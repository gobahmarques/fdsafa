<?php
	include "session.php";
    include "enderecos.php";


	$campeonato = $_GET['codigo'];
	$datahora = date("Y-m-d H:i:s");

	mysqli_query($conexao, "INSERT INTO campeonato_inscricao VALUES ($campeonato, ".$usuario['codigo'].", NULL, '$datahora', NULL, 0)");

	header("Location: campeonato/".$campeonato."/inscricao/");