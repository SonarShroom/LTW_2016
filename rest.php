<?php
include('header.php');
include('restaurante_data.php');
?>

<html>
	<!-- empty checks if any GET variable is set or not. -->
	<head>
		<title><?php if(!empty($_GET['restName'])) { echo $_GET['restName']; } else { echo "No restaurant selected!"; } ?></title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/myStyle.css"> 
		<?php meta_includes(); ?>
	</head>
  
	<body>
		<header>
			<?php login_header(); ?>
			<h1><?php if(!empty($_GET['restName'])) { echo $_GET['restName']; } else { echo "No restaurant selected!"; }?></h1>
		</header>

		<div class="left_float">
			Restaurant Reviews
			<?php if(!empty($_GET['restName'])) { printRestaurantReviews(); } ?>
		</div>
	</body>
	
</html>