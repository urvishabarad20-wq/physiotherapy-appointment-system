<?php
require_once __DIR__ . '/_init.php';
require_admin();

/* DELETE */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $conn->prepare("DELETE FROM services WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }
        header("Location: services.php");
        exit();
    }

    if ($action === 'save') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $image = trim($_POST['image'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $sort_order = (int)($_POST['sort_order'] ?? 0);

        if ($title === '' || $description === '' || $image === '') {
            $error = "Please fill all required fields.";
        } else {
            if ($id > 0) {
                $stmt = $conn->prepare("UPDATE services SET title=?, description=?, image=?, is_active=?, sort_order=? WHERE id=?");
                $stmt->bind_param("sssiii", $title, $description, $image, $is_active, $sort_order, $id);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("INSERT INTO services (title, description, image, is_active, sort_order) VALUES (?,?,?,?,?)");
                $stmt->bind_param("sssii", $title, $description, $image, $is_active, $sort_order);
                $stmt->execute();
            }
            header("Location: services.php");
            exit();
        }
    }
}

$editId = (int)($_GET['edit'] ?? 0);
$edit = null;
if ($editId > 0) {
    $stmt = $conn->prepare("SELECT * FROM services WHERE id=?");
    $stmt->bind_param("i", $editId);
    $stmt->execute();
    $edit = $stmt->get_result()->fetch_assoc();
}

$services = $conn->query("SELECT * FROM services ORDER BY sort_order ASC, id DESC");
$count = $services->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin - Services</title>
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
    position:fixed;
    padding-top:20px;
}
.sidebar h2{
    color:white;
    text-align:center;
}
.sidebar a{
    display:block;
    color:white;
    padding:12px 20px;
    text-decoration:none;
}
.sidebar a:hover{
    background:#1b263b;
}
.active{
    background:#1b263b;
}
.logout{
    background:#e63946;
}

/* MAIN */
.main{
    margin-left:220px;
    padding:30px;
    width:100%;
}

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.badge{
    background:#1d3557;
    color:white;
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
}

/* CARD */
.card{
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    margin-top:20px;
}

input, textarea{
    width:100%;
    padding:10px;
    margin:6px 0;
    border:1px solid #ccc;
    border-radius:8px;
}

textarea{
    min-height:100px;
}

button{
    padding:10px;
    border:none;
    border-radius:8px;
    cursor:pointer;
}

.btn-save{
    background:#1e90ff;
    color:white;
    width:100%;
}

.error{
    background:#ffe5e8;
    color:#b00020;
    padding:10px;
    border-radius:8px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}
th{
    background:#1d3557;
    color:white;
    padding:10px;
}
td{
    padding:10px;
    border-bottom:1px solid #eee;
}
tr:hover{
    background:#f1f3f5;
}
.actions a{
    padding:6px 10px;
    border-radius:6px;
    color:white;
    text-decoration:none;
    font-size:13px;
}
.edit{
    background:#1e90ff;
}
.delete{
    background:#e63946;
}
img{
    max-width:100px;
    border-radius:6px;
}
</style>
</head>

<body>

<div class="sidebar">
    <h2>Admin</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="appointments.php">Appointments</a>
    <a href="services.php" class="active">Services</a>
    <a href="admin_contact.php">Contact</a>
    <a href="logout.php" class="logout">Logout</a>
</div>

<div class="main">

<div class="top-bar">
    <h2>Services</h2>
    <span class="badge"><?php echo $count; ?> Services</span>
</div>

<div class="card">
<h3><?php echo $edit ? "Edit Service" : "Add Service"; ?></h3>

<?php if(isset($error)){ ?>
<div class="error"><?php echo $error; ?></div>
<?php } ?>

<form method="post">
<input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
<input type="hidden" name="action" value="save">
<input type="hidden" name="id" value="<?php echo (int)($edit['id'] ?? 0); ?>">

<label>Title</label>
<input type="text" name="title" required value="<?php echo $edit['title'] ?? ''; ?>">

<label>Description</label>
<textarea name="description" required><?php echo $edit['description'] ?? ''; ?></textarea>

<label>Image Path</label>
<input type="text" name="image" required value="<?php echo $edit['image'] ?? ''; ?>">

<label>Sort Order</label>
<input type="number" name="sort_order" value="<?php echo $edit['sort_order'] ?? 0; ?>">

<label>
<input type="checkbox" name="is_active" <?php echo ((int)($edit['is_active'] ?? 1) === 1) ? 'checked' : ''; ?>>
Active
</label>

<br><br>
<button class="btn-save">Save Service</button>
</form>
</div>

<div class="card">
<h3>All Services</h3>

<table>
<tr>
<th>ID</th>
<th>Image</th>
<th>Title</th>
<th>Order</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($s = $services->fetch_assoc()){ ?>
<tr>
<td><?php echo $s['id']; ?></td>
<td>
    <?php if(!empty($s['image']) && file_exists("../image/".$s['image'])){ ?>
        <img src="../image/<?php echo $s['image']; ?>">
    <?php } else { ?>
        No Image
    <?php } ?>
</td><td><?php echo $s['title']; ?></td>
<td><?php echo $s['sort_order']; ?></td>
<td><?php echo $s['is_active'] ? 'Active' : 'Inactive'; ?></td>
<td class="actions">
<a class="edit" href="services.php?edit=<?php echo $s['id']; ?>">Edit</a>
<form method="post" style="display:inline;" onsubmit="return confirm('Delete this service?');">
<input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
<input type="hidden" name="action" value="delete">
<input type="hidden" name="id" value="<?php echo $s['id']; ?>">
<button class="delete">Delete</button>
</form>
</td>
</tr>
<?php } ?>

</table>
</div>

</div>

</body>
</html>