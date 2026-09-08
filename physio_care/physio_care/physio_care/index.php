<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Physio Care Center</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    box-sizing:border-box;
    margin:0;
    padding:0;
}

body{
    font-family: Arial, sans-serif;
    background: url('image/banner.jpg') no-repeat center center fixed;
    background-size: cover;
}

body::before{
    content:"";
    position: fixed;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.6);
    z-index:-1;
}

/* ===== HEADER ===== */

header{
    background:rgba(0,0,0,0.8);
    padding:18px 40px;
    position:fixed;
    width:100%;
    top:0;
    z-index:1000;
    display:flex;
    justify-content:space-between;
    align-items:center;
    transition:0.4s;
}

header.scrolled{
    background:#001f2e;
    box-shadow:0 5px 15px rgba(0,0,0,0.5);
}

.logo{
    font-size:28px;
    font-weight:bold;
    color:#00e0ff;
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
    background:#00e0ff;
    transition:0.3s;
}

nav a:hover::after{
    width:100%;
}

nav a:hover{
    color:#00e0ff;
}

.menu-toggle{
    display:none;
    font-size:28px;
    color:white;
    cursor:pointer;
}

@media(max-width:768px){
    nav{
        position:absolute;
        top:70px;
        right:0;
        background:#001f2e;
        flex-direction:column;
        width:200px;
        padding:20px;
        display:none;
    }

    nav.active{
        display:flex;
    }

    .menu-toggle{
        display:block;
    }

    .services{
        flex-direction:column;
    }

    .service-card{
        width:100%;
    }
}

/* ===== HERO ===== */

.hero{
    text-align:center;
    padding:180px 20px 130px;
    color:white;
}

.hero h2{
    font-size:45px;
}

.hero p{
    margin-top:15px;
    font-size:18px;
}

.btn{
    display:inline-block;
    margin-top:25px;
    padding:12px 25px;
    background:#00e0ff;
    color:black;
    text-decoration:none;
    border-radius:30px;
    transition:0.3s;
    font-weight:bold;
}

.btn:hover{
    background:white;
    transform:scale(1.05);
}

.container{
    width:85%;
    margin:auto;
    margin-top:40px;
}

/* ===== SERVICES ===== */

.services{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
}

.service-card{
    background:white;
    padding:20px;
    width:30%;
    border-radius:15px;
    transition:0.3s;
    text-align:center;
}

.service-card:hover{
    transform:translateY(-10px);
    box-shadow:0 15px 25px rgba(0,0,0,0.3);
}

.service-card img{
    width:100%;
    height:180px;
    object-fit:cover;
    border-radius:10px;
}

/* ===== DOCTOR ===== */

.doctor{
    margin-top:60px;
    padding:30px;
    border-radius:20px;
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(10px);
    color:white;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.5);
}

.doctor img{
    width:160px;
    height:160px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #00e0ff;
    margin-bottom:15px;
}

/* ===== TESTIMONIAL ===== */

.testimonial-section{
    margin-top:60px;
    padding:40px;
    background:white;
    border-radius:15px;
    text-align:center;
}

.testimonial-section h2{
    margin-bottom:30px;
    color:#00bfff;
}

.testimonial-slider{
    position:relative;
    max-width:700px;
    margin:auto;
}

.testimonial-card{
    display:none;
    padding:20px;
    animation:fade 1s ease-in-out;
}

.testimonial-card.active{
    display:block;
}

.patient img{
    width:80px;
    height:80px;
    border-radius:50%;
    object-fit:cover;
}

.stars{
    color:gold;
    font-size:20px;
}

@keyframes fade{
    from{opacity:0;}
    to{opacity:1;}
}

/* ===== WHATSAPP PREMIUM BUTTON ===== */

.whatsapp{
    position:fixed;
    bottom:25px;
    right:25px;
    z-index:1000;
}

.whatsapp a{
    background:#25D366;
    width:65px;
    height:65px;
    display:flex;
    justify-content:center;
    align-items:center;
    border-radius:50%;
    box-shadow:0 8px 20px rgba(0,0,0,0.4);
    transition:0.3s;
    text-decoration:none;
}

.whatsapp a:hover{
    transform:scale(1.1);
    box-shadow:0 12px 25px rgba(0,0,0,0.6);
}

.whatsapp img{
    width:35px;
}
</style>
</head>

<body>

<header>
<div class="logo">🩺 Physio Care Center</div>

<div class="menu-toggle" onclick="toggleMenu()">☰</div>

<nav id="nav">
<a href="index.php">Home</a>
<a href="about.php">About</a>
<a href="services.php">Services</a>
<a href="appointment.php">Book Appointment</a>
<a href="contact.php">Contact</a>

</nav>
</header>

<!-- HERO -->
<div class="hero">
<h2>Move Better. Live Better.</h2>
<p>Advanced Physiotherapy | Faster Recovery | Better Life</p>
<a href="appointment.php" class="btn">Book Appointment</a>
</div>

<div class="container">

<h2 style="color:white; text-align:center; margin-bottom:20px;">Our Services</h2>

<div class="services">

<div class="service-card">
<img src="image/backpain.jpg">
<h3>Back Pain Therapy</h3>
<p>Advanced techniques for spine & posture correction.</p>
</div>

<div class="service-card">
<img src="image/sports injury.jpg">
<h3>Sports Injury</h3>
<p>Professional rehab for athletes & active people.</p>
</div>

<div class="service-card">
<img src="image/Knee Pain Relief.jpg">
<h3>Knee Pain Relief</h3>
<p>Personalized therapy programs for joint pain.</p>
</div>

</div>

<div class="doctor">
<h2>Meet Our Specialist</h2>
<img src="image/bansari.jpg">
<h3>Dr. Bansari Barad</h3>
<p>BPT, MPT (Orthopedic) | 3+ Years Experience</p>
</div>

<div class="testimonial-section">
<h2>What Our Patients Say</h2>

<div class="testimonial-slider">

<div class="testimonial-card active">
<p>"Excellent treatment and very friendly staff. My back pain reduced in just 2 weeks!"</p>
<div class="patient">
<img src="https://randomuser.me/api/portraits/men/32.jpg">
<h4>Ramesh Patel</h4>
<div class="stars">★★★★★</div>
</div>
</div>

<div class="testimonial-card">
<p>"Very professional doctor and modern equipment. Highly recommended clinic."</p>
<div class="patient">
<img src="https://randomuser.me/api/portraits/women/44.jpg">
<h4>Priya Shah</h4>
<div class="stars">★★★★★</div>
</div>
</div>

</div>
</div>

</div>

<!-- WHATSAPP -->
<div class="whatsapp">
<a href="https://wa.me/9316400821" target="_blank">
<img src="https://cdn-icons-png.flaticon.com/512/733/733585.png">
</a>
</div>

<script>
function toggleMenu(){
    document.getElementById("nav").classList.toggle("active");
}

let cards = document.querySelectorAll(".testimonial-card");
let i = 0;

setInterval(function(){
    cards[i].classList.remove("active");
    i = (i + 1) % cards.length;
    cards[i].classList.add("active");
}, 3000);
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