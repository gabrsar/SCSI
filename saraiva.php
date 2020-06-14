<?php

require_once("start.php");

/* Empacota usuario com informações do login */
$u = new Usuario();
$u->setLogin("saraiva");
$u->setSenha("aviaras");

/* Gerenciador de acesso ao banco */
$gab = new GAB();


/* Valida login do usuario */
if($gab->validarLogin($u)) {

    /* Obtem resto das informações do usuário*/
    $u = $gab->buscarUsuarioPorLogin($u);

    /* Envia usuario para sessão */

    $_SESSION['usuarioLogado'] = $u;
    $_SESSION['sessaoAceita'] = true;

    $evento = new Evento();
    $evento->setUsuario($u);
    $evento->setEvento("LOGIN");
    $evento->setValor($_SERVER['REMOTE_ADDR']);
    $evento->setIdAlteracao(0);

    $gab = new GAB();
    $gab->cadastrarEvento($evento);
}
	
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $titulo; ?></title>
        <link href="temas/tema1.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/javaScript.js"></script>
		
		<style>
			.x{
				font-size:100px;
			}
		</style>
    </head>
    <body>
    <center>
	
	<form action="scriptSaraiva.php" method="post">
	
		<p class="x"> SERVIÇO <input class="x" type="text" name="id" size="5" /> </p>
		<!--<p> STATUS <input type="text" name="statusFinal" size="5" /> </p> -->
		
		<p> <input class="x" type="submit" value="SALVAR" /> </p>
	</form>
<!--	
	<p>0 "PENDENTE" </p>
	<p>1 "AGENDADO" </p>
	<p>2 "EM EXECUÇÃO" </p>
	<p>3 "CONCLUIDO" </p>
	<p>4 "PROBLEMA" </p>
	<p>5 "OUTROS" </p>
	-->
	</center>
    </body>
</html>