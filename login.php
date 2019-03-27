<?php

require("includes\config.php");
require_once('includes/comun/bootstrap.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Login</title>
</head>

<body>

<div id="content">

<?php

	require_once('includes/comun/cabecera.php');

	
	require("includes/FormularioLogin.php");

	$form = new FormLogin();
	
	$form->gestiona();
	

	require_once('includes/comun/footer.php');
?>


</div>

</body>
</html>