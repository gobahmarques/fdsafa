<?php
	switch($_POST['funcao']){
		case "comprarCupom":
			include "../session.php";
			$jogador = mysqli_fetch_array(mysqli_query($conexao, "SELECT codigo, pontos, saldo FROM jogador WHERE codigo = ".$_POST['jogador']." "));
			$rifa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM rifa WHERE codigo = ".$_POST['numRifa']." "));
			
			if($_POST['tipoPagamento'] == 0){ // COMPRAR COM eSCoin			
				if($jogador['pontos'] >= $rifa['preco_coin']){ // JOGADOR POSSUI SALDO FAZER COMPRA.					
					$pesquisaCupom = mysqli_query($conexao, "SELECT * FROM rifa_cupom WHERE cod_rifa = ".$rifa['codigo']." AND codigo = ".$_POST['numCupom']."");
					$pesquisaCupom = mysqli_num_rows($pesquisaCupom);
					
					if($pesquisaCupom == 0){
						mysqli_query($conexao, "UPDATE jogador SET pontos = pontos - ".$rifa['preco_coin']." WHERE codigo = ".$jogador['codigo']." ");
						
						mysqli_query($conexao, "INSERT INTO log_coin VALUES (NULL, ".$jogador['codigo'].", ".$rifa['preco_coin'].", 'Cupom <strong>".$_POST['numCupom']."</strong> ".$rifa['nome']."', 0, '".date('Y-m-d H:i:s')."')");
						
						mysqli_query($conexao, "INSERT INTO rifa_cupom VALUES (".$_POST['numCupom'].", ".$rifa['codigo'].", ".$jogador['codigo'].", '".date('Y-m-d H:i:s')."', 0, 0)");
					}
					echo 1;
				}else{ // JOGADOR NÃO POSSUI SALDO SUFICIENTE
					echo 0;
				}
			}else{ // COMPRAR COM REAL
				if($jogador['saldo'] >= $rifa['preco_real']){ // JOGADOR POSSUI SALDO FAZER COMPRA.					
					$pesquisaCupom = mysqli_query($conexao, "SELECT * FROM rifa_cupom WHERE cod_rifa = ".$rifa['codigo']." AND codigo = ".$_POST['numCupom']."");
					$pesquisaCupom = mysqli_num_rows($pesquisaCupom);
					
					if($pesquisaCupom == 0){
						mysqli_query($conexao, "UPDATE jogador SET saldo = saldo - ".$rifa['preco_real']." WHERE codigo = ".$jogador['codigo']." ");
						
						mysqli_query($conexao, "INSERT INTO log_real VALUES (NULL, ".$jogador['codigo'].", ".$rifa['preco_real'].", 'Cupom <strong>".$_POST['numCupom']."</strong> ".$rifa['nome']."', 0, '".date('Y-m-d H:i:s')."')");
						
						mysqli_query($conexao, "INSERT INTO rifa_cupom VALUES (".$_POST['numCupom'].", ".$rifa['codigo'].", ".$jogador['codigo'].", '".date('Y-m-d H:i:s')."', 0, 1)");
					}
					echo 1;
				}else{ // JOGADOR NÃO POSSUI SALDO SUFICIENTE
					echo 0;	
				}
			}
			break;
	}
?>