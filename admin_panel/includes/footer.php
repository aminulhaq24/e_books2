




 <!-- Footer -->
    <footer class="sticky-footer bg-white p-4">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; E-Book Publishing System <?php echo date('Y'); ?></span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

    <!-- Bootstrap 5 JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (for compatibility with some plugins if needed) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- jQuery Easing (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- Chart.js for charts (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Toggle sidebar on button click
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('toggled');
        });
        
        document.getElementById('sidebarToggleTop').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('toggled');
        });

        // Auto-collapse other menus when one opens (for better UX)
        document.querySelectorAll('.nav-link[data-bs-toggle="collapse"]').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-bs-target');
                document.querySelectorAll('.collapse.show').forEach(openCollapse => {
                    if (openCollapse.id !== targetId.replace('#', '')) {
                        const bsCollapse = new bootstrap.Collapse(openCollapse);
                        bsCollapse.hide();
                    }
                });
            });
        });

        // Scroll to top button functionality
        window.addEventListener('scroll', function() {
            const scrollBtn = document.querySelector('.scroll-to-top');
            if (window.scrollY > 300) {
                scrollBtn.style.display = 'block';
            } else {
                scrollBtn.style.display = 'none';
            }
        });

        // Smooth scrolling for scroll to top
        document.querySelector('.scroll-to-top').addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Initialize tooltips (if using Bootstrap tooltips)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // delete button 

        
    </script>

</body>
</html>