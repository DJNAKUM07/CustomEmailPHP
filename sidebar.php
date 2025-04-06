<head>
    <title>Email Templates | Email Sender</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Summernote -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4e73df;
            --primary-dark: #3a5eca;
            --secondary: #6c757d;
            --success: #1cc88a;
            --danger: #e74a3b;
            --warning: #f6c23e;
            --info: #36b9cc;
            --dark: #5a5c69;
            --light: #f8f9fc;
        }
        
        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            background-color: #f8f9fc;
            color: #2e384d;
        }
        
        /* Sidebar styles */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            z-index: 1;
            position: fixed;
            width: 250px;
            transition: all 0.3s;
        }
        
        .sidebar .navbar-brand {
            padding: 1.5rem 1rem;
            font-size: 1.2rem;
            font-weight: 800;
            text-align: center;
            letter-spacing: 0.05rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar .nav-link {
            padding: 1rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            border-radius: 0.25rem;
            margin: 0.2rem 0.5rem;
            transition: all 0.2s;
        }
        
        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 1.5rem;
            text-align: center;
        }
        
        /* Main content area */
        .content-wrapper {
            margin-left: 250px;
            min-height: 100vh;
            padding: 1.5rem;
            transition: all 0.3s;
        }
        
        .content-header {
            margin-bottom: 1.5rem;
        }
        
        /* Card styles */
        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.25rem;
            font-weight: 600;
        }
        
        /* Table styles */
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            border-top: none;
            background-color: #f8f9fc;
            color: #6e707e;
            text-transform: uppercase;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.05rem;
            padding: 1rem;
        }
        
        .table tbody td {
            vertical-align: middle;
            padding: 1rem;
        }
        
        /* Button styles */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        .btn-success {
            background-color: var(--success);
            border-color: var(--success);
        }
        
        .btn-danger {
            background-color: var(--danger);
            border-color: var(--danger);
        }
        
        .btn-circle {
            border-radius: 100%;
            height: 2.5rem;
            width: 2.5rem;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 0.25rem;
        }
        
        /* Alert styles */
        .alert {
            border-radius: 0.5rem;
            border: none;
        }
        
        .alert-success {
            background-color: rgba(28, 200, 138, 0.2);
            border-left: 4px solid var(--success);
            color: #0f6848;
        }
        
        .alert-danger {
            background-color: rgba(231, 74, 59, 0.2);
            border-left: 4px solid var(--danger);
            color: #a52b21;
        }
        
        /* Modal styles */
        .modal-header {
            border-bottom: 1px solid #e3e6f0;
        }
        
        .modal-footer {
            border-top: 1px solid #e3e6f0;
        }
        
        /* User dropdown */
        .user-dropdown {
            padding: 0.5rem 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        
        .user-dropdown .dropdown-toggle {
            color: white;
            display: flex;
            align-items: center;
            width: 100%;
            padding: 0.5rem;
            border-radius: 0.25rem;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .user-dropdown .dropdown-toggle::after {
            margin-left: auto;
        }
        
        .user-dropdown .dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: white;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
            font-weight: bold;
        }
        
        .badge-counter {
            position: absolute;
            transform: scale(0.8);
            transform-origin: top right;
            right: 0.3rem;
            top: 0.3rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 100px;
                transition: all 0.3s;
            }
            
            .sidebar .navbar-brand {
                font-size: 1rem;
                padding: 1rem 0.5rem;
            }
            
            .sidebar .nav-link span {
                display: none;
            }
            
            .sidebar .nav-link i {
                font-size: 1.2rem;
                margin-right: 0;
            }
            
            .content-wrapper {
                margin-left: 100px;
                transition: all 0.3s;
            }
            
            .user-dropdown .dropdown-toggle span {
                display: none;
            }
        }
        
        /* Utility classes */
        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.2) !important;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<!-- sidebar.php -->
<div class="sidebar">
    <a class="navbar-brand text-light" href="index.php">
        <i class="fas fa-envelope"></i> Email Sender
    </a>

    <div class="mt-4">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>" href="index.php">
                    <i class="fas fa-file-alt"></i> <span>Templates</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'list_credentials.php' ? 'active' : ''; ?>" href="list_credentials.php">
                    <i class="fas fa-key"></i> <span>Credentials</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'send_email.php' ? 'active' : ''; ?>" href="send_email.php">
                    <i class="fas fa-paper-plane"></i> <span>Send Email</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'email_log_list.php' ? 'active' : ''; ?>" href="email_log_list.php">
                    <i class="fas fa-history"></i> <span>Email Log</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- User dropdown at bottom of sidebar -->
    <div class="user-dropdown dropup">
        <a class="dropdown-toggle text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <span>User Account</span>
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user-circle me-2"></i> Profile</a></li>
            <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i> Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
        </ul>
    </div>
</div>
