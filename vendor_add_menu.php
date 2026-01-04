<?php
session_start();
include 'config.php';

if(isset($_POST['add_menu'])){
    $vendor_id = $_SESSION['vendor_id'];
    $name = $_POST['menu_name'];
    $details = $_POST['menu_details'];
    $price = $_POST['price'];

    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);

    $stmt = $conn->prepare(
        "INSERT INTO vendor_menu (vendor_id,menu_name,menu_details,price,image)
         VALUES (?,?,?,?,?)"
    );
    $stmt->bind_param("issds",$vendor_id,$name,$details,$price,$image);
    $stmt->execute();

    header("Location: vendor_dashboard.php");
}
?>
