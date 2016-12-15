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
	<h2>Edit your profile</h2>
	<br>
	<br>
	In this section, you can edit your user details.
	<br>
	<br>
	<br>
	<form action="php_sqlite_func.php" method="post">
		<?php
		echo '<label>Username:
			  <input required type="text" name="nn" value="' . getUserDetails($_SESSION['login_user'])[0]['username'] . '"></input>
			  </label><br><br>';
		?>
		
		<label>Current password:
			<input required name="uu" type="password"></input>
		</label><br><br>

		<label>New password:
			<input required name="nuu" type="password"></input>
		</label><br>
		<input class="form_button" type="submit" value="SUBMIT">
		</form>
	</body>

</html>