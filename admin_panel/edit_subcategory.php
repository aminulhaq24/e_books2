<?php
include("includes/connection.php");

if(isset($_POST['update'])){
    $sub_id = $_POST['sub_id'];
    $category_id = $_POST['category_id'];
    $subcategory_name = $_POST['subcategory_name'];

    $sql = "UPDATE subcategories 
            SET category_id='$category_id', subcategory_name='$subcategory_name'
            WHERE id='$sub_id'";

    if(mysqli_query($con, $sql)){
        header("Location: categories.php?success=subcategory_updated");
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
