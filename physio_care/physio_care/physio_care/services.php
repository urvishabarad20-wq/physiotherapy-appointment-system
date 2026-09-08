<?php
include 'config.php';

$services = [];

$result = $conn->query("SELECT id, title, description, image FROM services WHERE is_active=1 ORDER BY sort_order ASC, id DESC");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}



/* Check detail view */
$singleService = null;
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    foreach($services as $s){
        if($s['id'] == $id){
            $singleService = $s;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Our Services - Physio Care</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:#f4f7fb;
}

/* HEADER SAME */
header{
    position:sticky;
    top:0;
    z-index:1000;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 60px;
    background:#0d6efd;
}

header .logo{
    color:#fff;
    font-size:22px;
    font-weight:bold;
}

header nav a{
    color:#fff;
    margin-left:25px;
    text-decoration:none;
    font-weight:500;
}

/* TITLE */
.page-title{
    text-align:center;
    margin:60px 0 30px;
    font-size:36px;
    color:#0d6efd;
}

/* GRID */
.grid{
    width:90%;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:30px;
}

/* CARD */
.card{
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    transition:0.4s;
}

.card:hover{
    transform:translateY(-8px);
    box-shadow:0 20px 40px rgba(0,0,0,0.15);
}

.card img{
    width:100%;
    height:220px;
    object-fit:cover;
}

.card-content{
    padding:25px;
}

.card-content h3{
    color:#0d6efd;
}

.btn{
    display:inline-block;
    margin-top:15px;
    padding:10px 18px;
    background:#0d6efd;
    color:#fff;
    border-radius:8px;
    text-decoration:none;
}

/* DETAIL BOX */
.detail-box{
    width:90%;
    max-width:1000px;
    margin:60px auto;
    background:#fff;
    border-radius:20px;
    box-shadow:0 15px 40px rgba(0,0,0,0.1);
    overflow:hidden;
}

.detail-box img{
    width:100%;
    height:350px;
    object-fit:cover;
}

.detail-content{
    padding:40px;
}

.detail-content h1{
    color:#0d6efd;
}

.detail-content p{
    line-height:1.8;
    color:#555;
}

.back-btn{
    display:inline-block;
    margin-bottom:20px;
    text-decoration:none;
    color:#0d6efd;
    font-weight:bold;
}

/* FOOTER EXACT SAME */
.premium-footer{
    background:#0d6efd;
    color:#fff;
    padding:50px 60px 20px;
    margin-top:80px;
}

.footer-container{
    display:flex;
    justify-content:space-between;
    flex-wrap:wrap;
    gap:40px;
}

.footer-box{
    flex:1;
    min-width:250px;
}

.footer-box h3,
.footer-box h4{
    margin-bottom:15px;
}

.footer-box ul{
    list-style:none;
    padding:0;
}

.footer-box ul li{
    margin-bottom:8px;
}

.footer-box a{
    color:#fff;
    text-decoration:none;
}

.footer-box a:hover{
    text-decoration:underline;
}

.footer-bottom{
    text-align:center;
    margin-top:30px;
    border-top:1px solid rgba(255,255,255,0.3);
    padding-top:15px;
    font-size:14px;
}
</style>
</head>

<body>

<!-- HEADER -->
<header>
    <div class="logo">🩺 Physio Care center</div>
    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="services.php">Services</a>
        <a href="appointment.php">Appointment</a>
        <a href="contact.php">Contact</a>
    </nav>
</header>

<?php if($singleService){ ?>

<!-- DETAIL VIEW -->

<div class="detail-box">
<img src="image/<?php echo $singleService['image']; ?>">
    <div class="detail-content">
        <a href="services.php" class="back-btn">← Back to Services</a>

        <h1><?php echo $singleService['title']; ?></h1>

        <p><?php echo $singleService['description']; ?></p>

        <p>
        Our clinic provides complete physiotherapy assessment, advanced equipment treatment,
        strengthening exercises, posture correction therapy and long-term recovery planning.
        Every treatment plan is customized according to patient condition.
        </p>

        <h3>Key Benefits:</h3>
        <ul>
            <li>✔ Certified & Experienced Physiotherapist</li>
            <li>✔ Modern Equipment & Techniques</li>
            <li>✔ Personalized Exercise Program</li>
            <li>✔ Faster & Safe Recovery</li>
        </ul>

        <a href="appointment.php?service=<?php echo urlencode($singleService['title']); ?>" class="btn">
            Book Appointment
        </a>
    </div>
</div>

<?php } else { ?>

<!-- SERVICE LIST -->

<h2 class="page-title">Our Expert Services</h2>

<div class="grid">
<?php foreach($services as $s){ ?>
    <a href="services.php?id=<?php echo $s['id']; ?>" style="text-decoration:none;">
        <div class="card">
<img src="image/<?php echo $s['image']; ?>">
            <div class="card-content">
                <h3><?php echo $s['title']; ?></h3>
                <p><?php echo $s['description']; ?></p>
                <span class="btn">View Details</span>
            </div>
        </div>
    </a>
<?php } ?>
</div>

<?php } ?>

<!-- FOOTER SAME AS YOUR ORIGINAL -->
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
        © 2026 Physio Care Center | Designed with ❤️ | All Rights Reserved
    </div>
</footer>

</body>
</html>