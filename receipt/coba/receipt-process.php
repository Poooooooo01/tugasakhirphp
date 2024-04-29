<?php

include("../config/database.php");

$sql = "SELECT id, name FROM categories";
$result = mysqli_query($db, $sql);
$categories_list = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $categories = $_POST['category_id'];
    $note = $_POST['note'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    try {
        if ($id) {
            $sql = "UPDATE menus SET name='$name', category_id='$categories', note='$note', note='$note',
                price='$price', status='$status' WHERE id=$id";
        } else {
            $sql = "INSERT INTO menus(name, category_id, note, price, status) VALUES ('$name', '$categories', 
            '$note', '$price', '$status')";
        }
        $result = mysqli_query($db, $sql);

        if ($result) {
            header("Location: index.php?success=Data tersimpan");
        } else {
            header("Location: index.php?error=Data tidak tersimpan");
        }
    } catch (Exception $exception) {
        header('Location: index.php?error=' . $exception->getMessage());
    }
}