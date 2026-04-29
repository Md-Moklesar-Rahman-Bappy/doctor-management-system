@props([
    'columns' => [],
    'rows' => [],
    'emptyMessage' => 'No data available.',
    'hover' => true,
    'striped' => false,
    'responsive' => true
])

<div class="{{ $responsive ? 'overflow-x-auto' : '' }}">
    <table class="min-w-full divide-y divide-secondary-200">
        @if(count($columns) > 0)
            <thead class="bg-secondary-50">
                <tr>
                    @foreach($columns as $column)
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            {{ is_array($column) ? ($column['label'] ?? $column['name']) : $column }}
                        </th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody class="bg-white divide-y divide-secondary-200 {{ $hover ? 'table-hover' : '' }} {{ $striped ? 'striped' : '' }}">
            @forelse($rows as $row)
                <tr>
                    {{ $row }}
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) }}" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-secondary-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-sm text-secondary-500">{{ $emptyMessage }}</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
