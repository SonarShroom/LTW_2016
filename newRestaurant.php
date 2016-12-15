<?php 
include('header.php');




function main_display()
{
	$status = session_status();
	
	switch($status)
	{
		case PHP_SESSION_DISABLED:break;
		case PHP_SESSION_ACTIVE:
			if(checkLogged()) ;
			else { display_register_form();}
			break;
		case PHP_SESSION_NONE:  break;
			default; break;
	}
}

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




	<h2>Add new Restaurant</h2>

	<br><br>
	In this section, you can add a new restaurant. You will be the owner.<br>
	You can check your owned restaurants in the 'My Restaurants' section for edit or delete options.

	<br>
	<br>
	<br>
	<br>

    <form action="php_sqlite_func.php" method="post">
 
  <label>Restaurant Name:
    <input required type="text" name="restName"></input>
  </label><br><br>
  
  <label>Description:
    <textarea required name="restDesc"></textarea>
  </label><br>
  
  <label>Localization:
    <textarea required name="restLoc"></textarea>
  </label><br>
  <input type="hidden" name="choice" value="INSERTRESTAURANT">
  <input class="form_button" type="submit" value="SUBMIT">
</form>
   
	<br>
	
	<footer>
	
       	<br>
	


    </footer>
	
</body>

</html>
