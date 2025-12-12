<?php
include('includes/nav.php');

?>



<!-- Page Header -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Books Shop</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active text-white">Shop</li>
    </ol>
</div>
<!-- Page Header End -->

<!-- Shop Start -->
<div class="container-fluid fruite py-5">
    <div class="container py-5">

        <div class="row g-4">

            <!-- SIDEBAR: SUBCATEGORIES -->
            <div class="col-lg-3">
                <h4 class="mb-3">Subcategories</h4>

                <?php
    // Fetch subcategories with parent category
    $subcatQuery = "
        SELECT sc.id, sc.subcategory_name, c.category_name
        FROM subcategories sc
        LEFT JOIN categories c ON sc.category_id = c.id
        ORDER BY c.category_name ASC, sc.subcategory_name ASC
    ";

    $subcats = mysqli_query($con, $subcatQuery);

    $currentCat = "";

    echo '<ul class="list-unstyled fruite-categorie">';

    while ($row = mysqli_fetch_assoc($subcats)) {

        // New category heading
        if ($currentCat != $row['category_name']) {

            // Close previous category <ul>
            if ($currentCat != "") {
                echo "</ul></li>";
            }

            // Category Name
            echo "<li class='mt-2'>
                    <strong>{$row['category_name']}</strong>
                    <ul class='list-unstyled ms-3'>";

            $currentCat = $row['category_name'];
        }

        // Subcategory Entry
        echo "
            <li>
                <a href='shop.php?subcat={$row['id']}'>
                    <i class='fas fa-book me-2'></i> {$row['subcategory_name']}
                </a>
            </li>
        ";
    }

    // close last opened lists
    if ($currentCat != "") {
        echo "</ul></li>";
    }

    echo "</ul>";
    ?>
            </div>


            <!-- MAIN PRODUCTS LIST -->
            <div class="col-lg-9">

                <?php
                // CATEGORY FILTER
               $where = "";

if (isset($_GET['subcat'])) {
    // FILTER BY SUBCATEGORY
    $sid = intval($_GET['subcat']);
    $where = "WHERE subcategory_id = $sid";
}

else if (isset($_GET['cat_id'])) {
    // FILTER BY CATEGORY (OPTIONAL)
    $cid = intval($_GET['cat_id']);
    $where = "WHERE category_id = $cid";
}

                // FETCH BOOKS
                $bookQuery = "SELECT * FROM books $where ORDER BY book_id DESC";
                $books = mysqli_query($con, $bookQuery);

                echo "<h2 class='mb-4'>All Books</h2>";
                ?>

                <div class="row g-4">

                    <?php
                    if (mysqli_num_rows($books) > 0) {
                        while ($book = mysqli_fetch_assoc($books)) {
                            ?>

                    <div class="col-md-4">
                        <div class="card rounded shadow-sm book-card">
                            <img src="../admin_panel/uploads/<?= $book['cover_image']; ?>" class="card-img-top"
                                style="height: 250px; object-fit: cover;">

                            <div class="card-body">
                                <h5 class="card-title"><?php echo $book['title']; ?></h5>

                                <p class="text-muted small">
                                    <?php echo substr($book['description'], 0, 60); ?>...
                                </p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="text-primary mb-0"><?php echo $book['price']; ?> PKR</h5>
                                    <a href="book_detail.php?id=<?php echo $book['book_id']; ?>"
                                        class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        }
                    } else {
                        echo "<h4 class='text-center text-danger'>No books found!</h4>";
                    }
                    ?>
                </div>

            </div>
        </div>

    </div>
</div>
<!-- Shop End -->

<?php include('includes/footer.php'); ?>