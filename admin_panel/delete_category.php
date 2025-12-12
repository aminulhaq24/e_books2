<?php
include('includes/connection.php');


    $id = $_GET['id'];

$sql = "delete from categories where id = $id";
$run = mysqli_query($con, $sql);

header("Location: categories.php");
?>