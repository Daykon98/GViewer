<?php

require("includes/config.php");
require("includes/FormularioRegistro.php");
$form = new FormRegistro();
$form->procesa();
?>

<!DOCTYPE html>
<html>
<head>
<?php require_once('includes/comun/bootstrap.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Registro</title>
</head>

<body>

<div id="contenedor">

<?php	

require_once('includes/comun/cabecera.php');

$form->gestiona();


require_once('includes/comun/footer.php');
?>


</div>

</body>
</html>