<?php
session_start();
include('includes/connection.php');
if(isset($_POST['login'])){
$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
$result = mysqli_query($con, $query);


if(mysqli_num_rows($result) == 1){

    $row = mysqli_fetch_assoc($result);

    // Check password
    if(password_verify($password, $row['password'])){


        // Check role (only admin or dealer allowed)
        if($row['role'] == 'admin' || $row['role'] == 'dealer'){

            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_role'] = $row['role'];
            $_SESSION['admin_name'] = $row['name'];

            header("Location: index.php");
            exit;

        } else {
            echo "<script>alert('Access Denied! You are not Admin/Dealer'); window.location='login.php';</script>";
        }

    } else {
        echo "<script>alert('Wrong password'); window.location='login.php';</script>";
    }

} else {
    echo "<script>alert('Email not found'); window.location='login.php';</script>";
}
}
?>
