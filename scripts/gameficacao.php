<?php
	if(!function_exists("adicionarXp")){
		function adicionarXp($codJogador, $codJogo, $xp){
			include "../conexao-banco.php";
			$level = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM gm_jogador_level WHERE cod_jogador = $codJogador AND cod_jogo = $codJogo"));
			$xpAtual = $level['xp_atual'] + $xp;
			$lvlAtual = $level['level'];
			while($xpAtual >= $level['xp_final']){

				$xpAtual = $xpAtual - $level['xp_final'];
				$lvlAtual++;

				if($lvlAtual == 50){ // APLICAR RESET
					$lvlAtual = 1;
					$level['avanco_xp'] += 5;
					$level['xp_final'] = $level['avanco_xp'];
					$level['resets']++;
					$level['multiplicador'] += 0.01;
				}else{
					$level['xp_final'] += $level['avanco_xp'];
				}
			}
			mysqli_query($conexao, "
				UPDATE gm_jogador_level
				SET level = $lvlAtual, xp_atual = $xpAtual, xp_final = ".$level['xp_final'].", xp_total = xp_total + $xp, multiplicador = ".$level['multiplicador'].", resets = ".$level['resets'].", avanco_xp = ".$level['avanco_xp']."
				WHERE cod_jogador = $codJogador AND cod_jogo = $codJogo
			");
		}	
	}

    if(!function_exists("criarPerfil")){
		function criarPerfil($codJogador, $codJogo){
			include "../conexao-banco.php";
            mysqli_query($conexao, "INSERT INTO gm_jogador_level VALUES ($codJogador, 1, 0, 50, 0, '".date("Y-m-d")."', $codJogo, 1, 0, 50)");
		}	
	}

    if(isset($_POST['funcao'])){
        switch($_POST['funcao']){
            case "criarPerfil":
                criarPerfil($_POST['codJogador'], $_POST['codJogo']);
                break;
        }
    }
?>