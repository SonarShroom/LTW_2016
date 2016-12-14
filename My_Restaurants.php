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


<div >

      <?php $result = getOwnedRestaurants();

  
  //go through all the results and build the html from it
  foreach($result as &$restaurants)
  {

    
  $html_string = "<block><p class='line-break'><b>Name:</b> " . $restaurants['nome'] . 
    "</p><p class='line-break'><b>Description: </b> " . $restaurants['descricao'] . 
    "</p><p class='line-break'><b>Nr Reviews: </b> " . $restaurants['num_reviews'] . "</p></block>";


  }
  
  //show a list with all the scores, and comments from each review
  

  
  echo $html_string; ?>
    </div>
  </body>

</html>
