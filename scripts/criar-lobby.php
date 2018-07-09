<?php
	function criarTimes($qtdTimes, $qtdJogadores, $idLobby){
		include "../session.php";
		$auxTimes = 0;
		$posicao = 1;
		while($auxTimes < $qtdTimes){
			$contador = 1;
			mysqli_query($conexao, "INSERT INTO lobby_equipe VALUES (NULL, $idLobby, 'Equipe ".$posicao."', 0, 0, $qtdJogadores)");
			$idGerada = mysqli_insert_id($conexao);
			while($contador <= $qtdJogadores){
				mysqli_query($conexao, "INSERT INTO lobby_equipe_semente VALUES (NULL, $idGerada, NULL, $contador, 0, 0, 0)");
				$contador++;
			}
			$auxTimes++;
			$posicao++;
		}
	}

	if(isset($_POST['codJogo'])){
		include "../session.php";
		include "../enderecos.php";

		$codJogo = $_POST['codJogo'];
		$nome = $_POST['nome'];
		$qtdTimes = $_POST['qtdTimes'];
		$jogadorPorTime = $_POST['jogadorPorTime'];
		$data = date("Y-m-d H:i:s");
		$tipo = $_POST['tipo'];
		if(isset($_POST['privacidade'])){ // CRIAR LOBBY PRIVADO
			mysqli_query($conexao, "INSERT INTO lobby VALUES (NULL, $codJogo, ".$usuario['codigo'].", $qtdTimes, $jogadorPorTime, '$nome', '$data', 0, 1, '".$_POST['senha']."', $tipo, 0)");
		}else{ // CRIAR LOBBY PUBLICO
			mysqli_query($conexao, "INSERT INTO lobby VALUES (NULL, $codJogo, ".$usuario['codigo'].", $qtdTimes, $jogadorPorTime, '$nome', '$data', 0, 0, NULL, $tipo, 0)");
		}

		$idLobby = mysqli_insert_id($conexao);

		criarTimes($qtdTimes, $jogadorPorTime, $idLobby);
		header("Location: ../lobby/$idLobby/");	
	}	
?>