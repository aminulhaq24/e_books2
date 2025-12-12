<?php
// orders_list.php
include 'includes/nav.php';


if(!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Filters
$filter_status = $_GET['status'] ?? '';
$filter_payment = $_GET['payment'] ?? '';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';

// Build query
$where = "1=1";
if($filter_status) $where .= " AND o.status = '$filter_status'";
if($filter_payment) $where .= " AND o.payment_status = '$filter_payment'";
if($date_from) $where .= " AND DATE(o.placed_at) >= '$date_from'";
if($date_to) $where .= " AND DATE(o.placed_at) <= '$date_to'";

$query = "SELECT o.*, u.name as customer_name, u.email as customer_email 
          FROM orders o 
          LEFT JOIN users u ON o.user_id = u.id 
          WHERE $where 
          ORDER BY o.placed_at DESC";

$orders = mysqli_query($con, $query);
$total_orders = mysqli_num_rows($orders);
?>

    
    
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-shopping-cart"></i> All Orders (<?php echo $total_orders; ?>)</h2>
            <div>
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print"></i> Print Report
                </button>
                <a href="orders_dashboard.php" class="btn btn-secondary">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </div>
        </div>
        
        <!-- Filter Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Orders</h5>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label>Order Status</label>
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="PENDING" <?php echo $filter_status=='PENDING'?'selected':''; ?>>Pending</option>
                            <option value="CONFIRMED" <?php echo $filter_status=='CONFIRMED'?'selected':''; ?>>Confirmed</option>
                            <option value="PROCESSING" <?php echo $filter_status=='PROCESSING'?'selected':''; ?>>Processing</option>
                            <option value="SHIPPED" <?php echo $filter_status=='SHIPPED'?'selected':''; ?>>Shipped</option>
                            <option value="DELIVERED" <?php echo $filter_status=='DELIVERED'?'selected':''; ?>>Delivered</option>
                            <option value="CANCELLED" <?php echo $filter_status=='CANCELLED'?'selected':''; ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Payment Status</label>
                        <select name="payment" class="form-control">
                            <option value="">All Payments</option>
                            <option value="PENDING" <?php echo $filter_payment=='PENDING'?'selected':''; ?>>Pending</option>
                            <option value="PAID" <?php echo $filter_payment=='PAID'?'selected':''; ?>>Paid</option>
                            <option value="FAILED" <?php echo $filter_payment=='FAILED'?'selected':''; ?>>Failed</option>
                            <option value="REFUNDED" <?php echo $filter_payment=='REFUNDED'?'selected':''; ?>>Refunded</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Date From</label>
                        <input type="date" name="date_from" value="<?php echo $date_from; ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Date To</label>
                        <input type="date" name="date_to" value="<?php echo $date_to; ?>" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Apply Filters
                        </button>
                        <a href="orders_list.php" class="btn btn-secondary">Clear Filters</a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Orders Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="ordersTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Order Date</th>
                                <th>Items</th>
                                <th>Total Amount</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($order = mysqli_fetch_assoc($orders)): 
                                // Count order items
                                $items_count = mysqli_fetch_assoc(mysqli_query($conn, 
                                    "SELECT COUNT(*) as count FROM order_items WHERE order_id = {$order['id']}"))['count'];
                            ?>
                            <tr>
                                <td>#<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></td>
                                <td>
                                    <strong><?php echo $order['customer_name'] ?? 'Guest'; ?></strong><br>
                                    <small class="text-muted"><?php echo $order['customer_email'] ?? ''; ?></small>
                                </td>
                                <td><?php echo date('d M Y h:i A', strtotime($order['placed_at'])); ?></td>
                                <td>
                                    <span class="badge badge-primary"><?php echo $items_count; ?> items</span><br>
                                    <small><?php echo $order['order_type']; ?></small>
                                </td>
                                <td>
                                    <strong>₨<?php echo number_format($order['total_amount'], 2); ?></strong><br>
                                    <?php if($order['shipping_charges'] > 0): ?>
                                    <small class="text-muted">Shipping: ₨<?php echo $order['shipping_charges']; ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $payment_badge = [
                                        'PAID' => 'success',
                                        'PENDING' => 'warning', 
                                        'FAILED' => 'danger',
                                        'REFUNDED' => 'info'
                                    ];
                                    ?>
                                    <span class="badge badge-<?php echo $payment_badge[$order['payment_status']] ?? 'secondary'; ?>">
                                        <?php echo $order['payment_status']; ?>
                                    </span><br>
                                    <small><?php echo $order['payment_method'] ?? 'N/A'; ?></small>
                                </td>
                                <td>
                                    <?php
                                    $status_badge = [
                                        'PENDING' => 'warning',
                                        'CONFIRMED' => 'info',
                                        'PROCESSING' => 'primary',
                                        'SHIPPED' => 'secondary',
                                        'DELIVERED' => 'success',
                                        'CANCELLED' => 'danger',
                                        'REFUNDED' => 'dark'
                                    ];
                                    ?>
                                    <span class="badge badge-<?php echo $status_badge[$order['status']] ?? 'secondary'; ?>">
                                        <?php echo $order['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="order_details.php?id=<?php echo $order['id']; ?>" 
                                           class="btn btn-sm btn-info" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="update_order_status.php?id=<?php echo $order['id']; ?>" 
                                           class="btn btn-sm btn-warning" title="Update Status">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="generate_invoice.php?id=<?php echo $order['id']; ?>" 
                                           target="_blank" class="btn btn-sm btn-success" title="Invoice">
                                            <i class="fas fa-file-invoice"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    
    <!-- DataTables Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#ordersTable').DataTable({
            "pageLength": 25,
            "order": [[2, 'desc']] // Order by date descending
        });
    });
    </script>
