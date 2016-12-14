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
  <h2>Edit Restaurant</h2>

  <br><br>
  In this section, you can edit your restaurant.<br>
  
  <br>
  <br>


    <form action="php_sqlite_func.php" method="post">
 
  <label>Restaurant Name:
    <input type="text" name="restName"></input>
  </label><br><br>
  
  <label>Description:
    <textarea name="Restdescription"></textarea>
  </label><br>
  
  <label>Localization:
    <textarea name="Restlocalization"></textarea>
  </label><br>
  <?php  $_GET['id'] ?>
  <input type="hidden" name="choice" value="<?php echo $_GET['id']?>">
  <input type="hidden" name="choice" value="UPDATERESTAURANT">
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