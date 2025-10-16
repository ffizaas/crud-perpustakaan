<?php
require_once 'config.php';

// Set header JSON
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'ID buku tidak ditemukan'
    ]);
    exit;
}

$id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->execute([$id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($book) {
        echo json_encode([
            'success' => true,
            'data' => $book
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Buku tidak ditemukan'
        ]);
    }
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
}
?>