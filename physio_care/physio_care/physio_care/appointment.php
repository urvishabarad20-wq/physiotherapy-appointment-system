<?php
include 'config.php';

$services = [];
$success = "";
$error = "";

/* ===== FETCH SERVICES ===== */
$sql = "SELECT title FROM services WHERE is_active=1 ORDER BY sort_order ASC, id DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row['title'];
    }
}

/* ===== GENERATE 1 HOUR SLOTS ===== */
function generateSlots(){

    $slots = [];

    // Morning 10–1
    for($h=10; $h<13; $h++){

        $start = date("h:i A", strtotime($h.":00"));
        $end   = date("h:i A", strtotime(($h+1).":00"));

        $slots[] = $start . " - " . $end;
    }

    // Afternoon 2–8
    for($h=14; $h<20; $h++){

        $start = date("h:i A", strtotime($h.":00"));
        $end   = date("h:i A", strtotime(($h+1).":00"));

        $slots[] = $start . " - " . $end;
    }

    return $slots;
}

$slots = generateSlots();

/* ===== FORM SUBMIT ===== */
if(isset($_POST['submit'])){

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$service = $_POST['service'];
$date = $_POST['date'];
$time = $_POST['time'];
$message = $_POST['message'];

$today = date("Y-m-d");

if($date < $today){
    $error = "Past date not allowed!";
}

elseif(date('l', strtotime($date)) == "Sunday"){
    $error = "Clinic Closed on Sunday!";
}

else{

    $check = $conn->query("SELECT id FROM appointments WHERE date='$date' AND time='$time'");

    if($check->num_rows >= 3){
        $error = "This time slot is fully booked!";
    }else{

        $conn->query("INSERT INTO appointments 
        (name,phone,email,service,date,time,message)
        VALUES 
        ('$name','$phone','$email','$service','$date','$time','$message')");

        $success = "Appointment Booked Successfully!";
    }
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Book Appointment - Physio Care</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

*{box-sizing:border-box;margin:0;padding:0;}

body{
font-family:Arial;
background:linear-gradient(135deg,#e0f7ff,#ffffff);
}

header{
background:linear-gradient(90deg,#007acc,#00c6ff);
padding:18px 40px;
position:fixed;
width:100%;
top:0;
display:flex;
justify-content:space-between;
color:white;
z-index:1000;
}

nav{display:flex;gap:25px;}

nav a{
color:white;
text-decoration:none;
font-weight:bold;
}

.wrapper{
width:85%;
margin:auto;
padding-top:120px;
}

.appointment-section{
display:flex;
gap:40px;
margin-top:40px;
flex-wrap:wrap;
}

.info-box,.form-box{
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 10px 25px rgba(0,0,0,0.1);
flex:1;
min-width:300px;
}

.form-group{margin-bottom:15px;}

label{
font-weight:bold;
display:block;
margin-bottom:5px;
}

input,select,textarea{
width:100%;
padding:10px;
border:1px solid #ccc;
border-radius:8px;
}

button{
background:linear-gradient(90deg,#007acc,#00c6ff);
color:white;
padding:12px 25px;
border:none;
border-radius:25px;
cursor:pointer;
}

.success{
background:#d4edda;
color:#155724;
padding:12px;
margin-bottom:15px;
border-radius:8px;
}

.error{
background:#f8d7da;
color:#721c24;
padding:12px;
margin-bottom:15px;
border-radius:8px;
}

.slot-container{
display:flex;
flex-wrap:wrap;
gap:10px;
}

.slot-btn{
border:1px solid #007acc;
padding:8px 12px;
border-radius:20px;
cursor:pointer;
font-size:14px;
}

.slot-btn input{
display:none;
}

.slot-btn input:checked + span{
background:#007acc;
color:white;
padding:6px 10px;
border-radius:20px;
}

.slot-btn input:disabled + span{
background:#ccc;
color:#666;
cursor:not-allowed;
border-radius:20px;
padding:6px 10px;
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

.footer-box p{
font-size:14px;
line-height:1.6;
}

.footer-box ul{
list-style:none;
padding:0;
}

.footer-box ul li{
margin-bottom:10px;
}

.footer-box ul li a{
color:#ddd;
text-decoration:none;
}

.footer-box ul li a:hover{
color:#00c6ff;
}

.footer-bottom{
background:#000;
text-align:center;
padding:15px;
font-size:13px;
}

</style>

<script>
function checkSunday(){
let d = new Date(document.getElementById("date").value);
if(d.getDay() == 0){
alert("Clinic Closed on Sunday!");
document.getElementById("date").value="";
}
}
</script>

</head>

<body>

<header>

<div>🩺 Physio Care Center</div>

<nav>
<a href="index.php">Home</a>
<a href="about.php">About</a>
<a href="services.php">Services</a>
<a href="appointment.php">Book Appointment</a>
<a href="contact.php">Contact</a>
</nav>

</header>

<div class="wrapper">

<div class="appointment-section">

<div class="info-box">

<h2>Clinic Timing</h2>

<p>
Morning: 10:00 AM – 1:00 PM<br>
Afternoon: 2:00 PM – 8:00 PM<br>
Sunday Closed
</p>

</div>

<div class="form-box">

<h2>Book Appointment</h2>

<?php if($success) echo "<div class='success'>$success</div>"; ?>
<?php if($error) echo "<div class='error'>$error</div>"; ?>

<form method="post">

<div class="form-group">
<label>Full Name</label>
<input type="text" name="name" required>
</div>

<div class="form-group">
<label>Phone</label>
<input type="text" name="phone" required>
</div>

<div class="form-group">
<label>Email</label>
<input type="email" name="email" required>
</div>

<div class="form-group">
<label>Select Service</label>

<select name="service" required>

<option value="">-- Choose Service --</option>

<?php foreach ($services as $s){ ?>

<option value="<?php echo htmlspecialchars($s); ?>">

<?php echo htmlspecialchars($s); ?>

</option>

<?php } ?>

</select>

</div>

<div class="form-group">

<label>Select Date</label>

<input type="date" name="date" id="date"

min="<?php echo date('Y-m-d'); ?>"

onchange="checkSunday()" required>

</div>

<div class="form-group">

<label>Select Time Slot</label>

<div class="slot-container">

<?php
foreach($slots as $slot){

$count = 0;

if(isset($_POST['date'])){
$d = $_POST['date'];
$r = $conn->query("SELECT id FROM appointments WHERE date='$d' AND time='$slot'");
$count = $r->num_rows;
}

$disabled = ($count >= 3) ? "disabled" : "";
?>

<label class="slot-btn">

<input type="radio" name="time" value="<?php echo $slot; ?>" required <?php echo $disabled; ?>>

<span>

<?php echo $slot; ?> <?php if($count>=3) echo "(Full)"; ?>

</span>

</label>

<?php } ?>

</div>

</div>

<div class="form-group">

<label>Message (Optional)</label>

<textarea name="message" rows="4"></textarea>

</div>

<button type="submit" name="submit">Book Appointment</button>

</form>

</div>

</div>

</div>

<footer class="premium-footer">

<div class="footer-container">

<div class="footer-box">

<h3>🩺 Physio Care Center</h3>

<p>
Professional physiotherapy clinic providing advanced 
treatment with modern equipment and certified experts.
Our mission is to help you live pain-free.
</p>

</div>

<div class="footer-box">

<h4>Quick Links</h4>

<ul>

<li><a href="index.php">Home</a></li>
<li><a href="about.php">About</a></li>
<li><a href="services.php">Services</a></li>
<li><a href="appointment.php">Book Appointment</a></li>

</ul>

</div>

<div class="footer-box">

<h4>Contact Info</h4>

<p>📍 Kothariya Road, Rajkot, Gujarat - 360002</p>
<p>📞 +91 9876543210</p>
<p>✉ info@physiocare.com</p>

</div>

</div>

<div class="footer-bottom">

© 2026 Physio Care Center | All Rights Reserved

</div>

</footer>

</body>
</html>