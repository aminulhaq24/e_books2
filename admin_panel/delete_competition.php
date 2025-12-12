<?php
include('includes/connection.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid competition ID");
}

$competition_id = intval($_GET['id']);


// -------------------------------------------
// (1) Pehle check karo competition exist karta hai ya nahi
// -------------------------------------------
$check_sql = "SELECT * FROM competitions WHERE id = $competition_id";
$check_res = mysqli_query($con, $check_sql);

if (mysqli_num_rows($check_res) == 0) {
    die("Competition not found");
}


// -------------------------------------------
// (2) Agar submissions table me foreign key hai to delete submissions first
// -------------------------------------------
$del_sub_sql = "DELETE FROM competition_submissions WHERE competition_id = $competition_id";
mysqli_query($con, $del_sub_sql);


// -------------------------------------------
// (3) Ab main competition delete karein
// -------------------------------------------
$del_sql = "DELETE FROM competitions WHERE id = $competition_id";
if (mysqli_query($con, $del_sql)) {
    header("Location: competition_list.php?msg=deleted");
    exit;
} else {
    echo "Error deleting competition: " . mysqli_error($con);
}
?>
