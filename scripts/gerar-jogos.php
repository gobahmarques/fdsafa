<?php
	function jogosElimSimples($etapa, $campeonato, $jogadores, $partida, $dispTerceiro, $conexao){
		$maiorExp = 2;
		while($maiorExp < $jogadores){
			$maiorExp = $maiorExp * 2;
		}
		$limiteLinha = $maiorExp / 2;
		$limiteColuna = log($maiorExp, 2);
		$l = 1;
		$c = 1;
		$totalPartidas = $maiorExp - 1;		
		$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = $campeonato"));
		$aux = $totalPartidas;
		while($aux > 0){
			if($l > $limiteLinha){
				$l = 1;
				$c++;
				$limiteLinha = $limiteLinha / 2;
			}
			mysqli_query($conexao, "INSERT INTO campeonato_partida VALUES (NULL, $etapa, '".$campeonato['inicio']."', NULL, NULL, ".$campeonato['codigo'].", $partida, 0, $l, $c, 0, 0, NULL)");
			$aux--;
			$l++;
		}
		if($dispTerceiro == 1){
			$c++;
			$l--;
			mysqli_query($conexao, "INSERT INTO campeonato_partida VALUES (NULL, $etapa, '".$campeonato['inicio']."', NULL, NULL, ".$campeonato['codigo'].", $partida, 0, $l, $c, 0, 0, NULL)");
		}
	}

	function byesElimSimples($etapa, $codCampeonato, $conexao){
		$etapa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_etapa = $etapa AND cod_campeonato = $codCampeonato "));
		$maiorExp = 2;
		while($maiorExp < $etapa['vagas']){
			$maiorExp = $maiorExp * 2;
		}
		$byes = $maiorExp - $etapa['vagas'];
		
		while($byes != 0){
			$partida = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_campeonato = $codCampeonato AND cod_etapa = ".$etapa['cod_etapa']." AND coluna = 1 ORDER BY rand() LIMIT 1"));
			if($partida['status'] == 0){
				mysqli_query($conexao, "UPDATE campeonato_partida SET status = 3 WHERE codigo = ".$partida['codigo']."");
				$byes--;
			}
		}
	}

	function byesElimDupla($etapa, $codCampeonato, $conexao){
		$etapa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_etapa = $etapa AND cod_campeonato = $codCampeonato "));
		$maiorExp = 2;
		while($maiorExp < $etapa['vagas']){
			$maiorExp = $maiorExp * 2;
		}
		$byes = $maiorExp - $etapa['vagas'];
		
        echo $byes;
        
		while($byes != 0){
			$partida = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_campeonato = $codCampeonato AND cod_etapa = ".$etapa['cod_etapa']." AND coluna = 1 and sup_inf = 'U' AND status != 3 ORDER BY rand() LIMIT 1"));
			mysqli_query($conexao, "UPDATE campeonato_partida SET status = 3 WHERE codigo = ".$partida['codigo']."");
			$byes--;
			
			if($partida['linha'] % 2 != 0){
				$lDestino = ($partida['linha'] + 1) / 2;
			}else{
				$lDestino = $partida['linha'] / 2;
			}
			
			$partidaDestino = mysqli_fetch_array(mysqli_query($conexao, "SELECT codigo FROM campeonato_partida WHERE cod_campeonato = $codCampeonato AND cod_etapa = ".$etapa['cod_etapa']." AND coluna = 1 AND linha = $lDestino AND sup_inf = 'L'"));
			
			mysqli_query($conexao, "UPDATE campeonato_partida SET status = 2 WHERE codigo = ".$partidaDestino['codigo']." ");
		}
	}

	function distribuirSementesElimSimples($etapa, $codCampeonato, $conexao){
		
		$sementes = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_semente WHERE cod_etapa = $etapa AND cod_campeonato = $codCampeonato ORDER BY numero");
		$aux = 0;
		while($semente = mysqli_fetch_array($sementes)){
			$seeds[$aux] = $semente['codigo'];
			$aux++;
		}
		$maiorExp = 2;
		while($maiorExp < $aux){
			$maiorExp = $maiorExp * 2;
		}
		$byes = $maiorExp - $aux;
		
		$maximo = $aux - 1;
		$aux = 0;
		$partidasBye = mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_etapa = $etapa AND cod_campeonato = $codCampeonato AND coluna = 1 AND status = 3 ORDER BY codigo");
		while($partida = mysqli_fetch_array($partidasBye)){
			$linhaDestino = (int) (($partida['linha'] + 1) / 2);
			$colunaDestino = $partida['coluna'] + 1;
			$codigo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_etapa = $etapa AND cod_campeonato = $codCampeonato AND coluna = $colunaDestino AND linha = $linhaDestino"));
			if($partida['linha'] % 2 != 0){
				$lado = 1;
			}else{
				$lado = 2;
			}
			mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES (".$seeds[$aux].", ".$codigo['codigo'].", 0, $lado, NULL, $codCampeonato, $etapa)");
			$aux++;
		}
		
		$partidas = mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_etapa = $etapa AND cod_campeonato = $codCampeonato AND coluna = 1 AND status != 3 ORDER BY codigo");
		while($partida = mysqli_fetch_array($partidas)){
			mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES ($seeds[$aux], ".$partida['codigo'].", 0, 1, NULL, $codCampeonato, $etapa)");
			$aux++;
			mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES ($seeds[$maximo], ".$partida['codigo'].", 0, 2, NULL, $codCampeonato, $etapa)");
			$maximo--;
		}
	}

	function distribuirSementesElimDupla($etapa, $codCampeonato, $conexao){		
		$sementes = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_semente WHERE cod_etapa = $etapa AND cod_campeonato = $codCampeonato ORDER BY numero");
		$aux = 0;
		while($semente = mysqli_fetch_array($sementes)){
			$seeds[$aux] = $semente['codigo'];
			$aux++;
		}
		$maiorExp = 2;
		while($maiorExp < $aux){
			$maiorExp = $maiorExp * 2;
		}
		$byes = $maiorExp - $aux;
		
		$maximo = $aux - 1;
		$aux = 0;
		$partidasBye = mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_etapa = $etapa AND cod_campeonato = $codCampeonato AND coluna = 1 AND status = 3 ORDER BY codigo");
		while($partida = mysqli_fetch_array($partidasBye)){
			$linhaDestino = (int) (($partida['linha'] + 1) / 2);
			$colunaDestino = $partida['coluna'] + 1;
			$codigo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_etapa = $etapa AND cod_campeonato = $codCampeonato AND coluna = $colunaDestino AND linha = $linhaDestino"));
			if($partida['linha'] % 2 != 0){
				$lado = 1;
			}else{
				$lado = 2;
			}
			mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES (".$seeds[$aux].", ".$codigo['codigo'].", 0, $lado, NULL, $codCampeonato, $etapa)");
			$aux++;
		}
		
		$partidas = mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_etapa = $etapa AND cod_campeonato = $codCampeonato AND coluna = 1 AND status != 3 AND sup_inf = 'U' ORDER BY codigo");
		while($partida = mysqli_fetch_array($partidas)){
			mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES ($seeds[$aux], ".$partida['codigo'].", 0, 1, NULL, $codCampeonato, $etapa)");
			$aux++;
			mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES ($seeds[$maximo], ".$partida['codigo'].", 0, 2, NULL, $codCampeonato, $etapa)");
			$maximo--;
		}
	}

	function jogosPontosCorridos($etapa, $campeonato){
		include "../../../../conexao-banco.php";
		if($etapa['datalimite'] != NULL){ // TEM DATA LIMITE
			$grupos = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_grupo WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$campeonato['codigo']." ORDER BY codigo");
			while($grupo = mysqli_fetch_array($grupos)){
				$seedsGrupo = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_semente WHERE cod_grupo = ".$grupo['codigo']."");
				$aux = 0;
				while($seed = mysqli_fetch_array($seedsGrupo)){
					$seeds[$aux] = $seed['codigo'];
					$aux++;
				}
				$limite = $aux - 2; // 2
				$limite2 = $aux; // 4
				$posicao = 0;		
				$aux = 1;
				$aux2 = 1;
				while($posicao <= $limite){
					while($aux < $limite2){
						mysqli_query($conexao, "INSERT INTO campeonato_partida VALUES (NULL, ".$etapa['cod_etapa'].", NULL, '".$etapa['datalimite']."', ".$grupo['codigo'].", ".$campeonato['codigo'].", ".$etapa['formato_partidas'].", 0, NULL, NULL, 0, 0, NULL)");
						$codPartida = mysqli_insert_id($conexao);
						mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES (".$seeds[$posicao].", $codPartida, 0, 1, NULL, ".$campeonato['codigo'].", ".$etapa['cod_etapa'].")");
						mysqli_query($conexao, "INSERT INTO campeonato_partida_semente VALUES (".$seeds[$aux].", $codPartida, 0, 2, NULL, ".$campeonato['codigo'].", ".$etapa['cod_etapa'].")");
						$aux++;
					}
					$aux = $aux2 + 1;
					$posicao++;
					$aux2 = $aux;
				}
			}
		}else{ // NÃO TEM DATA LIMITE
			
		}	
	}

	function jogosElimDupla($etapa, $campeonato, $jogadores, $partida, $inicio, $conexao){
		$formato = "d/m/Y H:i:s";
		$inicio = DateTime::createFromFormat($formato, $_POST['inicio']);
		$inicio = $inicio->format("Y-m-d H:i:s");
		
		/* UPPER BRACKET */
		
		$maiorExp = 2;
		while($maiorExp < $jogadores){
			$maiorExp = $maiorExp * 2;
		}
		$limiteLinha = $maiorExp / 2;
		$limiteColuna = log($maiorExp, 2);
		$l = 1;
		$c = 1;
		$totalPartidas = $maiorExp - 1;		
		$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = $campeonato"));
		$aux = $totalPartidas;
		$campos = "NULL, $etapa, '$inicio', NULL, NULL, '".$campeonato['codigo']."', $partida, 0, $l, $c, 0, 0, 'U'";
		
		while($aux > 0){
			if($l > $limiteLinha){
				$l = 1;
				$c++;
				$limiteLinha /= 2;
				$campos = "NULL, $etapa, NULL, NULL, NULL, '".$campeonato['codigo']."', $partida, 0, $l, $c, 0, 0, 'U'";
			}else{
				$campos = "NULL, $etapa, '$inicio', NULL, NULL, '".$campeonato['codigo']."', $partida, 0, $l, $c, 0, 0, 'U'";
			}
			mysqli_query($conexao, "INSERT INTO campeonato_partida VALUES ($campos)");
			$aux--;
			$l++;			
		}
		
		
		/* LOWER BRACKET */
		
		$maiorExp = 2;
		while($maiorExp < $jogadores){
			$maiorExp = $maiorExp * 2;
		}
		$limiteLinha = $maiorExp / 4;
		$limiteColuna += 1;
		$l = 1;
		$c = 1;
		$totalPartidas -= 1;	
		$aux = $totalPartidas;
		$ctd = 0;
		while($aux > 0){
			if($l > $limiteLinha){
				$l = 1;
				$c++;
				if($ctd == 0){
					$ctd++;
				}else{
					$ctd = 0;
					$limiteLinha /= 2;
				}				
			}
			mysqli_query($conexao, "INSERT INTO campeonato_partida VALUES (NULL, $etapa, NULL, NULL, NULL, '".$campeonato['codigo']."', $partida, 0, $l, $c, 0, 0, 'L')");
			$aux--;
			$l++;
		}
		
		/* FINAL */
		
		$l = 1;
		$c++;
		mysqli_query($conexao, "INSERT INTO campeonato_partida VALUES (NULL, $etapa, NULL, NULL, NULL, '".$campeonato['codigo']."', $partida, 0, $l, $c, 0, 0, NULL)");
		$c++;
		mysqli_query($conexao, "INSERT INTO campeonato_partida VALUES (NULL, $etapa, NULL, NULL, NULL, '".$campeonato['codigo']."', $partida, 0, $l, $c, 0, 0, NULL)");
		
	}
?>