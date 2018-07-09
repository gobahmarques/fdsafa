<?php
	include "../session.php";
	mysqli_query($conexao, "DELETE FROM login_autenticacao WHERE cod_jogador = ".$usuario['codigo']." ");
	session_destroy();
	header ("Location: https://www.esportscups.com.br/ptbr/");
?>