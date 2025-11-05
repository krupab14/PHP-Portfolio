
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Panel - Krupa Bhalsod Portfolio</title>
        <meta name="description" content="Admin panel for managing Krupa Bhalsod's portfolio website">
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome Icons -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
        <style>
            :root {
                --primary-color: #522258;
                --secondary-color: #dc5f00;
                --accent-color: #c3b1e1;
                --text-dark: #373a40;
                --bg-light: #f8f9fa;
            }
            
            body {
                background-color: var(--bg-light);
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
        
            /* Custom Navbar Styling */
            .navbar {
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                padding: 1rem 0;
            }
            
            .navbar-brand {
                font-weight: 700;
                font-size: 1.5rem;
                color: white !important;
            }
            
            .navbar-brand:hover {
                color: #f8f9fa !important;
                text-decoration: none;
            }
        
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.75rem 1rem !important;
            border-radius: 0.375rem;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }
        
        .navbar-nav .nav-link.active {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.85%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        /* Main Content Styling */
        .container {
            max-width: 1200px;
            margin-top: 2rem;
        }
        
        .page-header {
            background: white;
            border-radius: 0.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .page-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: #6c757d;
            margin: 0;
        }
        
        /* Card Styling */
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--accent-color) 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
            border-radius: 0.75rem 0.75rem 0 0 !important;
            padding: 1.25rem;
        }
        
        .card-title {
            color: var(--text-dark);
            font-weight: 600;
            margin: 0;
        }
        
        /* Form Styling */
        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 0.5rem;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(82, 34, 88, 0.25);
        }
        
        /* Button Styling */
        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php">
                <i class="fas fa-user-cog"></i> Admin Panel
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" 
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./about.php">
                            <i class="fas fa-user"></i> About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./education.php">
                            <i class="fas fa-graduation-cap"></i> Qualifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./skills.php">
                            <i class="fas fa-code"></i> Skills
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./internship.php">
                            <i class="fas fa-briefcase"></i> Internships
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./projects.php">
                            <i class="fas fa-project-diagram"></i> Projects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./contact.php">
                            <i class="fas fa-envelope"></i> Contact
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php" onclick="return confirm('Are you sure you want to logout?')">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
