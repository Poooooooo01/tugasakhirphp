<?php
include ("../layout/header.php");

$id = isset($_GET['id'])? $_GET['id']: 0;

$sql = "SELECT * FROM categories WHERE id=$id";
$result = mysqli_query($db, $sql);
$categories = $result->num_rows > 0 ? mysqli_fetch_assoc($result): null;
?>
<br><br><br>
<div class="container">
<h2 style="color: grey;" class="text-center"><?= $id ? "EDIT" : "ADD"; ?> FORM NEW CATEGORIES</h2>

    <form action="post-process.php" method="POST">
        <div class="row">
            <div class="col-md-6">
                <input type="hidden" name="id" value="<?= $id ; ?>">
            <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" name="name" value="<?= $categories? $categories['name']: '' ; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">Note:</label>
                    <input type="text" class="form-control" name="note" value="<?= $categories? $categories['note']: '' ; ?>">
                </div>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php" type="submit" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
</div>
                </form>
  <?php
include ("../layout/footer.php");
?>