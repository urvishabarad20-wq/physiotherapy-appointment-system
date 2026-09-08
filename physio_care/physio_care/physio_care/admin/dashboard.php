<?php
require_once __DIR__ . '/_init.php';
require_admin();

// Counts
$totalAppointments = 0;
$newAppointments = 0;
$totalServices = 0;

if ($r = $conn->query("SELECT COUNT(*) AS c FROM appointments")) {
    $totalAppointments = (int)$r->fetch_assoc()['c'];
}

if ($r = $conn->query("SELECT COUNT(*) AS c FROM appointments WHERE status='new'")) {
    $newAppointments = (int)$r->fetch_assoc()['c'];
}

if ($r = $conn->query("SELECT COUNT(*) AS c FROM services WHERE is_active=1")) {
    $totalServices = (int)$r->fetch_assoc()['c'];
}

$latest = $conn->query("
    SELECT id, name, phone, service, date, time, status, created_at 
    FROM appointments 
    ORDER BY created_at DESC 
    LIMIT 10
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin - Dashboard</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f1f3f6;
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:220px;
    background:#0b1f2b;
    min-height:100vh;
    color:white;
}

.sidebar h2{
    padding:20px;
    margin:0;
}

.sidebar a{
    display:block;
    padding:14px 20px;
    color:white;
    text-decoration:none;
}

.sidebar a:hover{
    background:#162c3b;
}

.sidebar .active{
    background:#162c3b;
}

.sidebar .logout{
    background:#e63946;
    margin-top:20px;
}

/* MAIN CONTENT */
.main{
    flex:1;
    padding:30px;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.badge{
    background:#e63946;
    color:white;
    padding:6px 12px;
    border-radius:20px;
    font-size:14px;
}

/* CARDS */
.stats{
    display:grid;
    grid-template-columns: repeat(3,1fr);
    gap:20px;
    margin-top:20px;
}

.card{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,0.05);
}

.card h3{
    margin:0;
    color:#555;
}

.big{
    font-size:30px;
    font-weight:bold;
    color:#1e90ff;
    margin-top:10px;
}

/* TABLE */
.table-box{
    margin-top:30px;
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,0.05);
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:10px;
    border-bottom:1px solid #ddd;
}

th{
    background:#243b55;
    color:white;
}

.pill{
    padding:4px 10px;
    border-radius:20px;
    font-size:12px;
}

.new{ background:#ffe9b5; }
.confirmed{ background:#c9f7d6; }
.completed{ background:#d7e9ff; }
.cancelled{ background:#ffd7dd; }

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Admin</h2>
    <a href="dashboard.php" class="active">Dashboard</a>
    <a href="appointments.php">Appointments</a>
    <a href="services.php">Services</a>
    <a href="admin_contact.php">Contact</a>
    <a href="logout.php" class="logout">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<div class="header">
    <h2>Dashboard Overview</h2>
    <div class="badge"><?php echo $newAppointments; ?> New Appointments</div>
</div>

<!-- STATS -->
<div class="stats">
    <div class="card">
        <h3>Total Appointments</h3>
        <div class="big"><?php echo $totalAppointments; ?></div>
    </div>

    <div class="card">
        <h3>New Appointments</h3>
        <div class="big"><?php echo $newAppointments; ?></div>
    </div>

    <div class="card">
        <h3>Active Services</h3>
        <div class="big"><?php echo $totalServices; ?></div>
    </div>
</div>

<!-- LATEST TABLE -->
<div class="table-box">
<h3>Latest Appointments</h3>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Phone</th>
<th>Service</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
</tr>

<?php if($latest && $latest->num_rows > 0) { ?>
<?php while($row = $latest->fetch_assoc()) { ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo e($row['name']); ?></td>
<td><?php echo e($row['phone']); ?></td>
<td><?php echo e($row['service']); ?></td>
<td><?php echo e($row['date']); ?></td>
<td><?php echo e($row['time']); ?></td>
<td>
<?php
$st = $row['status'];
$class = "pill ".$st;
?>
<span class="<?php echo $class; ?>">
<?php echo ucfirst(e($st)); ?>
</span>
</td>
</tr>
<?php } ?>
<?php } else { ?>
<tr>
<td colspan="7">No Appointments Found</td>
</tr>
<?php } ?>
</table>

</div>

</div>

</body>
</html>