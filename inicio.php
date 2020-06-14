<?php
require_once("start.php");
validaSessao();
?>

<?php


$nomeCookie = "anuncio_" . $usuarioLogado->getLogin();

if(!isset($_COOKIE[$nomeCookie]))
{
	header("Location: ./anuncio.php");
}


        	
        	
        	$gab = new GAB();
?>

<!DOCTYPE html>
<html>
<head>
<?php require_once("head.php"); ?>



</head>
<body>
 

    <?php require_once("topo.php"); ?>
    <?php require_once("menu.php"); ?>

	
	<div class="formulario">

		<p class="titulo">
			Olá <?php echo $usuarioLogado->getNome(); ?>
		</p>

		<p class="texto">Lista dos 5 ultimos serviços que você solicitou:</p>

		<div class="painel resultados">
			<table class="tableshorting resultados" cellpadding="3px" id="tabela" border="1px" cellspacing="2px">
			<thead class="cabecalho">
				<th>ID</th>
				<th>Data</th>
				<th>Idm</th>
				<th><img src="imagens/colocacao.png" alt="C"></th>
				<th><img src="imagens/retirada.png" alt="R"></th>
				<th>A</th>
				<th>V</th>
				<th><img src="imagens/foto.png" alt="F"></th>
				<th><img src="imagens/vistoria.png" alt="Vi"></th>
				<th>Endereço</th>
				<th>Estado Atual</th>
				<th><img src="imagens/imprimir.png"></th>
			</thead>
		</thead>
		<tbody>
			
			
		<?php

		$servicos = $gab->buscarUltimosServicosDeUsuario($usuarioLogado->getId(),5);			
		$i=0;

        $imgColocacao = '<img src="./imagens/colocacao.png" >';
        $imgRetirada = '<img src="./imagens/retirada.png" >';
        $imgVistoria = '👁';

		$pendentes = 0;
		$concluidos = 0;
		$executando = 0;

		foreach ($servicos as $s) {
			$d = $s->getDataCadastro();
	   		$dataStringArray = explode(" - ",$d);

			$dataString = $dataStringArray[0];
            
			$data = date_create($dataString);

            $hoje = date_create();

			$diferenca = date_diff($data,$hoje)->format("%a");

			$urgencia="";
			if($diferenca >= 3 && $s->getStatusFinalTexto() !="CONCLUIDO")
			{
				$urgencia=' urgencia';
			}

			echo('<tr class="dados'.$urgencia.'">');
			echo("<td>");
			echo('<a href="formularioAlterarServico.php?id=');
			echo($s->getId());
			echo('">'.$s->getId().'</a>');
			echo("</td>");
			
			echo("<td>");
			
			$a_m_d = explode("/",$dataString);
			
			
			if(trim($dataString) != "")
			{
			echo('<span class="oculto">'.$dataString.'</span>');
			echo(trim($a_m_d[2]).'/'.$a_m_d[1]);
			}else
			{
				echo("Não Registrado");
			}
			
			echo("</td>");
			echo("<td>");
			echo($s->getImovel()->getIdm());
			echo("</td>");
			echo("<td>");
			echo($s->getColocacao() == 1?$imgColocacao:"");
			echo("</td>");
			echo("<td>");
			echo($s->getRetirada() == 1?$imgRetirada:"");
			echo("</td>");
			echo("<td>");
			echo($s->getAluga() == 1?"A":"");
			echo("</td>");
			echo("<td>");
			echo($s->getVenda() == 1?"V":"");
			echo("</td>");
			echo("<td>");
			echo($s->getFoto() == 1?"F":"");
			echo("</td>");
			echo("<td>");
			echo($s->getVistoria() == 1?$imgVistoria:"");
			echo("</td>");
			echo("<td>");
			echo('<span class="oculto">'.$s->getImovel()->getBairro().'</span>');
			echo($s->getImovel()->toString());
			echo("</td>");
			echo("<td>");


            echo($s->getStatusFinalTexto());

			switch($s->getStatusFinalTexto())
			{
				case "PENDENTE":
					$pendentes++;
					break;
				case "CONCLUIDO":
					$concluidos++;
					break;
				case "EXECUÇÃO":
					$executando++;
					break;
			}

			echo("</td>");
			echo("<td>");
			echo('<input type="checkbox" id="gServicoParaImprimir" name="serivcoParaImprimir[]" value="'.$s->getId().'" >');
			echo("</td>");
			echo("</tr>");
			$i++;
		}


		echo('</tbody><tfoot><th colspan="13">');
	
    	if ($i>1)
		{
			echo ("Foram encontrados " . $i . " serviços. ");
			echo ($executando . " em execução, ");
			echo ($pendentes . " pendente". ($pendentes>1?"s":"") .", ");
			echo ($concluidos . " concluido". ($concluidos>1?"s":"") .".");
		}
		else if($i==1)
		{
			echo ("Foi encontrado 1 serviço.");
		}
		else
		{
			echo ("Não foram encontrados serviços com as caracteristicas fornecidas.");
		}

    	
		?>
		
		</th>


			</tr>
			</tfoot>
	
	</table> 
		</div>

    </div>

</body>
</html>
