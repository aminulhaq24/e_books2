<?php
// checkout.php - Complete Checkout Page
session_start();
include('includes/connection.php');

// Check if user is logged in for checkout
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=" . urlencode("checkout.php"));
    exit;
}

// Check if cart is empty
if(!isset($_SESSION['cart']) || empty($_SESSION['cart']['items'])) {
    header("Location: cart.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_items = $_SESSION['cart']['items'];
$subtotal = $_SESSION['cart']['subtotal'];
$total_items = $_SESSION['cart']['total_items'];

// Calculate shipping
$shipping = ($subtotal > 300) ? 0 : 50;
$total = $subtotal + $shipping;

// Process order when form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $state = mysqli_real_escape_string($con, $_POST['state']);
    $postal_code = mysqli_real_escape_string($con, $_POST['postal_code']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $payment_method = mysqli_real_escape_string($con, $_POST['payment_method']);
    $special_instructions = mysqli_real_escape_string($con, $_POST['special_instructions']);
    
    // Generate unique order ID
    $order_id = 'ORD' . date('Ymd') . strtoupper(uniqid());
    
    // Start transaction
    mysqli_begin_transaction($con);
    
    try {
        // 1. Create order
        $order_query = "INSERT INTO orders (
            user_id, order_type, quantity, price, shipping_charges, total_amount,
            payment_method, payment_status, status, shipping_address, delivery_date
        ) VALUES (
            $user_id, 'HARDCOPY', $total_items, $subtotal, $shipping, $total,
            '$payment_method', 'PENDING', 'PENDING', 
            '$address, $city, $state, $postal_code, $country',
            DATE_ADD(NOW(), INTERVAL 7 DAY)
        )";
        
        mysqli_query($con, $order_query);
        $order_db_id = mysqli_insert_id($con);
        
        // 2. Add order items
        foreach($cart_items as $item) {
            if(!$item['is_free']) {
                $item_query = "INSERT INTO order_items (
                    order_id, book_id, format, quantity, price
                ) VALUES (
                    $order_db_id, {$item['book_id']}, 'HARDCOPY', {$item['quantity']}, {$item['price']}
                )";
                mysqli_query($con, $item_query);
            }
        }
        
        // 3. Create payment record
        $payment_query = "INSERT INTO payments (
            order_id, user_id, paid_amount, method
        ) VALUES (
            $order_db_id, $user_id, $total, '$payment_method'
        )";
        mysqli_query($con, $payment_query);
        
        // 4. Update user address if provided
        if(!empty($address)) {
            $update_user = "UPDATE users SET 
                address = '$address',
                phone = '$phone'
                WHERE id = $user_id";
            mysqli_query($con, $update_user);
        }
        
        // Commit transaction
        mysqli_commit($con);
        
        // Clear cart after successful order
        $_SESSION['cart'] = [
            'items' => [],
            'subtotal' => 0,
            'total_items' => 0,
            'session_id' => session_id()
        ];
        
        // Redirect to order confirmation
        header("Location: order-confirmation.php?order_id=$order_db_id");
        exit;
        
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($con);
        $error = "Order failed. Please try again. Error: " . $e->getMessage();
    }
}

// Get user details
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($con, $user_query);
$user = mysqli_fetch_assoc($user_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - ReadSphere</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .checkout-container {
            margin-top: 100px;
        }
        .checkout-header {
            background: linear-gradient(135deg, #2c3e50, #4a6491);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
        }
        .checkout-step {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .step-number {
            width: 30px;
            height: 30px;
            background: #ffd700;
            color: #2c3e50;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }
        .step-active .step-number {
            background: #27ae60;
            color: white;
        }
        .order-summary-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 20px;
            position: sticky;
            top: 20px;
        }
        .checkout-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 30px;
            margin-bottom: 20px;
        }
        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .form-section-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }
        .payment-option {
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .payment-option:hover {
            border-color: #3498db;
            background-color: #f8f9fa;
        }
        .payment-option.selected {
            border-color: #27ae60;
            background-color: #e8f6f3;
        }
        .payment-icon {
            font-size: 24px;
            margin-right: 10px;
            color: #3498db;
        }
        .cart-item-checkout {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .cart-item-checkout:last-child {
            border-bottom: none;
        }
        .cart-item-img {
            width: 50px;
            height: 70px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
        }
        .btn-place-order {
            background: linear-gradient(135deg, #27ae60, #219653);
            color: white;
            font-weight: 600;
            padding: 15px;
            font-size: 1.1rem;
            border: none;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn-place-order:hover {
            background: linear-gradient(135deg, #219653, #1e8449);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(33, 150, 83, 0.3);
        }
        .secure-badge {
            background: #27ae60;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        @media (max-width: 768px) {
            .checkout-container {
                margin-top: 80px;
            }
            .order-summary-card {
                position: static;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    
    
    <div class="container checkout-container">
        <!-- Checkout Header -->
        <div class="checkout-header mb-4">
            <h2 class="mb-3"><i class="fas fa-shopping-cart me-2"></i>Checkout</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="checkout-step step-active">
                        <div class="step-number">1</div>
                        <div>
                            <small>STEP 1</small>
                            <div>Cart Review</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="checkout-step">
                        <div class="step-number">2</div>
                        <div>
                            <small>STEP 2</small>
                            <div>Checkout</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="checkout-step">
                        <div class="step-number">3</div>
                        <div>
                            <small>STEP 3</small>
                            <div>Order Complete</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if(isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <div class="row">
            <!-- Left Column: Checkout Form -->
            <div class="col-lg-8">
                <form method="POST" action="" id="checkoutForm">
                    <!-- Shipping Information -->
                    <div class="checkout-card">
                        <h4 class="form-section-title">
                            <i class="fas fa-shipping-fast me-2"></i>Shipping Information
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="full_name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" 
                                       value="<?php echo htmlspecialchars($user['name']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country *</label>
                                <select class="form-select" id="country" name="country" required>
                                    <option value="">Select Country</option>
                                    <option value="Pakistan" selected>Pakistan</option>
                                    <option value="India">India</option>
                                    <option value="USA">United States</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="UAE">United Arab Emirates</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Complete Address *</label>
                            <textarea class="form-control" id="address" name="address" rows="3" 
                                      required placeholder="Street address, apartment, suite, etc."><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">City *</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">State/Province *</label>
                                <input type="text" class="form-control" id="state" name="state" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="postal_code" class="form-label">Postal Code *</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="checkout-card">
                        <h4 class="form-section-title">
                            <i class="fas fa-credit-card me-2"></i>Payment Method
                        </h4>
                        
                        <div class="payment-options">
                            <div class="payment-option selected" data-method="credit_card">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" 
                                           id="credit_card" value="credit_card" checked>
                                    <label class="form-check-label d-flex align-items-center" for="credit_card">
                                        <i class="fas fa-credit-card payment-icon"></i>
                                        <div>
                                            <strong>Credit/Debit Card</strong>
                                            <div class="text-muted small">Pay with Visa, MasterCard, etc.</div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            
                            
                            <div class="payment-option" data-method="cash_on_delivery">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" 
                                           id="cash_on_delivery" value="cash_on_delivery">
                                    <label class="form-check-label d-flex align-items-center" for="cash_on_delivery">
                                        <i class="fas fa-money-bill-wave payment-icon"></i>
                                        <div>
                                            <strong>Cash on Delivery</strong>
                                            <div class="text-muted small">Pay when you receive the order</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="payment-option" data-method="bank_transfer">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" 
                                           id="bank_transfer" value="bank_transfer">
                                    <label class="form-check-label d-flex align-items-center" for="bank_transfer">
                                        <i class="fas fa-university payment-icon"></i>
                                        <div>
                                            <strong>Bank Transfer</strong>
                                            <div class="text-muted small">Transfer directly to our bank account</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="payment-option" data-method="jazzcash">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" 
                                           id="jazzcash" value="jazzcash">
                                    <label class="form-check-label d-flex align-items-center" for="jazzcash">
                                        <i class="fas fa-mobile-alt payment-icon"></i>
                                        <div>
                                            <strong>JazzCash</strong>
                                            <div class="text-muted small">Mobile wallet payment</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card Details (shown only for credit card) -->
                        <div id="cardDetails" class="mt-4">
                            <h6 class="mb-3">Card Details</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="card_number" class="form-label">Card Number</label>
                                    <input type="text" class="form-control" id="card_number" 
                                           placeholder="1234 5678 9012 3456" maxlength="19">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="expiry_date" class="form-label">Expiry Date</label>
                                    <input type="text" class="form-control" id="expiry_date" 
                                           placeholder="MM/YY" maxlength="5">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control" id="cvv" 
                                           placeholder="123" maxlength="3">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="card_holder" class="form-label">Card Holder Name</label>
                                <input type="text" class="form-control" id="card_holder" 
                                       placeholder="Name on card">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Special Instructions -->
                    <div class="checkout-card">
                        <h4 class="form-section-title">
                            <i class="fas fa-edit me-2"></i>Additional Information
                        </h4>
                        <div class="mb-3">
                            <label for="special_instructions" class="form-label">Special Instructions (Optional)</label>
                            <textarea class="form-control" id="special_instructions" name="special_instructions" 
                                      rows="3" placeholder="Any special delivery instructions or notes..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Right Column: Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary-card">
                    <h4 class="mb-4">Order Summary</h4>
                    
                    <!-- Cart Items -->
                    <div class="mb-4">
                        <h6 class="mb-3">Items (<?php echo $total_items; ?>)</h6>
                        <div class="cart-items-list">
                            <?php foreach($cart_items as $item): ?>
                            <div class="cart-item-checkout">
                                <img src="../admin_panel/uploads/<?php echo $item['cover_image']; ?>" 
                                     alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                     class="cart-item-img"
                                     onerror="this.src='img/default-book.jpg'">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1" style="font-size: 0.9rem;">
                                            <?php echo htmlspecialchars($item['title']); ?>
                                        </h6>
                                        <span class="text-primary fw-bold">
                                            <?php if($item['is_free']): ?>
                                                FREE
                                            <?php else: ?>
                                                $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <small class="text-muted d-block">Qty: <?php echo $item['quantity']; ?></small>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Price Breakdown -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
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
                        <?php if($shipping != 0 && $subtotal > 0): ?>
                        <div class="alert alert-info p-2 mb-2">
                            <small>
                                <i class="fas fa-info-circle me-1"></i>
                                Spend $<?php echo number_format(301 - $subtotal, 2); ?> more for free shipping!
                            </small>
                        </div>
                        <?php endif; ?>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total</strong>
                            <strong class="text-primary">$<?php echo number_format($total, 2); ?></strong>
                        </div>
                    </div>
                    
                    <!-- Security & Terms -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-shield-alt text-success me-2"></i>
                            <div>
                                <small class="d-block">Secure Checkout</small>
                                <small class="text-muted">SSL encrypted payment</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-lock text-warning me-2"></i>
                            <div>
                                <small class="d-block">Privacy Protected</small>
                                <small class="text-muted">Your data is safe with us</small>
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="agree_terms" required>
                            <label class="form-check-label" for="agree_terms" style="font-size: 0.9rem;">
                                I agree to the <a href="terms.php" target="_blank">Terms & Conditions</a> 
                                and <a href="privacy.php" target="_blank">Privacy Policy</a>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Place Order Button -->
                    <button type="submit" form="checkoutForm" class="btn-place-order mb-3">
                        <i class="fas fa-lock me-2"></i> Place Order
                    </button>
                    
                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-undo me-1"></i>
                            <a href="cart.php" class="text-decoration-none">Return to cart</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    // Payment option selection
    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', function() {
            // Remove selected class from all options
            document.querySelectorAll('.payment-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            
            // Add selected class to clicked option
            this.classList.add('selected');
            
            // Check the radio button
            const radioBtn = this.querySelector('input[type="radio"]');
            radioBtn.checked = true;
            
            // Show/hide card details
            const method = this.getAttribute('data-method');
            const cardDetails = document.getElementById('cardDetails');
            
            if(method === 'credit_card') {
                cardDetails.style.display = 'block';
            } else {
                cardDetails.style.display = 'none';
            }
        });
    });
    
    // Format card number
    document.getElementById('card_number').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        let matches = value.match(/\d{4,16}/g);
        let match = matches && matches[0] || '';
        let parts = [];
        
        for(let i=0; i<match.length; i+=4) {
            parts.push(match.substring(i, i+4));
        }
        
        if(parts.length) {
            e.target.value = parts.join(' ');
        } else {
            e.target.value = value;
        }
    });
    
    // Format expiry date
    document.getElementById('expiry_date').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        
        if(value.length >= 2) {
            e.target.value = value.substring(0,2) + '/' + value.substring(2,4);
        }
    });
    
    // Only numbers for CVV
    document.getElementById('cvv').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^0-9]/gi, '');
    });
    
    // Form validation
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const termsChecked = document.getElementById('agree_terms').checked;
        
        if(!termsChecked) {
            e.preventDefault();
            alert('Please agree to the Terms & Conditions to proceed.');
            return false;
        }
        
        // Check payment method specific validations
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        
        if(paymentMethod === 'credit_card') {
            const cardNumber = document.getElementById('card_number').value.replace(/\s/g, '');
            const expiryDate = document.getElementById('expiry_date').value;
            const cvv = document.getElementById('cvv').value;
            const cardHolder = document.getElementById('card_holder').value;
            
            if(cardNumber.length < 16 || !/^\d+$/.test(cardNumber)) {
                e.preventDefault();
                alert('Please enter a valid 16-digit card number.');
                return false;
            }
            
            if(!expiryDate.match(/^(0[1-9]|1[0-2])\/\d{2}$/)) {
                e.preventDefault();
                alert('Please enter a valid expiry date (MM/YY).');
                return false;
            }
            
            if(cvv.length < 3 || !/^\d+$/.test(cvv)) {
                e.preventDefault();
                alert('Please enter a valid 3-digit CVV.');
                return false;
            }
            
            if(cardHolder.trim().length < 3) {
                e.preventDefault();
                alert('Please enter card holder name.');
                return false;
            }
        }
        
        // Show loading
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing Order...';
        submitBtn.disabled = true;
        
        // Allow form submission
        return true;
    });
    
    // Auto-fill city based on postal code (example for Pakistan)
    document.getElementById('postal_code').addEventListener('blur', function() {
        const postalCode = this.value.trim();
        const cityField = document.getElementById('city');
        const stateField = document.getElementById('state');
        
        if(postalCode.length > 0) {
            // Example mapping for Pakistan
            const cityMap = {
                '74': 'Karachi',
                '54': 'Lahore',
                '44': 'Islamabad',
                '75': 'Faisalabad',
                '60': 'Rawalpindi'
            };
            
            const prefix = postalCode.substring(0, 2);
            if(cityMap[prefix]) {
                cityField.value = cityMap[prefix];
                stateField.value = 'Sindh'; // Default
                if(['54', '75', '60'].includes(prefix)) {
                    stateField.value = 'Punjab';
                } else if(prefix === '44') {
                    stateField.value = 'Federal Capital';
                }
            }
        }
    });
    </script>
</body>
</html>