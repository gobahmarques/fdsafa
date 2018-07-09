<?php
	header("access-control-allow-origin: https://pagseguro.uol.com.br");
	header("Content-Type: text/html; charset=UTF-8", true);
	date_default_timezone_set("America/Sao_Paulo");

	require_once("../pagseguro/PagSeguro.class.php");
	$pagseguro = new PagSeguro();

	require("../session.php");

	// CRIAR PAGAMENTO

	$taxa = round($_POST['valor']*0.0500+0.4, 2);

	$valor = round($_POST['valor'] + $taxa, 2);

	mysqli_query($conexao, "INSERT INTO jogador_pagamentos VALUES (NULL, ".$usuario['codigo'].", NULL, '".date("Y-m-d H:i:s")."', ".$_POST['valor'].", $taxa, 0)");
	$codPagamento = mysqli_insert_id($conexao);

	$endereco = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador_enderecos WHERE cod_jogador = ".$usuario['codigo']." LIMIT 1"));

	$venda = array("codigo"=>"$codPagamento",
				   "valor"=>$valor,
				   "descricao"=>"Adicionar saldo Carteira eSC + taxas PagSeguro",
				   "nome"=>$usuario['nome']." ".$usuario['sobrenome'],
				   "telefone"=>"(61) 9367-6442",
				   "email"=>"".$usuario['email']."",
				   "rua"=>"".$endereco['endereco']."",
				   "numero"=>"".$endereco['numero']."",
				   "bairro"=>"".$endereco['bairro']."",
				   "cidade"=>"".$endereco['cidade']."",
				   "estado"=>"".$endereco['estado']."",
				   "cep"=>"".$endereco['cep']."",
				   "codigo_pagseguro"=>"",
				   "telefone"=>""
				  );

	$pagseguro->executeCheckout($venda, "https://www.esportscups.com.br/ptbr/");
?>