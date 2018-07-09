<?php
	include "../session.php";	
	require "../conexao-banco.php";
	$email = $_POST['email'];
	$senha = sha1($_POST['senha']);

	$pesquisa = mysqli_query($conexao, "
		SELECT * FROM jogador WHERE email = '$email' AND senha = '$senha'
	");

	if(mysqli_num_rows($pesquisa) > 0){
		$dados = mysqli_fetch_array($pesquisa);
		mysqli_query($conexao, "DELETE FROM jogador_senha WHERE cod_jogador = ".$dados['codigo']." ");
		mysqli_query($conexao, "DELETE FROM login_autenticacao WHERE cod_jogador = ".$dados['codigo']." ");
		
		// AUTENTICACAO
		$token = sha1(uniqid(mt_rand()+time(),true));
		$expirar = (time() + (7*24*3600));
		mysqli_query($conexao, "INSERT INTO login_autenticacao VALUES (NULL, ".$dados['codigo'].", '$token', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')");
		
		$id = mysqli_insert_id($conexao);
		
		if(isset($_POST['remember']) && $_POST['remember'] == 1){ // LEMBRAR LOGIN						
			setcookie('auth', $id, $expirar);
		}else{
			setcookie('auth', $id, time() + 5);
		}
		
		if(!isset($_SESSION)){
			@ob_start();
			session_start();		
		}
		$_SESSION['codigo'] = $dados['codigo'];
		
		$dataHora = date("Y-m-d H:i:s");
		$diaAtual = date("Y-m-d");

		$pesquisaLogin = mysqli_query($conexao, "SELECT * FROM log_login WHERE cod_jogador = ".$dados['codigo']." AND date(datahora) = '$diaAtual'");

		if(mysqli_num_rows($pesquisaLogin) == 0){
			echo "0";
			mysqli_query($conexao, "UPDATE jogador SET pontos = pontos + 100 WHERE codigo = ".$dados['codigo']."");
			mysqli_query($conexao, "INSERT INTO log_coin VALUES (NULL, ".$dados['codigo'].", 100, 'Login diário', 1, '$dataHora')");
		}else{				
			echo "1";			
		}
		mysqli_query($conexao, "INSERT INTO log_login VALUES (NULL, ".$dados['codigo'].", '".date("Y-m-d H:i:s")."')");
		mysqli_query($conexao, "INSERT INTO login VALUES (".$dados['codigo'].", '".date("Y-m-d H:i:s")."')");	
	}else{
		$pesquisa = mysqli_query($conexao, "
			SELECT * FROM jogador_senha
			INNER JOIN jogador ON jogador.codigo = jogador_senha.cod_jogador
			WHERE jogador.email = '$email' AND jogador_senha.senha = '$senha'
		");
		if(mysqli_num_rows($pesquisa) != 0){
			$dados = mysqli_fetch_array($pesquisa);
			echo $dados['codigo'];
		}else{
			echo "2";
		}		
	}

	/*
	$pesquisa = mysqli_query($conexao, "
		SELECT * FROM jogador WHERE email = '$email' AND senha = '$senha'
	");

	if(mysqli_num_rows($pesquisa) != 0){
		$dados = mysqli_fetch_array($pesquisa);
		mysqli_query($conexao, "DELETE FROM jogador_senha WHERE cod_jogador = ".$dados['codigo']." ");
		
		// AUTENTICACAO
		
		$id = md5(uniqid(mt_rand(),true));
		$token = sha1(uniqid(mt_rand()+time(),true));
		$expirar = (time() + (7*24*3600));
		
		mysqli_query($conexao, "INSERT INTO login_autenticacao VALUES ('$id', ".$dados['codigo'].", '$token', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')");
		
		$cookieToken = array(
			"i" => $id,
			"token" => $token
		);
		setcookie('login',json_encode($cookieToken),$expirar,'/','http://localhost/esportscups/',isset( $_SERVER["HTTPS"] ),true);
		
		
		$_SESSION['codigo'] = $dados['codigo'];
		$dataHora = date("Y-m-d H:i:s");
		$diaAtual = date("Y-m-d");

		$pesquisaLogin = mysqli_query($conexao, "SELECT * FROM login WHERE cod_jogador = ".$dados['codigo']." AND date(dataHora) = '$diaAtual'");

		if(mysqli_num_rows($pesquisaLogin) == 0){
			echo "0";
			mysqli_query($conexao, "UPDATE jogador SET pontos = pontos + 100 WHERE codigo = ".$dados['codigo']."");
			mysqli_query($conexao, "INSERT INTO log_coin VALUES (NULL, ".$dados['codigo'].", 100, 'Login diário', 1, '$dataHora')");
		}else{				
			echo "1";					
		}

		$pesquisaLogin = mysqli_query($conexao, "SELECT * FROM login WHERE cod_jogador = ".$dados['codigo']."");

		if(mysqli_num_rows($pesquisaLogin) == 0){
			mysqli_query($conexao, "INSERT INTO login (dataHora, cod_jogador) VALUE ('$dataHora', ".$dados['codigo'].")");
		}else{
			mysqli_query($conexao, "UPDATE login SET dataHora = '$dataHora' WHERE cod_jogador = ".$dados['codigo']."");
		}
	}else{
		$pesquisa = mysqli_query($conexao, "
			SELECT * FROM jogador_senha
			INNER JOIN jogador ON jogador.codigo = jogador_senha.cod_jogador
			WHERE jogador.email = '$email' AND jogador_senha.senha = '$senha'
		");
		if(mysqli_num_rows($pesquisa) != 0){
			$dados = mysqli_fetch_array($pesquisa);
			echo $dados['codigo'];
		}else{
			echo "2";	
		}		
	}

	echo "<br><br>".sha1( uniqid( mt_rand() + time(), true ) );;
	*/
?>