<?php
session_start();
include 'config.php';

$menu_id = $_POST['menu_id'];
$qty = $_POST['qty'];

$query = $conn->prepare("SELECT * FROM vendor_menu WHERE id=?");
$query->bind_param("i",$menu_id);
$query->execute();
$item = $query->get_result()->fetch_assoc();

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

if(isset($_SESSION['cart'][$menu_id])){
    $_SESSION['cart'][$menu_id]['qty'] += $qty;
}else{
    $_SESSION['cart'][$menu_id] = [
        'name'=>$item['menu_name'],
        'price'=>$item['price'],
        'qty'=>$qty
    ];
}

header("Location: cart.php");
