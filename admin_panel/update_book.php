<?php
include("includes/connection.php");

if (isset($_POST['book_id'])) {

    $book_id = $_POST['book_id'];
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $author = mysqli_real_escape_string($con, $_POST['author']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $price = intval($_POST['price']);
    $category_id = intval($_POST['category_id']);
    $subcategory_id = intval($_POST['subcategory_id']);

    // -----------------------------------------------------
    // Fetch old book data (so we can keep old file if new not uploaded)
    // -----------------------------------------------------
    $old = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM books WHERE book_id=$book_id"));

    $cover_image = $old['cover_image'];
    $pdf_file = $old['pdf_file'];
    $soft_copy_file = $old['soft_copy_file'];

    // -----------------------------------------------------
    // Upload Cover Image (Optional)
    // -----------------------------------------------------
    if (!empty($_FILES['cover_image']['name'])) {
        $img_name = time() . "_" . $_FILES['cover_image']['name'];
        $img_tmp = $_FILES['cover_image']['tmp_name'];
        $upload_path = "uploads/covers/" . $img_name;

        move_uploaded_file($img_tmp, $upload_path);
        $cover_image = $img_name;
    }

    // -----------------------------------------------------
    // Upload PDF File (Optional)
    // -----------------------------------------------------
    if (!empty($_FILES['pdf_file']['name'])) {
        $pdf_name = time() . "_" . $_FILES['pdf_file']['name'];
        $pdf_tmp = $_FILES['pdf_file']['tmp_name'];
        $upload_path = "uploads/pdfs/" . $pdf_name;

        move_uploaded_file($pdf_tmp, $upload_path);
        $pdf_file = $pdf_name;
    }

    // -----------------------------------------------------
    // Upload Soft Copy File (Optional)
    // -----------------------------------------------------
    if (!empty($_FILES['soft_copy_file']['name'])) {
        $soft_name = time() . "_" . $_FILES['soft_copy_file']['name'];
        $soft_tmp = $_FILES['soft_copy_file']['tmp_name'];
        $upload_path = "uploads/softcopy/" . $soft_name;

        move_uploaded_file($soft_tmp, $upload_path);
        $soft_copy_file = $soft_name;
    }

    // -----------------------------------------------------
    // Update Query
    // -----------------------------------------------------
    $sql = "UPDATE books SET
                title='$title',
                author='$author',
                description='$description',
                price='$price',
                category_id='$category_id',
                subcategory_id='$subcategory_id',
                cover_image='$cover_image',
                pdf_file='$pdf_file',
                soft_copy_file='$soft_copy_file'
            WHERE book_id=$book_id";

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
