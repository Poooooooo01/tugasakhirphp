<?php include("../layout/header.php");

$id = isset($_GET['id']) ? $_GET['id'] : 0; 

$sql = "select * from users where id=$id";
$result = mysqli_query($db, $sql);
$user = $result->num_rows > 0 ? mysqli_fetch_assoc($result) : null;
?>

<h2 class='my-3'><?= $id ? "Edit" : "Add"; ?> User</h2>
<br><br><br>
<div class="container">
    <h2>Form add</h2>
    <form action="post-process.php" method="POST">
    <div class="col-md-6">
        <input type="hidden" name="id" value="<?= $id ; ?>">
    <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" name="name" value="<?= $user ? $user['name'] : ''; ?>" required>
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" value="<?= $user ? $user['username'] : ''; ?>" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <?php
                            if(isset($_GET['error'])) {
                                ?>
                        <div class="alert alert-danger">
                            <?= $_GET['error']; ?>
                        </div>
                        <?php
                            }
            ?>
            <button type="submit" name="submit" class="btn btn-primary btn-block">Simpan</button>
          </form>
          </div>
                        </div>

<?php include("../layout/footer.php")?>
