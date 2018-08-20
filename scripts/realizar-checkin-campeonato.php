ses<?php
	include "../conexao-banco.php";

	$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_POST['campeonato'].""));
	$datahora = date("Y-m-d H:i:s");

	if($campeonato['valor_escoin'] > 0){
		mysqli_query($conexao, "UPDATE organizacao SET saldo_coin = saldo_coin + ".$campeonato['valor_escoin']." WHERE codigo = ".$campeonato['cod_organizacao']." ");
		mysqli_query($conexao, "INSERT INTO log_coin_organizacao VALUES (NULL, ".$campeonato['cod_organizacao'].", ".$_POST['jogador'].", ".$campeonato['valor_escoin'].", 'Inscrição campeonato: <strong>".$campeonato['nome']."</strong>', 1, '$datahora')");
	}
	mysqli_query($conexao, "UPDATE campeonato_inscricao SET status = 1 WHERE cod_campeonato = ".$_POST['campeonato']." AND cod_jogador = ".$_POST['jogador']." ");
	
?>