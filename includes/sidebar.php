<?php
// Determine the current page by checking the script name
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="../assets/css/Font Awesome-all.min.css">
<!-- <link rel="stylesheet" href="../assets/css/all.min.css"> -->

<div class="d-flex flex-column flex-shrink-0 bg-body-tertiary" style="width: 4.5rem;">
    <a href="../templates/dashboard.php" class="d-block p-3 link-body-emphasis text-decoration-none <?= $current_page == 'dashboard.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Dashboard">
        <i class="fas fa-tachometer-alt" style="font-size: 40px;"></i>
        <span class="visually-hidden">Dashboard</span>
    </a>

    <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
        <li>
            <a href="../templates/add_student_form.php" class="nav-link py-3 border-bottom rounded-0 <?= $current_page == 'add_student_form.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Add Student" data-bs-original-title="Add Student">
                <i class="fas fa-user-plus" style="font-size: 24px;"></i>
            </a>
        </li>
        <li>
            <a href="../templates/manage_fee_form.php" class="nav-link py-3 border-bottom rounded-0 <?= $current_page == 'manage_fee_form.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Manage Fee" data-bs-original-title="Manage Fee">
                <i class="fas fa-money-bill-wave" style="font-size: 24px;"></i>

            </a>
        </li>
        <li class="nav-item">
            <a href="./student_records.php" class="nav-link py-3 border-bottom rounded-0 <?= $current_page == 'student_records.php' ? 'active' : ''; ?>" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Student Records" data-bs-original-title="Student Records">
                <i class="fas fa-user-graduate" style="font-size: 24px;"></i>
            </a>
        </li>
        <li>
            <a href="./fee_reports.php" class="nav-link py-3 border-bottom rounded-0 <?= $current_page == 'fee_reports.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Fee Reports" data-bs-original-title="Fee Reports">
                <i class="fas fa-file-invoice-dollar" style="font-size: 24px;"></i>
            </a>
        </li>
        <li>
            <a href="./monthly_fee_reports.php" class="nav-link py-3 border-bottom rounded-0 <?= $current_page == 'monthly_fee_reports.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Monthly Fee Reports" data-bs-original-title="Monthly Fee Reports">
                <i class="fas fa-calendar-alt" style="font-size: 24px;"></i>
            </a>
        </li>
        <li>
            <a href="../templates/admin_login.php" class="nav-link py-3 border-bottom rounded-0 <?= $current_page == 'admin_login.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Admin Login" data-bs-original-title="Admin Login">
                <i class="fas fa-user-shield" style="font-size: 24px;"></i>
            </a>
        </li>
        <li>
            <a href="../templates/logout.php" class="nav-link py-3 border-bottom rounded-0 <?= $current_page == 'logout.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Logout" data-bs-original-title="Logout">
                <i class="fas fa-sign-out-alt" style="font-size: 24px;"></i>
            </a>
        </li>
        <li>
            <a href="../templates/login.php" class="nav-link py-3 border-bottom rounded-0 <?= $current_page == 'login.php' ? 'active' : ''; ?>" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Login" data-bs-original-title="Login">
                <i class="fas fa-sign-in-alt" style="font-size: 24px;"></i>
            </a>
        </li>
    </ul>
    <div class="dropdown border-top">
        <a href="#" class="d-flex align-items-center justify-content-center p-3 link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="mdo" width="24" height="24" class="rounded-circle">
        </a>
        <ul class="dropdown-menu text-small shadow">
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
    </div>
</div>

<style>
    .nav-link.active {
        background-color: #00BFFF;
        /* Light blue color */
        color: white;
    }

    .nav-link {
        color: #6c757d;
        /* Default inactive color */
    }
</style>