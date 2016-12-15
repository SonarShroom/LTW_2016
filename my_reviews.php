<?php 
include_once('header.php');
include_once('php_sqlite_func.php');
?>

<html>
	<head>
		<title>Reviews</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/myStyle.css"> 
		<?php meta_includes(); ?>
	</head>

	<body>
		<header>
			<h1>RestFeed</h1> <br>
			<?php login_header(); ?>
		</header>

		<div class="left_float">
			<h2>My Reviews</h2>
			<?php getUserReviews(); ?>
		</div>
	</body>

</html>