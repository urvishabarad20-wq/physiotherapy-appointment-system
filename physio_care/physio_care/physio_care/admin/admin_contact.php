<?php
include dirname(__DIR__) . '/config.php';

/* DELETE MESSAGE */
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM contact_messages WHERE id=$id");
    header("Location: admin_contact.php");
    exit();
}

/* FETCH MESSAGES */
$result = $conn->query("SELECT * FROM contact_messages ORDER BY id DESC");
$count = $result->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin - Contact</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#f4f6f9;
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:220px;
    background:#0d1b2a;
    height:100vh;
    padding-top:20px;
    position:fixed;
}

.sidebar h2{
    color:white;
    text-align:center;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    color:white;
    padding:12px 20px;
    text-decoration:none;
    transition:0.3s;
}

.sidebar a:hover{
    background:#1b263b;
}

.active{
    background:#1b263b;
}

.logout{
    background:#e63946;
    margin-top:20px;
}

/* CONTENT */
.main{
    margin-left:220px;
    padding:40px;
    width:100%;
}

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.badge{
    background:#e63946;
    color:white;
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    background:white;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    border-radius:10px;
    overflow:hidden;
}

th{
    background:#1d3557;
    color:white;
    padding:14px;
}

td{
    padding:12px;
    border-bottom:1px solid #eee;
}

tr:hover{
    background:#f1f3f5;
}

.delete-btn{
    background:#e63946;
    color:white;
    padding:6px 10px;
    text-decoration:none;
    border-radius:5px;
    font-size:12px;
}
</style>
</head>

<body>

<div class="sidebar">
    <h2>Admin</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="appointments.php">Appointments</a>
    <a href="services.php">Services</a>
    <a href="admin_contact.php" class="active">Contact</a>
    <a href="logout.php" class="logout">Logout</a>
</div>

<div class="main">

<div class="top-bar">
    <h3>Contact Messages</h3>
    <span class="badge"><?php echo $count; ?> Messages</span>
</div>

<?php if($count > 0){ ?>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Subject</th>
<th>Message</th>
<th>Date</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['subject']; ?></td>
<td><?php echo $row['message']; ?></td>
<td><?php echo $row['created_at']; ?></td>
<td>
<a class="delete-btn" 
   href="?delete=<?php echo $row['id']; ?>" 
   onclick="return confirm('Are you sure to delete this message?');">
   Delete
</a>
</td>
</tr>
<?php } ?>

</table>

<?php } else { ?>

<p>No Contact Messages Found</p>

<?php } ?>

</div>

</body>
</html>