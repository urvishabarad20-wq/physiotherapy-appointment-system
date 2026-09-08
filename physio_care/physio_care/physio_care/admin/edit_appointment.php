<?php
require_once __DIR__ . '/_init.php';
require_admin();

$success = "";
$error = "";

/* ===== FETCH SERVICES ===== */
$services = [];
$sq = mysqli_query($conn,"SELECT title FROM services WHERE is_active=1 ORDER BY sort_order ASC, id DESC");
while($s = mysqli_fetch_assoc($sq)){
    $services[] = $s['title'];
}

/* ===== GET APPOINTMENT ===== */
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $result = mysqli_query($conn,"SELECT * FROM appointments WHERE id=$id");
    $row = mysqli_fetch_assoc($result);

    if(!$row){
        die("Appointment not found!");
    }
}

/* ===== UPDATE ===== */
if(isset($_POST['update'])){

    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $service = mysqli_real_escape_string($conn,$_POST['service']);
    $date = $_POST['date'];
    $time = $_POST['time'];

    $today = date("Y-m-d");

    if($date < $today){
        $error = "Past date not allowed!";
    }
    elseif(date('l', strtotime($date)) == "Sunday"){
        $error = "Clinic Closed on Sunday!";
    }
    else{
        $hour = date("H", strtotime($time));

        if(!(($hour >= 10 && $hour < 13) || ($hour >= 14 && $hour <= 20))){
            $error = "Invalid time selected!";
        }
        else{

            $check = mysqli_query($conn,
            "SELECT id FROM appointments 
             WHERE date='$date' AND time='$time' 
             AND id!=$id");

            if(mysqli_num_rows($check) >= 3){
                $error = "This slot already full!";
            }
            else{

                mysqli_query($conn,
                "UPDATE appointments SET
                 name='$name',
                 phone='$phone',
                 service='$service',
                 date='$date',
                 time='$time'
                 WHERE id=$id");

                echo "<script>
                alert('Appointment Updated Successfully!');
                window.location='appointments.php';
                </script>";
                exit;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Appointment - Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
font-family:Arial;
background:#eef2f7;
margin:0;
}

.admin-wrapper{
width:550px;
margin:60px auto;
background:#fff;
padding:35px;
border-radius:15px;
box-shadow:0 15px 40px rgba(0,0,0,0.1);
}

h2{
text-align:center;
margin-bottom:25px;
color:#333;
}

.form-group{
margin-bottom:15px;
}

label{
font-weight:bold;
display:block;
margin-bottom:6px;
}

input,select{
width:100%;
padding:10px;
border-radius:8px;
border:1px solid #ccc;
}

button{
width:100%;
padding:12px;
background:linear-gradient(90deg,#007bff,#00c6ff);
border:none;
border-radius:25px;
color:white;
font-size:16px;
cursor:pointer;
}

button:hover{
opacity:0.9;
}

.error{
background:#f8d7da;
color:#721c24;
padding:10px;
border-radius:8px;
margin-bottom:15px;
text-align:center;
}

.back{
text-align:center;
margin-top:15px;
}

.back a{
text-decoration:none;
color:#007bff;
font-weight:bold;
}
</style>
</head>

<body>

<div class="admin-wrapper">

<h2>Edit Appointment</h2>

<?php if($error) echo "<div class='error'>$error</div>"; ?>

<form method="POST">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<div class="form-group">
<label>Patient Name</label>
<input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
</div>

<div class="form-group">
<label>Phone</label>
<input type="text" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>" required>
</div>

<div class="form-group">
<label>Select Service</label>
<select name="service" required>
<?php foreach($services as $s){ ?>
<option value="<?php echo htmlspecialchars($s); ?>"
<?php if($row['service']==$s) echo "selected"; ?>>
<?php echo htmlspecialchars($s); ?>
</option>
<?php } ?>
</select>
</div>

<div class="form-group">
<label>Date</label>
<input type="date" name="date" value="<?php echo $row['date']; ?>" required>
</div>

<div class="form-group">
<label>Time</label>
<input type="time" name="time" value="<?php echo $row['time']; ?>" required>
</div>

<button type="submit" name="update">Update Appointment</button>

</form>

<div class="back">
<a href="appointments.php">← Back to Dashboard</a>
</div>

</div>

</body>
</html>