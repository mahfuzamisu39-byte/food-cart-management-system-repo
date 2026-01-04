<?php
session_start();
include 'config.php';

$total = 0;
?>

<h2>Your Cart</h2>

<table border="1" cellpadding="10">
<tr>
<th>Item</th>
<th>Qty</th>
<th>Price</th>
<th>Total</th>
</tr>

<?php foreach($_SESSION['cart'] as $item): 
$sub = $item['qty'] * $item['price'];
$total += $sub;
?>
<tr>
<td><?= $item['name'] ?></td>
<td><?= $item['qty'] ?></td>
<td><?= $item['price'] ?></td>
<td><?= $sub ?></td>
</tr>
<?php endforeach; ?>

<tr>
<td colspan="3"><b>Grand Total</b></td>
<td><b><?= $total ?> BDT</b></td>
</tr>
</table>

<br>
<form action="place_order.php" method="POST">
    <button type="submit">Purchase Order</button>
</form>
