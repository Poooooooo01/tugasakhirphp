<?php

include("../config/database.php");
session_start();
if(isset($_POST['submit'])) {

    $id = $_POST['modal_id'];
    $receipt_id = $_POST['modal_receipt_id'];
    $amount = $_POST['modal_amount'];
    $note = $_POST['modal_note'];
    $menu_id = $_POST['modal_menu_id'];

    $sql = "SELECT * FROM menus WHERE id=$menu_id";
    $result = mysqli_query($db, $sql);
    $menu = $result->num_rows > 0 ? mysqli_fetch_assoc($result) : null;

    $price = $menu['price'];
    try {
        $sql = "";

        if ($id) {
            $sql = "update receipt_details set menu_id='$menu_id', amount='$amount', note='$note' where id= $id";
        } else {
            $sql = "insert into receipt_details(receipt_id, menu_id, amount, price, note) values ('$receipt_id', '$menu_id', '$amount', '$price', '$note')";
        }

        $query = mysqli_query($db, $sql);
        if (!$id) {
            $id = mysqli_insert_id($db);
        }
        if ($query) {
            header('Location: form.php?success=Data berhasil dieksekusi'  . "&id=$receipt_id");
        } else {
            header('Location: form.php?error=Data gagal dieksekusi' . "&id=$receipt_id");
        }
    } catch(Exception $exception) {
        header('Location: form.php?error=' . $exception->getMessage() . "&id=$receipt_id");
    }
} else {
    die("akses dilarang...");
}