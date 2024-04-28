<?php
include("../config/database.php");

if (isset($_POST['submit'])) {
    $id = (int)$_POST['id'];
    $customer_name = mysqli_real_escape_string($db, $_POST['customer_name']);
    $receipt_date = mysqli_real_escape_string($db, $_POST['receipt_date']);
    $user_id = (int)$_POST['user_id'];
    $status = mysqli_real_escape_string($db, $_POST['status']);
    $amount = (float)$_POST['amount'];
    $price = (float)$_POST['price'];
    $total_price = $amount * $price;

    try {
        if ($id > 0) {
            // Update jika ID ada
            $stmt = $db->prepare("UPDATE receipts SET customer_name = ?, receipt_date = ?, user_id = ?, status = ?, total_price = ? WHERE id = ?");
            $stmt->bind_param("sssiid", $customer_name, $receipt_date, $user_id, $status, total_price, $id);

            $stmt2 = $db->prepare("UPDATE receipt_details SET amount = ?, price = ? WHERE receipt_id = ?");
            $stmt2->bind_param("idi", $amount, $price, $id);

        } else {
            // Insert jika ID tidak ada
            $stmt = $db->prepare("INSERT INTO receipts (customer_name, receipt_date, user_id, status, amount, price) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssif", $customer_name, $receipt_date, $user_id, $status, $amount, $price);

            $stmt->execute(); // Jalankan statement pertama

            $receipt_id = $stmt->insert_id; // Dapatkan ID terbaru

            $stmt2 = $db->prepare("INSERT INTO receipt_details (receipt_id, amount, price) VALUES (?, ?, ?)");
            $stmt2->bind_param("iid", $receipt_id, $amount, $price);
        }

        $stmt->execute();
        $stmt2->execute();

        header("Location: index.php?success=Data berhasil disimpan");
    } catch (Exception $e) {
        header("Location: index.php?error=" . $e->getMessage());
    }
} else {
    header("Location: index.php?error=Invalid access");
}
