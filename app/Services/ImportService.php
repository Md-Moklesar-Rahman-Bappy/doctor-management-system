<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportService
{
    public function importFromFile(Request $request, Model $model, array $columnMap, string $identifier = 'file'): int
    {
        $request->validate([
            $identifier => 'required|file|mimes:csv,xlsx,xls,txt|max:51200',
        ]);

        $file = $request->file($identifier);
        $path = $file->getRealPath();
        $extension = $file->getClientOriginalExtension();

        $rows = $this->parseFile($path, $extension);

        if (empty($rows)) {
            return 0;
        }

        $rows = $this->removeHeaderRow($rows, $columnMap);

        return $this->batchInsert($model, $rows, $columnMap);
    }

    private function parseFile(string $path, string $extension): array
    {
        $rows = [];

        if (in_array($extension, ['xlsx', 'xls'])) {
            $spreadsheet = IOFactory::load($path);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
        } else {
            if (($handle = fopen($path, 'r')) !== false) {
                $delimiters = [',', ';', "\t", '|'];
                $firstLine = fgets($handle);
                rewind($handle);

                $delimiter = ',';
                if ($firstLine) {
                    $maxCount = 0;
                    foreach ($delimiters as $delim) {
                        $count = count(str_getcsv($firstLine, $delim));
                        if ($count > $maxCount) {
                            $maxCount = $count;
                            $delimiter = $delim;
                        }
                    }
                }

                $bom = fread($handle, 3);
                if ($bom !== "\xEF\xBB\xBF") {
                    rewind($handle);
                }

                while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
                    $rows[] = $data;
                }
                fclose($handle);
            }
        }

        return $rows;
    }

    private function removeHeaderRow(array $rows, array $columnMap): array
    {
        if (count($rows) > 0) {
            $firstRow = $rows[0];
            $headerIndicators = array_values($columnMap);

            $isHeader = false;
            foreach ($headerIndicators as $indicator) {
                foreach ($firstRow as $cell) {
                    if (is_string($cell) && stripos(trim($cell), $indicator) !== false) {
                        $isHeader = true;
                        break 2;
                    }
                }
            }

            if ($isHeader) {
                array_shift($rows);
            }
        }

        return $rows;
    }

    private function batchInsert(Model $model, array $rows, array $columnMap): int
    {
        $batchSize = 500;
        $batches = array_chunk($rows, $batchSize);
        $totalImported = 0;

        foreach ($batches as $batch) {
            $records = [];
            foreach ($batch as $data) {
                if (empty($data) || ! is_array($data)) {
                    continue;
                }

                $record = [];
                foreach ($columnMap as $dbColumn => $csvIndex) {
                    if (is_string($csvIndex) && isset($data[$csvIndex])) {
                        $record[$dbColumn] = trim($data[$csvIndex] ?? '');
                    } elseif (is_numeric($csvIndex) && isset($data[$csvIndex])) {
                        $record[$dbColumn] = trim($data[$csvIndex] ?? '');
                    }
                }

                if (! empty($record)) {
                    $record['created_at'] = now();
                    $record['updated_at'] = now();
                    $records[] = $record;
                }
            }

            if (! empty($records)) {
                try {
                    $model->insert($records);
                    $totalImported += count($records);
                } catch (\Exception $e) {
                    foreach ($records as $record) {
                        try {
                            $model->create($record);
                            $totalImported++;
                        } catch (\Exception $e2) {
                            // Skip failed record
                        }
                    }
                }
            }
        }

        return $totalImported;
    }
}
