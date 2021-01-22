<?php
	include "php/Conexao.php";
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	session_start();
	/*if((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		unset($_SESSION['EletronTech']);
		header('location:../'); 
	}
	else
	{
		if ($_SESSION['EletronTech']['admin'] == 0)
		{
			header('location:../EletronTech.php'); 
		}
	}*/
	
	$op = 0;
	$valorBusca = "";
	
	if (isset($_POST['buscar']))
	{
		if ($_POST['op'] == 1)
		{
			$valorBusca = mysql_escape_string($_POST['valorBusca']);
		
			$query_Busca = "select cd_usuario, nm_usuario from tb_usuario 
								where nm_usuario like '%$valorBusca%'
									order by nm_usuario";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
			
		}
		else if ($_POST['op'] == 2)
		{
			$valorBusca = mysql_escape_string($_POST['valorBusca']);
		
			$query_Busca = "select cd_usuario, nm_usuario from tb_usuario 
								where cd_usuario like '$valorBusca'";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		else if ($_POST['op'] == 3)
		{
			$valorBusca = mysql_escape_string($_POST['valorBusca']);
		
			$query_Busca = "select cd_usuario, nm_usuario from tb_usuario 
								where nm_email like '%$valorBusca'%";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		else if ($_POST['op'] == 4)
		{
			$valorBusca = mysql_escape_string($_POST['valorBusca']);
		
			$query_Busca = "select cd_usuario, nm_usuario from tb_usuario 
								where cd_cpf like '%$valorBusca%'";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		
	}
	else
	{
		$query_Busca = "select cd_usuario, nm_usuario from tb_usuario order by nm_usuario limit 0";
			
		$result_Busca = mysql_query($query_Busca) or die(mysql_error());
		$linha_Busca = mysql_fetch_assoc($result_Busca);
		$totalLinha_Busca = mysql_num_rows($result_Busca);
	}
	
	if (isset($_POST['buscar']))
	{
		$valorBusca = mysql_escape_string($_POST['valorBusca']);
		
		$query_Busca = "select * from tb_usuario 
							where cd_usuario like '%$valorBusca%' or 
								  nm_usuario like '%$valorBusca%' or 
								  cd_cpf like '%$valorBusca%' or
								  cd_datanas like '%$valorBusca%' or
								  cd_telefone1 like '%$valorBusca%' or
								  cd_telefone2 like '%$valorBusca%' or
								  nm_sexo like '%$valorBusca%' or
								  nm_email like '%$valorBusca%' or
								  cd_senha like '%$valorBusca%'";
			
		$result_Busca = mysql_query($query_Busca) or die(mysql_error());
		$linha_Busca = mysql_fetch_assoc($result_Busca);
		$totalLinha_Busca = mysql_num_rows($result_Busca);
		
	}
	else
	{
		$query_Busca = "select * from tb_usuario order by nm_usuario";
			
		$result_Busca = mysql_query($query_Busca) or die(mysql_error());
		$linha_Busca = mysql_fetch_assoc($result_Busca);
		$totalLinha_Busca = mysql_num_rows($result_Busca);
	}
	
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
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="shortcut icon" href="imagens/logo/logoblackwhite.png" />
		<title>EletronTech - Gestão de Usuários</title>
		<style>
			*
			{
				margin: 0;
				padding: 0;				
				font-family: Century Gothic;
				outline: none;
			}
			
			::-webkit-scrollbar
			{
				height: 12px;
				width: 12px;
				background: linear-gradient(to top, #1d1d1d,#575757);
			}
			
			::-webkit-scrollbar-thumb
			{
				background:  gray;
				-webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.75);
			}

			::-webkit-scrollbar-corner
			{
				background: #000;
			}
			
			body
			{
				background-color: #000;
			}
			
			#all
			{
				display: inline-block;
				width: 950px;
				height: 500px;
				position: absolute;
				background-color: black;
				margin-left: -475px;
				margin-top: -250px;
				left: 50%;
				top: 50%;
			}
			
			.etLogo
			{
				width: 40px;
				margin-top: 2px;
				position: absolute;
			}
			
			.saudacao
			{
				font-size: 36px;
				color: gray;
				margin-left: 55px;
				text-shadow: 1px 1px #222;
			}
			
			.down
			{
				display: inline-block;
				width: 950px;
				height: 450px;
			}
			
			.busca
			{
				display: inline-block;
				width: 950px;
				height: 70px;
				background: linear-gradient(to top, #272727,#585858);
				
			}
			
			.buscatxt
			{
				display: inline-block;
				width: 770px;
				margin-left: 20px;
				height: 30px;
				margin-top: 20px;
				background-color: black;
				border: 0px;
				color: white;
				padding: 5px;
			}
			
			.optS
			{
				display: inline-block;
				width: 30px;
				background-color: transparent;
				margin-top:10px;
			}
			
			.optS:hover
			{
				background-color:#272727;
			}
			
			.btns
			{
				display: inline-block;
				position: absolute;
				margin-top: 10px;
				margin-left: 5px;
			}
			
			.giu
			{
				display: inline-block;
				width: 950px;
				height: 380px;
				margin-top: 10px;
			}
			
			.left
			{
				display: inline-block;
				width: 300px;
				height: 380px;
				background: linear-gradient(to top, #272727,#585858);
			}
			
			.right
			{
				display: inline-block;
				width: 640px;
				height: 380px;
				background: linear-gradient(to top, #272727,#585858);
				float: right;
			
			}
			
			.resbusca
			{
				display:inline-block;
				width: 280px;
				height: 300px;
				padding: 10px;
				margin-top: 20px;
				overflow: auto;
			}
			
			.itemResBusca
			{
				display: inline-block;
				width: 90%;
				margin-left: 5%;
				margin-bottom: 5px;
				color: white;
				font-size: 14px;
				text-shadow: 2px 2px #111;
			}
			
			.itemResBusca:hover
			{
				background-color: #585858;
			}
			
			.lblnmoe
			{
				display: inline-block;
				color: gray;
				width: 100%;
				right: 10px;
				font-size: 12px;
				text-shadow: 2px 2px #111;
				margin-top: 10px;
			}
			
		
			#dadosUsuario
			{
				display: inline-block;
				width: 390px;
				height: 190px;
				padding: 10px;
				position: absolute;
			}
			
			#dadosUsuario img
			{
				display: inline-block;
				width: 25px;
			}
			
			#dadosUsuario label
			{
				display: inline-block;
				heigth: 30px;
				color: #eee;
				font-size: 12px;
				margin-top:7px;
				margin-left: 10px;
				position: absolute;
			}
		
		
			.imgUsuario
			{
				display:inline-block;
				width: 200px;
				height: 200px;
				margin-left: 10px;
				padding:5px;
				<!--background-image: url('imagens/gus.jpg');-->
			}
			
			.username
			{
				display: inline-block;
				width: 620px;
				margin: 10px;
				text-shadow: 1px 1px #111;
				font-size: 24px;
				color: white;
				padding: 10px;
			}
			
			.perfilFoto
			{
				display: inline-block;
				width: 95%;
				height: 95%;
				margin-top: 2.5%;
				
			}
			
			.optGestaoUsuario
			{
				display: inline-block;
				position: absolute;
				margin-top: 200px;
				margin-left: -110px;
			}
		</style>
	</head>
	
	<body>
		<div id="all">
			<div class="titulo">
				<img class="etLogo" src="imagens/logowhite.png">
				<label class="saudacao">GESTÃO DE USUÁRIOS</label>
			</div>
			<div class="down">
				<div class="busca"><!-- if (txt_gerar.value == 0 && barraBusca.value != '') {return true;} else {return false;} -->
					<form id="Frm_Busca" method="POST" onsubmit="btn_busca.click(); return false;">
						<input type="text" class="buscatxt" id="barraBusca" name="valorBusca">
						<input type="hidden" name="tipoBusca" id="txt_tipo" value="<?php if (isset($_POST['buscar'])) {echo $_POST['op'];} else {echo $op;}?>">
						<input type="hidden" name="valorBuscaTXT" id="txt_buscaTXT" value="<?php echo $valorBusca; ?>">
						<input type="hidden" name="gerar" id="txt_gerar" value="0">
						<input type="hidden" name="op" id="rdb_op_nome" value="1">
						<div class="btns">
							<input type="image" class="optS" id="btn_busca" value="Buscar" name="buscar" src="imagens/iconesadm/search.png">
							<input type="image" class="optS" src="imagens/iconesadm/buscaav.png" onclick="return false;">
							<input type="image" class="optS" id="btn_limpar" value="Limpar" src="imagens/iconesadm/limpar.png">
							<input type="image" class="optS" src="imagens/iconesadm/download.png" onclick="return false;">
						</div>
					</form>
				</div>
				<div class="giu">
					<div class="left">
						<div id="resbusca" class="resbusca">
							<?php
								do
								{
									if ($linha_Busca['nm_usuario'] != "")
									{
										$nome = $linha_Busca['nm_usuario'];
										
										if ($linha_Busca['im_usuario'] != "")
										{						
											$fotoPerfil = "../".$linha_Busca['im_usuario'];
										}
										else
										{
											$fotoPerfil = "../imagens/usuario.png";
										}
										
										$datanas = $linha_Busca['cd_datanas'];
										$datanas = $datanas[0].$datanas[1].'/'.$datanas[2].$datanas[3].'/'.$datanas[4].$datanas[5].$datanas[6].$datanas[7];
										$datanas = "Nascido em ".$datanas;
										
										$sexo = $linha_Busca['nm_sexo'];
										$email = $linha_Busca['nm_email'];
										
										$tipoTelefone1 = $linha_Busca['cd_tipo_telefone1'];
										$tipoTelefone2 = $linha_Busca['cd_tipo_telefone2'];
										
										$mascaraCPF = "###.###.###-##";
										$mascaraTelefoneFixo = "(##) ####-####";
										$mascaraTelefoneCelular = "(##) #####-####";
										
										$aux = $linha_Busca['cd_cpf'];
										$cpf = $aux[0] . $aux[1] . $aux[2] . $mascaraCPF[3] . $aux[3] . $aux[4] . $aux[5] . $mascaraCPF[7] . $aux[6] . $aux[7] . $aux[8] . $mascaraCPF[11] . $aux[9] . $aux[10];
										
										$aux = $linha_Busca['cd_telefone1'];
										$tipo = $linha_Busca['cd_tipo_telefone1'];
										
										if ($tipo != 2)
										{
											$telefone1 = $mascaraTelefoneFixo[0] . $aux[0] . $aux[1] . $mascaraTelefoneFixo[3] . $mascaraTelefoneFixo[4] . $aux[2] . $aux[3] . $aux[4] . $aux[5] . $mascaraTelefoneFixo[9] . $aux[6] . $aux[7] . $aux[8] . $aux[9];
										}
										else
										{
											$telefone1 = $mascaraTelefoneCelular[0] . $aux[0] . $aux[1] . $mascaraTelefoneCelular[3] . $mascaraTelefoneCelular[4] . $aux[2] . $aux[3] . $aux[4] . $aux[5] . $aux[6] . $mascaraTelefoneCelular[10] . $aux[7] . $aux[8] . $aux[9] . $aux[10];
										}
										
										if ($linha_Busca['cd_telefone2'] != "")
										{
											$aux = $linha_Busca['cd_telefone2'];
											$tipo = $linha_Busca['cd_tipo_telefone2'];
											
											if ($tipo != 2)
											{
												$telefone2 = $mascaraTelefoneFixo[0] . $aux[0] . $aux[1] . $mascaraTelefoneFixo[3] . $mascaraTelefoneFixo[4] . $aux[2] . $aux[3] . $aux[4] . $aux[5] . $mascaraTelefoneFixo[9] . $aux[6] . $aux[7] . $aux[8] . $aux[9];
											}
											else
											{
												$telefone2 = $mascaraTelefoneCelular[0] . $aux[0] . $aux[1] . $mascaraTelefoneCelular[3] . $mascaraTelefoneCelular[4] . $aux[2] . $aux[3] . $aux[4] . $aux[5] . $aux[6] . $mascaraTelefoneCelular[10] . $aux[7] . $aux[8] . $aux[9] . $aux[10];
											}
										}
										else
										{
											$telefone2 = "Informação não disponível!";
										}
										
										if ($linha_Busca['ic_admin'] == 1)
										{
											$admin = "Sim";
										}
										else
										{
											$admin = "Não";
										}
										
										$dataCadastro = "Usuário do Eletron Tech desde ".date("d", strtotime($linha_Busca['dt_cadastro']))." de ".TransformaMes(date("m", strtotime($linha_Busca['dt_cadastro'])))." de ".date("Y", strtotime($linha_Busca['dt_cadastro']));
										
										$funcaoJavaScript = "nome.innerHTML = '$nome'; parent.fotoPerfil.src = '$fotoPerfil'; datanas.innerHTML = '$datanas'; sexo.innerHTML = '$sexo'; email.innerHTML = '$email'; if ('$telefone2' == '() -') {trTelefone2.style.display = 'none';} else {trTelefone2.style.display = 'inline-block';} txt_tipoTelefone1.value = '$tipoTelefone1'; txt_tipoTelefone2.value = '$tipoTelefone2'; telefone1.innerHTML = '$telefone1'; telefone2.innerHTML = '$telefone2'; cpf.innerHTML = '$cpf'; admin.innerHTML = '$admin'; dataCadastro.innerHTML = '$dataCadastro'; if (txt_tipoTelefone1.value != 2) {parent.imagemTelefone1.src = 'imagens/telefone.png';} else {parent.imagemTelefone1.src = 'imagens/celular.png';} if (txt_tipoTelefone2.value != 2) {parent.imagemTelefone2.src = 'imagens/telefone.png';} else {parent.imagemTelefone2.src = 'imagens/celular.png';}";
							?>
									<label class="itemResBusca" onclick="<?php echo $funcaoJavaScript; ?>"><?php if ($linha_Busca['nm_usuario'] != "") {echo $linha_Busca['nm_usuario'];} ?></label>
							<?php
									}
								}
								while ($linha_Busca = mysql_fetch_assoc($result_Busca));
							?>
						</div>
						<label id="lbl_buscaPor" class="lblnmoe" align="center">Resultados da busca por "<?php echo $valorBusca; ?>"</label>
					</div>
					
					<div class="right">
						<div class="username">
							<label id="nome">Informação não disponível!</label> 
						</div>
						<div class="imgUsuario" align="center">
							<img src="../imagens/usuario.png" id="fotoPerfil" class="perfilFoto">
						</div>
						<div id="dadosUsuario">
							<table>
								<tbody>
									<tr>
										<td>
											<img src="imagens/baby.png"><label id="datanas">Informação não disponível!</label>
										</td>
									</tr>
									
									<tr>
										<td>
											<img src="imagens/homem.png"><label id="sexo">Informação não disponível!</label>
										</td>
									</tr>
									
									<tr style="display: none;">
										<td>
											<img src="imagens/estudante.png"><label id="tipoUsuario">Informação não disponível!</label>
										</td>
									</tr>
									
									<tr>
										<td>
											<img src="imagens/mensagens.png"><label id="email">Informação não disponível!</label>
										</td>
									</tr>
									
									<tr>
										<td>
											<img id="imagemTelefone1" src="imagens/telefone.png"><label id="telefone1">Informação não disponível!</label>
											<input type="hidden" id="txt_tipoTelefone1">
										</td>
									</tr>
									
									
									<tr id="trTelefone2">
										<td>
											<img id="imagemTelefone2" src="imagens/celular.png"><label id="telefone2">Informação não disponível!</label>
											<input type="hidden" id="txt_tipoTelefone2">
										</td>
									</tr> 
									
									<tr>
										<td>
											<img src="imagens/documento.png"><label id="cpf">Informação não disponível!</label>
										</td>
									</tr>
									
									<tr>
										<td>
											<img src="imagens/admin.png"><label id="admin">Informação não disponível!</label>
										</td>
									</tr>
									
									<tr>
										<td>
											<img src="imagens/tempo.png"><label id="dataCadastro">Informação não disponível!</label>
										</td>
									</tr>
								</tbody>
							</table>				
						</div>
						<div class="optGestaoUsuario">
							<img class="optS"src="imagens/iconesadm/editar.png">
							<img class="optS"src="imagens/iconesadm/excluir.png">
							<img class="optS"src="imagens/iconesadm/download.png">
						</div>
					</div>
				</div>
			</div>
		</div>
		<iframe id="FrameBuscar" src="" style="display: none;"></iframe>
	</body>
	<script src="script/ajax.js"></script>
	<script>
		barraBusca.onkeyup = function()
		{
			btn_busca.click();
		}
		
		btn_busca.onclick = function()
		{
			txt_tipo.value = 1;

			Ajax("GET", "php/BuscarUsers.php", "buscar=" + btn_busca.value + "&op=" + txt_tipo.value + "&valorBusca=" + barraBusca.value.trim(), "var retorno = this.responseXML; var buscaPor = retorno.getElementsByTagName('buscar')[0].innerHTML.trim(); lbl_buscaPor.innerHTML = 'Resultados da busca por \"' + buscaPor + '\"'; var lista = this.responseText; lista = lista.split('<!-- lista --\>'); if (lista[1].trim() != '') {resbusca.innerHTML = lista[1];} else {resbusca.innerHTML = '';}");

			return false;
		}
		
		btn_limpar.onclick = function()
		{
			LimparDadosRelatorio();
			
			barraBusca.value = '';
			btn_busca.click(); 
			
			return false;
		}
		
		function LimparDadosRelatorio()
		{
			fotoPerfil.src = "../imagens/usuario.png";
			
			nome.innerHTML = "Informação não disponível!";
			datanas.innerHTML = "Informação não disponível!";
			sexo.innerHTML = "Informação não disponível!";
			tipoUsuario.innerHTML = "Informação não disponível!";
			email.innerHTML = "Informação não disponível!";
			telefone1.innerHTML = "Informação não disponível!";
			telefone2.innerHTML = "Informação não disponível!";
			cpf.innerHTML = "Informação não disponível!";
			admin.innerHTML = "Informação não disponível!";
			dataCadastro.innerHTML = "Informação não disponível!";
			
			imagemTelefone1.src = "imagens/telefone.png";
			imagemTelefone2.src = "imagens/celular.png";
		}
	</script>
</html>

<?php
	mysql_close($conexao);
?>