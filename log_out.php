<?php
header("location: main.php");
session_start();
$_SESSION = array();
//header('Location: ' . str_replace( "errorMsg","pEM",$_SERVER['HTTP_REFERER']));
?>