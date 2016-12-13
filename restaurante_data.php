<?php

$db = new PDO('sqlite:rest.db');

function getRestaurants($restName, $sortMode)
{
	/* sort mode = sortMode 
	 can be:
	 alphabetical
	 alphabeticaldesc
	 location
	 locationdesc*/
	
	$sqlQuery = 'SELECT * FROM restaurante ';
	
	if($restName == null || $restName == '')
	{
		$sqlQuery .= 'WHERE lower(restaurant.name) = ? ';
		switch($sortMode)
		{
			case "alphabetical":
				$sqlQuery .= 'ORDER BY nome';
				break;
			case "alphabeticaldesc":
				$sqlQuery .= 'ORDER BY nome DESC';
				break;
			case "location":
				$sqlQuery .= 'ORDER BY localizacao';
				break;
			case "locationdesc":
				$sqlQuery .= 'ORDER BY localizacao DESC';
				break;
		}
		$stmt->execute(array(strtolower($restName)));
	}
	else
	{
		switch($sortMode)
		{
			case "alphabetical":
				$sqlQuery .= 'ORDER BY nome';
				break;
			case "alphabeticaldesc":
				$sqlQuery .= 'ORDER BY nome DESC';
				break;
			case "location":
				$sqlQuery .= 'ORDER BY localizacao';
				break;
			case "locationdesc":
				$sqlQuery .= 'ORDER BY localizacao DESC';
				break;
		}
		$stmt->execute();
	}
	
	$results = $stmt->fetchAll();
	return results;
}

function printRestaurantReviews()
{
	//TODO: SEPARATE SQL FROM PRESENTATION
	$stmt = $db->prepare('SELECT restaurante_reviews.stars as stars, restaurante_reviews.comentario as comentario, restaurante.nome as rest_name, user.username as username' .
						 'FROM restaurante_reviews INNER JOIN restaurante ' .
						 'ON restaurante_reviews.restaurante_id = ? AND restaurante.nome = ?' .
						 'INNER JOIN user ON user.id = restaurante_reviews.user_id');
	$stmt->execute(array($_GET["restId"], $_GET["restNome"]));
	$results = $stmt->fetchAll();
	
	$html_string = "<ul>";
	
	foreach($results as &$review)
		{
			$html_string .= "<li>";
			
			$html_string .= "<h3> " . $review['username'] . "'s Review" . " </h3>" .
							"<h4> " . $review['stars'] . "/5" . " </h4><br>";
			if($review['comentario'] != null)
			{
				$html_string .= "<h5> " . $review['comentario'] . "</h5>";
			}
			
			$html_string .= "</li>";
		}
	
	$html_string .= "</ul>"
	
	if($html_string == "<ul></ul>") //erro
	{
		$html_string = "This restaurant hasn't been reviewed yet!";
	}
	
	echo $html_string;
}

function printSearchRestaurants()
{
	$restaurantsList = getRestaurants($_GET['restName'], $_GET['sortMode']);
	
	$html_string = "<ul>";
	
	foreach($restaurantsList as &$restaurant)
	{
		$html_string .= "<li>";
		$linkToRest = "http://gnomo.fe.up.pt/~up201607942/rest.php?restName=" . $restaurant['nome'] . "&restId=" . $restaurant['id'];
		
		//TODO: ADD RESTAURANT REVIEW COUNT
		$html_string .= "<a href=" . $linkToRest . ">" . $restaurant['nome'] . "</a>";
		
		$html_string .= "</li>";
	}
	
	$html_string = "</ul>";
	
	if($html_string == "<ul></ul>")
	{
		$html_string = "No restaurants found matching your criteria.";
	}
	
	echo $html_string;
}

?>