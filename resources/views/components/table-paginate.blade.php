@props([
    'columns' => [], // array: [ ['label'=>'No', 'field'=>'no'], ... ]
    'data' => [], // array data
    'pagination' => null, // Laravel paginator
    'filter' => false, // tampilkan filter/cari
    'title' => null, // judul tabel
])

<div class="card" style="border:1px solid #eee; border-radius:6px; margin-bottom:1rem;">
    @if($title)
        <div style="padding:10px 16px; border-bottom:1px solid #eee; font-weight:bold; color:#5b2be7;">
            <i class="fa fa-table"></i> {{ $title }}
        </div>
    @endif
    
    <div style="padding:12px 16px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
            <div>
                <label>Tampil
                    <select style="padding:2px 8px; border-radius:4px; border:1px solid #ccc;" 
                            onchange="this.form.submit()" 
                            name="per_page" 
                            form="filterForm">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    data
                </label>
            </div>
            @if($filter)
            <div>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari..." 
                       style="padding:4px 8px; border-radius:4px; border:1px solid #ccc;"
                       form="filterForm">
            </div>
            @endif
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead style="background:#f8f8f8;">
                    <tr>
                        @foreach($columns as $col)
                            <th style="padding:8px; border-bottom:1px solid #eee; text-align:left; font-weight:500;">
                                {{ $col['label'] }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                        <tr>
                            @foreach($columns as $col)
                                <td style="padding:8px; border-bottom:1px solid #f3f3f3;">
                                    {!! $row[$col['field']] ?? '' !!}
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) }}" style="text-align:center; padding:16px; color:#888;">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pagination && count($data) > 0)
            <div style="display:flex; align-items:center; justify-content:space-between; margin-top:1rem;">
                <div style="color:#666;">
                    Menampilkan {{ $pagination->firstItem() }} s/d {{ $pagination->lastItem() }} 
                    dari {{ $pagination->total() }} data
                </div>
                <div>
                    {{ $pagination->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<form id="filterForm" method="GET"></form> 