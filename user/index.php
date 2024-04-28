<?php include("../layout/header.php"); 
$sql = "select * from users";
$query = mysqli_query($db, $sql);
?>
<br><br><br>

<div class="container">
<h1>Users</h1>
<?php
if(isset($_GET['error'])) {
    ?>
<div class="alert alert-danger">
    <?= $_GET['error']; ?>
</div>
<?php
}

if(isset($_GET['success'])) {
    ?>
<div class="alert alert-success">
    <?= $_GET['success']; ?>
</div>
<?php
}
?>

<a href="form.php" class="btn btn-primary">Add</a>

<table id="my-datatables" class="table  table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Username</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        while($user = mysqli_fetch_array($query)){
        ?>
        <tr>
            <td><?= $i; ?></td>
            <td><?= $user["name"]; ?></td>
            <td><?= $user["username"]; ?></td>
            <td>
                <div class="d-flex">
                    <a href="form.php?id=<?= $user["id"]; ?>" class="btn btn-sm btn-warning me-2">Edit</a>
            <form action="delete-process.php" method="post">
                            <input type="hidden" name="id" value="<?=  $user["id"]; ?>">
                            <button type="submit" name="submit"
                                onclick="return confirm('Anda yakin menghapus data ini?');"
                                class="btn btn-danger btn-sm">Delete</button>
                        </form>
            </td>
        </tr>
        <?php
        $i++;
        }?>
    </tbody>
</table>
</table>
</div>
<?php include("../layout/footer.php");
?>