<?php

include("../config/database.php");

session_start();
if(isset($_SESSION['user_id'])){
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "select id, name from users where username='$username' and password='$password'";
    $result = mysqli_query($db, $sql);

    if($result->num_rows > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];

        header("Location: ../index.php");
    } else {
        header("Location: index.php?error=Username atau password anda salah. Silahkan coba lagi.");
    }
}