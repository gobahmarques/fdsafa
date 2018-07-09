<?php
	require "../../session.php";
	
	$cep = $_POST['cep'];
	$endereco = $_POST['endereco'];
	$numero = $_POST['numero'];
	$complemento = $_POST['complemento'];
	$bairro = $_POST['bairro'];
	$cidade = $_POST['cidade'];
	$estado = $_POST['estado'];
	$pais = $_POST['pais'];

	$inserir = mysqli_query($conexao, "INSERT INTO jogador_enderecos VALUES (NULL, ".$_SESSION['codigo'].", '$cep', '$endereco', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$pais')");

	if($inserir == true){
		echo mysqli_insert_id($conexao);
	}else{
		echo "0";
	}
?>