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

// File untuk menyimpan respons
$file = 'responses.json';

// Membaca data yang sudah ada
$responses = [];
if (file_exists($file)) {
    $file_content = file_get_contents($file);
    if (!empty($file_content)) {
        $responses = json_decode($file_content, true);
        if (!is_array($responses)) {
            $responses = [];
        }
    }
}

// Menambahkan respons baru
$responses[] = $data;

// Menyimpan kembali ke file
if (file_put_contents($file, json_encode($responses, JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true, 'message' => 'Respons berhasil disimpan']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan respons']);
}
?>