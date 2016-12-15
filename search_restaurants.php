<?php 
include_once('header.php');
include_once('php_sqlite_func.php');
?>

<html>
	<head>
		<title>Restaurants</title>
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
			<h2>Restaurants</h2>

			<br><br>

			<form method=get action="search_restaurants.php"><input type="hidden" name="choice" value="ADVANCEDSEARCH">
			<input class="form_button" type="submit" value="ADVANCED SEARCH"><input type="text" name="restName"></input></form>
			<section>
				<br>Sort by:<br> <select name="log_type">
				<option value="alphabetical">alphabetical</option>
				<option value="alphabeticaldesc">alphabetical desc</option>
				<option value="location">location</option>
				<option value="locationdesc">location desc</option>
				
				</select><br><br>
				<ul>
					<?php $foundRestaurants = getSearchRestaurants();
						$html_string = "";
						foreach($foundRestaurants as &$restaurant)
						{
							$html_string .= '<block><p class="line-break"><b>Name:</b> <a href="restaurant.php?id=' . $restaurant['rest_id'] . '">' . $restaurant['rest_nome'] . '</a>' .
											'</p><p class="line-break"><b>Description: </b> ' . $restaurant['rest_descricao'] . 
											'</p><p class="line-break"><b>Nr Reviews: </b> ' . $restaurant['num_reviews'] . '</p></block>';
						}
						echo $html_string;
						
						if(empty($html_string))
						{
							echo 'No restaurants found.';
						}
					?>
				</ul>
			</section>
		</div>
	</body>

</html>