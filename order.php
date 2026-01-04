<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT menu.name, orders.quantity, orders.total_amount FROM orders JOIN menu ON orders.food_id = menu.id WHERE orders.user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Your Orders</title>
</head>
<body>
    <header>
        <h1>Your Orders</h1>
    </header>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='order-item'>
                        <h3>{$row['name']}</h3>
                        <p>Quantity: {$row['quantity']}</p>
                        <p>Total Amount: {$row['total_amount']} TK</p>
                      </div>";
            }
        } else {
            echo "<p>No orders found.</p>";
        }
        ?>
    </div>
</body>
</html>
