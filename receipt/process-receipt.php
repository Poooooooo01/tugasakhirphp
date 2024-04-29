<?php

include("../config/database.php");
session_start();
if(isset($_POST['submit'])) {

    $id = $_POST['id'];
    $customer_name = $_POST['customer_name'];
    $status = $_POST['status'];

    try {
        $sql = "";

        if ($id) {
            $sql = "update receipts set user_id='". $_SESSION['user_id'] ."', customer_name='$customer_name', status='$status' where id= $id";
        } else {
            $sql = "insert into receipts(customer_name, status, receipt_date, user_id) values ('$customer_name', '$status', now(), '". $_SESSION['user_id'] ."')";
        }

        $query = mysqli_query($db, $sql);
        if (!$id) {
            $id = mysqli_insert_id($db);
        }
        if ($query) {

            if($status == "Done") {
                header('Location: index.php?success=Transaksi selesai');
            } else {
                header('Location: form.php?success=Data berhasil dieksekusi'  . "&id=$id");
            }
        } else {
            header('Location: form.php?error=Data gagal dieksekusi' . "&id=$id");
        }
    } catch(Exception $exception) {
        header('Location: form.php?error=' . $exception->getMessage() . "&id=$id");
    }
} else {
    die("akses dilarang...");
}