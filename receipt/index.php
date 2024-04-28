<?php
include ("../layout/header.php");

// Modifikasi SQL untuk mengganti 'done' dengan 'entry' pada saat pengambilan data
$sql = "
    SELECT r.id, r.receipt_date,
           CASE 
               WHEN r.status = 'done' THEN 'Entry'
               ELSE r.status
           END AS status,
           SUM(rd.amount * rd.price) AS total_price,
           r.customer_name,
           u.name AS user_name
    FROM receipts r
    LEFT JOIN receipt_details rd ON r.id = rd.receipt_id
    LEFT JOIN users u ON r.user_id = u.id 
    GROUP BY r.id
    ORDER BY r.receipt_date";

$query = mysqli_query($db, $sql);
?>
<h1 style="color:grey;" class="text-center">Receipt List</h1>
<?php
// Pemberitahuan kesalahan atau keberhasilan
if (isset($_GET['error'])) {
    ?>
    <div class="alert alert-danger">
        <?= $_GET['error']; ?>
    </div>
    <?php
}
if (isset($_GET['success'])) {
    ?>
    <div class="alert alert-success">
        <?= $_GET['success']; ?>
    </div>
    <?php
}
?>

<div class="container">
    <a href="form.php" class="btn btn-info my-2" style="color:white;">Add</a>

    <!-- Tambahkan field di tabel -->
    <table id="my-datatables" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>User Name</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        while ($receipt = mysqli_fetch_array($query)) {
            ?>
            <tr>
                <td><?= $receipt["id"]; ?></td>
                <td><?= $receipt["receipt_date"]; ?></td>
                <td><?= $receipt["status"]; ?></td>
                <td><?= $receipt["customer_name"]; ?></td>
                <td><?= $receipt["user_name"]; ?></td>
                <td><?= number_format($receipt["total_price"], 2); ?></td>
                <td>
                    <div class="d-flex">
                        <a href="form.php?id=<?= $receipt["id"]; ?>" class="btn btn-sm btn-warning me-2">Edit</a>
                        <form action="delete-process.php" method="post">
                            <input type="hidden" name="id" value="<?= $receipt["id"]; ?>">
                            <button type="submit" name="delete"
                                    onclick="return confirm('Anda yakin menghapus data ini?');"
                                    class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php
        }?>
        
        </tbody>
    </table>
</div>

<?php
include ("../layout/footer.php");
?>
