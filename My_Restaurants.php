<?php 
include_once('header.php');
include_once('php_sqlite_func.php');
?>

<!DOCTYPE html>

<html>
<header>
<title> New Restaurant </title>
<meta charset = "utf-8">
<link rel="stylesheet" href="./css/myStyle.css">
<?php meta_includes(); ?>
<script type="text/javascript" src="main.js"></script>
</header>

<body>

    <header> 
	<h1>RestFeed</h1> <br>
  <?php login_header(); ?>
	</header>
	
    <br>



    <br>
    <br>
	My Restaurants

	<br><br>
	In this section, you can view your previously added restaurants.<br>
	You can also edit a restaurant or delete it.

	<br>
	<br>


    

  
	<br>
	
	<footer>
	
       	<br>
	<div id="date_display"><?php // echo date('l jS \of F Y h:i:s A')?></div>


    </footer>
	
</body>

</html>
