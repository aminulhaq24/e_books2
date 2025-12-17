<?php
// shop.php - Complete Books Shop Page
include('includes/nav.php');



// Page title
$page_title = "Book Store - Browse All Books | ReadSphere";

// Get current page for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 12; // Books per page
$offset = ($page - 1) * $limit;

// Get filter parameters
$category_filter = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$subcategory_filter = isset($_GET['subcategory']) ? (int)$_GET['subcategory'] : 0;
$price_min = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
$price_max = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 1000;
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';

// Build SQL query
$where_conditions = ["b.category_id = 22"]; // Only books category

// Search query
if (!empty($search_query)) {
    $search_clean = mysqli_real_escape_string($con, $search_query);
    $where_conditions[] = "(b.title LIKE '%$search_clean%' OR b.author LIKE '%$search_clean%' OR b.description LIKE '%$search_clean%')";
}

// Category filter
if ($category_filter > 0) {
    $where_conditions[] = "b.category_id = $category_filter";
}

// Subcategory filter
if ($subcategory_filter > 0) {
    $where_conditions[] = "b.subcategory_id = $subcategory_filter";
}

// Price filter
$where_conditions[] = "b.price BETWEEN $price_min AND $price_max";

// Combine WHERE conditions
$where_clause = implode(" AND ", $where_conditions);

// Sorting
$order_by = "ORDER BY ";
switch ($sort_by) {
    case 'price_low':
        $order_by .= "b.price ASC";
        break;
    case 'price_high':
        $order_by .= "b.price DESC";
        break;
    case 'title':
        $order_by .= "b.title ASC";
        break;
    case 'popular':
        $order_by .= "b.book_id DESC"; // You can change this to actual popularity later
        break;
    default: // 'newest'
        $order_by .= "b.created_at DESC";
}

// Get total count for pagination
$count_query = "SELECT COUNT(*) as total FROM books b WHERE $where_clause";
$count_result = mysqli_query($con, $count_query);
$total_books = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_books / $limit);

// Main query for books
$books_query = "SELECT b.*, s.subcategory_name, c.category_name 
                FROM books b 
                JOIN subcategories s ON b.subcategory_id = s.id 
                JOIN categories c ON b.category_id = c.id 
                WHERE $where_clause 
                $order_by 
                LIMIT $limit OFFSET $offset";

$books_result = mysqli_query($con, $books_query);

// Get categories and subcategories for filters
$categories_result = mysqli_query($con, "SELECT * FROM categories WHERE id = 22");
$subcategories_result = mysqli_query($con, "SELECT * FROM subcategories WHERE category_id = 22 ORDER BY subcategory_name");
?>


<style>
/* Shop Page Specific Styles */
.page-header {
    background: linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.8)), url('img/shop-banner.jpg');
    background-size: cover;
    background-position: center;
    color: white;
    padding: 100px 0;
    margin-top: 152px;
}

@media (max-width: 992px) {
    .page-header {
        margin-top: 97px;
        padding: 60px 0;
    }
}




.book-card {
    border: 1px solid #e6e6e6;
    border-radius: 14px;
    overflow: hidden;
    background: #fff;
    height: 100%;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.book-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
}

/* IMAGE */
.book-img-container {
    height: 260px;
    overflow: hidden;
    position: relative;
}

.book-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
}

.book-card:hover .book-img {
    transform: scale(1.08);
}

/* BADGE */
.book-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: linear-gradient(135deg, #3498db, #2c80c9);
    color: #fff;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    z-index: 2;
}

.book-price {
    color: #e74c3c;
    font-size: 1.2rem;
    font-weight: 700;
}



.free-tag {
    background: #27ae60;
    color: #fff;
    padding: 4px 14px;
    font-size: 12px;
    border-radius: 20px;
    font-weight: 600;
    letter-spacing: .3px;
    margin-top: 20px;
}

.book-card .btn {
    font-size: 13px;
    padding: 6px 14px;
    border-radius: 20px;
}

/* LIST VIEW */
#booksGrid.list-view .col-xl-3,
#booksGrid.list-view .col-lg-4,
#booksGrid.list-view .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
}

#booksGrid.list-view .book-card {
    display: flex;
    gap: 20px;
}

/* #booksGrid.list-view .book-price, .free-tag {
    margin-top: 50px;
} */

#booksGrid.list-view .book-img-container {
    width: 160px;
    height: 220px;
    flex-shrink: 0;
}

#booksGrid.list-view .book-card .p-3 {
    flex: 1;
}


.filter-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    margin-bottom: 20px;
}

.filter-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #3498db;
}

.price-slider {
    width: 100%;
    margin: 15px 0;
}

.price-range {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}

.pagination .page-link {
    color: #2c3e50;
    border: 1px solid #3498db;
    margin: 0 3px;
    border-radius: 5px;
}

.pagination .page-item.active .page-link {
    background: #3498db;
    border-color: #3498db;
    color: white;
}

.pagination .page-link:hover {
    background: #f8f9fa;
}

.shop-header {
    background: white;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.sort-dropdown .dropdown-menu {
    min-width: 200px;
}

.no-books {
    padding: 50px;
    text-align: center;
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.view-options {
    display: flex;
    gap: 10px;
}

.view-btn {
    padding: 8px 15px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.view-btn.active {
    background: #3498db;
    color: white;
    border-color: #3498db;
}

.view-btn:hover {
    border-color: #3498db;
}

/* Responsive */
@media (max-width: 768px) {
    .book-img-container {
        height: 220px;
    }

    .shop-header {
        flex-direction: column;
        gap: 15px;
    }

    .sort-dropdown {
        width: 100%;
    }

    .view-options {
        justify-content: center;
    }
}
</style>



<!-- Page Header -->
<div class="container-fluid page-header">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 text-white mb-3">Our Book Store</h1>
                <p class="lead text-light mb-4">Browse our complete collection of
                    <?php echo number_format($total_books); ?>+ books</p>

                <!-- Search Bar -->
                <form action="shop.php" method="GET" class="w-75 mx-auto">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" name="q"
                            value="<?php echo htmlspecialchars($search_query); ?>"
                            placeholder="Search books by title, author, or keyword...">
                        <button class="btn btn-warning btn-lg" type="submit">
                            <i class="fas fa-search me-2"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Shop Content -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 col-md-4">
                <div class="filter-card">
                    <h5 class="filter-title"><i class="fas fa-filter me-2"></i> Filters</h5>

                    <!-- Search Again -->
                    <form id="filterForm" method="GET" action="shop.php">
                        <input type="hidden" name="q" value="<?php echo htmlspecialchars($search_query); ?>">

                        <!-- Categories -->
                        <div class="mb-4">
                            <h6 class="mb-3">Categories</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="category" value="0" id="catAll"
                                    <?php echo $category_filter == 0 ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="catAll">
                                    All Categories
                                </label>
                            </div>
                            <?php while($cat = mysqli_fetch_assoc($categories_result)): ?>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="category"
                                    value="<?php echo $cat['id']; ?>" id="cat<?php echo $cat['id']; ?>"
                                    <?php echo $category_filter == $cat['id'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="cat<?php echo $cat['id']; ?>">
                                    <?php echo htmlspecialchars($cat['category_name']); ?>
                                </label>
                            </div>
                            <?php endwhile; ?>
                        </div>

                        <!-- Subcategories -->
                        <div class="mb-4">
                            <h6 class="mb-3">Subcategories</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="subcategory" value="0" id="subAll"
                                    <?php echo $subcategory_filter == 0 ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="subAll">
                                    All Subcategories
                                </label>
                            </div>
                            <?php 
                                mysqli_data_seek($subcategories_result, 0);
                                while($sub = mysqli_fetch_assoc($subcategories_result)): 
                                ?>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="subcategory"
                                    value="<?php echo $sub['id']; ?>" id="sub<?php echo $sub['id']; ?>"
                                    <?php echo $subcategory_filter == $sub['id'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="sub<?php echo $sub['id']; ?>">
                                    <?php echo htmlspecialchars($sub['subcategory_name']); ?>
                                </label>
                            </div>
                            <?php endwhile; ?>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-4">
                            <h6 class="mb-3">Price Range</h6>
                            <input type="range" class="price-slider" min="0" max="1000" step="10" name="min_price"
                                value="<?php echo $price_min; ?>">
                            <input type="range" class="price-slider" min="0" max="1000" step="10" name="max_price"
                                value="<?php echo $price_max; ?>">
                            <div class="price-range">
                                <span>$<?php echo $price_min; ?></span>
                                <span>$<?php echo $price_max; ?></span>
                            </div>
                        </div>

                        <!-- Sort By -->
                        <div class="mb-4">
                            <h6 class="mb-3">Sort By</h6>
                            <select class="form-select" name="sort">
                                <option value="newest" <?php echo $sort_by == 'newest' ? 'selected' : ''; ?>>Newest
                                    First</option>
                                <option value="price_low" <?php echo $sort_by == 'price_low' ? 'selected' : ''; ?>>
                                    Price: Low to High</option>
                                <option value="price_high" <?php echo $sort_by == 'price_high' ? 'selected' : ''; ?>>
                                    Price: High to Low</option>
                                <option value="title" <?php echo $sort_by == 'title' ? 'selected' : ''; ?>>Title A-Z
                                </option>
                                <option value="popular" <?php echo $sort_by == 'popular' ? 'selected' : ''; ?>>Most
                                    Popular</option>
                            </select>
                        </div>

                        <!-- Filter Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check me-2"></i> Apply Filters
                            </button>
                            <a href="shop.php" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i> Clear All
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Quick Stats -->
                <div class="filter-card">
                    <h5 class="filter-title"><i class="fas fa-chart-bar me-2"></i> Quick Stats</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-book text-primary me-2"></i>
                            <strong><?php echo number_format($total_books); ?></strong> Total Books
                        </li>
                        <?php
                            // Count free books
                            $free_query = "SELECT COUNT(*) as free FROM books WHERE price = 0 OR is_free_for_members = 1";
                            $free_result = mysqli_query($con, $free_query);
                            $free_count = mysqli_fetch_assoc($free_result)['free'];
                            ?>
                        <li class="mb-2">
                            <i class="fas fa-gift text-success me-2"></i>
                            <strong><?php echo $free_count; ?></strong> Free Books
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-tags text-warning me-2"></i>
                            <strong><?php echo mysqli_num_rows($subcategories_result); ?></strong> Categories
                        </li>
                        <li>
                            <i class="fas fa-user text-info me-2"></i>
                            <?php echo number_format(rand(1000, 5000)); ?>+ Happy Readers
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 col-md-8">
                <!-- Shop Header -->
                <div class="shop-header d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h4 class="mb-0">Showing <?php echo number_format($total_books); ?> Books</h4>
                        <?php if(!empty($search_query)): ?>
                        <p class="text-muted mb-0">Search results for:
                            "<strong><?php echo htmlspecialchars($search_query); ?></strong>"</p>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex align-items-center">
                        <!-- View Options -->
                        <div class="view-options me-3">
                            <span class="view-btn active" data-view="grid">
                                <i class="fas fa-th-large"></i>
                            </span>
                            <span class="view-btn" data-view="list">
                                <i class="fas fa-list"></i>
                            </span>
                        </div>

                        <!-- Sort Dropdown -->
                        <div class="sort-dropdown">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="fas fa-sort me-2"></i>
                                    <?php 
                                        $sort_labels = [
                                            'newest' => 'Newest First',
                                            'price_low' => 'Price: Low to High',
                                            'price_high' => 'Price: High to Low',
                                            'title' => 'Title A-Z',
                                            'popular' => 'Most Popular'
                                        ];
                                        echo $sort_labels[$sort_by];
                                        ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="?sort=newest<?php echo !empty($search_query) ? '&q=' . urlencode($search_query) : ''; ?>">Newest
                                            First</a></li>
                                    <li><a class="dropdown-item"
                                            href="?sort=price_low<?php echo !empty($search_query) ? '&q=' . urlencode($search_query) : ''; ?>">Price:
                                            Low to High</a></li>
                                    <li><a class="dropdown-item"
                                            href="?sort=price_high<?php echo !empty($search_query) ? '&q=' . urlencode($search_query) : ''; ?>">Price:
                                            High to Low</a></li>
                                    <li><a class="dropdown-item"
                                            href="?sort=title<?php echo !empty($search_query) ? '&q=' . urlencode($search_query) : ''; ?>">Title
                                            A-Z</a></li>
                                    <li><a class="dropdown-item"
                                            href="?sort=popular<?php echo !empty($search_query) ? '&q=' . urlencode($search_query) : ''; ?>">Most
                                            Popular</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Books Grid -->
                <div class="row" id="booksGrid">
                    <?php if(mysqli_num_rows($books_result) > 0): ?>
                    <?php while($book = mysqli_fetch_assoc($books_result)): ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-4">
                        <div class="book-card">
                            <!-- Book Image -->
                            <a href="book-detail.php?id=<?php echo $book['book_id']; ?>">
                                <div class="book-img-container">
                                    <img src="../admin_panel/uploads/<?php echo $book['cover_image']; ?>"
                                        alt="<?php echo htmlspecialchars($book['title']);  ?>" class="book-img"
                                        onerror="this.src='img/default-book.jpg'">

                                    <span class="book-badge">
                                        <?php echo htmlspecialchars($book['subcategory_name']); ?>
                                    </span>

                                </div>

                                <!-- Book Details -->
                                <div class="p-3">
                                    <h6 class="mb-2">
                                        <a href="book-detail.php?id=<?php echo $book['book_id']; ?>"
                                            class="text-dark text-decoration-none">
                                            <?php echo htmlspecialchars($book['title']); ?>
                                    </h6>
                                    <p class="small text-muted mb-2">
                                        <i class="fas fa-user-edit me-1"></i>
                                        <?php echo htmlspecialchars($book['author']); ?>
                                    </p>
                                    <p class="small text-muted mb-3">
                                        <?php 
                                            $desc = strip_tags($book['description']);
                                            echo strlen($desc) > 110 ? substr($desc, 0, 110) . '...' : $desc;
                                            ?>
                                    </p>


                                    <!-- Price & Actions -->
                                    <div class="d-flex mt-5 justify-content-between align-items-center">

                                        <?php 
                                    $isFree = ($book['price'] == 0 || $book['is_free_for_members'] == 1);
                                     ?>

                                        <!-- PRICE / FREE TAG -->
                                        <?php if($isFree): ?>
                                        <span class="free-tag">FREE</span>
                                        <?php else: ?>
                                        <span class="book-price ">Rs <?php echo $book['price']; ?></span>
                                        <?php endif; ?>

                                        <!-- ACTION BUTTON -->
                                        <div>
                                            <?php if($isFree): ?>

                                            <!-- FREE BOOK -->
                                            <a href="download.php?id=<?php echo $book['book_id']; ?>"
                                                class="btn btn-sm btn-success rounded-pill px-3">
                                                <i class="fas fa-download me-1"></i> Download Now
                                            </a>

                                            <?php else: ?>

                                            <!-- PAID BOOK -->
                                            <a href="javascript:void(0);"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3 add-to-cart"
                                                data-id="<?php echo $book['book_id']; ?>"
                                                data-title="<?php echo htmlspecialchars($book['title']); ?>">
                                                <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                            </a>


                                            <?php endif; ?>
                                        </div>

                                    </div>

                                </div>
                            </a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <div class="col-12">
                        <div class="no-books">
                            <i class="fas fa-book-open fa-4x text-muted mb-4"></i>
                            <h4>No Books Found</h4>
                            <p class="text-muted mb-4">
                                <?php if(!empty($search_query)): ?>
                                No books found for "<?php echo htmlspecialchars($search_query); ?>". Try different
                                keywords.
                                <?php else: ?>
                                No books available at the moment. Please check back later.
                                <?php endif; ?>
                            </p>
                            <a href="shop.php" class="btn btn-primary">
                                <i class="fas fa-book me-2"></i> Browse All Books
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <?php if($total_pages > 1): ?>
                <nav aria-label="Page navigation" class="mt-5">
                    <ul class="pagination justify-content-center">
                        <!-- Previous Button -->
                        <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link"
                                href="?page=<?php echo $page-1; ?><?php echo !empty($search_query) ? '&q=' . urlencode($search_query) : ''; ?><?php echo $category_filter ? '&category=' . $category_filter : ''; ?><?php echo $subcategory_filter ? '&subcategory=' . $subcategory_filter : ''; ?>&sort=<?php echo $sort_by; ?>">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>

                        <!-- Page Numbers -->
                        <?php 
                            $start_page = max(1, $page - 2);
                            $end_page = min($total_pages, $page + 2);
                            
                            for($i = $start_page; $i <= $end_page; $i++): 
                            ?>
                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                            <a class="page-link"
                                href="?page=<?php echo $i; ?><?php echo !empty($search_query) ? '&q=' . urlencode($search_query) : ''; ?><?php echo $category_filter ? '&category=' . $category_filter : ''; ?><?php echo $subcategory_filter ? '&subcategory=' . $subcategory_filter : ''; ?>&sort=<?php echo $sort_by; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                        <?php endfor; ?>

                        <!-- Next Button -->
                        <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                            <a class="page-link"
                                href="?page=<?php echo $page+1; ?><?php echo !empty($search_query) ? '&q=' . urlencode($search_query) : ''; ?><?php echo $category_filter ? '&category=' . $category_filter : ''; ?><?php echo $subcategory_filter ? '&subcategory=' . $subcategory_filter : ''; ?>&sort=<?php echo $sort_by; ?>">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                    <p class="text-center text-muted mt-2">
                        Page <?php echo $page; ?> of <?php echo $total_pages; ?>
                        (Showing <?php echo ($offset + 1); ?>-<?php echo min($offset + $limit, $total_books); ?> of
                        <?php echo number_format($total_books); ?> books)
                    </p>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Footer Include -->
<?php
   include('includes/footer.php');
   ?>

<!-- JavaScript Libraries -->


<script>
// View Toggle (Grid/List)
document.querySelectorAll('.view-btn').forEach(btn => {
    btn.addEventListener('click', function() {

        document.querySelectorAll('.view-btn')
            .forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const booksGrid = document.getElementById('booksGrid');

        if (this.dataset.view === 'list') {
            booksGrid.classList.add('list-view');
        } else {
            booksGrid.classList.remove('list-view');
        }
    });
});


// Add to Cart Functionality
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const bookId = this.getAttribute('data-id');
        const bookTitle = this.getAttribute('data-title');

        const originalHTML = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        this.disabled = true;

        fetch('add-to-cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `book_id=${bookId}&action=add`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {


                    // Update cart count in navbar using server response
                    const cartCount = document.querySelector(
                            '.position-relative .position-absolute span') ||
                        document.querySelector('.position-relative span');
                    if (cartCount) {
                        cartCount.textContent = data.cart_count;
                    }

                    alert(`"${bookTitle}" added to cart successfully!`);
                } else {
                    alert(data.message || 'Failed to add to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            })
            .finally(() => {
                this.innerHTML = originalHTML;
                this.disabled = false;
            });
    });
});


// Price Slider Update Display
const priceSliders = document.querySelectorAll('.price-slider');
const priceDisplay = document.querySelector('.price-range');

priceSliders.forEach(slider => {
    slider.addEventListener('input', function() {
        const minPrice = document.querySelector('input[name="min_price"]').value;
        const maxPrice = document.querySelector('input[name="max_price"]').value;

        if (priceDisplay) {
            priceDisplay.innerHTML = `<span>$${minPrice}</span><span>$${maxPrice}</span>`;
        }
    });
});

// Auto-submit filter form on some changes
document.querySelector('select[name="sort"]').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});

// Filter form submission
document.getElementById('filterForm').addEventListener('submit', function(e) {
    // Ensure min price is less than max price
    const minPrice = parseFloat(document.querySelector('input[name="min_price"]').value);
    const maxPrice = parseFloat(document.querySelector('input[name="max_price"]').value);

    if (minPrice > maxPrice) {
        e.preventDefault();
        alert('Minimum price cannot be greater than maximum price');
    }
});
</script>