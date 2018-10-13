<?php
	if(!function_exists("adicionarXp")){
		function adicionarXp($codJogador, $xp){
			global $conexao;
			$level = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM gm_jogador_level WHERE cod_jogador = $codJogador"));
			$xpAtual = $level['xp_atual'] + $xp;
			$lvlAtual = $level['level'];
			while($xpAtual >= $level['xp_final']){

				$xpAtual = $xpAtual - $level['xp_final'];
				$lvlAtual++;

				if($lvlAtual == 30){ // APLICAR RESET
					$lvlAtual = 1;
					$level['avanco_xp'] += 25;
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
				WHERE cod_jogador = $codJogador
			");
		}	
	}

    if(!function_exists("concluirMissao")){
        function concluirMissao($codJogador, $codMissao){
            global $conexao;
            $pesquisa = mysqli_query($conexao, "
                SELECT * FROM gm_jogador_missao
                WHERE cod_jogador = $codJogador
                AND cod_missao = $codMissao
                AND data_conclusao is null
            ");
            if(mysqli_num_rows($pesquisa) > 0){
                $missaoUsuario = mysqli_fetch_array($pesquisa);
                $missao = mysqli_fetch_array(mysqli_query($conexao, "
                    SELECT * FROM gm_missoes
                    WHERE id = $codMissao
                "));

                include "usuario.php";

                /*

                1 - CONTEMPLAR EXPERIENCIA DA MISSAO
                2 - CONTEMPLAR RECOMPENSA DA MISSAO
                3 - DEFINIR DATA CONCLUSÃO DA MISSÃO            

                */

                adicionarXp($codJogador, $missao['xp']);
                creditarCoin($codJogador, $missao['recompensa'], 'Missão concluída: <strong>'.$missao['titulo'].'</strong>');
                mysqli_query($conexao, "
                    UPDATE gm_jogador_missao
                    SET data_conclusao = '".date("Y-m-d H:i:s")."'
                    WHERE codigo = ".$missaoUsuario['codigo']."
                ");
            }
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