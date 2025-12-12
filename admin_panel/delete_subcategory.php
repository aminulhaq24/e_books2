<?php
include("includes/connection.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM subcategories WHERE id='$id'";

    if(mysqli_query($con, $sql)){
        header("Location: categories.php?success=subcategory_deleted");
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
