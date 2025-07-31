<?php
require_once 'database.php';

$form_valid = false;
$error_messages = array();
$appointment_saved = false;

// ============= FUNCTION THAT SETS APT ID FOR EACH UNIQUE APPOINTMENT ================= //
function create_appointment_id() {
    $pdo = db_connect();
    
    $sql = "SELECT counter FROM appointment_counter WHERE id = 1";
    $result = $pdo->query($sql)->fetch();
    
    if (!$result) {
        $pdo->query("INSERT INTO appointment_counter (id, counter) VALUES (1, 1)");
        $counter = 1;
    } else {
        $counter = $result['counter'];
    }
    
    $appointment_id = 'APT-' . date('Y') . '-' . sprintf('%06d', $counter);
    
    $new_counter = $counter + 1;
    $pdo->query("UPDATE appointment_counter SET counter = $new_counter WHERE id = 1");
    
    return $appointment_id;
}

// ================ Function to call when appointment form is valid to database ===================== //
function save_appointment($data) {
    $pdo = db_connect();
    
    $sql = "INSERT INTO appointments (appointment_id, name, email, phone, appointment_date, appointment_time, services, vehicle_year, vehicle_make, vehicle_model, comments) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    
    $services_text = implode(',', $data['services']);
    
    $result = $stmt->execute([
        $data['appointment_id'],
        $data['name'],
        $data['email'],
        $data['phone'],
        $data['date'],
        $data['time'],
        $services_text,
        $data['vehicle_year'],
        $data['vehicle_make'],
        $data['vehicle_model'],
        $data['comments']
    ]);
    
    return $result;
}

// ========== FORM VALIDATOIN PART =================== //
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_valid = true;
    
    $name = $_POST['name'] ?? '';
    if (empty($name)) {
        $error_messages['name'] = "⚠️ Please enter your full name.";
        $form_valid = false;
    } else if (!preg_match('/^[a-zA-Z\s\'-]{2,50}$/', $name)) {
        $error_messages['name'] = "⚠️ Please enter a valid name (letters, spaces, hyphens, and apostrophes only).";
        $form_valid = false;
    }
    
    $email = $_POST['email'] ?? '';
    if (empty($email)) {
        $error_messages['email'] = "⚠️ Please enter your email address.";
        $form_valid = false;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_messages['email'] = "⚠️ Please enter a valid email address.";
        $form_valid = false;
    }
    
    $phone = $_POST['phone'] ?? '';
    if (empty($phone)) {
        $error_messages['phone'] = "⚠️ Please enter your phone number.";
        $form_valid = false;
    } else if (!preg_match('/^(\+?1[-.\s]?)?\(?[0-9]{3}\)?[-.\s]?[0-9]{3}[-.\s]?[0-9]{4}$/', $phone)) {
        $error_messages['phone'] = "⚠️ Please enter a valid phone number (e.g., 123-456-7890).";
        $form_valid = false;
    }
    
    $date = $_POST['date'] ?? '';
    if (empty($date)) {
        $error_messages['date'] = "⚠️ Please select an appointment date.";
        $form_valid = false;
    } else {
        $selected_date = strtotime($date);
        $today = strtotime(date('Y-m-d'));
        if ($selected_date < $today) {
            $error_messages['date'] = "⚠️ Please select a future date.";
            $form_valid = false;
        }
    }
    
    $time = $_POST['time'] ?? '';
    if (empty($time)) {
        $error_messages['time'] = "⚠️ Please select an appointment time.";
        $form_valid = false;
    }
    
    $services = $_POST['services'] ?? [];
    if (empty($services)) {
        $error_messages['services'] = "⚠️ Please select at least one service.";
        $form_valid = false;
    }
    
    $vehicle_year = $_POST['vehicle_year'] ?? '';
    if (empty($vehicle_year)) {
        $error_messages['vehicle_year'] = "⚠️ Please enter your vehicle year.";
        $form_valid = false;
    } else if ($vehicle_year < 1950 || $vehicle_year > 2029) {
        $error_messages['vehicle_year'] = "⚠️ Please enter a valid year (1950-2029).";
        $form_valid = false;
    }
    
    $vehicle_make = $_POST['vehicle_make'] ?? '';
    if (empty($vehicle_make)) {
        $error_messages['vehicle_make'] = "⚠️ Please enter your vehicle make.";
        $form_valid = false;
    } else if (!preg_match('/^[a-zA-Z\s\-]{2,30}$/', $vehicle_make)) {
        $error_messages['vehicle_make'] = "⚠️ Please enter a valid vehicle make.";
        $form_valid = false;
    }
    
    $vehicle_model = $_POST['vehicle_model'] ?? '';
    if (empty($vehicle_model)) {
        $error_messages['vehicle_model'] = "⚠️ Please enter your vehicle model.";
        $form_valid = false;
    } else if (!preg_match('/^[a-zA-Z0-9\s\-]{1,30}$/', $vehicle_model)) {
        $error_messages['vehicle_model'] = "⚠️ Please enter a valid vehicle model.";
        $form_valid = false;
    }
    
    $comments = $_POST['comments'] ?? '';
    
    if ($form_valid) {
        $appointment_id = create_appointment_id();
        
        $appointment_data = [
            'appointment_id' => $appointment_id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'date' => $date,
            'time' => $time,
            'services' => $services,
            'vehicle_year' => $vehicle_year,
            'vehicle_make' => $vehicle_make,
            'vehicle_model' => $vehicle_model,
            'comments' => $comments
        ];
        
        $appointment_saved = save_appointment($appointment_data);
    }
}

function show_error_message($field) {
    global $error_messages;
    if (isset($error_messages[$field])) {
        echo "<div class='failure-message'>{$error_messages[$field]}</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - 1 Stop Auto-Shop</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="appointment.css">
    <script src="index.js" defer></script>
    <script src="appointment.js" defer></script>
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
                <li class="hideOnMobile"><a id="logInBtn" href="login.php">Admin Log In</a></li>
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
            </ul>
        </nav>
    </div>  
</header>

<body>
<br><br><br><br><br>
<div class="appointment-container">
    <h1>📅 Book Your Appointment</h1>
    
    <?php if ($appointment_saved): ?>
        <div class='results'>
            <div class='result-text'>
                <h2>✅ Appointment Confirmation</h2>
                <p><strong>Appointment ID:</strong> <?php echo $appointment_data['appointment_id']; ?></p>
            </div>
            <div class='result-text'>
                <p><strong>Name:</strong> <?php echo $appointment_data['name']; ?></p>
            </div>
            <div class='result-text'>
                <p><strong>Email:</strong> <?php echo $appointment_data['email']; ?></p>
            </div>
            <div class='result-text'>
                <p><strong>Phone:</strong> <?php echo $appointment_data['phone']; ?></p>
            </div>
            <div class='result-text'>
                <p><strong>Appointment Date:</strong> <?php echo date('F j, Y', strtotime($appointment_data['date'])); ?></p>
            </div>
            <div class='result-text'>
                <p><strong>Appointment Time:</strong> <?php echo date('g:i A', strtotime($appointment_data['time'])); ?></p>
            </div>
            <div class='result-text'>
                <p><strong>🔧 Selected Services:</strong></p>
                <ul>
                    <?php foreach ($appointment_data['services'] as $service): ?>
                        <li>• <?php echo $service; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class='result-text'>
                <p><strong>Vehicle:</strong> <?php echo $appointment_data['vehicle_year'] . ' ' . $appointment_data['vehicle_make'] . ' ' . $appointment_data['vehicle_model']; ?></p>
            </div>
            <?php if (!empty($appointment_data['comments'])): ?>
                <div class='result-text'>
                    <p><strong>💬 Additional Comments:</strong> <?php echo $appointment_data['comments']; ?></p>
                </div>
            <?php endif; ?>
            <div class='result-text' style='text-align: center; margin-top: 2rem;'>
                <p><strong>📋 Next Steps:</strong></p>
                <p>We will contact you within 24 hours to confirm your appointment. Please save your appointment ID for reference.</p>
                <p style='margin-top: 1rem;'><a href='appointment.php' style='color: white; text-decoration: underline;'>Book Another Appointment</a></p>
            </div>
        </div>
    <?php else: ?>
        <form method="POST" action="appointment.php" id="appointmentForm">
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name" value="<?php echo $_POST['name'] ?? ''; ?>" placeholder="Enter your full name" required>
                    <?php show_error_message('name'); ?>
                </div>
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" value="<?php echo $_POST['email'] ?? ''; ?>" placeholder="your@email.com" required>
                    <?php show_error_message('email'); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number *</label>
                <input type="tel" id="phone" name="phone" value="<?php echo $_POST['phone'] ?? ''; ?>" placeholder="123-456-7890" required>
                <?php show_error_message('phone'); ?>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="date">Preferred Date *</label>
                    <input type="date" id="date" name="date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $_POST['date'] ?? ''; ?>" required>
                    <?php show_error_message('date'); ?>
                </div>
                <div class="form-group">
                    <label for="time">Preferred Time *</label>
                    <select id="time" name="time" required>
                        <option value="">Select a time</option>
                        <option value="08:00" <?php echo (($_POST['time'] ?? '') == '08:00') ? 'selected' : ''; ?>>8:00 AM</option>
                        <option value="09:00" <?php echo (($_POST['time'] ?? '') == '09:00') ? 'selected' : ''; ?>>9:00 AM</option>
                        <option value="10:00" <?php echo (($_POST['time'] ?? '') == '10:00') ? 'selected' : ''; ?>>10:00 AM</option>
                        <option value="11:00" <?php echo (($_POST['time'] ?? '') == '11:00') ? 'selected' : ''; ?>>11:00 AM</option>
                        <option value="12:00" <?php echo (($_POST['time'] ?? '') == '12:00') ? 'selected' : ''; ?>>12:00 PM</option>
                        <option value="13:00" <?php echo (($_POST['time'] ?? '') == '13:00') ? 'selected' : ''; ?>>1:00 PM</option>
                        <option value="14:00" <?php echo (($_POST['time'] ?? '') == '14:00') ? 'selected' : ''; ?>>2:00 PM</option>
                        <option value="15:00" <?php echo (($_POST['time'] ?? '') == '15:00') ? 'selected' : ''; ?>>3:00 PM</option>
                        <option value="16:00" <?php echo (($_POST['time'] ?? '') == '16:00') ? 'selected' : ''; ?>>4:00 PM</option>
                        <option value="17:00" <?php echo (($_POST['time'] ?? '') == '17:00') ? 'selected' : ''; ?>>5:00 PM</option>
                    </select>
                    <?php show_error_message('time'); ?>
                </div>
            </div>

            <div class="form-group">
                <label>🔧 Services Needed * (Select all that apply)</label>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="services[]" value="Oil Change" <?php echo (in_array('Oil Change', $_POST['services'] ?? [])) ? 'checked' : ''; ?>> Oil Change</label>
                    <label><input type="checkbox" name="services[]" value="Brake Inspection" <?php echo (in_array('Brake Inspection', $_POST['services'] ?? [])) ? 'checked' : ''; ?>> Brake Inspection</label>
                    <label><input type="checkbox" name="services[]" value="Engine Diagnostics" <?php echo (in_array('Engine Diagnostics', $_POST['services'] ?? [])) ? 'checked' : ''; ?>> Engine Diagnostics</label>
                    <label><input type="checkbox" name="services[]" value="Tire Service" <?php echo (in_array('Tire Service', $_POST['services'] ?? [])) ? 'checked' : ''; ?>> Tire Service</label>
                    <label><input type="checkbox" name="services[]" value="Transmission Service" <?php echo (in_array('Transmission Service', $_POST['services'] ?? [])) ? 'checked' : ''; ?>> Transmission Service</label>
                    <label><input type="checkbox" name="services[]" value="Auto Detailing" <?php echo (in_array('Auto Detailing', $_POST['services'] ?? [])) ? 'checked' : ''; ?>> Auto Detailing</label>
                    <label><input type="checkbox" name="services[]" value="Custom Modifications" <?php echo (in_array('Custom Modifications', $_POST['services'] ?? [])) ? 'checked' : ''; ?>> Custom Modifications</label>
                </div>
                <?php show_error_message('services'); ?>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="vehicle_year">Vehicle Year *</label>
                    <input type="number" id="vehicle_year" name="vehicle_year" value="<?php echo $_POST['vehicle_year'] ?? ''; ?>" min="1950" max="2029" placeholder="2020" required>
                    <?php show_error_message('vehicle_year'); ?>
                </div>
                <div class="form-group">
                    <label for="vehicle_make">Vehicle Make *</label>
                    <input type="text" id="vehicle_make" name="vehicle_make" value="<?php echo $_POST['vehicle_make'] ?? ''; ?>" placeholder="Honda, Toyota, Ford..." required>
                    <?php show_error_message('vehicle_make'); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="vehicle_model">Vehicle Model *</label>
                <input type="text" id="vehicle_model" name="vehicle_model" value="<?php echo $_POST['vehicle_model'] ?? ''; ?>" placeholder="Civic, Camry, F-150..." required>
                <?php show_error_message('vehicle_model'); ?>
            </div>

            <div class="form-group">
                <label for="comments">💬 Additional Comments</label>
                <textarea id="comments" name="comments" rows="4" placeholder="Any specific concerns, requests, or additional information you'd like us to know..."><?php echo $_POST['comments'] ?? ''; ?></textarea>
            </div>

            <div class="button-group">
                <button type="submit" class="appointmentBtnPhp">
                    <i class="fa-solid fa-calendar-check"></i> Book Appointment
                </button>
                <button type="reset" class="appointmentBtnPhp">
                    <i class="fa-solid fa-rotate-left"></i> Reset Form
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>

</body>

<footer>
    <div class="midContentFour footer">
        <h2 style="text-align: center;">Get in Touch</h2>
        <div class="horizon">
            <div class="contInfo">
                <i class="fa-solid fa-location-dot"></i> <span style="margin-left: 1rem;">123 Main Street, Auto City, Canada</span>
                <br><br>
                <i class="fa-solid fa-phone"></i><span style="margin-left: 1rem;">123-456-7890</span>
                <br><br>
                <i class="fa-regular fa-envelope"></i><span style="margin-left: 1rem;">info@1stopautoshop.com</span>
            </div>
            <br><br>
            <div>
                <h3 style="margin-top: 0;">Quick Links</h3>
                <ul class="footerLinks">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="cars.html">Cars</a></li>
                    <li><a href="index.html#Services">Services</a></li>
                    <li><a href="parts.html">Parts</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="logoLinks">
        <i class="fa-brands fa-facebook"></i> 
        <i class="fa-brands fa-instagram"></i>
        <i class="fa-brands fa-x-twitter"></i>
        <i class="fa-brands fa-tiktok"></i>
    </div>
</footer>

</html>