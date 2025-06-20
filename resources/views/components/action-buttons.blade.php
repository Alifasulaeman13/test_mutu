@props(['editUrl', 'deleteUrl', 'confirm' => 'Apakah Anda yakin?'])

<div class="flex items-center space-x-1">
    <a href="{{ $editUrl }}" 
       class="inline-flex items-center justify-center w-8 h-8 text-yellow-700 bg-yellow-100 rounded-lg hover:bg-yellow-200 focus:ring-2 focus:ring-yellow-300 focus:ring-offset-1 transition-colors duration-150"
       title="Edit Data">
        <i class="ri-edit-line text-lg"></i>
    </a>
    
    <form action="{{ $deleteUrl }}" method="POST" class="inline-block">
        @csrf
        @method('DELETE')
        <button type="button" 
                onclick="if(confirm('{{ $confirm }}')) this.closest('form').submit()"
                class="inline-flex items-center justify-center w-8 h-8 text-red-700 bg-red-100 rounded-lg hover:bg-red-200 focus:ring-2 focus:ring-red-300 focus:ring-offset-1 transition-colors duration-150"
                title="Hapus Data">
            <i class="ri-delete-bin-line text-lg"></i>
        </button>
    </form>
</div> 