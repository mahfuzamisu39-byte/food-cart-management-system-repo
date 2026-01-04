<?php
include 'config.php';

/* ================= USERS ================= */
$conn->query("
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB
");

/* ================= VENDORS ================= */
$conn->query("
CREATE TABLE IF NOT EXISTS vendors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vendor_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB
");

/* ================= MENU (GENERAL) ================= */
$conn->query("
CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    image VARCHAR(255) NOT NULL
) ENGINE=InnoDB
");

/* ================= VENDOR MENU ================= */
$conn->query("
CREATE TABLE IF NOT EXISTS vendor_menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vendor_id INT NOT NULL,
    menu_name VARCHAR(100) NOT NULL,
    menu_details TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vendor_id) REFERENCES vendors(id) ON DELETE CASCADE
) ENGINE=InnoDB
");

/* ================= ORDERS ================= */
$conn->query("
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB
");

/* ================= ORDER ITEMS ================= */
$conn->query("
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE CASCADE
) ENGINE=InnoDB
");

/* ================= SAMPLE MENU DATA ================= */
$menu_items = [
    ['Crispy Korean BBQ Chicken Wings', 120, 'Starters', 'Crispy-Korean-BBQ-Chicken-Wings.jpg'],
    ['Fish Finger', 140, 'Starters', 'fish-finger.jpg'],
    ['Nachos', 100, 'Starters', 'Nachos.jpg'],
    ['Potato Wedges', 80, 'Starters', 'potato-wedges.jpg'],
    ['Regular Rice Bowl', 140, 'Main Courses', 'RiceBowl.jpg'],
    ['Set Menu 1', 200, 'Main Courses', 'SetMenu1.jpg'],
    ['Set Menu 2', 280, 'Main Courses', 'SetMenu2.jpg'],
    ['Set Menu 3', 350, 'Main Courses', 'SetMenu3.jpg'],
    ['Chicken Chow Mein', 180, 'Main Courses', 'ChickenChowMein.jpg'],
    ['Beef Chow Mein', 250, 'Main Courses', 'BeefChowMein.webp'],
    ['Chicken Steak', 450, 'Main Courses', 'ChickenSteak.jpg'],
    ['Beef Steak', 550, 'Main Courses', 'BeefSteak.jpg'],
    ['Soft Drinks', 50, 'Drinks', 'SoftDrinks.jpg'],
    ['Mint Lemonade', 100, 'Drinks', 'MintLemonade.jpg'],
    ['Cold Coffee', 180, 'Drinks', 'ColdCoffee.webp'],
    ['Lassi', 140, 'Drinks', 'Lassi.webp'],
    ['Mineral Water', 20, 'Drinks', 'Water.jpg'],
];

$stmt = $conn->prepare("INSERT INTO menu (name, price, category, image) VALUES (?, ?, ?, ?)");

foreach ($menu_items as $item) {
    $stmt->bind_param("sdss", $item[0], $item[1], $item[2], $item[3]);
    $stmt->execute();
}

$stmt->close();

echo "✅ Database setup completed successfully!";
?>
