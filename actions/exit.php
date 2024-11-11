<?php 
session_start();
unset($_SESSION['uid']);
header("Location: /?page=auth");
die();
?>