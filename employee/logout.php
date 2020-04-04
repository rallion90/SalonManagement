<?php
session_start();
unset($_SESSION['barber_id']);
session_destroy();
header("Location: login.php");
exit;
?>
