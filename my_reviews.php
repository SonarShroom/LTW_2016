<?php 
include('header.php');
include('user_data.php');
?>

<html>
  <head>
    <title>My Reviews    (EM OBRAS)</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/myStyle.css"> 
	<?php meta_includes(); ?>
  </head>
  
  <body>
    <header>
	<?php login_header(); ?>
      <h1>My Reviews    (EM OBRAS)</h1>
    </header>
	
	<div class="left_float">
	<h2>  </h2>
	<br>AS MINHAS REVIEWS BLA BLA BLA 
	<?php getUserReviews(); ?>
	</div>
	
	
	
	</body>

</html>