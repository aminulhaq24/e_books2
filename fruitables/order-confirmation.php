<?php
// order-confirmation.php
session_start();
include('includes/connection.php');

if(!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit;
}

$order_id = (int)$_GET['order_id'];
$user_id = $_SESSION['user_id'];

// Fetch order details
$order_query = "SELECT o.*, u.name, u.email, u.phone 
                FROM orders o 
                JOIN users u ON o.user_id = u.id 
                WHERE o.id = $order_id AND o.user_id = $user_id";
$order_result = mysqli_query($con, $order_query);

if(mysqli_num_rows($order_result) == 0) {
    header("Location: index.php");
    exit;
}

$order = mysqli_fetch_assoc($order_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation - ReadSphere</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .confirmation-container {
            margin-top: 120px;
            max-width: 800px;
        }
        .success-icon {
            width: 80px;
            height: 80px;
            background: #27ae60;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 20px;
        }
        .order-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-top: 30px;
        }
        .order-id {
            background: #2c3e50;
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 1.2rem;
            font-weight: bold;
            display: inline-block;
        }
        .next-steps {
            background: #e8f6f3;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
        }
        .step-icon {
            width: 40px;
            height: 40px;
            background: #27ae60;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
    </style>
</head>
<body>
   
    
    <div class="container confirmation-container">
        <div class="text-center">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            <h1 class="mb-3">Order Confirmed!</h1>
            <p class="lead text-muted mb-4">Thank you for your purchase. Your order has been received.</p>
            <div class="order-id mb-4">ORDER #<?php echo str_pad($order_id, 6, '0', STR_PAD_LEFT); ?></div>
        </div>
        
        <div class="order-card">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">Order Details</h5>
                    <div class="mb-2">
                        <strong>Order Date:</strong> 
                        <?php echo date('F d, Y', strtotime($order['placed_at'])); ?>
                    </div>
                    <div class="mb-2">
                        <strong>Payment Method:</strong> 
                        <?php echo ucwords(str_replace('_', ' ', $order['payment_method'])); ?>
                    </div>
                    <div class="mb-2">
                        <strong>Payment Status:</strong>
                        <span class="badge bg-<?php echo $order['payment_status'] == 'PAID' ? 'success' : 'warning'; ?>">
                            <?php echo $order['payment_status']; ?>
                        </span>
                    </div>
                    <div class="mb-2">
                        <strong>Order Status:</strong>
                        <span class="badge bg-info"><?php echo $order['status']; ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3">Amount Paid</h5>
                    <div class="display-4 text-primary mb-3">
                        $<?php echo number_format($order['total_amount'], 2); ?>
                    </div>
                    <div class="text-muted">
                        Includes shipping: $<?php echo number_format($order['shipping_charges'], 2); ?>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <h5 class="mb-3">Shipping Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <strong>Name:</strong> <?php echo htmlspecialchars($order['name']); ?><br>
                    <strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?><br>
                    <strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?>
                </div>
                <div class="col-md-6">
                    <strong>Address:</strong><br>
                    <?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?>
                </div>
            </div>
        </div>
        
        <div class="next-steps">
            <h5 class="mb-4">What's Next?</h5>
            <div class="d-flex align-items-center mb-3">
                <div class="step-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <strong>Order Confirmation Email</strong>
                    <div class="text-muted">We've sent a confirmation email to <?php echo $order['email']; ?></div>
                </div>
            </div>
            <div class="d-flex align-items-center mb-3">
                <div class="step-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <div>
                    <strong>Order Processing</strong>
                    <div class="text-muted">Your order is being processed and will be shipped soon</div>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="step-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div>
                    <strong>Delivery</strong>
                    <div class="text-muted">Expected delivery: <?php echo date('F d, Y', strtotime($order['delivery_date'])); ?></div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="orders.php" class="btn btn-primary btn-lg me-3">
                <i class="fas fa-clipboard-list me-2"></i> View My Orders
            </a>
            <a href="shop.php" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-book me-2"></i> Continue Shopping
            </a>
        </div>
    </div>
</body>
</html>