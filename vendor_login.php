<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Vendor Login</title>
<style>
body { font-family: Arial; background:#eef2f3; }
.login-box {
    width:320px; margin:100px auto; background:#fff;
    padding:20px; border-radius:6px;
}
input, button { width:100%; padding:10px; margin:8px 0; }
button { background:#007bff; color:#fff; border:none; }
</style>
</head>
<body>

<div class="login-box">
<h2>Vendor Login</h2>

<form method="POST">
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
</form>

<?php
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM vendors WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $res = $stmt->get_result();

    if($v = $res->fetch_assoc()){
        if(password_verify($pass,$v['password'])){
            $_SESSION['vendor_id'] = $v['id'];
            header("Location: vendor_dashboard.php");
        } else echo "Wrong Password!";
    } else echo "Vendor not found!";
}
?>
</div>

</body>
</html>
