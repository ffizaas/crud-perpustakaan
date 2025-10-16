<?php
require_once 'config.php';

try {
    $stmt = $pdo->query("SELECT COUNT(*) FROM books");
    $count = $stmt->fetchColumn();
    echo "✓ Koneksi database BERHASIL!<br>";
    echo "Total buku: " . $count;
} catch(PDOException $e) {
    echo "✗ Koneksi database GAGAL: " . $e->getMessage();
}
?>