<?php
	include "../conexao-banco.php";

	$funcao = $_POST['funcao'];
	$etapa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_etapa = ".$_POST['etapa']." AND cod_campeonato = ".$_POST['campeonato'].""));
	$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$etapa['cod_campeonato']." "));

	if($campeonato['jogador_por_time'] == 1){ // INSCRIÇÕES SOLO
		switch($funcao){
			case 1: // Ordem Aleatoria
				$jogadores = mysqli_query($conexao, "
					SELECT * FROM campeonato_inscricao
					INNER JOIN jogador ON jogador.codigo = campeonato_inscricao.cod_jogador
					WHERE campeonato_inscricao.cod_campeonato = ".$etapa['cod_campeonato']." AND campeonato_inscricao.status = 1
					ORDER BY rand()
				");
				break;
			case 2: // Por DATA&HORA
				$jogadores = mysqli_query($conexao, "
					SELECT * FROM campeonato_inscricao
					INNER JOIN jogador ON jogador.codigo = campeonato_inscricao.cod_jogador
					WHERE campeonato_inscricao.cod_campeonato = ".$etapa['cod_campeonato']." AND campeonato_inscricao.status = 1
					ORDER BY datahora ASC
				");
				break;
		}

		$aux = 0;
		while($jogador = mysqli_fetch_array($jogadores)){
			$players[$aux] = $jogador['codigo'];
			$aux++;
			$players[$aux] = $jogador['cod_equipe'];
			$aux++;
		}

		$seeds = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_semente WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$etapa['cod_campeonato']." ORDER BY numero ASC");

		$aux = 0;
		$aux2 = 1;
		while($seed = mysqli_fetch_array($seeds)){
			mysqli_query($conexao, "UPDATE campeonato_etapa_semente SET cod_jogador = ".$players[$aux]." WHERE codigo = ".$seed['codigo']." ");
			echo $players[$aux]." - ".$players[$aux2]."<br>";
			$aux = $aux2+1;
			$aux2 = $aux+1;
		}	
	}else{ // INSCRIÇÕES EQUIPE
		switch($funcao){
			case 1: // Ordem Aleatoria
				$equipes = mysqli_query($conexao, "
					SELECT * FROM campeonato_inscricao
					INNER JOIN equipe ON equipe.codigo = campeonato_inscricao.cod_equipe
					WHERE campeonato_inscricao.cod_campeonato = ".$etapa['cod_campeonato']." AND campeonato_inscricao.status = 1
					GROUP BY campeonato_inscricao.cod_equipe
					ORDER BY rand()
				");
				break;
			case 2: // Por DATA&HORA
				$equipes = mysqli_query($conexao, "
					SELECT * FROM campeonato_inscricao
					INNER JOIN equipe ON equipe.codigo = campeonato_inscricao.cod_equipe
					WHERE campeonato_inscricao.cod_campeonato = ".$etapa['cod_campeonato']." AND campeonato_inscricao.status = 1
					GROUP BY campeonato_inscricao.cod_equipe
					ORDER BY datahora ASC
				");
				break;
		}

		$aux = 0;
		while($equipe = mysqli_fetch_array($equipes)){
			$equipesLista[$aux] = $equipe['cod_equipe'];
			$aux++;
			$equipesLista[$aux] = $equipe['cod_jogador'];
			$aux++;
		}

		$seeds = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_semente WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$etapa['cod_campeonato']." ORDER BY numero ASC");

		$aux = 0;
		$aux2 = 1;
		while($seed = mysqli_fetch_array($seeds)){
			mysqli_query($conexao, "UPDATE campeonato_etapa_semente SET cod_equipe = ".$equipesLista[$aux].", cod_jogador = ".$equipesLista[$aux2]." WHERE codigo = ".$seed['codigo']." ");
			$aux = $aux2+1;
			$aux2 = $aux+1;
		}	
	}

	
?>