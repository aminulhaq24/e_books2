<?php
include('includes/connection.php');

$title  = $_POST['title'];
$type   = $_POST['type'];
$start  = $_POST['start_datetime'];
$end    = $_POST['end_datetime'];

$first  = $_POST['first_prize'];
$second = $_POST['second_prize'];
$third  = $_POST['third_prize'];

$desc   = $_POST['description'];

$sql = "INSERT INTO competitions 
(title, type, start_datetime, end_datetime, description, first_prize, second_prize, third_prize)
VALUES
('$title', '$type', '$start', '$end', '$desc', '$first', '$second', '$third')";

if(mysqli_query($con, $sql)){
    header("Location: competition_list.php?added=1");
} else {
    echo "Error: " . mysqli_error($con);
}
?>

