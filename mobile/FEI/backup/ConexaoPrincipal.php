<?php
	$host = 'localhost';
	$user = '***REMOVED***';
	$pass = '***REMOVED***';
	$banco = 'anyte539_anytech';

	$conexaoPrincipal = new Conexao();
	$conexaoPrincipal -> AbrirConexao($host, $user, $pass, $banco);
?>