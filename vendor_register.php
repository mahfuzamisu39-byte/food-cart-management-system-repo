<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Vendor Registration</title>
<style>
body { font-family: Arial; background:#f4f4f4; }
.form-box {
    width:350px; margin:80px auto; background:#fff;
    padding:20px; border-radius:6px;
}
input, button {
    width:100%; padding:10px; margin:8px 0;
}
button { background:#28a745; color:#fff; border:none; }
</style>
</head>
<body>

<div class="form-box">
<h2>Vendor Registration</h2>

<form method="POST">
<input type="text" name="vendor_name" placeholder="Vendor Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button name="register">Register</button>
</form>

<?php
if (isset($_POST['register'])) {
    $name = $_POST['vendor_name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO vendors (vendor_name,email,password) VALUES (?,?,?)");
    $stmt->bind_param("sss",$name,$email,$pass);
    if($stmt->execute()){
        echo "Registered Successfully!";
    } else {
        echo "Email already exists!";
    }
}
?>
</div>

</body>
</html>
