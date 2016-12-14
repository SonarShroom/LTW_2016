<?php
session_start();
$_SESSION = array();
header('Location: ' . str_replace( "errorMsg","pEM",$_SERVER['HTTP_REFERER']));
header("Refresh:0; url=main.php");
?>