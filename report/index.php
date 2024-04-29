<?php include("../layout/header.php");

$sql = "SELECT rcp.*, ifnull(sum(rcp_det.price * rcp_det.amount),0)  as total, users.name as user_name FROM receipts as rcp
left join receipt_details as rcp_det on rcp.id=rcp_det.receipt_id
inner join users on users.id = rcp.user_id
where rcp.status='Done' and date(receipt_date) = date(now())   group by rcp.id limit 5";

$query = mysqli_query($db, $sql);
?>

<h1 class="text-center">Today Report</h1>


<div class="table-responsive">
    <table class="table table-striped table-bordered" style="width:100%">

        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Status</th>
                <th scope="col">User</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
$total = 0;
while($menu = mysqli_fetch_array($query)) {
    ?>
            <tr>
                <td scope="row"><?= $i; ?></td>
                <td scope="row"><?= date("d/m/Y H:i:s", strtotime($menu["receipt_date"])); ?></td>
                <td scope="row"><?= $menu["customer_name"]; ?></td>
                <td scope="row" class="text-end"><?= number_format($menu["total"], 0, '.', '.'); ?></td>
                <td scope="row"><?= $menu["status"]; ?></td>
                <td scope="row"><?= $menu["user_name"]; ?></td>
            </tr>
            <?php
        $i++;
    $total += $menu["total"];
} ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-end"><b><?= number_format($total, 0, '.', '.'); ?></b></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

<?php include("../layout/footer.php");