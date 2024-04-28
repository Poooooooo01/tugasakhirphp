<?php
include("../config/database.php");

if (isset($_POST['delete'])) {

    $id = $_POST['id'];
    
    // Mencoba menghapus data dengan prepared statements
    try {
        $stmt = $db->prepare("DELETE FROM menus WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header('Location: index.php?success=Data berhasil dihapus');
        } else {
            header('Location: index.php?error=Data gagal dihapus');
        }
    } catch (Exception $exception) {
        header('Location: index.php?error=' . $exception->getMessage());
    }
} else {
    die("Akses dilarang..");
}
?>
