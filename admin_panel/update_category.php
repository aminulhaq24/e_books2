<?php
include("includes/connection.php");

$id = $_POST['id'];
$name = $_POST['category_name'];

$sql = "UPDATE categories SET category_name='$name' WHERE id=$id";
mysqli_query($con, $sql);

header("Location: categories.php");
?>






