<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <!-- You can add more navbar items here if needed -->
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Welcome to Admin Panel</h2>
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="dashboard.php" class="list-group-item list-group-item-action"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="add_student_form.php" class="list-group-item list-group-item-action"><i class="fas fa-user-plus"></i> Add Student</a>
                    <a href="manage_fee_form.php" class="list-group-item list-group-item-action"><i class="fas fa-money-bill-wave"></i> Manage Fee</a>
                    <a href="admin_login.php" class="list-group-item list-group-item-action"><i class="fas fa-user-shield"></i> Admin Login</a>
                    <!-- Add more menu items as per your application needs -->
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Admin Panel
                    </div>
                    <div class="card-body">
                        <p class="lead">Welcome to the Admin Dashboard. Here you can manage various aspects of your system.</p>
                        <!-- Example content: Replace with your actual admin functionality -->
                        <p>Student Fee Management Portal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
