    <!-- Footer Section -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> Krupa Bhalsod Portfolio Admin Panel</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        <a href="../index.php" class="footer-link">
                            <i class="fas fa-external-link-alt"></i> View Portfolio
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        /**
         * Admin Panel Common JavaScript Functions
         */
        
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 500);
                }, 5000);
            });
        });
        
        // Confirm logout
        function confirmLogout() {
            return confirm('Are you sure you want to logout from the admin panel?');
        }
        
        // Form validation helper
        function validateForm(formId) {
            const form = document.getElementById(formId);
            if (form) {
                form.classList.add('was-validated');
                return form.checkValidity();
            }
            return false;
        }
        
        // Active navigation highlighting
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            
            navLinks.forEach(function(link) {
                if (link.getAttribute('href') === './' + currentPath.split('/').pop()) {
                    link.classList.add('active');
                }
            });
        });
    </script>
    
    <style>
        .footer {
            background-color: white;
            border-top: 1px solid #dee2e6;
            padding: 2rem 0;
            margin-top: 3rem;
            color: #6c757d;
        }
        
        .footer-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .footer-link:hover {
            color: var(--secondary-color);
            text-decoration: none;
        }
    </style>
</body>
</html>

<?php
/**
 * Close Database Connection
 * Clean up resources if connection exists
 */
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>