<?php
// PERBAIKAN: Path file yang benar
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Cek apakah ini action delete
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $bookId = $_POST['bookId'];
        
        try {
            $stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
            $stmt->execute([$bookId]);
            
            header("Location: index.php?success=" . urlencode("Buku berhasil dihapus!"));
            exit;
        } catch(PDOException $e) {
            header("Location: index.php?error=" . urlencode("Terjadi kesalahan: " . $e->getMessage()));
            exit;
        }
    }
    
    // Proses tambah/edit buku
    $bookId = $_POST['bookId'] ?? '';
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'] ?? '';
    $tahun_terbit = $_POST['tahun_terbit'] ?? null;
    $isbn = $_POST['isbn'] ?? '';
    $kategori = $_POST['kategori'];
    $jumlah_halaman = $_POST['jumlah_halaman'] ?? null;
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'] ?? '';

    try {
        if (empty($bookId)) {
            // Tambah buku baru
            $stmt = $pdo->prepare("INSERT INTO books (judul, pengarang, penerbit, tahun_terbit, isbn, kategori, jumlah_halaman, stok, deskripsi) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$judul, $pengarang, $penerbit, $tahun_terbit, $isbn, $kategori, $jumlah_halaman, $stok, $deskripsi]);
            $message = "Buku berhasil ditambahkan!";
        } else {
            // Update buku
            $stmt = $pdo->prepare("UPDATE books SET judul=?, pengarang=?, penerbit=?, tahun_terbit=?, isbn=?, kategori=?, jumlah_halaman=?, stok=?, deskripsi=? 
                                   WHERE id=?");
            $stmt->execute([$judul, $pengarang, $penerbit, $tahun_terbit, $isbn, $kategori, $jumlah_halaman, $stok, $deskripsi, $bookId]);
            $message = "Buku berhasil diperbarui!";
        }
        
        header("Location: index.php?success=" . urlencode($message));
        exit;
        
    } catch(PDOException $e) {
        header("Location: index.php?error=" . urlencode("Terjadi kesalahan: " . $e->getMessage()));
        exit;
    }
}
?>