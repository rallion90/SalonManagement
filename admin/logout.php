<?php
session_start();
unset($_SESSION['db_admin_id']);
session_destroy();
header("Location: login.php");
exit;
?>
