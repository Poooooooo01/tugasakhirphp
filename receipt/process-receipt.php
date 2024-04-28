<?php
include("../config/database.php"); // Inklusi koneksi database

session_start(); // Mulai sesi

// Pastikan koneksi database valid
if (!isset($db) or $db->connect_error) {
    die("Koneksi database tidak tersedia.");
}

if (isset($_POST['submit'])) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $customer_name = isset($_POST['customer_name']) ? mysqli_real_escape_string($db, $_POST['customer_name']) : '';
    $receipt_date = date('Y-m-d H:i:s'); // Tambahkan waktu
    $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

    try {
        if ($id > 0) {
            // Jika ID ada, lakukan pembaruan
            $stmt = $db->prepare("UPDATE receipts SET customer_name = ?, receipt_date = ?, user_id = ? WHERE id = ?");
            $stmt->bind_param("sssi", $customer_name, $receipt_date, $user_id, $id);
        } else {
            // Jika ID tidak ada, tambahkan data baru
            $stmt = $db->prepare("INSERT INTO receipts (customer_name, receipt_date, user_id) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $customer_name, $receipt_date, $user_id);

            $stmt->execute(); // Jalankan SQL
            $receipt_id = $stmt->insert_id;

            // Mengarahkan ke form dengan ID yang baru
            header("Location: form.php?id=$receipt_id");
            exit(); // Keluar setelah arahan
        }

        $stmt->execute(); // Jalankan perintah SQL
        header("Location: index.php?success=Data berhasil disimpan");
        exit(); // Keluar setelah arahan
    } catch (Exception $e) {
        header("Location: index.php?error=" . $e->getMessage());
        exit(); // Keluar setelah arahan
    }
} else {
    // Jika tidak ada POST data, arahkan ke index
    header("Location: index.php?error=Invalid access");
    exit(); // Keluar setelah arahan
}
?>
