<?php
// register.php
session_start();
include('includes/connection.php');

$errors = [];
$success = false;

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
        // If no cart table, keep session cart as is
        return;
    }
    
    $query = "SELECT c.*, b.title, b.price, b.cover_image, 
                     (b.price = 0 OR b.is_free_for_members = 1) as is_free
              FROM cart c 
              JOIN books b ON c.book_id = b.book_id 
              WHERE c.user_id = $user_id";
    $result = mysqli_query($con, $query);
    
    if(!$result) {
        // If error, keep session cart
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
    // Get form data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $address = isset($_POST['address']) ? mysqli_real_escape_string($con, $_POST['address']) : '';
    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($con, $_POST['phone']) : '';
    
    // Validation
    if(empty($name)) $errors[] = "Name is required";
    if(empty($email)) $errors[] = "Email is required";
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";
    if(empty($password)) $errors[] = "Password is required";
    if(strlen($password) < 6) $errors[] = "Password must be at least 6 characters";
    if($password !== $confirm_password) $errors[] = "Passwords do not match";
    
    // Check if email exists
    $check_email = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $check_email);
    if(mysqli_num_rows($result) > 0) {
        $errors[] = "Email already registered";
    }
    
    // If no errors, create user
    if(empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert into users table
        $query = "INSERT INTO users (name, email, password, address, phone, role) 
                  VALUES ('$name', '$email', '$hashed_password', '$address', '$phone', 'user')";
        
        if(mysqli_query($con, $query)) {
            $user_id = mysqli_insert_id($con);
            
            // Auto login after registration
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = 'user';
            
            // Merge cart if exists in session
            if(isset($_SESSION['cart']) && !empty($_SESSION['cart']['items'])) {
                merge_cart_with_database($user_id, $_SESSION['cart']);
            }
            
            $success = true;
            header("Location: index.php?registered=1");
            exit;
        } else {
            $errors[] = "Registration failed: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - ReadSphere</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .auth-container {
            max-width: 500px;
            margin: 80px auto;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
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
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .alert ul {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
   
    
    <div class="container">
        <div class="auth-container">
            <div class="auth-header">
                <h2>Create Your Account</h2>
                <p>Join thousands of readers on ReadSphere</p>
            </div>
            
            <?php if(!empty($errors)): ?>
            <div class="alert alert-danger">
                <strong>Please fix the following errors:</strong>
                <ul>
                    <?php foreach($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success">
                Registration successful! Redirecting...
            </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="row">
                    
                        <div class="form-group">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" 
                                   required>
                        </div>
                    
                    
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                                   required>
                        </div>
                    
                </div>
                
                <div class="row">
                    
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                   value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                        </div>
                   
                    
                        <div class="form-group">
                            <label for="password" class="form-label">Password *</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <small class="text-muted">Minimum 6 characters</small>
                        </div>
                    
                </div>
                
                <div class="form-group">
                    <label for="confirm_password" class="form-label">Confirm Password *</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                
                <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="2"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
                </div>
                
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                    <label class="form-check-label" for="terms">
                        I agree to the <a href="terms.php" target="_blank">Terms & Conditions</a>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 btn-lg">Create Account</button>
            </form>
            
            <div class="auth-footer">
                <p class="mb-0">Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>
    
    <script>
    // Password strength check
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strength = checkPasswordStrength(password);
        
        // Remove existing feedback
        const existingFeedback = document.getElementById('password-strength');
        if(existingFeedback) existingFeedback.remove();
        
        // Create feedback element
        const feedback = document.createElement('div');
        feedback.id = 'password-strength';
        feedback.className = 'mt-1';
        
        if(password.length > 0) {
            if(strength === 'weak') {
                feedback.innerHTML = '<small class="text-danger"><i class="fas fa-times-circle"></i> Weak password</small>';
            } else if(strength === 'medium') {
                feedback.innerHTML = '<small class="text-warning"><i class="fas fa-exclamation-circle"></i> Medium strength</small>';
            } else {
                feedback.innerHTML = '<small class="text-success"><i class="fas fa-check-circle"></i> Strong password</small>';
            }
            
            this.parentNode.appendChild(feedback);
        }
    });
    
    function checkPasswordStrength(password) {
        if(password.length < 6) return 'weak';
        if(password.length < 8) return 'medium';
        if(/[A-Z]/.test(password) && /[0-9]/.test(password)) return 'strong';
        return 'medium';
    }
    
    // Confirm password match
    document.getElementById('confirm_password').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        
        // Remove existing feedback
        const existingFeedback = document.getElementById('password-match');
        if(existingFeedback) existingFeedback.remove();
        
        if(confirmPassword.length > 0 && password !== confirmPassword) {
            const feedback = document.createElement('div');
            feedback.id = 'password-match';
            feedback.innerHTML = '<small class="text-danger"><i class="fas fa-times-circle"></i> Passwords do not match</small>';
            this.parentNode.appendChild(feedback);
        }
    });
    </script>
</body>
</html>