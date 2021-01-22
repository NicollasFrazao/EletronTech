<meta charset="UTF-8">
<?php
	include "php/Conexao.php";
	
	mysql_set_charset('utf8');
	ini_set('default_charset','UTF-8');
	
	session_start();
	if((!isset ($_SESSION['EletronTech']['login']) == true) and (!isset ($_SESSION['EletronTech']['senha']) == true)) 
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
	}
	
	$op = 0;
	$valorBusca = "";
	
	if (isset($_POST['buscar']))
	{
		if ($_POST['op'] == 1)
		{
			$valorBusca = mysql_escape_string($_POST['valorBusca']);
		
			$query_Busca = "select * from tb_usuario 
								where nm_usuario like '%$valorBusca%'";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
			
		}
		else if ($_POST['op'] == 2)
		{
			$valorBusca = mysql_escape_string($_POST['valorBusca']);
		
			$query_Busca = "select * from tb_usuario 
								where cd_usuario like '$valorBusca'";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		else if ($_POST['op'] == 3)
		{
			$valorBusca = mysql_escape_string($_POST['valorBusca']);
		
			$query_Busca = "select * from tb_usuario 
								where nm_email like '%$valorBusca'%";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		else if ($_POST['op'] == 4)
		{
			$valorBusca = mysql_escape_string($_POST['valorBusca']);
		
			$query_Busca = "select * from tb_usuario 
								where cd_cpf like '%$valorBusca%'";
				
			$result_Busca = mysql_query($query_Busca) or die(mysql_error());
			$linha_Busca = mysql_fetch_assoc($result_Busca);
			$totalLinha_Busca = mysql_num_rows($result_Busca);
		}
		
	}
	else
	{
		$query_Busca = "select * from tb_usuario";
			
		$result_Busca = mysql_query($query_Busca) or die(mysql_error());
		$linha_Busca = mysql_fetch_assoc($result_Busca);
		$totalLinha_Busca = mysql_num_rows($result_Busca);
	}
	
	/*if (isset($_POST['buscar']))
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
		$query_Busca = "select * from tb_usuario";
			
		$result_Busca = mysql_query($query_Busca) or die(mysql_error());
		$linha_Busca = mysql_fetch_assoc($result_Busca);
		$totalLinha_Busca = mysql_num_rows($result_Busca);
	}*/
	
	
?>
<html>
	<head>
		<title>Área Administrativa</title>
	</head>
	<style>
		*
		{
			margin: 0px;
			padding: 0px;
		}
		
		body
		{
			background-color: transparent;
		}
		
		#user
		{
			display: inline-block;
			position:relative;
			background-color: black;
			width: 750px;
			color: white;
			font-family: Century Gothic;
			opacity: 0.9;
			left:50%;
			margin-left: -400px;
			margin-top: 70px;
			margin-bottom: -65px;
		}
		
		#user h1
		{
			display: inline-block;
			font-size: 32px;
			color: #40c1f2;
			font-weight: bold;
			margin-left: 20px;
			margin-bottom: 10px;
		}
		
		#user label
		{
			font-size: 14px;
			color:white;
			margin-left:20px;
			font-weight: bold;
		}
		
		#user #data
		{
			font-size: 14px;
			color:white;
			font-weight: normal;
			margin-left:20px;
		}
		
		td
		{
			height: 10px;
		}
		
		#imgUser
		{
			background-color: #5a5a5a;
			width: 200px;
			height: 200px;
			margin-left: 20px;
			margin-right: 5px;
		}
		
		#btn_editar
		{
			margin-left: 20px;
			width: 40px;
		}
		
		#btn_excluir
		{
			width: 40px;
		}
		
		#btn_ativarDesativar
		{
			width: 40px;
		}
		
		#barraBusca
		{
			display: inline-block;
			height: 40px;
			width: 655px;
			font-size: 20px;
			font-family: Century Gothic;
			border: 2px solid black;
			background-color: black;
			margin-right: 5px;
			color: white;
			padding: 5px;
		}
		
		
		#Frm_Busca
		{
			width: 750px;
			height: 40px;
			margin-left: -400px;
			left: 50%;
			position: absolute;
			margin-bottom: -50px;
		}
		
		#btn_busca, #btn_limpar, #btn_gerar
		{
			width:40px;
			background-color: #1492df;
		}
		
		#btn_limpar, #btn_gerar
		{
			margin-left:5px;
			background-color: #474747;
		}
		
		h1
		{
			font-family: Century Gothic;
			color: black;
			
		}
		
		#User #EE
		{
			position: absolute;
			margin-top:12px;
			margin-left: -50px;
			font-family: Century Gothic;
			font-size: 18px;
		}
	</style>
	<body onload="setTimeout('window.location.reload()', 300000);">
		<form id="Frm_Busca" method="POST" onsubmit="if ((rdb_op_codigo.checked == true || rdb_op_nome.checked == true || rdb_op_email.checked == true || rdb_op_cpf.checked == true) && txt_gerar.value == 0 && barraBusca.value != '') {return true;} else {return false;}">
			<label>
				</br>
			</label>
			<table>
				<tr>
					<td>
						<input id="barraBusca" type="text" name="valorBusca">
					</td>
					<td>
						<input id="btn_busca" type="image" value="Buscar" name="buscar" src="busca.png">
					</td>
					<td>
						<input id="btn_limpar" type="image" value="Limpar" onclick="window.location.href = 'Administrativo.php';" src="limpar.png">
					</td>
					<td>
						<input id="btn_gerar" type="image" value="Gerar Log" onclick="txt_gerar.value = 1; window.location.href = 'php/GerarRelacao.php?tipo=' + txt_tipo.value + '&valorBusca=' + txt_buscaTXT.value;" src="download.png">
					</td>
				</tr>
				<tr>
					<td>
						<input type="radio" name="op" id="rdb_op_nome" value="1"><label id="lbl_op_nome">Nome</label>
						<input type="radio" name="op" id="rdb_op_codigo" value="2"><label id="lbl_op_codigo">Código</label>
						<input type="radio" name="op" id="rdb_op_email" value="3"><label id="lbl_op_email">Email</label>
						<input type="radio" name="op" id="rdb_op_cpf" value="4"><label id="lbl_op_cpf">CPF</label>
						<input type="hidden" name="tipoBusca" id="txt_tipo" value="<?php if (isset($_POST['buscar'])) {echo $_POST['op'];} else {echo $op;}?>">
						<input type="hidden" name="valorBuscaTXT" id="txt_buscaTXT" value="<?php echo $valorBusca; ?>">
						<input type="hidden" name="gerar" id="txt_gerar" value="0">
						
						<?php
							if (isset($_POST['op']))
							{
								if (isset($valorBusca))
								{
									if ($_POST['op'] == 1 && $valorBusca != "")
									{
										echo '<script> rdb_op_nome.checked = true; </script>';								
									}
									else if ($_POST['op'] == 2 && $valorBusca != "")
									{
										echo '<script> rdb_op_codigo.checked = true; </script>';	
									}
									else if ($_POST['op'] == 3 && $valorBusca != "")
									{
										echo '<script> rdb_op_email.checked = true; </script>';	
									}
									else if ($_POST['op'] == 4 && $valorBusca != "")
									{
										echo '<script> rdb_op_cpf.checked = true; </script>';	
									}
									else if ($op == 0 && $valorBusca == "")
									{
										echo '<script> 
												rdb_op_nome.checked = false; 
												rdb_op_codigo.checked = false;
												rdb_op_email.checked = false; 
												rdb_op_cpf.checked = false;
											</script>';
									}
								}
								else
								{
									echo '<script> 
											rdb_op_nome.checked = false; 
											rdb_op_codigo.checked = false;
										</script>';
								}
							}
						?>
					</td>
				</tr>
			</table>
		</form>
		</br>
		<?php
			do
			{
		?>
				<div id="user">
					<table>
					</br>
						<h1><?php echo $linha_Busca['nm_usuario']; ?></h1>
						
						<tr>
							
							<td rowspan="10">
								<img id="imgUser" src="<?php if ($linha_Busca['im_usuario'] == "") {echo "usuario.png";} else {echo "../".$linha_Busca['im_usuario'];} ?>">
							</td>
						</tr>
						<tr>
							<td>
								<label>Documento (CPF)</label>
							</td>
							<td>
								<label id="data"><?php echo $linha_Busca['cd_cpf']; ?></label>
							</td>
						</tr>
						
						<tr>
							<td>
								<label>Data de Nascimento</label>
							</td>
							<td>
								<label id="data"><?php echo $linha_Busca['cd_datanas']; ?></label>
							</td>
						</tr>
						
						<tr>
							<td>
								<label>Telefone</label>
							</td>
							<td>
								<label id="data"><?php echo $linha_Busca['cd_telefone1']; ?></label>
							</td>
						</tr>
						
						<tr>
							<td>
								<label>Telefone 2</label>
							</td>
							<td>
								<label id="data"><?php echo $linha_Busca['cd_telefone2']; ?></label>
							</td>
						</tr>
						
						<tr>
							<td>
								<label>Sexo</label>
							</td>
							<td>
								<label id="data"><?php echo $linha_Busca['nm_sexo']; ?></label>
							</td>
						</tr>
						
						<tr>
							<td>
								<label>Email</label>
							</td>
							<td>
								<label id="data"><?php echo $linha_Busca['nm_email']; ?></label>
							</td>
						</tr>
						
						<tr>
							<td>
								<label>Senha</label>
							</td>
							<td>
								<label id="data"><?php echo $linha_Busca['cd_senha']; ?></label>
							</td>
						</tr>
						
						<tr>
							<td>
								<label>Usuário/Administrador</label>
							</td>
							<td>
								<label id="data"><?php if ($linha_Busca['ic_admin'] == 1) {echo "Sim";} else {echo "Não";} ?></label>
							</td>
						</tr>
						<tr>
							<td>
								<label>Código de Usuário</label>
							</td>
							<td>
								 <label id="data"><?php echo $linha_Busca['cd_usuario']; ?></label>
							</td>
						</tr>
						<tr>
							<td align="right">
								<label id="EE">2</label>
								<a id="b1" href="php/Editar.php?codigo=<?php echo $linha_Busca['cd_usuario']; ?>" target="_blank"><input id="btn_editar" type="image" src="edit.png" /></a>
								
								<?php
									if ($linha_Busca['ic_admin'] != 1)
									{
								?>
										<a href="php/AtivarDesativar.php?codigo=<?php echo $linha_Busca['cd_usuario']; ?>"><input id="btn_ativarDesativar" type="image" src="del.png"/></a>
									
										<a href="php/Excluir.php?codigo=<?php echo $linha_Busca['cd_usuario']; ?>"><input id="btn_excluir" type="image" src="del.png"/></a>
								<?php
									}
								?>
							</td>
						</tr>
					</table>
				</div>
				</br>
		<?php
			}
			while ($linha_Busca = mysql_fetch_assoc($result_Busca));
		?>
	</body>
	
</html>

<?php
	mysql_close($conexao);
?>