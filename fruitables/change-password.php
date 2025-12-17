<?php
require_once 'includes/nav.php';



// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';
$message_type = '';

// -------- Fetch full user data for sidebar --------
$user_result = mysqli_query($con, "SELECT name, email, created_at FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($user_result);
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $current_password = $_POST['current_password'] ?? '';
    $new_password     = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    
    // ----------------- Fetch user password -----------------
    $result = mysqli_query($con, "SELECT password FROM users WHERE id = $user_id");
    $password_row = mysqli_fetch_assoc($result);
    
    if (!$password_row) {
        $message = 'User not found';
        $message_type = 'danger';
    }
    // ----------------- Verify current password -----------------
    elseif (!password_verify($current_password, $password_row['password'])) {

        $message = 'Current password is incorrect';
        $message_type = 'danger';
    }
    elseif (strlen($new_password) < 6) {
        $message = 'New password must be at least 6 characters';
        $message_type = 'danger';
    }
    elseif ($new_password !== $confirm_password) {
        $message = 'New passwords do not match';
        $message_type = 'danger';
    }
    else {
        // ----------------- Hash new password -----------------
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // ----------------- Update password -----------------
        $update = mysqli_query(
            $con,
            "UPDATE users SET password = '$hashed_password' WHERE id = $user_id"
        );

        if ($update) {
            $message = 'Password changed successfully';
            $message_type = 'success';

            // Clear form values
            $_POST = [];
        } else {
            $message = 'Failed to change password';
            $message_type = 'danger';
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
            
            <!-- Change Password Form -->
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">
                            <i class="fas fa-key me-2"></i> Change Password
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
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Current Password *</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="current_password" 
                                                   name="current_password" required>
                                            <button class="btn btn-outline-secondary" type="button" 
                                                    onclick="togglePassword('current_password')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">New Password *</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="new_password" 
                                                   name="new_password" required minlength="6">
                                            <button class="btn btn-outline-secondary" type="button" 
                                                    onclick="togglePassword('new_password')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted">Minimum 6 characters</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Confirm New Password *</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="confirm_password" 
                                                   name="confirm_password" required minlength="6">
                                            <button class="btn btn-outline-secondary" type="button" 
                                                    onclick="togglePassword('confirm_password')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Password Requirements:</strong>
                                        <ul class="mb-0 mt-2">
                                            <li>At least 6 characters long</li>
                                            <li>Should contain letters and numbers</li>
                                            <li>Avoid using common passwords</li>
                                        </ul>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i> Change Password
                                        </button>
                                        <a href="account.php" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i> Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
    
    <script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const button = input.nextElementSibling.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            button.classList.remove('fa-eye');
            button.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            button.classList.remove('fa-eye-slash');
            button.classList.add('fa-eye');
        }
    }
    </script>
