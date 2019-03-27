<?php

require("includes\config.php");
require_once('includes/comun/bootstrap.php');

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Registro</title>
</head>

<body>

<div id="contenedor">

<?php	

require_once('includes/comun/cabecera.php');

	
require("includes/FormularioRegistro.php");

$form = new FormRegistro();

$form->gestiona();


require_once('includes/comun/footer.php');
?>


</div>

</body>
</html>