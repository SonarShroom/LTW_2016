<?php

include('header.php');

function getUserReviews()
{
	//check if logged
	
	if(checklogged())
	{
		//get all comments based on username
		
		$db = new PDO('sqlite:rest.db');
		$stmt = $db->prepare('SELECT restaurante_reviews.stars as stars, restaurante_reviews.comentario as comentario, restaurante.nome as nome ' .
							 'FROM restaurante_reviews INNER JOIN restaurante ' .
							 'ON restaurante.id = restaurante_reviews.restaurante_id AND user_id = ?');
		$stmt->execute(array($_SESSION['login_user']));
		$results = $stmt->fetchAll();
		$html_string = "<ul>";
		
		//go through all the results and build the html from it
		foreach($results as &$review)
		{
			$html_string .= "<h3> " . $review['nome'] . " </h3>" .
							"<h4> " . $review['stars'] . " </h4>";
			if($review['comentario'] != null)
			{
				$html_string .= "<h5> " . $review['comentario'] . "</h5>";
			}
		}
		
		//show a list with all the scores, and comments from each review
		
		$html_string .= "</ul>";
		
		echo $html_string;
	}
	
}

?>