<?php
// dashboard.php - Simple but functional

include('includes/nav.php');
?>

<div class="container-fluid">
    <h1 class="mt-4">Dashboard</h1>
    
    <div class="row mt-4">
        <!-- Quick Stats -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Books</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                $result = mysqli_query($con, "SELECT COUNT(*) FROM books");
                                echo mysqli_fetch_row($result)[0];
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- More stats... -->
    </div>
    
    <!-- Recent Orders -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Recent Orders</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Book</th>
                            <th>Format</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT o.*, u.name, b.title 
                                  FROM orders o 
                                  JOIN users u ON o.user_id = u.id 
                                  JOIN books b ON o.book_id = b.book_id 
                                  ORDER BY o.placed_at DESC LIMIT 5";
                        $result = mysqli_query($con, $query);
                        while($row = mysqli_fetch_assoc($result)):
                        ?>
                        <tr>
                            <td>#<?= $row['id'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['title'] ?></td>
                            <td>
                                <span class="badge bg-<?= $row['order_type'] == 'PDF' ? 'danger' : 'success' ?>">
                                    <?= $row['order_type'] ?>
                                </span>
                            </td>
                            <td>Rs <?= number_format($row['total_amount']) ?></td>
                            <td>
                                <span class="badge bg-<?= 
                                $row['status'] == 'DELIVERED' ? 'success' : 
                                ($row['status'] == 'PENDING' ? 'warning' : 'info') ?>">
                                    <?= $row['status'] ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>