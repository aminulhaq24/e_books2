<?php
// book-actions.php - Reusable action buttons component
include('includes/connection.php');
?>
<div class="book-price-section">
    <?php if($book['price'] == 0 || $book['is_free_for_members'] == 1): ?>
        <div class="free-badge-large">
            <i class="fas fa-gift me-2"></i> FREE BOOK
        </div>
    <?php else: ?>
        <div class="book-price">
            $<?php echo number_format($book['price'], 2); ?>
        </div>
    <?php endif; ?>
    
    <div class="action-buttons">
        <?php if($book['price'] == 0 || $book['is_free_for_members'] == 1): ?>
            <?php if(isset($_SESSION['user_id'])): ?>
            <a href="download.php?id=<?php echo $book['book_id']; ?>" 
               class="btn btn-success btn-lg-custom">
                <i class="fas fa-download me-2"></i> Download Now
            </a>
            <?php else: ?>
            <a href="login.php?redirect=book-detail.php?id=<?php echo $book_id; ?>" 
               class="btn btn-success btn-lg-custom">
                <i class="fas fa-download me-2"></i> Login to Download
            </a>
            <?php endif; ?>
        <?php else: ?>
            <button class="btn btn-primary btn-lg-custom add-to-cart-main" 
                    data-id="<?php echo $book['book_id']; ?>"
                    data-title="<?php echo htmlspecialchars($book['title']); ?>">
                <i class="fas fa-cart-plus me-2"></i> Add to Cart
            </button>
            <button class="btn btn-outline-primary btn-lg-custom buy-now-btn"
                    data-id="<?php echo $book['book_id']; ?>">
                <i class="fas fa-bolt me-2"></i> Buy Now
            </button>
        <?php endif; ?>
    </div>
</div>