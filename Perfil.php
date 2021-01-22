<?php
	include ("php/Conexao.php");
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );

	date_default_timezone_set( 'America/Sao_Paulo' );
	
	session_start();
	$codigo = $_SESSION['EletronTech']['codigo'];
		
	$query_Busca = "select * from tb_usuario where cd_usuario = '$codigo'";
			
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);
	
	$_SESSION['EletronTech']['login'] = $linha_Busca['nm_usuario'];
	
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
	
	$dia = $dataCadastro[0];
	$mes = $dataCadastro[1];
	$mes = TransformaMes($mes);
	$ano = $dataCadastro[2];
	
	$query_Busca_Evento = "select * from tb_evento where dt_evento >= curdate() and cd_usuario = '$codigo' order by dt_evento";
	$result_Busca_Evento = mysql_query($query_Busca_Evento) or die(mysql_error());
	$linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento);
	$totalLinha_Busca_Evento = mysql_num_rows($result_Busca_Evento);
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="shortcut icon" href="imagens/logo/logo.ico" />
		<title></title>
	</head>
	<style>
		*
		{
			margin: 0;
			padding: 0;
			font-family: Century Gothic;
			outline: none;
			cursor: hand;
			font-size: 10px;
			
		}
		
		body
		{
			background-color: #transparent;
			overflow: hidden;
		}
		
		#all
		{
			display: inline-block;
			position: absolute;
			width: 1000px;
			height: 500px;
			margin-left: -500px;
			margin-top: -270px;
			left: 50%;
			top: 50%;
			background-color: transparent;
			
		}
		
		#etLogo
		{
			margin-left: 20px;
			width: 50px;
			margin-bottom: -15px;
		}
		
		#saudacao
		{
			font-size: 36px;
			color: #167ff6;
			margin-left: 25px;
		}
		
		#user
		{
			display: inline-block;
			width: 950px;
			height: 150px;
			background-color: black;
			margin-left: 25px;
			margin-top: 50px;
			background-image: url('<?php if ($linha_Busca['im_capa'] == "") {echo "imagens/ae.png";} else {echo $linha_Busca['im_capa'];} ?>');
			box-shadow: 0px 0px 4px 0px gray;
		}
		
		#foto
		{
			display: inline-block;
			width: 180px;
			height: 180px;
			margin-top:-15px;
			margin-left: 30px;
			background-color: black;
			box-shadow: 0px 0px 4px 0px gray;
			background-image: url('<?php if ($linha_Busca['im_capa'] == "") {echo "imagens/ae.png";} else {echo $linha_Busca['im_capa'];} ?>');
		}
		
		#foto img
		{
			width: 95%;
			height: 95%;
			padding: 2.5%;
		}
		
		#nmUsuario
		{
			display: inline-block;
			position: absolute;
			color: white;
			height: 150px;
			width: 730px;
		}
		
		#nmUsuario label
		{
			display: inline-block;
			margin-top: 50px;
			font-size: 36px;
			text-shadow: 2px 2px #000;
		}
		
		#dadosUsuario
		{
			display: inline-block;
			width: 500px;
			heigh: 300px;
			background-color: #292929;
			margin-left: 25px;
			padding: 25px;
			margin-top: 30px;
			box-shadow: 0px 0px 4px 0px #222222;
		}
		
		#dadosUsuario img
		{
			display: inline-block;
			width: 30px;
		}
		
		#dadosUsuario label
		{
			display: inline-block;
			heigth: 30px;
			color: #eee;
			font-size: 14px;
			margin-top:7px;
			margin-left: 10px;
			position: absolute;
		}
		
		#mudarFoto
		{
			display: none;
			width: 80%;
			height: 15px;
			background-color: black;
			z-index: 9999;
			margin-top: -45px;
			font-size: 14px;
			color: white;
			opacity: 0.8;
			padding:15px;
		}
		
		#editCapa
		{
			display: inline-block;
			position: relative;
			float: right;
			width: 30px;
			bottom: 10px;
			margin-left: 200px;
			opacity: 0.7;
			margin-top: 120px;
			background-color:transparent;
		}
		
		#menuI
		{
			display: inline-block;
			width: 320px;
			height: 225px;
			background-color: #292929;
			margin-top: 30px;
			margin-left: 30px;
			position: absolute;
			padding: 25px;
			box-shadow: 0px 0px 4px 0px #222222;
		}
		
		#nota
		{
			display: inline-block;
			width: 100%;
			height:180px;
		}
		
		#nota label
		{
			color: white;
			font-size: 14px;
		}
		
		#nota textarea
		{
			display: inline-block;
			width: 100%;
			margin-top: 20px;
			background-color:#125abd;
			border: 0px;
			color: white;
			height: 150px;
			resize: none;
			padding: 10px;
			font-family: Century Gothic;
			font-size: 12px;
		}
		
		#nota img
		{
			height: 70%;
		}
		
		
		#crud
		{
			display: inline-block;
			width: 100%;
			background-color: #292929;
			margin-top: 20px;
		}
		
		#crud input
		{
			width: 30px;
		}
		
		#crud input:hover
		{
			background-color: #125abd;
		}
		
		#crud label
		{
			display: inline-block;
			color: #4e98ff;
			font-size: 14px;
			margin-left: -120px;
			margin-top:7px;
			position: absolute;
		}
		
		h1
		{
			color: #4e98ff;
			font-size: 18px;
		}
		
		#confirmarDel
		{
			display: none;
			background-color: #0d4c94;
			width: 400px;
			height: 180px;
			margin-left: -200px;
			left: 50%;
			top: 50%;
			margin-top: -90px;
			position: absolute;
			z-index: 9999;
			box-shadow: 0px 0px 4px 0px black;
		}

		#confirmarDel table
		{
			display: inline-block;
			width: 90%;
			color: white;
			margin: 5%;
			background-color: transparent;
			margin-top: 50px;
		}
		
		#confirmarDel label
		{
			font-size: 14px;
		}
		
		#confirmarDel h1
		{
			display: inline-block;
			width: 100%;
			margin-top: 20px;
			position: absolute;
			color: white;
		}
		
		#excluirConta
		{
			display: none;
			background-color: #0d4c94;
			width: 400px;
			height: 150px;
			margin-left: -200px;
			left: 50%;
			top: 50%;
			margin-top: -75px;
			position: absolute;
			z-index: 9999;
			box-shadow: 0px 0px 4px 0px black;
		}
		
		
		#excluirConta table
		{
			display: inline-block;
			width: 90%;
			color: white;
			margin: 5%;
			background-color: transparent;
			margin-top: 50px;
		}
		
		#excluirConta label
		{
			font-size: 14px;
		}
		
		#excluirConta h1
		{
			display: inline-block;
			width: 100%;
			margin-top: 20px;
			position: absolute;
			color: white;
		}
		
		#mudarSenha
		{
			display: none;
			background-color: #0d4c94;
			width: 350px;
			height: 280px;
			margin-left: -185px;
			left: 50%;
			top: 50%;
			margin-top: -140px;
			position: absolute;
			z-index: 9999;
			box-shadow: 0px 0px 4px 0px black;
		}
		
		#mudarSenha table
		{
			display: inline-block;
			width: 90%;
			color: white;
			margin: 5%;
			background-color: transparent;
			margin-top: 50px;
		}
		
		#mudarSenha h1
		{
			display: inline-block;
			width: 100%;
			margin-top: 20px;
			position: absolute;
			color: white;
		}
		
		#mudarSenha label
		{
			font-size: 14px;
		}
		
		#formEditar
		{
			display: none;
			background-color: #0d4c94;
			width: 500px;
			height: 400px;
			margin-left: -250px;
			left: 50%;
			top: 50%;
			margin-top: -200px;
			position: absolute;
			z-index: 9999;
			box-shadow: 0px 0px 4px 0px black;
		}
		
		#formEditar h1
		{
			display: inline-block;
			width: 100%;
			margin-top: 20px;
			position: absolute;
			color: white;
		}
		
		#formEditar table
		{
			display: inline-block;
			width: 90%;
			color: white;
			margin: 5%;
			background-color: transparent;
			margin-top: 40px;
		}
		
		#formEditar label
		{
			font-size: 12px;
		}
		
		#formEditar input, #mudarSenha input, #excluirConta input, #confirmarDel input, #formEditar select
		{
			width: 100%;
			height: 36px;
			font-size: 14px;
		}
		
		#fecharConfirmarDel, #btn_desativar, #btn_naoDel, #btn_simDel, #btn_editarCad, #btn_cancelarCad, #btn_cancela, #btn_confirma
		{
			background-color: #061f3c;
			border: 0;
			color: white;
		}
		
		#fecharConfirmarDel:hover, #btn_desativar:hover, #btn_naoDel:hover, #btn_simDel:hover, #btn_editarCad:hover, #btn_cancelarCad:hover, #btn_cancela:hover, #btn_confirma:hover
		{
			background: linear-gradient(to bottom, #0078ff, #176bc9);
		}
		
		#tp
		{
			display: none;
			background-color: black;
			width: 100%;
			height: 100%;
			z-index: 9998;
			position: absolute;
			top:0;
			left: 0;
			opacity: 0.7;
		}
	</style>
	<body>
		<div id="all">
			<img id="etLogo" src="imagens/logo/logoblue.png">
			<label id="saudacao">Perfil</label>
			
			<div id="user">
				<div id="foto" align="center">
					<img src="<?php if ($linha_Busca['im_usuario'] == "") {echo "et-admin/usuario.png";} else {echo $linha_Busca['im_usuario'];} ?>">
					<label id="mudarFoto">Escolher Foto</label>
				</div>
				<div id="nmUsuario" align="center">
					<label><?php echo $linha_Busca['nm_usuario']; ?></label>
					<input id="editCapa" type="image" src="imagens/foto.png">
				</div>

				
				
				
			</div>
			
			<div id="dadosUsuario">
				<table>
					<tr>
						<td>
							<img src="imagens/baby.png"><label>Nascido em <?php echo $data; ?></label>
						</td>
					</tr>
					
					<tr>
						<td>
							<img src="imagens/homem.png"><label><?php echo $linha_Busca['nm_sexo']; ?></label>
						</td>
					</tr>
					
					<tr style="display: none;">
						<td>
							<img src="imagens/estudante.png"><label>Estudante</label>
						</td>
					</tr>
					
					<tr>
						<td>
							<img src="imagens/mensagens.png"><label><?php echo $linha_Busca['nm_email']; ?></label>
						</td>
					</tr>
					
					<tr>
						<td>
							<img src="<?php echo $imagemTipo; ?>"><label><?php echo $telefone; ?></label>
						</td>
					</tr>
					
					
					<tr>
						<td>
							<img src="<?php echo $imagemTipo2; ?>"><label><?php echo $telefone2; ?></label>
						</td>
					</tr> 
					
					<tr>
						<td>
							<img src="imagens/documento.png"><label><?php echo $CPF; ?></label>
						</td>
					</tr>
					
					<tr>
						<td>
							<img src="imagens/tempo.png"><label>Usuário do Eletron Tech desde <?php echo  $dia . " de " . $mes . " de " . $ano;?></label>
						</td>
					</tr>
				</table>
				
			
				<form id="Frm_Foto" method="POST" action="php/AtualizarFoto.php" enctype="multipart/form-data" style="display:none">
					<div id="fotoperfil">
						<input type="file" id="upFoto" name="foto">
					</div>
				</form>
				
				<input id="btn_confirmarFoto" style="display: none;" type="image" src="imagens/senha.png">
				
			</div>
				
			<div id="menuI">
				<div id="nota" align="center">
					<!--<label>Anotações</label>
					<textarea></textarea>-->
					
					<!--Próximo evento-->
					<label>Próximo Evento</label><br>
					<h1 id="nomeEvento" <?php if ($linha_Busca_Evento['nm_evento'] == "") {echo 'style="display: none;"';}?>></h1>
					<img src="imagens/calendario.png" <?php if ($linha_Busca_Evento['nm_evento'] == "") {echo 'style="display: none;"';}?>><br>
					<label id="data" <?php if ($linha_Busca_Evento['nm_evento'] == "") {echo 'style="display: none;"';}?>></label>
				</div>
				<div id="crud" align="right">
					<label id="legenda"></label>
					<input id="btnEditar" type="image" src="imagens/dados.png">
					<input id="btnPassword" type="image" src="imagens/senha.png">
					<input id="btnExcluiConta" type="image" src="imagens/excluirUser.png">
				</div>
			</div>
				
				
			<!-- Editar Conta -->
			<div id="formEditar">
				<h1 align="center"> Editar Cadastro</h1>
				<form id="Frm_Editar_Dados" method="POST" action="php/EditarDados.php">
					<table>
						<tr>
							<td colspan="2">
								
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<label>Nome completo</label>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input value="<?php echo $linha_Busca['nm_usuario']; ?>" name="nome" type="text" id="txt_nome" maxlength="50" required>
							</td>
						</tr>
						<tr>
							<td>
								<label>CPF</label>
							</td>
							<td>
								<label>Data de Nascimento</label>
							<td>
						</tr>
						<tr>
							<td>
								<input value="<?php echo $linha_Busca['cd_cpf']; ?>" name="cpf" type="text" id="txt_cpf" maxlength="14" disabled required>
							</td>
							<td>
								<input value="<?php echo $linha_Busca['cd_datanas']; ?>" name="datanas" type="text" id="txt_datanas_fisica" maxlength="10" placeholder="DD/MM/AAAA" required>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<label>Telefone</label>
							</td>
						</tr>
						<tr>
							<?php
								if ($linha_Busca['cd_tipo_telefone1'] == 1)
								{
									echo '<td>
											<select id="cmb_tipo_tel1_fisica" name="tipo_telefone1">
												<option value="0">Selecione um...</option>
												<option value="1" selected>Residencial</option>
												<option value="2">Celular</option>
												<option value="3">Comercial</option>
											</select>
										</td>';
								}
								else if ($linha_Busca['cd_tipo_telefone1'] == 2)
								{
									echo '<td>
											<select id="cmb_tipo_tel1_fisica" name="tipo_telefone1">
												<option value="0">Selecione um...</option>
												<option value="1">Residencial</option>
												<option value="2" selected>Celular</option>
												<option value="3">Comercial</option>
											</select>
										</td>';
								}
								else if ($linha_Busca['cd_tipo_telefone1'] == 3)
								{
									echo '<td>
											<select id="cmb_tipo_tel1_fisica" name="tipo_telefone1">
												<option value="0">Selecione um...</option>
												<option value="1">Residencial</option>
												<option value="2">Celular</option>
												<option value="3" selected>Comercial</option>
											</select>
										</td>';
								}
								else
								{
									echo '<td>
											<select id="cmb_tipo_tel1_fisica" name="tipo_telefone1">
												<option value="0">Selecione um...</option>
												<option value="1">Residencial</option>
												<option value="2">Celular</option>
												<option value="3">Comercial</option>
											</select>
										</td>';
								}
							?>
											
							<td>
								<input value="<?php echo $linha_Busca['cd_telefone1']; ?>" name="telefone1" type="text" id="txt_telefone1_fisica" maxlength="15" required>
							</td>
						</tr>

						<tr>
							<td>
								<label>Telefone 2</label>
							</td>
						</tr>
						<tr>
							<?php
								if ($linha_Busca['cd_tipo_telefone2'] == 1)
								{
									echo '<td>
											<select id="cmb_tipo_tel2_fisica" name="tipo_telefone2">
												<option value="0">Selecione um...</option>
												<option value="1" selected>Residencial</option>
												<option value="2">Celular</option>
												<option value="3">Comercial</option>
											</select>
										</td>';
								}
								else if ($linha_Busca['cd_tipo_telefone2'] == 2)
								{
									echo '<td>
											<select id="cmb_tipo_tel2_fisica" name="tipo_telefone2" >
												<option value="0">Selecione um...</option>
												<option value="1">Residencial</option>
												<option value="2" selected>Celular</option>
												<option value="3">Comercial</option>
											</select>
										</td>';
								}
								else if ($linha_Busca['cd_tipo_telefone2'] == 3)
								{
									echo '<td>
											<select id="cmb_tipo_tel2_fisica" name="tipo_telefone2" >
												<option value="0">Selecione um...</option>
												<option value="1">Residencial</option>
												<option value="2">Celular</option>
												<option value="3" selected>Comercial</option>
											</select>
										</td>';
								}
								else
								{
									echo '<td>
											<select id="cmb_tipo_tel2_fisica" name="tipo_telefone2" >
												<option value="0">Selecione um...</option>
												<option value="1">Residencial</option>
												<option value="2">Celular</option>
												<option value="3">Comercial</option>
											</select>
										</td>';
								}
							?>
							
							
							<td>
								<input value="<?php echo $linha_Busca['cd_telefone2']; ?>" name="telefone2" type="text" id="txt_telefone2_fisica" maxlength="15" <?php if ($linha_Busca['cd_tipo_telefone2'] == 0) {echo "disabled";} ?>>
							</td>
						</tr>				
					</br>
						<tr>
							<td colspan="2">
								
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<label>E-mail</label>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input value="<?php echo $linha_Busca['nm_email']; ?>" name="email" type="text" id="txt_email" placeholder="Apenas letras minusculas"  disabled required>
							</td>
						</tr>

						<!--
						<tr>
							<td>
								<label>Confirmar Senha</label>
							</td>					
						</tr>

						<tr>
							<td>
								<input type="password" id="txt_senha_antiga" placeholder="" name="senha_antiga"maxlength="12">
							</td>
							
						</tr>
						-->
						<tr>
							<td>
								<input value="<?php echo $linha_Busca['cd_usuario']; ?>" name="codigo" type="hidden" id="txt_codigo" placeholder="" maxlength="12" required>
							</td>
							<!--
							<td>
								<input value="<?php echo $linha_Busca['cd_senha']; ?>" type="hidden" id="txt_senha_antiga_banco" placeholder="" maxlength="12" required>
							</td>
							-->					
						</tr>
						<tr>
							<td>
								<input type="button" value="Cancelar" id="btn_cancelarCad"></input>
							</td>
							<td>
								<input type="button" value="Confirmar" id="btn_editarCad"></input>
							</td>
						</tr>
					</table>
				</form>
			</div>


			<!-- Mudar Senha -->
			<div id="mudarSenha">
				<h1 id="alteraSenha" align="center">Alterar Senha</h1>
				<table>
					<tr>
						<td colspan="2">
							<label>Digite sua senha atual</label>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="password" id="passAtual" maxlength="12">
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<label>Digite sua nova senha</label>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="password" id="passNew" maxlength="12">
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<label>Confirme sua nova senha</label>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="password" id="passNewConfirma" maxlength="12">
						</td>
					</tr>
					
					<tr>
						<td>
							<input type="button" id="btn_cancela" value="Cancelar">
						</td>
						<td>
							<input type="button" id="btn_confirma" value="Confirmar">
						</td>
					</tr>
					<input value="<?php echo $linha_Busca['cd_senha']; ?>" type="hidden" id="txt_senha_antiga_banco" placeholder="" maxlength="12" required>
				</table>
			</div>	
				
			<div id="excluirConta">
				<h1 id="delLabel" align="center">Desativar Conta</h1>
				<table>
					<tr>
						<td colspan="2" align="center">
							<label>Deseja realmente desativar sua conta?</label>
						</td>
					<tr>
					<tr>
						<td>
							<input type="button" value="Não" id="btn_naoDel">
						</td>
						<td>
							<input type="button" value="Sim " id="btn_simDel">
						</td>
					<tr>
				</table>
			</div>
			
			<div id="confirmarDel">
				<h1 id="delLabel" align="center">Desativar Conta</h1>				
				<table>
					<tr>
						<td colspan="2" align="justify">
							<label>Para concluir a desativação de sua conta digite sua senha no campo abaixo</label>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="password" id="confirmarSenhaDel">
						</td>
					</tr>
					<tr>
						<td>
							<input type="button" value="Cancelar " id="fecharConfirmarDel">
						</td>
						<td>
							<input type="button" value="Confirmar" id="btn_desativar">
						</td>
					</tr>
				</table>
			</div>
				
				<!--Conf Edit.
			<div id="confirmarAlt">
				<h1 id="altLabel" align="center">Confirmar Alterações</h1>
				<table>
					<tr>
						<td colspan="2" align="justify">
							<label>Digite sua senha para confirmar as alterações no perfil</label>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="password" id="confirmarSenhaDel">
						</td>
					</tr>
					<tr>
						<td>
							<input type="button" value="Cancelar " id="fecharConfirmarDel">
						</td>
						<td>
							<input type="button" value="Confirmar" id="btn_desativar">
						</td>
					</tr>
				</table>
			</div>
			-->
		</div>
		<div id="tp">
	
		</div>
		<form id="Frm_AlterarSenha" method="POST" style="display: none;" action="php/AlterarSenha.php">
			<input type="hidden" id="txt_passNew" name="senha" value="" required>
		</form>
	</body>
	<script type="text/javascript" src="script/Criptografia.js"></script>
	<script>
		window.onload = function()
		{
			nmEvento = new Array;
			diaEvento = new Array;
			mesEvento = new Array;
			anoEvento = new Array;
			txt_passNew.value = "";
			
			<?php
				do
				{
			?>
					nmEvento.push("<?php echo $linha_Busca_Evento['nm_evento']; ?>");
					<?php
						$dataEvento = date("d/m/Y", strtotime($linha_Busca_Evento['dt_evento']));
						$dataEvento = explode('/',$dataEvento);
					?>
					diaEvento.push("<?php echo $dataEvento[0]; ?>");
					mesEvento.push("<?php echo TransformaMes($dataEvento[1]); ?>");
					anoEvento.push("<?php echo $dataEvento[2]; ?>")
			<?php
				}
				while ($linha_Busca_Evento = mysql_fetch_assoc($result_Busca_Evento));
			?>
			
			nomeEvento.innerHTML = nmEvento[0];
			data.innerHTML = diaEvento[0] + " de " + mesEvento[0] + " de " + anoEvento[0];
		}
	
		foto.onmouseover = function()
		{
			mudarFoto.style.display = "inline-block";
		}
		
		foto.onmouseout = function()
		{
			mudarFoto.style.display = "none";
		}
		
		mudarFoto.onclick = function()
		{
			Frm_Foto.action = "php/AtualizarFoto.php";
			upFoto.click();
			btn_confirmarFoto.style.display = 'none';
		}
		
		
		
		upFoto.onchange = function()
		{
			if (upFoto.value != "")
			{
				btn_confirmarFoto.click();
			}
		}
		
		btn_confirmarFoto.onclick = function()
		{
			var frm = document.querySelector("#Frm_Foto");
			frm.submit();
		}
		
		nmUsuario.onmouseover = function()
		{
			editCapa.style.backgroundColor = "black";
		}
		
		nmUsuario.onmouseout = function()
		{
			editCapa.style.backgroundColor = "transparent";
		}
		
		editCapa.onclick = function()
		{
			Frm_Foto.action = "php/AtualizarCapa.php";
			upFoto.click();
			btn_confirmarFoto.style.display = 'none';
		}
		
		btnEditar.onmouseover = function()
		{
			legenda.innerHTML = "Editar Cadastro";
		}
		
		btnPassword.onmouseover = function()
		{
			legenda.innerHTML = "Alterar Senha";
		}
		
		btnExcluiConta.onmouseover = function()
		{
			legenda.innerHTML = "Desativar Conta";
		}
		
		btnEditar.onmouseout = function()
		{
			legenda.innerHTML = "";
		}
		
		btnPassword.onmouseout = function()
		{
			legenda.innerHTML = "";
		}
		
		btnExcluiConta.onmouseout = function()
		{
			legenda.innerHTML = "";
		}
		
		btnEditar.onclick = function()
		{
			tp.style.display = "inline-block";
			formEditar.style.display = "inline-block";
		}
		
		btn_cancelarCad.onclick = function()
		{
			tp.style.display = "none";
			formEditar.style.display = "none";
		}
		
		btnPassword.onclick = function()
		{
			tp.style.display = "inline-block";
			mudarSenha.style.display = "inline-block";
		}
		
		btn_cancela.onclick = function()
		{
			tp.style.display = "none";
			mudarSenha.style.display = "none";
			
			passAtual.value="";
			passNew.value="";
			passNewConfirma.value="";
			
			passAtual.style.border="";
			passNew.style.border="";
			passNewConfirma.style.border="";
		}
		
		btnExcluiConta.onclick = function()
		{
			tp.style.display = "inline-block";
			excluirConta.style.display = "inline-block";
		}
		
		btn_naoDel.onclick = function()
		{
			tp.style.display = "none";
			excluirConta.style.display = "none";
		}
		
		btn_simDel.onclick = function()
		{
			confirmarDel.style.display = "inline-block";
			excluirConta.style.display = "none";
		}
		
		fecharConfirmarDel.onclick = function()
		{
			tp.style.display = "none";
			confirmarDel.style.display = "none";
		}
		
		document.onkeydown = KeyCheck;
		function KeyCheck()
		{
		   var KeyID = event.keyCode;
		   switch(KeyID)
		   {
			  case 38:
				//parent.ativarMenu();
				parent.inicioOPT.click();
				parent.inicio.focus();
				
			  break; 
			  case 40:
				//parent.ativarMenu();
				parent.mensagensOPT.click();
				parent.mensagens.focus();
			  break;
			  default:
			  break;
		   }
		}
		
		btn_editarCad.onclick = function()
		{
			parent.inicio.src = "Inicio.php";
			txt_codigo.value = <?php echo $linha_Busca['cd_usuario']; ?>;
			Validar();
		}
		
		var campoSenhaAntiga = document.querySelector("#passAtual");
		var campoSenhaAntigaBanco = document.querySelector("#txt_senha_antiga_banco");
		var camposCorretosSenha = new Array(3);

		btn_confirma.onclick = function()
		{
			verificarSenhaAntiga();
			verificarSenha();
			verificarConfirmaSenha();
			
			var aux = 0;
			for (cont = 0; cont <= camposCorretosSenha.length - 1; cont = cont + 1)
			{
				aux = aux + parseInt(camposCorretosSenha[cont]);
			}
			
			if (aux != camposCorretosSenha.length)
			{
				alert("Alguns campos estão inválidos, verifique e tente novamente!\n\n");
				return false;
			}
			else
			{
				//parent.exibir();
				//tabela.style.display="inline-block";
				mudarSenha.style.display="none";
				passAtual.value="";
				aux = passNew.value;
				passNew.value="";
				passNewConfirma.value="";
				passAtual.style.border="";
				passNew.style.border="";
				passNewConfirma.style.border="";
				txt_passNew.value = aux;
				Frm_AlterarSenha.submit();				
			}
		}
		
		campoSenhaAntiga.onfocus = function()
		{
			campoSenhaAntiga.style.border = "3px solid blue";
		}

		function verificarSenhaAntiga()
		{
			if (campoSenhaAntiga.value == base64_decode(campoSenhaAntigaBanco.value))
			{
				campoSenhaAntiga.style.border = "3px solid green";
				camposCorretosSenha[0] = 1;
			}
			else
			{
				campoSenhaAntiga.style.border = "3px solid red";
				camposCorretosSenha[0] = 0;
			}
		}
		
		campoSenhaAntiga.onkeypress = function(e,args)
		{
			if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = "0123456789abcdefghijlmnopqrstuvxzwykçÇsQWERTYUIOPASDFGHJKLZXCVBNM´`~!@#$%^&*()_-+={}[]\\|:;<>,.?/" + args;      // criando a lista de teclas permitidas
				var chr= String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
				{
					return true;
				}
				
				// para permitir teclas como <BACKSPACE> adicionamos uma permissão para
				// códigos de tecla menores que 09 por exemplo 
				
				if (valid_chars.indexOf(chr)>-1 || evt < 9)
				{
					return true;
				}
				
				return false;   // do contrário nega
		}
		
		function VerificacaoFinalSenhaAntiga()
		{
			var valorCampo = campoSenhaAntiga.value;
			var valorFiltrado = "";
			var quant = 0;
			var filtro = "0123456789abcdefghijlmnopqrstuvxzwykçÇsQWERTYUIOPASDFGHJKLZXCVBNM´`~!@#$%^&*()_-+={}[]\\|:;<>,.?/";
				
			for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
			{
				if (filtro.indexOf(valorCampo.charAt(cont)) != -1)
				{
					valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
				}
			}
			
			campoSenhaAntiga.value = valorFiltrado;
		}

		campoSenhaAntiga.onblur = function()
		{
			VerificacaoFinalSenhaAntiga();
			verificarSenhaAntiga();
		}
		
		var campoSenha = document.querySelector("#passNew");

		campoSenha.onfocus = function()
		{
			campoSenha.style.border = "2px solid blue";
		}

		campoSenha.onkeypress = function(e,args)
		{
			if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = "0123456789abcdefghijlmnopqrstuvxzwykçÇsQWERTYUIOPASDFGHJKLZXCVBNM´`~!@#$%^&*()_-+={}[]\\|:;<>,.?/" + args;      // criando a lista de teclas permitidas
				var chr= String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
				{
					return true;
				}
				
				// para permitir teclas como <BACKSPACE> adicionamos uma permissão para
				// códigos de tecla menores que 09 por exemplo 
				
				if (valid_chars.indexOf(chr)>-1 || evt < 9)
				{
					return true;
				}
				
				return false;   // do contrário nega
		}

		function VerificacaoFinalSenha()
		{
			var valorCampo = campoSenha.value;
			var valorFiltrado = "";
			var quant = 0;
			var filtro = "0123456789abcdefghijlmnopqrstuvxzwykçÇsQWERTYUIOPASDFGHJKLZXCVBNM´`~!@#$%^&*()_-+={}[]\\|:;<>,.?/";
				
			for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
			{
				if (filtro.indexOf(valorCampo.charAt(cont)) != -1)
				{
					valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
				}
			}
			
			campoSenha.value = valorFiltrado;
		}

		function verificarSenha()
		{
			if (campoSenha.value.length >=6 && campoSenha.value.length <= 12)
			{
				campoSenha.style.border = "2px solid green";
				camposCorretosSenha[1] = 1;
			}
			else
			{
				campoSenha.style.border = "2px solid red";
				camposCorretosSenha[1] = 0;
			}
		}

		campoSenha.onblur = function()
		{
			VerificacaoFinalSenha();
			verificarSenha();
		}

		var campoConfirmaSenha = document.querySelector("#passNewConfirma");

		campoConfirmaSenha.onfocus = function()
		{
			campoConfirmaSenha.style.border = "2px solid blue";
		}

		campoConfirmaSenha.onkeypress = function(e,args)
		{
			if (document.all) // caso seja IE
				{
					var evt=event.keyCode;
				}			
				else // do contrário deve ser Mozilla ou Google
				{
					var evt = e.charCode;
				}
				
				var valid_chars = "0123456789abcdefghijlmnopqrstuvxzwykçÇsQWERTYUIOPASDFGHJKLZXCVBNM´`~!@#$%^&*()_-+={}[]\\|:;<>,.?/" + args;      // criando a lista de teclas permitidas
				var chr= String.fromCharCode(evt);      // pegando a tecla digitada
				
				if (valid_chars.indexOf(chr)>-1 ) // se a tecla estiver na lista de permissão permite-a
				{
					return true;
				}
				
				// para permitir teclas como <BACKSPACE> adicionamos uma permissão para
				// códigos de tecla menores que 09 por exemplo 
				
				if (valid_chars.indexOf(chr)>-1 || evt < 9)
				{
					return true;
				}
				
				return false;   // do contrário nega
		}

		function VerificacaoFinalConfirmaSenha()
		{
			var valorCampo = campoConfirmaSenha.value;
			var valorFiltrado = "";
			var quant = 0;
			var filtro = "0123456789abcdefghijlmnopqrstuvxzwykçÇsQWERTYUIOPASDFGHJKLZXCVBNM´`~!@#$%^&*()_-+={}[]\\|:;<>,.?/";
				
			for (cont = 0; cont <= valorCampo.length - 1; cont = cont + 1)
			{
				if (filtro.indexOf(valorCampo.charAt(cont)) != -1)
				{
					valorFiltrado = valorFiltrado + valorCampo.charAt(cont);
				}
			}
			
			campoConfirmaSenha.value = valorFiltrado;
		}

		function verificarConfirmaSenha()
		{
			if (campoConfirmaSenha.value == campoSenha.value && campoSenha.value != "")
			{
				campoConfirmaSenha.style.border = "2px solid green";
				camposCorretosSenha[2] = 1;
			}
			else
			{
				campoConfirmaSenha.style.border = "2px solid red";
				camposCorretosSenha[2] = 0;
			}
		}

		campoConfirmaSenha.onblur = function()
		{
			VerificacaoFinalConfirmaSenha();
			verificarConfirmaSenha();
		}
		
		function verificarSenhaDel()
		{
			if (confirmarSenhaDel.value == base64_decode("<?php echo $linha_Busca['cd_senha']; ?>"))
			{
				confirmarSenhaDel.style.border = "3px solid green";
				return true;
			}
			else
			{
				confirmarSenhaDel.style.border = "3px solid red";
				return false;
			}
		}
		
		confirmarSenhaDel.onfocus = function()
		{
			confirmarSenhaDel.style.border = "3px solid blue";
		}
		
		confirmarSenhaDel.onblur = function()
		{
			verificarSenhaDel();
		}
		
		btn_desativar.onclick = function()
		{
			aux = verificarSenhaDel();
			
			if (aux == true)
			{
				window.location.href = "php/DesativarConta.php?codigoUsuario=<?php echo $codigo; ?>";
			}
		}
		
		window.onclick = function()
		{
			parent.desativarMenu();
		}
	</script>
	<script type="text/javascript" src="script/Editar - Validação.js" onload="Mascara();"></script>
</html>

<?php
	mysql_close($conexao);
?>	