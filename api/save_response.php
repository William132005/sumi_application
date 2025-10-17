<?php
// Mengatur header untuk respons JSON
header('Content-Type: application/json');

// Memeriksa apakah request adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Hanya metode POST yang diizinkan']);
    exit;
}

// Mendapatkan data JSON dari request
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Validasi data
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Data tidak valid']);
    exit;
}

// Menambahkan timestamp
$data['timestamp'] = date('Y-m-d H:i:s');
$data['id'] = uniqid();

// Untuk Vercel, kita akan mengembalikan data langsung tanpa menyimpan ke file
// karena Vercel Functions bersifat stateless dan tidak bisa menulis ke filesystem secara permanen
echo json_encode([
    'success' => true, 
    'message' => 'Respons berhasil diterima',
    'data' => $data
]);
?>