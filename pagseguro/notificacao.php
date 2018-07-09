<?php
	header("access-control-allow-origin: https://pagseguro.uol.com.br");
	require_once("PagSeguro.class.php");

	if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){
		$PagSeguro = new PagSeguro();
		$response = $PagSeguro->executeNotification($_POST);
		if( $response->status==3 || $response->status==4 ){
        	include "../conexao-banco.php";
			$transacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador_pagamentos WHERE codigo = '".$response->reference."'"));
			if($transacao['status'] == 0){
				mysqli_query($conexao, "UPDATE jogador SET saldo = saldo + ".$transacao['valor']." WHERE codigo = ".$transacao['cod_jogador']."");
				mysqli_query($conexao, "INSERT INTO log_real VALUES (NULL, ".$transacao['cod_jogador'].", ".$transacao['valor'].", 'Saldo adicionado Carteira eSC', 1, '".date("Y-m-d H:i:s")."')");
				mysqli_query($conexao, "UPDATE jogador_pagamentos SET status = 1, cod_transacao = '".$response->code."' WHERE codigo = ".$transacao['codigo']." ");
			}			
		}else{
			//PAGAMENTO PENDENTE
			echo $PagSeguro->getStatusText($PagSeguro->status);
		}
	}
?>