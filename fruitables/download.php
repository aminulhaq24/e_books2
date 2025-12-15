<?php
// download.php (Basic)

include('includes/connection.php');

// if(!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit;
// }

if(isset($_GET['id'])) {
    $book_id = (int)$_GET['id'];
    
    // Verify book is free
    $query = "SELECT * FROM books WHERE book_id = $book_id AND (price = 0 OR is_free_for_members = 1)";
    $result = mysqli_query($con, $query);
    
    if(mysqli_num_rows($result) > 0) {
        $book = mysqli_fetch_assoc($result);
        
        // Track download in database (optional)
        // $user_id = $_SESSION['user_id'];
        // $track_query = "INSERT INTO downloads (user_id, book_id) VALUES ($user_id, $book_id)";
        // mysqli_query($con, $track_query);
        
        // Redirect to PDF file
        if($book['pdf_file']) {
            $file_path = "../admin_panel/uploads/" . $book['pdf_file'];
            if(file_exists($file_path)) {
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $book['title'] . '.pdf"');
                readfile($file_path);
                exit;
            }
        }
    }
}

header("Location: shop.php");
?>