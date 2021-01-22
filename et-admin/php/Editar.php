<?php
	include "conexao.php";
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	session_start();
	if((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
	{ 
		unset($_SESSION['EletronTech']);
		header('location:../../'); 
	}
	else
	{
		if ($_SESSION['EletronTech']['admin'] == 0)
		{
			header('location:../../EletronTech.php'); 
		}
	}
	
	if (!isset($_GET['codigo']))
	{
		header('location:../'); 
	}
	
	$codigo = mysql_escape_string($_GET['codigo']);
	
	$query_Busca = "select * from tb_usuario 
							where cd_usuario = '$codigo'";
			
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>Atualização de Dados</title>
		<style>
			#juridica{
				display: none;
			}
			
			body
			{
				background-attachment: fixed;
				background-repeat: no-repeat;
				background-color:black;
				color: white;
				font-size: 14px;
				font-family: Century Gothic;
			}
			
			#fisica
			{
				background-color: black;
				position: absolute;
				padding: 30px;
				padding-left: 30px;
				padding-top: 50px;
				top: 1%;
				left:50%;
				opacity: 0.8;
				height: 87%;
				width: 370px;
			}
			
			#fisica input
			{
				display: inline-block;
				width: 100%;
				height: 30px;
				padding: 5px;
				vertical-align: middle;
				font-size: 14px;
				font-family: Century Gothic;
				margin-right: 10px;
			}
			
			#fisica select
			{
				width: 100%;
				height: 30px;
				padding: 5px;
				font-size: 14px;
				font-family: Century Gothic;
			}
			
			#fisica #rdb_sexo_marculino, #fisica #rdb_sexo_feminino
			{
				height: 15px;
				position: relative;
				margin-top: -17px;
			}
			
			#fisica label
			{
				font-size: 14px;
			}
			
			#fisica #btn_limpar, #fisica #btn_enviar
			{
				border: 0px;
				background-color: #0ca3ff;
				color: black;
				outline: none;
				width: 48%;
				margin: 0;
			}
			
			#fisica #btn_enviar
			{
				width: 100%;
				font-weight: bold;
			}
			
			#fisica #btn_limpar
			{
				background-color: transparent;
				color: white;
				width: 30%;
				font-size: 12px;
			}
			
			#btn_limpar:active, #btn_enviar:active
			{
				background-color: #201f1f;
				color: white;
				
			}
			
			#tit
			{
				font-size: 18px;
			}
			
			h1
			{
				font-size:12px;
			}
			
			#fundo
			{
				display: inline-block;
				width: 450px;
				height: 500px;
				position: absolute;
				top: 50%;
				margin-top: -290px;
				margin-left: -440px;
				left:50%;
			}
			
			#npass
			{
				width: 30px;
			}
			
			#fundo h1
			{
				font-size: 30px;
				color: #0b68ae;
			}
			
			#fundo img
			{
				width: 400px;
			}
			
			#Frm_Fisica
			{
				position: absolute;
				width: 420px;
				height: 550px;
				top: 50%;
				margin-top: -280px;
			}
		</style>
	</head>
	<body>
		<form id="Frm_Fisica" method="POST" action="Atualizar.php" enctype="multipart/form-data">
			<table>
				<tr>
					<td colspan="2">
						<h1 id="tit">Dados pessoais</h1>
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<label>Nome completo</label>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input value="<?php echo $linha_Busca['nm_usuario']; ?>" name="nome" type="text" id="txt_nome" required>
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
						<input value="<?php echo $linha_Busca['cd_datanas']; ?>" name="datanas" type="text" id="txt_datanas_fisica" maxlength="10" placeholder="DD/MM/AAAA" disabled required>
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
						<input value="<?php echo $linha_Busca['cd_telefone1']; ?>" name="telefone1" type="text" id="txt_telefone1_fisica" required>
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
									<select id="cmb_tipo_tel2_fisica" name="tipo_telefone2" >
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
						<input value="<?php echo $linha_Busca['cd_telefone2']; ?>" name="telefone2" type="text" id="txt_telefone2_fisica" >
					</td>
				</tr>

				<?php
					if ($linha_Busca['nm_sexo'] == "Masculino")
					{
						echo '<tr>
								<td id="sexo">
								</br>
									<label>Sexo</label>
								</td>
							</tr>
							<tr>
								<td>
									<label id="sexo">Masculino</label>
									<input id="rdb_sexo_marculino" type="radio" name="sexo" value="Masculino" checked="true">
								</td>
								<td>
									<label id="sexo">Feminino</label>
									<input id="rdb_sexo_feminino" type="radio" name="sexo" value="Feminino">
								</td>
							</tr>';
					}
					else if ($linha_Busca['nm_sexo'] == "Feminino")
					{
						echo '<tr>
								<td id="sexo">
								</br>
									<label>Sexo</label>
								</td>
							</tr>
							<tr>
								<td>
									<label id="sexo">Masculino</label>
									<input id="rdb_sexo_marculino" type="radio" name="sexo" value="Masculino">
								</td>
								<td>
									<label id="sexo">Feminino</label>
									<input id="rdb_sexo_feminino" type="radio" name="sexo" value="Feminino" checked="true">
								</td>
							</tr>';
					}
					else
					{
						echo '<tr>
								<td id="sexo">
								</br>
									<label>Sexo</label>
								</td>
							</tr>
							<tr>
								<td>
									<label id="sexo">Masculino</label>
									<input id="rdb_sexo_marculino" type="radio" name="sexo" value="Masculino">
								</td>
								<td>
									<label id="sexo">Feminino</label>
									<input id="rdb_sexo_feminino" type="radio" name="sexo" value="Feminino">
								</td>
							</tr>';
					}
					
					if ($linha_Busca['ic_admin'] == "1")
					{
						echo '<tr>
								<td id="Admin">
								</br>
									<label>Admin</label>
								</td>
							</tr>
							<tr>
								<td>
									<label id="admin_sim">Sim</label>
									<input id="rdb_admin_sim" type="radio" name="admin" value="1" checked="true">
								</td>
								<td>
									<label id="admin_nao">Não</label>
									<input id="rdb_admin_nao" type="radio" name="admin" value="0">
								</td>
							</tr>';
					}
					else
					{
						echo '<tr>
								<td id="Admin">
								</br>
									<label>Admin</label>
								</td>
							</tr>
							<tr>
								<td>
									<label id="admin_sim">Sim</label>
									<input id="rdb_admin_sim" type="radio" name="admin" value="1">
								</td>
								<td>
									<label id="admin_nao">Não</label>
									<input id="rdb_admin_nao" type="radio" name="admin" value="0" checked="true">
								</td>
							</tr>';
					}
				?>

				<tr>
					<td colspan="2">
						<label>Foto de Perfil</label>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input name="foto" type="file" id="im_foto" required>
					</td>
				</tr>
				
			</table></br>
			<table>
				<tr>
					<td colspan="2">
						<h1 id="tit">Dados de acesso ao EletronTech</h1>
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<label>E-mail</label>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input value="<?php echo $linha_Busca['nm_email']; ?>" name="email" type="text" id="txt_email" placeholder="Apenas letras minusculas" required>
					</td>
				</tr>

				<tr>
					<td>
						<label>Senha Antiga</label>
					</td>					
				</tr>

				<tr>
					<td>
						<input type="password" id="txt_senha_antiga" placeholder="" name="senha_antiga"maxlength="12">
					</td>
					
				</tr>
				
				<tr>
					<td>
						<label>Nova Senha</label>
					</td>
					<td>
						<label>Confirmar Nova Senha</label>
					</td>
					
				</tr>

				<tr>
					<td>
						<input name="senha" type="password" id="txt_senha" placeholder="" maxlength="12">
					</td>
					<td>
						<input type="password" id="txt_conf_senha" placeholder="" maxlength="12">
					</td>
					
				</tr>
				
				<tr>
					<td>
						<input value="<?php echo $linha_Busca['cd_usuario']; ?>" name="codigo" type="hidden" id="txt_cdigo" placeholder="" maxlength="12" required>
					</td>
					<td>
						<input value="<?php echo $linha_Busca['cd_senha']; ?>" type="hidden" id="txt_senha_antiga_banco" placeholder="" maxlength="12" required>
					</td>					
				</tr>
				
				<tr>
					<td>
						<h1 id="npass"></h1>
					</td>
					<td align="right">
						<!--<input type="reset" value="Limpar" id="btn_limpar" onclick="LimparBorda();"></input>-->
						<input type="button" value="Atualizar" id="btn_enviar" onclick="Validar();"></input>
					</td>
				</tr>
			</table>
			</form>
		<script type="text/javascript" src="script/Editar - Validação.js"  onload="Zerar(); Mascara();"></script>
	</body>
</html>

<?php
	mysql_close($conexao);
?>