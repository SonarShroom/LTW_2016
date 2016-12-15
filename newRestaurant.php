<?php 
include('header.php');




function main_display()
{
	$status = session_status();
	
	switch($status)
	{
		case PHP_SESSION_DISABLED:/*display_login_form();*/ break;
		case PHP_SESSION_ACTIVE:
			if(checkLogged()) ;
			else {/*session_destroy();*/ display_register_form();}
			break;
		case PHP_SESSION_NONE:/*display_login_form();*/  break;
			default; break;
	}
}
//insertRestaurant() - restname, descricao, ownerid,
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


<!--<form id="newRestaurant" action="log_in.php" method="post" enctype="multipart/form-data">
	<span>
    username:<input type="text" name="log_username">
	password:<input type="password" name="log_password">
        </span>
		<input type="hidden" name="login_token" value="'.$_SESSION['login_token'].'">
		<input type="hidden" name="choice" value="LOGIN">
			<input class="form_button" type="submit" value="LOGIN">
    </form> -->
    <br>
    <br>
	Add new Restaurant

	<br><br>
	In this section, you can add a new restaurant. You will be the owner.<br>
	You can check your owned restaurants in the 'My Restaurants' section for edit or delete options.

	<br>
	<br>


    <form action="php_sqlite_func.php" method="post">
 
  <label>Restaurant Name:
    <input type="text" name="restName"></input>
  </label><br><br>
  
  <label>Description:
    <textarea name="restDesc"></textarea>
  </label><br>
  
  <label>Localization:
    <textarea name="restLoc"></textarea>
  </label><br>
  <input type="hidden" name="choice" value="INSERTRESTAURANT">
  <input class="form_button" type="submit" value="SUBMIT">
</form>
   <!-- <a href="list_events.php">Check all public events</a> -->
	<br>
	
	<footer>
	
       	<br>
	<div id="date_display"><?php // echo date('l jS \of F Y h:i:s A')?></div>


    </footer>
	
</body>

</html>
