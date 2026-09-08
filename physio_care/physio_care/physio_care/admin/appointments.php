<?php
require_once __DIR__ . '/_init.php';
require_admin();

/* HANDLE ACTIONS */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    csrf_verify();

    $action = $_POST['action'] ?? '';
    $id = (int)($_POST['id'] ?? 0);

    /* DELETE */
    if ($id > 0 && $action === 'delete') {

        $stmt = $conn->prepare("DELETE FROM appointments WHERE id=?");
        $stmt->bind_param("i",$id);
        $stmt->execute();

        header("Location: appointments.php");
        exit();
    }

    /* STATUS UPDATE */
    if ($id > 0 && $action === 'status') {

        $status = $_POST['status'] ?? 'new';

        $allowed = ['new','confirmed','completed','cancelled'];

        if(!in_array($status,$allowed)){
            $status='new';
        }

        $stmt = $conn->prepare("UPDATE appointments SET status=? WHERE id=?");
        $stmt->bind_param("si",$status,$id);
        $stmt->execute();

        header("Location: appointments.php");
        exit();
    }
}

/* FETCH DATA */

$sql="SELECT * FROM appointments ORDER BY created_at DESC";

$stmt=$conn->prepare($sql);
$stmt->execute();
$result=$stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin - Appointments</title>

<style>

body{
margin:0;
font-family:Arial;
background:#f1f3f6;
display:flex;
}

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

.main{
flex:1;
padding:30px;
}

.header{
display:flex;
justify-content:space-between;
align-items:center;
}

.table-box{
margin-top:20px;
background:white;
padding:20px;
border-radius:12px;
box-shadow:0 4px 10px rgba(0,0,0,0.05);
overflow:auto;
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
padding:10px;
border-bottom:1px solid #ddd;
text-align:left;
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

.new{background:#ffe9b5;}
.confirmed{background:#c9f7d6;}
.completed{background:#d7e9ff;}
.cancelled{background:#ffd7dd;}

.msg{
max-width:250px;
white-space:pre-wrap;
}

button{
padding:6px 10px;
border:none;
border-radius:6px;
cursor:pointer;
}

.btn-danger{
background:#d11a2a;
color:white;
}

.btn-edit{
background:#2563eb;
color:white;
text-decoration:none;
padding:6px 10px;
border-radius:6px;
margin-right:5px;
}

select{
padding:5px;
border-radius:6px;
}

</style>

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

<h2>Admin</h2>

<a href="dashboard.php">Dashboard</a>

<a href="appointments.php" class="active">Appointments</a>

<a href="services.php">Services</a>

<a href="admin_contact.php">Contact</a>

<a href="logout.php" class="logout">Logout</a>

</div>


<!-- MAIN -->

<div class="main">

<div class="header">
<h2>Appointments</h2>
</div>


<div class="table-box">

<table>

<tr>

<th>ID</th>
<th>Name</th>
<th>Phone</th>
<th>Email</th>
<th>Service</th>
<th>Date</th>
<th>Time</th>
<th>Message</th>
<th>Status</th>
<th>Action</th>

</tr>


<?php if($result && $result->num_rows>0){ ?>

<?php while($row=$result->fetch_assoc()){ 

$st=$row['status'];

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo e($row['name']); ?></td>

<td><?php echo e($row['phone']); ?></td>

<td><?php echo e($row['email']); ?></td>

<td><?php echo e($row['service']); ?></td>

<td><?php echo e($row['date']); ?></td>

<td><?php echo e($row['time']); ?></td>

<td class="msg"><?php echo e($row['message']); ?></td>


<!-- STATUS -->

<td>

<form method="POST">

<input type="hidden" name="csrf_token" value="<?php echo e(csrf_token()); ?>">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<input type="hidden" name="action" value="status">

<select name="status" onchange="this.form.submit()">

<option value="new" <?php if($st=='new') echo 'selected'; ?>>New</option>

<option value="confirmed" <?php if($st=='confirmed') echo 'selected'; ?>>Confirmed</option>

<option value="completed" <?php if($st=='completed') echo 'selected'; ?>>Completed</option>

<option value="cancelled" <?php if($st=='cancelled') echo 'selected'; ?>>Cancelled</option>

</select>

</form>

</td>


<!-- ACTION -->

<td>

<a href="edit_appointment.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>

<form method="POST" style="display:inline;">

<input type="hidden" name="csrf_token" value="<?php echo e(csrf_token()); ?>">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<input type="hidden" name="action" value="delete">

<button class="btn-danger" onclick="return confirm('Delete appointment?')">Delete</button>

</form>

</td>

</tr>

<?php } ?>

<?php } else { ?>

<tr>

<td colspan="10">No Appointments Found</td>

</tr>

<?php } ?>


</table>

</div>

</div>

</body>
</html>