<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>About - Physio Care Center</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    box-sizing:border-box;
    margin:0;
    padding:0;
}

body{
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg,#e0f7ff,#ffffff);
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

/* ===== CONTAINER ===== */

.container{
    width:85%;
    margin:auto;
    padding-top:120px;
}

/* ===== WHITE SECTION BOX ===== */

.section{
    background:white;
    padding:40px;
    border-radius:20px;
    margin-bottom:40px;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
    transition:0.3s;
}

.section:hover{
    transform:translateY(-5px);
}

/* ===== DOCTOR ===== */

.doctor{
    display:flex;
    gap:30px;
    align-items:center;
    flex-wrap:wrap;
}

.doctor img{
    width:200px;
    height:200px;
    border-radius:50%;
    object-fit:cover;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

/* ===== VISION MISSION ===== */

.flex{
    display:flex;
    gap:25px;
    flex-wrap:wrap;
}

.box{
    flex:1;
    background:#f4fbff;
    padding:25px;
    border-radius:15px;
    font-weight:bold;
    transition:0.3s;
}

.box:hover{
    transform:scale(1.05);
}

/* ===== COUNTER ===== */

.counter-section{
    display:flex;
    justify-content:space-between;
    flex-wrap:wrap;
    text-align:center;
    gap:20px;
}

.counter-box{
    flex:1;
    min-width:200px;
    background:#007acc;
    color:white;
    padding:30px;
    border-radius:15px;
}

.counter-box h2{
    font-size:42px;
}

/* ===== TIMELINE ===== */

.timeline{
    border-left:4px solid #007acc;
    padding-left:25px;
}

.timeline-item{
    margin-bottom:25px;
}

.timeline-item h4{
    color:#007acc;
}

/* ===== FOOTER ===== */

footer{
    text-align:center;
    padding:20px;
    background:#222;
    color:white;
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

<div class="container">

<!-- ABOUT INTRO -->
<div class="section">
<h2>About Physio Care</h2>
<p>
Physio Care is a modern physiotherapy center focused on pain relief,
faster recovery, and long-term wellness using advanced scientific treatment methods.
</p>
</div>

<!-- DOCTOR -->
<div class="section doctor">
<img src="image/bansari.jpg">
<div>
<h2>Dr. Bansari Barad</h2>
<p>BPT, MPT (Orthopedic)</p>
<p>3+ Years Experience | Spine & Sports Rehabilitation Specialist</p>
</div>
</div>

<!-- VISION MISSION -->
<div class="section flex">
<div class="box">
<h3>Our Vision</h3>
<p>To become the most trusted physiotherapy center delivering advanced and affordable care.</p>
</div>

<div class="box">
<h3>Our Mission</h3>
<p>Helping every patient Move Better and Live Better with personalized treatment.</p>
</div>
</div>

<!-- COUNTER -->
<div class="section counter-section">

<div class="counter-box">
<h2 id="exp">0</h2>
<p>Years Experience</p>
</div>

<div class="counter-box">
<h2 id="patients">0</h2>
<p>Happy Patients</p>
</div>

<div class="counter-box">
<h2 id="sessions">0</h2>
<p>Therapy Sessions</p>
</div>

<div class="counter-box">
<h2 id="awards">0</h2>
<p>Awards</p>
</div>

</div>

<!-- TIMELINE -->
<div class="section">
<h2>Our Journey</h2>

<div class="timeline">

<div class="timeline-item">
<h4>2022 - Clinic Founded</h4>
<p>Started with a mission to provide quality physiotherapy services.</p>
</div>

<div class="timeline-item">
<h4>2024 - Expanded Services</h4>
<p>Introduced sports rehabilitation and advanced equipment therapy.</p>
</div>

<div class="timeline-item">
<h4>2026 - 5000+ Patients Treated</h4>
<p>Achieved milestone of helping thousands of patients recover.</p>
</div>

</div>
</div>

</div>



<script>
function animateCounter(id, target){
    let count = 0;
    let element = document.getElementById(id);
    let interval = setInterval(()=>{
        count++;
        element.innerText = count;
        if(count >= target){
            clearInterval(interval);
        }
    },10);
}

animateCounter("exp",3);
animateCounter("patients",2000);
animateCounter("sessions",12000);
animateCounter("awards",2);
</script>
<!-- ===== UNIQUE PREMIUM FOOTER START ===== -->

<style>
.premium-footer{
    margin-top:60px;
    background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    color:white;
    padding-top:50px;
    font-family: Arial, sans-serif;
}

.footer-container{
    width:85%;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:40px;
    padding-bottom:40px;
}

.footer-box h3{
    font-size:22px;
    margin-bottom:15px;
}

.footer-box h4{
    font-size:18px;
    margin-bottom:15px;
    color:#00c6ff;
}

.footer-box p{
    font-size:14px;
    line-height:1.6;
    color:#ddd;
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
    transition:0.3s;
}

.footer-box ul li a:hover{
    color:#00c6ff;
    padding-left:6px;
}

.social-icons{
    margin-top:15px;
}

.social-icons a{
    display:inline-block;
    margin-right:10px;
    font-size:18px;
    color:white;
    background:#00c6ff;
    width:35px;
    height:35px;
    text-align:center;
    line-height:35px;
    border-radius:50%;
    transition:0.3s;
    text-decoration:none;
}

.social-icons a:hover{
    background:white;
    color:#00c6ff;
}

.footer-bottom{
    background:#000;
    text-align:center;
    padding:15px;
    font-size:13px;
    letter-spacing:1px;
}
</style>

<footer class="premium-footer">

<div class="footer-container">

    <!-- Column 1 -->
    <div class="footer-box">
        <h3>🩺 Physio Care Center</h3>
        <p>
            Professional physiotherapy clinic providing advanced 
            treatment with modern equipment and certified experts.
            Our mission is to help you live pain-free.
        </p>

       
    </div>

    <!-- Column 2 -->
    <div class="footer-box">
        <h4>Quick Links</h4>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="appointment.php">Book Appointment</a></li>
        </ul>
    </div>

    <!-- Column 3 -->
    <div class="footer-box">
        <h4>Contact Info</h4>
<p>📍 Kothariya Road, Rajkot, Gujarat - 360002</p>
        <p>📞 +91 9876543210</p>
        <p>✉️ info@physiocare.com</p>
    </div>

</div>

<div class="footer-bottom">
    © 2026 Physio Care Center | Designed with ❤️ | All Rights Reserved
</div>

</footer>
</body>
</html>