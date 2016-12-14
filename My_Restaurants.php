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

    <div class="left_float">
      <h2>My Restaurants</h2>
      <?php $result = getUserReviews();
  $html_string = "<ul>";
  
  //go through all the results and build the html from it
  foreach($result as &$restaurants)
  {
   $html_string .= "<li>";
    
    $html_string .= "<h3> " . $restaurants['nome'] . " </h3><br><br>" .
            "<h4> " . $restaurants['descricao'] . " </h4><br>".
            "<h5> " . $restaurants['num_reviews'] . " </h4><br>";
   
    
    $html_string .= "</li>";
  }
  
  //show a list with all the scores, and comments from each review
  
  $html_string .= "</ul>";
  
  echo $html_string; ?>
    </div>
  </body>

</html>
In this section, you can view your previously added restaurants.<br>
  You can also edit a restaurant or delete it.