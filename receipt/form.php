<!-- form.php -->
<?php
include("../layout/header.php");
include("../config/database.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Jika ID ada, ambil data untuk edit, jika tidak, biarkan kosong untuk tambah
$receipt = null;
if ($id > 0) {
    $sql = "SELECT * FROM receipts WHERE id = $id";
    $result = mysqli_query($db, $sql);
    if ($result && $result->num_rows > 0) {
        $receipt = mysqli_fetch_assoc($result);
    }
}
?>
<h1 style="color:grey;" class="text-center"><?= $id ? "Edit Receipt" : "Add New Receipt"; ?></h1>

<div class="container">
    <form action="process-receipt.php" method="post">
        <?php if ($id > 0): ?>
            <input type="hidden" name="id" value="<?= $id; ?>">
        <?php endif; ?>

        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name:</label>
            <input type="text" class="form-control" name="customer_name" value="<?= isset($receipt['customer_name']) ? $receipt['customer_name'] : ''; ?>" required>
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" name="submit" class="btn btn-primary">Save</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<?php
include("../layout/footer.php");
