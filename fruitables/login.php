<?php
// login.php
session_start();
include('includes/connection.php');

$error = '';

// ==================== REQUIRED FUNCTIONS ====================
function merge_cart_with_database($user_id, $session_cart) {
    global $con;
    
    // First, check if cart table exists
    $check_table = mysqli_query($con, "SHOW TABLES LIKE 'cart'");
    if(mysqli_num_rows($check_table) == 0) {
        // Create cart table if doesn't exist
        create_cart_table();
    }
    
    // Load existing cart from database
    $db_cart = [];
    $query = "SELECT * FROM cart WHERE user_id = $user_id";
    $result = mysqli_query($con, $query);
    
    if($result) {
        while($row = mysqli_fetch_assoc($result)) {
            $db_cart[$row['book_id']] = $row['quantity'];
        }
    }
    
    // Merge with session cart
    foreach($session_cart['items'] as $item) {
        $book_id = $item['book_id'];
        $quantity = $item['quantity'];
        
        if(isset($db_cart[$book_id])) {
            // Update quantity
            $new_quantity = $db_cart[$book_id] + $quantity;
            $query = "UPDATE cart SET quantity = $new_quantity 
                     WHERE user_id = $user_id AND book_id = $book_id";
        } else {
            // Insert new item
            $query = "INSERT INTO cart (user_id, book_id, quantity) 
                     VALUES ($user_id, $book_id, $quantity)";
        }
        mysqli_query($con, $query);
    }
    
    // Load merged cart into session
    load_cart_from_database($user_id);
}

function load_cart_from_database($user_id) {
    global $con;
    
    // Check if cart table exists
    $check_table = mysqli_query($con, "SHOW TABLES LIKE 'cart'");
    if(mysqli_num_rows($check_table) == 0) {
        // If no cart table, return empty array
        $_SESSION['cart'] = [
            'items' => [],
            'subtotal' => 0,
            'total_items' => 0,
            'session_id' => session_id()
        ];
        return;
    }
    
    $query = "SELECT c.*, b.title, b.price, b.cover_image, 
                     (b.price = 0 OR b.is_free_for_members = 1) as is_free
              FROM cart c 
              JOIN books b ON c.book_id = b.book_id 
              WHERE c.user_id = $user_id";
    $result = mysqli_query($con, $query);
    
    if(!$result) {
        // If error, create empty cart
        $_SESSION['cart'] = [
            'items' => [],
            'subtotal' => 0,
            'total_items' => 0,
            'session_id' => session_id()
        ];
        return;
    }
    
    $cart_items = [];
    $subtotal = 0;
    $total_items = 0;
    
    while($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = [
            'book_id' => $row['book_id'],
            'title' => $row['title'],
            'price' => $row['price'],
            'cover_image' => $row['cover_image'],
            'quantity' => $row['quantity'],
            'is_free' => $row['is_free']
        ];
        
        if(!$row['is_free']) {
            $subtotal += $row['price'] * $row['quantity'];
        }
        $total_items += $row['quantity'];
    }
    
    $_SESSION['cart'] = [
        'items' => $cart_items,
        'subtotal' => $subtotal,
        'total_items' => $total_items,
        'session_id' => session_id()
    ];
}

function create_cart_table() {
    global $con;
    
    $sql = "CREATE TABLE IF NOT EXISTS cart (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        book_id INT NOT NULL,
        quantity INT DEFAULT 1,
        added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE,
        UNIQUE KEY unique_cart_item (user_id, book_id)
    )";
    
    mysqli_query($con, $sql);
}
// ==================== END FUNCTIONS ====================

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;
    
    // Check user credentials
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    
    if(mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        if(password_verify($password, $user['password'])) {
            // Save old cart from session (before login)
            $old_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;
            
            // Set user session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            
            // If user had items in cart before login
            if($old_cart && !empty($old_cart['items'])) {
                merge_cart_with_database($user['id'], $old_cart);
            } else {
                // Load cart from database
                load_cart_from_database($user['id']);
            }
            
            // Redirect to previous page or home
            $redirect = isset($_GET['redirect']) ? urldecode($_GET['redirect']) : 'index.php';
            header("Location: $redirect");
            exit;
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - ReadSphere</title>

     <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            background-image: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9)), url('img/login-bg.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }
        .auth-container {
            max-width: 450px;
            margin: 100px auto;
            padding: 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .auth-header h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .auth-header p {
            color: #7f8c8d;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .auth-footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .btn-login {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            border: none;
            padding: 12px;
            font-weight: 600;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #2980b9, #1a252f);
        }
        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-logo i {
            font-size: 60px;
            color: #3498db;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
   
    
    <div class="container">
        <div class="auth-container">
            <div class="login-logo">
                <i class="fas fa-book-reader"></i>
                <h3>ReadSphere</h3>
            </div>
            
            <div class="auth-header">
                <h2>Welcome Back</h2>
                <p>Login to continue reading</p>
            </div>
            
            <?php if(!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <?php if(isset($_GET['registered'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                Registration successful! Please login.
            </div>
            <?php endif; ?>
            
            <?php if(isset($_GET['logout'])): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                You have been logged out successfully.
            </div>
            <?php endif; ?>
            
            <?php if(isset($_GET['session_expired'])): ?>
            <div class="alert alert-warning">
                <i class="fas fa-clock me-2"></i>
                Your session has expired. Please login again.
            </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                               required placeholder="your@email.com">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" class="form-control" id="password" name="password" 
                               required placeholder="Enter your password">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>
                    <a href="forgot-password.php" class="text-decoration-none">
                        Forgot Password?
                    </a>
                </div>
                
                <button type="submit" class="btn btn-login w-100 btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i> Login
                </button>
            </form>
            
            <div class="auth-footer">
                <p class="mb-2">Don't have an account?</p>
                <a href="register.php" class="btn btn-outline-primary w-100">
                    <i class="fas fa-user-plus me-2"></i> Create New Account
                </a>
                
                <div class="mt-3">
                    <small class="text-muted">
                        By logging in, you agree to our 
                        <a href="terms.php" class="text-decoration-none">Terms</a> and 
                        <a href="privacy.php" class="text-decoration-none">Privacy Policy</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if(passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
    
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        if(!email || !password) {
            e.preventDefault();
            alert('Please fill in all fields');
            return false;
        }
        
        // Add loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Logging in...';
        submitBtn.disabled = true;
    });
    
    // Auto-focus email field
    document.getElementById('email').focus();
    
    // Demo credentials hint (remove in production)
    setTimeout(() => {
        const urlParams = new URLSearchParams(window.location.search);
        if(urlParams.has('demo')) {
            document.getElementById('email').value = 'amin@gmail.com';
            document.getElementById('password').value = 'admin123';
        }
    }, 100);
    </script>
</body>
</html>