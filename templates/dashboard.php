<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "StudentFeeManagement_ok";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total number of students
$sql_students_count = "SELECT COUNT(*) AS total_students FROM students";
$result_students_count = $conn->query($sql_students_count);
$row_students_count = $result_students_count->fetch_assoc();
$total_students = $row_students_count['total_students'];

// Fetch total number of fees records
$sql_fees_count = "SELECT COUNT(*) AS total_fees FROM fees";
$result_fees_count = $conn->query($sql_fees_count);
$row_fees_count = $result_fees_count->fetch_assoc();
$total_fees = $row_fees_count['total_fees'];

// Fetch total number of teachers
$sql_teachers_count = "SELECT COUNT(*) AS total_teachers FROM teacher";
$result_teachers_count = $conn->query($sql_teachers_count);
$row_teachers_count = $result_teachers_count->fetch_assoc();
$total_teachers = $row_teachers_count['total_teachers'];

// Fetch status and totals of fees
$sql_paid_sum = "SELECT SUM(amount) AS total_paid FROM fees WHERE status = 'Paid'";
$result_paid_sum = $conn->query($sql_paid_sum);
$row_paid_sum = $result_paid_sum->fetch_assoc();
$total_paid_sum = $row_paid_sum['total_paid'];

$sql_unpaid_sum = "SELECT SUM(amount) AS total_unpaid FROM fees WHERE status = 'Unpaid'";
$result_unpaid_sum = $conn->query($sql_unpaid_sum);
$row_unpaid_sum = $result_unpaid_sum->fetch_assoc();
$total_unpaid_sum = $row_unpaid_sum['total_unpaid'];

// Fetch total number of registered users
$sql_registered_users = "SELECT COUNT(*) AS total_registered_users FROM users";
$result_registered_users = $conn->query($sql_registered_users);
$row_registered_users = $result_registered_users->fetch_assoc();
$total_registered_users = $row_registered_users['total_registered_users'];

// Fetch actual number of logged-in users based on recent login activities (last 30 minutes)
$current_time = time();
$last_activity_threshold = $current_time - (30 * 60); // 30 minutes ago

$sql_logged_in_users = "SELECT COUNT(DISTINCT user_id) AS total_logged_in_users 
                       FROM user_sessions 
                       WHERE last_activity > FROM_UNIXTIME($last_activity_threshold)";
$result_logged_in_users = $conn->query($sql_logged_in_users);
$row_logged_in_users = $result_logged_in_users->fetch_assoc();
$total_logged_in_users = $row_logged_in_users['total_logged_in_users'];

// Fetch total fees collected this month
$sql_monthly_fees = "SELECT SUM(amount) AS total_monthly_fees 
                     FROM fees 
                     WHERE status = 'Paid' 
                     AND MONTH(created_on) = MONTH(CURRENT_DATE()) 
                     AND YEAR(created_on) = YEAR(CURRENT_DATE())";
$result_monthly_fees = $conn->query($sql_monthly_fees);
$row_monthly_fees = $result_monthly_fees->fetch_assoc();
$total_monthly_fees = $row_monthly_fees['total_monthly_fees'];

// Fetch total number of classes
$sql_classes_count = "SELECT COUNT(DISTINCT class) AS total_classes FROM students";
$result_classes_count = $conn->query($sql_classes_count);
$row_classes_count = $result_classes_count->fetch_assoc();
$total_classes = $row_classes_count['total_classes'];

// Fetch total number of sections
$sql_sections_count = "SELECT COUNT(DISTINCT section) AS total_sections FROM students";
$result_sections_count = $conn->query($sql_sections_count);
$row_sections_count = $result_sections_count->fetch_assoc();
$total_sections = $row_sections_count['total_sections'];

// Fetch total number of pending fees
$sql_pending_fees_count = "SELECT COUNT(*) AS total_pending_fees FROM fees WHERE status = 'Pending'";
$result_pending_fees_count = $conn->query($sql_pending_fees_count);
$row_pending_fees_count = $result_pending_fees_count->fetch_assoc();
$total_pending_fees = $row_pending_fees_count['total_pending_fees'];

// Add these lines after fetching other totals but before closing the connection

// Fetch total number of male students
$sql_male_students_count = "SELECT COUNT(*) AS total_male_students FROM students WHERE gender = 'male'";
$result_male_students_count = $conn->query($sql_male_students_count);
$row_male_students_count = $result_male_students_count->fetch_assoc();
$total_male_students = $row_male_students_count['total_male_students'];

// Fetch total number of female students
$sql_female_students_count = "SELECT COUNT(*) AS total_female_students FROM students WHERE gender = 'female'";
$result_female_students_count = $conn->query($sql_female_students_count);
$row_female_students_count = $result_female_students_count->fetch_assoc();
$total_female_students = $row_female_students_count['total_female_students'];

// Fetch total number of students by age group (0-18, 19-35, 36+)

// Fetch total number of students by class greater than 10th and less than or equal to 13th
$sql_students_by_class = "SELECT class, COUNT(*) AS total_students FROM students 
                          WHERE class > '08' AND class <= '13' 
                          GROUP BY class";
$result_students_by_class = $conn->query($sql_students_by_class);
$students_by_class = array();

while ($row_students_by_class = $result_students_by_class->fetch_assoc()) {
    $students_by_class[$row_students_by_class['class']] = $row_students_by_class['total_students'];
}
// Fetch total number of students by class greater than 10th and less than or equal to 13th// Fetch total number of students by class greater than 8 and less than or equal to 11 (for 9th and 10th classes)
$sql_students_by_class_9_10 = "SELECT class, COUNT(*) AS total_students FROM students 
WHERE class >= '9' AND class <= '10' 
GROUP BY class";
$result_students_by_class_9_10 = $conn->query($sql_students_by_class_9_10);

if (!$result_students_by_class_9_10) {
die("SQL Error: " . $conn->error);
}

$students_by_class_9_10 = array();

while ($row_students_by_class_9_10 = $result_students_by_class_9_10->fetch_assoc()) {
$students_by_class_9_10[$row_students_by_class_9_10['class']] = $row_students_by_class_9_10['total_students'];
}


// Fetch total number of students by age group
$sql_students_by_age = "SELECT 
                            CASE
                                WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 0 AND 18 THEN '0-18'
                                WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 19 AND 35 THEN '19-35'
                                WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) >= 36 THEN '36+'
                                ELSE 'Unknown'
                            END AS age_group,
                            COUNT(*) AS total_students
                        FROM students
                        GROUP BY age_group";

$result_students_by_age = $conn->query($sql_students_by_age);
$students_by_age = array();

while ($row_students_by_age = $result_students_by_age->fetch_assoc()) {
    $students_by_age[$row_students_by_age['age_group']] = $row_students_by_age['total_students'];
}





// Close connection (move this line to the end after fetching all required data)
$conn->close();



// Get the username from the session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Fee Management Portal - Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <style>
        .navbar {
            background-color: #0D6EFD; /* Dark Blue */
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover {
            background-color: red !important; /* Slightly lighter blue on hover */
        }

        .dashboard-card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            transition: transform 0.2s, background-color 0.2s;
            background-color: #ffffff; /* Light background color */
            margin-bottom: 20px;
            height: 200px; /* Fixed height for consistency */
            display: flex;
            flex-direction: column;
            justify-content: center;
            cursor: pointer;
        }

        .dashboard-card:hover {
            transform: scale(1.18);
        }

        .dashboard-card.bg-primary {
            background-color: #0d6efd;
        }

        .dashboard-card.bg-success {
            background-color: #198754;
        }

        .dashboard-card.bg-info {
            background-color: #0dcaf0;
        }

        .dashboard-card.bg-warning {
            background-color: #ffc107;
        }

        .dashboard-card.bg-danger {
            background-color: #dc3545;
        }

        .dashboard-card.bg-secondary {
            background-color: #6c757d;
        }

        .dashboard-card:hover {
            transform: scale(1.18);
        }

        .dashboard-card.bg-primary:hover {
            background-color: #0056b3;
        }

        .dashboard-card.bg-success:hover {
            background-color: #0f5132;
        }

        .dashboard-card.bg-info:hover {
            background-color: #0a758f;
        }

        .dashboard-card.bg-warning:hover {
            background-color: #b38600;
        }

        .dashboard-card.bg-danger:hover {
            background-color: #841d22;
        }

        .dashboard-card.bg-secondary:hover {
            background-color: #4b4b4b;
        }


        .card-title {
            font-size: 1.5rem;
        }

        .card-text {
            font-size: 2.5rem;
        }

        .chart-container {
            width: 80%;
            margin: auto;
            height: 500px; /* Adjust height as needed */
        }

        @media (max-width: 768px) {
            .dashboard-card {
                height: 150px; /* Reduce height for smaller screens */
            }

            .card-title {
                font-size: 1.2rem;
            }

            .card-text {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../templates/dashboard.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                        <span class="navbar-text">
                            Welcome, <?php echo htmlspecialchars($username); ?>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Dashboard</h1>

<?php
// Set timezone to Pakistan (Asia/Karachi)
date_default_timezone_set('Asia/Karachi');

// Fetch current date and time
$current_datetime = date('l, F j, Y \a\t g:i A');
?>

<div class="alert alert-info" role="alert">
    <p class="mb-0">Current Date and Time (Pakistan Timezone):</p>
    <p class="mb-0"><?php echo $current_datetime; ?></p>
</div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
               <!-- #region -->  
        <div class="col">
                <div class="dashboard-card bg-primary text-white">
                    <h5 class="card-title">Total Students</h5>
                    <p class="card-text"><?php echo $total_students; ?></p>
                </div>
            </div>
            <div class="col">
                <div class="dashboard-card bg-success text-white">
                    <h5 class="card-title">Total Fees Records</h5>
                    <p class="card-text"><?php echo $total_fees; ?></p>
                </div>
            </div>
            <div class="col">
                <div class="dashboard-card bg-info text-white">
                    <h5 class="card-title">Total Teachers</h5>
                    <p class="card-text"><?php echo $total_teachers; ?></p>
                </div>
            </div>
            <div class="col">
                <div class="dashboard-card bg-warning text-white">
                    <h5 class="card-title">Total Paid Fees (PKR)</h5>
                    <p class="card-text"><?php echo $total_paid_sum; ?></p>
                </div>
            </div>
            <div class="col">
                <div class="dashboard-card bg-danger text-white">
                    <h5 class="card-title">Total Unpaid Fees (PKR)</h5>
                    <p class="card-text"><?php echo $total_unpaid_sum; ?></p>
                </div>
            </div>
            <div class="col">
                <div class="dashboard-card bg-secondary text-white">
                    <h5 class="card-title">Total Registered Users</h5>
                    <p class="card-text"><?php echo $total_registered_users; ?></p>
                </div>
            </div>
            <div class="col">
                <div class="dashboard-card bg-primary text-white">
                    <h5 class="card-title">Total Logged-In Users</h5>
                    <p class="card-text"><?php echo $total_logged_in_users; ?></p>
                </div>
            </div>
            <div class="col">
                <div class="dashboard-card bg-success text-white">
                    <h5 class="card-title">Total Fees Collected This Month (PKR)</h5>
                    <p class="card-text"><?php echo $total_monthly_fees; ?></p>
                </div>
            </div>
            <div class="col">
                <div class="dashboard-card bg-info text-white">
                    <h5 class="card-title">Total Classes</h5>
                    <p class="card-text"><?php echo $total_classes; ?></p>
                </div>
            </div>
            <div class="col">
                <div class="dashboard-card bg-warning text-white">
                    <h5 class="card-title">Total Sections</h5>
                    <p class="card-text"><?php echo $total_sections; ?></p>
                </div>
            </div>

            <!-- Add these cards where you want to display male and female student counts -->
<div class="col">
    <div class="dashboard-card bg-secondary text-white">
        <h5 class="card-title">Total Male Students</h5>
        <p class="card-text"><?php echo $total_male_students; ?></p>
    </div>
</div>
<div class="col">
    <div class="dashboard-card bg-secondary text-white">
        <h5 class="card-title">Total Female Students</h5>
        <p class="card-text"><?php echo $total_female_students; ?></p>
    </div>
</div>

<div class="col">
    <div class="dashboard-card bg-primary text-white">
        <h5 class="card-title">Total Students by Class</h5>
        <div class="card-body">
            <ul class="list-unstyled">
                <?php
                foreach ($students_by_class as $class => $total_students) {
                    echo '<li><strong>Class ' . htmlspecialchars($class) . ': </strong>' . htmlspecialchars($total_students) . '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<!-- here is the issue detail of 9th and 10th class students is not show on the output -->
<div class="col">
    <div class="dashboard-card bg-primary text-white">
        <h5 class="card-title">Total Students by Class</h5>
        <div class="card-body">
            <ul class="list-unstyled">
                <?php
                foreach ($students_by_class_9_10 as $class => $total_students) {
                    echo '<li><strong>Class ' . htmlspecialchars($class) . ': </strong>' . htmlspecialchars($total_students) . '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>






<div class="col">
    <div class="dashboard-card bg-primary text-white">
        <h5 class="card-title">Students by Age Group</h5>
        <div class="card-body">
            <ul class="list-unstyled">
                <li><strong>0-18 years: </strong><?php echo isset($students_by_age['0-18']) ? $students_by_age['0-18'] : 0; ?></li>
                <li><strong>19-35 years: </strong><?php echo isset($students_by_age['19-35']) ? $students_by_age['19-35'] : 0; ?></li>
                <li><strong>36+ years: </strong><?php echo isset($students_by_age['36+']) ? $students_by_age['36+'] : 0; ?></li>
            </ul>
        </div>
    </div>
</div>


            <div class="col">
                <div class="dashboard-card bg-danger text-white">
                    <h5 class="card-title">Total Pending Fees</h5>
                    <p class="card-text"><?php echo $total_pending_fees; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="chart-container">
                    <canvas id="feesChart" width="200" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var ctx = document.getElementById('feesChart').getContext('2d');
        var feesChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Total Paid Fees', 'Total Unpaid Fees', 'Total Monthly Fees'],
                datasets: [{
                    data: [<?php echo $total_paid_sum; ?>, <?php echo $total_unpaid_sum; ?>, <?php echo $total_monthly_fees; ?>],
                    backgroundColor: [
                        'rgba(54, 162, 235, 1)',   // Darker blue for paid fees
                        'rgba(255, 99, 132, 0.6)', // Darker red for unpaid fees
                        'rgba(255, 205, 86, 0.6)'  // Darker yellow for monthly fees
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 205, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Fee Collection Overview'
                    }
                }
            }
        });
    </script>
</body>

</html>
