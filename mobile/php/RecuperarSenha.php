<?php
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
	
	$email = mysql_escape_string($_POST['email']);
	
	$query_Busca = "select nm_usuario, cd_senha 
						from tb_usuario
							where nm_email = '$email'";
		
	$result_Busca = mysql_query($query_Busca) or die(mysql_error());
	$linha_Busca = mysql_fetch_assoc($result_Busca);
	$totalLinha_Busca = mysql_num_rows($result_Busca);
	
	if ($linha_Busca['cd_senha'] != "")
	{
		$nome = explode(" ", $linha_Busca['nm_usuario']);
		$senhaRecuperada = base64_decode($linha_Busca['cd_senha']);
		
		$para = $email;
		$assunto = "Recuperação de Senha";
		
		$aux = $nome[0];
		$deNome = "AnyTech - EletronTech";
		$deEmail = "eletrontech@anytech.com.br";
		$senha = "ad.anyeletron";
		$reply = "eletrontech@anytech.com.br";
		
		$mensagem = "
					<p>
						Olá $aux, estamos por meio desse e-mail para responder sua solicitação de recuperação de senha.
					</p>
					<p>
						Esperamos que você anote um algum lugar para que isso não ocorra novamente.
					</p>
					<br/>
					<p>$deNome</p>
					<p>Sua senha é: <b>$senhaRecuperada</b></p>
					<p>Clique <a href='http://eletrontech.anytech.com.br' target='_blank'>aqui</a> para ir à página de Login.
					"; // Codigo HTML
		
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
		
		if($enviou)
		 echo "Mensagem enviada com sucesso. Clique <a href='../Login.php'>aqui</a> para voltar à página de Login.";
		else
		 echo "A mensagem não pode ser enviada";
	 
	}
	else
	{
		echo "E-mail não cadastrado. Clique <a href='../EsqueceuSenha.php'>aqui</a> para voltar à página de Recuperação de Senha ou <a href='../Login.php'>aqui</a> para voltar à página de Login.";
	}
	
	echo "<p><b>Sistema Operacial</b> - $sistema</p>";
?>

<!Doctype html>

<html>
	<head>
	</head>
	<body>
	</body>
</html>

<?php
	mysql_close($conexao);
?>