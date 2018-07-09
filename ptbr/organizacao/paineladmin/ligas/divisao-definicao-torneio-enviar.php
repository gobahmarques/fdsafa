<?php	
	include "../../../../session.php";
	include "../../../../enderecos.php";

	$organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$_GET['codigo'].""));
	$formato = "Y-m-d H:i:s";

    $divisao = $_POST['codDivisao'];
    $divisaoInfos = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM liga_divisao WHERE codigo = $divisao "));
	$jogo = $_POST['codJogo'];
	$regiao = $_POST['regiao'];
	$nome = $_POST['nome'];
	$vagas = $_POST['vagas'];
	$inscricao = (int) $_POST['valor'];
	$inscricaoReal = (float) $_POST['valorReal'];
	$plataforma = $_POST['plataforma'];

	$link = $_POST['link'];
	$fusoHorario = $_POST['fusoHorario'];

	if($_POST['minprecheckin'] > 0){
		$precheckin = $_POST['minprecheckin'];
	}else{
		$precheckin = 0;
	}
    $dispInsc = $_POST['dispInsc'];

	$descricao = $_POST['descricao'];
	$regulamento = $_POST['regulamento'];
	$premiacao = $_POST['premiacao'];
	$cronograma = $_POST['cronograma'];

	$tipoInscricao = $_POST['tipoInsc'];

	if($tipoInscricao == 1){ // Pegar quantidade de jogador por time
		$qtdJogador = $_POST['jogTime'];
	}else{
		$qtdJogador = 1;
	}

	if($_POST['etapaPresencial'] == 0){ // Não haverá etapa presencial.
		$etapaPresencial = 0;
	}else{ // Haverá fase presencial.
		$etapaPresencial = 1;
	}

	$local = $_POST['local'];
	$pais = $_POST['pais'];

	if(isset($_POST['inscSolo'])){
		$inscSolo = 1;
	}else{
		$inscSolo = 0;
	}

	if($_POST['qtdPick'] == ""){
		$qtdPick = 0;
	}else{
		$qtdPick = $_POST['qtdPick'];
	}
	if($_POST['qtdBans'] == ""){
		$qtdBan = 0;
	}else{
		$qtdBan = $_POST['qtdBans'];
	}

    switch($_POST['funcao']){
        case "criarpadrao": // CRIAR PADRÃO DE CONFIGURAÇÕES DE TORNEIO
            mysqli_query($conexao, "INSERT INTO liga_divisao_campeonato VALUES ($divisao, $jogo, '$nome', $vagas, $qtdJogador, $inscricao, $inscricaoReal, '$regiao', '$descricao', '$regulamento', '$premiacao', '$cronograma', '".$divisaoInfos['logo_caminho']."', $tipoInscricao, '$fusoHorario', '$link', '$pais', '$local', $etapaPresencial, 0, $qtdPick, $qtdBan, '$plataforma', $precheckin, $dispInsc)");
            break;
        case "alterarpadrao": // ALTERAR PADRÃO JÁ CRIADO
            mysqli_query($conexao, "
                UPDATE liga_divisao_campeonato
                SET nome = '$nome',
                vagas = $vagas,
                jogador_por_time = $qtdJogador,
                valor_escoin = $inscricao,
                valor_real = $inscricaoReal,
                regiao = '$regiao',
                descricao = '$descricao',
                regulamento = '$regulamento',
                premiacao = '$premiacao',
                cronograma = '$cronograma',
                tipo_inscricao = $tipoInscricao,
                fuso_horario = '$fusoHorario',
                link = '$link',
                pais = '$pais',
                local = '$local',
                presencial = $etapaPresencial,
                qtd_pick = $qtdPick,
                qtd_ban = $qtdBan,
                plataforma = '$plataforma',
                precheckin = $precheckin,
                status_inscricao = $dispInsc
                WHERE cod_divisao = ".$divisaoInfos['codigo']."
            ");
            break;
    }

	// header("Location: campeonato/".$id."/");

	