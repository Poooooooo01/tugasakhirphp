<?php

include("../config/database.php");

if(isset($_POST['submit'])) {

    $id = $_POST['id'];
    $receipt_id = $_POST['receipt_id'];
    try {
        $sql = "DELETE FROM receipt_details WHERE id='$id'";
        $query = mysqli_query($db, $sql);

        if ($query) {
            header('Location: form.php?success=Data berhasil dihapus&id=' . $receipt_id);
        } else {
            header('Location: form.php?error=Data gagal dihapus&id=' . $receipt_id);
        }
    } catch(Exception $exception) {
        header('Location: form.php?error=' . $exception->getMessage() . "&id=" . $receipt_id);
    }
} else {
    die("akses dilarang...");
}