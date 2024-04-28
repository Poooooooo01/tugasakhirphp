<?php

include("../config/database.php");

if(isset($_POST['delete'])) {

    $id = $_POST['id'];
    try {
        $sql = "DELETE FROM categories WHERE id='$id'";
        $query = mysqli_query($db, $sql);

        if ($query) {
            header('Location: index.php?success=Data berhasil dihapus');
        } else {
            header('Location: index.php?error=Data gagal dihapus');
        }
    } catch(Exception $exception) {
        header('Location: index.php?error=' . $exception->getMessage());
    }
} else{
    die("Akses dilarang..");
}
?>