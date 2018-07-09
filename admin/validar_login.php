<?php
	include "session.php";	
	$email = $_POST['email'];
	$senha = sha1($_POST['senha']);

	$pesquisa = mysqli_query($conexao, "
		SELECT * FROM jogador WHERE email = '$email' AND senha = '$senha'
	");

	if(mysqli_num_rows($pesquisa) != 0){		
		$dados = mysqli_fetch_array($pesquisa);
		$pesquisaCargo = mysqli_query($conexao, "SELECT * FROM funcionario WHERE codigo = ".$dados['codigo']." ");
		if(mysqli_num_rows($pesquisaCargo) != 0){
			$_SESSION['codigo'] = $dados['codigo'];			
			echo "1";	
		}else{
			echo "0";
		}	
	}else{
		echo "2";	
	}
?>