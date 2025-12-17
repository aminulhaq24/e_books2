<?php
require_once 'init.php'; // Session bhi start ho jayega

// Get user data if logged in
$user = null;
if (isLoggedIn()) {
    $user = getUserData($con);
}

// Page meta data
$page_title = "ReadSphere - Online eBook Library & Book Store";
$page_description = "Discover thousands of eBooks, novels, academic books and participate in writing competitions. Read anytime, anywhere.";
$page_keywords = "eBooks, Online Library, Digital Books, Reading Platform, Books Online";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo $page_title; ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="<?php echo $page_keywords; ?>" name="keywords">
    <meta content="<?php echo $page_description; ?>" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Merriweather:wght@400;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <style>
    /* Custom eBook System Styles */
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #3498db;
        --accent-color: #e74c3c;
        --light-color: #f8f9fa;
        --dark-color: #2c3e50;
        --success-color: #27ae60;
        --warning-color: #f39c12;
    }

    body {
        font-family: 'Poppins', sans-serif;
        color: #333;
        background-color: #f8f9fa;
    }

    h1,
    h2,
    h3,
    h4,
    h5 {
        font-family: 'Merriweather', serif;
        font-weight: 700;
    }

    /* Navbar Customization */
    .navbar-brand h1 {
        color: var(--primary-color) !important;
    }

    .navbar-brand h1 i {
        color: var(--secondary-color);
    }

    /* Hero Section */
    .hero-header {
        background: linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.8));
        /* background-position: center center;
            background-repeat: no-repeat;
            background-size: cover; */
        color: white;
        margin-top: 152px !important;
        height: 110vh;
    }

    @media (max-width: 992px) {
        .hero-header {
            margin-top: 97px !important;
        }
    }

    /* Book Cards */
    .fruite-item {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        background: white;
        position: relative;
    }

    .fruite-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .fruite-img {
        height: 250px;
        overflow: hidden;
    }

    .fruite-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .fruite-item:hover .fruite-img img {
        transform: scale(1.05);
    }

    .category-badge {
        background: var(--secondary-color) !important;
        color: white;
        font-size: 0.8rem;
        font-weight: 500;
        border: none;
    }

    .price-tag {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--accent-color);
        margin: 0;
    }

    .free-badge {
        background: var(--success-color);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* Features Section */

    .featurs {
        margin-top: 130px;
    }

    .featurs-item {
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        height: 100%;
    }

    .featurs-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        border-color: var(--secondary-color);
    }

    .featurs-icon {
        background: var(--secondary-color) !important;
    }

    .featurs-content h5 {
        color: var(--primary-color);
    }

    /* Statistics Section */
    .counter h1 {
        color: var(--secondary-color);
        font-weight: 700;
    }

    .counter i {
        color: var(--secondary-color) !important;
    }

    /* Banner Section */
    .banner {
        background: linear-gradient(135deg, var(--primary-color) 0%, #4a6491 100%) !important;
    }

    .banner h1 {
        color: white !important;
    }

    .banner-btn {
        background: white;
        color: var(--primary-color) !important;
        border: 2px solid white !important;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .banner-btn:hover {
        background: transparent;
        color: white !important;
    }

    /* Testimonials */
    .testimonial-item {
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .testimonial-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        border-color: var(--secondary-color);
    }

    /* Footer */
    .footer {
        background: var(--primary-color) !important;
    }

    /* Competition Cards */
    .competition-card {
        border-left: 5px solid var(--accent-color);
        transition: all 0.3s ease;
    }

    .competition-card:hover {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    /* Search Modal */
    #searchModal .modal-content {
        background: rgba(44, 62, 80, 0.95);
    }

    #searchModal .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    #searchModal .modal-title {
        color: white;
    }

    /* Custom Buttons */
    .btn-primary {
        background: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .btn-primary:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
    }

    /* Tabs */
    .nav-pills .nav-link.active {
        background: var(--secondary-color) !important;
    }

    .tabs-slider .nav-link {
        transition: all 0.3s ease;
    }

    .tabs-slider .nav-link:hover {
        background: #f0f8ff !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-header h1.display-3 {
            font-size: 2.5rem;
        }

        .fruite-img {
            height: 200px;
        }

        .featurs-item {
            margin-bottom: 20px;
        }
    }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <div class="container-fluid fixed-top">
        <div class="container topbar bg-primary d-none d-lg-block">
            <div class="d-flex justify-content-between">
                <div class="top-info ps-2">
                    <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i>
                        <a href="#" class="text-white">Karachi, Pakistan</a>
                    </small>
                    <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i>
                        <a href="mailto:info@readsphere.com" class="text-white">info@readsphere.com</a>
                    </small>
                </div>
                <div class="top-link pe-2">
                    <a href="privacy.php" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                    <a href="terms.php" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                    <a href="refund.php" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
                </div>
            </div>
            <div class="position-absolute" style="left: 96%; top: 20px">
                 <a href="cart.php" class="position-relative me-4 my-auto">
                            <!-- <i class="fa fa-shopping-bag fa-2x text-primary"></i> -->
                            <img src="img/cart-image.png"  alt="">
                            <span
                            
                                class="cart-count position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                                style="top: -8px; left: 18px; height: 20px; min-width: 20px;">
                                <?php echo isset($_SESSION['cart']['total_items']) ? $_SESSION['cart']['total_items'] : 0; ?>
                            </span>
                        </a>
            </div>
            
        </div>
        <div class="container-fluid px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="index.php" class="navbar-brand">
                    <h1 class="text-primary display-6">
                        <i class="fas fa-book-open me-2"></i>ReadSphere
                    </h1>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <a href="shop.php" class="nav-item nav-link">Shop</a>

                        <?php
                        // Fetch main categories for navigation
                        $cat_sql = "SELECT * FROM categories ORDER BY category_name";
                        $cat_run = mysqli_query($con, $cat_sql);
                        
                        while($cat = mysqli_fetch_assoc($cat_run)):
                        ?>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <?php echo htmlspecialchars($cat['category_name']); ?>
                            </a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <?php
                                $cat_id = $cat['id'];
                                $sub_sql = "SELECT * FROM subcategories WHERE category_id = $cat_id ORDER BY subcategory_name ASC";
                                $sub_run = mysqli_query($con, $sub_sql);
                                
                                while($sub = mysqli_fetch_assoc($sub_run)):
                                ?>
                                <a href="shop.php?subcat=<?php echo $sub['id']; ?>" class="dropdown-item">
                                    <?php echo htmlspecialchars($sub['subcategory_name']); ?>
                                </a>
                                <?php endwhile; ?>
                            </div>
                        </div>
                        <?php endwhile; ?>

                        <a href="competitions.php" class="nav-item nav-link">Competitions</a>
                        <a href="free-books.php" class="nav-item nav-link">Free Books</a>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                    </div>
                    <div class="d-flex m-3 me-0">
                        <button
                            class="btn-search btn  btn-md-square rounded-circle bg-white me-4"
                            data-bs-toggle="modal" data-bs-target="#searchModal">
                            <i class="fas fa-search text-primary"></i>
                        </button>
                        

                   

                        <!-- profile -->

                          <?php if (isLoggedIn() && $user): ?>
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" 
                            id="userDropdown" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i>
                        <?php echo htmlspecialchars($user['name']); ?>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="account.php">
                            <i class="fas fa-user-circle me-2"></i> My Account
                        </a></li>
                        <li><a class="dropdown-item" href="my-orders.php">
                            <i class="fas fa-shopping-bag me-2"></i> My Orders
                        </a></li>
                        <li><a class="dropdown-item" href="my-library.php">
                            <i class="fas fa-book me-2"></i> My Library
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a></li>
                    </ul>
                </div>
            <?php else: ?>
                <div>
                    <a href="login.php" class="btn btn-outline-primary me-2">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                    <a href="register.php" class="btn btn-primary">
                        <i class="fas fa-user-plus me-1"></i> Register
                    </a>
                </div>
            <?php endif; ?>


                        <!-- frofile end -->
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search Books & Authors</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <form action="search.php" method="GET" class="w-100">
                            <div class="input-group">
                                <input type="search" class="form-control p-3" name="q"
                                    placeholder="Search by book title, author, category..."
                                    aria-describedby="search-icon-1">
                                <button type="submit" class="input-group-text p-3 bg-primary text-white"
                                    id="search-icon-1">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                            <div class="mt-3 text-center">
                                <small class="text-white">Try: <em>Islamic books, Novels, Poetry,
                                        Technology</em></small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->