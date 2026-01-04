<?php
session_start();
include 'config.php';
if(!isset($_SESSION['vendor_id'])) header("Location: vendor_login.php");

$vendor_id = $_SESSION['vendor_id'];



$res = $conn->query("SELECT SUM(total_amount) AS total_sales FROM orders");
$data = $res->fetch_assoc();





// ===== Add Menu =====
if(isset($_POST['add_menu'])){
    $menu_name = $_POST['menu_name'];
    $menu_details = $_POST['menu_details'];
    $price = $_POST['price'];

    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $new_name = time().'_'.rand(1000,9999).'.'.$ext;
    $upload_dir = __DIR__ . "/uploads/";

    if(!is_dir($upload_dir)){
        mkdir($upload_dir, 0777, true); // auto-create folder if not exists
    }

    if(move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir.$new_name)){
        $stmt = $conn->prepare("INSERT INTO vendor_menu (vendor_id, menu_name, menu_details, price, image) VALUES (?,?,?,?,?)");
        $stmt->bind_param("issds",$vendor_id,$menu_name,$menu_details,$price,$new_name);
        $stmt->execute();
        echo "Menu added successfully!";
    } else {
        echo "Failed to move uploaded file!";
    }
} else {
    echo "Image upload error: ".$_FILES['image']['error'];
}

}

// ===== Edit Menu =====
if(isset($_POST['edit_menu'])){
    $id = $_POST['menu_id'];
    $menu_name = $_POST['menu_name'];
    $menu_details = $_POST['menu_details'];
    $price = $_POST['price'];

    // Check if new image uploaded
if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $new_name = time().'_'.rand(1000,9999).'.'.$ext;
    
    $upload_dir = __DIR__ . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;

    // Just in case folder doesn't exist
    if(!is_dir($upload_dir)){
        mkdir($upload_dir, 0777, true);
    }

    $destination = $upload_dir . $new_name;

    if(move_uploaded_file($_FILES['image']['tmp_name'], $destination)){
        $stmt = $conn->prepare("INSERT INTO vendor_menu (vendor_id, menu_name, menu_details, price, image) VALUES (?,?,?,?,?)");
        $stmt->bind_param("issds", $vendor_id, $menu_name, $menu_details, $price, $new_name);
        $stmt->execute();
        echo "<p style='color:green;'>Menu added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Failed to move uploaded file! Check folder permissions.</p>";
    }
} else {
    if(isset($_FILES['image']['error'])){
        echo "<p style='color:red;'>Image upload error: ".$_FILES['image']['error']."</p>";
    }
}

}

// ===== Delete Menu =====
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM vendor_menu WHERE id=? AND vendor_id=?");
    $stmt->bind_param("ii",$id,$vendor_id);
    $stmt->execute();
}

// Fetch vendor menus
$stmt = $conn->prepare("SELECT * FROM vendor_menu WHERE vendor_id=?");
$stmt->bind_param("i",$vendor_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
<title>Vendor Dashboard</title>
<style>
body{margin:0;font-family:Arial,sans-serif;background:#f1f3f6;}
.header{background:#212529;color:#fff;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;}
.header h2{margin:0;}
.header a{background:#dc3545;color:#fff;padding:8px 16px;border-radius:4px;text-decoration:none;}
.container{width:90%;margin:30px auto;}
.form-box{background:#fff;padding:25px;border-radius:8px;box-shadow:0 3px 10px rgba(0,0,0,.1);margin-bottom:40px;}
.form-box h3{margin-top:0;}
input,textarea{width:100%;padding:10px;margin:8px 0;border:1px solid #ccc;border-radius:5px;}
textarea{resize:vertical;}
button{background:#28a745;color:#fff;padding:12px;border:none;border-radius:5px;cursor:pointer;font-size:15px;}
button:hover{background:#218838;}
.menu-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:20px;}
.menu-card{background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 3px 10px rgba(0,0,0,.1);transition:.3s;position:relative;}
.menu-card:hover{transform:translateY(-4px);}
.menu-card img{width:100%;height:160px;object-fit:cover;}
.menu-content{padding:15px;}
.menu-content h4{margin:0 0 6px;}
.menu-content p{font-size:14px;color:#555;}
.price{font-weight:bold;color:#28a745;margin-top:6px;}
.actions{display:flex;gap:10px;margin-top:10px;}
.actions a{flex:1;text-align:center;padding:6px;border-radius:4px;font-size:13px;text-decoration:none;color:#fff;cursor:pointer;}
.edit{background:#007bff;}
.delete{background:#dc3545;}
.footer{text-align:center;margin:40px 0;color:#777;}

/* Modal */
.modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);justify-content:center;align-items:center;}
.modal-content{background:#fff;padding:20px;border-radius:6px;width:400px;position:relative;}
.close{position:absolute;top:10px;right:15px;font-size:20px;font-weight:bold;color:#333;cursor:pointer;}
</style>
</head>
<body>

<div class="header">
<h2>Vendor Dashboard</h2>
<a href="vendor_logout.php">Logout</a>
</div>

<div class="container">


<h2>Admin Dashboard</h2>
<h3>Total Sales: <?= $data['total_sales'] ?> BDT</h3>

<div class="form-box">
<h3>Add New Menu</h3>
<form method="POST" enctype="multipart/form-data">
<input type="text" name="menu_name" placeholder="Menu Name" required>
<textarea name="menu_details" placeholder="Menu Details" required></textarea>
<input type="number" step="0.01" name="price" placeholder="Price (৳)" required>
<input type="file" name="image" >
<button name="add_menu">Add Menu</button>
</form>
</div>

<h3>Your Menus</h3>
<div class="menu-grid">
<?php if($result->num_rows>0): ?>
<?php while($row=$result->fetch_assoc()): ?>
<div class="menu-card">
<img src="uploads/<?php echo htmlspecialchars($row['image']); ?>">
<div class="menu-content">
<h4><?php echo htmlspecialchars($row['menu_name']); ?></h4>
<p><?php echo htmlspecialchars($row['menu_details']); ?></p>
<div class="price">৳ <?php echo $row['price']; ?></div>
<div class="actions">
<span class="edit" onclick="openEditModal(<?php echo $row['id']; ?>,'<?php echo addslashes($row['menu_name']); ?>','<?php echo addslashes($row['menu_details']); ?>',<?php echo $row['price']; ?>)">Edit</span>
<a class="delete" href="javascript:confirmDelete(<?php echo $row['id']; ?>)">Delete</a>
</div>
</div>
</div>
<?php endwhile; ?>
<?php else: ?>
<p>No menu added yet.</p>
<?php endif; ?>
</div>

</div>

<div class="footer">&copy; <?php echo date("Y"); ?> Food Ordering System</div>

<!-- Modal HTML -->
<div class="modal" id="editModal">
<div class="modal-content">
<span class="close" onclick="closeModal()">&times;</span>
<h3>Edit Menu</h3>
<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="menu_id" id="edit_id">
<input type="text" name="menu_name" id="edit_name" placeholder="Menu Name" required>
<textarea name="menu_details" id="edit_details" placeholder="Menu Details" required></textarea>
<input type="number" step="0.01" name="price" id="edit_price" placeholder="Price" required>
<input type="file" name="image">
<button name="edit_menu">Save Changes</button>
</form>
</div>
</div>

<script>
function openEditModal(id,name,details,price){
document.getElementById('editModal').style.display='flex';
document.getElementById('edit_id').value=id;
document.getElementById('edit_name').value=name;
document.getElementById('edit_details').value=details;
document.getElementById('edit_price').value=price;
}
function closeModal(){ document.getElementById('editModal').style.display='none'; }
window.onclick = function(event){
if(event.target==document.getElementById('editModal')) closeModal();
}
function confirmDelete(id){
if(confirm('Are you sure you want to delete this menu?')){
window.location.href='vendor_dashboard.php?delete='+id;
}
}
</script>

</body>
</html>
