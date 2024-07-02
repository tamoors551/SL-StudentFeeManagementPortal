<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sticky-bar {
            background-color: black;
            color: red;
            font-weight: 1000;
            text-align: center;
            padding: 22px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            font-size: larger;
        }

        .navbar {
            z-index: 999;
            position: sticky;
            top: 62px;
            background-color: #343a40;
            padding: 0.75rem 1rem;
        }

        .navbar-brand {
            color: #ffffff;
            font-weight: bold;
            font-size: 1.25rem;
            text-transform: uppercase;
            text-decoration: none;
        }

        .navbar-nav .nav-link {
            color: #ffffff !important; /* White text */
            padding: 0.5rem 1rem;
            transition: background-color 0.3s ease, color 0.3s ease;
            font-size: 1rem;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus {
            background-color: red !important; /* Red background on hover */
            color: #ffffff !important; /* White text on hover */
            border-radius: 5px;
        }

        .navbar-nav .active {
            background-color: #0d6efd !important;
            color: white !important;
            font-weight: bold !important;
            border-radius: 5px;
        }

        .navbar-toggler-icon {
            filter: invert(1);
        }
    </style>
</head>

<body>
    <div class="sticky-bar">
        Welcome to Student Fee Management Portal
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../templates/dashboard.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="add_student_form.php">Add Student</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_fee_form.php">Manage Fee</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="student_records.php">Student Records</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="fee_reports.php">Fee Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="monthly_fee_reports.php">Monthly Fee Reports</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../templates/admin_login.php">Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.navbar-nav .nav-link').each(function () {
                if (this.href === window.location.href) {
                    $(this).addClass('active');
                }
            });
        });
    </script>
</body>
</html>
