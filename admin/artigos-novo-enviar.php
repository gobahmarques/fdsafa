<?php
	include "session.php";
	include "enderecos.php";

	$nome = $_POST['nome'];
	$autor = $_POST['codautor'];
	$jogo = $_POST['codjogo'];
	$descricao = addslashes($_POST['descricao']);
	$artigo = addslashes($_POST['artigo']);

	if(isset($_POST['funcao'])){
		switch($_POST['funcao']){
			case "criar":
				mysqli_query($conexao, "INSERT INTO artigos VALUES (NULL, '$nome', '$descricao', '$artigo', $autor, '".date("Y-m-d H:i:s")."', NULL, NULL)");
				$id = mysqli_insert_id($conexao);
				if($jogo != "" && $jogo != NULL){
					mysqli_query($conexao, "UPDATE artigos SET cod_jogo = $jogo WHERE codigo = $id");
				}
                ?>
                <script>
                    var img = "https://www.esportscups.com.br/img/logo.png";
                    var text = "Novo post publicado na e-Sports Cups";
                    var notificacao = new Notification("<?php echo $nome; ?>", {
                        body: text, icon: img
                    });

                    notificacao.onclick = function(){
                        window.open("https://www.esportscups.com.br/ptbr/artigo/<?php echo $id; ?>/");
                    };
                    setTimeout(notificacao.close.bind(notificacao), 5000);
                </script>
                <?php
				header("Location: painel/artigos/");
				break;
			case "alterar":
				$id = $_POST['codartigo'];
				echo $id."<br>".$descricao;
				mysqli_query($conexao, "UPDATE artigos SET nome = '$nome', descricao = '$descricao', artigo = '$artigo', autor = $autor WHERE codigo = $id");
				if($jogo != "" && $jogo != NULL){
					mysqli_query($conexao, "UPDATE artigos SET cod_jogo = $jogo WHERE codigo = $id");
				}
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
			
		if ( strstr ( '.jpg;.jpeg;.png', $extensao ) ) {
			// Cria um nome único para esta imagem
			// Evita que duplique as imagens no servidor.
			// Evita nomes com acentos, espaços e caracteres não alfanuméricos
			$novoNome = $id.'.'.$extensao;
			// Concatena a pasta com o nome
			$destino = '../img/artigos/'.$novoNome;
			if(file_exists("../img/artigos/")){
				@move_uploaded_file ($arquivo_tmp, $destino);
			}else{
				mkdir("../img/artigos/");
				@move_uploaded_file($arquivo_tmp, $destino);
			}
			mysqli_query($conexao, "UPDATE artigos SET thumb = '$novoNome' WHERE codigo = $id");
		}
	}
?>
