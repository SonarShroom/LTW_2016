<?php

include('header.php');
include('restaurante_data.php');
?>

<html>
	
	<head>
		<title><?php $_GET['restName']?></title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/myStyle.css"> 
		<?php meta_includes(); ?>
	</head>
  
	<body>
		<header>
			<?php login_header(); ?>
			<h1><?php $_GET['restName']?></h1>
		</header>

		<div class="left_float">
			Restaurant Reviews
			<?php getUserReviews(); ?>
		</div>
	</body>
	
</html>