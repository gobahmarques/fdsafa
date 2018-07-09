<?php
	include "../../session.php";	

	$produto = $_POST['produto'];
	$endereco = $_POST['endereco'];
	$valor = $_POST['valor'];
	$data = date("Y-m-d");
	$datahora = date("Y-m-d H:i:s");
	

	$verificarCupom = mysqli_query($conexao, "SELECT * FROM produto_cupom WHERE cod_produto = $produto AND cod_jogador = ".$usuario['codigo']." AND status = 0 ");
	if(mysqli_num_rows($verificarCupom) != 0){
		$cupom = mysqli_fetch_array($verificarCupom);
		mysqli_query($conexao, "UPDATE produto_cupom SET status = 1, datahora = '$datahora' WHERE codigo = ".$cupom['codigo']."");
	}else{
		mysqli_query($conexao, "UPDATE jogador SET pontos = pontos - $valor WHERE codigo = ".$usuario['codigo']."");		
	}
	mysqli_query($conexao, "INSERT INTO pedido VALUES (NULL, ".$_SESSION['codigo'].", '$data', NULL, $endereco, $valor, $produto, NULL)");
	$pedido = mysqli_insert_id($conexao);

	if(isset($_POST['instrucao'])){
		mysqli_query($conexao, "UPDATE pedido SET instrucao = '".$_POST['instrucao']."' WHERE codigo = $pedido");
	}