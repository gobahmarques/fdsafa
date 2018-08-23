<?php	
	include "../../../../session.php";
	include "../../../../enderecos.php";

	$formato = "d/m/Y H:i:s";

	$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_POST['codCampeonato']." "));
	$regiao = $_POST['regiao'];
	$nome = $_POST['nome'];
	$plataforma = $_POST['plataforma'];

	$inicioTorneio = DateTime::createFromFormat($formato, $_POST['inicioTorneio']);
	$inicioTorneio = $inicioTorneio->format("Y-m-d H:i:s");

	$fimTorneio = DateTime::createFromFormat($formato, $_POST['fimTorneio']);
	$fimTorneio = $fimTorneio->format("Y-m-d H:i:s");

	$inicioInscricao = DateTime::createFromFormat($formato, $_POST['inicioInsc']);
	$inicioInscricao = $inicioInscricao->format("Y-m-d H:i:s");

	$fimInscricao = DateTime::createFromFormat($formato, $_POST['fimInsc']);
	$fimInscricao = $fimInscricao->format("Y-m-d H:i:s");

	$link = $_POST['link'];
	$fusoHorario = $_POST['fusoHorario'];

    
	$descricao = $_POST['descricao'];
	$regulamento = $_POST['regulamento'];
	$premiacao = $_POST['premiacao'];
	$cronograma = $_POST['cronograma'];
	$local = $_POST['local'];
	$pais = $_POST['pais'];


    $precheckin = $_POST['minprecheckin'];
    $vagas = $_POST['vagas'];



    

	mysqli_query($conexao, "UPDATE campeonato
	SET regiao = '$regiao', nome = '$nome', plataforma = '$plataforma', inicio = '$inicioTorneio', fim = '$fimTorneio',
	inicio_inscricao = '$inicioInscricao', fim_inscricao = '$fimInscricao', link = '$link', fuso_horario = '$fusoHorario',
	descricao = '$descricao', regulamento = '$regulamento', premiacao = '$premiacao', cronograma = '$cronograma', local = '$local',
	pais = '$pais', precheckin = $precheckin, vagas = $vagas WHERE codigo = ".$campeonato['codigo']."");

	if(isset($_FILES['thumb']) && $_FILES['thumb']['error'] == 0){
		$arquivo_tmp = $_FILES['thumb']['tmp_name'];
		$nome = $_FILES['thumb']['name'];
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
			$destino = '../img/campeonatos/'.$campeonato['codigo']."/".$novoNome;
			if(file_exists("../img/campeonatos/".$campeonato['codigo']."/")){
				@move_uploaded_file ($arquivo_tmp, $destino);
			}else{
				mkdir("../img/campeonatos/".$campeonato['codigo']."/");
				@move_uploaded_file($arquivo_tmp, $destino);
			}
			mysqli_query($conexao, "UPDATE campeonato SET thumb = '$destino' WHERE codigo = ".$campeonato['codigo']."");
		}
	}

	header("Location: ../../../organizacao/".$campeonato['cod_organizacao']."/painel/campeonato/".$campeonato['codigo']."/");

	