<?php
require_once("start.php");
validaSessao();
?>

<?php

$gab = new GAB();

setcookie('anuncio_'.$usuarioLogado->getLogin(),'ok',time()+60*60*24*365,"/");

?>


<!DOCTYPE html>
<html>
<head>
<?php require_once("head.php"); ?>

</head>
<body>
 
 	<div class="anuncio">

		<p class="titulo">
			Seja bem vindo ao novo Sistema de Controle de Serviços Imobiliários (SCSI) para Borsari Imóveis.
		</p>

		<p> Por favor, lembre-se de trocar sua senha regularmente e sempre usar uma senha segura. </p>

	<p>
	<a href="./inicio.php">Li o aviso. Prosseguir para o Sistema</a>
	</p>

	</div>
</body>
</html>
