<?php include("../layout/header.php");
$id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT * FROM receipts WHERE id=$id";
$result = mysqli_query($db, $sql);
$receipt = $result->num_rows > 0 ? mysqli_fetch_assoc($result) : null;


$sql = "SELECT rcp_det.*, (rcp_det.price * rcp_det.amount) as subtotal, menus.name as menu_name, cat.name as category_name FROM receipt_details as rcp_det inner join menus on rcp_det.menu_id=menus.id inner join categories as cat on menus.category_id = cat.id WHERE receipt_id=$id";
$receipt_details = mysqli_query($db, $sql);

$sql = "SELECT * FROM menus";
$menus = mysqli_query($db, $sql);

?>

<h1 class="mb-5"><?= $id ? "Update" : "Add"; ?> Receipt</h1>
<?php
    if(isset($_GET["error"])) :  ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong><?= $_GET["error"]; ?></strong>
</div>
<?php endif;
if(isset($_GET["success"])) :
    ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong><?= $_GET["success"]; ?></strong>
</div>
<?php endif;?>

<form method="post" action="process-receipt.php">
    <div class="row">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="customer_name" class="form-label">Nama</label>
                <input type="text" class="form-control" name="customer_name"
                    value="<?= $receipt ? $receipt['customer_name'] : "" ; ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="Entry" <?= $receipt && $receipt['status'] == "Entry" ? "selected" : "" ; ?>>Entry
                    </option>
                    <?php if($receipt && $receipt_details->num_rows > 0) : ?>
                    <option value="Done" <?= $receipt && $receipt['status'] == "Done" ? "selected" : "" ; ?>>Done
                    </option>
                    <?php endif; ?>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>

<?php if($receipt) : ?>
<hr />
<h2>Details</h2>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#detailFormModal">
    Add
</button>


<div class="table-responsive">
    <table class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <th scope="col">Note</th>
                <th scope="col">Price</th>
                <th scope="col">Amount</th>
                <th scope="col">Subtotal</th>
                <th scope="col" width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
    $total = 0;
    while ($receipt_detail = mysqli_fetch_array($receipt_details)) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $receipt_detail['menu_name']; ?></td>
                <td><?= $receipt_detail['category_name']; ?></td>
                <td><?= $receipt_detail['note']; ?></td>
                <td class="text-end"><?= number_format($receipt_detail['price'], 0, '.', '.'); ?></td>
                <td class="text-end"><?= number_format($receipt_detail['amount'], 0, '.', '.'); ?></td>
                <td class="text-end"><?= number_format($receipt_detail['subtotal'], 0, '.', '.'); ?></td>
                <td>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary me-1 btn-sm" data-bs-toggle="modal"
                            onclick="editModalShow('<?= $receipt_detail['id']; ?>','<?= $receipt_detail['menu_id']; ?>','<?= $receipt_detail['note']; ?>','<?= $receipt_detail['amount']; ?>')"
                            data-bs-target="#detailFormModal">
                            Edit
                        </button>
                        <form action="detail-delete-process.php" method="post">
                            <input type="hidden" name="id" value="<?=  $receipt_detail["id"]; ?>">
                            <input type="hidden" name="receipt_id" value="<?= $id; ?>">
                            <button type="submit" name="submit"
                                onclick="return confirm('Anda yakin menghapus data ini?');"
                                class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php
            $i++;
        $total += $receipt_detail['subtotal'];
    }
    ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-end"><b><?= number_format($total, 0, '.', '.'); ?></b></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

<?php include("modal-form.php"); ?>

<?php endif; ?>


<?php include("../layout/footer.php"); ?>