// Konfirmasi Delete
function confirmDelete(event) {
    event.preventDefault();
    const form = event.target.closest('form');
    
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

// Konfirmasi Form Submit
function confirmSubmit(event) {
    event.preventDefault();
    const form = event.target;
    
    Swal.fire({
        title: 'Konfirmasi',
        text: "Apakah data yang dimasukkan sudah benar?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, simpan!',
        cancelButtonText: 'Periksa lagi'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
} 