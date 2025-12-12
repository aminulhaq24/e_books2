<?php
include("includes/connection.php");


// Check admin authentication
// if(!isset($_SESSION['admin_id'])) {
//     echo json_encode(['success' => false, 'message' => 'Unauthorized access!']);
//     exit();
// }

// $response = ['success' => false, 'message' => ''];

if (isset($_POST['book_id'])) {
    $book_id = intval($_POST['book_id']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $author = mysqli_real_escape_string($con, $_POST['author']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);
    $subcategory_id = intval($_POST['subcategory_id']);
    $format_type = mysqli_real_escape_string($con, $_POST['format_type'] ?? 'HARDCOPY');
    $weight = floatval($_POST['weight'] ?? 0);
    $delivery_charges = floatval($_POST['delivery_charges'] ?? 0);
    $subscription_duration = intval($_POST['subscription_duration'] ?? 0);
    $cd_price = floatval($_POST['cd_price'] ?? 0);
    $cd_available = isset($_POST['cd_available']) ? 'Yes' : 'No';
    $is_free_for_members = isset($_POST['is_free_for_members']) ? 1 : 0;
    $is_competition_winner = isset($_POST['is_competition_winner']) ? 1 : 0;

    // Fetch old book data
    $old = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM books WHERE book_id=$book_id"));
    
    $cover_image = $old['cover_image'];
    $pdf_file = $old['pdf_file'];
    $soft_copy_file = $old['soft_copy_file'];

    // Handle Cover Image Upload
    if (!empty($_FILES['cover_image']['name'])) {
        $img_name = time() . "_" . $_FILES['cover_image']['name'];
        $img_tmp = $_FILES['cover_image']['tmp_name'];
        $upload_path = "uploads/covers/" . $img_name;
        
        // Validate image
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($img_tmp);
        
        if(in_array($file_type, $allowed_types) && $_FILES['cover_image']['size'] <= 2097152) {
            move_uploaded_file($img_tmp, $upload_path);
            $cover_image = $img_name;
            
            // Delete old image
            if($old['cover_image'] && file_exists("uploads/covers/" . $old['cover_image'])) {
                unlink("uploads/covers/" . $old['cover_image']);
            }
        }
    }

    // Handle PDF Upload
    if (!empty($_FILES['pdf_file']['name'])) {
        $pdf_name = time() . "_" . $_FILES['pdf_file']['name'];
        $pdf_tmp = $_FILES['pdf_file']['tmp_name'];
        $upload_path = "uploads/pdfs/" . $pdf_name;
        
        if(pathinfo($pdf_name, PATHINFO_EXTENSION) === 'pdf') {
            move_uploaded_file($pdf_tmp, $upload_path);
            $pdf_file = $pdf_name;
            
            if($old['pdf_file'] && file_exists("uploads/pdfs/" . $old['pdf_file'])) {
                unlink("uploads/pdfs/" . $old['pdf_file']);
            }
        }
    }

    // Handle Soft Copy Upload
    if (!empty($_FILES['soft_copy_file']['name'])) {
        $soft_name = time() . "_" . $_FILES['soft_copy_file']['name'];
        $soft_tmp = $_FILES['soft_copy_file']['tmp_name'];
        $upload_path = "uploads/softcopy/" . $soft_name;
        
        $allowed_ext = ['doc', 'docx', 'txt'];
        $file_ext = strtolower(pathinfo($soft_name, PATHINFO_EXTENSION));
        
        if(in_array($file_ext, $allowed_ext)) {
            move_uploaded_file($soft_tmp, $upload_path);
            $soft_copy_file = $soft_name;
            
            if($old['soft_copy_file'] && file_exists("uploads/softcopy/" . $old['soft_copy_file'])) {
                unlink("uploads/softcopy/" . $old['soft_copy_file']);
            }
        }
    }

    // Update Query
    $sql = "UPDATE books SET
                title = '$title',
                author = '$author',
                description = '$description',
                price = '$price',
                category_id = '$category_id',
                subcategory_id = '$subcategory_id',
                format_type = '$format_type',
                weight = '$weight',
                delivery_charges = '$delivery_charges',
                subscription_duration = '$subscription_duration',
                cd_available = '$cd_available',
                cd_price = '$cd_price',
                is_free_for_members = '$is_free_for_members',
                is_competition_winner = '$is_competition_winner',
                cover_image = '$cover_image',
                pdf_file = '$pdf_file',
                soft_copy_file = '$soft_copy_file'
                
            WHERE book_id = $book_id";

     if (mysqli_query($con, $sql)) {
        echo "<script>
                alert('Book updated successfully!');
                window.location.href='book_lists.php';
              </script>";
    } else {
        echo "<script>
                alert('Something went wrong!');
                window.location.href='book_lists.php';
              </script>";
    }
}
?>