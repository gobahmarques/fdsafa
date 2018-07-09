<?php
	require "conexao-banco.php";   
	if(!isset($_SESSION)){
		@ob_start();
		session_start();
	}
    if(!isset($_COOKIE['modalNewsletter'])){        
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