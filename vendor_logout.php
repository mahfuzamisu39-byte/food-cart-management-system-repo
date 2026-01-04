<?php
session_start();

// সব session data remove
session_unset();
session_destroy();

// Vendor registration page এ redirect
header("Location: http://localhost/sadproject1/vendor_register.php");
exit();
?>
