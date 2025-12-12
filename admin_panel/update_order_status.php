<?php
// update_order_status.php


// Admin check
// if(!isset($_SESSION['admin_id'])) {
    //     header("Location: login.php");
    //     exit();
    // }

    $order_id = intval($_GET['id'] ?? 0);
    
    if($order_id == 0) {
        header("Location: orders_list.php");
        exit();
    }
    
    include 'includes/nav.php';
// Fetch order details
$order = mysqli_fetch_assoc(mysqli_query($conn, 
    "SELECT * FROM orders WHERE id = $order_id"));

if(!$order) {
    die("Order not found!");
}

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes'] ?? '');
    $tracking_number = mysqli_real_escape_string($conn, $_POST['tracking_number'] ?? '');
    
    // Update query
    $update_sql = "UPDATE orders SET 
        status = '$new_status',
        tracking_number = '$tracking_number',
        updated_at = NOW()";
    
    // If status is DELIVERED, set delivery date
    if($new_status == 'DELIVERED') {
        $update_sql .= ", delivery_date = CURDATE()";
    }
    
    $update_sql .= " WHERE id = $order_id";
    
    if(mysqli_query($conn, $update_sql)) {
        // Log status change
        $log_sql = "INSERT INTO order_status_history 
                   (order_id, status, updated_by, notes) 
                   VALUES ($order_id, '$new_status', 'admin', '$notes')";
        mysqli_query($conn, $log_sql);
        
        $_SESSION['success'] = "Order status updated successfully!";
        header("Location: order_details.php?id=$order_id&success=Status+Updated");
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

    
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-edit"></i> Update Order Status
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Order Info -->
                        <div class="alert alert-info">
                            <h6>Order #<?php echo str_pad($order_id, 6, '0', STR_PAD_LEFT); ?></h6>
                            <p class="mb-0">
                                Customer: <strong><?php echo "User ID: " . $order['user_id']; ?></strong><br>
                                Current Status: 
                                <span class="badge badge-<?php 
                                    echo $order['status'] == 'PENDING' ? 'warning' : 
                                         ($order['status'] == 'DELIVERED' ? 'success' : 'primary');
                                ?>">
                                    <?php echo $order['status']; ?>
                                </span>
                            </p>
                        </div>
                        
                        <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <!-- Update Form -->
                        <form method="POST">
                            <div class="form-group">
                                <label>Select New Status *</label>
                                <select name="status" class="form-control" required>
                                    <option value="PENDING" <?php echo $order['status']=='PENDING'?'selected':''; ?>>Pending</option>
                                    <option value="CONFIRMED" <?php echo $order['status']=='CONFIRMED'?'selected':''; ?>>Confirmed</option>
                                    <option value="PROCESSING" <?php echo $order['status']=='PROCESSING'?'selected':''; ?>>Processing</option>
                                    <option value="SHIPPED" <?php echo $order['status']=='SHIPPED'?'selected':''; ?>>Shipped</option>
                                    <option value="DELIVERED" <?php echo $order['status']=='DELIVERED'?'selected':''; ?>>Delivered</option>
                                    <option value="CANCELLED" <?php echo $order['status']=='CANCELLED'?'selected':''; ?>>Cancelled</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Tracking Number (Optional)</label>
                                <input type="text" name="tracking_number" 
                                       value="<?php echo $order['tracking_number'] ?? ''; ?>"
                                       class="form-control" 
                                       placeholder="Enter tracking number">
                            </div>
                            
                            <div class="form-group">
                                <label>Notes (Optional)</label>
                                <textarea name="notes" class="form-control" 
                                          rows="3" 
                                          placeholder="Add any notes about this status change"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-warning btn-block">
                                    <i class="fas fa-save"></i> Update Status
                                </button>
                                <a href="order_details.php?id=<?php echo $order_id; ?>" 
                                   class="btn btn-secondary btn-block">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
