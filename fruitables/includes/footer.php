     <!-- Footer Start -->
     <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
         <div class="container py-5">
             <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5);">
                 <div class="row g-4">
                     <div class="col-lg-3">
                         <a href="index.php">
                             <h1 class="text-primary mb-3"><i class="fas fa-book-open me-2"></i>ReadSphere</h1>
                             <p class="text-secondary mb-2">Digital Library & Book Store</p>
                         </a>
                     </div>
                     <div class="col-lg-6">
                         <form action="subscribe.php" method="POST">
                             <div class="position-relative mx-auto">
                                 <input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="email"
                                     name="email" placeholder="Your Email" required>
                                 <button type="submit"
                                     class="btn btn-primary border-0 border-secondary py-3 px-4 position-absolute rounded-pill text-white"
                                     style="top: 0; right: 0;">Subscribe Now</button>
                             </div>
                         </form>
                     </div>
                     <div class="col-lg-3">
                         <div class="d-flex justify-content-end pt-3">
                             <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href="#"><i
                                     class="fab fa-twitter"></i></a>
                             <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href="#"><i
                                     class="fab fa-facebook-f"></i></a>
                             <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href="#"><i
                                     class="fab fa-youtube"></i></a>
                             <a class="btn btn-outline-secondary btn-md-square rounded-circle" href="#"><i
                                     class="fab fa-linkedin-in"></i></a>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="row g-5">
                 <div class="col-lg-3 col-md-6">
                     <div class="footer-item">
                         <h4 class="text-light mb-3">About ReadSphere</h4>
                         <p class="mb-4">
                             Your premier destination for digital books. We offer thousands of eBooks
                             across all genres, along with writing competitions and community features.
                         </p>
                         <a href="about.php" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Read
                             More</a>
                     </div>
                 </div>
                 <div class="col-lg-3 col-md-6">
                     <div class="d-flex flex-column text-start footer-item">
                         <h4 class="text-light mb-3">Quick Links</h4>
                         <a class="btn-link" href="about.php">About Us</a>
                         <a class="btn-link" href="contact.php">Contact Us</a>
                         <a class="btn-link" href="privacy.php">Privacy Policy</a>
                         <a class="btn-link" href="terms.php">Terms & Condition</a>
                         <a class="btn-link" href="refund.php">Return Policy</a>
                         <a class="btn-link" href="faq.php">FAQs & Help</a>
                     </div>
                 </div>
                 <div class="col-lg-3 col-md-6">
                     <div class="d-flex flex-column text-start footer-item">
                         <h4 class="text-light mb-3">My Account</h4>
                         <a class="btn-link" href="profile.php">My Profile</a>
                         <a class="btn-link" href="orders.php">My Orders</a>
                         <a class="btn-link" href="cart.php">Shopping Cart</a>
                         <a class="btn-link" href="wishlist.php">Wishlist</a>
                         <a class="btn-link" href="downloads.php">My Downloads</a>
                         <a class="btn-link" href="competitions.php">My Competitions</a>
                     </div>
                 </div>
                 <div class="col-lg-3 col-md-6">
                     <div class="footer-item">
                         <h4 class="text-light mb-3">Contact Info</h4>
                         <p><i class="fas fa-map-marker-alt me-2"></i> Karachi, Pakistan</p>
                         <p><i class="fas fa-envelope me-2"></i> info@readsphere.com</p>
                         <p><i class="fas fa-phone me-2"></i> +92 300 1234567</p>
                         <p><i class="fas fa-clock me-2"></i> 24/7 Customer Support</p>
                         <p>Payment Methods</p>
                         <img src="img/payment.png" class="img-fluid" alt="Payment Methods">
                     </div>
                 </div>
             </div>
         </div>
        </div>
        <!-- Footer End -->
        
        <!-- Copyright Start -->
     <div class="container-fluid copyright bg-dark py-4">
         <div class="container">
             <div class="row">
                 <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                     <span class="text-light">
                         <a href="index.php"><i class="fas fa-copyright text-light me-2"></i>ReadSphere</a>,
                         All rights reserved.
                     </span>
                 </div>
                 <div class="col-md-6 my-auto text-center text-md-end text-white">
                     Designed By <a class="border-bottom" href="#">Your Name</a>
                 </div>
             </div>
         </div>
         </div>
         <!-- Copyright End -->
         
    
     <!-- Back to Top -->
     <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top">
         <i class="fa fa-arrow-up"></i>
        </a>

     <!-- JavaScript Libraries -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
     <script src="lib/easing/easing.min.js"></script>
     <script src="lib/waypoints/waypoints.min.js"></script>
     <script src="lib/lightbox/js/lightbox.min.js"></script>
     <script src="lib/owlcarousel/owl.carousel.min.js"></script>

     <!-- Template Javascript -->
     <script src="js/main.js"></script>

     <script>
// Tabs carousel functionality
document.querySelector(".left-arrow").onclick = function() {
    document.getElementById("tabs-slider").scrollLeft -= 170;
}

document.querySelector(".right-arrow").onclick = function() {
    document.getElementById("tabs-slider").scrollLeft += 170;
}

// Animated statistics counter
document.addEventListener('DOMContentLoaded', function() {
    // Animate statistics
    const stats = ['stat-books', 'stat-users', 'stat-free', 'stat-comp'];

    stats.forEach(statId => {
        const element = document.getElementById(statId);
        if (element) {
            const target = parseInt(element.textContent);
            let current = 0;
            const increment = target / 50;

            const updateCounter = () => {
                if (current < target) {
                    current += increment;
                    if (current > target) current = target;
                    element.textContent = Math.floor(current);
                    setTimeout(updateCounter, 30);
                }
            }

            // Start animation when element is in viewport
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateCounter();
                        observer.unobserve(entry.target);
                    }
                });
            });

            observer.observe(element);
        }
    });

    // Carousel auto-play
    const myCarousel = document.getElementById('featuredCarousel');
    if (myCarousel) {
        const carousel = new bootstrap.Carousel(myCarousel, {
            interval: 5000,
            wrap: true
        });
    }
});
     </script>

     </body>

     </html>