<?php
// sab se pehle common system load karo
include('includes/nav.php');

// login check
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

// user data (already function bana hua)
$user = getUserData();
$user_id = $user['id'];
$safe_user_id = mysqli_real_escape_string($con, $user_id);
// ================== USER STATS ==================

// Total orders
$result = mysqli_query($con, "SELECT COUNT(*) AS total_orders FROM orders WHERE user_id = '$safe_user_id'");
if (!$result) {
    die("Database Query Error: " . mysqli_error($con)); // DEBUGGING k liye zaroori
}

$row = mysqli_fetch_assoc($result);
$total_orders = $row['total_orders'];

// Total books purchased
$result = mysqli_query($con, "
    SELECT SUM(oi.quantity) AS total_books
    FROM order_items oi
    JOIN orders o ON oi.order_id = o.id
    WHERE o.user_id = $safe_user_id AND o.status = 'completed'
");

if (!$result) {
    die("Database Query Error: " . mysqli_error($con)); 
}
$row = mysqli_fetch_assoc($result);
$total_books = $row['total_books'] ?? 0;

// Total spent
$result = mysqli_query($con, "
    SELECT SUM(total_amount) AS total_spent
    FROM orders
    WHERE user_id = $safe_user_id AND status = 'completed'
");
$row = mysqli_fetch_assoc($result);
$total_spent = $row['total_spent'] ?? 0;


?>

<style>
    .top {
        margin-top: 180px;
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

.recent-order {
    border-left: 4px solid #0d6efd;
    padding-left: 15px;
    margin-bottom: 15px;
}

.dashboard-section {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    margin-bottom: 30px;
}

.dashboard-title {
    color: #333;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 15px;
    margin-bottom: 20px;
}
</style>



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

        <!-- Main Dashboard -->
        <div class="col-lg-9">
            <!-- Welcome Banner -->
            <div class="dashboard-section">
                <h2 class="dashboard-title">Welcome back, <?php echo htmlspecialchars($user['name']); ?>!</h2>
                <p class="lead">Here's what's happening with your account.</p>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card stat-card border-primary">
                        <div class="card-body text-center">
                            <i class="fas fa-shopping-bag card-icon text-primary mb-3"></i>
                            <h3 class="card-title"><?php echo $total_orders; ?></h3>
                            <p class="card-text text-muted">Total Orders</p>
                            <a href="my-orders.php" class="btn btn-outline-primary btn-sm">View Orders</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card stat-card border-success">
                        <div class="card-body text-center">
                            <i class="fas fa-book card-icon text-success mb-3"></i>
                            <h3 class="card-title"><?php echo $total_books; ?></h3>
                            <p class="card-text text-muted">Books Purchased</p>
                            <a href="my-library.php" class="btn btn-outline-success btn-sm">View Library</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card stat-card border-info">
                        <div class="card-body text-center">
                            <i class="fas fa-wallet card-icon text-info mb-3"></i>
                            <h3 class="card-title">$<?php echo number_format($total_spent, 2); ?></h3>
                            <p class="card-text text-muted">Total Spent</p>
                            <a href="my-orders.php" class="btn btn-outline-info btn-sm">View History</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="dashboard-section">
                <h4 class="dashboard-title">
                    <i class="fas fa-history me-2"></i> Recent Orders
                </h4>

                <?php
                    // Get recent orders
                   $recent_orders = [];

                  $result = mysqli_query($con, "
                      SELECT * FROM orders 
                      WHERE user_id = $safe_user_id 
                      ORDER BY placed_at DESC 
                      LIMIT 5
                  ");

                  if ($result) {
                      while ($row = mysqli_fetch_assoc($result)) {
                          $recent_orders[] = $row;
                      }
                  }

                    
                    if ($recent_orders): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_orders as $order): ?>
                            <tr>
                                <td>#<?php echo $order['id']; ?></td>
                                <td><?php echo date('M d, Y', strtotime($order['placed_at'])); ?></td>
                                <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                <td>
                                    <span class="badge bg-<?php 
                                                echo $order['status'] === 'completed' ? 'success' : 
                                                     ($order['status'] === 'pending' ? 'warning' : 
                                                     ($order['status'] === 'processing' ? 'info' : 'danger')); ?>">
                                        <?php echo ucfirst($order['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="view-order.php?id=<?php echo $order['id']; ?>"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="my-orders.php" class="btn btn-primary">View All Orders</a>
                </div>
                <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h5>No orders yet</h5>
                    <p class="text-muted">You haven't placed any orders yet.</p>
                    <a href="index.php" class="btn btn-primary">Start Shopping</a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Recently Viewed Books -->
            <div class="dashboard-section">
                <h4 class="dashboard-title">
                    <i class="fas fa-eye me-2"></i> Recently Viewed
                </h4>

                <?php
                    // Get recently viewed books (you need to track this separately)
                    // For now, showing recommended books
                  
$recommended_books = [];

$result = mysqli_query($con, "
    SELECT * FROM books
    ORDER BY RAND() 
    LIMIT 4
");

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $recommended_books[] = $row;
    }
}
?>


                <div class="row">
                    <?php foreach ($recommended_books as $book): ?>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="card h-100">
                            <img src="../admin_panel/uploads/<?php echo $book['cover_image'] ?: 'assets/images/default-book.jpg'; ?>"
                                class="card-img-top" alt="<?php echo htmlspecialchars($book['title']); ?>"
                                style="height: 150px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 0.9rem;">
                                    <?php echo htmlspecialchars(substr($book['title'], 0, 30)) . (strlen($book['title']) > 30 ? '...' : ''); ?>
                                </h6>
                                <p class="card-text text-primary fw-bold mb-2">
                                    $<?php echo number_format($book['price'], 2); ?>
                                </p>
                                <a href="book-detail.php?id=<?php echo $book['book_id']; ?>"
                                    class="btn btn-sm btn-outline-primary w-100">View Book</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include('includes/footer.php'); ?>

<!-- Bootstrap JS -->
<script>
// Active nav link highlighting
document.addEventListener('DOMContentLoaded', function() {
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.account-sidebar .nav-link');

    navLinks.forEach(link => {
        const linkPage = link.getAttribute('href');
        if (linkPage === currentPage) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
});
</script>