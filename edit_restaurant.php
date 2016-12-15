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

	<h2>Edit Restaurant</h2>
	<br>
	<br>
	In this section, you can edit your restaurant.
	<br>
	<br>
	<br>
	<form action="php_sqlite_func.php" method="post">
		<label>Restaurant Name:
			<input required type="text" name="resName"></input>
		</label><br><br>

		<label>Description:
			<textarea required name="resDesc"></textarea>
		</label><br>

		<label>Localization:
			<textarea required name="resLoc"></textarea>
		</label><br>
		<?php  echo '<input type="hidden" name="resId" value="' . $_GET['id'] . '"> ';?>

		<input type="hidden" name="choice" value="UPDATERESTAURANT">
		<input class="form_button" type="submit" value="SUBMIT">
		</form>
	</body>

</html>