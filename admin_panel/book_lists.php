<?php
include('includes/nav.php');


// Fetch books + category + subcategory
 //$sql = "
// SELECT b.*, 
//        c.category_name, 
//        sc.subcategory_name
// FROM books b
// JOIN categories c ON b.category_id = c.id
// JOIN subcategories sc ON b.subcategory_id = sc.id
// ORDER BY b.book_id DESC
// ";
$latest_books = mysqli_query($con, "
SELECT books.*, 
       categories.category_name, 
       subcategories.subcategory_name
FROM books
JOIN categories ON books.category_id = categories.id
JOIN subcategories ON books.subcategory_id = subcategories.id 
ORDER BY book_id DESC");

?>

<style>
/* Tables */
.table-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    margin-bottom: 2rem;
}

.table-card .card-header {
    background: transparent;
    border-bottom: 2px solid #f1f2f6;
    padding: 1rem 0;
    margin-bottom: 1.5rem;
}

.table-card .card-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.custom-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.custom-table th {
    background: #f8f9fa;
    padding: 1rem;
    font-weight: 600;
    color: #495057;
    border: none;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.custom-table td {
    padding: 1rem;
    border-bottom: 1px solid #f1f2f6;
    vertical-align: middle;
}

.custom-table tr:last-child td {
    border-bottom: none;
}

.custom-table tr:hover {
    background-color: #f8f9fa;
}

/* Book Thumbnail */
.book-thumb {
    width: 60px;
    height: 75px;
    border-radius: 8px;
    object-fit: cover;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.book-thumb:hover {
    transform: scale(1.05);
}

/* Status Badges */
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-block;
}

.badge-delivered {
    background: #d4edda;
    color: #155724;
}

.badge-pending {
    background: #fff3cd;
    color: #856404;
}

.badge-processing {
    background: #cce5ff;
    color: #004085;
}

.badge-cancelled {
    background: #f8d7da;
    color: #721c24;
}

/* Format Badges */
.format-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
}

.badge-pdf {
    background: #ffeaa7;
    color: #e17055;
}

.badge-hardcopy {
    background: #a29bfe;
    color: #6c5ce7;
}

.badge-cd {
    background: #fd79a8;
    color: #d63031;
}

/* Quick Actions */
.quick-actions {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.action-btn {
    display: block;
    padding: 1.2rem;
    margin-bottom: 1rem;
    border-radius: 10px;
    background: #f8f9fa;
    text-align: center;
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.action-btn:hover {
    background: #667eea;
    color: white;
    transform: translateX(5px);
    text-decoration: none;
    border-color: #667eea;
}

.action-icon {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    display: block;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-title {
        font-size: 2rem;
    }

    .stat-number {
        font-size: 1.8rem;
    }

    .table-card {
        padding: 1rem;
    }
}
</style>

<!-- Latest Books -->

<div class="container-fluid py-4 px-3 px-md-4">
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="table-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title"><i class="fas fa-book-open me-2"></i> All Books</h5>
                      <a href="add_book.php" class="btn btn-success shadow-sm">
            + Add New Book
        </a>
                </div>

                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Cover</th>
                                <th>Title & Author</th>
                                <th>Category</th>
                                <th>Format</th>
                                <th>Files</th>
                                <th>Price</th>
                                <th>Added On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($latest_books) > 0): ?>
                            <?php while($book = mysqli_fetch_assoc($latest_books)): ?>
                            <tr>
                                <td>
                                    <img src="../admin_panel/uploads/<?= $book['cover_image'] ?? 'default-book.jpg' ?>"
                                        class="book-thumb" alt="Book Cover">
                                </td>
                                <td>
                                    <div class="fw-bold">
                                        <?= htmlspecialchars(substr($book['title'], 0, 35)) ?><?= strlen($book['title']) > 35 ? '...' : '' ?>
                                    </div>
                                    <small class="text-muted">by <?= htmlspecialchars($book['author']) ?></small>
                                </td>
                                <td><?= $book['category_name'] ?> / <?= $book['subcategory_name']; ?></td>
                                <td>
                                    <span
                                        class="format-badge badge-<?= strtolower($book['format_type'] ?? 'hardcopy') ?>">
                                        <?= $book['format_type'] ?? 'HARDCOPY' ?>
                                    </span>
                                    <?php if($book['is_free_for_members']): ?>
                                    <span class="badge bg-success mt-1">Free for Members</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(!empty($book['pdf_file'])) { ?>
                                    <a href="uploads/<?php echo $book['pdf_file']; ?>" target="_blank"
                                        class="btn btn-primary p-1 action-btn">PDF</a>
                                    <?php } ?>

                                    <?php if($book['cd_available']=='Yes') { ?>
                                    <span class="badge bg-warning text-dark">CD</span>
                                    <?php } ?>
                                </td>

                                <td class="fw-bold"> <?php 
                                if($book['price'] == 0) 
                                   echo "<span class='text-success'>FREE</span>";
                                  else 
                                  echo "Rs. " . $book['price'];
                                 ?></td>
                                <td><?= date('M j, Y', strtotime($book['created_at'])) ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- Edit Button -->
                                        
                                        <a href="edit_book.php?id=<?= $book['book_id'] ?>"
                                            class="btn btn-md btn-outline-primary" title="Edit Book">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete Button with Confirmation -->
                                        <a href="delete_book.php?id=<?= $book['book_id']?>"
                                            class="btn btn-md btn-outline-danger" title="Delete Book"
                                            onclick="return confirm('Delete this book?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>

                                        <!-- Quick View Button -->
                                        <a href="book_preview.php?id=<?= $book['book_id'] ?>"
                                            class="btn btn-md btn-outline-info" title="Quick Preview" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>

                            </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-book fa-2x mb-3"></i>
                                    <p>No books added yet. Start by uploading your first book!</p>
                                    <a href="upload_book.php" class="btn btn-primary mt-2">Upload First Book</a>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>





<!-- EDIT BOOK MODAL -->


<div class="modal fade" id="editBookModal">
    <div class="modal-dialog modal-lg">
        <form action="update_book.php" method="POST" enctype="multipart/form-data" class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5>Edit Book</h5>
                <button class="close" data-bs-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="book_id" id="edit_book_id">
                <div class="row">
                    <div class="col-md-6">
                        <label>Title</label>
                        <input type="text" name="title" id="edit_title" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Author</label>
                        <input type="text" name="author" id="edit_author" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="edit_description" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>Price</label>
                    <input type="number" name="price" id="edit_price" class="form-control">
                </div>

                <!-- CATEGORY -->
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" id="edit_category" class="form-control">
                        <option disabled>Select Category</option>
                        <?php
                        $cat = mysqli_query($con, "SELECT * FROM categories");
                        while ($c = mysqli_fetch_assoc($cat)) {
                            echo "<option value='{$c['id']}'>{$c['category_name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- SUBCATEGORY -->
                <div class="form-group">
                    <label>Subcategory</label>
                    <select name="subcategory_id" id="edit_subcategory" class="form-control">
                        <option disabled>Select Subcategory</option>
                        <?php
                        $sub = mysqli_query($con, "SELECT * FROM subcategories");
                        while ($s = mysqli_fetch_assoc($sub)) {
                            echo "<option value='{$s['id']}'>{$s['subcategory_name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6 mt-3">
                    <label>Price (0 = Free)</label>
                    <input type="number" name="price" id="edit_price" class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-success">Update Book</button>
            </div>

        </form>
    </div>
</div>






<?php include('includes/footer.php'); ?>
<script>
$(document).on("click", ".editBookBtn", function() {

    let id = $(this).data("id");
    let title = $(this).data("title");
    let author = $(this).data("author");
    let description = $(this).data("description");
    let price = $(this).data("price");
    let category = $(this).data("category");
    let subcategory = $(this).data("subcategory");

    $("#edit_book_id").val(id);
    $("#edit_title").val(title);
    $("#edit_author").val(author);
    $("#edit_description").val(description);
    $("#edit_price").val(price);

    // SELECT CATEGORY
    $("#edit_category").val(category);

    // SELECT SUBCATEGORY
    $("#edit_subcategory").val(subcategory);
});
</script>