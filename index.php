<?php require("includes/config.php") ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Graph</title>
	<?php require_once('includes/comun/bootstrap.php'); ?>
	<script src="js/canvasjs.min.js"></script>
	<?php	require_once('includes/viewSelection.php');
			$ID = validateView(isset($_GET['id']) ? $_GET['id'] : null, isset($_GET['view']) ? $_GET['view'] : null);
			
			$handler = getHandlerRoute($ID);
			require_once('viewHandlers/' . $handler . '/' . $handler . '.php'); 

			if (isset($_GET['logout']))
			{
				unset($_SESSION["login"]);
				unset($_SESSION["esAdmin"]);
				unset($_SESSION["nombre"]);
				unset($_SESSION['id']);
				session_destroy();
			}
			?>

</head>
<body>

	<!-- Cabecera-->
	<?php require_once('includes/comun/cabecera.php'); 
				
				printDatasets($ID['id'],$ID['view']);
				printViews($ID['id'],$ID['view']);?>
	


	<div class="container">
		<div id="options" class='row'>
			<?php getSelections(''); ?>
		</div>
		<div class="chartContainer" id="chartContainer">
	</div>
	
	<script src="viewHandlers\<?php echo $handler; ?>\<?php echo $handler;?>.js"></script>
	<script> generateGraph(<?php if (isset($_POST['data'])) echo "'" . $_POST['data'] . "'"; else echo 'null'; ?>)</script>
	
	<div class="container">
		<div class="d-flex justify-content-center">
			<div class="col-2 offset-11">
				
				<button type="button" class="btn btn-success custom-form" onclick="saveView(<?php echo $ID['id'] . ',' . $ID['view'];?>)">
				<?php if (isset($_SESSION['login']) && $_SESSION['login'] == true) echo "Save graph"; else echo "Login to save graphs";?></button>
				
			</div>
		</div>

	</div>
	
	
	<!--button type="button" class="btn btn-secondary" data-toggle="snackbar" data-content="Free fried chicken here! <a href='https://example.org' class='btn btn-info'>Check it out</a>" data-html-allowed="true" data-timeout="0"-->

	<?php require_once('includes/comun/footer.php'); ?>
	
</body>
</html>