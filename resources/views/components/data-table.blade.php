@props([
    'headers' => [],
    'rows' => [],
    'searchable' => true,
    'sortable' => true,
    'paginator' => null,
    'actions' => true,
])

<div class="card">
    <!-- Header with search and actions -->
    @if($searchable || $actions)
    <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        @if($searchable)
        <form method="GET" class="flex items-center gap-2 flex-1">
            <div class="relative flex-1 max-w-md">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search..."
                       class="form-input pl-10">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <button type="submit" class="btn-secondary">Search</button>
        </form>
        @endif

        <div class="flex items-center gap-2">
            {{ $actions ?? '' }}
        </div>
    </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    @foreach($headers as $header)
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            @if($sortable && isset($header['sortable']) && $header['sortable'])
                                <button class="flex items-center gap-1 hover:text-gray-700">
                                    {{ $header['label'] }}
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                </button>
                            @else
                                {{ $header['label'] }}
                            @endif
                        </th>
                    @endforeach
                    @if($actions !== false)
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($rows as $row)
                    <tr class="hover:bg-gray-50 transition-colors">
                        @foreach($headers as $header)
                            <td class="px-4 py-4 text-sm text-gray-900">
                                {{ $row[$header['key']] ?? '' }}
                            </td>
                        @endforeach
                        @if($actions !== false)
                            <td class="px-4 py-4 text-right">
                                {{ $row['actions'] ?? '' }}
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($headers) + ($actions !== false ? 1 : 0) }}" class="px-4 py-12 text-center">
                            <div class="empty-state">
                                <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <div class="empty-state-title">No data found</div>
                                <div class="empty-state-description">Get started by creating a new record.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($paginator && $paginator->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $paginator->links() }}
        </div>
    @endif
</div>
