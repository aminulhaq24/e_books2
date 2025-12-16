<?php
include('includes/nav.php');

// Count Queries
$total_books = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM books"))['total'];
$free_books = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM books WHERE price = 0"))['total'];
$paid_books = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM books WHERE price > 0"))['total'];
$total_categories = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM categories"))['total'];
$total_subcategories = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM subcategories"))['total'];

// Format-wise counts
$pdf_books = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM books WHERE format_type = 'PDF'"))['total'];
$hardcopy_books = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM books WHERE format_type = 'HARDCOPY'"))['total'];
$cd_books = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM books WHERE format_type = 'CD'"))['total'];

// Recent orders
$recent_orders = mysqli_query($con, "
SELECT o.*, u.name, b.title, b.format_type 
FROM orders o 
JOIN users u ON o.user_id = u.id 
JOIN books b ON o.book_id = b.book_id 
ORDER BY o.placed_at DESC LIMIT 5
");

// Latest books
$latest_books = mysqli_query($con, "
SELECT books.*, 
       categories.category_name, 
       subcategories.subcategory_name
FROM books
JOIN categories ON books.category_id = categories.id
JOIN subcategories ON books.subcategory_id = subcategories.id 
ORDER BY book_id DESC 
LIMIT 5
");
?>

<style>
/* Dashboard Styles */
.dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    color: white;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.dashboard-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.dashboard-subtitle {
    opacity: 0.9;
    font-size: 1.1rem;
}

/* Stats Cards */
.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border-left: 4px solid;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
}

.stat-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    display: inline-block;
    padding: 15px;
    border-radius: 12px;
    background: rgba(0, 0, 0, 0.05);
}

.stat-number {
    font-size: 2.2rem;
    font-weight: 700;
    margin: 0.5rem 0;
    color: #2c3e50;
}

.stat-label {
    color: #7f8c8d;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
}

/* Format Cards */
.format-card {
    border-radius: 12px;
    padding: 1.2rem;
    text-align: center;
    color: white;
    margin-bottom: 1rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.format-card.pdf {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
}

.format-card.hardcopy {
    background: linear-gradient(135deg, #1dd1a1 0%, #10ac84 100%);
}

.format-card.cd {
    background: linear-gradient(135deg, #54a0ff 0%, #2e86de 100%);
}

.format-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.format-count {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0.5rem 0;
}

/* Tables */
.table-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    margin-bottom: 2rem;
}

.table-card .card-header {
    background: transparent;
    border-bottom: 2px solid #f1f2f6;
    padding: 1rem 0;
    margin-bottom: 1.5rem;
}

.table-card .card-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.custom-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.custom-table th {
    background: #f8f9fa;
    padding: 1rem;
    font-weight: 600;
    color: #495057;
    border: none;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.custom-table td {
    padding: 1rem;
    border-bottom: 1px solid #f1f2f6;
    vertical-align: middle;
}

.custom-table tr:last-child td {
    border-bottom: none;
}

.custom-table tr:hover {
    background-color: #f8f9fa;
}

/* Book Thumbnail */
.book-thumb {
    width: 60px;
    height: 75px;
    border-radius: 8px;
    object-fit: cover;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.book-thumb:hover {
    transform: scale(1.05);
}

/* Status Badges */
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-block;
}

.badge-delivered {
    background: #d4edda;
    color: #155724;
}

.badge-pending {
    background: #fff3cd;
    color: #856404;
}

.badge-processing {
    background: #cce5ff;
    color: #004085;
}

.badge-cancelled {
    background: #f8d7da;
    color: #721c24;
}

/* Format Badges */
.format-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
}

.badge-pdf {
    background: #ffeaa7;
    color: #e17055;
}

.badge-hardcopy {
    background: #a29bfe;
    color: #6c5ce7;
}

.badge-cd {
    background: #fd79a8;
    color: #d63031;
}

/* Quick Actions */
.quick-actions {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.action-btn {
    display: block;
    padding: 1.2rem;
    margin-bottom: 1rem;
    border-radius: 10px;
    background: #f8f9fa;
    text-align: center;
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.action-btn:hover {
    background: #667eea;
    color: white;
    transform: translateX(5px);
    text-decoration: none;
    border-color: #667eea;
}

.action-icon {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    display: block;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-title {
        font-size: 2rem;
    }

    .stat-number {
        font-size: 1.8rem;
    }

    .table-card {
        padding: 1rem;
    }
}
</style>

<div class="container-fluid py-4 px-3 px-md-4">

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1 class="dashboard-title">📊 Dashboard Overview</h1>
        <p class="dashboard-subtitle">Welcome back,
            <?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Administrator'); ?>! Here's what's happening with
            your eBook system.</p>
        <small><i class="fas fa-clock me-1"></i> Last updated: <?php echo date('F j, Y \a\t g:i A'); ?></small>
    </div>

    <!-- Main Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card" style="border-left-color: #667eea;">
                <div class="stat-icon text-primary">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-number"><?php echo $total_books; ?></div>
                <div class="stat-label">Total Books</div>
                <small class="text-muted"><?php echo $free_books; ?> free • <?php echo $paid_books; ?> paid</small>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="stat-card" style="border-left-color: #1dd1a1;">
                <div class="stat-icon text-success">
                    <i class="fas fa-folder"></i>
                </div>
                <div class="stat-number"><?php echo $total_categories; ?></div>
                <div class="stat-label">Categories</div>
                <small class="text-muted"><?php echo $total_subcategories; ?> subcategories</small>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="stat-card" style="border-left-color: #ff9ff3;">
                <div class="stat-icon text-info">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <?php
                $total_orders = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as total FROM orders"))['total'];
                $pending_orders = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as total FROM orders WHERE status = 'PENDING'"))['total'];
                ?>
                <div class="stat-number"><?php echo $total_orders; ?></div>
                <div class="stat-label">Total Orders</div>
                <small class="text-muted"><?php echo $pending_orders; ?> pending</small>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="stat-card" style="border-left-color: #feca57;">
                <div class="stat-icon text-warning">
                    <i class="fas fa-users"></i>
                </div>
                <?php
                $total_users = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as total FROM users WHERE role = 'user'"))['total'];
                ?>
                <div class="stat-number"><?php echo $total_users; ?></div>
                <div class="stat-label">Registered Users</div>
                <small class="text-muted">Customer accounts</small>
            </div>
        </div>
    </div>

    <!-- Format Distribution & Quick Actions -->
    <div class="row g-4 mb-4">
        <!-- Format Distribution -->
        <div class="col-lg-8">
            <div class="table-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title"><i class="fas fa-chart-pie me-2"></i> Book Format Distribution</h5>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="format-card pdf">
                            <div class="format-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="format-count"><?php echo $pdf_books; ?></div>
                            <div>PDF eBooks</div>
                            <small><?php echo round(($pdf_books/$total_books)*100, 1); ?>% of total</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="format-card hardcopy">
                            <div class="format-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="format-count"><?php echo $hardcopy_books; ?></div>
                            <div>Hard Copies</div>
                            <small><?php echo round(($hardcopy_books/$total_books)*100, 1); ?>% of total</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="format-card cd">
                            <div class="format-icon">
                                <i class="fas fa-compact-disc"></i>
                            </div>
                            <div class="format-count"><?php echo $cd_books; ?></div>
                            <div>CD Versions</div>
                            <small><?php echo round(($cd_books/$total_books)*100, 1); ?>% of total</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="quick-actions">
                <h5 class="mb-4"><i class="fas fa-bolt me-2"></i> Quick Actions</h5>
                <a href="upload_book.php" class="action-btn">
                    <i class="fas fa-upload action-icon"></i>
                    Upload New Book
                </a>
                <a href="manage_competitions.php" class="action-btn">
                    <i class="fas fa-trophy action-icon"></i>
                    Create Competition
                </a>
                <a href="view_orders.php" class="action-btn">
                    <i class="fas fa-shopping-cart action-icon"></i>
                    View Orders
                </a>
                <a href="manage_pdf_access.php" class="action-btn">
                    <i class="fas fa-file-pdf action-icon"></i>
                    Manage PDF Access
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="row g-4 mb-4">
        <div class="col-lg-12">
            <div class="table-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title"><i class="fas fa-history me-2"></i> Recent Orders</h5>
                    <a href="view_orders.php" class="btn btn-sm btn-outline-primary">View All</a>
                </div>

                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Book</th>
                                <th>Format</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($recent_orders) > 0): ?>
                            <?php while($order = mysqli_fetch_assoc($recent_orders)): ?>
                            <tr>
                                <td><strong>#<?= $order['id'] ?></strong></td>
                                <td><?= htmlspecialchars($order['name']) ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="../admin_panel/uploads/<?= $order['cover_image'] ?? 'default-book.jpg' ?>"
                                            class="book-thumb me-3" alt="Book Cover">
                                        <div>
                                            <div class="fw-bold">
                                                <?= htmlspecialchars(substr($order['title'], 0, 30)) ?><?= strlen($order['title']) > 30 ? '...' : '' ?>
                                            </div>
                                            <small class="text-muted"><?= $order['format_type'] ?? 'HARDCOPY' ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="format-badge badge-<?= strtolower($order['order_type']) ?>">
                                        <?= $order['order_type'] ?>
                                    </span>
                                </td>
                                <td class="fw-bold">Rs <?= number_format($order['total_amount']) ?></td>
                                <td><?= date('M j, g:i A', strtotime($order['placed_at'])) ?></td>
                                <td>
                                    <?php
                                        $status_class = 'badge-pending';
                                        if($order['status'] == 'DELIVERED') $status_class = 'badge-delivered';
                                        if($order['status'] == 'PROCESSING') $status_class = 'badge-processing';
                                        if($order['status'] == 'CANCELLED') $status_class = 'badge-cancelled';
                                        ?>
                                    <span class="status-badge <?= $status_class ?>">
                                        <?= $order['status'] ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-shopping-cart fa-2x mb-3"></i>
                                    <p>No orders yet. Orders will appear here once customers start purchasing.</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Books -->
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="table-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title"><i class="fas fa-book-open me-2"></i> Recently Added Books</h5>
                    <a href="book_lists.php" class="btn btn-sm btn-outline-primary">View All Books</a>
                </div>

                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Cover</th>
                                <th>Title & Author</th>
                                <th>Category</th>
                                <th>Format</th>
                                <th>Files</th>
                                <th>Price</th>
                                <th>Added On</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($latest_books) > 0): ?>
                            <?php while($book = mysqli_fetch_assoc($latest_books)): ?>
                            <tr>
                                <td>
                                    <img src="../admin_panel/uploads/<?= $book['cover_image'] ?? 'default-book.jpg' ?>"
                                        class="book-thumb" alt="Book Cover">
                                </td>
                                <td>
                                    <div class="fw-bold">
                                        <?= htmlspecialchars(substr($book['title'], 0, 35)) ?><?= strlen($book['title']) > 35 ? '...' : '' ?>
                                    </div>
                                    <small class="text-muted">by <?= htmlspecialchars($book['author']) ?></small>
                                </td>
                                <td><?= $book['category_name'] ?> / <?= $book['subcategory_name']; ?></td>
                                <td>
                                    <span
                                        class="format-badge badge-<?= strtolower($book['format_type'] ?? 'hardcopy') ?>">
                                        <?= $book['format_type'] ?? 'HARDCOPY' ?>
                                    </span>
                                    <?php if($book['is_free_for_members']): ?>
                                    <span class="badge bg-success mt-1">Free for Members</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(!empty($book['pdf_file'])) { ?>
                                    <a href="uploads/<?php echo $book['pdf_file']; ?>" target="_blank"
                                        class="btn btn-primary p-1 action-btn">PDF</a>
                                    <?php } ?>

                                    <?php if($book['cd_available']=='Yes') { ?>
                                    <span class="badge bg-warning text-dark">CD</span>
                                    <?php } ?>
                                </td>

                                <td class="fw-bold"> <?php 
                                if($book['price'] == 0) 
                                   echo "<span class='text-success'>FREE</span>";
                                  else 
                                  echo "Rs. " . $book['price'];
                                 ?></td>
                                <td><?= date('M j, Y', strtotime($book['created_at'])) ?></td>
                               

                            </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-book fa-2x mb-3"></i>
                                    <p>No books added yet. Start by uploading your first book!</p>
                                    <a href="upload_book.php" class="btn btn-primary mt-2">Upload First Book</a>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
include('includes/footer.php');
?>