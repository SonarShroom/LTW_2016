<?php 
include('header.php');

/*function display_register_form(){
	
	echo
    '<div id="register" title="Register form" style="display:none;"><form id="logNreg" action="log_in.php" method="post" enctype="multipart/form-data">

        <br>Username<br><input type="text" name="log_username">
        <br>Password<br><input type="password" name="log_password">
		<br>Confirm password<br><input type="password" name="log_password_conf">
		<br>Email address<br><input type="email" name="log_email">
		<input type="hidden" name="choice" value="REGISTER">
        <br><input class="form_button" type="submit" value="REGISTER">
    </form></div>';

}*/

function main_display()
{
	$status = session_status();
	
	switch($status)
	{
		case PHP_SESSION_DISABLED:
			/*display_login_form();*/ 
			break;
		case PHP_SESSION_ACTIVE:
			if(!checkLogged())
			{
				/*session_destroy();*/
				display_register_form();
			}
			break;
		case PHP_SESSION_NONE:/*display_login_form();*/  break;
			default; break;
	}
}

?>

<!DOCTYPE html>

<html>

	<header>
		<title> RESTFeed LTW 2016/2017 </title>
		<h1>RESTFeed</h1>
		<meta charset = "utf-8">
		<link rel="stylesheet" href="./css/myStyle.css">
		<script type="text/javascript" src="main.js"></script>
	</header>

	<body>
		
		<a href="list_events.php">Check all public events</a>
		<footer>
			<marquee behavior="scroll" direction="left">
				Welcome to RESTFeed
			</marquee>
		</footer>
		
	</body>

</html>
