<?php
include('includes/nav.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (empty($user)) {
    // Agar nav.php ne $user set nahi kiya to yahan set kar lo (Best Practice)
    $user = getUserData();
}
$user = getUserData($con); 
$user_id = $user['id']; 

// 2. USER ID ko SQL Injection se bachane ke liye escape karein (ZAROORI)
$safe_user_id = mysqli_real_escape_string($con, $user_id);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// ----------------- Total orders -----------------
$result = mysqli_query($con, "SELECT COUNT(*) as total FROM orders WHERE user_id = '$safe_user_id'");
if (!$result) {
    die("Database Query Error (Total Orders): " . mysqli_error($con));
}

$total_orders = mysqli_fetch_assoc($result)['total'];
$total_pages = ceil($total_orders / $limit);

// ----------------- Get orders -----------------
$result = mysqli_query($con, "SELECT * FROM orders WHERE user_id = '$safe_user_id' ORDER BY placed_at DESC LIMIT $limit OFFSET $offset");
if (!$result) {
    die("Database Query Error (Get Orders): " . mysqli_error($con));
}
$orders = [];
while($row = mysqli_fetch_assoc($result)) {
    // Get order items count
    $order_id = $row['id'];
    $items_result = mysqli_query($con, "SELECT oi.quantity, b.title FROM order_items oi LEFT JOIN books b ON oi.book_id = b.book_id WHERE oi.order_id = '$order_id'");
    
    $items_count = 0;
    $book_titles = [];
    while($item = mysqli_fetch_assoc($items_result)) {
        $items_count += $item['quantity'];
        $book_titles[] = $item['title'];
    }
    
    $row['items_count'] = $items_count;
    $row['book_titles'] = implode(', ', $book_titles);
    
    $orders[] = $row;
}

?>

<style>
.top {
    margin-top: 110px;
}

.account-sidebar {

    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 30px 20px;
    height: 100%;
}

.account-sidebar .user-info {
    text-align: center;
    margin-bottom: 30px;
}

.account-sidebar .user-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-size: 40px;
    color: #667eea;
    border: 4px solid rgba(255, 255, 255, 0.3);
}

.account-sidebar .nav-link {
    color: rgba(255, 255, 255, 0.8);
    padding: 12px 20px;
    border-radius: 10px;
    margin-bottom: 5px;
    transition: all 0.3s;
}

.account-sidebar .nav-link:hover,
.account-sidebar .nav-link.active {
    background: rgba(255, 255, 255, 0.1);
    color: white;
}

.account-sidebar .nav-link i {
    width: 25px;
    text-align: center;
    margin-right: 10px;
}

.stat-card {
    border: none;
    border-radius: 15px;
    transition: transform 0.3s;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-card .card-icon {
    font-size: 40px;
    opacity: 0.8;
}


.order-card {
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    margin-bottom: 20px;
    transition: all 0.3s;
}

.order-card:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.order-header {
    background: #f8f9fa;
    padding: 15px;
    border-bottom: 1px solid #e0e0e0;
    border-radius: 10px 10px 0 0;
}

.order-body {
    padding: 20px;
}

.status-badge {
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.85rem;
}
</style>


<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="container py-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="account.php">Account</a></li>
        <li class="breadcrumb-item active">My Orders</li>
    </ol>
</nav>

<!-- Main Content -->
<div class="container-fluid top py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="account-sidebar">
                <!-- User Info -->
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4 class="mb-1"><?php echo htmlspecialchars($user['name']); ?></h4>
                    <p class="mb-0 text-white-50">
                        <i class="fas fa-envelope me-1"></i> <?php echo htmlspecialchars($user['email']); ?>
                    </p>
                    <small class="text-white-50">
                        Member since: <?php echo date('M Y', strtotime($user['created_at'])); ?>
                    </small>
                </div>

                <!-- Navigation -->
                <nav class="nav flex-column">
                    <a class="nav-link active" href="account.php">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a class="nav-link" href="my-orders.php">
                        <i class="fas fa-shopping-bag"></i> My Orders
                    </a>
                    
                    <a class="nav-link" href="edit-profile.php">
                        <i class="fas fa-user-edit"></i> Edit Profile
                    </a>
                    <a class="nav-link" href="change-password.php">
                        <i class="fas fa-key"></i> Change Password
                    </a>
                    <a class="nav-link" href="wishlist.php">
                        <i class="fas fa-heart"></i> Wishlist
                    </a>
                    <div class="mt-4 pt-3 border-top border-white-10">
                        <a class="nav-link text-warning" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Orders List -->
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fas fa-shopping-bag me-2"></i> My Orders
                        <span class="badge bg-primary ms-2"><?php echo $total_orders; ?> orders</span>
                    </h4>
                </div>
                <div class="card-body">
                    <?php if ($orders): ?>
                    <?php foreach ($orders as $order): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <strong>Order #<?php echo $order['id']; ?></strong>
                                    <div class="text-muted small">
                                        <?php echo date('F d, Y', strtotime($order['placed_at'])); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <span class="status-badge bg-<?php 
                                                echo $order['status'] === 'completed' ? 'success' : 
                                                     ($order['status'] === 'pending' ? 'warning' : 
                                                     ($order['status'] === 'processing' ? 'info' : 'secondary')); ?>">
                                        <?php echo ucfirst($order['status']); ?>
                                    </span>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <strong class="text-primary">
                                        $<?php echo number_format($order['total_amount'], 2); ?>
                                    </strong>
                                </div>
                            </div>
                        </div>

                        <div class="order-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6>Items Ordered:</h6>
                                    <p class="text-muted">
                                        <?php 
                                                $titles = explode(', ', $order['book_titles']);
                                                if (count($titles) > 3) {
                                                    echo implode(', ', array_slice($titles, 0, 3)) . '...';
                                                } else {
                                                    echo $order['book_titles'];
                                                }
                                                ?>
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-box me-2"></i>
                                        <strong><?php echo $order['items_count']; ?></strong> items
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-credit-card me-2"></i>
                                        Payment: <?php echo ucfirst($order['payment_method']); ?>
                                    </p>
                                    <p class="mb-0">
                                        <i class="fas fa-truck me-2"></i>
                                        Shipping: <?php echo $order['shipping_address'] ?: 'Not specified'; ?>
                                    </p>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <div class="mt-3">
                                        <a href="view-order.php?id=<?php echo $order['id']; ?>"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i> View Details
                                        </a>
                                        <?php if ($order['status'] === 'pending'): ?>
                                        <a href="cancel-order.php?id=<?php echo $order['id']; ?>"
                                            class="btn btn-outline-danger btn-sm mt-2"
                                            onclick="return confirm('Are you sure you want to cancel this order?')">
                                            <i class="fas fa-times me-1"></i> Cancel Order
                                        </a>
                                        <?php endif; ?>

                                        <?php if ($order['status'] === 'completed'): ?>
                                        <a href="download-invoice.php?id=<?php echo $order['id']; ?>"
                                            class="btn btn-outline-success btn-sm mt-2">
                                            <i class="fas fa-download me-1"></i> Invoice
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <!-- Pagination -->
                    <?php if ($total_pages > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                            </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>

                    <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                        <h3>No orders yet</h3>
                        <p class="text-muted mb-4">You haven't placed any orders yet.</p>
                        <a href="index.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i> Start Shopping
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include('includes/footer.php'); ?>