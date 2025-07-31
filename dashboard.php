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

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $appointment_id = $_POST['appointment_id'];
    $new_status = $_POST['status'];
    
    $pdo = db_connect();
    $sql = "UPDATE appointments SET status = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$new_status, $appointment_id]);
    
    if ($result) {
        $success_message = "Appointment status updated successfully!";
    } else {
        $error_message = "Failed to update appointment status.";
    }
}

// Get filters from URL
$status_filter = $_GET['status'] ?? '';
$date_filter = $_GET['date'] ?? '';
$search = $_GET['search'] ?? '';

// Build query with filters
$pdo = db_connect();
$sql = "SELECT * FROM appointments WHERE 1=1";
$params = [];

if ($status_filter != '' && $status_filter != 'all') {
    $sql .= " AND status = ?";
    $params[] = $status_filter;
}

if ($date_filter != '') {
    $sql .= " AND appointment_date = ?";
    $params[] = $date_filter;
}

if ($search != '') {
    $sql .= " AND (name LIKE ? OR email LIKE ? OR appointment_id LIKE ? OR vehicle_make LIKE ? OR vehicle_model LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
}

$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$appointments = $stmt->fetchAll();

// Get statistics
$total_count = $pdo->query("SELECT COUNT(*) FROM appointments")->fetchColumn();
$pending_count = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'pending'")->fetchColumn();
$confirmed_count = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'confirmed'")->fetchColumn();
$today_count = $pdo->query("SELECT COUNT(*) FROM appointments WHERE appointment_date = CURDATE()")->fetchColumn();

// Helper function to format services
function format_services($services) {
    // If it's already an array from JSON, join it
    if (is_array($services)) {
        return implode(', ', $services);
    }
    // If it's a JSON string, decode it
    $decoded = json_decode($services, true);
    if ($decoded && is_array($decoded)) {
        return implode(', ', $decoded);
    }
    // If it's comma-separated, return as is
    return $services;
}

// Helper function for status badge CSS class
function get_status_class($status) {
    switch ($status) {
        case 'pending': return 'status-pending';
        case 'confirmed': return 'status-confirmed';
        case 'completed': return 'status-completed';
        case 'cancelled': return 'status-cancelled';
        default: return 'status-pending';
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
    </div>

    <?php if ($success_message): ?>
        <div class="success-message">
            <i class="fa-solid fa-check-circle"></i> <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <?php if ($error_message): ?>
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
                    <option value="all" <?php echo ($status_filter == 'all' || $status_filter == '') ? 'selected' : ''; ?>>All Status</option>
                    <option value="pending" <?php echo ($status_filter == 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="confirmed" <?php echo ($status_filter == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                    <option value="completed" <?php echo ($status_filter == 'completed') ? 'selected' : ''; ?>>Completed</option>
                    <option value="cancelled" <?php echo ($status_filter == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
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
                        <?php foreach ($appointments as $appointment): ?>
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
                                    <span class="status-badge <?php echo get_status_class($appointment['status']); ?>">
                                        <?php echo ucfirst($appointment['status']); ?>
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <form method="POST" class="status-form">
                                        <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
                                        <select name="status" onchange="this.form.submit()">
                                            <option value="pending" <?php echo ($appointment['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                            <option value="confirmed" <?php echo ($appointment['status'] == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                                            <option value="completed" <?php echo ($appointment['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                            <option value="cancelled" <?php echo ($appointment['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                        <input type="hidden" name="update_status" value="1">
                                    </form>
                                    <?php if (!empty($appointment['comments'])): ?>
                                        <button class="view-comments-btn" onclick="showComments('<?php echo addslashes($appointment['comments']); ?>')">
                                            <i class="fa-solid fa-comment"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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

<div class="logOut" style="display: flex; justify-content: center; margin: 2rem;">
    <a href="logout.php" class="logout-btn"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
</div>

</body>

</html>