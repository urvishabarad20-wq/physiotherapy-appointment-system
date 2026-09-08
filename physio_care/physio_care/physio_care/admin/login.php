-<?php
require_once __DIR__ . '/_init.php';

if (is_admin_logged_in()) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['login'])) {
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $stored = (string)$row['password'];

        $ok = false;
        // Support both plain-text (demo) and hashed passwords (upgrade path)
        if (strpos($stored, '$2y$') === 0 || strpos($stored, '$argon2') === 0) {
            $ok = password_verify($password, $stored);
        } else {
            $ok = hash_equals($stored, $password);
        }

        if ($ok) {
            session_regenerate_id(true);
            $_SESSION['admin_username'] = (string)$row['username'];
            header("Location: dashboard.php");
            exit();
        }
    }

    $error = "Invalid Username or Password";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<style>
body{
    font-family: Arial, sans-serif;
    background:#f4f4f4;
}
.login-box{
    width:350px;
    margin:100px auto;
    background:white;
    padding:25px;
    box-shadow:0 0 10px #ccc;
    border-radius:10px;
    text-align:center;
}
input{
    width:100%;
    padding:10px;
    margin:10px 0;
}
button{
    background:#1e90ff;
    color:white;
    border:none;
    padding:10px;
    width:100%;
    cursor:pointer;
}
.error{
    color:red;
}
</style>
</head>
<body>

<div class="login-box">
<h2>Admin Login</h2>

<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

<form method="post">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
</form>

</div>
</body>
</html>
