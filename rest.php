<?php
include('header.php');
include('restaurante_data.php');
?>

<html>
	<!-- empty checks if any GET variable is set or not. -->
	<head>
		<title><?php if(!empty($_GET['restId'])) { echo getRestaurantName($_GET['restId']); } else { echo "No restaurant selected!"; } ?></title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/myStyle.css"> 
		<?php meta_includes(); ?>
	</head>
  
	<body>
		<header>
			<h1>RestFeed</h1> <br>
	<?php login_header(); ?>
			
		</header>
<?php if(!empty($_GET['restId'])) { echo getRestaurantName($_GET['restId']); } else { echo "No restaurant selected!"; } ?>
		<div class="left_float">
			Restaurant Reviews
			<?php if(!empty($_GET['restId'])) { printRestaurantReviews($_GET['restId']); } ?>
		</div>
	</body>
	
</html>