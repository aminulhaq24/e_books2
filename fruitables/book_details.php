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
?>

<!-- Book Detail Page -->
<div class="container py-5 mmm">
    <div class="row g-5">
        
        <!-- LEFT: Book Image Carousel -->
        <div class="col-lg-4 mx-5">
            <div class="book-image">
                <img src="../admin_panel/uploads/<?= $book['cover_image']; ?>" class="img-fluid rounded" alt="<?= $book['title']; ?>">
            </div>
        </div>
        
        <!-- RIGHT: Book Details -->
        <div class="col-lg-5">
            <h1 class="fw-bold mb-3"><?= $book['title']; ?></h1>
            
            <p class="text-muted mb-2">
                 <?= $book['category_name']; ?> |
                 <?= $book['subcategory_name']; ?>
                </p>
                
                <h3 class=" fw-bold mb-3">Rs <?= number_format($book['price']); ?></h3>
                
            <div class="mb-4">
                
                <p class="text-secondary"><?= nl2br($book['description']); ?></p>
            </div>
            
            <div class="mb-3">
                <button class="btn btn-primary btn-lg rounded-pill me-3"><i class="fa fa-shopping-cart me-2"></i> Add to Cart</button>
                <button class="btn btn-outline-secondary btn-lg rounded-pill"><i class="fa fa-heart me-2"></i> Wishlist</button>
            </div>
            
            <!-- Additional Info -->
            <div class="mt-4">
                <span class="badge bg-success me-2">Best Seller</span>
                <span class="badge bg-info me-2">Free Shipping</span>
                <span class="badge bg-warning text-dark">Limited Stock</span>
            </div>
        </div>

    </div>
</div>

<!-- Custom CSS -->
<style>

   /*  Push below navbar and add spacing */ 
.mmm {
    margin-top: 170px; /* adjust if your navbar height is different */
}

.book-image img {
    max-height: 350px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.book-image img:hover {
    transform: scale(1.05);
}

.btn-lg {
    padding: 12px 25px;
    font-size: 16px;
}

.badge {
    font-size: 14px;
    padding: 8px 12px;
}
</style>

<?php
include('includes/footer.php');
?>
