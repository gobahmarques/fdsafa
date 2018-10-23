<?php
    date_default_timezone_set("America/Sao_Paulo");
	$servidor = "localhost";
	$usuario = "u719907917_gobah";
	$senha = "parede2209azul";
	$banco = "u719907917_esc";
	$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
	
	mysqli_select_db($conexao, $banco);
	mysqli_query($conexao, "SET NAMES 'utf8'");
	mysqli_query($conexao,'SET character_set_connection=utf8');
	mysqli_query($conexao,'SET character_set_client=utf8');
	mysqli_query($conexao,'SET character_set_results=utf8');	
?>