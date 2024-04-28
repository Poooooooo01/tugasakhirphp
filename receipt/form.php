<?php
include("../layout/header.php");
include("../config/database.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$receipt = null;
if ($id > 0) {
    $sql = "SELECT * FROM receipts WHERE id = $id";
    $result = mysqli_query($db, $sql);
    if ($result && $result->num_rows > 0) {
        $receipt = mysqli_fetch_assoc($result);
    }
}

$user_query = mysqli_query($db, "SELECT id, name FROM users");
$users = mysqli_fetch_all($user_query, MYSQLI_ASSOC);
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

        <div class="mb-3">
            <label for="receipt_date" class="form-label">Receipt Date:</label>
            <input type="date" class="form-control" name="receipt_date" value="<?= isset($receipt['receipt_date']) ? $receipt['receipt_date'] : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">User:</label>
            <select name="user_id" class="form-control" required>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id']; ?>" <?= $receipt && $receipt['user_id'] == $user['id'] ? 'selected' : ''; ?>><?= $user['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select name="status" class="form-control" required>
                <option value="Done" <?= isset($receipt['status']) && $receipt['status'] == "Done" ? 'selected' : ''; ?>>Done</option>
            </select>
        </div>

        <!-- Field untuk Amount -->
        <div class="mb-3">
            <label for="amount" class="form-label">Amount:</label>
            <input type="number" step="1" class="form-control" name="amount" value="<?= isset($receipt['amount']) ? $receipt['amount'] : '1'; ?>" required>
        </div>

        <!-- Field untuk Price -->
        <div class="mb-3">
            <label for="price" class="form-label">Price:</label>
            <input type="number" step="0.01" class="form-control" name="price" value="<?= isset($receipt['price']) ? $receipt['price'] : '0'; ?>" required>
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" name="submit" class="btn btn-primary">Save</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<?php
include("../layout/footer.php");
