<?php 
include('header.php');




function main_display()
{
	$status = session_status();
	
	switch($status)
	{
		case PHP_SESSION_DISABLED: break;
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
<title> PROJECT LTW 2015/2016 </title>
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
  
	<br>
	
	<footer>
	
	

       	<br>
	<div id="date_display"><?php ?></div>

<br><br>By Ricardo Silva and Mario Esteves
    </footer>
	
</body>

</html>
