<?php
	require "conexao-banco.php";   
	if(!isset($_SESSION)){
		@ob_start();
		session_start();
	}

    /* MODAL NEWSLETTER

    if(!isset($_COOKIE['modalNewsletter'])){        
        $exibirModal = true;
    }else{
        $exibirModal = false;
    }    
    
    */

    // MODAL RIFAS

    if(!isset($_COOKIE['modalRifas'])){        
        $exibirModal = true;
    }else{
        $exibirModal = false;
    }   


	if(isset($_COOKIE['auth'])){
		$autorizacao = mysqli_query($conexao, "SELECT * FROM login_autenticacao WHERE id = '".$_COOKIE['auth']."' ");		
		if(mysqli_num_rows($autorizacao) != 0){
			$autorizacao = mysqli_fetch_array($autorizacao);
			$diaAtual = date("Y-m-d");
			$pesquisaLogin = mysqli_query($conexao, "SELECT * FROM log_login WHERE cod_jogador = ".$autorizacao['cod_jogador']." AND date(dataHora) = '$diaAtual'");
			if(mysqli_num_rows($pesquisaLogin) == 0){
				mysqli_query($conexao, "UPDATE jogador SET pontos = pontos + 100 WHERE codigo = ".$autorizacao['cod_jogador']."");
				mysqli_query($conexao, "INSERT INTO log_coin VALUES (NULL, ".$autorizacao['cod_jogador'].", 100, 'Login diário', 1, '".date("Y-m-d H:i:s")."')");
				mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, 'Recompensa de Login Diário', ".$autorizacao['cod_jogador'].", 0)");
				mysqli_query($conexao, "INSERT INTO log_login VALUES (NULL, ".$autorizacao['cod_jogador'].", '".date("Y-m-d H:i:s")."')");
                
                // DAR MISSÃO PARA JOGADOR
                
                $missao = mysqli_fetch_array(mysqli_query($conexao, "
                    SELECT * FROM gm_missoes
                    ORDER BY rand()
                    LIMIT 1
                "));
                
                $qtdMissoesUsuario = mysqli_num_rows(mysqli_query($conexao, "
                    SELECT * FROM gm_jogador_missao
                    WHERE cod_jogador = ".$autorizacao['cod_jogador']."
                    AND data_conclusao is null
                "));

                $usuarioMissao = mysqli_query($conexao, "
                    SELECT * FROM gm_jogador_missao
                    WHERE cod_jogador = ".$autorizacao['cod_jogador']."
                    AND cod_missao = ".$missao['id']."
                    AND data_conclusao is null
                ");

                if($qtdMissoesUsuario < 3){
                    if(mysqli_num_rows($usuarioMissao) == 0){
                        mysqli_query($conexao, "
                            INSERT INTO gm_jogador_missao
                            VALUES
                            (NULL, ".$autorizacao['cod_jogador'].", ".$missao['id'].", '".date("Y-m-d")."', NULL, 0)
                        ");   
                    }else{
                        while(mysqli_num_rows($usuarioMissao) != 0){
                            $missao = mysqli_fetch_array(mysqli_query($conexao, "
                                SELECT * FROM gm_missoes
                                ORDER BY rand()
                                LIMIT 1
                            "));

                            $usuarioMissao = mysqli_query($conexao, "
                                SELECT * FROM gm_jogador_missao
                                WHERE cod_jogador = ".$autorizacao['cod_jogador']."
                                AND cod_missao = ".$missao['id']."
                                AND data_conclusao is null
                            ");    
                        }
                        mysqli_query($conexao, "
                            INSERT INTO gm_jogador_missao
                            VALUES
                            (NULL, ".$autorizacao['cod_jogador'].", ".$missao['id'].", '".date("Y-m-d")."', NULL, 0)
                        ");
                    }
                }
                
			}
			$_SESSION['codigo'] = $autorizacao['cod_jogador'];
		}else{
			setcookie("auth");
		}
	}
	if(isset($_SESSION['codigo'])){
		$usuario = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$_SESSION['codigo'].""));
		$datahora = date("Y-m-d H:i:s");
		mysqli_query($conexao, "UPDATE login SET datahora = '".date("Y-m-d H:i:s")."' WHERE cod_jogador = ".$usuario['codigo']." ");
	}
?>