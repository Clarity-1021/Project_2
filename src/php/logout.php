<?php
session_start();
unset($_SESSION['UID']);
header("Location: ../Login.php");
?>
