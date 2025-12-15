<?php
// cart.php - Shopping Cart Page

include('includes/nav.php');


$page_title = "Shopping Cart | ReadSphere";

// If cart is empty, show empty cart
if(!isset($_SESSION['cart']) || empty($_SESSION['cart']['items'])) {
    $empty_cart = true;
} else {
    $cart_items = $_SESSION['cart']['items'];
    $subtotal = $_SESSION['cart']['subtotal'];
    $total_items = $_SESSION['cart']['total_items'];
    
    // Calculate shipping
    $shipping = ($subtotal > 300) ? 0 : 50;
    $total = $subtotal + $shipping;
}
?>


    
    <div class="container py-5 mt-5">
        <h2 class="mb-4">Shopping Cart</h2>
        
        <?php if(isset($empty_cart)): ?>
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
            <h4>Your cart is empty</h4>
            <p class="text-muted mb-4">Add some books to get started!</p>
            <a href="shop.php" class="btn btn-primary">
                <i class="fas fa-book me-2"></i> Browse Books
            </a>
        </div>
        <?php else: ?>
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Book</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($cart_items as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="../admin_panel/uploads/<?php echo $item['cover_image']; ?>" 
                                                     alt="<?php echo $item['title']; ?>"
                                                     style="width: 60px; height: 80px; object-fit: cover; margin-right: 15px;">
                                                <div>
                                                    <h6 class="mb-1"><?php echo $item['title']; ?></h6>
                                                    <small class="text-muted">
                                                        <?php echo $item['is_free'] ? 'Free Book' : 'Paid Book'; ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($item['is_free']): ?>
                                                <span class="text-success">FREE</span>
                                            <?php else: ?>
                                                $<?php echo number_format($item['price'], 2); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="quantity-selector">
                                                <button class="btn btn-sm btn-outline-secondary decrease-qty" 
                                                        data-id="<?php echo $item['book_id']; ?>">-</button>
                                                <span class="mx-2 qty-display" data-id="<?php echo $item['book_id']; ?>">
                                                    <?php echo $item['quantity']; ?>
                                                </span>
                                                <button class="btn btn-sm btn-outline-secondary increase-qty"
                                                        data-id="<?php echo $item['book_id']; ?>">+</button>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($item['is_free']): ?>
                                                FREE
                                            <?php else: ?>
                                                $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-danger remove-item" 
                                                    data-id="<?php echo $item['book_id']; ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="shop.php" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                    </a>
                    <button class="btn btn-outline-danger" id="clear-cart">
                        <i class="fas fa-trash me-2"></i> Clear Cart
                    </button>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Order Summary</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal (<?php echo $total_items; ?> items)</span>
                            <span>$<?php echo number_format($subtotal, 2); ?></span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <span>
                                <?php if($shipping == 0): ?>
                                    <span class="text-success">FREE</span>
                                <?php else: ?>
                                    $<?php echo number_format($shipping, 2); ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <strong>$<?php echo number_format($total, 2); ?></strong>
                        </div>
                        
                        <a href="checkout.php" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-lock me-2"></i> Proceed to Checkout
                        </a>
                        
                        <div class="mt-3 text-center">
                            <small class="text-muted">
                                <i class="fas fa-lock me-1"></i> Secure checkout
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php
    include('includes/footer.php');
    ?>
    
    <script>
    // Cart page JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        // Update quantity
        document.querySelectorAll('.increase-qty').forEach(btn => {
            btn.addEventListener('click', function() {
                const bookId = this.getAttribute('data-id');
                updateQuantity(bookId, 'increase');
            });
        });
        
        document.querySelectorAll('.decrease-qty').forEach(btn => {
            btn.addEventListener('click', function() {
                const bookId = this.getAttribute('data-id');
                updateQuantity(bookId, 'decrease');
            });
        });
        
        // Remove item
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', function() {
                const bookId = this.getAttribute('data-id');
                removeItem(bookId);
            });
        });
        
        // Clear cart
        document.getElementById('clear-cart').addEventListener('click', function() {
            if(confirm('Are you sure you want to clear your cart?')) {
                clearCart();
            }
        });
    });
    
    function updateQuantity(bookId, action) {
        fetch('add-to-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `book_id=${bookId}&action=update&quantity=${getNewQuantity(bookId, action)}`
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload(); // Reload page to show updated totals
            }
        });
    }
    
    function removeItem(bookId) {
        fetch('add-to-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `book_id=${bookId}&action=remove`
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            }
        });
    }
    
    function clearCart() {
        fetch('add-to-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=clear`
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            }
        });
    }
    
    function getNewQuantity(bookId, action) {
        const qtyElement = document.querySelector(`.qty-display[data-id="${bookId}"]`);
        let currentQty = parseInt(qtyElement.textContent);
        
        if(action === 'increase') {
            return currentQty + 1;
        } else {
            return Math.max(1, currentQty - 1);
        }
    }
    </script>
