<?php
include_once('header.php');
/* User functions */

/* uu = pass
   nn = new username
   nuu = new password
*/
if(isset($_POST['uu']) && (isset($_POST['nn']) || isset($_POST['nuu'])))
{
	updateUserDetails();
}
function updateUserDetails()
{
	$currPassword = md5($_POST['uu']);
	$sqlQuery = "UPDATE user SET ";
	$execArray = array();
	
	if(isset($_POST['nn']))
	{
		$setpart = "name = ? ";
		array_push($execArray, $_POST['nn']);
	}
	
	if(isset($_POST['nuu']))
	{
		if(!empty($setpart))
		{
			$setpart .= ", password = ? ";
		}
		else
		{
			$setpart = "password = ? ";
		}
		array_push($execArray, md5($_POST['nuu']));
	}
	$sqlQuery .= $setpart . "WHERE id = ?";
	
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare($sqlQuery);
	$stmt->execute($execArray);
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
	
	$sqlQuery = 'SELECT * FROM restaurante_count_revs ';
	
	if($restName == null || $restName == '')
	{
		$sqlQuery .= 'WHERE lower(restaurant.name) = ? ';
		switch($sortMode)
		{
			default:
				$sqlQuery .= 'ORDER BY nome';
				break;
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
			default:
				$sqlQuery .= 'ORDER BY nome';
				break;
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
	
	return $stmt->fetchAll();
}

if(isset($_POST['restName']) && isset($_POST['restDesc']) && isset($_POST['restLoc']))
{
	insertRestaurant();
}
function insertRestaurant()
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("INSERT INTO restaurante VALUES (?, ?, ?, ?, ?)");
	$stmt->execute(array(null, $_POST['restName'], $_POST['restDesc'], $_SESSION['login_user'],$_POST['restLoc']));
}

function getSearchRestaurants()
{
	$db = new PDO('sqlite:rest.db');
	
	if(isset($_GET['sortMode']))
	{
		return getRestaurants($_GET['restName'], $_GET['sortMode']);
	}
	else
	{
		return getRestaurants($_GET['restName'], "alphabetical");
	}
	
	/* ===PASSAR PARA FRONT END===
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
	*/
}

function getOwnedRestaurants()
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("SELECT * FROM restaurante_count_revs
						  WHERE owner_id = ?");
	$stmt->execute(array($_SESSION['login_user']));
	
	return $stmt->fetchAll();
}

function getRestaurantName($restId)
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("SELECT nome FROM restaurante WHERE id = ?");
	$stmt->execute(array($restId));
	$results = $stmt->fetchAll();
	
	return $results[0]['nome'];
}

if(isset($_POST['restId']) && isset($_POST['restName']) && isset($_POST['restDesc']))
{
	updateRestaurantInfo();
}
function updateRestaurantInfo()
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("UPDATE restaurante SET nome = ?, descricao = ? WHERE id = ?");
	$stmt->execute(array($restId));
}

/* Review functions */

function getUserReviews()
{
	//get all comments based on username
	
	$db = new PDO('sqlite:rest.db');


	$stmt = $db->prepare("SELECT restaurante_reviews.stars as stars, restaurante_reviews.comentario as comentario, restaurante.nome as nome 
						 FROM restaurante_reviews INNER JOIN restaurante 
						 ON restaurante.id = restaurante_reviews.restaurant_id AND user_id = ?");


	$stmt->execute(array($_SESSION['login_user']));

	return $stmt->fetchAll();
	
	/* ===PASSAR PARA FRONT END===
	//$result = getUserReviews();
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
	*/
}

function insertReviewOnRestaurant($restId, $restStars, $restComment)
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("INSERT INTO restaurante_reviews VALUES (?, ?, ?, ?, ?)");
	$stmt->execute(array($restStars, $restComment, $_SESSION['login_user'], $restId, null));
}

function deleteReviewFromRestaurant($revId)
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("DELETE FROM restaurante_reviews WHERE id = ?");
	$stmt->execute(array($revId));
}

function insertReplyToReview($revId, $reply)
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("INSERT INTO owner_replies VALUES (?, ?, ?, ?)");
	$stmt->execute(array(null, $_SESSION['login_user'], $revId, $reply));
}

function deleteReplyToReview($repId)
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("DELETE FROM owner_replies WHERE id = ?");
	$stmt->execute(array($repId));
}

function getRestaurantReviews($restId)
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare('SELECT restaurante_reviews.stars as stars, restaurante_reviews.comentario as comentario, user.username as username ' .
						 'FROM restaurante_reviews INNER JOIN restaurante ' .
						 'ON restaurante_reviews.restaurant_id = ? ' .
						 'INNER JOIN user ON user.id = restaurante_reviews.user_id');
	$stmt->execute(array($restId));
	return $stmt->fetchAll();
	
	/* ==PASSAR PARA FRONT END===
	//$result = getUserReviews();
	$html_string = "<ul>";
	
	foreach($results as &$review)
		{
			$html_string .= "<li>";
			
			$html_string .= "<h3>" . $review['username'] . "'s Review" . " </h3><br>" .
							"<h4>" . $review['stars'] . "/5" . "</h4>";
			if(!empty($review['comentario']))
			{
				$html_string .= "<br><br><h5> " . $review['comentario'] . "</h5>";
			}
			
			$html_string .= "</li>";
		}
	
	$html_string .= "</ul>";
	
	if(strcmp($html_string, "<ul></ul>") == 0)
	{
		$html_string = "This restaurant hasn't been reviewed yet!";
	}
	
	echo $html_string;
	*/
}

?>