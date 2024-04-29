<?php
include ("../layout/header.php");

$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Mendapatkan daftar kategori dari tabel categories
$sql = "SELECT id, name FROM categories";
$categories_result = mysqli_query($db, $sql);
$categories_list = mysqli_fetch_all($categories_result, MYSQLI_ASSOC);

// Mendapatkan data dari tabel menus jika id disediakan
$sql = "SELECT * FROM menus WHERE id = $id";
$result = mysqli_query($db, $sql);
$menus = $result->num_rows > 0 ? mysqli_fetch_assoc($result) : null;
?>
<div class="container">
    <h2 style="color: grey;" class="text-center"><?= $id ? "EDIT" : "ADD"; ?> FORM MENUS</h2>

    <form action="receipt-process.php" method="POST">
        <input type="hidden" name="id" value="<?= $id; ?>">

        <!-- Input nama menu -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama:</label>
            <input type="text" class="form-control" name="name" value="<?= $menus ? $menus['name'] : ''; ?>" required>
        </div>
        <!-- Pilihan untuk status menu -->
        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select name="status" class="form-control" required>
                <option value="Aktif" <?= $receipt && $receipt['status'] == "Entry" ? "selected" : ""; ?>>Entry</option>>
            </select>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php
include ("../layout/footer.php");
?>