<?php

include_once('header.php');

/* User functions */

function getUserReviews()
{
	if(checklogged())
	{
		//get all comments based on username
		
		$db = new PDO('sqlite:rest.db');


		$stmt = $db->prepare("SELECT restaurante_reviews.stars as stars, restaurante_reviews.comentario as comentario, restaurante.nome as nome 
							 FROM restaurante_reviews INNER JOIN restaurante 
							 ON restaurante.id = restaurante_reviews.restaurant_id AND user_id = ?");


		$stmt->execute(array($_SESSION['login_user']));

		$results = $stmt->fetchAll();
		$html_string = "<ul>";
		
		//go through all the results and build the html from it
		foreach($results as &$review)
		{
			$html_string .= "<li>";
			
			$html_string .= "<h3> " . $review['nome'] . " </h3><br><br>" .
							"<h4> " . $review['stars'] . " </h4><br>";
			if($review['comentario'] != null)
			{
				$html_string .= "<h5> " . $review['comentario'] . "</h5>";
			}
			
			$html_string .= "</li>";
		}
		
		//show a list with all the scores, and comments from each review
		
		$html_string .= "</ul>";
		
		echo $html_string;
	}
}

/* Restaurant functions */

function getRestaurants($restName, $sortMode)
{
	$db = new PDO('sqlite:rest.db');
	
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
		$stmt = $db->prepare($sqlQuery);
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
		$stmt = $db->prepare($sqlQuery);
		$stmt->execute();
	}
	
	$results = $stmt->fetchAll();
	return results;
}

function printRestaurantReviews($restId)
{
	$db = new PDO('sqlite:rest.db');
	
	//TODO: SEPARATE SQL FROM PRESENTATION
	$stmt = $db->prepare('SELECT restaurante_reviews.stars as stars, restaurante_reviews.comentario as comentario, user.username as username ' .
						 'FROM restaurante_reviews INNER JOIN restaurante ' .
						 'ON restaurante_reviews.restaurant_id = ?' .
						 'INNER JOIN user ON user.id = restaurante_reviews.user_id');
	$stmt->execute(array($restId));
	$results = $stmt->fetchAll();
	
	$html_string = "<ul>";
	
	foreach($results as &$review)
		{
			$html_string .= "<li>";
			
			$html_string .= "<h3> " . $review['username'] . "'s Review" . " </h3><br>" .
							"<h4> " . $review['stars'] . "/5" . " </h4><br><br>";
			if(!empty($review['comentario']))
			{
				$html_string .= "<h5> " . $review['comentario'] . "</h5>";
			}
			
			$html_string .= "</li>";
		}
	
	$html_string .= "</ul>";
	
	if(strcmp($html_string, "<ul></ul>") == 0)
	{
		$html_string = "This restaurant hasn't been reviewed yet!";
	}
	
	echo $html_string;
}

function printSearchRestaurants()
{
	$db = new PDO('sqlite:rest.db');
	
	$restaurantsList = getRestaurants($_GET['restName'], $_GET['sortMode']);
	
	$html_string = "Restaurant Reviews<br><ul>";
	
	foreach($restaurantsList as &$restaurant)
	{
		$html_string .= "<li>";
		$linkToRest = "http://gnomo.fe.up.pt/~up201607942/rest.php?restId=" . $restaurant['id'];
		
		//TODO: ADD RESTAURANT REVIEW COUNT
		$html_string .= "<a href=" . $linkToRest . ">" . $restaurant['nome'] . "</a>";
		
		$html_string .= "</li>";
	}
	
	$html_string .= "</ul>";
	
	if(strcmp($html_string, "Restaurant Reviews<br><ul></ul>") == 0)
	{
		$html_string = "No restaurants found matching your criteria.";
	}
	
	echo $html_string;
}

function getRestaurantName($restId)
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("SELECT nome FROM restaurante WHERE id = ?");
	$stmt->execute(array($restId));
	$results = $stmt->fetchAll();
	
	return $results[0]['nome'];
}

function insertNewReviewOnRestaurant($restId, $restStars, $restComment)
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("INSERT INTO restaurante_reviews VALUES (?, ?, ?, ?, ?)");
	$stmt->execute(array($restStars, $restComment, $_SESSION['login_user'], $restId, null));
}

function deleteReviewFromRestaurant($revId)
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("DELETE FROM restaurant WHERE id = ?");
	$stmt->execute(array($revId));
}

?>