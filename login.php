<?php

require("includes/config.php");
require("includes/FormularioLogin.php");
$form = new FormLogin();
$form->procesa();
?>

<!DOCTYPE html>
<html>
<head>
	<?php require_once('includes/comun/bootstrap.php'); ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Login</title>
</head>

<body>

<div id="content">

<?php

	require_once('includes/comun/cabecera.php');

	$form->gestiona();
	

	require_once('includes/comun/footer.php');
?>


</div>

</body>
</html>