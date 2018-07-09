<?php
	include "../../../../session.php";
	include "../../../../enderecos.php";

	$codCampeonato = $_POST['codCampeonato'];
	$nome = $_POST['nome'];
	$vagas = $_POST['vagas'];
	$formatoPartidas = $_POST['formatoPartidas'];
	$disputaTerceiro = $_POST['disputaTerceiro'];
	$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = $codCampeonato"));

	echo $codCampeonato.", ".$nome.", ".$vagas.", ".$formatoPartidas.", ".$disputaTerceiro;

	$numEtapa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_campeonato = $codCampeonato ORDER BY cod_etapa DESC LIMIT 1"));
	$numEtapa = $numEtapa['cod_etapa'] + 1;

	mysqli_query($conexao, "INSERT INTO campeonato_etapa VALUES ($codCampeonato, $numEtapa, '$nome', 1, NULL, NULL, NULL, NULL, $formatoPartidas, $disputaTerceiro, $vagas, NULL, NULL, NULL)");

	$i = 0;

	while($i < $vagas){
		$i++;
		mysqli_query($conexao, "INSERT INTO campeonato_etapa_semente VALUES (NULL, $i, $numEtapa, $codCampeonato, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0)");		
	}
	
	include "../../../../scripts/gerar-jogos.php";
	jogosElimSimples($numEtapa, $codCampeonato, $vagas, $formatoPartidas, $disputaTerceiro, $conexao);
	byesElimSimples($numEtapa, $codCampeonato, $conexao);
	distribuirSementesElimSimples($numEtapa, $codCampeonato, $conexao);

	// header("Location: organizacao/".$campeonato['cod_organizacao']."/painel/campeonato/".$codCampeonato."/etapas/");
?>