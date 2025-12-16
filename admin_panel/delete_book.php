<?php
// delete_book.php - UPDATED VERSION
include('includes/connection.php');
session_start();

// Check if admin is logged in
// if(!isset($_SESSION['admin_logged_in'])) {
//     header("Location: login.php");
//     exit;
// }

// Get book ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validate ID
if($id <= 0) {
    die("Invalid book ID");
}

// Check if book exists
$check_sql = "SELECT * FROM books WHERE book_id = $id";
$check_result = mysqli_query($con, $check_sql);

if(mysqli_num_rows($check_result) == 0) {
    die("Book not found");
}

$book = mysqli_fetch_assoc($check_result);

// Delete book files if they exist
function deleteFileIfExists($filename) {
    if(!empty($filename)) {
        $path = "../admin_panel/uploads/" . $filename;
        if(file_exists($path)) {
            @unlink($path);
        }
    }
}

// Delete cover image
deleteFileIfExists($book['cover_image']);

// Delete PDF file
deleteFileIfExists($book['pdf_file']);

// Delete book from database
$delete_sql = "DELETE FROM books WHERE book_id = $id";
$result = mysqli_query($con, $delete_sql);

if($result) {
    // Check redirect destination
   header('Location: book_lists.php');
}

?>