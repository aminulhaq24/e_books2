<?php
include('includes/nav.php');

// Get book ID from URL
$book_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// if($book_id == 0) {
//     header("Location: shop.php");
//     exit;
// }


// Fetch book details with category and subcategory
$book_query = "SELECT b.*, s.subcategory_name, c.category_name 
               FROM books b 
               JOIN subcategories s ON b.subcategory_id = s.id 
               JOIN categories c ON b.category_id = c.id 
               WHERE b.book_id = $book_id LIMIT 1";

$book_result = mysqli_query($con, $book_query);

if(mysqli_num_rows($book_result) == 0) {
    header("Location: shop.php");
    exit;
}

$book = mysqli_fetch_assoc($book_result);

// Fetch related books (same subcategory)
$related_query = "SELECT b.*, s.subcategory_name 
                  FROM books b 
                  JOIN subcategories s ON b.subcategory_id = s.id 
                  WHERE b.subcategory_id = {$book['subcategory_id']} 
                  AND b.book_id != $book_id 
                  ORDER BY RAND() LIMIT 4";
$related_result = mysqli_query($con, $related_query);

// Page title
$page_title = "{$book['title']} by {$book['author']} | ReadSphere";
?>


    
    <style>
        /* Book Detail Page Styles */
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #ffd700;
            --danger-color: #e74c3c;
            --success-color: #27ae60;
            --light-bg: #f8f9fa;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
        }
        
        .book-detail-header {
            /* background: linear-gradient(135deg, var(--primary-color) 0%, #1a252f 100%); */
            padding: 60px 0 40px;
            margin-top: 80px;
            color: white;
            position: relative;
            overflow: hidden;
            margin-top: 150px;
        }
        
        .book-detail-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M1200 0L0 0 1200 120z" fill="rgba(255,255,255,0.05)"/></svg>');
            background-size: 100% 100px;
        }
        
        @media (max-width: 992px) {
            .book-detail-header {
                margin-top: 60px;
                padding: 40px 0 30px;
            }
        }
        
        .book-cover-container {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.25);
            background: white;
            padding: 15px;
            transition: transform 0.3s ease;
        }
        
        .book-cover-container:hover {
            transform: translateY(-5px);
        }
        
        .book-cover {
            width: 100%;
            height: 480px;
            border-radius: 8px;
            display: block;
        }
        
        .book-status-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background: var(--success-color);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            z-index: 2;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        
        .book-breadcrumb {
            font-size: 0.9rem;
            margin-bottom: 25px;
            opacity: 0.9;
        }
        
        .book-breadcrumb a {
            color: var(--accent-color);
            text-decoration: none;
            transition: opacity 0.3s ease;
        }
        
        .book-breadcrumb a:hover {
            opacity: 0.8;
            text-decoration: underline;
        }
        
        .book-breadcrumb .separator {
            color: rgba(255,255,255,0.6);
            margin: 0 8px;
        }
        
        .book-title {
            font-size: 2em;
            font-weight: 800;
            margin-bottom: 10px;
            line-height: 1.2;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        @media (max-width: 768px) {
            .book-title {
                font-size: 2.2rem;
            }
        }
        
        .book-author {
            font-size: 1rem;
            color: var(--accent-color);
            margin-bottom: 25px;
            font-family: 'Merriweather', serif;
            color: green;
        }

        .book-info {
            margin-left: 90px;
            padding-top:16px;

        }
        
        .book-meta-container {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            
        }
        
        .meta-item {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            padding: 8px 18px;
            border-radius: 25px;
            font-size: 0.9rem;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
        }
        
        .meta-item:hover {
            background: rgba(255,255,255,0.25);
            transform: translateY(-2px);
        }
        
        .meta-item i {
            margin-right: 5px;
        }
        
        .rating-container {
            background: rgba(255,255,255,0.1);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 30px;
            max-width: 300px;
        }
        
        .rating-stars {
            color: var(--accent-color);
            font-size: 1.3rem;
            margin-bottom: 8px;
        }
        
        .rating-text {
            font-size: 0.95rem;
            opacity: 0.9;
        }
        
        .book-description-text {
            line-height: 1.8;
            font-size: 1.1rem;
            opacity: 0.95;
            margin-bottom: 30px;
        }
        
        .format-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 30px;
        }
        
        .format-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 18px;
            background: rgba(52, 152, 219, 0.2);
            color: white;
            border-radius: 20px;
            font-size: 0.9rem;
            border: 1px solid rgba(52, 152, 219, 0.4);
            transition: all 0.3s ease;
        }
        
        .format-badge:hover {
            background: rgba(52, 152, 219, 0.3);
            transform: translateY(-2px);
        }
        
        .format-badge i {
            margin-right: 8px;
        }
        
        /* Main Content Area */
        .main-content-area {
            padding: 60px 0;
            background: white;
        }
        
        .content-section {
            margin-bottom: 50px;
        }
        
        .section-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--secondary-color);
            position: relative;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--accent-color);
        }
        
        .details-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            border: 1px solid #eee;
            height: 100%;
            transition: transform 0.3s ease;
        }
        
        .details-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }
        
        .specs-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .specs-list li {
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .specs-list li:last-child {
            border-bottom: none;
        }
        
        .spec-label {
            font-weight: 600;
            color: #555;
            min-width: 150px;
        }
        
        .spec-value {
            color: var(--primary-color);
            text-align: right;
            flex-grow: 1;
            margin-left: 20px;
        }
        
        /* Price & Actions Sidebar */
        .price-sidebar {
            position: sticky;
            top: 100px;
        }
        
        .price-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #e0e0e0;
            margin-bottom: 25px;
        }
        
        .free-badge {
            background: linear-gradient(135deg, var(--success-color) 0%, #2ecc71 100%);
            color: white;
            padding: 12px 25px;
            border-radius: 30px;
            font-size: 1.2rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
            box-shadow: 0 6px 15px rgba(39, 174, 96, 0.3);
        }
        
        .price-tag {
            font-size: 3rem;
            font-weight: 800;
            color: var(--danger-color);
            margin-bottom: 10px;
            line-height: 1;
        }
        
        .price-note {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 25px;
        }
        
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .btn-custom-lg {
            padding: 15px 25px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 10px;
            border: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .btn-custom-lg i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #2980b9 100%);
            color: white;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
        }
        
        .btn-success-custom {
            background: linear-gradient(135deg, var(--success-color) 0%, #27ae60 100%);
            color: white;
        }
        
        .btn-success-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(39, 174, 96, 0.3);
        }
        
        .secondary-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .secondary-actions .btn {
            flex: 1;
            padding: 10px;
            font-size: 0.95rem;
        }
        
        .quick-info {
            background: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            margin-top: 25px;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .info-item:last-child {
            margin-bottom: 0;
        }
        
        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e3f2fd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .info-content small {
            display: block;
            line-height: 1.4;
        }
        
        .info-content .title {
            font-weight: 600;
            color: #333;
        }
        
        .info-content .subtitle {
            color: #666;
            font-size: 0.85rem;
        }
        
        /* Author Card */
        .author-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            border: 1px solid #eee;
        }
        
        .author-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            flex-shrink: 0;
            font-size: 2rem;
            color: white;
        }
        
        /* Related Books */
        .related-books-section {
            background: #f8f9fa;
            padding: 60px 0;
            margin-top: 40px;
        }
        
        .related-book-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            height: 100%;
            border: 1px solid #eee;
            position: relative;
        }
        
        .related-book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        
        .related-book-img {
            height: 220px;
            overflow: hidden;
            position: relative;
        }
        
        .related-book-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        
        .related-book-card:hover .related-book-img img {
            transform: scale(1.1);
        }
        
        .related-book-content {
            padding: 20px;
        }
        
        .related-book-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
            line-height: 1.4;
        }
        
        .related-book-title a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .related-book-title a:hover {
            color: var(--secondary-color);
        }
        
        .related-book-author {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 15px;
        }
        
        .related-book-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }
        
        /* Preview Section */
        .preview-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin: 40px 0;
            border: 1px solid #e0e0e0;
        }
        
        .preview-images-container {
            display: flex;
            gap: 15px;
            overflow-x: auto;
            padding: 15px 0;
            scrollbar-width: thin;
            scrollbar-color: #ccc #f0f0f0;
        }
        
        .preview-images-container::-webkit-scrollbar {
            height: 8px;
        }
        
        .preview-images-container::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 4px;
        }
        
        .preview-images-container::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }
        
        .preview-img {
            width: 120px;
            height: 180px;
            border-radius: 8px;
            object-fit: cover;
            border: 3px solid #ddd;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }
        
        .preview-img:hover {
            border-color: var(--secondary-color);
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        /* Share Modal */
        .share-btn {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .share-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
            color: white;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .book-cover-container {
                max-width: 300px;
                margin: 0 auto 30px;
            }
            
            .book-meta-container {
                justify-content: center;
            }
            
            .format-badges {
                justify-content: center;
            }
            
            .btn-custom-lg {
                padding: 12px 20px;
                font-size: 1rem;
            }
            
            .related-book-img {
                height: 200px;
            }
            
            .price-tag {
                font-size: 2.5rem;
            }
        }
        
        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fadeInUp 0.6s ease forwards;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <?php 
    // Navbar is already included at the top
    // But ensure it's properly placed in the body
    ?>
    
    <!-- Book Detail Header -->
    <div class="book-detail-header">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="book-breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="shop.php">Books</a></li>
                    <li class="breadcrumb-item"><a href="shop.php?category=<?php echo $book['category_id']; ?>">
                        <?php echo htmlspecialchars($book['category_name']); ?>
                    </a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php echo htmlspecialchars($book['title']); ?>
                    </li>
                </ol>
            </nav>
            
            <div class="row align-items-center">
                <!-- Book Cover -->
                <div class="col-lg-4 col-md-5 mb-4 mb-md-0 animate-fade-in">
                    <div class="book-cover-container">
                        <?php if($book['price'] == 0 || $book['is_free_for_members'] == 1): ?>
                        <div class="book-status-badge">
                            <i class="fas fa-gift me-1"></i> FREE
                        </div>
                        <?php endif; ?>
                        <img src="../admin_panel/uploads/<?php echo $book['cover_image']; ?>" 
                             alt="<?php echo htmlspecialchars($book['title']); ?>"
                             class="book-cover"
                             onerror="this.src='img/default-book.jpg'">
                    </div>
                </div>
                
                <!-- Book Info -->
                <div class="col-lg-4 col-md-7 book-info me-5 mt-5 animate-fade-in" style="animation-delay: 0.2s;">
                    <h1 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h1>
                    <div class="book-author">
                        <i class="fas fa-user-edit me-2"></i>
                        by <?php echo htmlspecialchars($book['author']); ?>
                    </div>
                    
                    <!-- Meta Information -->
                    <div class="book-meta-container">
                        <span class="meta-item text-dark">
                            <i class="fas fa-tag me-2"></i>
                            <?php echo htmlspecialchars($book['category_name']); ?>
                        </span>
                        <span class="meta-item text-dark">
                            <i class="fas fa-bookmark me-2"></i>
                            <?php echo htmlspecialchars($book['subcategory_name']); ?>
                        </span>
                        <span class="meta-item text-dark">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Added on : <?php echo date('d M, Y', strtotime($book['created_at'])); ?>
                        </span><br>
                        <?php if($book['cd_available'] == 'Yes'): ?>
                        <span class="meta-item text-success">
                            <i class="fas fa-compact-disc me-2"></i>
                            CD Available
                        </span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Rating -->
                    <div class="rating-container">
                        <div class="rating-stars mb-2">
                            <?php
                            // Static rating - you can make it dynamic later
                            $rating = 4.5;
                            $full_stars = floor($rating);
                            $has_half = ($rating - $full_stars) >= 0.5;
                            
                            for($i = 1; $i <= 5; $i++):
                                if($i <= $full_stars):
                            ?>
                            <i class="fas fa-star"></i>
                            <?php elseif($has_half && $i == $full_stars + 1): ?>
                            <i class="fas fa-star-half-alt"></i>
                            <?php else: ?>
                            <i class="far fa-star"></i>
                            <?php endif; endfor; ?>
                        </div>
                        <div class="rating-text text-dark">
                            4.5 out of 5 (128 customer reviews)
                        </div>
                    </div>
                    
                    <!-- Book Description Preview -->
                    <div class="book-description-text text-dark">
                        <?php 
                        $short_description = substr($book['description'], 0, 300);
                        echo nl2br(htmlspecialchars($short_description));
                        if(strlen($book['description']) > 300) {
                            echo '...';
                        }
                        ?>
                    </div>
                    
                    <!-- Available Formats -->
                    <div class="mb-4">
                        <h5 class="text-light mb-3 text-dark">Available Formats:</h5>
                        <div class="format-badges">
                            <span class="format-badge text-dark">
                                <i class="fas fa-book me-2"></i> Hardcover
                            </span>
                            <?php if($book['pdf_file']): ?>
                            <span class="format-badge text-dark">
                                <i class="fas fa-file-pdf me-2"></i> PDF
                            </span>
                            <?php endif; ?>
                            <?php if($book['soft_copy_file']): ?>
                            <span class="format-badge">
                                <i class="fas fa-file-alt me-2"></i> Soft Copy
                            </span>
                            <?php endif; ?>
                            <?php if($book['cd_available'] == 'Yes'): ?>
                            <span class="format-badge">
                                <i class="fas fa-compact-disc me-2"></i> CD
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content-area">
        <div class="container">
            <div class="row">
                <!-- Left Column: Details & Description -->
                <div class="col-lg-8">
                    <!-- Detailed Description -->
                    <div class="content-section">
                        <h3 class="section-title">Book Description</h3>
                        <div class="details-card">
                            <div class="book-description-text">
                                <?php 
                                // Full description
                                echo nl2br(htmlspecialchars($book['description'])); 
                                
                                // If description is short, add more content
                                if(strlen($book['description']) < 500) {
                                    echo "\n\n<div class='mt-4 pt-3 border-top'>";
                                    echo "<h5 class='mb-3'>Why You'll Love This Book:</h5>";
                                    echo "<ul class='list-unstyled'>";
                                    echo "<li class='mb-2'><i class='fas fa-check-circle text-success me-2'></i> Comprehensive coverage of the subject</li>";
                                    echo "<li class='mb-2'><i class='fas fa-check-circle text-success me-2'></i> Engaging and accessible writing style</li>";
                                    echo "<li class='mb-2'><i class='fas fa-check-circle text-success me-2'></i> Perfect for beginners and experts alike</li>";
                                    echo "<li class='mb-2'><i class='fas fa-check-circle text-success me-2'></i> Practical examples and real-world applications</li>";
                                    echo "</ul>";
                                    echo "</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Book Specifications -->
                    <div class="content-section">
                        <h3 class="section-title">Book Specifications</h3>
                        <div class="details-card">
                            <ul class="specs-list">
                                <li>
                                    <span class="spec-label">Title:</span>
                                    <span class="spec-value"><?php echo htmlspecialchars($book['title']); ?></span>
                                </li>
                                <li>
                                    <span class="spec-label">Author:</span>
                                    <span class="spec-value"><?php echo htmlspecialchars($book['author']); ?></span>
                                </li>
                                <li>
                                    <span class="spec-label">Category:</span>
                                    <span class="spec-value"><?php echo htmlspecialchars($book['category_name']); ?></span>
                                </li>
                                <li>
                                    <span class="spec-label">Subcategory:</span>
                                    <span class="spec-value"><?php echo htmlspecialchars($book['subcategory_name']); ?></span>
                                </li>
                                <li>
                                    <span class="spec-label">Format:</span>
                                    <span class="spec-value"><?php echo htmlspecialchars($book['format_type']); ?></span>
                                </li>
                              
                               
                                <?php if($book['subscription_duration'] > 0): ?>
                                <li>
                                    <span class="spec-label">Subscription:</span>
                                    <span class="spec-value"><?php echo $book['subscription_duration']; ?> months</span>
                                </li>
                                <?php endif; ?>
                                <?php if($book['weight'] > 0): ?>
                                <li>
                                    <span class="spec-label">Weight:</span>
                                    <span class="spec-value"><?php echo $book['weight']; ?> kg</span>
                                </li>
                                <?php endif; ?>
                                <li>
                                    <span class="spec-label">Added Date:</span>
                                    <span class="spec-value"><?php echo date('F d, Y', strtotime($book['created_at'])); ?></span>
                                </li>
                                <?php if($book['is_free_for_members'] == 1): ?>
                                <li>
                                    <span class="spec-label">Member Benefit:</span>
                                    <span class="spec-value"><span class="badge bg-success">Free for Members</span></span>
                                </li>
                                <?php endif; ?>
                                <?php if($book['is_competition_winner'] == 1): ?>
                                <li>
                                    <span class="spec-label">Award:</span>
                                    <span class="spec-value"><span class="badge bg-warning">Competition Winner</span></span>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Sample Preview -->
                    <?php if($book['pdf_file']): ?>
                    <div class="content-section">
                        <h3 class="section-title">Book Preview</h3>
                        <div class="preview-section">
                            <p class="mb-4">Take a look inside this book to see what you'll be reading:</p>
                            <div class="preview-images-container">
                                <!-- Sample preview images -->
                                <img src="../admin_panel/uploads/<?php echo $book['cover_image']; ?>" 
                                     alt="Page 1" class="preview-img">
                                <img src="img/preview-sample1.jpg" alt="Page 2" class="preview-img"
                                     onerror="this.src='https://via.placeholder.com/120x180/667eea/fff?text=Preview'">
                                <img src="img/preview-sample2.jpg" alt="Page 3" class="preview-img"
                                     onerror="this.src='https://via.placeholder.com/120x180/764ba2/fff?text=Preview'">
                                <img src="img/preview-sample3.jpg" alt="Page 4" class="preview-img"
                                     onerror="this.src='https://via.placeholder.com/120x180/f093fb/fff?text=Preview'">
                                <img src="img/preview-sample4.jpg" alt="Page 5" class="preview-img"
                                     onerror="this.src='https://via.placeholder.com/120x180/4facfe/fff?text=Preview'">
                            </div>
                            <div class="mt-4 text-center">
                                <a href="../admin_panel/uploads/<?php echo $book['pdf_file']; ?>" 
                                   target="_blank" class="btn btn-outline-primary btn-lg">
                                    <i class="fas fa-eye me-2"></i> View Sample PDF
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Right Column: Price & Actions -->
                <div class="col-lg-4">
                    <div class="price-sidebar">
                        <!-- Price Card -->
                        <div class="price-card">
                            <?php if($book['price'] == 0 || $book['is_free_for_members'] == 1): ?>
                                <div class="free-badge">
                                    <i class="fas fa-gift me-2"></i> FREE BOOK
                                </div>
                                <p class="price-note">
                                    <?php if($book['is_free_for_members'] == 1): ?>
                                    <i class="fas fa-info-circle me-1"></i> Free for registered members
                                    <?php else: ?>
                                    <i class="fas fa-info-circle me-1"></i> Completely free for everyone
                                    <?php endif; ?>
                                </p>
                            <?php else: ?>
                                <div class="price-tag">
                                    $<?php echo number_format($book['price'], 2); ?>
                                </div>
                                <?php if($book['cd_price'] > 0): ?>
                                <p class="price-note">
                                    <i class="fas fa-compact-disc me-1"></i> 
                                    CD Version: <strong>$<?php echo number_format($book['cd_price'], 2); ?></strong>
                                </p>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <!-- Delivery Info -->
                            <?php if($book['delivery_charges'] > 0): ?>
                            <div class="alert alert-info mb-4">
                                <i class="fas fa-shipping-fast me-2"></i>
                                <strong>Delivery Charges:</strong> $<?php echo number_format($book['delivery_charges'], 2); ?>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <?php if($book['price'] == 0 || $book['is_free_for_members'] == 1): ?>
                                    <?php if(isset($_SESSION['user_id'])): ?>
                                    <a href="download.php?id=<?php echo $book['book_id']; ?>" 
                                    class="btn btn-success-custom btn-custom-lg">
                                    <i class="fas fa-download me-2"></i> Download Now
                                </a>
                                <?php else: ?>
                                    <a href="download.php?id=<?php echo $book['book_id']; ?>" 
                                    class="btn btn-success-custom btn-custom-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i> Download Free
                                </a>
                                <?php endif; ?>
                                <?php else: ?>
                                    <button class="btn btn-primary-custom btn-custom-lg add-to-cart-main" 
                                    data-id="<?php echo $book['book_id']; ?>"
                                            data-title="<?php echo htmlspecialchars($book['title']); ?>">
                                        <i class="fas fa-cart-plus me-2"></i> Add to Cart
                                    </button>
                                    <button class="btn btn-outline-primary btn-custom-lg buy-now-btn"
                                            data-id="<?php echo $book['book_id']; ?>">
                                        <i class="fas fa-bolt me-2"></i> Buy Now
                                    </button>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Secondary Actions -->
                            <div class="secondary-actions">
                                <button class="btn btn-outline-secondary" id="wishlistBtn">
                                    <i class="far fa-heart me-1"></i> Wishlist
                                </button>
                                <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#shareModal">
                                    <i class="fas fa-share-alt me-1"></i> Share
                                </button>
                            </div>
                        </div>
                        
                        <!-- Quick Info -->
                        <div class="quick-info">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-shield-alt text-success"></i>
                                </div>
                                <div class="info-content">
                                    <small class="title">Secure Payment</small>
                                    <small class="subtitle">100% safe & encrypted</small>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-sync-alt text-info"></i>
                                </div>
                                <div class="info-content">
                                    <small class="title">Easy Returns</small>
                                    <small class="subtitle">30-day return policy</small>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-headset text-warning"></i>
                                </div>
                                <div class="info-content">
                                    <small class="title">24/7 Support</small>
                                    <small class="subtitle">Customer support available</small>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-shipping-fast text-primary"></i>
                                </div>
                                <div class="info-content">
                                    <small class="title">Fast Delivery</small>
                                    <small class="subtitle">Free shipping on orders over $50</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Author Info -->
                        <div class="author-card mt-4">
                            <h5 class="mb-3">About the Author</h5>
                            <div class="d-flex align-items-start">
                                <div class="author-avatar">
                                    <?php echo strtoupper(substr($book['author'], 0, 1)); ?>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo htmlspecialchars($book['author']); ?></h6>
                                    <p class="text-muted small mb-2">
                                        Author of this book and several other publications in the 
                                        <?php echo htmlspecialchars($book['category_name']); ?> category.
                                    </p>
                                    <?php
                                    // Count other books by same author
                                    $author_count_query = "SELECT COUNT(*) as count FROM books WHERE author = '" . mysqli_real_escape_string($con, $book['author']) . "' AND book_id != $book_id";
                                    $author_count_result = mysqli_query($con, $author_count_query);
                                    $author_count = mysqli_fetch_assoc($author_count_result)['count'];
                                    
                                    if($author_count > 0):
                                    ?>
                                    <a href="shop.php?author=<?php echo urlencode($book['author']); ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        View <?php echo $author_count; ?> more books
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Books -->
    <?php if(mysqli_num_rows($related_result) > 0): ?>
    <div class="related-books-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="section-title text-center">Related Books</h3>
                    <p class="text-center text-muted mb-5">You might also like these books in the same category</p>
                </div>
            </div>
            <div class="row">
                <?php while($related = mysqli_fetch_assoc($related_result)): ?>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="related-book-card">
                        <div class="related-book-img">
                            <img src="../admin_panel/uploads/<?php echo $related['cover_image']; ?>" 
                                 alt="<?php echo htmlspecialchars($related['title']); ?>"
                                 onerror="this.src='img/default-book.jpg'">
                        </div>
                        <div class="related-book-content">
                            <h6 class="related-book-title">
                                <a href="book-detail.php?id=<?php echo $related['book_id']; ?>">
                                    <?php echo htmlspecialchars($related['title']); ?>
                                </a>
                            </h6>
                            <div class="related-book-author">
                                by <?php echo htmlspecialchars($related['author']); ?>
                            </div>
                            <div class="related-book-footer">
                                <?php if($related['price'] == 0): ?>
                                    <span class="badge bg-success">FREE</span>
                                <?php else: ?>
                                    <span class="text-primary fw-bold">$<?php echo number_format($related['price'], 2); ?></span>
                                <?php endif; ?>
                                <a href="book-detail.php?id=<?php echo $related['book_id']; ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Share Modal -->
    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareModalLabel">Share This Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-4">Share this book with your friends</p>
                    <div class="d-flex justify-content-center gap-3 mb-4">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" 
                           target="_blank" class="share-btn bg-primary">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text=Check out this book: <?php echo urlencode($book['title']); ?>&url=<?php echo urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" 
                           target="_blank" class="share-btn bg-info">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text=Check out this book: <?php echo urlencode($book['title'] . " - http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" 
                           target="_blank" class="share-btn bg-success">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <button class="share-btn bg-secondary" onclick="copyToClipboard()">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="shareUrl" 
                               value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" readonly>
                        <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard()">
                            <i class="fas fa-copy me-1"></i> Copy
                        </button>
                    </div>
                    <div class="alert alert-success d-none" id="copySuccess">
                        Link copied to clipboard!
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Include -->
    <?php include('includes/footer.php'); ?>


    
    <script>
    // Add to Cart Functionality
    $(document).ready(function() {
        // Add to Cart Button
        $('.add-to-cart-main').on('click', function() {
            const bookId = $(this).data('id');
            const bookTitle = $(this).data('title');
            const button = $(this);
            
            // Show loading
            const originalHTML = button.html();
            button.html('<i class="fas fa-spinner fa-spin me-2"></i> Adding...');
            button.prop('disabled', true);
            
            // AJAX request
            $.ajax({
                url: 'add-to-cart.php',
                method: 'POST',
                data: {
                    book_id: bookId,
                    action: 'add'
                },
                dataType: 'json',
                success: function(data) {
                    if(data.success) {
                        // Update cart count
                        const cartCount = $('.cart-count');
                        if(cartCount.length) {
                            let currentCount = parseInt(cartCount.text()) || 0;
                            cartCount.text(currentCount + 1);
                        }
                        
                        // Show success message
                        showNotification('success', `"${bookTitle}" added to cart successfully!`);
                    } else {
                        showNotification('error', data.message || 'Failed to add to cart');
                    }
                },
                error: function() {
                    showNotification('error', 'An error occurred. Please try again.');
                },
                complete: function() {
                    // Restore button
                    button.html(originalHTML);
                    button.prop('disabled', false);
                }
            });
        });
        
        // Buy Now Button
        $('.buy-now-btn').on('click', function() {
            const bookId = $(this).data('id');
            window.location.href = `checkout.php?book_id=${bookId}&action=buy_now`;
        });
        
        // Wishlist Button
        $('#wishlistBtn').on('click', function() {
            <?php if(isset($_SESSION['user_id'])): ?>
            const button = $(this);
            const originalHTML = button.html();
            
            button.html('<i class="fas fa-spinner fa-spin me-2"></i> Adding...');
            
            setTimeout(() => {
                button.html('<i class="fas fa-heart me-2"></i> Added to Wishlist');
                button.removeClass('btn-outline-secondary').addClass('btn-danger');
                showNotification('success', 'Book added to your wishlist!');
            }, 500);
            
            // AJAX call to add to wishlist
            $.ajax({
                url: 'add-to-wishlist.php',
                method: 'POST',
                data: { book_id: <?php echo $book_id; ?> },
                dataType: 'json'
            });
            <?php else: ?>
            window.location.href = 'login.php?redirect=' + encodeURIComponent(window.location.href);
            <?php endif; ?>
        });
        
        // Preview Image Click
        $('.preview-img').on('click', function() {
            const imgSrc = $(this).attr('src');
            showLightbox(imgSrc);
        });
        
        // View count update
        updateViewCount();
    });
    
    // Copy to Clipboard
    function copyToClipboard() {
        const copyText = document.getElementById("shareUrl");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        
        try {
            navigator.clipboard.writeText(copyText.value).then(function() {
                $('#copySuccess').removeClass('d-none');
                setTimeout(() => {
                    $('#copySuccess').addClass('d-none');
                }, 2000);
            });
        } catch(err) {
            // Fallback for older browsers
            document.execCommand("copy");
            $('#copySuccess').removeClass('d-none');
            setTimeout(() => {
                $('#copySuccess').addClass('d-none');
            }, 2000);
        }
    }
    
    // Show notification
    function showNotification(type, message) {
        // Remove existing notifications
        $('.custom-notification').remove();
        
        // Create notification
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        
        const notification = $(`
            <div class="alert ${alertClass} alert-dismissible fade show custom-notification position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <i class="fas ${icon} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        $('body').append(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.alert('close');
        }, 5000);
    }
    
    // Show lightbox
    function showLightbox(imgSrc) {
        // Remove existing lightbox
        $('#imageLightbox').remove();
        
        // Create lightbox
        const lightbox = $(`
            <div id="imageLightbox" class="lightbox-overlay">
                <div class="lightbox-content">
                    <button class="lightbox-close">&times;</button>
                    <img src="${imgSrc}" alt="Book Preview">
                </div>
            </div>
        `);
        
        $('body').append(lightbox);
        
        // Add styles if not already added
        if (!$('#lightbox-styles').length) {
            $('head').append(`
                <style id="lightbox-styles">
                    .lightbox-overlay {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(0,0,0,0.9);
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        z-index: 99999;
                        cursor: pointer;
                    }
                    .lightbox-content {
                        max-width: 90%;
                        max-height: 90%;
                        position: relative;
                    }
                    .lightbox-content img {
                        max-width: 100%;
                        max-height: 80vh;
                        border-radius: 10px;
                        box-shadow: 0 0 40px rgba(0,0,0,0.7);
                    }
                    .lightbox-close {
                        position: absolute;
                        top: -40px;
                        right: -10px;
                        background: none;
                        border: none;
                        color: white;
                        font-size: 3rem;
                        cursor: pointer;
                        z-index: 10;
                    }
                    .lightbox-close:hover {
                        color: #ffd700;
                    }
                </style>
            `);
        }
        
        // Close lightbox on click
        lightbox.on('click', function(e) {
            if (e.target === this || $(e.target).hasClass('lightbox-close')) {
                $(this).remove();
            }
        });
        
        // Close with ESC key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                $('#imageLightbox').remove();
            }
        });
    }
    
    // Update view count
    function updateViewCount() {
        $.ajax({
            url: 'update-views.php',
            method: 'POST',
            data: { book_id: <?php echo $book_id; ?> },
            dataType: 'json'
        });
    }
    </script>

