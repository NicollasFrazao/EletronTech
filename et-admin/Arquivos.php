<?php
	session_start();
	
	include "php/Conexao.php";
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	$codigoUsuario = $_SESSION['EletronTech']['codigo'];

	$aux = mysql_query("select cd_pasta from tb_pasta where nm_caminho = 'Users' and cd_usuario is null and cd_subpasta is null");
	$result = mysql_fetch_array($aux);
	
	if (!isset($_GET['pastaAtual']) && !isset($_GET['codigoPasta']))
	{
		$codigoPasta = $result[0];
		$codigoPastaAnterior = "";
		$PastaAnterior = "";
		$raiz = true;
	}
	else
	{
		if ($_GET['raiz'] == 1 && $_GET['busca'] == 1)
		{
			$raiz = true;
			$codigoPasta = $result[0];
			$codigoPastaAnterior = "";
			$PastaAnterior = "";
		}
		else
		{
			$raiz = false;
			$codigoPasta = mysql_escape_string($_GET['codigoPasta']);
			$codigoPastaAnterior = mysql_escape_string($_GET['codigoPastaAnterior']);
			$PastaAnterior = mysql_escape_string($_GET['pastaAnterior']);
		}
		
		if ($_GET['pastaAtual'] == "Users")
		{
			$raiz = true;
			$codigoPasta = $result[0];
			$codigoPastaAnterior = "";
			$PastaAnterior = "";
		}
		else
		{
			$raiz = false;
			$codigoPasta = mysql_escape_string($_GET['codigoPasta']);
			$codigoPastaAnterior = mysql_escape_string($_GET['codigoPastaAnterior']);
			$PastaAnterior = mysql_escape_string($_GET['pastaAnterior']);
		}
	}
	
	if (isset($_GET['busca']) && isset($_GET['valorBusca']))
	{
		if ($_GET['valorBusca'] != "")
		{
			$busca = 1;
			
			$valorBusca = mysql_escape_string($_GET['valorBusca']);
			
			$aux = mysql_query("select nm_caminho from tb_pasta where cd_pasta = '$codigoPasta'");
	
			$pastaAtual = mysql_fetch_array($aux);
			
			$query_Busca = "select * from tb_pasta 
								where nm_pasta like '%$valorBusca%' and cd_subpasta = '$codigoPasta' order by nm_pasta";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
			
			$query_Busca_Arquivo = "select * from tb_arquivo  where nm_arquivo like '%$valorBusca%' and cd_pasta = '$codigoPasta' order by nm_arquivo";
					
			$result_Busca_Arquivo = mysql_query($query_Busca_Arquivo) or die(mysql_error());
			$linha_Busca_Arquivo = mysql_fetch_assoc($result_Busca_Arquivo);
			$totalLinha_Busca_Arquivo = mysql_num_rows($result_Busca_Arquivo);
			
			$query_Busca_pastaAtual = "select * from tb_pasta where cd_pasta = '$codigoPasta'";
					
			$result_Busca_pastaAtual = mysql_query($query_Busca_pastaAtual) or die(mysql_error());
			$linha_Busca_pastaAtual = mysql_fetch_assoc($result_Busca_pastaAtual);
			$totalLinha_Busca_pastaAtual = mysql_num_rows($result_Busca_pastaAtual);
		}
		else
		{
			$busca = 0;
			
			$aux = mysql_query("select nm_caminho from tb_pasta where cd_pasta = '$codigoPasta'");
	
			$pastaAtual = mysql_fetch_array($aux);

			$query_Busca = "select * from tb_pasta where cd_subpasta = '$codigoPasta' order by nm_pasta";
					
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
			
			$query_Busca_pastaAtual = "select * from tb_pasta where cd_pasta = '$codigoPasta'";
					
			$result_Busca_pastaAtual = mysql_query($query_Busca_pastaAtual) or die(mysql_error());
			$linha_Busca_pastaAtual = mysql_fetch_assoc($result_Busca_pastaAtual);
			$totalLinha_Busca_pastaAtual = mysql_num_rows($result_Busca_pastaAtual);
			
			$query_Busca_Arquivo = "select * from tb_arquivo  where cd_pasta = '$codigoPasta' order by nm_arquivo";
					
			$result_Busca_Arquivo = mysql_query($query_Busca_Arquivo) or die(mysql_error());
			$linha_Busca_Arquivo = mysql_fetch_assoc($result_Busca_Arquivo);
			$totalLinha_Busca_Arquivo = mysql_num_rows($result_Busca_Arquivo);
		}
		
		
	}
	else
	{
		$busca = 0;
		
		$aux = mysql_query("select nm_caminho from tb_pasta where cd_pasta = '$codigoPasta'");
	
		$pastaAtual = mysql_fetch_array($aux);

		$query_Busca = "select * from tb_pasta where cd_subpasta = '$codigoPasta' order by nm_pasta";
				
		$result_Busca = mysql_query($query_Busca) or die(mysql_error());
		$linha_Busca = mysql_fetch_assoc($result_Busca);
		$totalLinha_Busca = mysql_num_rows($result_Busca);
		
		$query_Busca_pastaAtual = "select * from tb_pasta where cd_pasta = '$codigoPasta'";
				
		$result_Busca_pastaAtual = mysql_query($query_Busca_pastaAtual) or die(mysql_error());
		$linha_Busca_pastaAtual = mysql_fetch_assoc($result_Busca_pastaAtual);
		$totalLinha_Busca_pastaAtual = mysql_num_rows($result_Busca_pastaAtual);
		
		$query_Busca_Arquivo = "select * from tb_arquivo  where cd_pasta = '$codigoPasta' order by nm_arquivo";
				
		$result_Busca_Arquivo = mysql_query($query_Busca_Arquivo) or die(mysql_error());
		$linha_Busca_Arquivo = mysql_fetch_assoc($result_Busca_Arquivo);
		$totalLinha_Busca_Arquivo = mysql_num_rows($result_Busca_Arquivo);
	}
	
	$aux = mysql_query("select cd_subpasta from tb_pasta where cd_pasta = '$codigoPasta'");
	
	$sobrePastaAtual = mysql_fetch_array($aux);
	
	$aux = mysql_query("select nm_caminho from tb_pasta where cd_pasta = '$sobrePastaAtual[0]'");
	
	$caminhoSobrePastaAtual = mysql_fetch_array($aux);
	
	function foldersize($path) 
	{
		$total_size = 0;
		$files = scandir($path);

		foreach($files as $t) 
		{
			if (is_dir(rtrim($path, '/') . '/' . $t)) 
			{
				if ($t<>"." && $t<>"..") 
				{
					$size = foldersize(rtrim($path, '/') . '/' . $t);
					$total_size += $size;
				}
			} 
			else 
			{
				$size = filesize(rtrim($path, '/') . '/' . $t);
				$total_size += $size;
			}   
		}
		return $total_size;
	}

	function format_size($size) 
	{
		$mod = 1024;

		$units = explode(' ','B KB MB GB TB PB');
		for ($i = 0; $size > $mod; $i++) 
		{
			$size /= $mod;
		}

		return round($size, 2) . ' ' . $units[$i];
	}

	$tamanho = foldersize("../".$pastaAtual[0]);
	$tamanho = format_size($tamanho);
	
	$nomeUsuario = explode(" ", $_SESSION['EletronTech']['login']);
	
	function consultaItens($cdPasta)
	{
		$totalItens = 0;
		
		$query = mysql_query("select count(*) as quantidade from tb_arquivo where cd_pasta = '$cdPasta'");
	
		$linha = mysql_fetch_assoc($query);
		
		$aux = $linha['quantidade'];
		
		$totalItens = $totalItens + $aux;
		
		$query = mysql_query("select count(*) as quantidade from tb_pasta where cd_subpasta = '$cdPasta';");
	
		$linha = mysql_fetch_assoc($query);
		
		$aux = $linha['quantidade'];
		
		$totalItens = $totalItens + $aux;

		return $totalItens;
	}
	
	
	$url = $_SERVER ['REQUEST_URI'];
	$url = str_replace("/sites", "", $url);
	$url = str_replace("/EletronTech/", "", $url);
	$url = str_replace("et-admin/", "", $url);
	
	echo '<script> parent.txt_url.value = "'.$url.'"; </script>';
?>

<html>
	<head>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="imagens/logo/logo.ico" />
		<title>Arquivos</title>
		<style>
			*
			{
				margin: 0;
				padding:0;
				outline:none;
				font-family: Century Gothic;
			}
			
			
			::-webkit-scrollbar {
				height: 12px;
				width: 12px;
				background: #000;
			}
			
			::-webkit-scrollbar-thumb
			{
				background: white;
				-webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.75);
			}

			::-webkit-scrollbar-corner
			{
				background: #000;
			}
			
			body
			{
				font-family: Century Gothic;
				background-color: transparent;
			}
			
			
			<!--New-->
			
			#tutto
			{
				display: inline-block;
				width:100%;
				height: 100%;
				background-color: red;
			}
			
			#topo
			{
				display: inline-block;
				width: 100%;
				height: 10%;
				background-color: transparent;
				font-size: 26px;
			}
			
			#topo label
			{
				display: inline-block;
				margin-top: 2%;
				margin-left: 5%;
			}
			
			#central
			{
				display: inline-block;
				width: 90%;
				height: 80%;
				margin-left: 5%;
				position: absolute;
				background-color: transparent;
			}
			
			#sinistra
			{
				display: inline-block;
				width: 70%;
				height: 100%;
				background-color: transparent;
			}
			
			#destra
			{
				display: inline-block;
				width:27%;
				height: 100%;
				margin-left:1%;
				background-color: transparent;
				position: absolute;
			}	
			
			#propriedades
			{
				display: inline-block;
				width: 100%;
				height: 70%;
				background-color: #2568d8;
			}
			
			#propriedades table
			{
				display: inline-block;
				width: 90%;
				margin-left: 5%;
				margin-top:5%;
			}
			
			#propriedades label
			{
				display: inline-bloc;
				width: 100%;
				color: white;
			}
			
			#relogioData
			{
				display: inline-block;
				width: 100%;
				height: 25.5%;
				background-color: black;
				margin-top:3%;
				color: white;
			}
			
			
			#pastas
			{
				display: inline-block;
				width: 100%;
				height: 80%;
				background-color: #2b2b2b;
				overflow: auto;
			}
			
			#botoes
			{
				display: inline-block;
				width: 100%;
				height: 9%;
				background-color: black;
				position: relative;
			}
			
			#botoes input
			{
				display: inline-block;
				width:40px;
			}
			
			#barraBusca
			{
				background-color: black;
				height:8%;
			}
			
			#txt_buscaPasta
			{
				display: inline-block;
				width: 95%;
				height:70%;
				margin-top:1%;
				margin-left:2%;
			}
			
			#btn_buscar
			{
				height:5%;
				background-color: transparent;
				position: absolute;
				margin-left: <?php if ($busca == 1) {echo "-5%";} else {echo "-2%";} ?>;
				margin-top:0.8%;
				z-index: 9999;
			}
			
			#myFolder
			{
				width: 120px;
				display: inline-block;
				margin: 10px;
				color: white;
			}
			
			#myfolder input
			{
				width:80px;
			}
			
			#myfolder input:hover
			{
				background-color: gray;
			}
			
			#myfolder input:focus
			{
				background-color: #0e90df;
				outline: none;
			}
			
			#myFolder label
			{
				display:inline-block;
				margin-top:10px;
				color: white;
				width: 150px;
				height: 50px;
				text-align: center;
			}
			
			#opcao
			{
				position: absolute;
				margin-top:1.5%;
				margin-left: -130px;
				font-family: Century Gothic;
				color: white;
			}
			
			#relogioData table
			{
				width: 100%;
				margin-top: 5%;
			}
			
			#relogioData #hora
			{
				display: inline-block;
				width: 100%;
				color: white;
				font-size: 40px;
			}
			
			#relogioData #data
			{
				display: inline-block;
				width: 100%;
				font-size: 20px;
				color: white;
			}
			
			#newFolder
			{
				display: none;
				position: absolute;
				background-color: #1c4fbd;
				width: 40%;
				padding: 50px;
				top: 25%;
				left:25%;
				z-index: 9999;
				font-size: 20px;
				font-family: Century Gothic;
				color: white;
				z-index: 9999;
			}
			
			#newFolder input
			{
				height: 40px;
				width: 100%;
				margin-top:10px;
				font-size: 24px;
			}
			
			#newFolder #btn_popCancel
			{
				background-color: black;
				width: 75%;
				color: white;
				border: 0px;
				font-size: 16px;
			}
			
			#newFolder #btn_popCriar
			{
				background-color: black;
				width: 135%;
				margin-left: -35%;
				color: white;
				border: 0px;
				font-size: 16px;
			}
			
			#es
			{
				display: none;
				position: fixed;
				width: 100%;
				height: 100%;
				background-color: black;
				opacity: 0.98;
				z-index: 9999;
			}
			
			#load
			{
				display: none;
				position: absolute;
				background-color: transparent;
				width: 30%;
				padding: 50px;
				top: 25%;
				left:25%;
				z-index: 9999;
				font-size: 20px;
				font-family: Century Gothic;
				color: white;
				z-index: 9999;
			}
			
			#load img
			{
				display: inline-block;
				height: 20%;
				margin-left: 20%;
			}
			
			#load label
			{
				display: inline-block;
				width: 100%;
			}
			
			#delFolder
			{
				display: none;
				position: absolute;
				background-color: #1c4fbd;
				width: 40%;
				padding: 50px;
				top: 25%;
				left:25%;
				z-index: 9999;
				font-size: 20px;
				font-family: Century Gothic;
				color: white;
				z-index: 9999;
			}
			
			#delFolder input
			{
				height: 40px;
				width: 100%;
				margin-top:10px;
				font-size: 24px;
			}
			
			#delFolder #btn_popNao
			{
				background-color: black;
				color: white;
				border: 0px;
				font-size: 16px;
			}
			
			#delFolder #btn_popSim
			{
				background-color: black;
				color: white;
				border: 0px;
				font-size: 16px;
			}
			
			@media only screen and (min-height:700px) and (max-height: 813px)
			{
				#topo
				{
					display: inline-block;
					width: 100%;
					height: 10%;
					background-color: transparent;
					font-size: 36px;
				}
				
				#relogioData table
				{
					width: 100%;
					margin-top: 5%;
				}
				
				#relogioData #hora
				{
					display: inline-block;
					width: 100%;
					color: white;
					font-size: 60px;
				}
				
				#relogioData #data
				{
					display: inline-block;
					width: 100%;
					font-size: 36px;
					color: white;
				}
				
				#propriedades table
				{
					display: inline-block;
					width: 90%;
					margin-left: 5%;
					margin-top:5%;
				}
				
				#propriedades input
				{
					display: inline-block;
					width: 60%;
				}
				
				
				#propriedades label
				{
					display: inline-block;
					width: 100%;
					color: white;
					font-size: 26px;
				}
				
				#myFolder
				{
					width: 200px;
					display: inline-block;
					margin: 40px;
					color: white;
				}
				
				#myfolder input
				{
					width:180px;
				}
				
				#myFolder label
				{
					display:inline-block;
					margin-top:10px;
					color: white;
					width: 150px;
					height: 50px;
					text-align: center;
					font-size: 20px;
				}
				
				#botoes input
				{
					display: inline-block;
					width:70px;
				}
				
				#opcao
				{
					position: absolute;
					margin-top:1.5%;
					margin-left: -130px;
					font-family: Century Gothic;
					color: white;
					font-size: 26px;
				}
			}
			
			@media only screen and (min-height: 815px)
			{
				#topo
				{
					display: inline-block;
					width: 100%;
					height: 10%;
					background-color: transparent;
					font-size: 36px;
				}
				
				#relogioData table
				{
					width: 100%;
					margin-top: 5%;
				}
				
				#relogioData #hora
				{
					display: inline-block;
					width: 100%;
					color: white;
					font-size: 60px;
				}
				
				#relogioData #data
				{
					display: inline-block;
					width: 100%;
					font-size: 30px;
					color: white;
				}
				
				#propriedades table
				{
					display: inline-block;
					width: 90%;
					margin-left: 5%;
					margin-top:5%;
				}
				
				#propriedades input
				{
					display: inline-block;
					width: 50%;
				}
				
				
				#propriedades label
				{
					display: inline-block;
					width: 100%;
					color: white;
					font-size: 26px;
				}
				
				#myFolder
				{
					width: 200px;
					display: inline-block;
					margin: 40px;
					color: white;
				}
				
				#myfolder input
				{
					width:180px;
				}
				
				#myFolder label
				{
					display:inline-block;
					margin-top:10px;
					color: white;
					width: 150px;
					height: 50px;
					text-align: center;
					font-size: 20px;
				}
				
				#botoes input
				{
					display: inline-block;
					width:70px;
				}
				
				#opcao
				{
					position: absolute;
					margin-top:1.5%;
					margin-left: -130px;
					font-family: Century Gothic;
					color: white;
					font-size: 26px;
				}
			}
			
			@media only screen and (min-height:700px) and (max-height:746px)
			{
				#topo
				{
					display: inline-block;
					width: 100%;
					height: 10%;
					background-color: transparent;
					font-size: 30px;
				}
				
				#relogioData table
				{
					width: 100%;
					margin-top: 5%;
				}
				
				#relogioData #hora
				{
					display: inline-block;
					width: 100%;
					color: white;
					font-size: 52px;
				}
				
				#relogioData #data
				{
					display: inline-block;
					width: 100%;
					font-size: 26px;
					color: white;
				}
				
				#propriedades table
				{
					display: inline-block;
					width: 90%;
					margin-left: 5%;
					margin-top:5%;
				}
				
				#propriedades input
				{
					display: inline-block;
					width: 60%;
				}
				
				
				#propriedades label
				{
					display: inline-bloc;
					width: 100%;
					color: white;
					font-size: 20px;
				}
				
				#myFolder
				{
					width: 165px;
					display: inline-block;
					margin: 15px;
					color: white;
				}
				
				#myfolder input
				{
					width:100px;
				}
				
				#myFolder label
				{
					display:inline-block;
					margin-top:10px;
					color: white;
					width: 150px;
					height: 50px;
					text-align: center;
					font-size: 20px;
				}
				
				#botoes input
				{
					display: inline-block;
					width:50px;
				}
				
				#opcao
				{
					position: absolute;
					margin-top:1.5%;
					margin-left: -130px;
					font-family: Century Gothic;
					color: white;
					font-size: 22px;
				}
			}
			
			@media only screen and (max-height:480px)
			{
				#topo
				{
					display: inline-block;
					width: 100%;
					height: 10%;
					background-color: transparent;
					font-size: 16px;
				}
				
				#relogioData table
				{
					width: 100%;
					margin-top: 5%;
				}
				
				#relogioData #hora
				{
					display: inline-block;
					width: 100%;
					color: white;
					font-size: 30px;
				}
				
				#relogioData #data
				{
					display: inline-block;
					width: 100%;
					font-size: 18px;
					color: white;
				}
				
				#propriedades table
				{
					display: inline-block;
					width: 90%;
					margin-left: 5%;
					margin-top:5%;
				}
				
				#propriedades input
				{
					display: inline-block;
					width: 80%;
				}
				
				
				#propriedades label
				{
					display: inline-bloc;
					width: 100%;
					color: white;
					font-size: 12px;
				}
				
				#myFolder
				{
					width: 80px;
					display: inline-block;
					margin: 5px;
					color: white;
				}
				
				#myfolder input
				{
					width:60px;
				}
				
				#myFolder label
				{
					display:inline-block;
					margin-top:10px;
					color: white;
					width: 150px;
					height: 50px;
					text-align: center;
					font-size: 14px;
				}
				
				#botoes input
				{
					display: inline-block;
					width:30px;
				}
				
				#opcao
				{
					position: absolute;
					margin-top:1.5%;
					margin-left: -130px;
					font-family: Century Gothic;
					color: white;
					font-size: 14px;
				}
			}
			
			
			
			#btn_limpaBusca
			{
				display: <?php if ($busca == 1) {echo "inline-block";} else {echo "none";} ?>;
				z-index:9997;
				background-color: transparent;
				position: absolute;
				margin-left: -3%;
				margin-top:0.8%;
				height:5%;
			}
		</style>
	</head>
	<body onload="timer(); txt_excluirPasta.value = ''; uploader.value = ''; txt_raiz.value = <?php if ($raiz == true) {echo 1;} else {echo 0;}; ?>; if (txt_codigoPastaAnterior.value != '' && txt_raiz.value == 1) {location.reload();}">
		<div id="tutto">
			<div id="topo">
				<label>Arquivos</label>
			</div>
			<div id="central">
				<div id="sinistra">
					<div id="barraBusca">
						<input id="txt_buscaPasta" name="valorBusca" type="text">
						<input id="btn_buscar" name="busca" type="image" src="imagens/pesquisar.png">
						<input id="btn_limpaBusca" type="image" src="imagens/limpar.png" onclick="var frm = document.querySelector('#Frm_Dados'); if (txt_pastaAtual.value != '') {frm.submit();}">
					</div>
					
					<div id="pastas" onclick="if (aux == 0) {txt_excluirPasta.value = ''; txt_codigoExcluirPasta.value = ''; txt_tipo.value = '';}" >
						<?php
							if ($raiz == false && $busca == 0)
							{
						?>
								<div id="myFolder">
									<table>
										<tr>
											<td align="center">
												<input type="image" src="imagens/voltar.png" 
												ondblclick="aux = '<?php echo $sobrePastaAtual[0]; ?>'; 
												txt_codigoPastaAnterior.value = txt_codigoPastaAtual.value; 
												txt_codigoPastaAtual.value = aux; aux = '<?php echo $caminhoSobrePastaAtual[0]; ?>'; 
												txt_pastaAnterior.value = txt_pastaAtual.value; 
												txt_pastaAtual.value = aux; 
												txt_busca.value = ''; 
												txt_valorBusca.value = ''; 
												var frm = document.querySelector('#Frm_Dados'); 
												if (txt_pastaAtual.value != '') 
												{
													frm.submit();
												}">
											</td>
										</tr>
										<tr>
											<td align="center">
												<label>Voltar</label>
											</td>
										</tr>
									</table>
								</div>
						<?php
							}
						?>
						
						<?php
							do
							{
						?>
							<div id="myFolder" <?php if ($linha_Busca['nm_pasta'] == "") {echo "style='display: none;'";} ?>>
								<table>
									<tr>
										<td align="center">
											<input type="image" title="<?php if ($linha_Busca['nm_pasta'] != "") {echo $linha_Busca['nm_pasta']." - Clique duas vezes para abrir.";} ?>" src="<?php echo "imagens/pasta.png"; ?>"
											
											ondblclick="
											txt_pastaAnterior.value = txt_pastaAtual.value;
											txt_pastaAtual.value = '<?php echo $linha_Busca['nm_caminho']; ?>'; 
											txt_codigoPastaAnterior.value = txt_codigoPastaAtual.value; 
											txt_codigoPastaAtual.value = '<?php echo $linha_Busca['cd_pasta']; ?>'; 
											var frm = document.querySelector('#Frm_Dados'); 
											if (txt_pastaAtual.value != '') 
											{
												frm.submit();
											}" 
											
											onfocus="
											lbl_criada.innerHTML = '<?php echo "Criada em ".date("d/m/Y", strtotime($linha_Busca['dt_data_criacao'])); ?>';
											lbl_tamanho.innerHTML = '<?php $tamanhoFocus = foldersize("../".$pastaAtual[0]."/".$linha_Busca['nm_pasta']); $tamanhoFocus = format_size($tamanhoFocus); echo $tamanhoFocus; ?>'; 
											lbl_itens.innerHTML = '<?php echo consultaItens($linha_Busca['cd_pasta']) . " Item(s)"; ?>'; 
											lbl_nomePastaArquivo.innerHTML = '<?php echo $linha_Busca['nm_pasta']; ?>'; 
											aux = 1; txt_excluirPasta.value = '<?php echo $linha_Busca['nm_pasta']; ?>'; 
											txt_codigoExcluirPasta.value = '<?php echo $linha_Busca['cd_pasta']; ?>';
											txt_download.value = '<?php if ($tamanhoFocus != "0 B") {echo "1";} else {echo "0";} ?>';
											txt_tipo.value = 1;" 
											
											onblur="
											lbl_tamanho.innerHTML = '<?php echo $tamanho; ?>'; 
											lbl_itens.innerHTML = '<?php echo consultaItens($codigoPasta) . " Item(s)"; ?>'; 
											lbl_nomePastaArquivo.innerHTML = '<?php echo $linha_Busca_pastaAtual['nm_pasta']; ?>';
											lbl_criada.innerHTML = '<?php echo "Criada em ".date("d/m/Y", strtotime($linha_Busca_pastaAtual['dt_data_criacao'])); ?>';
											aux = 0;
											">
											
 <!--btn_excluirPasta.style.display = 'inline-block';" onblur="txt_excluirPasta.value = ''; txt_codigoExcluirPasta.value = ''; btn_excluirPasta.style.display = 'none'-->											
										</td>
									</tr>
									<tr>
										<td align="center">
											<label><?php if ($linha_Busca['nm_pasta'] != "") {echo $linha_Busca['nm_pasta'];} ?></label>
										</td>
									</tr>
								</table>
							</div>
						<?php
							}
							while ($linha_Busca = mysql_fetch_assoc($result_Busca));							
						?>
						
						<?php
							do
							{
						?>
							<div id="myFolder" <?php if ($linha_Busca_Arquivo['nm_arquivo'] == "") {echo "style='display: none;'";} ?>>
								<table>
									<tr>
										<td align="center">
											<input type="image" title="<?php if ($linha_Busca_Arquivo['nm_arquivo'] != "") {echo $linha_Busca_Arquivo['nm_arquivo']." - Clique duas vezes para abrir.";} ?>" src="<?php if ($linha_Busca_Arquivo['nm_arquivo'] != "") {echo "imagens/extensoes/".$linha_Busca_Arquivo['nm_tipo'].".png";} ?>" 
											
											ondblclick="
											window.open('<?php if ($linha_Busca_Arquivo['nm_tipo'] != "doc" && $linha_Busca_Arquivo['nm_tipo'] != "docx" && $linha_Busca_Arquivo['nm_tipo'] != "xlsx" && $linha_Busca_Arquivo['nm_tipo'] != "xls" && $linha_Busca_Arquivo['nm_tipo'] != "ppt" && $linha_Busca_Arquivo['nm_tipo'] != "pptx") {echo "../".$linha_Busca_Arquivo['nm_caminho']."'";} else {echo "php/ExibirDoc.php?arquivo=' + txt_pastaAtual.value + '/' + txt_excluirPasta.value";}?>, '_blank');" 
											
											onfocus="
											cp.innerHTML = 'Tipo:';
											lbl_itens.innerHTML = '<?php echo $linha_Busca_Arquivo['nm_tipo']; ?>';
											lbl_tamanho.innerHTML = '<?php $tamanhoFocus = filesize("../".$pastaAtual[0]."/".$linha_Busca_Arquivo['nm_arquivo']); $tamanhoFocus = format_size($tamanhoFocus); echo $tamanhoFocus; ?>';
											img_icone.src = '<?php if ($linha_Busca_Arquivo['nm_arquivo'] != "") {echo "imagens/extensoes/".$linha_Busca_Arquivo['nm_tipo'].".png";} ?>';
											lbl_nomePastaArquivo.innerHTML = '<?php echo $linha_Busca_Arquivo['nm_arquivo']; ?>';
											lbl_criada.innerHTML = '<?php echo "Criada em ".date("d/m/Y", strtotime($linha_Busca_Arquivo['dt_data_criacao'])); ?>';
											aux = 1; 
											txt_excluirPasta.value = '<?php echo $linha_Busca_Arquivo['nm_arquivo']; ?>'; 
											txt_codigoExcluirPasta.value = '<?php echo $linha_Busca_Arquivo['cd_arquivo']; ?>'; 
											txt_download.value = 1;
											txt_tipo.value = 2;" 
											
											onblur="
											img_icone.src = 'imagens/pasta.png';
											lbl_tamanho.innerHTML = '<?php echo $tamanho; ?>';
											cp.innerHTML = 'Contém:';
											lbl_itens.innerHTML = '<?php echo consultaItens($codigoPasta) . " Item(s)"; ?>';
											lbl_nomePastaArquivo.innerHTML = '<?php echo $linha_Busca_pastaAtual['nm_pasta']; ?>';
											lbl_criada.innerHTML = '<?php echo "Criada em ".date("d/m/Y", strtotime($linha_Busca_pastaAtual['dt_data_criacao'])); ?>';
											aux = 0;
											">
											
 <!--ondblclick="txt_pastaAnterior.value = txt_pastaAtual.value; txt_pastaAtual.value = '<?php echo $linha_Busca_Arquivo['nm_caminho']; ?>'; txt_codigoPastaAnterior.value = txt_codigoPastaAtual.value; txt_codigoPastaAtual.value = '<?php echo $linha_Busca_Arquivo['cd_pasta']; ?>'; var frm = document.querySelector('#Frm_Dados'); if (txt_pastaAtual.value != '') {frm.submit();}" onfocus="aux = 1; txt_excluirPasta.value = '<?php echo $linha_Busca_Arquivo['nm_pasta']; ?>'; txt_codigoExcluirPasta.value = '<?php echo $linha_Busca_Arquivo['cd_pasta']; ?>';" onblur="aux = 0;"-->											
										</td>
									</tr>
									<tr>
										<td align="center">
											<label><?php if ($linha_Busca_Arquivo['nm_arquivo'] != "") {echo $linha_Busca_Arquivo['nm_arquivo'];} else {echo "Sem Arquivos";} ?></label>
										</td>
									</tr>
								</table>
							</div>
						<?php
							}
							while ($linha_Busca_Arquivo = mysql_fetch_assoc($result_Busca_Arquivo));							
						?>	
						
					</div>
					<div id="botoes" align="right">
							<label id="opcao"></label>
							<input id="btn_upload" type="image" src="imagens/upload.png" onclick="uploader.click();">
							<input id="btn_download" type="image" src="imagens/download.png">
							<input id="btn_novaPasta" type="image" src="imagens/novaPasta.png">
							<input id="btn_excluirPasta" type="image" src="imagens/excluirPasta.png" onclick="if (txt_excluirPasta.value != '') {dell()}">
							
					</div>
					
				</div>
				<div id="destra">
					<div id="propriedades">
						<table>
							<tr>
								<td colspan="2" align="center">
									<label id="lbl_nomePastaArquivo"><?php echo $linha_Busca_pastaAtual['nm_pasta']; ?></label>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<input type="image" id="img_icone" src="imagens/pasta.png" Disabled>
								</td>
							</tr>
							<tr>
								<td align="left">
									<label id="cp">Contém:</label>
								</td>
								<td align="left">
									<label id="lbl_itens"><?php echo $totalLinha_Busca + $totalLinha_Busca_Arquivo; ?> item(s)</label>
								</td>
							</tr>
							<tr>
								<td align="left">
									<label  id="tm">Tamanho:</label>
								</td>
								<td align="left">
									<label id="lbl_tamanho"><?php echo $tamanho; ?></label>
								</td>
							</tr>
							<tr>
								
								<td colspan="2" align="center">
								<br>
									<label id="lbl_criada">Criada em <?php echo date("d/m/Y", strtotime($linha_Busca_pastaAtual['dt_data_criacao'])); ?></label>
								</td>
							</tr>
						</table>
					</div>
					<div id="relogioData">
						<table>
							<tr>
								<td align="center">
									<label id="hora"></label>
								</td>
							</tr>
							<tr>
								<td align="center">
									<label id="data"></label>	
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div id="es">
		
			</div>
		</div>
		
		
		<!--
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		-->
		<form method="GET" id="Frm_Dados" enctype="multipart/form-data">
				<input class="oculto" id="txt_pastaAtual" name="pastaAtual" type="hidden" value="<?php echo $pastaAtual[0];?>">
										
				<input class="oculto" id="txt_codigoPastaAtual" name="codigoPasta" type="hidden" value="<?php echo $codigoPasta;?>">

				<input class="oculto" id="txt_codigoPastaAnterior" name="codigoPastaAnterior" type="hidden" value="<?php echo $codigoPastaAnterior;?>">
				
				<input class="oculto" id="txt_pastaAnterior" name="pastaAnterior" type="hidden" value="<?php echo $PastaAnterior;?>">
				
				<input class="oculto" id="txt_novaPasta" type="hidden">
				
				<input class="oculto" id="txt_excluirPasta" type="hidden">
				
				<input class="oculto" id="txt_codigoExcluirPasta" type="hidden">
				
				<input class="oculto" id="txt_tipo" type="hidden">
				
				<input class="oculto" id="txt_raiz" name="raiz" type="hidden">
				
				<input class="oculto" id="txt_download" type="hidden">
				
				<input class="oculto" id="txt_valorBusca" name="valorBusca" type="hidden">
				
				<input class="oculto" id="txt_busca" name="busca" type="hidden">
				
				<input class="oculto" id="txt_url" type="hidden" value="<?php echo $url; ?>">
				
				<!-- UPLOAD AQUI-->
				<input class="oculto" type="file" id="uploader" name="arquivo" value="" style="display: none;">
		</form>	
		<table id="newFolder">
			<tr>
				<td colspan="2" align="center">
					<label>Escolha um nome para sua nova pasta</label>
				</td>
			<tr>
			<tr>
				<td colspan="2">
					<input id="txt_nomeNovaPasta" type="text">
				</td>
			</tr>
			<tr>
				<td>
					<input id="btn_popCancel" type="button" value="Cancelar">
				</td>
				<td>
					<input id="btn_popCriar" type="button" value="Criar" onclick="txt_novaPasta.value = txt_nomeNovaPasta.value; if (txt_novaPasta.value != '') {newFolder.style.display='none'; loadlabel.innerHTML='Gerando Diretório'; load.style.display='inline-block'; txt_nomeNovaPasta.value = '' ; window.location.href = 'php/CriarPasta.php?novaPasta=' + txt_novaPasta.value + '&pastaAtual=<?php echo $pastaAtual[0];?>&codigoPasta=<?php echo $codigoPasta;?>';}">
				</td>
			</tr>
		</table>
		
		<table id="delFolder">
			<tr>
				<td colspan="2" align="center">
					<label>Tem certeza que deseja excluir?</label>
				</td>
			<tr>
			<tr>
				<td>
					<input id="btn_popNao" type="button" value="Não" onclick="offDell()">
				</td>
				<td>
					<input id="btn_popSim" type="button" value="Sim" onclick="if (txt_excluirPasta.value != '') { delFolder.style.display='none'; loadlabel.innerHTML='Excluindo'; load.style.display='inline-block'; window.location.href = 'php/ExcluirPasta.php?tipo=' + txt_tipo.value + '&excluirPasta=' + txt_excluirPasta.value + '&pastaAtual=<?php echo $pastaAtual[0];?>&codigoExcluirPasta=' + txt_codigoExcluirPasta.value;}">
				</td>
			</tr>
		</table>
		<div id="load">
			<img src="imagens/load.gif"></br>
			<label align="center" id="loadlabel">Gerando Diretório</label>
		</div>
	</body>
	<script>
		var aux = 0;
		
		btn_download.onmouseover = function()
		{
			opcao.style.color="#3ed60f";
			opcao.innerHTML="download";
		}
		
		btn_novaPasta.onmouseover = function()
		{
			opcao.style.color="#269bf2";
			opcao.innerHTML="criar pasta";
		}
		
		btn_excluirPasta.onmouseover = function()
		{
			opcao.style.color="#f22626";
			opcao.innerHTML="excluir";
		}
		
		btn_upload.onmouseover = function()
		{
			opcao.style.color="yellow";
			opcao.innerHTML="upload";
		}
		
		btn_download.onmouseout = function()
		{
			opcao.innerHTML="";
		}
		
		btn_novaPasta.onmouseout = function()
		{
			opcao.innerHTML="";
		}
		
		btn_excluirPasta.onmouseout = function()
		{
			opcao.innerHTML="";
		}
		
		btn_upload.onmouseout = function()
		{
			opcao.innerHTML="";
		}
		
		btn_novaPasta.onclick = function()
		{
			//parent.fundao3();
			topo.style.display="none";
			central.style.display="none";
			es.style.display="inline-block";
			newFolder.style.display="inline-block";
		}
		
		btn_popCancel.onclick = function()
		{
			//parent.centro.style.backgroundColor="#eeeeee";
			topo.style.display="inline-block";
			central.style.display="inline-block";
			es.style.display="none";
			newFolder.style.display="none";
			txt_nomeNovaPasta.value = "";
		}
		
		function timer()
		{
			dat = new Date();
            dia = dat.getDate();
			mes = dat.getMonth()+1;
			ano = dat.getFullYear();
			horaN = dat.getHours();
			minuto = dat.getMinutes();
			
			//hora
			if(horaN < 10)
			{
				horaS = "0"+horaN;
			}
			else
			{
				horaS = horaN;
			}
			
			//minuto
			if(minuto < 10)
			{
				minutoS = "0"+minuto;
			}
			else
			{
				minutoS = minuto;
			}
			
			horario = horaS+":"+minutoS;
			
			if(mes < 10)
			{
				dataHoje = dia+"/0"+mes+"/"+ano;
			}
			else
			{
				dataHoje = dia+"/"+mes+"/"+ano;
			}
			data.innerHTML = dataHoje;
			hora.innerHTML = horario;
			setTimeout("timer()",1000);
		}
		
		function dell()
		{
			//parent.centro.style.backgroundColor="black";
			topo.style.display="none";
			central.style.display="none";
			es.style.display="inline-block";
			delFolder.style.display="inline-block";
		}	
		
		function offDell()
		{
			//parent.centro.style.backgroundColor="#eeeeee";
			topo.style.display="inline-block";
			central.style.display="inline-block";
			es.style.display="none";
			delFolder.style.display="none";
		}
		
		btn_download.onclick = function()
		{
			if (txt_excluirPasta.value != "" && txt_download.value != 0)
			{
				window.open("php/Download.php?arquivo=" + txt_pastaAtual.value + "/" + txt_excluirPasta.value + "&tipo=" + txt_tipo.value + "&nomePasta=" + txt_excluirPasta.value + "&pastaAtual=" + txt_pastaAtual.value , "_self"); 
			}
		}
		
		uploader.onchange = function()
		{
			if (uploader.value != "")
			{
				txt_url.name = "url";
				var frm = document.querySelector("#Frm_Dados");
				frm.action = "php/Upload.php";
				frm.method = "POST";
				frm.submit();
			}
		}
		
		btn_buscar.onclick = function()
		{
			txt_valorBusca.value = txt_buscaPasta.value;
			txt_busca.value = 1;
			
			var frm = document.querySelector("#Frm_Dados");
			frm.submit();
		}
		
		txt_nomeNovaPasta.onkeypress = function(e,args)
		{
			if (document.all) // caso seja IE
			{
				var evt=event.keyCode;
			}			
			else // do contrário deve ser Mozilla ou Google
			{
				var evt = e.charCode;
			}
			
			var nega_chars = '/\\|<>*:"';      // criando a lista de teclas nagadas
			var chr= String.fromCharCode(evt);      // pegando a tecla digitada
			
			if (nega_chars.indexOf(chr) == -1 ) // se a tecla estiver na lista de permissão permite-a
			{
				return true;
			}
			
			// para permitir teclas como <BACKSPACE> adicionamos uma permissão para
			// códigos de tecla menores que 09 por exemplo 
			
			if (nega_chars.indexOf(chr) == -1 || evt < 9)
			{
				return true;
			}
			
			return false;   // do contrário nega
		}
		
		txt_nomeNovaPasta.onkeyup = function()
		{
			var valorCampo = txt_nomeNovaPasta.value;
			var valorFiltrado = "";
			var quant = 0;
			var filtro = "´~`^¨";
				
			for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
			{
				if (filtro.indexOf(valorCampo.charAt(cont)) == -1)
				{
					valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
				}
			}
			
			txt_nomeNovaPasta.value = valorFiltrado;
		}
	</script>
</html>

<?php
	mysql_close($conexao);
?>