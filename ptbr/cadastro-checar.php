<?php
	include "../session.php";
	$usuario = $_POST['email'];
	
	$pesquisa = mysqli_query($conexao, "SELECT * FROM jogador WHERE email = '$usuario'");
	
	if(mysqli_num_rows($pesquisa) != 0){
		echo "<font color='#f60'>O e-mail informado já está sendo utilizado!</font><br><br>";		
	}else{
		if(!isset($_SESSION)){
			session_start();
		}
		$_SESSION['nome'] = $_POST['nome'];
		$_SESSION['sobrenome'] = $_POST['sobrenome'];
		$_SESSION['nick'] = $_POST['nick'];
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['senha'] = $_POST['senha'];
        $_SESSION['dataNascimento'] = $_POST['dataNascimento'];
        $_SESSION['sexo'] = $_POST['sexo'];
		echo "0";
	}
?>