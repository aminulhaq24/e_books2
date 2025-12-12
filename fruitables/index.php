<?php
include('includes/nav.php');
?>


<!-- Hero Start -->
<div class="container-fluid py-5 mb-5 hero-header ">

    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-md-12 col-lg-7">
                <h4 class="mb-3" style="color: #eb6134;">100% Organic Foods</h4>
                <h1 class="mb-5 display-3 text-primary">Organic Veggies & Fruits Foods</h1>
                <div class="position-relative mx-auto">
                    <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="number"
                        placeholder="Search">
                    <button type="submit"
                        class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100"
                        style="top: 0; right: 25%;">Submit Now</button>
                </div>
            </div>
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
                    <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselId"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselId"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->


<!-- Featurs Section Start -->
<div class="container-fluid featurs py-3">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="featurs-item text-center rounded bg-light p-4">
                    <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                        <i class="fas fa-car-side fa-3x text-white"></i>
                    </div>
                    <div class="featurs-content text-center">
                        <h5>Free Shipping</h5>
                        <p class="mb-0">Free on order over $300</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="featurs-item text-center rounded bg-light p-4">
                    <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                        <i class="fas fa-user-shield fa-3x text-white"></i>
                    </div>
                    <div class="featurs-content text-center">
                        <h5>Security Payment</h5>
                        <p class="mb-0">100% security payment</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="featurs-item text-center rounded bg-light p-4">
                    <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                        <i class="fas fa-exchange-alt fa-3x text-white"></i>
                    </div>
                    <div class="featurs-content text-center">
                        <h5>30 Day Return</h5>
                        <p class="mb-0">30 day money guarantee</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="featurs-item text-center rounded bg-light p-4">
                    <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                        <i class="fa fa-phone-alt fa-3x text-white"></i>
                    </div>
                    <div class="featurs-content text-center">
                        <h5>24/7 Support</h5>
                        <p class="mb-0">Support every time fast</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Featurs Section End -->


<!-- Fruits Shop Start-->
<div class="container-fluid fruite py-3">
    <div class="container py-5">
        <div class="tab-class text-center">
            <div class="row g-5">
                <div class="col-lg-4 text-start">
                    <h1>Our Books Collection</h1>
                </div>

                <div class="tabs-wrapper position-relative">

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
         // Multiple main categories support
        //  $categories = [22]; // <-- Yahan jitni marzi main categories add kar do
        //  $cat_ids = implode(",", $categories);

        //  $subQuery = "SELECT * FROM subcategories WHERE category_id IN ($cat_ids)";
        //  $subcats = mysqli_query($con, $subQuery);
               
        //  ---------------********---------
            // second method 
            
         //  (2 Main Categories ke Subcategories Fetch karne ke liye)

                        // $cat_ids = "22, 23";      // yahan jitni chahein categories add kar sakte hain

                        //  $subQuery = "SELECT * FROM subcategories WHERE category_id IN ($cat_ids)";
                        //  $subcats = mysqli_query($con, $subQuery);


                             $cat_id = 22; // MAIN BOOK CATEGORY ID
                             $subQuery = "SELECT * FROM subcategories WHERE category_id = $cat_id";
                             $subcats = mysqli_query($con, $subQuery);
                        
                             while($sub = mysqli_fetch_assoc($subcats)) {
                             ?>
                        <li class="nav-item">
                            <a class="d-flex m-1 py-2 px-3 bg-light rounded-pill" data-bs-toggle="pill"
                                href="#tab-<?= $sub['id'] ?>">
                                <span class="text-dark" style="width: 130px;"><?= $sub['subcategory_name'] ?></span>
                            </a>
                        </li>
                        <?php } ?>

                    </ul>



                </div>




            </div>
            <div class="tab-content py-4">

                <!-- ALL BOOKS TAB -->
                <div id="tab-all" class="tab-pane fade show active p-0">
                    <div class="row g-4">

                        <?php
                    $allBooksQuery = "
                    SELECT books.*, subcategories.subcategory_name
                    FROM books
                    JOIN subcategories ON books.subcategory_id = subcategories.id
                    WHERE books.category_id = $cat_id
                ";
                $allBooks = mysqli_query($con, $allBooksQuery);

                while($book = mysqli_fetch_assoc($allBooks)) {
                  ?>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="rounded position-relative fruite-item">
                                <div class="fruite-img">
                                    <img src="../admin_panel/uploads/<?= $book['cover_image'] ?>"
                                        class="img-fluid w-100 rounded-top">
                                </div>

                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                    style="top: 10px; left: 10px;">
                                    <?= $book['subcategory_name'] ?>
                                </div>

                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                    <h4><?= $book['title'] ?></h4>
                                    <p><?= $book['description'] ?></p>
                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                        <p class="text-dark fs-5 fw-bold mb-0">$<?= $book['price'] ?></p>
                                        <a class="btn border border-secondary rounded-pill px-3 text-primary">
                                            <i class="fa fa-shopping-bag me-2"></i> Add to cart
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                    </div>
                </div>

                <!-- SUBCATEGORY TABS -->
                <?php
                  $subcats = mysqli_query($con, "SELECT * FROM subcategories WHERE category_id = $cat_id");

                    while($sub = mysqli_fetch_assoc($subcats)) {
                  $sub_id = $sub['id'];
                   ?>

                <div id="tab-<?= $sub_id ?>" class="tab-pane fade p-0">
                    <div class="row g-4">

                        <?php
                $bq = "SELECT books.*, subcategories.subcategory_name
                       FROM books
                       JOIN subcategories ON books.subcategory_id = subcategories.id
                       WHERE books.subcategory_id = $sub_id";
                
                $books = mysqli_query($con, $bq);

                while($book = mysqli_fetch_assoc($books)) {
                ?>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="rounded position-relative fruite-item">
                                <div class="fruite-img">
                                    <img src="../admin_panel/uploads/<?= $book['cover_image']; ?>"
                                        class="img-fluid w-100 rounded-top">
                                </div>

                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                    style="top: 10px; left: 10px;">
                                    <?= $book['subcategory_name'] ?>
                                </div>

                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                    <h4><?= $book['title'] ?></h4>
                                    <p><?= $book['description'] ?></p>
                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                        <p class="text-dark fs-5 fw-bold mb-0">$<?= $book['price'] ?></p>
                                        <a class="btn border border-secondary rounded-pill px-3 text-primary">
                                            <i class="fa fa-shopping-bag me-2"></i> Add to cart
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                    </div>
                </div>

                <?php } ?>

            </div>




        </div>
    </div>
    <!-- Fruits Shop End-->


   
   <!-- Books Banner Start -->
<div class="container-fluid banner bg-secondary my-4">
    <div class="container py-5">
        <div class="row g-4 align-items-center">

            <!-- LEFT TEXT -->
            <div class="col-lg-6">
                <div class="py-4">
                    <h1 class="display-3 text-white">Discover Amazing Books</h1>
                    <p class="fw-normal display-5 text-dark mb-4">Read • Learn • Grow</p>

                    <p class="mb-4 text-dark">
                        Explore the world of literature, poetry, stories, biography, Islamic books and much more.
                        Hand-picked fresh reads just for you!
                    </p>

                    <a href="#books"
                        class="banner-btn btn border-2 border-white rounded-pill text-dark py-3 px-5">
                        Browse Books
                    </a>
                </div>
            </div>

            <!-- RIGHT IMAGES COLLAGE -->
            <div class="col-lg-6">
                <div class="position-relative d-flex justify-content-center">

                    <!-- Image 1 -->
                    <img src="img/book1.jpg"
                        class="rounded shadow-lg position-absolute"
                        style="width: 220px; top: 10px; left: 20px; transform: rotate(-5deg);">

                    <!-- Image 2 -->
                    <img src="img/book2.jpg"
                        class="rounded shadow-lg position-absolute"
                        style="width: 240px; top: 40px; right: 30px; transform: rotate(7deg); z-index: 2;">

                    <!-- Image 3 -->
                    <img src="img/book3.jpg"
                        class="rounded shadow-lg position-relative"
                        style="width: 260px; margin-top: 100px;">

                </div>
            </div>

        </div>
    </div>
</div>
<!-- Books Banner End -->


  


    <!-- Fact Start -->
    <div class="container-fluid py-4">
        <div class="container">
            <div class="bg-light p-5 rounded">
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>satisfied customers</h4>
                            <h1>1963</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>quality of service</h4>
                            <h1>99%</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>quality certificates</h4>
                            <h1>33</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>Available Products</h4>
                            <h1>789</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fact Start -->


    <!-- Tastimonial Start -->
    <div class="container-fluid testimonial py-4">
        <div class="container py-5">
            <div class="testimonial-header text-center">
                <h4 class="text-primary">Our Testimonial</h4>
                <h1 class="display-5 mb-5 text-dark">Our Client Saying!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel">
                <div class="testimonial-item img-border-radius bg-light rounded p-4">
                    <div class="position-relative">
                        <i class="fa fa-quote-right fa-2x text-secondary position-absolute"
                            style="bottom: 30px; right: 0;"></i>
                        <div class="mb-4 pb-4 border-bottom border-secondary">
                            <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the
                                industry's
                                standard dummy text ever since the 1500s,
                            </p>
                        </div>
                        <div class="d-flex align-items-center flex-nowrap">
                            <div class="bg-secondary rounded">
                                <img src="img/testimonial-1.jpg" class="img-fluid rounded"
                                    style="width: 100px; height: 100px;" alt="">
                            </div>
                            <div class="ms-4 d-block">
                                <h4 class="text-dark">Client Name</h4>
                                <p class="m-0 pb-3">Profession</p>
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
                            <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the
                                industry's
                                standard dummy text ever since the 1500s,
                            </p>
                        </div>
                        <div class="d-flex align-items-center flex-nowrap">
                            <div class="bg-secondary rounded">
                                <img src="img/testimonial-1.jpg" class="img-fluid rounded"
                                    style="width: 100px; height: 100px;" alt="">
                            </div>
                            <div class="ms-4 d-block">
                                <h4 class="text-dark">Client Name</h4>
                                <p class="m-0 pb-3">Profession</p>
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
                            <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the
                                industry's
                                standard dummy text ever since the 1500s,
                            </p>
                        </div>
                        <div class="d-flex align-items-center flex-nowrap">
                            <div class="bg-secondary rounded">
                                <img src="img/testimonial-1.jpg" class="img-fluid rounded"
                                    style="width: 100px; height: 100px;" alt="">
                            </div>
                            <div class="ms-4 d-block">
                                <h4 class="text-dark">Client Name</h4>
                                <p class="m-0 pb-3">Profession</p>
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
            </div>
        </div>
    </div>
    <!-- Tastimonial End -->
                </div>

    <?php
     include('includes/footer.php');
     ?>

        