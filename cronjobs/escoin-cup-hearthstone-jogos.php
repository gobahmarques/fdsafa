<?php
	include "conexao-banco.php";
	$data = date("Y-m-d");

	$campeonato = mysqli_query($conexao, "SELECT * FROM campeonato WHERE nome LIKE '%eSCoin Cup%' AND inicio LIKE '%$data%' AND cod_jogo = 369 AND status = 0 ORDER BY codigo LIMIT 1");
	$campeonato = mysqli_fetch_array($campeonato);
	
	
    echo $campeonato['codigo'];
    mysqli_query($conexao, "UPDATE campeonato SET status = 1 WHERE codigo = ".$campeonato['codigo']." "); // COMECAR TORNEIO
    $msg = "<li>Foi dada a largada. O torneio <strong>".$campeonato['nome']."</strong> está oficialmente iniciado.</li>";

    if($campeonato['tipo_inscricao'] == 0){
		$destinos = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']."");
	}else{
		$destinos = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$campeonato['codigo']." ");
	}

	while($destino = mysqli_fetch_array($destinos)){
		mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '".$msg."', ".$destino['cod_jogador'].", 0)");
	}

	$vagas = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 1 "));

	if($vagas > 1){
		// GERAR TABELA

		$numEtapa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_campeonato = ".$campeonato['codigo']." ORDER BY cod_etapa DESC LIMIT 1"));
		$numEtapa = $numEtapa['cod_etapa'] + 1;


		mysqli_query($conexao, "INSERT INTO campeonato_etapa VALUES (".$campeonato['codigo'].", $numEtapa, 'Fase Principal', 1, NULL, NULL, NULL, NULL, 5, 0, $vagas, NULL, NULL, NULL, 0)");

		$i = 0;

		while($i < $vagas){
			$i++;
			mysqli_query($conexao, "INSERT INTO campeonato_etapa_semente VALUES (NULL, $i, $numEtapa, ".$campeonato['codigo'].", NULL, NULL, NULL, 0, 0, 0, 0, 0, 0)");	
		}

		// DISTRIBUIR SEMENTES

		include "scripts/gerar-jogos.php";
		jogosElimSimples($numEtapa, $campeonato['codigo'], $vagas, 5, 0, $campeonato['inicio'], $conexao);
		byesElimSimples($numEtapa, $campeonato['codigo'], $conexao);
		distribuirSementesElimSimples($numEtapa, $campeonato['codigo'], $conexao);
		
		// DISTRIBUIR INSCRIÇÕES NAS SEMENTES

		$inscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 1 ");
		$sementes = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_semente WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_etapa = $numEtapa");
		while($seed = mysqli_fetch_array($sementes)){
			$jogador = mysqli_fetch_array($inscricoes);
			mysqli_query($conexao, "UPDATE campeonato_etapa_semente SET cod_jogador = ".$jogador['cod_jogador']." WHERE codigo = ".$seed['codigo']."");
			if($jogador['cod_equipe'] != NULL){
				mysqli_query($conexao, "UPDATE campeonato_etapa_semente SET cod_equipe = ".$jogador['cod_equipe']." WHERE codigo = ".$seed['codigo']."");
			}
		}
		
		// LIBERAR PARTIDAS
		
		mysqli_query($conexao, "UPDATE campeonato_partida SET status = 1 WHERE cod_campeonato = ".$campeonato['codigo']." AND status != 3 AND status != 2 ");
	}
?>