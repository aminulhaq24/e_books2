<?php
// order_details.php




$order_id = intval($_GET['id'] ?? 0);

if($order_id == 0) {
    header("Location: orders_list.php");
    exit();
}

include 'includes/nav.php';
// Fetch order details
$order_query = "SELECT o.*, u.name as customer_name, u.email as customer_email, 
                       u.address as customer_address, u.contact as customer_contact
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                WHERE o.id = $order_id";
$order_result = mysqli_query($conn, $order_query);
$order = mysqli_fetch_assoc($order_result);

if(!$order) {
    die("Order not found!");
}

// Fetch order items
$items_query = "SELECT oi.*, b.title as book_title, b.author as book_author, 
                       b.cover_image, b.format_type as book_format
                FROM order_items oi 
                LEFT JOIN books b ON oi.book_id = b.book_id 
                WHERE oi.order_id = $order_id";
$items_result = mysqli_query($conn, $items_query);

// Fetch payment details
$payment_query = "SELECT * FROM payments WHERE order_id = $order_id ORDER BY paid_at DESC LIMIT 1";
$payment_result = mysqli_query($conn, $payment_query);
$payment = mysqli_fetch_assoc($payment_result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Details #<?php echo $order_id; ?> - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .detail-card {
            border-left: 4px solid;
            margin-bottom: 20px;
        }
        .detail-card.success { border-color: #28a745; }
        .detail-card.warning { border-color: #ffc107; }
        .detail-card.info { border-color: #17a2b8; }
        .detail-card.primary { border-color: #007bff; }
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        .timeline:before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #dee2e6;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }
        .timeline-item:before {
            content: '';
            position: absolute;
            left: -25px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #6c757d;
        }
        .timeline-item.success:before { background: #28a745; }
        .timeline-item.primary:before { background: #007bff; }
        .timeline-item.warning:before { background: #ffc107; }
    </style>

    
    
    <div class="container-fluid mt-4">
        <!-- Order Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>
                    <i class="fas fa-shopping-cart"></i> 
                    Order Details #<?php echo str_pad($order_id, 6, '0', STR_PAD_LEFT); ?>
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="orders_dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="orders_list.php">All Orders</a></li>
                        <li class="breadcrumb-item active">Order Details</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="update_order_status.php?id=<?php echo $order_id; ?>" 
                   class="btn btn-warning">
                    <i class="fas fa-edit"></i> Update Status
                </a>
                <a href="generate_invoice.php?id=<?php echo $order_id; ?>" 
                   target="_blank" class="btn btn-success">
                    <i class="fas fa-file-invoice"></i> Generate Invoice
                </a>
                <a href="orders_list.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>
        
        <!-- Alert Messages -->
        <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> <?php echo $_GET['success']; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif; ?>
        
        <div class="row">
            <!-- Left Column - Order Information -->
            <div class="col-md-8">
                <!-- Order Items -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-boxes"></i> Order Items</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Book</th>
                                        <th>Format</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $item_counter = 1;
                                    $items_total = 0;
                                    while($item = mysqli_fetch_assoc($items_result)): 
                                        $subtotal = $item['price'] * $item['quantity'];
                                        $items_total += $subtotal;
                                    ?>
                                    <tr>
                                        <td><?php echo $item_counter++; ?></td>
                                        <td>
                                            <strong><?php echo $item['book_title']; ?></strong><br>
                                            <small class="text-muted">By: <?php echo $item['book_author']; ?></small>
                                        </td>
                                        <td>
                                            <span class="badge badge-info"><?php echo $item['format']; ?></span>
                                        </td>
                                        <td><?php echo $item['quantity']; ?></td>
                                        <td>₨<?php echo number_format($item['price'], 2); ?></td>
                                        <td>₨<?php echo number_format($subtotal, 2); ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                    
                                    <!-- Summary Row -->
                                    <tr>
                                        <td colspan="5" class="text-right"><strong>Items Total:</strong></td>
                                        <td><strong>₨<?php echo number_format($items_total, 2); ?></strong></td>
                                    </tr>
                                    <?php if($order['shipping_charges'] > 0): ?>
                                    <tr>
                                        <td colspan="5" class="text-right"><strong>Shipping Charges:</strong></td>
                                        <td>₨<?php echo number_format($order['shipping_charges'], 2); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr class="table-active">
                                        <td colspan="5" class="text-right"><strong>Grand Total:</strong></td>
                                        <td><strong>₨<?php echo number_format($order['total_amount'], 2); ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Order Timeline -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-history"></i> Order Timeline</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item success">
                                <strong>Order Placed</strong>
                                <div class="text-muted"><?php echo date('d M Y h:i A', strtotime($order['placed_at'])); ?></div>
                            </div>
                            
                            <?php if($order['status'] == 'CONFIRMED' || $order['status'] == 'PROCESSING' || 
                                    $order['status'] == 'SHIPPED' || $order['status'] == 'DELIVERED'): ?>
                            <div class="timeline-item primary">
                                <strong>Order Confirmed</strong>
                                <div class="text-muted"><?php echo date('d M Y'); ?></div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($order['status'] == 'PROCESSING' || $order['status'] == 'SHIPPED' || 
                                    $order['status'] == 'DELIVERED'): ?>
                            <div class="timeline-item primary">
                                <strong>Processing Started</strong>
                                <div class="text-muted">Processing your order</div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($order['status'] == 'SHIPPED' || $order['status'] == 'DELIVERED'): ?>
                            <div class="timeline-item warning">
                                <strong>Order Shipped</strong>
                                <?php if($order['tracking_number']): ?>
                                <div>Tracking: <?php echo $order['tracking_number']; ?></div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($order['status'] == 'DELIVERED'): ?>
                            <div class="timeline-item success">
                                <strong>Order Delivered</strong>
                                <?php if($order['delivery_date']): ?>
                                <div class="text-muted">Delivered on: <?php echo date('d M Y', strtotime($order['delivery_date'])); ?></div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($order['status'] == 'CANCELLED'): ?>
                            <div class="timeline-item danger">
                                <strong>Order Cancelled</strong>
                                <div class="text-muted">Cancelled by <?php echo $order['cancelled_by'] ?? 'system'; ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Order Summary -->
            <div class="col-md-4">
                <!-- Order Status Card -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Order Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <?php
                            $status_colors = [
                                'PENDING' => 'warning',
                                'CONFIRMED' => 'info',
                                'PROCESSING' => 'primary',
                                'SHIPPED' => 'secondary',
                                'DELIVERED' => 'success',
                                'CANCELLED' => 'danger'
                            ];
                            ?>
                            <span class="badge badge-pill badge-<?php echo $status_colors[$order['status']]; ?> p-3" 
                                  style="font-size: 1.2rem;">
                                <?php echo $order['status']; ?>
                            </span>
                        </div>
                        
                        <dl class="row mb-0">
                            <dt class="col-sm-6">Order ID:</dt>
                            <dd class="col-sm-6">#<?php echo str_pad($order_id, 6, '0', STR_PAD_LEFT); ?></dd>
                            
                            <dt class="col-sm-6">Order Date:</dt>
                            <dd class="col-sm-6"><?php echo date('d M Y', strtotime($order['placed_at'])); ?></dd>
                            
                            <dt class="col-sm-6">Order Type:</dt>
                            <dd class="col-sm-6"><?php echo $order['order_type']; ?></dd>
                            
                            <?php if($order['delivery_date']): ?>
                            <dt class="col-sm-6">Delivery Date:</dt>
                            <dd class="col-sm-6"><?php echo date('d M Y', strtotime($order['delivery_date'])); ?></dd>
                            <?php endif; ?>
                            
                            <?php if($order['tracking_number']): ?>
                            <dt class="col-sm-6">Tracking No:</dt>
                            <dd class="col-sm-6">
                                <code><?php echo $order['tracking_number']; ?></code>
                                <?php if(strpos($order['tracking_number'], 'TRK') === 0): ?>
                                <a href="#" class="btn btn-sm btn-link">Track</a>
                                <?php endif; ?>
                            </dd>
                            <?php endif; ?>
                        </dl>
                    </div>
                </div>
                
                <!-- Payment Information -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-credit-card"></i> Payment Information</h5>
                    </div>
                    <div class="card-body">
                        <?php if($payment): ?>
                        <dl class="row mb-0">
                            <dt class="col-sm-6">Payment Status:</dt>
                            <dd class="col-sm-6">
                                <span class="badge badge-<?php 
                                    echo $order['payment_status'] == 'PAID' ? 'success' : 
                                         ($order['payment_status'] == 'PENDING' ? 'warning' : 'danger'); 
                                ?>">
                                    <?php echo $order['payment_status']; ?>
                                </span>
                            </dd>
                            
                            <dt class="col-sm-6">Payment Method:</dt>
                            <dd class="col-sm-6"><?php echo $order['payment_method'] ?? 'N/A'; ?></dd>
                            
                            <?php if($payment['paid_amount']): ?>
                            <dt class="col-sm-6">Paid Amount:</dt>
                            <dd class="col-sm-6">₨<?php echo number_format($payment['paid_amount'], 2); ?></dd>
                            <?php endif; ?>
                            
                            <?php if($payment['transaction_ref']): ?>
                            <dt class="col-sm-6">Transaction Ref:</dt>
                            <dd class="col-sm-6">
                                <small><code><?php echo $payment['transaction_ref']; ?></code></small>
                            </dd>
                            <?php endif; ?>
                            
                            <?php if($payment['paid_at']): ?>
                            <dt class="col-sm-6">Payment Date:</dt>
                            <dd class="col-sm-6"><?php echo date('d M Y h:i A', strtotime($payment['paid_at'])); ?></dd>
                            <?php endif; ?>
                        </dl>
                        <?php else: ?>
                        <p class="text-muted">No payment information available</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Customer Information -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-user"></i> Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <?php if($order['customer_name']): ?>
                        <h6><?php echo $order['customer_name']; ?></h6>
                        <p class="mb-1">
                            <i class="fas fa-envelope"></i> 
                            <a href="mailto:<?php echo $order['customer_email']; ?>">
                                <?php echo $order['customer_email']; ?>
                            </a>
                        </p>
                        
                        <?php if($order['customer_contact']): ?>
                        <p class="mb-1">
                            <i class="fas fa-phone"></i> 
                            <a href="tel:<?php echo $order['customer_contact']; ?>">
                                <?php echo $order['customer_contact']; ?>
                            </a>
                        </p>
                        <?php endif; ?>
                        
                        <?php if($order['customer_address']): ?>
                        <p class="mb-0">
                            <i class="fas fa-map-marker-alt"></i> 
                            <?php echo $order['customer_address']; ?>
                        </p>
                        <?php endif; ?>
                        <?php else: ?>
                        <p class="text-muted">Guest Customer</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Shipping Address -->
                <?php if($order['shipping_address']): ?>
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-truck"></i> Shipping Address</h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo nl2br($order['shipping_address']); ?></p>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-bolt"></i> Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="update_order_status.php?id=<?php echo $order_id; ?>" 
                               class="btn btn-warning">
                                <i class="fas fa-edit"></i> Update Status
                            </a>
                            <a href="generate_invoice.php?id=<?php echo $order_id; ?>" 
                               target="_blank" class="btn btn-success">
                                <i class="fas fa-file-invoice"></i> Print Invoice
                            </a>
                            <a href="send_email.php?order_id=<?php echo $order_id; ?>" 
                               class="btn btn-info">
                                <i class="fas fa-envelope"></i> Email Customer
                            </a>
                            <?php if($order['status'] == 'PENDING'): ?>
                            <a href="cancel_order.php?id=<?php echo $order_id; ?>" 
                               class="btn btn-danger"
                               onclick="return confirm('Are you sure you want to cancel this order?')">
                                <i class="fas fa-times"></i> Cancel Order
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    
    <script>
    // Print invoice
    function printInvoice() {
        window.open('generate_invoice.php?id=<?php echo $order_id; ?>', '_blank');
    }
    
    // Update status
    function updateStatus(newStatus) {
        if(confirm('Change order status to ' + newStatus + '?')) {
            window.location.href = 'update_order_action.php?id=<?php echo $order_id; ?>&status=' + newStatus;
        }
    }
    </script>
