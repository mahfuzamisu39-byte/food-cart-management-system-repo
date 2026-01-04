<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        header("Location: register.php");
        exit();
    }

    $food_id = $_POST['food_id'];
    $quantity = $_POST['quantity'];

    $stmt = $conn->prepare("SELECT price FROM menu WHERE id=?");
    $stmt->bind_param("i", $food_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_amount = $row['price'] * $quantity;

    $stmt = $conn->prepare("INSERT INTO orders (user_id, food_id, quantity, total_amount) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $_SESSION['user_id'], $food_id, $quantity, $total_amount);
    if ($stmt->execute()) {
        echo "Order placed successfully! Total amount: " . $total_amount;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(218, 242, 252);
        }

        header {
            background-color: rgb(237, 66, 160);
            color: white;
            text-align: center;
            padding: 1em 0;
            height: 180px;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .category {
            margin-bottom: 40px;
        }

        .category h2 {
            border-bottom: 2px solid #ff6347;
            padding-bottom: 5px;
            margin-bottom: 20px;
            color: #333;
        }

        .food-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }

        .food-item img {
            width: 120px;
            height: 120px;
            object-fit: cover;
        }

        .food-details {
            flex: 1;
            padding: 10px;
        }

        .food-details h3 {
            margin: 0 0 10px;
            color: #333;
        }

        .food-details p {
            margin: 5px 0;
            color: #666;
        }

        .food-details .price {
            font-weight: bold;
            color: #ff6347;
        }

        .order-btn {
            padding: 10px 15px;
            background-color: #ff6347;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }

        .order-btn:hover {
            background-color: #e5533d;
        }
    </style>
</head>

<body>
    <header>
        <h1 style="font-size: 40px; font-family:sans-serif">Cuisine
        </h1>
        <p style="font-size: 20px;">Delicious meals just a click away!</p>

 <h3>
        <p style="text-align:center;">
            <a href="index.php">Home</a> |
            <a href="order.php">See Orders</a> |
            <a href="logout.php">Logout</a> |
        </p>
    </h8>




    </header>

    <div class="container">
        <?php
        $categories = ["Starters", "Main Courses", "Drinks"];
        foreach ($categories as $category) {
            echo "<div class='category'><h2>$category</h2>";
            $stmt = $conn->prepare("SELECT * FROM menu WHERE category=?");
            $stmt->bind_param("s", $category);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "<div class='food-item'>
                        <img src='./images/{$row['image']}' alt='{$row['name']}'>
                        <div class='food-details'>
                            <h3>{$row['name']}</h3>
                            <p class='price'>{$row['price']} TK</p>
                            <form method='post' action=''>
                                <input type='hidden' name='food_id' value='{$row['id']}'>
                                Quantity: <input type='number' name='quantity' required><br>
                                <input type='submit' value='Order Now'>
                            </form>
                        </div>
                      </div>";
            }
            echo "</div>";
        }
        ?>
    </div>
</body>

</html>