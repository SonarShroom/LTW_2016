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
		<form id="review_form" method="POST">
			<label>New Review:
				<textarea required name="comentario" id="review"></textarea>
			</label><br>
				<input type="hidden" name="choice" value="INSERTRESTAURANT">
				<input type="hidden" name="restId" value='<?=$_GET['id']?>' id="restId">
				<label>Stars: <select name="stars">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							</select> </label>
			
		</form>
		<button class="form_button" id="submitbutton">Submit</button>
			<?php
			foreach($reviews as &$review) {
				echo "<p class='line-break'><b>".$review['username']." (".$review['stars']." stars)</b> said:".
					"<p class='line-break'>".$review['comentario']."</p>";
			}
			?>
		</div>
<script>
$('#review_form').submit(false);
   $("#submitbutton").click(function (e) {
        var form = $('#review_form');
     $.ajax({
         url: "insert_review.php",
		type: 'POST',
         data: form.serialize(),
         success: function(resp){
			 data = JSON.parse(resp);
            $('#reviews').append($("<p class='line-break'><b>"+data.username+" ("+data.stars+" stars)</b> said:<p class='line-break'>"+data.comentario+"</p>").hide().fadeIn());
         }
      });
    });
</script>
	</body>

</html>
