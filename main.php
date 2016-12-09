<?php 
include('header.php');
include('list_events_popular.php');
include('print_events.php');

function display_register_form(){
	
	echo
    '<div id="register" title="Register form" style="display:none;"><form id="logNreg" action="log_in.php" method="post" enctype="multipart/form-data">

        <br>Username<br><input type="text" name="log_username">
        <br>Password<br><input type="password" name="log_password">
		<br>Confirm password<br><input type="password" name="log_password_conf">
		<br>Email address<br><input type="email" name="log_email">
		<input type="hidden" name="choice" value="REGISTER">
        <br><input class="form_button" type="submit" value="REGISTER">
    </form></div>';

}


function main_display()
{
	$status = session_status();
	
	switch($status)
	{

		case PHP_SESSION_DISABLED: break; //display_login_form();
		case PHP_SESSION_ACTIVE:
			if(checkLogged()) ;
			else { display_register_form();} //session_destroy();
			break;
		case PHP_SESSION_NONE:  break; //display_login_form();
			default; break;
	}
} 

?>


<!DOCTYPE html>

<html>

<header>
<title> RESTFeed LTW 2016/2017 </title>
<meta charset = "utf-8">
<link rel="stylesheet" href="./css/myStyle.css">
<?php meta_includes(); ?>
<script type="text/javascript" src="main.js"></script>
</header>

<body>

    <header> 
	<?php login_header(); ?>
	<h1>RestFeed</h1> 
	</header>
	
    <br>
		<?php /*main_display()*/; print_events(popular_events(),true,"Popular Events");?>
    <br>
    <br>
   <a href="list_events.php">Check all public events</a>
	<br>
	
	<footer>
        <marquee behavior="scroll" direction="left">
            Welcome to RESTFeed
        </marquee>

       	<br>Date  
	<div id="date_display"><?php // echo date('l jS \of F Y h:i:s A')?></div>
<!-- echo date('l jS \of F Y h:i:s A'); 
		<!--print_r(getdate()); -->
	<!--echo date('Y-m-d H:i:s'); -->

    </footer>
	
</body>

</html>
