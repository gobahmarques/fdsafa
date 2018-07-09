<?php	
	include "../../../../session.php";
	include "../../../../enderecos.php";

	$organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$_GET['codigo'].""));
	$formato = "Y-m-d H:i:s";

	$jogo = $_POST['codJogo'];
	$nome = $_POST['nome'];

	mysqli_query($conexao, "INSERT INTO liga VALUES (NULL, ".$organizacao['codigo'].", $jogo, '$nome', NULL, NULL)");

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
			$destino = '../../../../img/ligas/'.$id."/".$novoNome;
            $destino2 = 'img/ligas/'.$id."/".$novoNome;
			if(file_exists("../../../../img/ligas/".$id."/")){
				@move_uploaded_file ($arquivo_tmp, $destino);
			}else{
				mkdir("../../../../img/ligas/".$id."/");
				@move_uploaded_file($arquivo_tmp, $destino);
			}
			mysqli_query($conexao, "UPDATE liga SET logo_caminho = '$destino2' WHERE codigo = $id");
		}
	}

	// header("Location: ../../");

	