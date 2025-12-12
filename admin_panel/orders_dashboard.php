<?php
// orders_dashboard.php
include 'includes/nav.php';


// Admin check
if(!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Get statistics
$today = date('Y-m-d');

// Count queries
$total_orders = mysqli_fetch_assoc(mysqli_query($con, 
    "SELECT COUNT(*) as count FROM orders"))['count'];

$today_orders = mysqli_fetch_assoc(mysqli_query($con, 
    "SELECT COUNT(*) as count FROM orders WHERE DATE(placed_at) = '$today'"))['count'];

$pending_orders = mysqli_fetch_assoc(mysqli_query($con, 
    "SELECT COUNT(*) as count FROM orders WHERE status = 'PENDING'"))['count'];

$total_revenue = mysqli_fetch_assoc(mysqli_query($con, 
    "SELECT SUM(total_amount) as total FROM orders WHERE payment_status = 'PAID'"))['total'] ?? 0;

// Recent orders
$recent_orders = mysqli_query($con, 
    "SELECT o.*, u.name as customer_name 
     FROM orders o 
     LEFT JOIN users u ON o.user_id = u.id 
     ORDER BY o.placed_at DESC 
     LIMIT 10");
?>
    <style>
        .stat-card {
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            color: white;
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .bg-gradient-1 { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .bg-gradient-2 { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .bg-gradient-3 { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .bg-gradient-4 { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
    </style>


    
    
    <div class="container-fluid mt-4">
        <h2><i class="fas fa-tachometer-alt"></i> Orders Dashboard</h2>
        
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="stat-card bg-gradient-1">
                    <h3><i class="fas fa-shopping-cart"></i> <?php echo $total_orders; ?></h3>
                    <p>Total Orders</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-gradient-2">
                    <h3><i class="fas fa-clock"></i> <?php echo $pending_orders; ?></h3>
                    <p>Pending Orders</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-gradient-3">
                    <h3><i class="fas fa-calendar-day"></i> <?php echo $today_orders; ?></h3>
                    <p>Today's Orders</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-gradient-4">
                    <h3><i class="fas fa-money-bill-wave"></i> ₨<?php echo number_format($total_revenue, 2); ?></h3>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>
        
        <!-- Recent Orders Table -->
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-history"></i> Recent Orders</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($order = mysqli_fetch_assoc($recent_orders)): ?>
                            <tr>
                                <td>#<?php echo $order['id']; ?></td>
                                <td><?php echo $order['customer_name'] ?? 'Guest'; ?></td>
                                <td><?php echo date('d M Y', strtotime($order['placed_at'])); ?></td>
                                <td>₨<?php echo number_format($order['total_amount'], 2); ?></td>
                                <td>
                                    <span class="badge badge-<?php 
                                        echo $order['payment_status'] == 'PAID' ? 'success' : 
                                             ($order['payment_status'] == 'PENDING' ? 'warning' : 'danger'); 
                                    ?>">
                                        <?php echo $order['payment_status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-<?php 
                                        echo $order['status'] == 'DELIVERED' ? 'success' : 
                                             ($order['status'] == 'PROCESSING' ? 'primary' : 
                                             ($order['status'] == 'SHIPPED' ? 'info' : 'warning')); 
                                    ?>">
                                        <?php echo $order['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="order_details.php?id=<?php echo $order['id']; ?>" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Quick Links -->
        <div class="row mt-4">
            <div class="col-md-3">
                <a href="orders_list.php" class="btn btn-outline-primary btn-block">
                    <i class="fas fa-list"></i> All Orders
                </a>
            </div>
            <div class="col-md-3">
                <a href="pending_orders.php" class="btn btn-outline-warning btn-block">
                    <i class="fas fa-clock"></i> Pending Orders
                </a>
            </div>
            <div class="col-md-3">
                <a href="sales_report.php" class="btn btn-outline-success btn-block">
                    <i class="fas fa-chart-bar"></i> Sales Report
                </a>
            </div>
            <div class="col-md-3">
                <a href="add_book.php" class="btn btn-outline-info btn-block">
                    <i class="fas fa-plus"></i> Add New Book
                </a>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
