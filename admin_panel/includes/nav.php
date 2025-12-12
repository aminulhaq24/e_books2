<?php
include('includes/connection.php');
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Admin Dashboard for E-Book Publishing System">
    <meta name="author" content="">

    <title>E-Book System - Admin Dashboard</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts - Nunito -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for SB Admin 2 (Modified for Bootstrap 5) -->
    <style>
    :root {
        --primary: #4e73df;
        --primary-dark: #224abe;
        --gray-100: #f8f9fc;
        --gray-600: #858796;
    }

    body {
        font-family: 'Nunito', sans-serif;
        background-color: var(--gray-100);
        padding-top: 0;
    }

    #wrapper {
        display: flex;
    }

    .sidebar {
        min-height: 100vh;
        background: linear-gradient(180deg, var(--primary) 10%, var(--primary-dark) 100%);
        width: 14rem;
        transition: margin 0.25s ease-out;
    }

    .sidebar.toggled {
        margin-left: -14rem;
    }

    .sidebar-brand {
        padding: 1.5rem 1rem;
        color: white;
        font-size: 1.2rem;
        font-weight: 800;
        text-align: center;
        text-decoration: none;
        display: block;
    }

    .sidebar-brand i {
        font-size: 1.5rem;
    }

    .sidebar-heading {
        color: rgba(255, 255, 255, .6);
        padding: 0 1rem;
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        margin-top: 1.5rem;
    }

    .nav-item {
        position: relative;
    }

    .nav-link {
        color: rgba(255, 255, 255, .8);
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .nav-link:hover,
    .nav-link.active {
        color: white;
        background-color: rgba(255, 255, 255, .1);
    }

    .nav-link i {
        width: 1.5rem;
        text-align: center;
        margin-right: 0.5rem;
    }

    .sidebar-divider {
        border-top: 1px solid rgba(255, 255, 255, .2);
        margin: 1rem 1rem;
    }

    .collapse {
        background-color: rgba(0, 0, 0, .2);
    }

    .collapse-inner {
        padding: 0.5rem 0;
    }

    .collapse-item {
        color: rgba(255, 255, 255, .8);
        padding: 0.5rem 2rem;
        display: block;
        text-decoration: none;
    }

    .collapse-item:hover {
        color: white;
        background-color: transparent;
    }

    .topbar {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    /* Admin Name Display Fix */
    .admin-name-display {
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
        transition: none !important;
    }

    /* On mobile, hide the name if needed */
    @media (max-width: 992px) {
        .admin-name-display {
            display: none !important;
        }
    }

    /* Ensure dropdown doesn't affect the name */
    #userDropdown {
        display: inline-block;
    }

    /* Fix for the parent container */
    .navbar-nav .nav-item.dropdown {
        display: flex;
        align-items: center;
    }



    .badge-counter {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        font-size: 0.6rem;
    }

    /* Footer Styles */
    .sticky-footer {
        flex-shrink: 0;
    }

    .sticky-footer.bg-white {
        background-color: #fff !important;
        border-top: 1px solid #e3e6f0;
    }

    /* Scroll to Top Button */
    .scroll-to-top {
        position: fixed;
        right: 1rem;
        bottom: 1rem;
        width: 2.5rem;
        height: 2.5rem;
        text-align: center;
        color: #fff;
        background: rgba(0, 0, 0, 0.5);
        line-height: 2.5rem;
        border-radius: 50%;
        display: none;
    }

    .scroll-to-top:hover {
        color: #fff;
        background: #000;
    }

    /* Modal Styles */
    .modal-content {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .nav-item {
        list-style: none !important;
    }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <!-- Sidebar Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-book-reader"></i>
                </div>
                <div class="sidebar-brand-text mx-2">E-Book Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- EBOOK MANAGEMENT Heading -->
            <div class="sidebar-heading">
                E-Book Management
            </div>

            <!-- Books Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#booksCollapse">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Books</span>
                </a>
                <div id="booksCollapse" class="collapse">
                    <div class="collapse-inner">
                        <a class="collapse-item" href="upload_book.php">
                            <i class="fas fa-upload fa-sm me-1"></i> Upload New Book
                        </a>
                        <a class="collapse-item" href="manage_books.php">
                            <i class="fas fa-list fa-sm me-1"></i> Manage Books
                        </a>
                        <a class="collapse-item" href="manage_pdf_access.php">
                            <i class="fas fa-file-pdf fa-sm me-1"></i> PDF Access Control
                        </a>
                        <a class="collapse-item" href="subscriptions.php">
                            <i class="fas fa-sync-alt fa-sm me-1"></i> Subscriptions
                        </a>
                    </div>
                </div>
            </li>

            <!-- Categories & Subcategories -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#categoriesCollapse">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Categories</span>
                </a>
                <div id="categoriesCollapse" class="collapse">
                    <div class="collapse-inner">
                        <a class="collapse-item" href="manage_categories.php">Book Categories</a>
                        <a class="collapse-item" href="manage_subcategories.php">Subcategories</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- COMPETITIONS Heading -->
            <div class="sidebar-heading">
                Competitions
            </div>

            <!-- Competitions Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#competitionsCollapse">
                    <i class="fas fa-fw fa-trophy"></i>
                    <span>Competitions</span>
                </a>
                <div id="competitionsCollapse" class="collapse">
                    <div class="collapse-inner">
                        <a class="collapse-item" href="manage_competitions.php">
                            <i class="fas fa-plus-circle fa-sm me-1"></i> Create Competition
                        </a>
                        <a class="collapse-item" href="edit_competition.php">
                            <i class="fas fa-edit fa-sm me-1"></i> Manage Competitions
                        </a>
                        <a class="collapse-item" href="view_submissions.php">
                            <i class="fas fa-inbox fa-sm me-1"></i> View Submissions
                            <span class="badge bg-danger badge-counter">5</span>
                        </a>
                        <a class="collapse-item" href="competition_winners.php">
                            <i class="fas fa-award fa-sm me-1"></i> Declare Winners
                        </a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- ORDERS & USERS Heading -->
            <div class="sidebar-heading">
                Sales & Users
            </div>

            <!-- Orders -->
            <li class="nav-item">
                <a class="nav-link" href="view_orders.php">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>Orders</span>
                    <span class="badge bg-warning badge-counter">12</span>
                </a>
            </li>

            <!-- Shipments (for physical books/CDs) -->
            <li class="nav-item">
                <a class="nav-link" href="physical_shipments.php">
                    <i class="fas fa-fw fa-truck"></i>
                    <span>Shipments</span>
                </a>
            </li>

            <!-- Users -->
            <li class="nav-item">
                <a class="nav-link" href="manage_users.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Users</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler -->
            <div class="text-center d-none d-md-inline">
                <button class="btn rounded-circle border-0" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

        </nav>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column w-100">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle me-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search (Optional for your system) -->
                    <form class="d-none d-sm-inline-block form-inline p-2 me-auto ms-md-3 my-2 my-md-0 mw-100">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                placeholder="Search orders, books, users...">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <!-- Notification Bell - FIXED VERSION -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <!-- Bell Icon - Always Visible -->
                        <div class="bell-container me-4 position-relative">
                            <i class="fas fa-bell fa-fw text-gray-600 bell-icon" style="font-size: 1.1rem;"></i>
                            <span class="badge bg-danger badge-counter position-absolute" style="top: -8px; right: -12px; font-size: 0.65rem; padding: 2px 6px; 
                                min-width: 18px; text-align: center;">
                                3
                            </span>
                        </div>

                        <!-- Dropdown Trigger (Hidden but functional) -->
                        <a class="dropdown-trigger position-absolute" href="#" id="alertsDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false"
                            style="width: 40px; height: 40px; top: 0; left: 0; opacity: 0.01; cursor: pointer;">
                        </a>

                        <!-- Dropdown Menu -->
                        <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in mt-2"
                            aria-labelledby="alertsDropdown" style="min-width: 22rem;">
                            <h6 class="dropdown-header d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-bell me-1"></i> Notifications</span>
                                <small class="text-primary">3 New</small>
                            </h6>

                            <a class="dropdown-item d-flex align-items-center py-2" href="view_submissions.php">
                                <div class="me-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="small text-gray-500">Just Now</div>
                                    <span class="font-weight-bold">5 new competition submissions</span>
                                </div>
                            </a>

                            <a class="dropdown-item d-flex align-items-center py-2" href="view_orders.php">
                                <div class="me-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-shopping-cart text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="small text-gray-500">Today, 10:30 AM</div>
                                    3 new orders pending confirmation
                                </div>
                            </a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center text-primary small" href="#">
                                <i class="fas fa-eye me-1"></i> View All Notifications
                            </a>
                        </div>
                    </li>

                    <!-- User Dropdown -->
                    <!-- User Dropdown - FIXED WITH WORKING DROPDOWN -->
                    <li class="nav-item dropdown no-arrow position-relative">
                        <div class="d-flex align-items-center">
                            <!-- Admin Name - Always Visible -->
                            <span class="admin-name-display me-2 text-gray-600 small fw-bold">
                                <?php 
            $admin_name = $_SESSION['admin_name'] ?? 'Administrator';
            echo htmlspecialchars($admin_name);
            ?>
                            </span>

                            <!-- Dropdown Trigger (ON THE IMAGE) -->
                            <a class="nav-link dropdown-toggle p-0" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="img-profile rounded-circle dropdown-clickable" src="img/undraw_profile.svg"
                                    alt="Admin" style="width: 36px; height: 36px; object-fit: cover; border: 2px solid #e3e6f0;
                        cursor: pointer;">
                            </a>

                            <!-- Dropdown Menu -->
                            <div class="dropdown-menu dropdown-menu-end shadow mt-2" aria-labelledby="userDropdown">


                                <a class="dropdown-item" href="admin_profile.php">
                                    <i class="fas fa-user fa-sm me-2"></i>Profile
                                </a>
                                <a class="dropdown-item" href="system_settings.php">
                                    <i class="fas fa-cogs fa-sm me-2"></i>Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm me-2"></i>Logout
                                </a>
                            </div>
                        </div>
                    </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Main Page Content -->
                <!-- This is where individual page content will be included -->
                <div class="container-fluid" id="page-content">
                    <!-- Page content from other admin pages will load here -->

                    <!-- End of Content Wrapper -->

                </div>
                <!-- End of Page Wrapper -->

                <!-- Scroll to Top Button-->
                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>

                <!-- Logout Modal-->
                <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Select "Logout" below if you are ready to end your current session.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <a class="btn btn-primary" href="logout.php">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>