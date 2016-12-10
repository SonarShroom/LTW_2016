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
	<?php login_header(); ?>
	<h1>RestFeed</h1> 
	</header>
	
    <br>
		<!--<?php ///*main_display()*/; print_events(popular_events(),true,"Popular Events");?>-->
    <br>
    <br>
   <!-- <a href="list_events.php">Check all public events</a> -->
	<br>
	
	<footer>
	
	<!-- brincadeira, um bocado azeite, é pra tirar  :: se calhar inserir aqui as reviews mais recentes, assim nao era preciso login para as ver-->
        <marquee behavior="scroll" direction="left">
            Welcome to RestFeed. 
        </marquee>

       	<br>Date  
	<div id="date_display"><?php // echo date('l jS \of F Y h:i:s A')?></div>


    </footer>
	
</body>

</html>
