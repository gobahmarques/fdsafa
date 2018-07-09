                                              <?php
	function carregarDraft($picks, $bans, $jogo, $qtdPick){
		$picks = explode(";", $picks);
		$bans = explode (";", $bans);
		$aux = $aux2 = 0;
			
		while($aux < $qtdPick){
			if($picks[$aux] == $bans[$aux2]){
			?>
				<img src="img/draft/<?php echo $jogo."/".$picks[$aux]; ?>2.png" alt="<?php echo $picks[$aux]; ?>" title="<?php echo $picks[$aux]; ?>" height="60px">
			<?php
				$aux++;
				$aux2++;
			}else{
			?>
				<img src="img/draft/<?php echo $jogo."/".$picks[$aux]; ?>.png" alt="<?php echo $picks[$aux]; ?>" title="<?php echo $picks[$aux]; ?>" height="60px">
			<?php
				$aux++;
			}
		}		
	}

	function historicoSementeElimSimples($partida, $lado){		
		include "../conexao-banco.php";		
		if($partida['coluna'] > 1){
			$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$partida['cod_campeonato']." "));
			$colunaPassada = $partida['coluna'] - 1;
			if($lado == 2){
				$linhaPassada = $partida['linha'] * 2;			
			}elseif($lado == 1){			
				$linhaPassada = $partida['linha'] * 2 - 1;
			}		
			$partidaPassada = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida
				WHERE cod_etapa = ".$partida['cod_etapa']."
				AND cod_campeonato = ".$partida['cod_campeonato']."
				AND linha = $linhaPassada
				AND coluna = $colunaPassada
			"));
			$sementeUmPassada = mysqli_fetch_array(mysqli_query($conexao, "
				SELECT * FROM campeonato_partida_semente
				INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
				INNER JOIN jogador ON campeonato_etapa_semente.cod_jogador = jogador.codigo
				WHERE cod_partida = ".$partidaPassada['codigo']." AND lado = 1
			"));
			$sementeDoisPassada = mysqli_fetch_array(mysqli_query($conexao, "
				SELECT * FROM campeonato_partida_semente
				INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
				INNER JOIN jogador ON campeonato_etapa_semente.cod_jogador = jogador.codigo
				WHERE cod_partida = ".$partidaPassada['codigo']." AND lado = 2
			"));

			if(isset($sementeUmPassada) && isset($sementeDoisPassada)){ // DUAS SEMENTES EXISTEM
				if($sementeUmPassadaPassada['cod_equipe'] == NULL){
					$msg = "
						<a href='campeonato/".$partida['cod_campeonato']."/partida/".$partida['codigo']."/'>
							<li>
								Sua próxima partida do campeonato <strong>".$campeonato['nome']."</strong> é contra ".$sementeDoisPassada['nick'].". Só clicar aqui que te levaremos até lá.
							</li>
						</a>
					";
					mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$msg', ".$sementeUmPassada['cod_jogador'].", 0)");
					$msg = "
						<a href='campeonato/".$partida['cod_campeonato']."/partida/".$partida['codigo']."/'>
							<li>
								Sua próxima partida do campeonato <strong>".$campeonato['nome']."</strong> é contra ".$sementeUmPassada['nick'].". Só clicar aqui que te levaremos até lá.
							</li>
						</a>
					";
					mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$msg', ".$sementeDoisPassada['cod_jogador'].", 0)");
				}else{
					$equipeUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$sementeUmPassada['cod_Equipe'].""));
					$equipeDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$sementeDoisPassada['cod_Equipe'].""));
					$lineupUm = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$partida['cod_campeonato']." AND cod_equipe = ".$sementeUmPassada['cod_equipe']."");
					$lineupDois = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$partida['cod_campeonato']." AND cod_equipe = ".$sementeDoisPassada['cod_equipe']."");
					$msg = "
						<a href='campeonato/".$partida['cod_campeonato']."/partida/".$partida['codigo']."/'>
							<li>
								Sua próxima partida do campeonato <strong>".$campeonato['nome']."</strong> pela equipe ".$equipeUm['nome']." será contra ".$equipeDois['nome'].". Só clicar aqui que te levaremos até lá.
							</li>
						</a>
					";
					while($membro = mysqli_fetch_array($lineupUm)){
						mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$msg', ".$membro['cod_jogador'].", 0)");
					}
					$msg = "
						<a href='campeonato/".$partida['cod_campeonato']."/partida/".$partida['codigo']."/'>
							<li>
								Sua próxima partida do campeonato <strong>".$campeonato['nome']."</strong> pela equipe ".$equipeDois['nome']." será contra ".$equipeUm['nome'].". Só clicar aqui que te levaremos até lá.
							</li>
						</a>
					";
					while($membro = mysqli_fetch_array($lineupDois)){
						mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$msg', ".$membro['cod_jogador'].", 0)");
					}
				}
			}
			
			if($partida['coluna'] > 1){
				if(isset($sementeUmPassada)){
					historicoSementeElimSimples($partida, 2);
				}elseif(isset($sementeDoisPassada)){
					historicoSementeElimSimples($partida, 1);
				}else{ //
					historicoSementeElimSimples($partida, 1);
					historicoSementeElimSimples($partida, 2);
				}
			}
		}
	}

	function situacaoOponenteElimSimples($partida){
		include "../conexao-banco.php";
		$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$partida['cod_campeonato'].""));
	 	$sementeUm = mysqli_fetch_array(mysqli_query($conexao, "
			SELECT * FROM campeonato_partida_semente
			INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
			INNER JOIN jogador ON campeonato_etapa_semente.cod_jogador = jogador.codigo
			WHERE cod_partida = ".$partida['codigo']." AND lado = 1
		"));
		$sementeDois = mysqli_fetch_array(mysqli_query($conexao, "
			SELECT * FROM campeonato_partida_semente
			INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
			INNER JOIN jogador ON campeonato_etapa_semente.cod_jogador = jogador.codigo
			WHERE cod_partida = ".$partida['codigo']." AND lado = 2
		"));
		if(isset($sementeUm) && isset($sementeDois)){ // DUAS SEMENTES EXISTEM
			if($sementeUm['cod_equipe'] == NULL){
				$msg = "
					<a href='campeonato/".$campeonato['codigo']."/partida/".$partida['codigo']."/'>
						<li>
							Sua próxima partida do campeonato <strong>".$campeonato['nome']."</strong> é contra ".$sementeDois['nick'].". Só clicar aqui que te levaremos até lá.
						</li>
					</a>
				";
				mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$msg', ".$sementeUm['cod_jogador'].", 0)");
				$msg = "
					<a href='campeonato/".$campeonato['codigo']."/partida/".$partida['codigo']."/'>
						<li>
							Sua próxima partida do campeonato <strong>".$campeonato['nome']."</strong> é contra ".$sementeUm['nick'].". Só clicar aqui que te levaremos até lá.
						</li>
					</a>
				";
				mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$msg', ".$sementeDois['cod_jogador'].", 0)");
			}else{
				$equipeUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$sementeUm['cod_Equipe'].""));
				$equipeDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$sementeDois['cod_Equipe'].""));
				$lineupUm = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_equipe = ".$sementeUm['cod_equipe']."");
				$lineupDois = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_equipe = ".$sementeDois['cod_equipe']."");
				$msg = "
					<a href='campeonato/".$campeonato['codigo']."/partida/".$partida['codigo']."/'>
						<li>
							Sua próxima partida do campeonato <strong>".$campeonato['nome']."</strong> pela equipe ".$equipeUm['nome']." será contra ".$equipeDois['nome'].". Só clicar aqui que te levaremos até lá.
						</li>
					</a>
				";
				while($membro = mysqli_fetch_array($lineupUm)){
					mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$msg', ".$membro['cod_jogador'].", 0)");
				}
				$msg = "
					<a href='campeonato/".$campeonato['codigo']."/partida/".$partida['codigo']."/'>
						<li>
							Sua próxima partida do campeonato <strong>".$campeonato['nome']."</strong> pela equipe ".$equipeDois['nome']." será contra ".$equipeUm['nome'].". Só clicar aqui que te levaremos até lá.
						</li>
					</a>
				";
				while($membro = mysqli_fetch_array($lineupDois)){
					mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$msg', ".$membro['cod_jogador'].", 0)");
				}
			}
		}elseif(isset($sementeUm)){ // VERIFICAR HISTÓRICO SEMENTE DOIS			
			historicoSementeElimSimples($partida, 2);
		}elseif(isset($sementeDois)){ // VERIFICAR HISTÓRICO SEMENTE UM
			historicoSementeElimSimples($partida, 1);
		}
	}

	function avancarElimSimples($etapa, $partida){
		include "../conexao-banco.php";
		include "gameficacao.php";
		$xpWin = 25;
		$xpLose = 10;
		$maiorExp = 2;
		while($maiorExp < $etapa['vagas']){
			$maiorExp = $maiorExp * 2;
		}
		$maxLinhas = $maiorExp / 2;
		$maxColunas = log($maiorExp, 2);
		
		if($partida['linha'] % 2 != 0){
			$auxiliar = $partida['linha'] + 1;
		}else{
			$auxiliar = $partida['linha'];
		}
		
		$linhaDestino = $auxiliar / 2;
		$colunaDestino = $partida['coluna'] + 1;
		$sementeUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente 
			INNER JOIN campeonato_etapa_semente ON campeonato_partida_semente.cod_semente = campeonato_etapa_semente.codigo		
			WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 1"));
		$sementeDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente
			INNER JOIN campeonato_etapa_semente ON campeonato_partida_semente.cod_semente = campeonato_etapa_semente.codigo		
			WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 2"));
		
		$placar = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_resultado WHERE cod_partida = ".$partida['codigo']." LIMIT 1 "));
		
		mysqli_query($conexao, "UPDATE campeonato_partida SET status = 2, placar_um = ".$placar['placar_um'].", placar_dois = ".$placar['placar_dois']." WHERE codigo = ".$partida['codigo']." ");
		
		$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$partida['cod_campeonato'].""));
		
		if($placar['placar_um'] > $placar['placar_dois']){
			$ganhador = $sementeUm['cod_semente'];
			$perdedor = $sementeDois['cod_semente'];
			mysqli_query($conexao, "UPDATE campeonato_partida_semente SET status = 1 WHERE cod_semente = ".$sementeUm['cod_semente']." AND cod_partida = ".$partida['codigo']."");
			mysqli_query($conexao, "UPDATE campeonato_partida_semente SET status = 2 WHERE cod_semente = ".$sementeDois['cod_semente']." AND cod_partida = ".$partida['codigo']."");
			if($sementeUm['cod_equipe'] == NULL){
				adicionarXp($sementeUm['cod_jogador'],$campeonato['cod_jogo'], $xpWin);
				adicionarXp($sementeDois['cod_jogador'],$campeonato['cod_jogo'], $xpLose);
				mysqli_query($conexao, "INSERT INTO organizacao_feedback VALUES(NULL, ".$sementeDois['cod_jogador'].", ".$campeonato['cod_organizacao'].", ".$campeonato['codigo'].", NULL, NULL)");
			}else{
				$lineupUm = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$partida['cod_campeonato']." AND cod_equipe = ".$sementeUm['cod_equipe']."");
				$lineupDois = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$partida['cod_campeonato']." AND cod_equipe = ".$sementeDois['cod_equipe']."");
				while($membro = mysqli_fetch_array($lineupUm)){
					adicionarXp($membro['cod_jogador'],$campeonato['cod_jogo'], $xpWin);
				}
				while($membro = mysqli_fetch_array($lineupDois)){
					adicionarXp($membro['cod_jogador'],$campeonato['cod_jogo'], $xpLose);
					mysqli_query($conexao, "INSERT INTO organizacao_feedback VALUES(NULL, ".$sementeDois['cod_jogador'].", ".$campeonato['cod_organizacao'].", ".$campeonato['codigo'].", NULL, NULL)");
				}
			}
		}elseif($placar['placar_um'] < $placar['placar_dois']){
			$ganhador = $sementeDois['cod_semente'];
			$perdedor = $sementeUm['cod_semente'];
			mysqli_query($conexao, "UPDATE campeonato_partida_semente SET status = 1 WHERE cod_semente = ".$sementeDois['cod_semente']." AND cod_partida = ".$partida['codigo']."");
			mysqli_query($conexao, "UPDATE campeonato_partida_semente SET status = 2 WHERE cod_semente = ".$sementeUm['cod_semente']." AND cod_partida = ".$partida['codigo']."");
			if($sementeUm['cod_equipe'] == NULL){
				adicionarXp($sementeUm['cod_jogador'],$campeonato['cod_jogo'], $xpLose);
				mysqli_query($conexao, "INSERT INTO organizacao_feedback VALUES(NULL, ".$sementeUm['cod_jogador'].", ".$campeonato['cod_organizacao'].", ".$campeonato['codigo'].", NULL, NULL)");
				adicionarXp($sementeDois['cod_jogador'],$campeonato['cod_jogo'], $xpWin);
			}else{
				$lineupUm = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$partida['cod_campeonato']." AND cod_equipe = ".$sementeUm['cod_equipe']."");
				$lineupDois = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$partida['cod_campeonato']." AND cod_equipe = ".$sementeDois['cod_equipe']."");
				while($membro = mysqli_fetch_array($lineupUm)){
					adicionarXp($membro['cod_jogador'],$campeonato['cod_jogo'], $xpLose);					
					mysqli_query($conexao, "INSERT INTO organizacao_feedback VALUES(NULL, ".$membro['cod_jogador'].", ".$campeonato['cod_organizacao'].", ".$campeonato['codigo'].", NULL, NULL)");
				}
				while($membro = mysqli_fetch_array($lineupDois)){
					adicionarXp($membro['cod_jogador'],$campeonato['cod_jogo'], $xpWin);
				}
			}
		}	
		
		if($colunaDestino <= $maxColunas){
			$dataPartida = date("Y-m-d H:i:s");
			$partidaDestino = mysqli_fetch_array(mysqli_query($conexao, "SELECT codigo FROM campeonato_partida WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$partida['cod_campeonato']." AND linha = $linhaDestino AND coluna = $colunaDestino"));
			mysqli_query($conexao, "UPDATE campeonato_partida SET datahora = '$dataPartida' WHERE codigo = ".$partidaDestino['codigo']." ");
			if($partida['linha'] % 2 == 0){ // VAI SER O JOGADOR 2
				mysqli_query($conexao, "DELETE FROM campeonato_partida_semente WHERE cod_partida = ".$partidaDestino['codigo']." AND lado = 2");
				mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES ($ganhador, ".$partidaDestino['codigo'].", 0, 2, NULL, ".$partida['cod_campeonato'].", ".$etapa['cod_etapa'].")");				
			}else{ // VAI SER O JOGADOR 1
				mysqli_query($conexao, "DELETE FROM campeonato_partida_semente WHERE cod_partida = ".$partidaDestino['codigo']." AND lado = 1");
				mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES ($ganhador, ".$partidaDestino['codigo'].", 0, 1, NULL, ".$partida['cod_campeonato'].", ".$etapa['cod_etapa'].")");
			}
			situacaoOponenteElimSimples($partidaDestino); // VERIFICA QUAL A SITUAÇÃO ATUAL DO OPONENTE DO GANHADOR NA PRÓXIMA PARTIDA E GERA UMA NOTIFICAÇÃO.
		}else{ // VERIFICAR SE TEM QUE IR PARA DISPUTA DE TERCEIRO
			if($etapa['desempate'] == 1){
				$dataPartida = date("Y-m-d H:i:s", strtotime("+15 minutes", strtotime(date("Y-m-d H:i:s"))));
				$colunaDestino--;
				$linhaDestino = 2;
				$partidaDestino = mysqli_fetch_array(mysqli_query($conexao, "SELECT codigo FROM campeonato_partida WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$partida['cod_campeonato']." AND linha = $linhaDestino AND coluna = $colunaDestino"));
				mysqli_query($conexao, "UPDATE campeonato_partida SET datahora = '$dataPartida' WHERE codigo = ".$partidaDestino['codigo']." ");
				if($partida['linha'] % 2 == 0){ // VAI SER O JOGADOR 2
					mysqli_query($conexao, "DELETE FROM campeonato_partida_semente WHERE cod_partida = ".$partidaDestino['codigo']." AND lado = 2");
					mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES ($perdedor, ".$partidaDestino['codigo'].", 0, 2, NULL, ".$partida['cod_campeonato'].", ".$etapa['cod_etapa'].")");				
				}else{ // VAI SER O JOGADOR 1
					mysqli_query($conexao, "DELETE FROM campeonato_partida_semente WHERE cod_partida = ".$partidaDestino['codigo']." AND lado = 1");
					mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES ($perdedor, ".$partidaDestino['codigo'].", 0, 1, NULL, ".$partida['cod_campeonato'].", ".$etapa['cod_etapa'].")");
				}
				situacaoOponenteElimSimples($partidaDestino); // VERIFICA QUAL A SITUAÇÃO ATUAL DO OPONENTE DO GANHADOR NA PRÓXIMA PARTIDA E GERA UMA NOTIFICAÇÃO.
			}
		}
		
	}
	
	function avancarElimDupla($etapa, $partida){
		include "../conexao-banco.php";
		include "gameficacao.php";
		$xpWin = 25;
		$xpLose = 10;
		$maiorExp = 2;
		while($maiorExp < $etapa['vagas']){
			$maiorExp = $maiorExp * 2;
		}
		$maxLinhas = $maiorExp / 2;
		$maxColunas = log($maiorExp, 2);
		$maxColunasLower = $maxColunas + ($maxColunas-2);
		
		if($partida['linha'] % 2 != 0){
			$auxiliar = $partida['linha'] + 1;
		}else{
			$auxiliar = $partida['linha'];
		}
		
		$linhaDestino = $auxiliar / 2;
		
		$sementeUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente 
			INNER JOIN campeonato_etapa_semente ON campeonato_partida_semente.cod_semente = campeonato_etapa_semente.codigo		
			WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 1"));
		$sementeDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente
			INNER JOIN campeonato_etapa_semente ON campeonato_partida_semente.cod_semente = campeonato_etapa_semente.codigo		
			WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 2"));
		
		$placar = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_resultado WHERE cod_partida = ".$partida['codigo']." LIMIT 1 "));
		
		mysqli_query($conexao, "UPDATE campeonato_partida SET status = 2, placar_um = ".$placar['placar_um'].", placar_dois = ".$placar['placar_dois']." WHERE codigo = ".$partida['codigo']." ");
		
		$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$partida['cod_campeonato'].""));
		
		if($placar['placar_um'] > $placar['placar_dois']){
			$ganhador = $sementeUm['cod_semente'];
			$perdedor = $sementeDois['cod_semente'];
			mysqli_query($conexao, "UPDATE campeonato_partida_semente SET status = 1 WHERE cod_semente = ".$sementeUm['cod_semente']." AND cod_partida = ".$partida['codigo']."");
			mysqli_query($conexao, "UPDATE campeonato_partida_semente SET status = 2 WHERE cod_semente = ".$sementeDois['cod_semente']." AND cod_partida = ".$partida['codigo']."");
			
			if($sementeUm['cod_equipe'] == NULL){
				adicionarXp($sementeUm['cod_jogador'],$campeonato['cod_jogo'], $xpWin);
				adicionarXp($sementeDois['cod_jogador'],$campeonato['cod_jogo'], $xpLose);
				mysqli_query($conexao, "INSERT INTO organizacao_feedback VALUES(NULL, ".$sementeDois['cod_jogador'].", ".$campeonato['cod_organizacao'].", ".$campeonato['codigo'].", NULL, NULL)");
			}else{
				$lineupUm = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$partida['cod_campeonato']." AND cod_equipe = ".$sementeUm['cod_equipe']."");
				$lineupDois = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$partida['cod_campeonato']." AND cod_equipe = ".$sementeDois['cod_equipe']."");
				while($membro = mysqli_fetch_array($lineupUm)){
					adicionarXp($membro['cod_jogador'],$campeonato['cod_jogo'], $xpWin);
				}
				while($membro = mysqli_fetch_array($lineupDois)){
					adicionarXp($membro['cod_jogador'],$campeonato['cod_jogo'], $xpLose);
					mysqli_query($conexao, "INSERT INTO organizacao_feedback VALUES(NULL, ".$sementeDois['cod_jogador'].", ".$campeonato['cod_organizacao'].", ".$campeonato['codigo'].", NULL, NULL)");
				}
			}
		}elseif($placar['placar_um'] < $placar['placar_dois']){
			$ganhador = $sementeDois['cod_semente'];
			$perdedor = $sementeUm['cod_semente'];
			mysqli_query($conexao, "UPDATE campeonato_partida_semente SET status = 1 WHERE cod_semente = ".$sementeDois['cod_semente']." AND cod_partida = ".$partida['codigo']."");
			mysqli_query($conexao, "UPDATE campeonato_partida_semente SET status = 2 WHERE cod_semente = ".$sementeUm['cod_semente']." AND cod_partida = ".$partida['codigo']."");
			if($sementeUm['cod_equipe'] == NULL){
				adicionarXp($sementeUm['cod_jogador'],$campeonato['cod_jogo'], $xpLose);
				mysqli_query($conexao, "INSERT INTO organizacao_feedback VALUES(NULL, ".$sementeUm['cod_jogador'].", ".$campeonato['cod_organizacao'].", ".$campeonato['codigo'].", NULL, NULL)");
				adicionarXp($sementeDois['cod_jogador'],$campeonato['cod_jogo'], $xpWin);
			}else{
				$lineupUm = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$partida['cod_campeonato']." AND cod_equipe = ".$sementeUm['cod_equipe']."");
				$lineupDois = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$partida['cod_campeonato']." AND cod_equipe = ".$sementeDois['cod_equipe']."");
				while($membro = mysqli_fetch_array($lineupUm)){
					adicionarXp($membro['cod_jogador'],$campeonato['cod_jogo'], $xpLose);					
					mysqli_query($conexao, "INSERT INTO organizacao_feedback VALUES(NULL, ".$membro['cod_jogador'].", ".$campeonato['cod_organizacao'].", ".$campeonato['codigo'].", NULL, NULL)");
				}
				while($membro = mysqli_fetch_array($lineupDois)){
					adicionarXp($membro['cod_jogador'],$campeonato['cod_jogo'], $xpWin);
				}
			}
		}
		
		if($partida['sup_inf'] == "U"){ // JOGO DA UPPER BRACKET
			$destinoGanhador = $partida['coluna'] + 1;
			
			if($partida['coluna'] > 2){				
				$destinoPerdedor = $partida['coluna'] + ($partida['coluna'] - 2);
				$linhaPerdedor = $partida['linha'];
				$ladoPerdedor = 2;
			}else{
				if($partida['coluna'] == 1){
					if($partida['linha'] % 2 != 0){
						$linhaPerdedor = ($partida['linha'] + 1) / 2;
						$ladoPerdedor = 1;
					}else{
						$linhaPerdedor = $partida['linha'] / 2;
						$ladoPerdedor = 2;
					}
				}else{
					$linhaPerdedor = $partida['linha'];
					$ladoPerdedor = 1;
				}
				$destinoPerdedor = $partida['coluna'];
			}
			
			// AVANCAR GANHADOR
			
			if($destinoGanhador <= $maxColunas){
				$dataPartida = date("Y-m-d H:i:s");
				$partidaDestino = mysqli_fetch_array(mysqli_query($conexao, "SELECT codigo FROM campeonato_partida WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$partida['cod_campeonato']." AND linha = $linhaDestino AND coluna = $destinoGanhador AND sup_inf = 'U'"));
				mysqli_query($conexao, "UPDATE campeonato_partida SET datahora = '$dataPartida' WHERE codigo = ".$partidaDestino['codigo']." ");
				if($partida['linha'] % 2 == 0){ // VAI SER O JOGADOR 2
					mysqli_query($conexao, "DELETE FROM campeonato_partida_semente WHERE cod_partida = ".$partidaDestino['codigo']." AND lado = 2");
					mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES ($ganhador, ".$partidaDestino['codigo'].", 0, 2, NULL, ".$partida['cod_campeonato'].", ".$etapa['cod_etapa'].")");				
				}else{ // VAI SER O JOGADOR 1
					mysqli_query($conexao, "DELETE FROM campeonato_partida_semente WHERE cod_partida = ".$partidaDestino['codigo']." AND lado = 1");
					mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES ($ganhador, ".$partidaDestino['codigo'].", 0, 1, NULL, ".$partida['cod_campeonato'].", ".$etapa['cod_etapa'].")");
				}
			}else{ // AVANCAR PARA PRIMEIRA FINAL
				$partidaDestino = mysqli_fetch_array(mysqli_query($conexao, "SELECT codigo FROM campeonato_partida WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$partida['cod_campeonato']." AND sup_inf is null ORDER BY codigo ASC LIMIT 1"));
				
				mysqli_query($conexao, "UPDATE campeonato_partida SET datahora = '".date("Y-m-d H:i:s")."' WHERE codigo = ".$partidaDestino['codigo']." ");
				mysqli_query($conexao, "DELETE FROM campeonato_partida_semente WHERE cod_partida = ".$partidaDestino['codigo']." AND lado = 1");
				mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES ($ganhador, ".$partidaDestino['codigo'].", 0, 1, NULL, ".$partida['cod_campeonato'].", ".$etapa['cod_etapa'].")");
			}
			
			// AVANCAR PERDEDOR
			
			echo $linhaPerdedor."<br>";
			echo $destinoPerdedor."<br>";
			echo $ladoPerdedor;
			
			$dataPartida = date("Y-m-d H:i:s");
			$partidaDestino = mysqli_fetch_array(mysqli_query($conexao, "SELECT codigo, status FROM campeonato_partida WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$partida['cod_campeonato']." AND linha = $linhaPerdedor AND coluna = $destinoPerdedor AND sup_inf = 'L'"));
			mysqli_query($conexao, "UPDATE campeonato_partida SET datahora = '$dataPartida' WHERE codigo = ".$partidaDestino['codigo']." ");
			mysqli_query($conexao, "DELETE FROM campeonato_partida_semente WHERE cod_partida = ".$partidaDestino['codigo']." AND lado = $ladoPerdedor");
			mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES ($perdedor, ".$partidaDestino['codigo'].", 0, $ladoPerdedor, NULL, ".$partida['cod_campeonato'].", ".$etapa['cod_etapa'].")");
			
			
			
		}elseif($partida['sup_inf'] == "L"){ // JOGO DA LOWER BRACKET
			if($partida['coluna'] % 2 != 0){
				$linhaDestino = $partida['linha'];
				$ladoDestino = 2;
			}else{
				if($partida['linha'] % 2 != 0){
					$linhaDestino = ($partida['linha'] + 1) / 2;
					$ladoDestino = 1;
				}else{
					$linhaDestino = $partida['linha'] / 2;
					$ladoDestino = 2;
				}
			}
			
			if(($partida['coluna'] + 1) > $maxColunasLower){ // MOVE GANHADOR PARA A FINAL
				$partidaDestino = mysqli_fetch_array(mysqli_query($conexao, "SELECT codigo FROM campeonato_partida WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$partida['cod_campeonato']." AND sup_inf is null ORDER BY codigo ASC LIMIT 1"));
				$ladoDestino = 2;
			}else{ 
				$partidaDestino = mysqli_fetch_array(mysqli_query($conexao, "SELECT codigo FROM campeonato_partida WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$partida['cod_campeonato']." AND linha = $linhaDestino AND coluna = ".($partida['coluna'] + 1)." AND sup_inf = 'L'"));
			}
			
			// MOVE PARA PROXIMA RODADA
			
			mysqli_query($conexao, "UPDATE campeonato_partida SET datahora = '".date("Y-m-d H:i:s")."' WHERE codigo = ".$partidaDestino['codigo']." ");
			mysqli_query($conexao, "DELETE FROM campeonato_partida_semente WHERE cod_partida = ".$partidaDestino['codigo']." AND lado = $ladoDestino");
			mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES ($ganhador, ".$partidaDestino['codigo'].", 0, $ladoDestino, NULL, ".$partida['cod_campeonato'].", ".$etapa['cod_etapa'].")");
		}else{	
			$partidaDestino = mysqli_fetch_array(mysqli_query($conexao, "SELECT codigo FROM campeonato_partida WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$partida['cod_campeonato']." AND sup_inf is null ORDER BY codigo DESC LIMIT 1"));	
			
			if($partidaDestino['codigo'] != $partida['codigo']){
				if($perdedor == $sementeUm['cod_semente']){
					
					// FORMA PRÓXIMA FINAL
					mysqli_query($conexao, "UPDATE campeonato_partida SET datahora = '".date("Y-m-d H:i:s")."' WHERE codigo = ".$partidaDestino['codigo']." ");
					mysqli_query($conexao, "DELETE FROM campeonato_partida_semente WHERE cod_partida = ".$partidaDestino['codigo']." AND lado = 1");
					mysqli_query($conexao, "DELETE FROM campeonato_partida_semente WHERE cod_partida = ".$partidaDestino['codigo']." AND lado = 2");	

					mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES ($ganhador, ".$partidaDestino['codigo'].", 0, 1, NULL, ".$partida['cod_campeonato'].", ".$etapa['cod_etapa'].")");
					mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES ($perdedor, ".$partidaDestino['codigo'].", 0, 2, NULL, ".$partida['cod_campeonato'].", ".$etapa['cod_etapa'].")");
				}else{
					mysqli_query($conexao, "UPDATE campeonato_partida SET status = 3 WHERE codigo = ".$partidaDestino['codigo']." ");
				}	
			}
			
		}
	}

	function resultadoPontosCorridos($etapa, $partida){
		echo "ok funcionando";
		include "../conexao-banco.php";
		include "gameficacao.php";
		$xpWin = 25;
		$xpLose = 10;
		$sementeUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente 
			INNER JOIN campeonato_etapa_semente ON campeonato_partida_semente.cod_semente = campeonato_etapa_semente.codigo		
			WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 1"));
		$sementeDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente
			INNER JOIN campeonato_etapa_semente ON campeonato_partida_semente.cod_semente = campeonato_etapa_semente.codigo		
			WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 2"));
		$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$partida['cod_campeonato']." "));
		
		$placar = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_resultado WHERE cod_partida = ".$partida['codigo']." LIMIT 1 "));
		
		mysqli_query($conexao, "UPDATE campeonato_partida SET status = 2, placar_um = ".$placar['placar_um'].", placar_dois = ".$placar['placar_dois']." WHERE codigo = ".$partida['codigo']." ");
		
		if($placar['placar_um'] > $placar['placar_dois']){
			$ganhador = $sementeUm['cod_semente'];
			$perdedor = $sementeDois['cod_semente'];
			mysqli_query($conexao, "UPDATE campeonato_partida_semente SET status = 1 WHERE cod_semente = ".$sementeUm['cod_semente']." AND cod_partida = ".$partida['codigo']."");
			mysqli_query($conexao, "UPDATE campeonato_partida_semente SET status = 2 WHERE cod_semente = ".$sementeDois['cod_semente']." AND cod_partida = ".$partida['codigo']."");
			if($sementeUm['cod_equipe'] == NULL){				
				adicionarXp($sementeUm['cod_jogador'],$campeonato['cod_jogo'], $xpWin);
				adicionarXp($sementeDois['cod_jogador'],$campeonato['cod_jogo'], $xpLose);
				mysqli_query($conexao, "INSERT INTO organizacao_feedback VALUES(NULL, ".$sementeDois['cod_jogador'].", ".$campeonato['cod_organizacao'].", ".$campeonato['codigo'].", NULL, NULL)");
			}else{
				$lineupUm = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$partida['cod_campeonato']." AND cod_equipe = ".$sementeUm['cod_equipe']."");
				$lineupDois = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$partida['cod_campeonato']." AND cod_equipe = ".$sementeDois['cod_equipe']."");
				while($membro = mysqli_fetch_array($lineupUm)){
					adicionarXp($membro['cod_jogador'],$campeonato['cod_jogo'], $xpWin);
				}
				while($membro = mysqli_fetch_array($lineupDois)){
					adicionarXp($membro['cod_jogador'],$campeonato['cod_jogo'], $xpLose);
					mysqli_query($conexao, "INSERT INTO organizacao_feedback VALUES(NULL, ".$sementeDois['cod_jogador'].", ".$campeonato['cod_organizacao'].", ".$campeonato['codigo'].", NULL, NULL)");
				}
			}
			mysqli_query($conexao, "UPDATE campeonato_etapa_semente
			SET total_jogos = total_jogos + 1, 
			vitorias = vitorias + 1, 
			partidas_pro = partidas_pro + ".$placar['placar_um'].",
			partidas_contra = partidas_contra + ".$placar['placar_dois']."
			WHERE codigo = ".$sementeUm['cod_semente']." ");
			
			mysqli_query($conexao, "UPDATE campeonato_etapa_semente
			SET total_jogos = total_jogos + 1, 
			derrotas = derrotas + 1, 
			partidas_pro = partidas_pro + ".$placar['placar_dois'].",
			partidas_contra = partidas_contra + ".$placar['placar_um']."
			WHERE codigo = ".$sementeDois['cod_semente']." ");
		}elseif($placar['placar_um'] < $placar['placar_dois']){
			$ganhador = $sementeDois['cod_semente'];
			$perdedor = $sementeUm['cod_semente'];
			mysqli_query($conexao, "UPDATE campeonato_partida_semente SET status = 1 WHERE cod_semente = ".$sementeDois['cod_semente']." AND cod_partida = ".$partida['codigo']."");
			mysqli_query($conexao, "UPDATE campeonato_partida_semente SET status = 2 WHERE cod_semente = ".$sementeUm['cod_semente']." AND cod_partida = ".$partida['codigo']."");
			if($sementeUm['cod_equipe'] == NULL){
				adicionarXp($sementeUm['cod_jogador'],$campeonato['cod_jogo'], $xpLose);
				mysqli_query($conexao, "INSERT INTO organizacao_feedback VALUES(NULL, ".$sementeUm['cod_jogador'].", ".$campeonato['cod_organizacao'].", ".$campeonato['codigo'].", NULL, NULL)");
				adicionarXp($sementeDois['cod_jogador'],$campeonato['cod_jogo'], $xpWin);
			}else{
				$lineupUm = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$partida['cod_campeonato']." AND cod_equipe = ".$sementeUm['cod_equipe']."");
				$lineupDois = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$partida['cod_campeonato']." AND cod_equipe = ".$sementeDois['cod_equipe']."");
				while($membro = mysqli_fetch_array($lineupUm)){
					adicionarXp($membro['cod_jogador'],$campeonato['cod_jogo'], $xpLose);					
					mysqli_query($conexao, "INSERT INTO organizacao_feedback VALUES(NULL, ".$membro['cod_jogador'].", ".$campeonato['cod_organizacao'].", ".$campeonato['codigo'].", NULL, NULL)");
				}
				while($membro = mysqli_fetch_array($lineupDois)){
					adicionarXp($membro['cod_jogador'],$campeonato['cod_jogo'], $xpWin);
				}
			}
			mysqli_query($conexao, "UPDATE campeonato_etapa_semente
			SET total_jogos = total_jogos + 1, 
			derrotas = derrotas + 1, 
			partidas_pro = partidas_pro + ".$placar['placar_um'].",
			partidas_contra = partidas_contra + ".$placar['placar_dois']."
			WHERE codigo = ".$sementeUm['cod_semente']." ");
			
			mysqli_query($conexao, "UPDATE campeonato_etapa_semente
			SET total_jogos = total_jogos + 1, 
			vitorias = vitorias + 1, 
			partidas_pro = partidas_pro + ".$placar['placar_dois'].",
			partidas_contra = partidas_contra + ".$placar['placar_um']."
			WHERE codigo = ".$sementeDois['cod_semente']." ");
		}	
	}

	function resultadoPartida($codPartida){
		include "../conexao-banco.php";
		$partida = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE codigo = $codPartida"));
		$etapa = mysqli_fetch_array(mysqli_query($conexao, "SELECT cod_etapa, tipo_etapa, vagas FROM campeonato_etapa WHERE cod_etapa = ".$partida['cod_etapa']." AND cod_campeonato = ".$partida['cod_campeonato'].""));
		
		if($partida['status'] == 1){
			switch($etapa['tipo_etapa']){
				case 1: // ELIMINAÇÃO SIMPLES
					avancarElimSimples($etapa, $partida);		
					break;
				case 2: // GRUPO PONTOS CORRIDOS
					resultadoPontosCorridos($etapa, $partida);
					break;
				case 3: // ELIMINAÇÃO DUPLA
					avancarElimDupla($etapa, $partida);
					break;
			}	
		}		
	}

	function jogAusentes($codPartida){
		include "../conexao-banco.php";
		mysqli_query($conexao, "DELETE FROM campeonato_partida_semente WHERE cod_partida = $codPartida");
		mysqli_query($conexao, "UPDATE campeonato_partida SET status = 3 WHERE codigo = $codPartida");
	}

	if(isset($_POST['funcao'])){
		switch($_POST['funcao']){
			case 1: // DEFINIR PARTIDA COMO WO
				jogAusentes($_POST['codpartida']);
				break;
			case 2: // CARREGAR MENSAGENS GERAL DOS OPONENTES (CAPITÃES)
				include "../conexao-banco.php";
				$partida = $_POST['codpartida'];
				$jogador = $_POST['jogador'];


				$mensagens = mysqli_query($conexao, "SELECT * FROM campeonato_partida_chat
				INNER JOIN jogador ON jogador.codigo = campeonato_partida_chat.cod_jogador
				WHERE campeonato_partida_chat.cod_partida = $partida
				ORDER BY datahora ASC");

				if(mysqli_num_rows($mensagens) == 0){
				?>
					<div class="centralizar">
						<h3>CHAT COM O CAPITÃO DA OUTRA EQUIPE</h3>
						Apenas os capitães e membros da organização tem acesso a esse chat.<br><br>
						
						Utilize esta aba para trocar informações sobre a partida que irão disputar.
					</div>
				<?php
				}else{
					while($msg = mysqli_fetch_array($mensagens)){
					?>
						<div class="msg <?php if($msg['cod_jogador'] == $jogador){ echo "destaque"; } ?>">
							<?php
								echo "<strong>".$msg['nick'].":</strong> ".$msg['mensagem'];
							?>
						</div>
					<?php
					}	
				}
				break;
			case 3: // ENVIAR MENSAGEM GERAL
				include "../conexao-banco.php";
				$jogador = $_POST['jogador'];
				$partida = $_POST['codpartida'];
				$mensagem = $_POST['mensagem'];
				$datahora = date("Y-m-d H:i:s");

				mysqli_query($conexao, "INSERT INTO campeonato_partida_chat
				VALUES (NULL, $partida, $jogador, '$mensagem', '$datahora')");

				require "../../js/vendor/autoload.php";
				$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
				$pusher->trigger('chatpartida'.$partida, 'atualizarChat', array('message' => 'hello world'));
				break;
			case 4: // ENVIAR MENSAGEM EQUIPE
				include "../conexao-banco.php";
				$jogador = $_POST['jogador'];
				$partida = $_POST['codpartida'];
				$equipe = $_POST['codequipe'];
				$mensagem = $_POST['mensagem'];
				$datahora = date("Y-m-d H:i:s");

				mysqli_query($conexao, "INSERT INTO campeonato_partida_chat_equipe
				VALUES (NULL, $partida, $equipe, $jogador, '$mensagem', '$datahora')");

				require "../../js/vendor/autoload.php";
				$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
				$pusher->trigger('chatequipepartida'.$equipe, 'atualizarChat', array('message' => 'hello world'));
				break;
		}
	}
?>