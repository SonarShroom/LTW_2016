<?php

include('header.php');

function getUserReviews()
{
	//check if logged
	
	if(checklogged())
	{
		//get all comments based on username
		
		$db = new PDO('sqlite:rest.db');
		$stmt = $db->prepare('SELECT stars, comentario FROM restaurante_reviews WHERE user_id = ?');
		$stmt->execute(array($_SESSION['login_user']));
		$result = $stmt->fetchAll();
		$html_string = '';
		
		//go through all the results and build the html from it
		foreach($result as &$review)
		{
			$review_row = 
		}
		
		//show a list with all the scores, and comments from each review
		
	}
	
}

?>