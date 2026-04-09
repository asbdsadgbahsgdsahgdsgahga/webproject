<?php
// 1. DATABASE CONNECTION SETTINGS
$host = 'localhost';
$db   = 'coffeeshop';
$user = 'root'; 
$pass = ''; 

$message = ""; // To store the success or error message

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. HANDLE THE FORM SUBMISSION (ORDER SYSTEM)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
        $name = htmlspecialchars(trim($_POST['customer_name']));
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $phone = htmlspecialchars(trim($_POST['phone']));
        $coffee = htmlspecialchars(trim($_POST['coffee_name']));
        $qty = filter_var($_POST['quantity'], FILTER_VALIDATE_INT);
        $price = filter_var($_POST['unit_price'], FILTER_VALIDATE_FLOAT);

        if ($name && $email && $qty && $price) {
            $total = $qty * $price;

            $stmt = $pdo->prepare("INSERT INTO orders (customer_name, email, phone, coffee_name, quantity, total_price) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $phone, $coffee, $qty, $total])) {
                $message = "<p style='color: green; font-weight: bold;'>✅ Order for $coffee placed successfully!</p>";
            }
        } else {
            $message = "<p style='color: red;'>❌ Please fill out all fields correctly.</p>";
        }
    }
} catch(PDOException $e) {
    $message = "<p style='color: red;'>Database error: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia Coffee Shop | Full Stack</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>

    <header>
        <div class="logo">Academia <span>Coffee Shop</span></div>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#menu">Menu</a></li>
                <li><a href="#about">About</a></li>
            </ul>
        </nav>
    </header>

    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Crafted Coffee,<br> Perfected Daily.</h1>
            <?php echo $message; ?>
            <a href="#menu" class="cta-button">View Menu</a>
        </div>
    </section>

    <section id="menu" class="menu-section">
        <h2>Our Available Iteams</h2>
        <div class="menu-grid"></div>
    </section>

    <section id="about" class="about-section">
        <div class="about-content">
            <h2>About Us</h2>
            <p>Founded in 2026, The Artisan Roastery is dedicated to bringing ethical, single-origin coffee to your cup. We believe in sustainable farming and precision roasting. Whether you need a quick espresso or a slow pour-over, we have crafted our menu to elevate your morning ritual.</p>
            <p><strong>Contact Number:</strong> (555) 123-4567</p>
        </div>
    </section>

    <footer class="footer-section">
        <div class="footer-content">
            <p>© 2026 Artisan Roastery. All rights reserved.</p>
            <p>Follow us on social media for seasonal blends and shop updates.</p>
        </div>
    </footer>

    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Place Your Order</h2>
            
            <form action="index.php" method="POST">
                <input type="hidden" id="coffee_name" name="coffee_name">
                <input type="hidden" id="unit_price" name="unit_price">
                
                <h3 id="modal_coffee_title">Coffee Name</h3>
                <p>Price: $<span id="modal_coffee_price">0.00</span></p>

                <div class="form-group">
                    <label>Your Name:</label>
                    <input type="text" name="customer_name" required>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Phone:</label>
                    <input type="tel" name="phone" required>
                </div>
                <div class="form-group">
                    <label>Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" max="10" value="1" onchange="updateTotal()" required>
                </div>
                
                <h3>Total: $<span id="modal_total_price">0.00</span></h3>
                
                <button type="submit" name="place_order" class="submit-btn">Confirm Order</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>