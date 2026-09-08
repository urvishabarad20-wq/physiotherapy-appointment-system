<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim((string)($_POST['name'] ?? ''));
    $phone = trim((string)($_POST['phone'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $service = trim((string)($_POST['service'] ?? ''));
    $date = (string)($_POST['date'] ?? '');
    $time = (string)($_POST['time'] ?? '');
    $message = trim((string)($_POST['message'] ?? ''));

    $stmt = $conn->prepare("INSERT INTO appointments (name, phone, email, service, date, time, message) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss", $name, $phone, $email, $service, $date, $time, $message);

    if ($stmt->execute()) {
?>
<!DOCTYPE html>
<html>
<head>
<title>Appointment Confirmed - Physio Care</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:Arial;
    background:linear-gradient(135deg,#e0f7ff,#ffffff);
}

/* HEADER */
header{
    background:linear-gradient(90deg,#007acc,#00c6ff);
    padding:18px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
}
.logo{
    font-size:22px;
    font-weight:bold;
}
nav a{
    color:white;
    margin-left:20px;
    text-decoration:none;
    font-weight:bold;
}

/* SUCCESS BOX */
.success-wrapper{
    width:90%;
    max-width:600px;
    margin:80px auto;
}

.success-box{
    background:white;
    padding:40px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
    animation:fadeIn 0.6s ease-in-out;
}

.success-box h2{
    color:#28a745;
    margin-bottom:15px;
}

.success-box p{
    margin-bottom:20px;
    font-size:16px;
}

.btn{
    display:inline-block;
    margin:8px;
    padding:12px 25px;
    border-radius:25px;
    text-decoration:none;
    color:white;
    background:linear-gradient(90deg,#007acc,#00c6ff);
    transition:0.3s;
}

.btn:hover{
    background:linear-gradient(90deg,#005f99,#0099cc);
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

/* FOOTER */
footer{
    margin-top:60px;
    background:#0f2027;
    color:white;
    text-align:center;
    padding:20px;
}

/* WhatsApp Button */
.whatsapp-float{
    position:fixed;
    width:60px;
    height:60px;
    bottom:25px;
    right:25px;
    background:#25d366;
    color:white;
    border-radius:50%;
    text-align:center;
    font-size:30px;
    line-height:60px;
    text-decoration:none;
}
.whatsapp-float:hover{
    background:#1ebe5d;
}
</style>
</head>

<body>

<header>
<div class="logo">🩺 Physio Care</div>
<nav>
<a href="index.php">Home</a>
<a href="services.php">Services</a>
<a href="appointment.php">Book Appointment</a>
</nav>
</header>

<div class="success-wrapper">
<div class="success-box">
    <h2>✅ Appointment Booked Successfully!</h2>
    <p>
        Thank you, 
        <strong><?php echo htmlspecialchars($name); ?></strong>.<br>
        Your appointment for 
        <strong><?php echo htmlspecialchars($service); ?></strong> 
        on <strong><?php echo htmlspecialchars($date); ?></strong> 
        at <strong><?php echo htmlspecialchars($time); ?></strong> 
        has been confirmed.
    </p>

    <a href="appointment.php" class="btn">Book Another</a>
    <a href="index.php" class="btn">Go to Home</a>
</div>
</div>

<footer>
© 2026 Physio Care | All Rights Reserved
</footer>

<a href="https://wa.me/919876543210" target="_blank" class="whatsapp-float">💬</a>

</body>
</html>

<?php
    } else {
        echo "Error: " . $conn->error;
    }
}
?>