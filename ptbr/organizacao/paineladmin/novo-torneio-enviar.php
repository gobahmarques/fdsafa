<?php	
	include "../../../session.php";
	include "../../../enderecos.php";

	$organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$_GET['codigo'].""));
	$formato = "Y-m-d H:i:s";

	$jogo = $_POST['codJogo'];
	$regiao = $_POST['regiao'];
	$nome = $_POST['nome'];
	$vagas = $_POST['vagas'];
	$inscricao = (int) $_POST['valor'];
	$inscricaoReal = (float) $_POST['valorReal'];
	$plataforma = $_POST['plataforma'];

	echo $_POST['inicioData'];
	$inicioTorneio = $_POST['inicioData']." ".$_POST['inicioHora'].":00";
	$inicioTorneio = DateTime::createFromFormat($formato, $inicioTorneio);
	$inicioTorneio = $inicioTorneio->format("Y-m-d H:i:s");

	$fimTorneio = $_POST['fimData']." ".$_POST['fimHora'].":00";
	$fimTorneio = DateTime::createFromFormat($formato, $fimTorneio);
	$fimTorneio = $fimTorneio->format("Y-m-d H:i:s");

	$inicioInscricao = $_POST['inicioInscData']." ".$_POST['inicioInscHora'].":00";	
	$inicioInscricao = DateTime::createFromFormat($formato, $inicioInscricao);
	$inicioInscricao = $inicioInscricao->format("Y-m-d H:i:s");

	$fimInscricao = $_POST['fimInscData']." ".$_POST['fimInscHora'].":00";	
	$fimInscricao = DateTime::createFromFormat($formato, $fimInscricao);
	$fimInscricao = $fimInscricao->format("Y-m-d H:i:s");

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

	mysqli_query($conexao, "INSERT INTO campeonato VALUES (NULL, ".$organizacao['codigo'].", ".$usuario['codigo'].", $jogo, '$nome', $vagas, $qtdJogador, $inscricao, $inscricaoReal, '$inicioInscricao', '$fimInscricao', '$inicioTorneio', '$fimTorneio', '$regiao', '$descricao', '$regulamento', '$premiacao', '$cronograma', NULL, $tipoInscricao, '$fusoHorario', '$link', '$pais', '$local', $etapaPresencial, 0, 0, $qtdPick, $qtdBan, '$plataforma', $precheckin, NULL, $dispInsc, NULL)");

	$id = mysqli_insert_id($conexao);

	if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0){
		$arquivo_tmp = $_FILES['logo']['tmp_name'];
		$nome = $_FILES['logo']['name'];
		// Pega a extensão
		$extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
		// Converte a extensão para minúsculo
		$extensao = strtolower ( $extensao );
			
		if ( strstr ( '.jpg;.jpeg;.png', $extensao ) ) {
			// Cria um nome único para esta imagem
			// Evita que duplique as imagens no servidor.
			// Evita nomes com acentos, espaços e caracteres não alfanuméricos
			$novoNome = 'logo.'.$extensao;
			// Concatena a pasta com o nome
			$destino = '../img/campeonatos/'.$id."/".$novoNome;
			if(file_exists("../img/campeonatos/".$id."/")){
				@move_uploaded_file ($arquivo_tmp, $destino);
			}else{
				mkdir("../img/campeonatos/".$id."/");
				@move_uploaded_file($arquivo_tmp, $destino);
			}
			mysqli_query($conexao, "UPDATE campeonato SET thumb = '$destino' WHERE codigo = $id");
		}
	}

	// REGISTRAR PREMIAÇÃO AUTOMATICA

	$contador = 0;
	$totalCoin = $totalReal = 0;

	while($contador < 32){
		if($_POST['coin'.$contador] > 0 && $_POST['real'.$contador] > 0){ // TEM PREMIAÇÃO EM COIN E EM REAL
			mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, ($contador + 1), ".$_POST['coin'.$contador].", ".$_POST['real'.$contador].", NULL)");
			$totalCoin += $_POST['coin'.$contador];
			$totalReal += $_POST['real'.$contador];
		}else{
			if($_POST['coin'.$contador] > 0){
				mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, ($contador + 1), ".$_POST['coin'.$contador].", 0, NULL)");
				$totalCoin += $_POST['coin'.$contador];
			}elseif($_POST['real'.$contador] > 0){
				mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, ($contador + 1), 0, ".$_POST['real'.$contador].", NULL )");
				$totalReal += $_POST['real'.$contador];
			}
		}
		$contador++;
	}

	// REGISTRAR MOVIMENTAÇÃO ORGANIZACAO

	if($totalCoin > 0){
		mysqli_query($conexao, "INSERT INTO log_coin_organizacao VALUES (NULL, ".$organizacao['codigo'].", ".$usuario['codigo'].", $totalCoin, 'Premiação do Torneio: $nome', 0, '".date("Y-m-d H:i:s")."')");
		mysqli_query($conexao, "UPDATE organizacao SET saldo_coin = saldo_coin - $totalCoin WHERE codigo = ".$organizacao['codigo']." ");
	}
	if($totalReal > 0){
		mysqli_query($conexao, "INSERT INTO log_real_organizacao VALUES (NULL, ".$organizacao['codigo'].", ".$usuario['codigo'].", $totalReal, 'Premiação do Torneio: $nome', 0, '".date("Y-m-d H:i:s")."')");
		mysqli_query($conexao, "UPDATE organizacao SET saldo_real = saldo_real - $totalReal WHERE codigo = ".$organizacao['codigo']." ");
	}

	// header("Location: campeonato/".$id."/");

	