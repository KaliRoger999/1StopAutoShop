<?php
$valid = false;
$val_messages = Array();

function the_results()
{
    global $valid;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && $valid) {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $phone = htmlspecialchars($_POST['phone']);
        $date = htmlspecialchars($_POST['date']);
        $time = htmlspecialchars($_POST['time']);
        $services = $_POST['services'] ?? [];
        $vehicle_year = htmlspecialchars($_POST['vehicle_year']);
        $vehicle_make = htmlspecialchars($_POST['vehicle_make']);
        $vehicle_model = htmlspecialchars($_POST['vehicle_model']);
        $comments = htmlspecialchars($_POST['comments']);

        $appointment_id = 'APT-' . date('Y') . '-' . sprintf('%06d', rand(100000, 999999));

        echo "<div class='results'>";

        echo "<div class='result-text'>";
        echo "<h2>Appointment Confirmation</h2>";
        echo "<p><strong>Appointment ID:</strong> {$appointment_id}</p>";
        echo "</div>";

        echo "<div class='result-text'>";
        echo "<p><strong>Name:</strong> {$name}</p>";
        echo "</div>";

        echo "<div class='result-text'>";
        echo "<p><strong>Email:</strong> {$email}</p>";
        echo "</div>";

        echo "<div class='result-text'>";
        echo "<p><strong>Phone:</strong> {$phone}</p>";
        echo "</div>";

        echo "<div class='result-text'>";
        echo "<p><strong>Appointment Date:</strong> {$date}</p>";
        echo "</div>";

        echo "<div class='result-text'>";
        echo "<p><strong>Appointment Time:</strong> {$time}</p>";
        echo "</div>";

        echo "<div class='result-text'>";
        echo "<p><strong>Selected Services:</strong></p>";
        echo "<ul>";
        foreach ($services as $service) {
            $safe_service = htmlspecialchars($service);
            echo "<li>{$safe_service}</li>";
        }
        echo "</ul>";
        echo "</div>";

        echo "<div class='result-text'>";
        echo "<p><strong>Vehicle:</strong> {$vehicle_year} {$vehicle_make} {$vehicle_model}</p>";
        echo "</div>";

        if (!empty($comments)) {
            echo "<div class='result-text'>";
            echo "<p><strong>Additional Comments:</strong> {$comments}</p>";
            echo "</div>";
        }

        echo "</div>";
    }
}

function validate()
{
    global $valid;
    global $val_messages;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $valid = true;

        $name = $_POST['name'] ?? '';
        if (empty($name)) {
            $val_messages['name'] = "Please enter your full name.";
            $valid = false;
        } else {
            $name_pattern = '#^[a-zA-Z\s\'-]{2,50}$#';
            if (!preg_match($name_pattern, $name)) {
                $val_messages['name'] = "Please enter a valid name (letters, spaces, hyphens, and apostrophes only).";
                $valid = false;
            } else {
                $val_messages['name'] = "";
            }
        }

        $email = $_POST['email'] ?? '';
        if (empty($email)) {
            $val_messages['email'] = "Please enter your email address.";
            $valid = false;
        } else {
            $email_pattern = '#^(.+)@([^\.].*)\.([a-z]{2,})$#';
            if (!preg_match($email_pattern, $email)) {
                $val_messages['email'] = "Please enter a valid email address.";
                $valid = false;
            } else {
                $val_messages['email'] = "";
            }
        }

        $phone = $_POST['phone'] ?? '';
        if (empty($phone)) {
            $val_messages['phone'] = "Please enter your phone number.";
            $valid = false;
        } else {
            $phone_pattern = '#^(\+?1[-.\s]?)?\(?[0-9]{3}\)?[-.\s]?[0-9]{3}[-.\s]?[0-9]{4}$#';
            if (!preg_match($phone_pattern, $phone)) {
                $val_messages['phone'] = "Please enter a valid phone number (e.g., 123-456-7890).";
                $valid = false;
            } else {
                $val_messages['phone'] = "";
            }
        }

        $date = $_POST['date'] ?? '';
        if (empty($date)) {
            $val_messages['date'] = "Please select an appointment date.";
            $valid = false;
        } else {
            $date_pattern = '#^\d{4}-\d{2}-\d{2}$#';
            if (!preg_match($date_pattern, $date)) {
                $val_messages['date'] = "Please enter a valid date.";
                $valid = false;
            } else {
                $selected_date = strtotime($date);
                $today = strtotime(date('Y-m-d'));
                if ($selected_date < $today) {
                    $val_messages['date'] = "Please select a future date.";
                    $valid = false;
                } else {
                    $val_messages['date'] = "";
                }
            }
        }

        $time = $_POST['time'] ?? '';
        if (empty($time)) {
            $val_messages['time'] = "Please select an appointment time.";
            $valid = false;
        } else {
            $time_pattern = '#^([01]?[0-9]|2[0-3]):[0-5][0-9]$#';
            if (!preg_match($time_pattern, $time)) {
                $val_messages['time'] = "Please select a valid time.";
                $valid = false;
            } else {
                $val_messages['time'] = "";
            }
        }

        $services = $_POST['services'] ?? [];
        if (!is_array($services) || count($services) < 1) {
            $val_messages['services'] = "Please select at least one service.";
            $valid = false;
        } else {
            $val_messages['services'] = "";
        }

        $vehicle_year = $_POST['vehicle_year'] ?? '';
        if (empty($vehicle_year)) {
            $val_messages['vehicle_year'] = "Please enter your vehicle year.";
            $valid = false;
        } else {
            $year_pattern = '#^(19[5-9][0-9]|20[0-2][0-9])$#';
            if (!preg_match($year_pattern, $vehicle_year)) {
                $val_messages['vehicle_year'] = "Please enter a valid year (1950-2029).";
                $valid = false;
            } else {
                $val_messages['vehicle_year'] = "";
            }
        }

        $vehicle_make = $_POST['vehicle_make'] ?? '';
        if (empty($vehicle_make)) {
            $val_messages['vehicle_make'] = "Please enter your vehicle make.";
            $valid = false;
        } else {
            $make_pattern = '#^[a-zA-Z\s\-]{2,30}$#';
            if (!preg_match($make_pattern, $vehicle_make)) {
                $val_messages['vehicle_make'] = "Please enter a valid vehicle make.";
                $valid = false;
            } else {
                $val_messages['vehicle_make'] = "";
            }
        }

        $vehicle_model = $_POST['vehicle_model'] ?? '';
        if (empty($vehicle_model)) {
            $val_messages['vehicle_model'] = "Please enter your vehicle model.";
            $valid = false;
        } else {
            $model_pattern = '#^[a-zA-Z0-9\s\-]{1,30}$#';
            if (!preg_match($model_pattern, $vehicle_model)) {
                $val_messages['vehicle_model'] = "Please enter a valid vehicle model.";
                $valid = false;
            } else {
                $val_messages['vehicle_model'] = "";
            }
        }

        $val_messages['comments'] = "";
    }
}

function the_validation_message($type)
{
    global $val_messages;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($val_messages[$type])) {
            echo "<div class='failure-message'>{$val_messages[$type]}</div>";
        }
    }
}

validate();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - 1 Stop Auto-Shop</title>
    <link rel="stylesheet" href="styles.css">
    <script src="index.js" defer></script>
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
            </ul>
        </nav>
    </div>  
</header>

<body>
<br><br><br><br><br>
<div class="appointment-container">
    <h1>Book Your Appointment</h1>
    
    <form method="POST" action="appointment.php">
        <div class="form-group">
            <label for="name">Full Name *</label>
            <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
            <?php the_validation_message('name'); ?>
        </div>

        <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            <?php the_validation_message('email'); ?>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number *</label>
            <input type="tel" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" placeholder="123-456-7890" required>
            <?php the_validation_message('phone'); ?>
        </div>

        <div class="form-group">
            <label for="date">Preferred Date *</label>
            <?php $today = date('Y-m-d'); ?>
            <input type="date" id="date" name="date" min="<?php echo $today; ?>" value="<?php echo (isset($_POST['date']) && !$valid) ? htmlspecialchars($_POST['date']) : ''; ?>" required>
            <?php the_validation_message('date'); ?>
        </div>

        <div class="form-group">
            <label for="time">Preferred Time *</label>
            <select id="time" name="time" required>
                <option value="">Select a time</option>
                <option value="08:00" <?php echo (isset($_POST['time']) && $_POST['time'] == '08:00') ? 'selected' : ''; ?>>8:00 AM</option>
                <option value="09:00" <?php echo (isset($_POST['time']) && $_POST['time'] == '09:00') ? 'selected' : ''; ?>>9:00 AM</option>
                <option value="10:00" <?php echo (isset($_POST['time']) && $_POST['time'] == '10:00') ? 'selected' : ''; ?>>10:00 AM</option>
                <option value="11:00" <?php echo (isset($_POST['time']) && $_POST['time'] == '11:00') ? 'selected' : ''; ?>>11:00 AM</option>
                <option value="12:00" <?php echo (isset($_POST['time']) && $_POST['time'] == '12:00') ? 'selected' : ''; ?>>12:00 PM</option>
                <option value="13:00" <?php echo (isset($_POST['time']) && $_POST['time'] == '13:00') ? 'selected' : ''; ?>>1:00 PM</option>
                <option value="14:00" <?php echo (isset($_POST['time']) && $_POST['time'] == '14:00') ? 'selected' : ''; ?>>2:00 PM</option>
                <option value="15:00" <?php echo (isset($_POST['time']) && $_POST['time'] == '15:00') ? 'selected' : ''; ?>>3:00 PM</option>
                <option value="16:00" <?php echo (isset($_POST['time']) && $_POST['time'] == '16:00') ? 'selected' : ''; ?>>4:00 PM</option>
                <option value="17:00" <?php echo (isset($_POST['time']) && $_POST['time'] == '17:00') ? 'selected' : ''; ?>>5:00 PM</option>
            </select>
            <?php the_validation_message('time'); ?>
        </div>

        <div class="form-group">
            <label>Services Needed * (Select all that apply)</label>
            <div class="checkbox-group">
                <label><input type="checkbox" name="services[]" value="Oil Change" <?php echo (isset($_POST['services']) && in_array('Oil Change', $_POST['services'])) ? 'checked' : ''; ?>> Oil Change</label>
                <label><input type="checkbox" name="services[]" value="Brake Inspection" <?php echo (isset($_POST['services']) && in_array('Brake Inspection', $_POST['services'])) ? 'checked' : ''; ?>> Brake Inspection</label>
                <label><input type="checkbox" name="services[]" value="Engine Diagnostics" <?php echo (isset($_POST['services']) && in_array('Engine Diagnostics', $_POST['services'])) ? 'checked' : ''; ?>> Engine Diagnostics</label>
                <label><input type="checkbox" name="services[]" value="Tire Service" <?php echo (isset($_POST['services']) && in_array('Tire Service', $_POST['services'])) ? 'checked' : ''; ?>> Tire Service</label>
                <label><input type="checkbox" name="services[]" value="Transmission Service" <?php echo (isset($_POST['services']) && in_array('Transmission Service', $_POST['services'])) ? 'checked' : ''; ?>> Transmission Service</label>
                <label><input type="checkbox" name="services[]" value="Auto Detailing" <?php echo (isset($_POST['services']) && in_array('Auto Detailing', $_POST['services'])) ? 'checked' : ''; ?>> Auto Detailing</label>
                <label><input type="checkbox" name="services[]" value="Custom Modifications" <?php echo (isset($_POST['services']) && in_array('Custom Modifications', $_POST['services'])) ? 'checked' : ''; ?>> Custom Modifications</label>
            </div>
            <?php the_validation_message('services'); ?>
        </div>

        <div class="form-group">
            <label for="vehicle_year">Vehicle Year *</label>
            <input type="number" id="vehicle_year" name="vehicle_year" value="<?php echo isset($_POST['vehicle_year']) ? htmlspecialchars($_POST['vehicle_year']) : ''; ?>" min="1950" max="2029" placeholder="2020" required>
            <?php the_validation_message('vehicle_year'); ?>
        </div>

        <div class="form-group">
            <label for="vehicle_make">Vehicle Make *</label>
            <input type="text" id="vehicle_make" name="vehicle_make" value="<?php echo isset($_POST['vehicle_make']) ? htmlspecialchars($_POST['vehicle_make']) : ''; ?>" placeholder="Honda" required>
            <?php the_validation_message('vehicle_make'); ?>
        </div>

        <div class="form-group">
            <label for="vehicle_model">Vehicle Model *</label>
            <input type="text" id="vehicle_model" name="vehicle_model" value="<?php echo isset($_POST['vehicle_model']) ? htmlspecialchars($_POST['vehicle_model']) : ''; ?>" placeholder="Civic" required>
            <?php the_validation_message('vehicle_model'); ?>
        </div>

        <div class="form-group">
            <label for="comments">Additional Comments</label>
            <textarea id="comments" name="comments" rows="4" placeholder="Any specific concerns or requests..."><?php echo isset($_POST['comments']) ? htmlspecialchars($_POST['comments']) : ''; ?></textarea>
            <?php the_validation_message('comments'); ?>
        </div>

        <button type="submit" class="appointmentBtnPhp">Book Appointment</button>
        <button type="reset" class="appointmentBtnPhp">Reset Form</button>
    </form>

    <?php the_results(); ?>
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