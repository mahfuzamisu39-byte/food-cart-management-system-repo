<?php
session_start();
include 'config.php';

$total = 0;
foreach($_SESSION['cart'] as $item){
    $total += $item['qty'] * $item['price'];
}

// Insert order
$stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$stmt->bind_param("id", $user_id, $total);
$stmt->execute();
$order_id = $stmt->insert_id;

// Insert order items
foreach($_SESSION['cart'] as $menu_id => $item){
    $stmt = $conn->prepare(
        "INSERT INTO order_items (order_id, menu_id, quantity, price)
         VALUES (?,?,?,?)"
    );
    $stmt->bind_param("iiid", $order_id, $menu_id, $item['qty'], $item['price']);
    $stmt->execute();
}

// Clear cart
unset($_SESSION['cart']);

echo "<h2>Order Placed Successfully!</h2>";
echo "<a href='index.php'>Back to Home</a>";
?>
