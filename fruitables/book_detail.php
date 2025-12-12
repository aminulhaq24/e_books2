<?php
include("includes/nav.php");

// --- GET BOOK ID ---
if (!isset($_GET['id'])) {
    echo "<h2 class='text-center mt-5 text-danger'>Invalid Book</h2>";
    exit;
}

$book_id = intval($_GET['id']);

// --- FETCH BOOK DATA ---
$query = "
SELECT b.*, c.category_name, s.subcategory_name 
FROM books b
LEFT JOIN categories c ON b.category_id = c.id
LEFT JOIN subcategories s ON b.subcategory_id = s.id
WHERE b.book_id = $book_id
";

$result = mysqli_query($con, $query);
$book = mysqli_fetch_assoc($result);

if (!$book) {
    echo "<h2 class='text-center mt-5 text-danger'>Book Not Found</h2>";
    exit;
}

// Calculate discount if applicable
$original_price = $book['price'];
$discount_percentage = 0;
if (isset($book['discount_price']) && $book['discount_price'] > 0) {
    $discount_percentage = round((($original_price - $book['discount_price']) / $original_price) * 100);
}
?>

<!-- Book Detail Page -->
<div class="container-fluid book-detail-container">
    <div class="container py-5">
        <div class="row g-5">
            
            <!-- LEFT: Book Images & Actions -->
            <div class="col-lg-5">
                <div class="book-media-section">
                    <!-- Main Book Image -->
                    <div class="book-image-main mb-4">
                        <div class="image-wrapper">
                            <img src="../admin_panel/uploads/<?= $book['cover_image']; ?>" 
                                 class="img-fluid rounded-4 shadow" 
                                 alt="<?= $book['title']; ?>"
                                 id="mainBookImage">
                            <?php if($discount_percentage > 0): ?>
                                <span class="discount-badge">-<?= $discount_percentage ?>%</span>
                            <?php endif; ?>
                            <div class="image-overlay">
                                <button class="btn btn-light btn-sm" onclick="zoomImage()">
                                    <i class="fa fa-search-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Images (if available) -->
                    <div class="book-thumbnails d-flex justify-content-center gap-3">
                        <div class="thumbnail active" onclick="changeImage(this, '../admin_panel/uploads/<?= $book['cover_image']; ?>')">
                            <img src="../admin_panel/uploads/<?= $book['cover_image']; ?>" class="img-fluid rounded" alt="Cover">
                        </div>
                        <!-- Add more thumbnails here if you have additional images -->
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="quick-actions mt-4 d-flex flex-wrap gap-2 justify-content-center">
                        <button class="btn btn-outline-primary btn-action" title="Preview">
                            <i class="fa fa-eye me-2"></i> Preview
                        </button>
                        <button class="btn btn-outline-primary btn-action" title="Share">
                            <i class="fa fa-share-alt me-2"></i> Share
                        </button>
                        <button class="btn btn-outline-primary btn-action" title="Compare">
                            <i class="fa fa-balance-scale me-2"></i> Compare
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- RIGHT: Book Details -->
            <div class="col-lg-7">
                <div class="book-details-section">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="category.php?id=<?= $book['category_id'] ?>"><?= $book['category_name']; ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $book['title']; ?></li>
                        </ol>
                    </nav>
                    
                    <!-- Title & Author -->
                    <h1 class="fw-bold mb-2 book-title"><?= $book['title']; ?></h1>
                    <p class="text-muted mb-3">
                        <i class="fa fa-user-circle me-1"></i> Author: 
                        <span class="fw-medium"><?= isset($book['author']) ? $book['author'] : 'Unknown Author'; ?></span>
                    </p>
                    
                    <!-- Rating -->
                    <div class="rating-section mb-3">
                        <div class="stars">
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star-half-alt text-warning"></i>
                            <span class="ms-2 text-muted">(4.5 • 128 reviews)</span>
                        </div>
                    </div>
                    
                    <!-- Categories -->
                    <div class="categories mb-4">
                        <span class="badge bg-light text-dark border me-2">
                            <i class="fa fa-tag me-1"></i> <?= $book['category_name']; ?>
                        </span>
                        <span class="badge bg-light text-dark border">
                            <i class="fa fa-folder me-1"></i> <?= $book['subcategory_name']; ?>
                        </span>
                    </div>
                    
                    <!-- Price Section -->
                    <div class="price-section mb-4">
                        <h2 class="fw-bold text-primary mb-1">
                            Rs <?= number_format($discount_percentage > 0 ? $book['discount_price'] : $book['price']); ?>
                        </h2>
                        <?php if($discount_percentage > 0): ?>
                            <div class="d-flex align-items-center">
                                <del class="text-muted me-3">Rs <?= number_format($book['price']); ?></del>
                                <span class="badge bg-danger fs-6">Save Rs <?= number_format($book['price'] - $book['discount_price']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Description -->
                    <div class="description-section mb-4">
                        <h5 class="fw-bold mb-3">Description</h5>
                        <div class="description-content">
                            <p class="text-secondary"><?= nl2br($book['description']); ?></p>
                        </div>
                        <a href="#full-description" class="text-primary text-decoration-none" data-bs-toggle="collapse">
                            Read More <i class="fa fa-chevron-down ms-1"></i>
                        </a>
                        <div class="collapse mt-2" id="full-description">
                            <!-- Additional description content can go here -->
                        </div>
                    </div>
                    
                    <!-- Key Features -->
                    <div class="features-section mb-4">
                        <h5 class="fw-bold mb-3">Key Features</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fa fa-check text-success me-2"></i> High Quality Print</li>
                                    <li class="mb-2"><i class="fa fa-check text-success me-2"></i> Premium Paper</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fa fa-check text-success me-2"></i> Free Bookmark</li>
                                    <li class="mb-2"><i class="fa fa-check text-success me-2"></i> Author Signature</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons mb-4">
                        <div class="d-flex flex-wrap gap-3 align-items-center">
                            <!-- Quantity Selector -->
                            <div class="quantity-selector d-flex align-items-center border rounded-3">
                                <button class="btn btn-outline-secondary border-0 rounded-start" onclick="decreaseQuantity()">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <input type="number" class="form-control text-center border-0" 
                                       id="quantity" value="1" min="1" max="10" style="width: 60px;">
                                <button class="btn btn-outline-secondary border-0 rounded-end" onclick="increaseQuantity()">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            
                            <!-- Main Actions -->
                            <button class="btn btn-primary btn-lg rounded-3 px-4 py-3 d-flex align-items-center">
                                <i class="fa fa-shopping-cart me-2"></i> Add to Cart
                            </button>
                            
                            <button class="btn btn-outline-danger btn-lg rounded-3 px-4 py-3 d-flex align-items-center">
                                <i class="fa fa-heart me-2"></i> Wishlist
                            </button>
                            
                            <button class="btn btn-outline-success btn-lg rounded-3 px-4 py-3 d-flex align-items-center">
                                <i class="fa fa-bolt me-2"></i> Buy Now
                            </button>
                        </div>
                    </div>
                    
                    <!-- Additional Info -->
                    <div class="additional-info mt-4 pt-4 border-top">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                                        <i class="fa fa-truck fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">Free Shipping</h6>
                                        <small class="text-muted">On orders over Rs 500</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                                        <i class="fa fa-shield-alt fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">Secure Payment</h6>
                                        <small class="text-muted">100% Secure</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-warning bg-opacity-10 text-warning rounded-circle p-3 me-3">
                                        <i class="fa fa-undo fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">Easy Returns</h6>
                                        <small class="text-muted">30 Day Returns</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional Sections -->
        <div class="row mt-5">
            <!-- Tabs for More Info -->
            <div class="col-12">
                <ul class="nav nav-tabs" id="bookTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="details-tab" data-bs-toggle="tab" 
                                data-bs-target="#details" type="button" role="tab">
                            <i class="fa fa-info-circle me-2"></i> Details
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" 
                                data-bs-target="#reviews" type="button" role="tab">
                            <i class="fa fa-star me-2"></i> Reviews (128)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" 
                                data-bs-target="#shipping" type="button" role="tab">
                            <i class="fa fa-truck me-2"></i> Shipping
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content p-4 border border-top-0 rounded-bottom" id="bookTabsContent">
                    <div class="tab-pane fade show active" id="details" role="tabpanel">
                        <h5 class="fw-bold mb-3">Book Specifications</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" width="40%">ISBN</td>
                                        <td class="fw-medium"><?= isset($book['isbn']) ? $book['isbn'] : '978-3-16-148410-0'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Publisher</td>
                                        <td class="fw-medium"><?= isset($book['publisher']) ? $book['publisher'] : 'Penguin Books'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Publication Date</td>
                                        <td class="fw-medium"><?= isset($book['publish_date']) ? date('F Y', strtotime($book['publish_date'])) : 'January 2023'; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" width="40%">Pages</td>
                                        <td class="fw-medium"><?= isset($book['pages']) ? $book['pages'] : '320'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Language</td>
                                        <td class="fw-medium"><?= isset($book['language']) ? $book['language'] : 'English'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Format</td>
                                        <td class="fw-medium">Hardcover</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <h5 class="fw-bold mb-3">Customer Reviews</h5>
                        <p>Reviews will be displayed here. You can integrate a review system.</p>
                    </div>
                    
                    <div class="tab-pane fade" id="shipping" role="tabpanel">
                        <h5 class="fw-bold mb-3">Shipping Information</h5>
                        <p>Free shipping on orders over Rs 500. Delivery within 3-7 business days.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Books (Optional) -->
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="fw-bold mb-4">Related Books</h3>
                <div class="row" id="relatedBooks">
                    <!-- Related books will be loaded here via AJAX or PHP -->
                    <div class="col-md-3 text-center py-4">
                        <p class="text-muted">Loading related books...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Zoom Modal -->
<div class="modal fade" id="imageZoomModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="zoomedImage" class="img-fluid rounded-3" alt="Zoomed Book Image">
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
.book-detail-container {
    margin-top: 120px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: calc(100vh - 120px);
}

.book-image-main {
    position: relative;
    overflow: hidden;
    border-radius: 20px;
}

.book-image-main .image-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.book-image-main img {
    width: 100%;
    height: 500px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.book-image-main img:hover {
    transform: scale(1.03);
}

.image-overlay {
    position: absolute;
    top: 20px;
    right: 20px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.image-wrapper:hover .image-overlay {
    opacity: 1;
}

.discount-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: #dc3545;
    color: white;
    padding: 8px 15px;
    border-radius: 30px;
    font-weight: bold;
    font-size: 1.1rem;
    box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
}

.book-thumbnails .thumbnail {
    width: 80px;
    height: 100px;
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    opacity: 0.6;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.book-thumbnails .thumbnail:hover,
.book-thumbnails .thumbnail.active {
    opacity: 1;
    border-color: #0d6efd;
    transform: translateY(-5px);
}

.book-thumbnails .thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.book-title {
    font-size: 2.5rem;
    line-height: 1.2;
    color: #2c3e50;
}

.price-section h2 {
    font-size: 2.8rem;
    color: #0d6efd;
}

.quantity-selector {
    background: white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.quantity-selector input {
    font-weight: bold;
}

.btn-action {
    border-radius: 30px;
    padding: 10px 20px;
    transition: all 0.3s ease;
}

.btn-action:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.icon-circle {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.nav-tabs .nav-link {
    border: none;
    padding: 15px 30px;
    font-weight: 600;
    color: #6c757d;
    position: relative;
}

.nav-tabs .nav-link.active {
    color: #0d6efd;
    background: transparent;
}

.nav-tabs .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: #0d6efd;
    border-radius: 3px 3px 0 0;
}

.tab-content {
    background: white;
    border-radius: 0 0 20px 20px;
}

.breadcrumb {
    background: transparent;
    padding: 0;
}

.breadcrumb-item a {
    text-decoration: none;
    color: #6c757d;
}

.breadcrumb-item.active {
    color: #0d6efd;
    font-weight: 600;
}

.rating-section .stars {
    font-size: 1.2rem;
}

.description-content {
    max-height: 120px;
    overflow: hidden;
    position: relative;
}

.description-content::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 40px;
    background: linear-gradient(transparent, white);
}

@media (max-width: 768px) {
    .book-title {
        font-size: 1.8rem;
    }
    
    .price-section h2 {
        font-size: 2rem;
    }
    
    .book-image-main img {
        height: 350px;
    }
    
    .action-buttons .btn {
        width: 100%;
        margin-bottom: 10px;
    }
}
</style>

<!-- JavaScript -->
<script>
function changeImage(element, src) {
    // Update main image
    document.getElementById('mainBookImage').src = src;
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.classList.remove('active');
    });
    element.classList.add('active');
}

function zoomImage() {
    const src = document.getElementById('mainBookImage').src;
    document.getElementById('zoomedImage').src = src;
    const modal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
    modal.show();
}

function increaseQuantity() {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) < 10) {
        input.value = parseInt(input.value) + 1;
    }
}

function decreaseQuantity() {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

// Add to cart functionality
document.querySelector('.btn-primary').addEventListener('click', function() {
    const quantity = document.getElementById('quantity').value;
    const bookId = <?= $book_id; ?>;
    
    // Show success message
    const toast = document.createElement('div');
    toast.className = 'position-fixed bottom-0 end-0 p-3';
    toast.style.zIndex = '11';
    toast.innerHTML = `
        <div class="toast show" role="alert">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">Success!</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                Added ${quantity} item(s) to cart!
            </div>
        </div>
    `;
    document.body.appendChild(toast);
    
    // Remove toast after 3 seconds
    setTimeout(() => {
        toast.remove();
    }, 3000);
    
    // Here you would typically make an AJAX call to add to cart
    // fetch('add_to_cart.php', { method: 'POST', body: JSON.stringify({book_id, quantity}) })
});
</script>

<?php
include('includes/footer.php');
?>