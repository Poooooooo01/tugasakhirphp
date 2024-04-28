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
<br><br><br>
<div class="container">
    <h2 style="color: grey;" class="text-center"><?= $id ? "EDIT" : "ADD"; ?> FORM MENUS</h2>

    <form action="post-process.php" method="POST">
        <input type="hidden" name="id" value="<?= $id; ?>">

        <!-- Input nama menu -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama:</label>
            <input type="text" class="form-control" name="name" value="<?= $menus ? $menus['name'] : ''; ?>" required>
        </div>

        <!-- Input kategori menggunakan dropdown -->
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori:</label>
            <select name="category_id" class="form-control" required>
                <?php
                foreach ($categories_list as $category) {
                    $selected = ($menus && $menus['category_id'] == $category['id']) ? 'selected' : '';
                    echo "<option value=\"{$category['id']}\" $selected>{$category['name']}</option>";
                }
                ?>
            </select>
        </div>

        <!-- Input untuk catatan menu -->
        <div class="mb-3">
            <label for="note" class="form-label">Catatan:</label>
            <input type="text" class="form-control" name="note" value="<?= $menus ? $menus['note'] : ''; ?>">
        </div>

        <!-- Input untuk harga menu -->
        <div class="mb-3">
            <label for="price" class="form-label">Harga:</label>
            <input type="number" step="0.01" class="form-control" name="price" value="<?= $menus ? $menus['price'] : ''; ?>" required>
        </div>

        <!-- Pilihan untuk status menu -->
        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select name="status" class="form-control" required>
                <option value="Aktif" <?= $menus && $menus['status'] == "Aktif" ? "selected" : ""; ?>>Aktif</option>
                <option value="Non-Aktif" <?= $menus && $menus['status'] == "Non-Aktif" ? "selected" : ""; ?>>Non-Aktif</option>
            </select>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php
include ("../layout/footer.php");
?>