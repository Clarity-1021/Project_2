<?php
session_start();
unset($_SESSION['UserName']);
header("Location: ../Login.php");
?>
