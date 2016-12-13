<?php
include('header.php');
include('restaurante_data.php');
?>

<html>
	
	<head>
		<title><?php if($_GET['restName'] != null) { echo $_GET['restName']; } else { echo "No restaurant selected!"; } ?></title>
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
			<?php if($_GET['restName'] != null) { printRestaurantReviews(); } ?>
		</div>
	</body>
	
</html>