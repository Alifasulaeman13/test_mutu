@props(['editUrl', 'deleteUrl'])

<div class="action-buttons">
    <a href="{{ $editUrl }}" class="btn btn-sm btn-warning" title="Edit">
        <i class="ri-edit-line"></i>
    </a>
    <form action="{{ $deleteUrl }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-danger" title="Hapus" onclick="confirmDelete(event)">
            <i class="ri-delete-bin-line"></i>
        </button>
    </form>
</div> 