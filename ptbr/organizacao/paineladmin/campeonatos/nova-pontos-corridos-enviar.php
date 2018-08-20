<?php
	include "../../../../session.php";
	include "../../../../enderecos.php";

	$codCampeonato = $_POST['codCampeonato'];
	$nome = $_POST['nome'];
	$vagas = $_POST['vagas'];
	$formatoPartidas = $_POST['formatoPartidas'];
	$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = $codCampeonato"));
	$formato = "d/m/Y H:i:s";
	$dataLimite = DateTime::createFromFormat($formato, $_POST['datalimite']);
	$dataLimite = $dataLimite->format("Y-m-d H:i:s");

	$numEtapa = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_campeonato = $codCampeonato ORDER BY cod_etapa DESC LIMIT 1"));
	$numEtapa = $numEtapa + 1;
	

	// CRIAR ETAPA

	mysqli_query($conexao, "INSERT INTO campeonato_etapa VALUES ($codCampeonato, $numEtapa, '$nome', 2, NULL, ".$_POST['vitoria'].", ".$_POST['empate'].", ".$_POST['derrota'].", $formatoPartidas, NULL, $vagas, ".$_POST['grupos'].", ".$_POST['classificados'].", '$dataLimite')");

	$etapa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_campeonato = $codCampeonato AND cod_etapa = $numEtapa"));

    echo $etapa['cod_etapa'];

	// CRIAR GRUPOS

	$aux = 1;	
	while($aux <= $_POST['grupos']){
		mysqli_query($conexao, "INSERT INTO campeonato_etapa_grupo VALUES (NULL, 'Grupo $aux', $codCampeonato,  $numEtapa)");
		$aux++;
	}
	
	// CRIAR SEMENTES

	$aux = 1;
	while($aux <= $_POST['vagas']){
		mysqli_query($conexao, "INSERT INTO campeonato_etapa_semente VALUES (NULL, $aux, $numEtapa, $codCampeonato, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0)");
		$aux++;
	}

	// DISTRIBUIR SEMENTES NOS GRUPOS

	$sementes = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_semente WHERE cod_etapa = $numEtapa AND cod_campeonato = $codCampeonato ORDER BY numero ASC");
	$aux = 0;
	while($seed = mysqli_fetch_array($sementes)){
		$seeds[$aux] = $seed['codigo'];
		$aux++;
	}

	$grupos = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_grupo WHERE cod_etapa = $numEtapa AND cod_campeonato = $codCampeonato ORDER BY codigo");
	$aux = 0;
	while($grupo = mysqli_fetch_array($grupos)){
		$pts[$aux] = $grupo['codigo'];
		$aux++;
	}

	$auxSeed = 0;
	$auxGrupo = 0;

	while($auxSeed < $_POST['vagas']){
		if($auxGrupo >= $_POST['grupos']){
			$auxGrupo = 0;
		}
		mysqli_query($conexao, "UPDATE campeonato_etapa_semente SET cod_grupo = ".$pts[$auxGrupo]." WHERE codigo = ".$seeds[$auxSeed]."");
		$auxSeed++;
		$auxGrupo++;
	}

	// CRIAR PARTIDAS & DISTRIBUIR SEMENTES NAS PARTIDAS

	include "../../../../scripts/gerar-jogos.php";
	jogosPontosCorridos($etapa, $campeonato);

	header("Location: ../../../organizacao/".$campeonato['cod_organizacao']."/painel/campeonato/".$codCampeonato."/etapas/");
?>