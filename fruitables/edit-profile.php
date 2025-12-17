<?php
include 'includes/nav.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';
$message_type = '';

// ----------------- Fetch user details -----------------
$result = mysqli_query($con, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($result);

// ----------------- Handle form submission -----------------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name'] ?? '');
    $email = mysqli_real_escape_string($con, $_POST['email'] ?? '');
    $phone = mysqli_real_escape_string($con, $_POST['phone'] ?? '');
    $address = mysqli_real_escape_string($con, $_POST['address'] ?? '');
    
    // Validation
    if (empty($name) || empty($email)) {
        $message = 'Name and email are required';
        $message_type = 'danger';
    } else {
        // Check if email already exists for another user
        $check_result = mysqli_query($con, "SELECT id FROM users WHERE email = '$email' AND id != $user_id");
        if (mysqli_num_rows($check_result) > 0) {
            $message = 'Email already exists';
            $message_type = 'danger';
        } else {
            // Update user
            $update_query = "
                UPDATE users SET
                name = '$name',
                email = '$email',
                phone = '$phone',
                address = '$address',
                updated_at = NOW()
                WHERE id = $user_id
            ";
            
            if (mysqli_query($con, $update_query)) {
                $message = 'Profile updated successfully';
                $message_type = 'success';
                
                // Update session
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                
                // Refresh user data
                $result = mysqli_query($con, "SELECT * FROM users WHERE id = $user_id");
                $user = mysqli_fetch_assoc($result);
            } else {
                $message = 'Failed to update profile';
                $message_type = 'danger';
            }
        }
    }
}

?>

<style>
    .top {
    margin-top: 170px;
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
            
            <!-- Edit Profile Form -->
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">
                            <i class="fas fa-user-edit me-2"></i> Edit Profile
                        </h4>
                    </div>
                    
                    <div class="card-body">
                        <?php if ($message): ?>
                        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show">
                            <?php echo $message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" 
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
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                    <small class="text-muted">Format: +92XXXXXXXXXX</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="address" 
                                              rows="2"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Account Created</label>
                                <input type="text" class="form-control" 
                                       value="<?php echo date('F d, Y', strtotime($user['created_at'])); ?>" 
                                       readonly>
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Update Profile
                                </button>
                                <a href="account.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
