@props([
    'columns' => [],
    'rows' => [],
    'emptyMessage' => 'No data available.',
    'hover' => true,
    'striped' => false,
    'responsive' => true
])

<div class="{{ $responsive ? 'table-responsive' : '' }}">
    <table class="table {{ $hover ? 'table-hover' : '' }} {{ $striped ? 'table-striped' : '' }}">
        @if(count($columns) > 0)
            <thead class="table-light">
                <tr>
                    @foreach($columns as $column)
                        <th class="text-uppercase small fw-semibold text-muted">
                            {{ is_array($column) ? ($column['label'] ?? $column['name']) : $column }}
                        </th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody>
            @forelse($rows as $row)
                <tr>
                    {{ $row }}
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) }}" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-inbox text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="text-muted mb-0">{{ $emptyMessage }}</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
