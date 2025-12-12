<?php
session_start();
include('includes/connection.php');

// Check admin authentication
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

// Get form data
$title = mysqli_real_escape_string($con, $_POST['title']);
$author = mysqli_real_escape_string($con, $_POST['author']);
$category_id = intval($_POST['category_id']);
$subcategory_id = intval($_POST['subcategory_id']);
$description = mysqli_real_escape_string($con, $_POST['description']);
$cd_available = $_POST['cd_available'] ?? 'No';
$price = floatval($_POST['price']);
$format_type = $_POST['format_type'] ?? 'HARDCOPY';
$subscription_duration = intval($_POST['subscription_duration'] ?? 0);
$cd_price = floatval($_POST['cd_price'] ?? 0.00);
$weight = floatval($_POST['weight'] ?? 0.00);
$delivery_charges = floatval($_POST['delivery_charges'] ?? 0.00);
$is_free_for_members = isset($_POST['is_free_for_members']) ? 1 : 0;
$is_competition_winner = isset($_POST['is_competition_winner']) ? 1 : 0;

// Validation
if(empty($title) || empty($author) || $category_id <= 0 || $subcategory_id <= 0) {
    die("Please fill all required fields");
}

// File upload function
function uploadFile($file, $allowedTypes, $maxSize, $uploadPath) {
    $fileName = time() . "_" . basename($file['name']);
    $targetFile = $uploadPath . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $fileSize = $file['size'];
    
    // Check file type
    if(!in_array($fileType, $allowedTypes)) {
        return ['success' => false, 'error' => 'Invalid file type. Allowed: ' . implode(', ', $allowedTypes)];
    }
    
    // Check file size
    if($fileSize > $maxSize) {
        return ['success' => false, 'error' => 'File too large. Max: ' . ($maxSize/1024/1024) . 'MB'];
    }
    
    // Upload file
    if(move_uploaded_file($file['tmp_name'], $targetFile)) {
        return ['success' => true, 'filename' => $fileName];
    } else {
        return ['success' => false, 'error' => 'Failed to upload file'];
    }
}

// Upload files
$cover_image = "";
$pdf_file = "";
$soft_copy_file = "";

$uploadPath = "uploads/";

// Create uploads directory if not exists
if(!is_dir($uploadPath)) {
    mkdir($uploadPath, 0777, true);
}

// Upload cover image (required)
if(isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
    $allowedImageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $result = uploadFile($_FILES['cover_image'], $allowedImageTypes, 5*1024*1024, $uploadPath);
    
    if($result['success']) {
        $cover_image = $result['filename'];
    } else {
        die("Cover image error: " . $result['error']);
    }
} else {
    die("Cover image is required");
}

// Upload PDF file (optional)
if(isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == 0) {
    $result = uploadFile($_FILES['pdf_file'], ['pdf'], 50*1024*1024, $uploadPath);
    
    if($result['success']) {
        $pdf_file = $result['filename'];
    } else {
        die("PDF upload error: " . $result['error']);
    }
}

// Upload soft copy file (optional)
if(isset($_FILES['soft_copy_file']) && $_FILES['soft_copy_file']['error'] == 0) {
    $allowedDocTypes = ['doc', 'docx', 'epub', 'txt'];
    $result = uploadFile($_FILES['soft_copy_file'], $allowedDocTypes, 10*1024*1024, $uploadPath);
    
    if($result['success']) {
        $soft_copy_file = $result['filename'];
    } else {
        die("Soft copy upload error: " . $result['error']);
    }
}

// Insert into database
$sql = "INSERT INTO books (
    title, author, category_id, subcategory_id, description, 
    cover_image, pdf_file, soft_copy_file, cd_available, price,
    format_type, subscription_duration, cd_price, weight, 
    delivery_charges, is_free_for_members, is_competition_winner
) VALUES (
    '$title', '$author', '$category_id', '$subcategory_id', '$description',
    '$cover_image', '$pdf_file', '$soft_copy_file', '$cd_available', '$price',
    '$format_type', '$subscription_duration', '$cd_price', '$weight',
    '$delivery_charges', '$is_free_for_members', '$is_competition_winner'
)";

if(mysqli_query($con, $sql)) {
    $book_id = mysqli_insert_id($con);
    
    // Success message with sweet alert
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Book Added Successfully</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            body { background: #f8f9fa; font-family: Arial, sans-serif; }
            .success-container { text-align: center; padding: 50px 20px; }
            .success-icon { font-size: 80px; color: #28a745; margin-bottom: 20px; }
            .book-preview { max-width: 300px; margin: 20px auto; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        </style>
    </head>
    <body>
        <div class="success-container">
            <i class="fas fa-check-circle success-icon"></i>
            <h2 class="text-success">Book Added Successfully!</h2>
            <p>Book ID: #' . $book_id . '</p>
            
            <div class="book-preview">
                <img src="' . $uploadPath . $cover_image . '" 
                     style="width:100%; border-radius: 10px 10px 0 0;" 
                     alt="' . $title . '">
                <div style="padding: 20px; background: white; border-radius: 0 0 10px 10px;">
                    <h5>' . htmlspecialchars($title) . '</h5>
                    <p><strong>Author:</strong> ' . htmlspecialchars($author) . '</p>
                    <p><strong>Format:</strong> ' . $format_type . '</p>
                    <p><strong>Price:</strong> Rs ' . number_format($price, 2) . '</p>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="upload_book.php" class="btn btn-outline-primary me-2">
                    <i class="fas fa-plus"></i> Add Another Book
                </a>
                <a href="edit_book.php?id=' . $book_id . '" class="btn btn-primary me-2">
                    <i class="fas fa-edit"></i> Edit This Book
                </a>
                <a href="manage_books.php" class="btn btn-success">
                    <i class="fas fa-list"></i> View All Books
                </a>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: "Success!",
                text: "Book \'' . addslashes($title) . '\' has been added successfully.",
                icon: "success",
                confirmButtonText: "Continue"
            }).then(() => {
                window.location.href = "manage_books.php";
            });
        </script>
    </body>
    </html>';
} else {
    // Error handling
    $error_message = mysqli_error($con);
    
    // Delete uploaded files if database insert failed
    if(!empty($cover_image) && file_exists($uploadPath . $cover_image)) {
        unlink($uploadPath . $cover_image);
    }
    if(!empty($pdf_file) && file_exists($uploadPath . $pdf_file)) {
        unlink($uploadPath . $pdf_file);
    }
    if(!empty($soft_copy_file) && file_exists($uploadPath . $soft_copy_file)) {
        unlink($uploadPath . $soft_copy_file);
    }
    
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Error</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: "Error!",
                html: "Failed to add book.<br><small>' . addslashes($error_message) . '</small>",
                icon: "error",
                confirmButtonText: "Go Back"
            }).then(() => {
                window.history.back();
            });
        </script>
    </body>
    </html>';
}
?>