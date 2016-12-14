<?php 
include_once('header.php');
include_once('php_sqlite_func.php');
?>

<!DOCTYPE html>

<html>
  <head>
    <title>My Restaurants</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/myStyle.css"> 
    <?php meta_includes(); ?>
  </head>

  <body>
    <header>
      <h1>RestFeed</h1> <br>
  <?php login_header(); ?>
    </header>

    
      <h2>My Restaurants</h2>
<br><br>
      In this section, you can view your previously added restaurants.<br>
  You can also edit a restaurant or delete it. <br><br><br><br>




      <?php $result = getOwnedRestaurants();

  
  //go through all the results and build the html from it
      $html_string="";

  foreach($result as &$restaurants)
  {

    
  $html_string .= "<div><block><p class='line-break'><b>Name:</b> " . $restaurants['rest_nome'] . 
    "</p><p class='line-break'><b>Description: </b> " . $restaurants['rest_descricao'] . 
    "</p><p class='line-break'><b>Localization: </b> " . $restaurants['rest_localizacao'] . 
    "</p><p class='line-break'><b>Nr Reviews: </b> " . $restaurants['num_reviews'] . 
    "</p><p class='line-break'><a href='edit_restaurant.php?id=" . $restaurants['rest_id'] . "'>EDIT</a></p>
    <p class='line-break'><a href='edit_restaurant.php?id=" . $restaurants['rest_id'] . "'>DELETE</a></p></block></div><br><br>";

  }
  
  //show a list with all the scores, and comments from each review
  

  
  echo $html_string; ?>
   
  </body>

</html>
