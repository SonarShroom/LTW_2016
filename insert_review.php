<?php
include_once('php_sqlite_func.php');


	insertReviewOnRestaurant($_POST['restId'],$_POST['stars'],$_POST['comentario']);
	echo json_encode(array('username'=>$_SESSION['login_username'], 'stars'=>$_POST['stars'], 'comentario'=>$_POST['comentario']));


?>