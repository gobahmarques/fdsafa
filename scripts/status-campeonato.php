<?php
	include "../enderecos.php";
	include "../session.php";	
	mysqli_query($conexao, "UPDATE campeonato SET status = ".$_POST['status']." WHERE codigo = ".$_POST['campeonato']." ");

	mysqli_query($conexao, "INSERT INTO log_campeonato VALUES (NULL, ".$usuario['codigo'].", '".date("Y-m-d H:i:s")."', 'Encerramento das inscrições', ".$_POST['campeonato'].")");

	$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_POST['campeonato'].""));

	switch($_POST['status']){
		case '1': // TORNEIO INICIADO
			$msg = "<li>Foi dada a largada. O torneio <strong>".$campeonato['nome']."</strong> está oficialmente iniciado.</li>";
			break;
		case '2': // TORNEIO FINALIZADO
			$msg = "<li>O torneio <strong>".$campeonato['nome']."</strong> foi finalizado. A premiação será entregue pela organização de acordo com o descrito em seu regulamento. Se houver premiação de e$, ela será entregue em até 3 dias.</li>";
			break;
		case '3': // TORNEIO CANCELADO
			$msg = "<li>Más notícias. Infelizmente o torneio <strong>".$campeonato['nome']."</strong> foi cancelado. Mas continue treinando com a gente, torneio é o que não falta por aqui.</li>";
			break;
		case '4': // EXCLUIR TORNEIO
			$msg = "<li>O torneio <strong>".$campeonato['nome']."</strong> foi cancelado. Mas continue treinando com a gente, torneio é o que não falta por aqui.</li>";
			$partidas = mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_campeonato = ".$campeonato['codigo']." ");
			while($partida = mysqli_fetch_array($partidas)){
				mysqli_query($conexao, "DELETE FROM campeonato_partida_chat WHERE cod_partida = ".$partida['codigo']." ");
				mysqli_query($conexao, "DELETE FROM campeonato_partida_checkin WHERE cod_partida = ".$partida['codigo']." ");
				mysqli_query($conexao, "DELETE FROM campeonato_partida_resultado WHERE cod_partida = ".$partida['codigo']." ");
				mysqli_query($conexao, "DELETE FROM campeonato_partida_semente WHERE cod_partida = ".$partida['codigo']." ");
				mysqli_query($conexao, "DELETE FROM campeonato_partida WHERE codigo = ".$partida['codigo']." ");				
			}
			mysqli_query($conexao, "DELETE FROM campeonato_premiacao WHERE cod_campeonato = ".$campeonato['codigo']." ");
			mysqli_query($conexao, "DELETE FROM campeonato_lineup WHERE cod_campeonato = ".$campeonato['codigo']." ");
			mysqli_query($conexao, "DELETE FROM campeonato_feedback WHERE cod_campeonato = ".$campeonato['codigo']." ");
			mysqli_query($conexao, "DELETE FROM campeonato_etapa_semente WHERE cod_campeonato = ".$campeonato['codigo']." ");
			mysqli_query($conexao, "DELETE FROM campeonato_etapa_grupo WHERE cod_campeonato = ".$campeonato['codigo']." ");
			mysqli_query($conexao, "DELETE FROM campeonato_etapa WHERE cod_campeonato = ".$campeonato['codigo']." ");
			mysqli_query($conexao, "DELETE FROM campeonato_draft WHERE cod_campeonato = ".$campeonato['codigo']." ");
			mysqli_query($conexao, "DELETE FROM campeonato_colocacao WHERE cod_campeonato = ".$campeonato['codigo']." ");
			mysqli_query($conexao, "DELETE FROM campeonato_checkin WHERE cod_campeonato = ".$campeonato['codigo']." ");
			
			if($campeonato['valor_escoin'] > 0){
				$inscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." ");
				while($inscricao = mysqli_fetch_array($inscricoes)){
					mysqli_query($conexao, "UPDATE jogador SET pontos = pontos + ".$campeonato['valor_escoin']." WHERE codigo = ".$inscricao['cod_jogador']."");
					mysqli_query($conexao, "INSERT INTO log_coin VALUES (NULL, ".$inscricao['cod_jogador'].", ".$campeonato['valor_escoin'].", 'Devolução de inscrição campeonato: <strong>".$campeonato['nome']."</strong>', 1, '".date("Y-m-d H:i:s")."')");
				}
			}elseif($campeonato['valor_real'] > 0){
				$inscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." ");
				while($inscricao = mysqli_fetch_array($inscricoes)){
					mysqli_query($conexao, "UPDATE jogador SET saldo = saldo + ".$campeonato['valor_real']." WHERE codigo = ".$inscricao['cod_jogador']."");
					mysqli_query($conexao, "INSERT INTO log_real VALUES (NULL, ".$inscricao['cod_jogador'].", ".$campeonato['valor_real'].", 'Devolução de inscrição campeonato: <strong>".$campeonato['nome']."</strong>', 1, '".date("Y-m-d H:i:s")."')");
				}
			}
			
            mysqli_query($conexao, "DELETE FROM campeonato_inscricao_deckstring WHERE cod_campeonato = ".$campeonato['codigo']." ");
			mysqli_query($conexao, "DELETE FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." ");			
			mysqli_query($conexao, "DELETE FROM log_campeonato WHERE cod_campeonato = ".$campeonato['codigo']." ");
			mysqli_query($conexao, "DELETE FROM campeonato WHERE codigo = ".$campeonato['codigo']." ");
			break;
	}

	if($campeonato['tipo_inscricao'] == 0){
		$destinos = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']."");
	}else{
		$destinos = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$campeonato['codigo']." ");
	}
	
	if($_POST['status'] != 0){
		while($destino = mysqli_fetch_array($destinos)){
			mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '".$msg."', ".$destino['cod_jogador'].", 0)");
		}
	}
?>