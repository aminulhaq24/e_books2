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



/* modal */

/* Stylish Modal Design */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-edit {
    background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
    border: none;
    color: white;
}

.bg-gradient-update {
    background: linear-gradient(to right, #43e97b 0%, #38f9d7 100%);
    border: none;
    color: white;
    font-weight: 600;
}

.btn-gradient-edit {
    background: linear-gradient(45deg, #6a11cb 0%, #2575fc 100%);
    color: white;
    border: none;
    border-radius: 30px;
    padding: 5px 15px;
    transition: all 0.3s;
}

.btn-gradient-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(106, 17, 203, 0.4);
}

.section-title {
    color: #2d3748;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 2px solid #e2e8f0;
}

.section-title i {
    color: #4c51bf;
    margin-right: 8px;
}

.file-upload-card {
    background: #f8fafc;
    border: 2px dashed #cbd5e0;
    border-radius: 10px;
    padding: 15px;
    transition: all 0.3s;
}

.file-upload-card:hover {
    border-color: #4c51bf;
    background: #edf2f7;
}

.custom-file-input:focus ~ .custom-file-label {
    border-color: #4c51bf;
    box-shadow: 0 0 0 0.2rem rgba(76, 81, 191, 0.25);
}

/* Form Styling */
.form-control-lg {
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    padding: 12px 15px;
    font-size: 1.1rem;
}

.form-control-lg:focus {
    border-color: #4c51bf;
    box-shadow: 0 0 0 0.2rem rgba(76, 81, 191, 0.25);
}

/* Checkbox Styling */
.custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
    background-color: #4c51bf;
    border-color: #4c51bf;
}

/* Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.modal-content {
    animation: fadeIn 0.3s ease-out;
    border-radius: 15px;
    overflow: hidden;
}

/* Responsive Design */
@media (max-width: 768px) {
    .modal-dialog {
        margin: 10px;
    }
    
    .file-upload-card {
        margin-bottom: 15px;
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
                                        <!-- EDIT BUTTON in book_lists.php -->
                                        <button class="btn btn-sm btn-gradient-edit editBookBtn" 
                                                data-id="<?= $book['book_id']; ?>"
                                                data-title="<?= htmlspecialchars($book['title']); ?>"
                                                data-author="<?= htmlspecialchars($book['author']); ?>"
                                                data-description="<?= htmlspecialchars($book['description']); ?>"
                                                data-price="<?= $book['price']; ?>"
                                                data-category="<?= $book['category_id']; ?>"
                                                data-subcategory="<?= $book['subcategory_id']; ?>"
                                                data-format="<?= $book['format_type']; ?>"
                                                data-cd-available="<?= $book['cd_available']; ?>"
                                                data-cd-price="<?= $book['cd_price']; ?>"
                                                data-weight="<?= $book['weight']; ?>"
                                                data-delivery="<?= $book['delivery_charges']; ?>"
                                                data-subscription="<?= $book['subscription_duration']; ?>"
                                                data-is-free="<?= $book['is_free_for_members']; ?>"
                                                data-is-competition="<?= $book['is_competition_winner']; ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editBookModal">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

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
                                            class="btn  btn-gradient-edit btn-md btn-outline-info" title="Quick Preview" target="_blank">
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



<!-- EDIT BOOK MODAL - Stylish Version -->
<div class="modal fade" id="editBookModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-book-edit mr-2"></i>Edit Book Details
                </h5>
                <button type="button" class="close text-white" data-bs-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="update_book.php" method="POST" enctype="multipart/form-data" id="editBookForm">
                <div class="modal-body">
                    <input type="hidden" name="book_id" id="edit_book_id">

                    <!-- Success/Error Messages -->
                    <div id="editMessage" class="alert" style="display:none;"></div>

                    <div class="row">
                        <!-- Left Column - Basic Info -->
                        <div class="col-md-6">
                            <h6 class="section-title"><i class="fas fa-info-circle"></i> Basic Information</h6>
                            
                            <div class="form-group">
                                <label class="form-label">Book Title *</label>
                                <input type="text" name="title" id="edit_title" class="form-control form-control-lg" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Author *</label>
                                <input type="text" name="author" id="edit_author" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Category *</label>
                                        <select name="category_id" id="edit_category" class="form-control select2" required>
                                            <option disabled>Select Category</option>
                                            <?php
                                            $cat = mysqli_query($con, "SELECT * FROM categories");
                                            while ($c = mysqli_fetch_assoc($cat)) {
                                                echo "<option value='{$c['id']}'>{$c['category_name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="edit_description" class="form-control" rows="4"></textarea>
                            </div>
                        </div>

                        <!-- Right Column - Pricing & Files -->
                        <div class="col-md-6">
                            <h6 class="section-title"><i class="fas fa-dollar-sign"></i> Pricing & Format</h6>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Price (PKR)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">₨</span>
                                            </div>
                                            <input type="number" name="price" id="edit_price" class="form-control" min="0" step="0.01">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Format Type</label>
                                        <select name="format_type" id="edit_format" class="form-control">
                                            <option value="HARDCOPY">Hard Copy</option>
                                            <option value="PDF">PDF</option>
                                            <option value="CD">CD</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Checkboxes in Card -->
                            <div class="card mb-3">
                                <div class="card-body py-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="cd_available" id="edit_cd_available" value="Yes">
                                                <label class="custom-control-label" for="edit_cd_available">CD Available</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="is_free_for_members" id="edit_is_free" value="1">
                                                <label class="custom-control-label" for="edit_is_free">Free for Members</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Details -->
                            <h6 class="section-title mt-3"><i class="fas fa-cog"></i> Additional Details</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Weight (kg)</label>
                                        <input type="number" name="weight" id="edit_weight" class="form-control" step="0.01">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Delivery (PKR)</label>
                                        <input type="number" name="delivery_charges" id="edit_delivery" class="form-control" step="0.01">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Subscription (Months)</label>
                                        <input type="number" name="subscription_duration" id="edit_subscription" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- File Uploads Section -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h6 class="section-title"><i class="fas fa-file-upload"></i> File Uploads (Optional)</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="file-upload-card">
                                        <label class="form-label">Cover Image</label>
                                        <div class="custom-file">
                                            <input type="file" name="cover_image" class="custom-file-input" id="edit_cover_image" accept="image/*">
                                            <label class="custom-file-label" for="edit_cover_image">Choose file</label>
                                        </div>
                                        <small class="text-muted">Max 2MB. JPG, PNG, GIF</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="file-upload-card">
                                        <label class="form-label">PDF File</label>
                                        <div class="custom-file">
                                            <input type="file" name="pdf_file" class="custom-file-input" id="edit_pdf_file" accept=".pdf">
                                            <label class="custom-file-label" for="edit_pdf_file">Choose PDF</label>
                                        </div>
                                        <small class="text-muted">PDF format only</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="file-upload-card">
                                        <label class="form-label">Soft Copy</label>
                                        <div class="custom-file">
                                            <input type="file" name="soft_copy_file" class="custom-file-input" id="edit_soft_copy" accept=".doc,.docx,.txt">
                                            <label class="custom-file-label" for="edit_soft_copy">Choose file</label>
                                        </div>
                                        <small class="text-muted">DOC, DOCX, TXT</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit"  class="btn btn-gradient-update">
                        <i class="fas fa-save"></i> Update Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>





<?php include('includes/footer.php'); ?>
<!-- <script>
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
</script> -->

    <script>
    
        // Edit Book Button Click
        $(document).on("click", ".editBookBtn", function() {
            // Get data from button
            let bookData = {
                id: $(this).data("id"),
                title: $(this).data("title"),
                author: $(this).data("author"),
                description: $(this).data("description"),
                price: $(this).data("price"),
                category: $(this).data("category"),
                subcategory: $(this).data("subcategory"),
                format: $(this).data("format"),
                cdAvailable: $(this).data("cd-available"),
                cdPrice: $(this).data("cd-price"),
                weight: $(this).data("weight"),
                delivery: $(this).data("delivery"),
                subscription: $(this).data("subscription"),
                isFree: $(this).data("is-free"),
                isCompetition: $(this).data("is-competition")
            };
    
            // Fill modal fields
            $("#edit_book_id").val(bookData.id);
            $("#edit_title").val(bookData.title);
            $("#edit_author").val(bookData.author);
            $("#edit_description").val(bookData.description);
            $("#edit_price").val(bookData.price);
            $("#edit_category").val(bookData.category);
            $("#edit_subcategory").val(bookData.subcategory);
            $("#edit_format").val(bookData.format);
            $("#edit_weight").val(bookData.weight);
            $("#edit_delivery").val(bookData.delivery);
            $("#edit_subscription").val(bookData.subscription);
            $("#edit_cd_price").val(bookData.cdPrice);
    
            // Set checkboxes
            $("#edit_cd_available").prop("checked", bookData.cdAvailable === "Yes");
            $("#edit_is_free").prop("checked", bookData.isFree == 1);
            $("#edit_is_competition").prop("checked", bookData.isCompetition == 1);
    
            // Set category and load subcategories
            // $("#edit_category").val(bookData.category);
            // loadSubcategories(bookData.category, bookData.subcategory);
    
            // Update file input labels
            $('.custom-file-input').next('.custom-file-label').html('Choose file');
        });
    
        // Load Subcategories based on Category
        // function loadSubcategories(categoryId, selectedSubcategory = '') {
        //     if (!categoryId) {
        //         $("#edit_subcategory").html('<option value="">Select Subcategory</option>');
        //         return;
        //     }
    
        //     $.ajax({
        //         url: 'get_subcategories.php',
        //         type: 'GET',
        //         data: { category_id: categoryId },
        //         success: function(response) {
        //             $("#edit_subcategory").html(response);
        //             if (selectedSubcategory) {
        //                 $("#edit_subcategory").val(selectedSubcategory);
        //             }
        //         }
        //     });
        // }
    
        // Category change event
        // $("#edit_category").change(function() {
        //     loadSubcategories($(this).val());
        // });
    
        // File input label update
        // $('.custom-file-input').change(function() {
        //     var fileName = $(this).val().split('\\').pop();
        //     $(this).next('.custom-file-label').addClass("selected").html(fileName);
        // });
    
        // Form submission with AJAX
        // $("#editBookForm").submit(function(e) {
        //     e.preventDefault();
            
        //     var formData = new FormData(this);
            
        //     $.ajax({
        //         url: 'update_book.php',
        //         type: 'POST',
        //         data: formData,
        //         contentType: false,
        //         processData: false,
        //         beforeSend: function() {
        //             $(".btn-gradient-update").html('<i class="fas fa-spinner fa-spin"></i> Updating...').prop('disabled', true);
        //         },
        //         success: function(response) {
        //             if (response.success) {
        //                 // Show success message
        //                 $("#editMessage").removeClass("alert-danger").addClass("alert-success")
        //                     .html('<i class="fas fa-check-circle"></i> ' + response.message).show();
                        
        //                 // Close modal after 2 seconds and reload page
        //                 setTimeout(function() {
        //                     $('#editBookModal').modal('hide');
        //                     location.reload();
        //                 }, 2000);
        //             } else {
        //                 $("#editMessage").removeClass("alert-success").addClass("alert-danger")
        //                     .html('<i class="fas fa-exclamation-circle"></i> ' + response.message).show();
        //                 $(".btn-gradient-update").html('<i class="fas fa-save"></i> Update Book').prop('disabled', false);
        //             }
        //         },
        //         error: function() {
        //             $("#editMessage").removeClass("alert-success").addClass("alert-danger")
        //                 .html('<i class="fas fa-exclamation-circle"></i> Network error! Please try again.').show();
        //             $(".btn-gradient-update").html('<i class="fas fa-save"></i> Update Book').prop('disabled', false);
        //         }
        //     });
        // });
    
    </script>