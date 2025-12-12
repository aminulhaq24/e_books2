<?php
include('includes/connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Fetch Form Data
    $id             = intval($_POST['id']);
    $title          = mysqli_real_escape_string($con, $_POST['title']);
    $type           = mysqli_real_escape_string($con, $_POST['type']);
    $start_date     = mysqli_real_escape_string($con, $_POST['start_datetime']);
    $end_date       = mysqli_real_escape_string($con, $_POST['end_datetime']);
    $description    = mysqli_real_escape_string($con, $_POST['description']);

    $first_prize    = mysqli_real_escape_string($con, $_POST['first_prize']);
    $second_prize   = mysqli_real_escape_string($con, $_POST['second_prize']);
    $third_prize    = mysqli_real_escape_string($con, $_POST['third_prize']);

    // Allowed types (ENUM validation)
    $allowed_types = ['Essay', 'Story Writing', 'Quiz', 'Poetry'];

    if (!in_array($type, $allowed_types)) {
        die("Invalid competition type");
    }

    // Date validation
    if (strtotime($end_date) < strtotime($start_date)) {
        die("End date must be greater than start date.");
    }

    // Update Query
    $sql = "
        UPDATE competitions SET 
            title = '$title',
            type = '$type',
            start_datetime = '$start_date',
            end_datetime = '$end_date',
            description = '$description',
            first_prize = '$first_prize',
            second_prize = '$second_prize',
            third_prize = '$third_prize'
        WHERE id = $id";

    if (mysqli_query($con, $sql)) {
        echo "<script>
            alert('Competition Updated Successfully!');
            window.location.href = 'competition_list.php';
        </script>";
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}
?>
