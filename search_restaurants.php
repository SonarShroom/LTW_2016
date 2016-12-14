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
			<h2>Search</h2>
			<section>
				<ul>
					<?php $foundRestaurants = getSearchRestaurants(); 
						foreach($foundRestaurants as &$restaurant)
						{
							echo "<block><p class='line-break'><b>Name:</b> " . $restaurants['nome'] . 
								 "</p><p class='line-break'><b>Description: </b> " . $restaurants['descricao'] . 
								 "</p><p class='line-break'><b>Nr Reviews: </b> " . $restaurants['num_reviews'] . "</p></block>";
						}
					?>
				</ul>
			</section>
		</div>
	</body>

</html>