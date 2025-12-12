<?php
include("includes/connection.php");

$id     = intval($_GET['id']);
$status = $_GET['status'];

$allowed = ['received','shortlisted','winner','rejected'];

if(!in_array($status, $allowed)){
    die("Invalid status!");
}

$q = "UPDATE competition_submissions SET status = '$status' WHERE id = $id";
mysqli_query($con, $q);

header("Location: submissions_list.php");
exit;
?>
