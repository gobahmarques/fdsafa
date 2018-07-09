<?php
	include "session.php";
	include "enderecos.php";

	$dataSorteio = $_POST['dataSorteio']." ".$_POST['horaSorteio'];
	
	if(isset($_POST['funcao'])){
		switch($_POST['funcao']){
			case "criar":
				mysqli_query($conexao, "INSERT INTO rifa VALUES (NULL, '".$_POST['nome']."', ".$_POST['minCupons'].", ".$_POST['maxCupons'].", ".$_POST['precoCupom'].", ".$_POST['precoCupomCoin'].", '$dataSorteio', '".$_POST['nomeProduto']."', ".$_POST['precoProduto'].", '".$_POST['linkProduto']."', 'ok', 0)");
				$id = mysqli_insert_id($conexao);
				
				header("Location: painel/rifas/");
				break;
			case "alterar":
								
				header("Location: painel/artigos/$id/");
				break;
		}
	}
	
	if(isset($_FILES['thumb']) && $_FILES['thumb']['error'] == 0){
		$arquivo_tmp = $_FILES['thumb']['tmp_name'];
		$nome = $_FILES['thumb']['name'];
		// Pega a extensão
		$extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
		// Converte a extensão para minúsculo
		$extensao = strtolower ( $extensao );
			
		if ( strstr ( '.jpg;.jpeg;.png;.gif', $extensao ) ) {
			// Cria um nome único para esta imagem
			// Evita que duplique as imagens no servidor.
			// Evita nomes com acentos, espaços e caracteres não alfanuméricos
			$novoNome = $id.'.'.$extensao;
			// Concatena a pasta com o nome
			$destino = '../img/rifas/'.$id."/".$novoNome;
			if(file_exists("../img/rifas/".$id."/")){
				@move_uploaded_file ($arquivo_tmp, $destino);
			}else{
				mkdir("../img/rifas/".$id."/");
				@move_uploaded_file($arquivo_tmp, $destino);
			}
			mysqli_query($conexao, "UPDATE rifa SET foto_produto = '$novoNome' WHERE codigo = $id");
		}
	}



	/*
	$autor = $_POST['codautor'];
	$jogo = $_POST['codjogo'];
	$descricao = addslashes($_POST['descricao']);
	$artigo = addslashes($_POST['artigo']);

	

	
	*/