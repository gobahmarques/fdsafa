<?php
	require "conexao-banco.php";
	if(!isset($_SESSION)){
		@ob_start();
		session_start();
	}
	if(isset($_SESSION['codigo'])){
		$usuario = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$_SESSION['codigo'].""));
		$datahora = date("Y-m-d H:i:s");
		mysqli_query($conexao, "UPDATE login SET dataHora = '$datahora' WHERE cod_jogador = ".$usuario['codigo']." ");
	}
?>