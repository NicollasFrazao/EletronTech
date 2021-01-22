<?php
	session_start();
	
	include "Conexao.php";
	
	if (isset($_SESSION['EletronTech']['login']))
	{
		$codigo = $_SESSION['EletronTech']['codigo'];
	}
	else
	{
		$codigo = -1;
	}
	
	$query_Busca = "select * from tb_usuario where cd_usuario = '$codigo'";
				
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);
	
	if ($codigo > 0)
	{		
		$_SESSION['EletronTech']['login'] = $linha_Busca['nm_usuario'];
		$logado = $_SESSION['EletronTech']['login'];
	}
	else
	{
		$logado = "";
	}
	
	$mascaraData = "##/##/####";
	$mascaraCPF = "###.###.###-##";
	$mascaraTelefoneFixo = "(##) ####-####";
	$mascaraTelefoneCelular = "(##) #####-####";
	
	$aux = $linha_Busca['cd_datanas'];
	$data = $aux[0] . $aux[1] . $mascaraData[2] . $aux[2] . $aux[3] . $mascaraData[5] . $aux[4] . $aux[5] . $aux[6] . $aux[7];
	
	$aux = $linha_Busca['cd_cpf'];
	$CPF = $aux[0] . $aux[1] . $aux[2] . $mascaraCPF[3] . $aux[3] . $aux[4] . $aux[5] . $mascaraCPF[7] . $aux[6] . $aux[7] . $aux[8] . $mascaraCPF[11] . $aux[9] . $aux[10];
	
	$aux = $linha_Busca['cd_telefone1'];
	$tipo = $linha_Busca['cd_tipo_telefone1'];
	
	if ($tipo != 2)
	{
		$imagemTipo = "imagens/telefone.png";
		$telefone = $mascaraTelefoneFixo[0] . $aux[0] . $aux[1] . $mascaraTelefoneFixo[3] . $mascaraTelefoneFixo[4] . $aux[2] . $aux[3] . $aux[4] . $aux[5] . $mascaraTelefoneFixo[9] . $aux[6] . $aux[7] . $aux[8] . $aux[9];
	}
	else
	{
		$imagemTipo = "imagens/celular.png";
		$telefone = $mascaraTelefoneCelular[0] . $aux[0] . $aux[1] . $mascaraTelefoneCelular[3] . $mascaraTelefoneCelular[4] . $aux[2] . $aux[3] . $aux[4] . $aux[5] . $aux[6] . $mascaraTelefoneCelular[10] . $aux[7] . $aux[8] . $aux[9] . $aux[10];
	}
	
	$aux = $linha_Busca['cd_telefone2'];
	$tipo = $linha_Busca['cd_tipo_telefone2'];
	
	if ($aux != "")
	{
		if ($tipo != 2)
		{
			$imagemTipo2 = "imagens/telefone.png";
			$telefone2 = $mascaraTelefoneFixo[0] . $aux[0] . $aux[1] . $mascaraTelefoneFixo[3] . $mascaraTelefoneFixo[4] . $aux[2] . $aux[3] . $aux[4] . $aux[5] . $mascaraTelefoneFixo[9] . $aux[6] . $aux[7] . $aux[8] . $aux[9];
		}
		else
		{
			$imagemTipo2 = "imagens/celular.png";
			$telefone2 = $mascaraTelefoneCelular[0] . $aux[0] . $aux[1] . $mascaraTelefoneCelular[3] . $mascaraTelefoneCelular[4] . $aux[2] . $aux[3] . $aux[4] . $aux[5] . $aux[6] . $mascaraTelefoneCelular[10] . $aux[7] . $aux[8] . $aux[9] . $aux[10];
		}
	}
	else
	{
		$imagemTipo2 = "imagens/celular.png";
		$telefone2 = "";
	}
	
	$dataCadastro = date("d/m/Y", strtotime($linha_Busca['dt_cadastro']));
	$dataCadastro = explode('/',$dataCadastro);
	
	function TransformaMes($mes)
	{
		switch ($mes)
		{
			case 1:
			{
				$mes = 'Janeiro';
			}
			break;
			
			case 2:
			{
				$mes = 'Fevereiro';
			}
			break;
			
			case 3:
			{
				$mes = 'Março';
			}
			break;
			
			case 4:
			{
				$mes = 'Abril';
			}
			break;
			
			case 5:
			{
				$mes = 'Maio';
			}
			break;
			
			case 6:
			{
				$mes = 'Junho';
			}
			break;
			
			case 7:
			{
				$mes = 'Julho';
			}
			break;
			
			case 8:
			{
				$mes = 'Agosto';
			}
			break;
			
			case 9:
			{
				$mes = 'Setembro';
			}
			break;
			
			case 10:
			{
				$mes = 'Outubro';
			}
			break;
			
			case 11:
			{
				$mes = 'Novembro';
			}
			break;
			
			case 12:
			{
				$mes = 'Dezembro';
			}
			break;
		}
		return $mes;
	}
	
	$diaCadastro = $dataCadastro[0];
	$mesCadastro = $dataCadastro[1];
	$mesCadastro = TransformaMes($mesCadastro);
	$anoCadastro = $dataCadastro[2];
	
	$query_Busca_Evento = "select * from tb_evento where dt_evento >= curdate() and cd_usuario = '$codigo' order by dt_evento";
	$result_Busca_Evento = mysql_query($query_Busca_Evento) or die(mysql_error());
	$linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento);
	$totalLinha_Busca_Evento = mysql_num_rows($result_Busca_Evento);
	
	$datanas = explode('/', $data);
	$diaDatanas = $datanas[0];
	$mesDatanas = TransformaMes($datanas[1]);
	$anoDatanas = $datanas[2];
	
	mysql_close($conexao);
	
	header("Content-type: application/xml; charset=utf-8");
	echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<retorno>
	<foto id="im_perfil"><?php if ($linha_Busca['im_usuario'] == "") {echo 'imagens/usuario.png';} else {echo '../'.$linha_Busca['im_usuario'];} ?></foto>
	<foto id="im_capa"><?php if ($linha_Busca['im_capa'] == "") {echo 'imagens/ae.png';} else {echo '../'.$linha_Busca['im_capa'];} ?></foto>
	<nome id="nm_usuario"><?php echo $logado; ?></nome>
	<data id="cd_datanas">
		<dia id="diaDatanas"><?php echo $diaDatanas; ?></dia>
		<mes id="mesDatanas"><?php echo $mesDatanas; ?></mes>
		<ano id="anoDatanas"><?php echo $anoDatanas; ?></ano>
	</data>
	<data id="dt_cadastro">
		<dia id="diaCadastro"><?php echo $diaCadastro; ?></dia>
		<mes id="mesCadastro"><?php echo $mesCadastro; ?></mes>
		<ano id="anoCadastro"><?php echo $anoCadastro; ?></ano>
	</data>
	<email id="nm_email"><?php echo $linha_Busca['nm_email']; ?></email>
	<telefone id="cd_telefone"><?php echo $telefone; ?></telefone>
	<telefone id="cd_telefone2"><?php echo $telefone2; ?></telefone>
</retorno>