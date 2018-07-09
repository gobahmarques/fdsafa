<?php
	$servidor = "mysql.esportscups.com.br";
	$usuario = "esportscups";
	$senha = "parede2209azul";
	$banco = "esportscups";
	$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
	
	mysqli_select_db($conexao, $banco);
	mysqli_query($conexao, "SET NAMES 'utf8'");
	mysqli_query($conexao,'SET character_set_connection=utf8');
	mysqli_query($conexao,'SET character_set_client=utf8');
	mysqli_query($conexao,'SET character_set_results=utf8');	
?>