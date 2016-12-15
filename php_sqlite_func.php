<?php
include_once('header.php');
/* User functions */

function getUserDetails($userId)
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("SELECT * FROM user WHERE id = ?");
	$stmt->execute(array($userId));
	return $stmt->fetchAll();
}

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

	//header('location: main.php');
	//exit;
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
	
	$sqlQuery = "SELECT * FROM restaurante_count_revs ";
	
	if(!empty($restName))
	{
		$sqlQuery .= "WHERE restaurante_count_revs.rest_nome LIKE '%" . $restName . "%' ";
		switch($sortMode)
		{
			default:
				$sqlQuery .= "ORDER BY rest_nome ";
				break;
			case "alphabetical":
				$sqlQuery .= "ORDER BY rest_nome ";
				break;
			case "alphabeticaldesc":
				$sqlQuery .= "ORDER BY rest_nome DESC ";
				break;
			case "location":
				$sqlQuery .= "ORDER BY rest_localizacao ";
				break;
			case "locationdesc":
				$sqlQuery .= "ORDER BY rest_localizacao DESC ";
				break;
		}
		$stmt = $db->prepare($sqlQuery);
		$stmt->execute();
	}
	else
	{
		switch($sortMode)
		{
			default:
				$sqlQuery .= "ORDER BY rest_nome";
				break;
			case "alphabetical":
				$sqlQuery .= "ORDER BY rest_nome";
				break;
			case "alphabeticaldesc":
				$sqlQuery .= "ORDER BY rest_nome DESC";
				break;
			case "location":
				$sqlQuery .= "ORDER BY rest_localizacao";
				break;
			case "locationdesc":
				$sqlQuery .= "ORDER BY rest_localizacao DESC";
				break;
		}
		$stmt = $db->prepare($sqlQuery);
		$stmt->execute();
	}
	
	return $stmt->fetchAll();
}

if(!isset($_POST['restId']) && isset($_POST['restName']) && isset($_POST['restDesc']) && isset($_POST['restLoc']))
{
	insertRestaurant();
}
function insertRestaurant()
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("INSERT INTO restaurante VALUES (?, ?, ?, ?, ?)");
	$stmt->execute(array(null, $_POST['restName'], $_POST['restDesc'], $_SESSION['login_user'],$_POST['restLoc']));
	header('location: main.php');
	exit;
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
		if(!isset($_GET['restName']))
		{
			return getRestaurants("", "alphabetical");
		}
		return getRestaurants($_GET['restName'], "alphabetical");
	}
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

function getRestaurant($restId)
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("SELECT * FROM restaurante WHERE id = ?");
	$stmt->execute(array($restId));
	$results = $stmt->fetchAll();
	
	return $results[0];
}

if(isset($_POST['resId']) && isset($_POST['resName']) && isset($_POST['resDesc']) && isset($_POST['resLoc']))
{
	updateRestaurantInfo();
}
function updateRestaurantInfo()
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("UPDATE restaurante SET nome = ?, descricao = ? , localizacao = ? WHERE id = ?");
	$stmt->execute(array($_POST['resName'],$_POST['resDesc'],$_POST['resLoc'],$_POST['resId']));

	header('location: main.php');
	exit;
}

/*if(isset($_POST['resId']))
{
	deleteRestaurant();
}*/
function deleteRestaurant($idrest)
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("DELETE FROM restaurante WHERE id = ?");
	$stmt->execute(array($idrest));

	header('location: main.php');
	exit;
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
}

function getReview($id)
{
	
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("SELECT * FROM restaurante_reviews WHERE id=?");
	$stmt->execute(array($id));
	return $stmt->fetchAll();
}


function insertReviewOnRestaurant($restId, $restStars, $restComment)
{
	$db = new PDO('sqlite:rest.db');
	$stmt = $db->prepare("INSERT INTO restaurante_reviews(stars,comentario,user_id,restaurant_id) ".
						"VALUES (?, ?, ?, ?)");
	$stmt->execute(array($restStars, $restComment, $_SESSION['login_user'], $restId));
	return $stmt->fetch();
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
						 'ON restaurante_reviews.restaurant_id = restaurante.id ' .
						 'INNER JOIN user ON user.id = restaurante_reviews.user_id '.
						 'WHERE restaurante.id=?');
	$stmt->execute(array($restId));
	return $stmt->fetchAll();
}

?>