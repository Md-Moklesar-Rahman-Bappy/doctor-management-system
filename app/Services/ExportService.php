<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportService
{
    public function exportToCsv(Builder $query, array $columns, string $filename): StreamedResponse
    {
        $items = $query->orderBy('id', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        return response()->stream(function () use ($items, $columns) {
            $handle = fopen('php://output', 'w');

            // Write header row
            fputcsv($handle, array_keys($columns));

            // Write data rows
            foreach ($items as $item) {
                $row = [];
                foreach ($columns as $column) {
                    $row[] = $item->{$column} ?? '';
                }
                fputcsv($handle, $row);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function exportToCsvWithCallback(Builder $query, array $headers, callable $mapRow, string $filename): StreamedResponse
    {
        $items = $query->orderBy('id', 'desc')->get();

        $csvHeaders = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        return response()->stream(function () use ($items, $headers, $mapRow) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);

            foreach ($items as $item) {
                fputcsv($handle, $mapRow($item));
            }

            fclose($handle);
        }, 200, $csvHeaders);
    }
}
