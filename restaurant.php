<?php 
include_once('header.php');
include_once('php_sqlite_func.php');

$restaurant = getRestaurant($_GET['id']);
$reviews = getRestaurantReviews($_GET['id']);
?>

<!DOCTYPE html>

<html>
	<head>
		<title><?=$restaurant['nome']?></title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/myStyle.css"> 
		<?php meta_includes(); ?>
	</head>

	<body>
		<header>
		<h1>RestFeed</h1> <br>
		<?php login_header(); ?>
		</header>
		
		

		<h2><?=$restaurant['nome']?></h2>
		<p>in <?=$restaurant['localizacao']?></p><br>
		<p><?=$restaurant['descricao']?></p><br>
		
		<div class="reviews" id="reviews">
		
			<label>New Review:
				<textarea required name="review" id="review"></textarea>
			</label><br>
				<input type="hidden" name="choice" value="INSERTRESTAURANT">
				<input type="hidden" name="restaurantId" value=<?="'$_GET['id']'"?> id="restId">
				<label>Stars:<input type="number" name="quantity" min="1" max="5" id="stars"></label>
			<input class="form_button" type="submit" id="submitbutton" value="SUBMIT">
			<?php
			foreach($reviews as &$review) {
				echo "<p class='line-break'><b>".$review['username']." (".$review['stars']." stars)</b> said:".
					"<p class='line-break'>".$review['comentario']."</p>";
			}
			?>
		</div>
<script>
    $("#submitbutton").click(function(){
        var comentario = $(#review).val();
		var restId = $(#restId).val();
		var stars = $(#stars).val();
     $.ajax({
         url: "insert_review.php", 
         type: 'POST',
         data: {comentario: comentario,
				restId: restId,
				stars: stars},
		 dataType: "json",
         success: function(data){ 
            
         }
      });
    });
</script>
	</body>

</html>
