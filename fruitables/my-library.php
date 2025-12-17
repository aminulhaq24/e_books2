<?php
require_once 'includes/nav.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get purchased books
$stmt = $con->prepare("
    SELECT DISTINCT b.* 
    FROM books b
    JOIN order_items oi ON b.book_id = oi.book_id
    JOIN orders o ON oi.order_id = o.id
    WHERE o.user_id = ? AND o.status = 'completed'
    ORDER BY o.placed_at DESC
");
$stmt->execute([$user_id]);
$library_books = $stmt->fetch();
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

</style>

    
    <!-- Main Content -->
    <div class="container-fluid py-4">
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
            
            <!-- Library -->
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">
                            <i class="fas fa-book me-2"></i> My Library
                            <span class="badge bg-primary ms-2"><?php echo count($library_books); ?> books</span>
                        </h4>
                    </div>
                    
                    <div class="card-body">
                        <?php if ($library_books): ?>
                            <div class="row">
                                <?php foreach ($library_books as $book): ?>
                                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                    <div class="card h-100">
                                        <img src="<?php echo $book['cover_image'] ?: 'assets/images/default-book.jpg'; ?>" 
                                             class="card-img-top" alt="<?php echo htmlspecialchars($book['title']); ?>"
                                             style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h6 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h6>
                                            <p class="card-text text-muted small">
                                                <i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($book['author']); ?>
                                            </p>
                                            <div class="mt-3">
                                                <a href="read-book.php?id=<?php echo $book['id']; ?>" 
                                                   class="btn btn-primary btn-sm w-100 mb-2">
                                                    <i class="fas fa-book-open me-1"></i> Read Now
                                                </a>
                                                <a href="download-book.php?id=<?php echo $book['id']; ?>" 
                                                   class="btn btn-outline-primary btn-sm w-100">
                                                    <i class="fas fa-download me-1"></i> Download
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white">
                                            <small class="text-muted">
                                                <i class="fas fa-tag me-1"></i> <?php echo htmlspecialchars($book['category']); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-book-open fa-4x text-muted mb-4"></i>
                                <h3>Your library is empty</h3>
                                <p class="text-muted mb-4">Purchase books to add them to your library</p>
                                <a href="index.php" class="btn btn-primary btn-lg">
                                    <i class="fas fa-shopping-bag me-2"></i> Browse Books
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
