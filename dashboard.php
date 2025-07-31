<?php
session_start();
require_once 'database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$success_message = '';
$error_message = '';

// Handle appointment status updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $appointment_id = $_POST['appointment_id'];
    $new_status = $_POST['status'];
    
    try {
        $pdo = db_connect();
        
        // Simple update query
        $sql = "UPDATE appointments SET status = '$new_status' WHERE id = $appointment_id";
        $result = $pdo->exec($sql);
        
        if ($result) {
            $success_message = "Appointment status updated successfully!";
        } else {
            $error_message = "Failed to update appointment status.";
        }
    } catch (Exception $e) {
        $error_message = "Error updating appointment: " . $e->getMessage();
    }
}

// Get filter values from URL
$status_filter = '';
$date_filter = '';
$search = '';

if (isset($_GET['status'])) {
    $status_filter = $_GET['status'];
}
if (isset($_GET['date'])) {
    $date_filter = $_GET['date'];
}
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Build the main query with filters
$pdo = db_connect();

// Start with basic query
$sql = "SELECT * FROM appointments WHERE 1=1";

// Add filters one by one
if ($status_filter != '' && $status_filter != 'all') {
    $sql .= " AND status = '$status_filter'";
}

if ($date_filter != '') {
    $sql .= " AND appointment_date = '$date_filter'";
}

if ($search != '') {
    $sql .= " AND (name LIKE '%$search%' OR email LIKE '%$search%' OR appointment_id LIKE '%$search%' OR vehicle_make LIKE '%$search%' OR vehicle_model LIKE '%$search%')";
}

// Order by newest first
$sql .= " ORDER BY created_at DESC";

// Execute the query
$stmt = $pdo->prepare($sql);
$stmt->execute();
$appointments = $stmt->fetchAll();

// Get statistics with separate queries
$total_sql = "SELECT COUNT(*) as count FROM appointments";
$total_stmt = $pdo->prepare($total_sql);
$total_stmt->execute();
$total_count = $total_stmt->fetch()['count'];

$pending_sql = "SELECT COUNT(*) as count FROM appointments WHERE status = 'pending'";
$pending_stmt = $pdo->prepare($pending_sql);
$pending_stmt->execute();
$pending_count = $pending_stmt->fetch()['count'];

$confirmed_sql = "SELECT COUNT(*) as count FROM appointments WHERE status = 'confirmed'";
$confirmed_stmt = $pdo->prepare($confirmed_sql);
$confirmed_stmt->execute();
$confirmed_count = $confirmed_stmt->fetch()['count'];

$completed_sql = "SELECT COUNT(*) as count FROM appointments WHERE status = 'completed'";
$completed_stmt = $pdo->prepare($completed_sql);
$completed_stmt->execute();
$completed_count = $completed_stmt->fetch()['count'];

$cancelled_sql = "SELECT COUNT(*) as count FROM appointments WHERE status = 'cancelled'";
$cancelled_stmt = $pdo->prepare($cancelled_sql);
$cancelled_stmt->execute();
$cancelled_count = $cancelled_stmt->fetch()['count'];

$today_sql = "SELECT COUNT(*) as count FROM appointments WHERE appointment_date = CURDATE()";
$today_stmt = $pdo->prepare($today_sql);
$today_stmt->execute();
$today_count = $today_stmt->fetch()['count'];

// Helper function to format services
function format_services($services_json) {
    // Try to decode JSON, if it fails just return as is
    $services_array = json_decode($services_json, true);
    if ($services_array && is_array($services_array)) {
        $formatted = '';
        for ($i = 0; $i < count($services_array); $i++) {
            if ($i > 0) {
                $formatted .= ', ';
            }
            $formatted .= $services_array[$i];
        }
        return $formatted;
    }
    return $services_json;
}

// Helper function to get status badge class
function get_status_badge_class($status) {
    if ($status == 'pending') {
        return 'status-pending';
    } else if ($status == 'confirmed') {
        return 'status-confirmed';
    } else if ($status == 'completed') {
        return 'status-completed';
    } else if ($status == 'cancelled') {
        return 'status-cancelled';
    } else {
        return 'status-pending';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - 1 Stop Auto-Shop</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="dashboard.css">
    <script src="index.js" defer></script>
    <script src="dashboard.js" defer></script>
    <script src="https://kit.fontawesome.com/fd55908e0f.js" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
</head>

<header class="fixed">
    <div class="logoAndBar">
        <img src="./images/logo.jpg" alt="logo" style="width: 130px; height: 110px;">
        <h1 class="headName">1 Stop Auto-Shop</h1>
        <div class="desktopBars">
            <ul>
                <li class="hideOnMobile"><a href="index.html">Home</a></li>
                <li class="hideOnMobile"><a href="cars.html">Cars</a></li>
                <li class="hideOnMobile"><a href="index.html#Services">Services</a></li>
                <li class="hideOnMobile"><a href="parts.html">Parts</a></li>
                <li class="hideOnMobile"><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="bars" id="hamburger">
            <i class="fa-solid fa-bars"></i>
        </div>
    </div>
    <div class="navbars" id="navbars">
        <nav>
            <ul class="mobileBar">
                <li><a href="index.html">Home</a></li>
                <li><a href="cars.html">Cars</a></li>
                <li><a href="index.html#Services">Services</a></li>
                <li><a href="parts.html">Parts</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>  
</header>

<body>
<br><br><br><br><br>

<div class="dashboard-content">
    <div class="welcome-box">
        <h2>Admin Dashboard</h2>
        <p>Welcome back, <?php echo $username; ?>!</p>
        <a href="logout.php" class="logout-btn">
            <i class="fa-solid fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <?php if ($success_message != ''): ?>
        <div class="success-message">
            <i class="fa-solid fa-check-circle"></i> <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <?php if ($error_message != ''): ?>
        <div class="error-message">
            <i class="fa-solid fa-exclamation-triangle"></i> <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card total">
            <div class="stat-icon"><i class="fa-solid fa-calendar-days"></i></div>
            <div class="stat-info">
                <h3><?php echo $total_count; ?></h3>
                <p>Total Appointments</p>
            </div>
        </div>
        <div class="stat-card pending">
            <div class="stat-icon"><i class="fa-solid fa-clock"></i></div>
            <div class="stat-info">
                <h3><?php echo $pending_count; ?></h3>
                <p>Pending</p>
            </div>
        </div>
        <div class="stat-card confirmed">
            <div class="stat-icon"><i class="fa-solid fa-check"></i></div>
            <div class="stat-info">
                <h3><?php echo $confirmed_count; ?></h3>
                <p>Confirmed</p>
            </div>
        </div>
        <div class="stat-card today">
            <div class="stat-icon"><i class="fa-solid fa-calendar-day"></i></div>
            <div class="stat-info">
                <h3><?php echo $today_count; ?></h3>
                <p>Today</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-container">
        <form method="GET" class="filters-form">
            <div class="filter-group">
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="all" <?php if ($status_filter == 'all' || $status_filter == '') echo 'selected'; ?>>All Status</option>
                    <option value="pending" <?php if ($status_filter == 'pending') echo 'selected'; ?>>Pending</option>
                    <option value="confirmed" <?php if ($status_filter == 'confirmed') echo 'selected'; ?>>Confirmed</option>
                    <option value="completed" <?php if ($status_filter == 'completed') echo 'selected'; ?>>Completed</option>
                    <option value="cancelled" <?php if ($status_filter == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="date">Date:</label>
                <input type="date" name="date" id="date" value="<?php echo $date_filter; ?>">
            </div>
            
            <div class="filter-group">
                <label for="search">Search:</label>
                <input type="text" name="search" id="search" placeholder="Name, email, ID..." value="<?php echo $search; ?>">
            </div>
            
            <button type="submit" class="filter-btn">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
            
            <a href="dashboard.php" class="clear-btn">
                <i class="fa-solid fa-times"></i> Clear
            </a>
        </form>
    </div>

    <!-- Appointments Table -->
    <div class="appointments-container">
        <h3>Appointments (<?php echo count($appointments); ?> found)</h3>
        
        <?php if (count($appointments) == 0): ?>
            <div class="no-appointments">
                <i class="fa-solid fa-calendar-xmark"></i>
                <h4>No appointments found</h4>
                <p>Try adjusting your filters or check back later for new appointments.</p>
            </div>
        <?php else: ?>
            <div class="appointments-table-container">
                <table class="appointments-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Date & Time</th>
                            <th>Vehicle</th>
                            <th>Services</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Loop through each appointment
                        for ($i = 0; $i < count($appointments); $i++) {
                            $appointment = $appointments[$i];
                        ?>
                            <tr>
                                <td class="appointment-id"><?php echo $appointment['appointment_id']; ?></td>
                                <td>
                                    <div class="customer-info">
                                        <strong><?php echo $appointment['name']; ?></strong><br>
                                        <small><?php echo $appointment['email']; ?></small><br>
                                        <small><?php echo $appointment['phone']; ?></small>
                                    </div>
                                </td>
                                <td>
                                    <div class="datetime-info">
                                        <?php echo date('M j, Y', strtotime($appointment['appointment_date'])); ?><br>
                                        <small><?php echo date('g:i A', strtotime($appointment['appointment_time'])); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <?php echo $appointment['vehicle_year'] . ' ' . $appointment['vehicle_make'] . ' ' . $appointment['vehicle_model']; ?>
                                </td>
                                <td class="services-cell">
                                    <?php echo format_services($appointment['services']); ?>
                                </td>
                                <td>
                                    <span class="status-badge <?php echo get_status_badge_class($appointment['status']); ?>">
                                        <?php echo ucfirst($appointment['status']); ?>
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <form method="POST" class="status-form">
                                        <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
                                        <select name="status" onchange="this.form.submit()">
                                            <option value="pending" <?php if ($appointment['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                            <option value="confirmed" <?php if ($appointment['status'] == 'confirmed') echo 'selected'; ?>>Confirmed</option>
                                            <option value="completed" <?php if ($appointment['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                                            <option value="cancelled" <?php if ($appointment['status'] == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                                        </select>
                                        <input type="hidden" name="update_status" value="1">
                                    </form>
                                    <?php if ($appointment['comments'] != ''): ?>
                                        <button class="view-comments-btn" onclick="showComments('<?php echo addslashes($appointment['comments']); ?>')">
                                            <i class="fa-solid fa-comment"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Comments Modal -->
<div id="commentsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Customer Comments</h4>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <p id="commentsText"></p>
        </div>
    </div>
</div>


</body>

</html>