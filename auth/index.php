<?php

session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h3>Login RestoranQ</h3>
                    </div>
                    <?php
                    if (isset($_GET['error'])) {
                        ?>
                        <div class="alert alert-danger">
                            <?= $_GET['error']; ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="card-body">
                        <form action="login-process.php" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>