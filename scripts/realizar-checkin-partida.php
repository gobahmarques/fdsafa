<?php
	include "../conexao-banco.php";
	$data = date("Y-m-d H:i:s");
	mysqli_query($conexao, "INSERT INTO campeonato_partida_checkin VALUES (".$_POST['partida'].", ".$_POST['jogador'].", '$data')");

	require "../../js/vendor/autoload.php";
	$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
	$pusher->trigger('partida'.$_POST['partida'], 'atualizar');
?>