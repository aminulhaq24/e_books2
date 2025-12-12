<?php
include('includes/connection.php');

if(isset($_POST['subcategory_name']) && isset($_POST['category_id'])) {
    $name = mysqli_real_escape_string($con, $_POST['subcategory_name']);
    $cat_id = intval($_POST['category_id']);

    // Check if subcategory already exists under this category
    $check_sql = "SELECT * FROM subcategories WHERE subcategory_name='$name' AND category_id=$cat_id";
    
    $check_res = mysqli_query($con, $check_sql);

    if(mysqli_num_rows($check_res) > 0) {
        echo "<script>alert('Subcategory already exists!'); window.location='categories.php';</script>";

    } else {
        $insert_sql = "INSERT INTO subcategories (subcategory_name, category_id) VALUES ('$name', $cat_id)";

        if(mysqli_query($con, $insert_sql)) {
            echo "<script>alert('Subcategory added successfully'); window.location='categories.php';</script>";
        } else {
            echo "<script>alert('Error adding subcategory'); window.location='categories.php';</script>";
        }
    }
} else {
    header("Location: categories.php");
}
?>
