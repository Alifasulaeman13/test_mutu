@props([
    'columns' => [], // array: [ ['label'=>'No', 'field'=>'no'], ... ]
    'data' => [], // array data atau paginator
    'pagination' => null, // Laravel paginator
    'filter' => false, // tampilkan filter/cari
    'title' => null, // judul tabel
])

<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
    @if($title)
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fa fa-table"></i> {{ $title }}
            </h3>
        </div>
    @endif
    
    <div class="p-6">
        <div class="sm:flex sm:items-center sm:justify-between mb-6">
            <div class="flex items-center">
                <label class="flex items-center text-sm text-gray-600">
                    <span class="mr-2">Tampil</span>
                    <select class="form-select rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm"
                            onchange="this.form.submit()" 
                            name="per_page" 
                            form="filterForm">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span class="ml-2">data</span>
                </label>
            </div>
            
            @if($filter)
            <div class="mt-3 sm:mt-0">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari..." 
                           class="form-input pl-10 pr-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full sm:w-64 text-sm"
                           form="filterForm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ri-search-line text-gray-400"></i>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                @hasSection('head')
                    <thead class="bg-gray-50">
                        @yield('head')
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @yield('body')
                    </tbody>
                @elseif (isset($head) && isset($body))
                    <thead class="bg-gray-50">
                        {{ $head }}
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{ $body }}
                    </tbody>
                @else
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach($columns as $col)
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $col['label'] }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($data as $row)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                @foreach($columns as $col)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {!! $row[$col['field']] ?? '' !!}
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($columns) }}" class="px-6 py-4 text-center text-sm text-gray-500 bg-gray-50">
                                    <div class="flex flex-col items-center justify-center py-6">
                                        <i class="ri-inbox-line text-4xl text-gray-400 mb-2"></i>
                                        <p>Tidak ada data</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                @endif
            </table>
        </div>

        @if(($data instanceof \Illuminate\Pagination\LengthAwarePaginator && $data->count() > 0) || ($pagination && count($data) > 0))
            <div class="flex flex-col sm:flex-row items-center justify-between mt-6 space-y-3 sm:space-y-0">
                <div class="text-sm text-gray-600">
                    @if($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        Menampilkan {{ $data->firstItem() }} s/d {{ $data->lastItem() }} 
                        dari {{ $data->total() }} data
                    @elseif($pagination)
                        Menampilkan {{ $pagination->firstItem() }} s/d {{ $pagination->lastItem() }} 
                        dari {{ $pagination->total() }} data
                    @endif
                </div>
                <div>
                    @if($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        {{ $data->links() }}
                    @elseif($pagination)
                        {{ $pagination->links() }}
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<form id="filterForm" method="GET"></form> 