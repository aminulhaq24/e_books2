<?php
include("includes/connection.php");

$id = $_GET['id'];
$competition_id = $_GET['competition_id'];

mysqli_query($con, "DELETE FROM competition_rules WHERE id = $id");

header("Location: manage_rules.php?competition_id=$competition_id");
?>