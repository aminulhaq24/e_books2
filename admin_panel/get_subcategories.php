<?php
include("includes/connection.php");

$category_id = intval($_GET['category_id'] ?? 0);

$sql = "SELECT * FROM subcategories WHERE category_id = $category_id ORDER BY subcategory_name";
$result = mysqli_query($con, $sql);

$options = '<option value="">Select Subcategory</option>';
while($book = mysqli_fetch_assoc($result)) {
    $options .= "<option value='{$book['id']}'>{$book['subcategory_name']}</option>";
}

echo $options;
?>