<?php
	if (isset($_GET['email']))
	{
		echo "<script> parent.lbl_mensagem.innerHTML = 'Aguarde...'; parent.btn_OK.disabled = true; </script>";
		
		$email = mysql_escape_string(base64_decode($_GET['email']));
		$dataExpirar = base64_encode(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (60*60*24*2)));
	
		include "Conexao.php";
	
		mysql_set_charset('utf8');
		ini_set('default_charset','UTF-8');
		ini_set("error_reporting",E_ALL);
		
		switch (strtoupper(substr(PHP_OS, 0, 3))) 
		{
			// Windows
			case 'WIN':
			{
				$sistema = "Windows";
				$quebra = "\r\n";
			}
			break;

			// Mac
			case 'DAR':
			{
				$sistema = "Mac";
				$quebra = "\r";
			}
			break;

			// Unix
			default:
			{
				$sistema = "Unix";
				$quebra = "\n";
			}
		}
	}
	else
	{
		$dataExpirar = base64_encode(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (60*60*24*5)));
	}
	
	$query_Busca = "select cd_usuario, nm_usuario
							from tb_usuario
								where nm_email = '$email'";
	
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);
	
	$codigoUsuario = $linha_Busca['cd_usuario'];
	$codigoUsuario = base64_encode($codigoUsuario);
	
	$nomeUsuario = explode(" ", $linha_Busca['nm_usuario']);
	
	$para = $email;
	$assunto = "Confirmação de conta";
	
	$nomeUsuario = $nomeUsuario[0];
	$deNome = "AnyTech - EletronTech";
	$deEmail = "eletrontech@anytech.com.br";
	$senha = "ad.anyeletron";
	$reply = "eletrontech@anytech.com.br";
	
	
	$mensagem = "
				<p>
					Olá $nomeUsuario, estamos por meio desse e-mail para a confirmação de que o e-mail cadastrado no EletronTech é de propriedade sua.
				</p>
				<br/>
				<p>Clique <a href='http://eletrontech.anytech.com.br/php/ConfirmarConta.php?codigo=$codigoUsuario&data=$dataExpirar' target='_blank'>aqui</a> para confirmar sua conta.</p>
				<p>Atenção: Link válido até ".date("d/m/Y H:i:s", strtotime(base64_decode($dataExpirar)))."</p>
				<p>$deNome</p>"; // Codigo HTML
	
	// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
	include("class.phpmailer.php");

	// Inicia a classe PHPMailer
	$mail = new PHPMailer();

	// Define os dados do servidor e tipo de conexão
	$mail->IsSMTP();
	$mail->Host     = "smtp.anytech.com.br";     // Endereço do servidor SMTP
	$mail->SMTPAuth = true;                   // Usa autenticação SMTP? (opcional)
	$mail->Username = $deEmail;  // Usuário do servidor SMTP       
	$mail->Password = $senha;               // Senha do servidor SMTP

	// Define o remetente.
	$mail->From     = $deEmail; // Seu e-mail
	$mail->FromName = $deNome;       // Seu nome

	// Define os destinatário(s)
	$mail->AddAddress($para);
	//$mail->AddCC('3dmaster@uol.com.br', 'Eu'); // Copia
	//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta

	// Define os dados técnicos da Mensagem
	$mail->IsHTML(true); // Define que o e-mail será enviado como HTML

	// Define a mensagem (Texto e Assunto)
	$mail->Subject = $assunto; // Assunto da mensagem
	$mail->Body    = $mensagem;
	$mail->CharSet = 'utf-8';
	$mail->WordWrap = 70;

	// Envia o e-mail
	$enviou = $mail->Send();
	
	if($enviou && isset($_GET['email']))
	{
		echo "<script> parent.lbl_mensagem.innerHTML = 'Confirmação enviada com sucesso! confira sua caixa de entrada para efetuar a confirmação.'; parent.btn_OK.disabled = false; </script>";
	}
	else if ($enviou && !isset($_GET['email']))
	{
		echo "parent.lbl_mensagem.innerHTML = 'Confirmação enviada com sucesso! confira sua caixa de entrada para efetuar a confirmação.'; parent.btn_OK.disabled = false;";
	}
	else
	{
		if(isset($_GET['email']))
		{
			echo "<script> parent.lbl_mensagem.innerHTML = 'A mensagem não pode ser enviada!'; parent.btn_OK.disabled = false;  
			</script>";
		}
		else
		{
			echo "parent.lbl_mensagem.innerHTML = 'A mensagem não pode ser enviada!';parent.btn_OK.disabled = false;";
		}
	}
	
	if (isset($_GET['email']))
	{
		mysql_close($conexao);
	}
?>