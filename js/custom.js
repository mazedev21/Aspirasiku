document.getElementById("hapusSemuaAspirasi").addEventListener("click", function() {
    Swal.fire({
        title: "Yakin ingin menghapus semua aspirasi?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            // Kirim permintaan ke server melalui AJAX
            fetch("hapus_semua_aspirasi.php", {
                method: "POST"
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Terhapus!", "Semua aspirasi telah dihapus.", "success")
                    .then(() => location.reload()); // Refresh halaman setelah sukses
                } else {
                    Swal.fire("Gagal!", "Terjadi kesalahan saat menghapus data.", "error");
                }
            })
            .catch(error => {
                Swal.fire("Error!", "Terjadi kesalahan koneksi.", "error");
            });
        }
    });
});
