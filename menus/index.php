<?php
include ("../layout/header.php");

// Query untuk mengambil data menu beserta nama kategorinya
$sql = "SELECT menus.*, categories.name AS category_name FROM menus LEFT JOIN categories ON menus.category_id = categories.id ORDER BY menus.name";
$query = mysqli_query($db, $sql);
?>
<h1 style="color:grey;" class="text-center">Menus List</h1>
<?php
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
  <a href="form.php" class="btn btn-info my-2" style="color: white;">Add</a>

  <table id="my-datatables" class="table  table-striped table-bordered">
    <thead>
      <tr>
        <th>No</th>
        <th>Name</th>
        <th>Category</th>
        <th>Note</th>
        <th>Price</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 1;
      while ($menus = mysqli_fetch_array($query)) {
        ?>
        <tr>
          <td><?= $i; ?></td>
          <td><?= $menus["name"]; ?></td>
          <td><?= $menus["category_name"]; ?></td>
          <!-- Menggunakan category_name yang telah diambil dari tabel categories -->
          <td><?= $menus["note"]; ?></td>
          <td><?= $menus["price"]; ?></td>
          <td><?= $menus["status"]; ?></td>
          <td>
            <div class="d-flex">
              <a href="form.php?id=<?= $menus["id"]; ?>" class="btn btn-sm btn-warning me-2">Edit</a>
              <form action="delete-process.php" method="post">
                <input type="hidden" name="id" value="<?= $menus["id"]; ?>">
                <button type="submit" name="delete" onclick="return confirm('Anda yakin menghapus data ini?');"
                  class="btn btn-danger btn-sm">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        <?php
        $i++;
      } ?>
    </tbody>
  </table>
</div>
<?php
include ("../layout/footer.php");
?>