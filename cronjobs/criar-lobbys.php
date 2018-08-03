<?php
	include "../ptbr/conexao-banco.php";
	include "../ptbr/scripts/criar-lobby.php";
	$data = date("Y-m-d H:i:s");
	
	
	// DOTA 2 //

	mysqli_query($conexao, "INSERT INTO lobby VALUES (NULL, 357, 639282, 2, 5, '[eSC] Lobby Diário', '$data', 0, 0, NULL, 1, 1000)");
	$idLobby = mysqli_insert_id($conexao);
	criarTimes(2, 5, $idLobby);

	// mysqli_query($conexao, "INSERT INTO lobby VALUES (NULL, 357, 639282, 2, 5, '[eSC] Lobby Diário 02', '$data', 0, 0, NULL, 1, 2500)");
	//$idLobby = mysqli_insert_id($conexao);
	//criarTimes(2, 5, $idLobby);

	//mysqli_query($conexao, "INSERT INTO lobby VALUES (NULL, 357, 639282, 2, 5, '[eSC] Lobby Diário 03', '$data', 0, 0, NULL, 1, 5000)");
	//$idLobby = mysqli_insert_id($conexao);
	//criarTimes(2, 5, $idLobby);

	// HEARTHSTONE //

	mysqli_query($conexao, "INSERT INTO lobby VALUES (NULL, 369, 639282, 2, 1, '[eSC] Lobby Diário', '$data', 0, 0, NULL, 1, 200)");
	$idLobby = mysqli_insert_id($conexao);
	criarTimes(2, 1, $idLobby);

	//mysqli_query($conexao, "INSERT INTO lobby VALUES (NULL, 369, 639282, 2, 1, '[eSC] Lobby Diário 02', '$data', 0, 0, NULL, 1, 300)");
	//$idLobby = mysqli_insert_id($conexao);
	//criarTimes(2, 1, $idLobby);

	//mysqli_query($conexao, "INSERT INTO lobby VALUES (NULL, 369, 639282, 2, 1, '[eSC] Lobby Diário 03', '$data', 0, 0, NULL, 1, 500)");
	//$idLobby = mysqli_insert_id($conexao);
	//criarTimes(2, 1, $idLobby);

	// GWENT

	mysqli_query($conexao, "INSERT INTO lobby VALUES (NULL, 123, 639282, 2, 1, '[eSC] Lobby Diário', '$data', 0, 0, NULL, 1, 200)");
	$idLobby = mysqli_insert_id($conexao);
	criarTimes(2, 1, $idLobby);

	// LEAGUE OF LEGENDS //

	mysqli_query($conexao, "INSERT INTO lobby VALUES (NULL, 147, 639282, 2, 5, '[eSC] Lobby Diário', '$data', 0, 0, NULL, 1, 1000)");
	$idLobby = mysqli_insert_id($conexao);
	criarTimes(2, 5, $idLobby);

	//mysqli_query($conexao, "INSERT INTO lobby VALUES (NULL, 147, 639282, 2, 5, '[eSC] Lobby Diário 02', '$data', 0, 0, NULL, 1, 2500)");
	//$idLobby = mysqli_insert_id($conexao);
	//criarTimes(2, 5, $idLobby);

	//mysqli_query($conexao, "INSERT INTO lobby VALUES (NULL, 147, 639282, 2, 5, '[eSC] Lobby Diário 03', '$data', 0, 0, NULL, 1, 5000)");
	//$idLobby = mysqli_insert_id($conexao);
	//criarTimes(2, 5, $idLobby);

	// OVERWATCH //
	
	mysqli_query($conexao, "INSERT INTO lobby VALUES (NULL, 258, 639282, 2, 6, '[eSC] Lobby Diário', '$data', 0, 0, NULL, 1, 1200)");
	$idLobby = mysqli_insert_id($conexao);
	criarTimes(2, 6, $idLobby);

	//mysqli_query($conexao, "INSERT INTO lobby VALUES (NULL, 258, 639282, 2, 6, '[eSC] Lobby Diário 02', '$data', 0, 0, NULL, 1, 3000)");
	//$idLobby = mysqli_insert_id($conexao);
	//criarTimes(2, 6, $idLobby);

	//mysqli_query($conexao, "INSERT INTO lobby VALUES (NULL, 258, 639282, 2, 6, '[eSC] Lobby Diário 03', '$data', 0, 0, NULL, 1, 6000)");
	//$idLobby = mysqli_insert_id($conexao);
	//criarTimes(2, 6, $idLobby);
?>