<?php
include 'config.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sudharo: ?? '' vapravathi 'Deprecated' error nahi ave
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {

        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            $success = "Message Sent Successfully!";
        } else {
            $error = "Something went wrong!";
        }

        $stmt->close();
    } else {
        $error = "Please fill all fields!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Contact - Physio Care</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{box-sizing:border-box;margin:0;padding:0;}

body{
    font-family:Arial, sans-serif;
    background:linear-gradient(135deg,#e0f7ff,#ffffff);
}

/* ===== HEADER ===== */
header{
    background:linear-gradient(90deg,#007acc,#00c6ff);
    padding:18px 40px;
    position:fixed;
    width:100%;
    top:0;
    z-index:1000;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
}

.logo{
    font-size:24px;
    font-weight:bold;
}

nav{
    display:flex;
    gap:25px;
}

nav a{
    color:white;
    text-decoration:none;
    font-weight:bold;
    position:relative;
}

nav a::after{
    content:"";
    position:absolute;
    width:0%;
    height:2px;
    bottom:-5px;
    left:0;
    background:white;
    transition:0.3s;
}

nav a:hover::after{
    width:100%;
}

/* ===== CONTACT SECTION ===== */
.wrapper{
    width:85%;
    margin:auto;
    padding-top:120px;
}

.contact-section{
    display:flex;
    gap:40px;
    margin-top:40px;
    flex-wrap:wrap;
}

.contact-info{
    flex:1;
    min-width:280px;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.contact-info h2{
    color:#007acc;
    margin-bottom:15px;
}

.contact-form{
    flex:1.3;
    min-width:300px;
    background:rgba(255,255,255,0.9);
    backdrop-filter:blur(10px);
    padding:30px;
    border-radius:15px;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}

.contact-form h2{
    color:#007acc;
    margin-bottom:20px;
}

.form-group{
    margin-bottom:15px;
}

label{
    font-weight:bold;
    display:block;
    margin-bottom:5px;
}

input, textarea{
    width:100%;
    padding:10px;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:14px;
}

textarea{resize:none;}

button{
    background:linear-gradient(90deg,#007acc,#00c6ff);
    color:white;
    padding:12px 25px;
    border:none;
    border-radius:25px;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:linear-gradient(90deg,#005f99,#0099cc);
}

.success{
    background:#d4edda;
    color:#155724;
    padding:8px;
    border-radius:5px;
    margin-bottom:10px;
    text-align:center;
}

.error{
    background:#f8d7da;
    color:#721c24;
    padding:8px;
    border-radius:5px;
    margin-bottom:10px;
    text-align:center;
}

/* ===== FOOTER ===== */
.premium-footer{
    margin-top:60px;
    background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    color:white;
    padding-top:50px;
}

.footer-container{
    width:85%;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:40px;
    padding-bottom:40px;
}

.footer-box h3,
.footer-box h4{
    margin-bottom:15px;
}

.footer-box h4{
    color:#00c6ff;
}

.footer-box p,
.footer-box ul li a{
    font-size:14px;
    color:#ddd;
}

.footer-box ul{
    list-style:none;
    padding:0;
}

.footer-box ul li{
    margin-bottom:8px;
}

.footer-box ul li a{
    text-decoration:none;
    transition:0.3s;
}

.footer-box ul li a:hover{
    color:#00c6ff;
    padding-left:5px;
}

.footer-bottom{
    background:#000;
    text-align:center;
    padding:15px;
    font-size:13px;
}
</style>
</head>
<body>

<header>
<div class="logo">🩺 Physio Care Center</div>
<nav>
<a href="index.php">Home</a>
<a href="about.php">About</a>
<a href="services.php">Services</a>
<a href="appointment.php">Book Appointment</a>
<a href="contact.php">Contact</a>
</nav>
</header>

<div class="wrapper">
<div class="contact-section">

<div class="contact-form">
<h2>Send Us a Message</h2>

<?php if($success): ?>
<div class="success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if($error): ?>
<div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">

<div class="form-group">
<label>Your Name</label>
<input type="text" name="name" required>
</div>

<div class="form-group">
<label>Email</label>
<input type="email" name="email" required>
</div>

<div class="form-group">
<label>Subject</label>
<input type="text" name="subject" required>
</div>

<div class="form-group">
<label>Message</label>
<textarea name="message" rows="5" required></textarea>
</div>

<button type="submit">Send Message</button>

</form>
</div>

</div>
</div>

<footer class="premium-footer">
<div class="footer-container">

<div class="footer-box">
<h3>🩺 Physio Care Center</h3>
<p>Advanced physiotherapy with certified professionals and modern technology.</p>
</div>

<div class="footer-box">
<h4>Quick Links</h4>
<ul>
<li><a href="index.php">Home</a></li>
<li><a href="about.php">About</a></li>
<li><a href="services.php">Services</a></li>
<li><a href="appointment.php">Book Appointment</a></li>
<li><a href="contact.php">Contact</a></li>
</ul>
</div>

<div class="footer-box">
<h4>Contact Info</h4>
<p>📍 Rajkot, Gujarat</p>
<br>
<iframe 
    src="https://www.google.com/maps?q=Rajkot,Gujarat&output=embed"
    width="100%" 
    height="200" 
    style="border-radius:10px;border:0;" 
    allowfullscreen="" 
    loading="lazy">
</iframe>
<p>📞 +91 98765 43210</p>
<p>📧 physiocare@gmail.com</p>
</div>

</div>

<div class="footer-bottom">
© 2026 Physio Care Center | All Rights Reserved
</div>
</footer>

</body>
</html>