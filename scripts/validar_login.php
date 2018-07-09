<?php
	include "session.php";	
	require "conexao-banco.php";
	$email = $_POST['email'];
	$senha = sha1($_POST['senha']);
	
	$pesquisa = mysqli_query($conexao, "
		SELECT *.jogador, jogador_senha.senha AS senha2 FROM jogador_senha
		INNER JOIN jogador ON jogador.codigo = jogador_senha.cod_jogador
		WHERE (jogador.email = '$email' AND senha = '$senha')
		OR (jogador.email = '$email' AND jogador_senha.senha = '$senha')
	");
	
	if(mysqli_num_rows($pesquisa) == 1){
		$dados = mysqli_fetch_array($pesquisa);
		
		if($senha == $dados['senha']){
			mysqli_query($conexao, "DELETE FROM jogador_senha WHERE cod_jogador = ".$dados['codigo']." ");
			$_SESSION['codigo'] = $dados['codigo'];
			$dataHora = date("Y-m-d H:i:s");
			$diaAtual = date("Y-m-d");

			$pesquisaLogin = mysqli_query($conexao, "SELECT * FROM login WHERE cod_jogador = ".$dados['codigo']." AND date(dataHora) = '$diaAtual'");

			if(mysqli_num_rows($pesquisaLogin) == 0){
				echo "0";
				mysqli_query($conexao, "UPDATE jogador SET pontos = pontos + 100 WHERE codigo = ".$dados['codigo']."");						
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
			$_SESSION['codigo'] = $dados['codigo'];
			echo "3";
		}
	}else{
		
		if(mysqli_num_rows($pesquisa) == 1){
			echo "2";
		}else{
			
		}		
	}
?>