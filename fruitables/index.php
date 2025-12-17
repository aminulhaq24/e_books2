<?php
include('includes/nav.php');
?>


<!-- Hero Start -->
<div class="container-fluid py-4 mb-5 hero-header">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12 col-lg-7">
                <h4 class="mb-3" style="color: #ffd700;">
                    <i class="fas fa-star me-2"></i>Welcome to Digital Library
                </h4>
                <h1 class="mb-5 display-4 mt-4 text-white">
                    Discover & Read<br>Amazing Books Online
                </h1>
                <p class="lead text-light mt-5 me-4 mb-3">
                    Access thousands of eBooks across all genres. Read anytime, anywhere on any device.
                    Join our community of passionate readers and writers.
                </p>

                <div class="position-relative mx-auto" style="margin-top: 70px;">
                    <form action="search.php" method="GET" class="d-flex">
                        <input class="form-control border-2 border-light w-75 py-3 px-4 rounded-pill" type="text"
                            name="q" placeholder="Search books, authors, categories...">
                        <button type="submit"
                            class="btn btn-warning border-2 border-light py-3 px-4 rounded-pill text-dark fw-bold ms-2">
                            <i class="fas fa-search me-2"></i> Search
                        </button>
                    </form>
                </div>

                <div style="margin-top: 80px;">
                    <a href="register.php" class="btn btn-primary btn-lg px-4 me-3">
                        <i class="fas fa-user-plus me-2"></i>Join Free
                    </a>
                    <a href="books.php" class="btn btn-outline-light btn-lg px-4">
                        <i class="fas fa-book-open me-2"></i>Browse All Books
                    </a>
                </div>
            </div>

            <!-- carosel -->

            <div class="col-md-12 col-lg-5 rounded">
                <div id="carouselId" class="carousel slide position-relative carosel rounded" data-bs-ride="carousel">
                    <div class="carousel-inner" role="listbox rounded">
                        <div class="carousel-item active rounded">
                            <img src="img/technology1.jpg" class="img-fluid w-100 h-100 bg-secondary rounded"
                                alt="First slide">
                            <a href="#" class="btn px-4 py-2 text-white rounded">Technology</a>
                        </div>
                        <div class="carousel-item rounded">
                            <img src="img/novels.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                            <a href="#" class="btn px-4 py-2 text-white rounded">Novels</a>
                        </div>
                        <div class="carousel-item rounded">
                            <img src="img/biography.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                            <a href="#" class="btn px-4 py-2 text-white rounded">Biography</a>
                        </div>
                        <div class="carousel-item rounded">
                            <img src="img/history.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                            <a href="#" class="btn px-4 py-2 text-white rounded">History</a>
                        </div>
                        <div class="carousel-item rounded">
                            <img src="img/fiction.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                            <a href="#" class="btn px-4 py-2 text-white rounded">Fiction</a>
                        </div>
                        <div class="carousel-item rounded">
                            <img src="img/kids.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                            <a href="#" class="btn px-4 py-2 text-white rounded">Kids Learning</a>
                        </div>
                        <div class="carousel-item rounded">
                            <img src="img/poetry.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                            <a href="#" class="btn px-4 py-2 text-white rounded">Poetry</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Hero End -->

<!-- Features Section Start -->
<div class="container-fluid featurs py-3">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="featurs-item text-center rounded bg-light p-4">
                    <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                        <i class="fas fa-book-reader fa-3x text-white"></i>
                    </div>
                    <div class="featurs-content text-center">
                        <h5>Instant Access</h5>
                        <p class="mb-0">Read immediately after purchase. No shipping delays.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="featurs-item text-center rounded bg-light p-4">
                    <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                        <i class="fas fa-mobile-alt fa-3x text-white"></i>
                    </div>
                    <div class="featurs-content text-center">
                        <h5>Read Anywhere</h5>
                        <p class="mb-0">Access on phone, tablet, or computer. Sync your progress.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="featurs-item text-center rounded bg-light p-4">
                    <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                        <i class="fas fa-gift fa-3x text-white"></i>
                    </div>
                    <div class="featurs-content text-center">
                        <h5>Free Books</h5>
                        <p class="mb-0">Exclusive free books for registered members.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="featurs-item text-center rounded bg-light p-4">
                    <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                        <i class="fas fa-shield-alt fa-3x text-white"></i>
                    </div>
                    <div class="featurs-content text-center">
                        <h5>Secure Payment</h5>
                        <p class="mb-0">100% secure transactions with SSL encryption.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Features Section End -->

<!-- Books Collection Start -->
<div class="container-fluid fruite py-3">
    <div class="container py-5">
        <div class="tab-class text-center">
            <div class="row g-5">
                <div class="col-12 text-start">
                    <h1>Our Books Collection</h1>

                </div>

                <div class="tabs-wrapper position-relative col-lg-8">
                    <!-- Left Arrow -->
                    <button class="tab-arrow left-arrow">
                        <i class="fa fa-chevron-left"></i>
                    </button>

                    <!-- Right Arrow -->
                    <button class="tab-arrow right-arrow">
                        <i class="fa fa-chevron-right"></i>
                    </button>

                    <!-- Tabs Slider -->
                    <ul id="tabs-slider" class="nav nav-pills d-inline-flex text-center mb-5 tabs-slider">
                        <!-- All Books -->
                        <li class="nav-item">
                            <a class="d-flex m-1 py-2 px-3 bg-light rounded-pill active" data-bs-toggle="pill"
                                href="#tab-all">
                                <span class="text-dark" style="width: 130px;">All Books</span>
                            </a>
                        </li>

                        <?php
                            // Fetch subcategories for tabs
                            $cat_id = 22; // MAIN BOOK CATEGORY ID
                            $subQuery = "SELECT * FROM subcategories WHERE category_id = $cat_id ORDER BY subcategory_name";
                            $subcats = mysqli_query($con, $subQuery);
                            
                            while($sub = mysqli_fetch_assoc($subcats)):
                            ?>
                        <li class="nav-item">
                            <a class="d-flex m-1 py-2 px-3 bg-light rounded-pill" data-bs-toggle="pill"
                                href="#tab-<?php echo $sub['id']; ?>">
                                <span class="text-dark"
                                    style="width: 130px;"><?php echo htmlspecialchars($sub['subcategory_name']); ?></span>
                            </a>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>

            <div class="tab-content py-4">
                <!-- ALL BOOKS TAB -->
                <div id="tab-all" class="tab-pane fade show active p-0">
                    <div class="row g-4">
                        <?php
                            // Get all books with limit
                            $allBooksQuery = "SELECT books.*, subcategories.subcategory_name 
                                            FROM books 
                                            JOIN subcategories ON books.subcategory_id = subcategories.id 
                                            WHERE books.category_id = $cat_id 
                                            ORDER BY books.created_at DESC 
                                            LIMIT 8";
                            $allBooks = mysqli_query($con, $allBooksQuery);
                            
                            if(mysqli_num_rows($allBooks) > 0):
                                while($book = mysqli_fetch_assoc($allBooks)):
                            ?>
                        <div class="col-md-6 col-lg-4 col-xl-3">
    <div class="rounded position-relative fruite-item">

        <!-- IMAGE -->
        <div class="fruite-img">
            <a href="book-detail.php?id=<?php echo $book['book_id']; ?>">
                <img src="../admin_panel/uploads/<?php echo $book['cover_image']; ?>"
                     class="img-fluid w-100 rounded-top"
                     alt="<?php echo htmlspecialchars($book['title']); ?>"
                     style="height: 250px; object-fit: cover;">
            </a>
        </div>

        <!-- CATEGORY BADGE -->
        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute category-badge"
             style="top: 10px; left: 10px;">
            <?php echo htmlspecialchars($book['subcategory_name']); ?>
        </div>

        <!-- CONTENT -->
        <div class="p-4 border border-secondary border-top-0 rounded-bottom">

            <h6 class="mb-2">
                <a href="book-detail.php?id=<?php echo $book['book_id']; ?>"
                   class="text-dark text-decoration-none">
                    <?php echo htmlspecialchars($book['title']); ?>
                </a>
            </h6>

            <p class="small text-muted mb-2">
                by <?php echo htmlspecialchars($book['author']); ?>
            </p>

            <a href="book-detail.php?id=<?php echo $book['book_id']; ?>"
               class="text-muted text-decoration-none">
                <p class="small mb-3">
                    <?php
                        $description = strip_tags($book['description']);
                        echo strlen($description) > 115
                            ? substr($description, 0, 115) . '...'
                            : $description;
                    ?>
                </p>
            </a>

            <!-- PRICE / ACTION -->
            <div class="d-flex justify-content-between align-items-center">

                <?php if($book['price'] == 0 || $book['is_free_for_members'] == 1): ?>

                    <!-- FREE BOOK -->
                    <span class="badge bg-success">FREE</span>

                    <a href="download.php?id=<?php echo $book['book_id']; ?>"
                       class="btn border border-success rounded-pill px-3 text-success">
                        <i class="fa fa-download me-2"></i> Download
                    </a>

                <?php else: ?>

                    <!-- PAID BOOK -->
                    <p class="price-tag mb-0">
                        Rs <?php echo $book['price']; ?>
                    </p>

                    <a href="javascript:void(0);"
                       class="btn border border-primary rounded-pill px-3 text-primary add-to-cart"
                       data-id="<?php echo $book['book_id']; ?>"
                       data-title="<?php echo htmlspecialchars($book['title']); ?>">
                        <i class="fa fa-cart-plus me-2"></i> Add to Cart
                    </a>

                <?php endif; ?>

            </div>

        </div>
    </div>
</div>

                        <?php 
                                endwhile;
                            else:
                            ?>
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle me-2"></i>
                                No books available at the moment. Please check back later.
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="text-center" style="margin-top: 84px;">
                        <a href="shop.php" class="btn btn-primary px-5 py-3 rounded-pill">
                            <i class="fas fa-book me-2"></i> View All Books
                        </a>
                    </div>
                </div>

                <!-- SUBCATEGORY TABS -->
                <?php
                    mysqli_data_seek($subcats, 0);
                    while($sub = mysqli_fetch_assoc($subcats)):
                        $sub_id = $sub['id'];
                    ?>
                <div id="tab-<?php echo $sub_id; ?>" class="tab-pane fade p-0">
                    <div class="row g-4">
                        <?php
                            $bq = "SELECT books.*, subcategories.subcategory_name 
                                  FROM books 
                                  JOIN subcategories ON books.subcategory_id = subcategories.id 
                                  WHERE books.subcategory_id = $sub_id 
                                  ORDER BY books.created_at DESC 
                                  LIMIT 8";
                            $books = mysqli_query($con, $bq);
                            
                            if(mysqli_num_rows($books) > 0):
                                while($book = mysqli_fetch_assoc($books)):
                            ?>
                       <div class="col-md-6 col-lg-4 col-xl-3">
    <div class="rounded position-relative fruite-item">

        <!-- IMAGE -->
        <div class="fruite-img">
            <a href="book-detail.php?id=<?php echo $book['book_id']; ?>">
                <img src="../admin_panel/uploads/<?php echo $book['cover_image']; ?>"
                     class="img-fluid w-100 rounded-top"
                     alt="<?php echo htmlspecialchars($book['title']); ?>"
                     style="height: 250px; object-fit: cover;">
            </a>
        </div>

        <!-- CATEGORY BADGE -->
        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute category-badge"
             style="top: 10px; left: 10px;">
            <?php echo htmlspecialchars($book['subcategory_name']); ?>
        </div>

        <!-- CONTENT -->
        <div class="p-4 border border-secondary border-top-0 rounded-bottom">

            <h6 class="mb-2">
                <a href="book-detail.php?id=<?php echo $book['book_id']; ?>"
                   class="text-dark text-decoration-none">
                    <?php echo htmlspecialchars($book['title']); ?>
                </a>
            </h6>

            <p class="small text-muted mb-2">
                by <?php echo htmlspecialchars($book['author']); ?>
            </p>

            <a href="book-detail.php?id=<?php echo $book['book_id']; ?>"
               class="text-muted text-decoration-none">
                <p class="small mb-3">
                    <?php
                        $description = strip_tags($book['description']);
                        echo strlen($description) > 115
                            ? substr($description, 0, 115) . '...'
                            : $description;
                    ?>
                </p>
            </a>

            <!-- PRICE / ACTION -->
            <div class="d-flex justify-content-between align-items-center">

                <?php if($book['price'] == 0 || $book['is_free_for_members'] == 1): ?>

                    <!-- FREE BOOK -->
                    <span class="badge bg-success">FREE</span>

                    <a href="download.php?id=<?php echo $book['book_id']; ?>"
                       class="btn border border-success rounded-pill px-3 text-success">
                        <i class="fa fa-download me-2"></i> Download
                    </a>

                <?php else: ?>

                    <!-- PAID BOOK -->
                    <p class="price-tag mb-0">
                        Rs <?php echo $book['price']; ?>
                    </p>

                    <a href="javascript:void(0);"
                       class="btn border border-primary rounded-pill px-3 text-primary add-to-cart"
                       data-id="<?php echo $book['book_id']; ?>"
                       data-title="<?php echo htmlspecialchars($book['title']); ?>">
                        <i class="fa fa-cart-plus me-2"></i> Add to Cart
                    </a>

                <?php endif; ?>

            </div>

        </div>
    </div>
</div>

                        <?php 
                                endwhile;
                            else:
                                ?>
                                
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle me-2"></i>
                                No books available in this category yet.
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-12 text-center mt-4">
                       <a href="shop.php?subcat=<?= $sub_id ?>"
                          class="btn btn-outline-primary rounded-pill px-5">
                           View More
                       </a>
                   </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
<!-- Books Collection End -->

<!-- Statistics Banner Start -->
<div class="container-fluid banner bg-secondary my-4">
    <div class="container py-5">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="py-4">
                    <h1 class="display-3 text-white">Join Our Growing Community</h1>
                    <p class="fw-normal display-5 text-dark mb-4">Read • Learn • Grow • Win</p>
                    <p class="mb-4 text-dark">
                        With thousands of books and active competitions, we're building the largest
                        digital reading community. Be part of something amazing!
                    </p>
                    <a href="register.php"
                        class="banner-btn btn border-2 border-white rounded-pill text-dark py-3 px-5">
                        <i class="fas fa-user-plus me-2"></i> Join Now
                    </a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="bg-white p-5 rounded shadow-lg">
                    <h4 class="text-center mb-4">Live Statistics</h4>
                    <div class="row text-center">
                        <?php
                            // Live statistics
                            $stats = [];
                            
                            // Total Books
                            $result = mysqli_query($con, "SELECT COUNT(*) as total FROM books");
                            $stats['books'] = mysqli_fetch_assoc($result)['total'];
                            
                            // Total Users
                            $result = mysqli_query($con, "SELECT COUNT(*) as total FROM users");
                            $stats['users'] = mysqli_fetch_assoc($result)['total'];
                            
                            // Free Books
                            $result = mysqli_query($con, "SELECT COUNT(*) as total FROM books WHERE price = 0 OR is_free_for_members = 1");
                            $stats['free_books'] = mysqli_fetch_assoc($result)['total'];
                            
                            // Active Competitions
                            $result = mysqli_query($con, "SELECT COUNT(*) as total FROM competitions WHERE end_datetime > NOW()");
                            $stats['competitions'] = mysqli_fetch_assoc($result)['total'];
                            ?>

                        <div class="col-6 mb-4">
                            <div class="counter bg-light rounded p-3">
                                <i class="fas fa-book fa-2x text-primary mb-2"></i>
                                <h3 class="mb-0" id="stat-books"><?php echo $stats['books']; ?></h3>
                                <h6 class="text-muted">Total Books</h6>
                            </div>
                        </div>

                        <div class="col-6 mb-4">
                            <div class="counter bg-light rounded p-3">
                                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                                <h3 class="mb-0" id="stat-users"><?php echo $stats['users']; ?></h3>
                                <h6 class="text-muted">Registered Users</h6>
                            </div>
                        </div>

                        <div class="col-6 mb-4">
                            <div class="counter bg-light rounded p-3">
                                <i class="fas fa-gift fa-2x text-primary mb-2"></i>
                                <h3 class="mb-0" id="stat-free"><?php echo $stats['free_books']; ?></h3>
                                <h6 class="text-muted">Free Books</h6>
                            </div>
                        </div>

                        <div class="col-6 mb-4">
                            <div class="counter bg-light rounded p-3">
                                <i class="fas fa-trophy fa-2x text-primary mb-2"></i>
                                <h3 class="mb-0" id="stat-comp"><?php echo $stats['competitions']; ?></h3>
                                <h6 class="text-muted">Live Competitions</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Statistics Banner End -->

<!-- Competitions Section Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h4 class="text-primary">🏆 Writing Competitions</h4>
                <h1 class="display-6">Win Prizes & Get Published</h1>
            </div>
            <a href="competitions.php" class="btn btn-outline-primary btn-lg">
                View All <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>

        <div class="row g-4">
            <?php
                // Fetch active competitions
                $comp_query = "SELECT * FROM competitions 
                              WHERE end_datetime > NOW() 
                              ORDER BY start_datetime DESC 
                              LIMIT 3";
                $comp_result = mysqli_query($con, $comp_query);
                
                if(mysqli_num_rows($comp_result) > 0):
                    while($comp = mysqli_fetch_assoc($comp_result)):
                        $days_left = ceil((strtotime($comp['end_datetime']) - time()) / (60 * 60 * 24));
                ?>
            <div class="col-lg-4 col-md-6">
                <div class="competition-card bg-white p-4 rounded shadow-sm h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-danger"><?php echo htmlspecialchars($comp['type']); ?></span>
                        <?php if($days_left > 0): ?>
                        <span class="badge bg-warning text-dark">
                            <i class="fas fa-clock me-1"></i> <?php echo $days_left; ?> days left
                        </span>
                        <?php endif; ?>
                    </div>

                    <h5 class="mb-3"><?php echo htmlspecialchars($comp['title']); ?></h5>
                    <p class="text-muted mb-3"><?php echo substr($comp['description'], 0, 100); ?>...</p>

                    <div class="mb-4">
                        <h6 class="text-primary mb-2">Prizes:</h6>
                        <div class="d-flex gap-3">
                            <?php if(!empty($comp['first_prize'])): ?>
                            <div class="text-center">
                                <div class="bg-warning text-dark rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    1st
                                </div>
                                <div class="mt-1 small">$<?php echo $comp['first_prize']; ?></div>
                            </div>
                            <?php endif; ?>

                            <?php if(!empty($comp['second_prize'])): ?>
                            <div class="text-center">
                                <div class="bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    2nd
                                </div>
                                <div class="mt-1 small">$<?php echo $comp['second_prize']; ?></div>
                            </div>
                            <?php endif; ?>

                            <?php if(!empty($comp['third_prize'])): ?>
                            <div class="text-center">
                                <div class="bg-dark text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    3rd
                                </div>
                                <div class="mt-1 small">$<?php echo $comp['third_prize']; ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt me-1"></i>
                            <?php echo date('d M, Y', strtotime($comp['start_datetime'])); ?>
                        </small>
                        <a href="competition-detail.php?id=<?php echo $comp['id']; ?>" class="btn btn-sm btn-primary">
                            Participate Now
                        </a>
                    </div>
                </div>
            </div>
            <?php 
                    endwhile;
                else:
                ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    No active competitions at the moment. Check back soon!
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Competitions Section End -->

<!-- Testimonials Start -->
<div class="container-fluid testimonial py-4">
    <div class="container py-5">
        <div class="testimonial-header text-center">
            <h4 class="text-primary">Our Testimonial</h4>
            <h1 class="display-5 mb-5 text-dark">What Our Readers Say!</h1>
        </div>
        <div class="owl-carousel testimonial-carousel">
            <div class="testimonial-item img-border-radius bg-light rounded p-4">
                <div class="position-relative">
                    <i class="fa fa-quote-right fa-2x text-secondary position-absolute"
                        style="bottom: 30px; right: 0;"></i>
                    <div class="mb-4 pb-4 border-bottom border-secondary">
                        <p class="mb-0 text-dark">
                            "The collection of Islamic books helped me deepen my understanding of religion.
                            The platform is easy to use and books are well organized."
                        </p>
                    </div>
                    <div class="d-flex align-items-center flex-nowrap">
                        <div class="bg-secondary rounded">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" class="img-fluid rounded"
                                style="width: 100px; height: 100px;" alt="Ahmed Raza">
                        </div>
                        <div class="ms-4 d-block">
                            <h4 class="text-dark">Ahmed Raza</h4>
                            <p class="m-0 pb-3 text-success">Student</p>
                            <div class="d-flex pe-5">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="testimonial-item img-border-radius bg-light rounded p-4">
                <div class="position-relative">
                    <i class="fa fa-quote-right fa-2x text-secondary position-absolute"
                        style="bottom: 30px; right: 0;"></i>
                    <div class="mb-4 pb-4 border-bottom border-secondary">
                        <p class="mb-0 text-dark">
                            "As a literature student, I found amazing poetry and novels here.
                            The competitions are a great way to showcase writing skills."
                        </p>
                    </div>
                    <div class="d-flex align-items-center flex-nowrap">
                        <div class="bg-secondary rounded">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="img-fluid rounded"
                                style="width: 100px; height: 100px;" alt="Sara Khan">
                        </div>
                        <div class="ms-4 d-block">
                            <h4 class="text-dark">Sara Khan</h4>
                            <p class="m-0 pb-3 text-success">Writer</p>
                            <div class="d-flex pe-5">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="testimonial-item img-border-radius bg-light rounded p-4">
                <div class="position-relative">
                    <i class="fa fa-quote-right fa-2x text-secondary position-absolute"
                        style="bottom: 30px; right: 0;"></i>
                    <div class="mb-4 pb-4 border-bottom border-secondary">
                        <p class="mb-0 text-dark">
                            "Perfect platform for teachers. Found great educational resources
                            and my students love the interactive learning materials."
                        </p>
                    </div>
                    <div class="d-flex align-items-center flex-nowrap">
                        <div class="bg-secondary rounded">
                            <img src="https://randomuser.me/api/portraits/men/67.jpg" class="img-fluid rounded"
                                style="width: 100px; height: 100px;" alt="Bilal Ahmed">
                        </div>
                        <div class="ms-4 d-block">
                            <h4 class="text-dark">Bilal Ahmed</h4>
                            <p class="m-0 pb-3 text-success">Teacher</p>
                            <div class="d-flex pe-5">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star-half-alt text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Testimonials End -->



<?php
          include('includes/footer.php');
          ?>

          <script>

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

          </script>