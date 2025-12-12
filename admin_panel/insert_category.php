<?php
include('includes/connection.php');

if(isset($_POST['category_name'])){
    
    $name = mysqli_real_escape_string($con, $_POST['category_name']);

    $sql = "INSERT INTO categories (category_name) VALUES ('$name')";
    mysqli_query($con, $sql);

    header("Location: categories.php?added=1");
}
?>
