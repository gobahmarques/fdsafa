<?php
	include "../session.php";

	$partida = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE codigo = ".$_POST['codpartida']." "));
	$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT cod_organizacao FROM campeonato WHERE codigo = ".$partida['cod_campeonato'].""));

	if($_POST['datahora'] != ""){
		$formato = "d/m/Y H:i:s";
		$datahora = DateTime::createFromFormat($formato, $_POST['datahora']);
		$datahora = $datahora->format("Y-m-d H:i:s");
		mysqli_query($conexao, "UPDATE campeonato_partida SET datahora = '$datahora' WHERE codigo = ".$_POST['codpartida']." ");
	}

	if($_POST['placarUm'] != "" && $_POST['placarDois'] != ""){        
		$datahora = date("Y-m-d H:i:s");
		if($_POST['sementeUm'] != ""){
			mysqli_query($conexao, "DELETE FROM campeonato_partida_resultado WHERE cod_partida = ".$_POST['codpartida']." AND cod_semente = ".$_POST['sementeUm']." ");
			mysqli_query($conexao, "INSERT INTO campeonato_partida_resultado VALUES (".$_POST['codpartida'].", ".$_POST['sementeUm'].",".$_POST['placarUm'].", ".$_POST['placarDois'].", '$datahora')")or die (error());
		}		
		if($_POST['sementeDois'] != ""){
			mysqli_query($conexao, "DELETE FROM campeonato_partida_resultado WHERE cod_partida = ".$_POST['codpartida']." AND cod_semente = ".$_POST['sementeDois']." ");
			mysqli_query($conexao, "INSERT INTO campeonato_partida_resultado VALUES (".$_POST['codpartida'].", ".$_POST['sementeDois'].",".$_POST['placarUm'].", ".$_POST['placarDois'].", '$datahora')");
            echo mysqli_insert_id($conexao);
			
		}
	}

	if($_POST['resUm'] == 1 || $_POST['resUm'] == 2){
		include "partidas.php";
		resultadoPartida($_POST['codpartida']);
	}

    echo $_POST['resUm'];

	// header ("Location:  organizacao/".$campeonato['cod_organizacao']."/painel/campeonato/".$partida['cod_campeonato']."/etapa/".$partida['cod_etapa']."/");

?>