<?php
	include "../enderecos.php";
	include "../session.php";
	
	mysqli_query($conexao, "UPDATE campeonato_partida SET status = ".$_POST['status']." WHERE cod_campeonato = ".$_POST['campeonato']." AND cod_etapa = ".$_POST['etapa']." AND status != 3 AND status != 2 ");
?>