<?php
	include "../session.php";

	switch($_POST['funcao']){
		case "carregarSubCategorias":
			$subcategorias = mysqli_query($conexao, "SELECT * FROM categoria_sub WHERE cod_categoria = ".$_POST['categoria']." ");
			while($sub = mysqli_fetch_array($subcategorias)){
				echo "<option value='".$sub['codigo']."'>".$sub['nome']."</option>";
			}
			break;
		case "carregarValorProduto":
			$produto = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM produto WHERE codigo = ".$_POST['produto'].""));
			echo $produto['valor'];
			break;
		case "addSaldoCaixa":
			$valor = $_POST['valor'];
			$organizacao = $_POST['organizacao'];			
			$organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = $organizacao"));
			$caixa = mysqli_fetch_array(mysqli_query($conexao, "SELECT codigo, saldo FROM caixa WHERE codigo = ".$_POST['caixa']." "));
			
			if($organizacao['saldo_coin'] >= $valor){ // Realiza o deposito
				if($caixa['saldo'] < 0){
					mysqli_query($conexao, "UPDATE caixa SET saldo = $valor WHERE codigo = ".$caixa['codigo']."");	
				}else{
					mysqli_query($conexao, "UPDATE caixa SET saldo = saldo + $valor WHERE codigo = ".$_POST['caixa']."");
				}				
				mysqli_query($conexao, "UPDATE organizacao SET saldo_coin = saldo_coin - $valor WHERE codigo = ".$organizacao['codigo']."");
				mysqli_query($conexao, "INSERT INT log_coin_organizacao VALUES (NULL, ".$organizacao['codigo'].", ".$usuario['codigo'].", $valor, 'Depósito na Caixa de ID ".$_POST['caixa']."', 0, '$datahora')");
			}else{
				echo "0";
			}	
			break;
		case "convidarJogador":
			
			/*
				1 - VERIFICA SE EMAIL EXISTE
				2 - VERIFICA SE JÁ ESTÁ INSCRITO NO TORNEIO
				3 - CASO 2 SEJA FALSO, REALIZA A INSCRIÇÃO
				4 - GERA UMA NOTIFICAÇÃO PARA O USUÁRIO
			*/
			
			$jogador = mysqli_query($conexao, "SELECT * FROM jogador WHERE email = '".$_POST['email']."' ");
			if(isset($jogador)){ // EXISTE JOGADOR COM O EMAIL INFORMADO
				$inscricao = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_jogador = ".$jogador['codigo']." AND cod_campeonato = ".$_POST['campeonato']." ");
				if(!isset($inscricao)){ // NÃO EXISTE INSCRIÇÃO
					mysqli_query($conexao, "INSERT INTO campeonato_inscricao VALUES (".$_POST['campeonato'].", ".$jogador['codigo'].", NULL, '".date("Y-m-d H:i:s")."', NULL, 1, NULL)");
				}else{ // JOGADOR JÁ INSCRITO NA COMPETIÇÃO
					
				}
			}
			
			break;
        case "atualizarInfos":
            $id = $_POST['codorganizacao'];
            $descricao = $_POST['descricao'];
            $email = $_POST['email'];
            $site = $_POST['site'];
            $facebook = $_POST['facebook'];
            $discord = $_POST['discord'];
            $twitter = $_POST['twitter'];
            $twitch = $_POST['twitch'];
            $azubu = $_POST['azubu'];
            $youtube = $_POST['youtube'];
            
            mysqli_query($conexao, "UPDATE organizacao
            SET descricao = '$descricao',
            email = '$email',
            site = '$site',
            facebook = '$facebook',
            discord = '$discord',
            twitter = '$twitter',
            twitch = '$twitch',
            azubu = '$azubu',
            youtube = '$youtube'
            WHERE codigo = $id");
            
            if(isset($_FILES['perfil']) && $_FILES['perfil']['error'] == 0){
                echo "existe foto<br>";
                $arquivo_tmp = $_FILES['perfil']['tmp_name'];
                $nome = $_FILES['perfil']['name'];
                // Pega a extensão
                $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
                // Converte a extensão para minúsculo
                $extensao = strtolower ( $extensao );

                if ( strstr ( '.jpg;.jpeg;.png', $extensao ) ) {
                    // Cria um nome único para esta imagem
                    // Evita que duplique as imagens no servidor.
                    // Evita nomes com acentos, espaços e caracteres não alfanuméricos
                    $novoNome = 'perfil.'.$extensao;
                    // Concatena a pasta com o nome
                    $destino = '../img/organizacoes/'.$id."/".$novoNome;
                    $destino2 = 'organizacoes/'.$id."/".$novoNome;
                    if(file_exists("../img/organizacoes/".$id."/")){
                        echo "existe pasta";
                        @move_uploaded_file ($arquivo_tmp, $destino);
                    }else{
                        mkdir("../img/organizacoes/".$id."/");
                        @move_uploaded_file($arquivo_tmp, $destino);
                    }
                    mysqli_query($conexao, "UPDATE organizacao SET perfil = '$destino2' WHERE codigo = $id");
                }
            }
            
            if(isset($_FILES['fotobanner']) && $_FILES['fotobanner']['error'] == 0){
                echo "existe foto<br>";
                $arquivo_tmp = $_FILES['fotobanner']['tmp_name'];
                $nome = $_FILES['fotobanner']['name'];
                // Pega a extensão
                $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
                // Converte a extensão para minúsculo
                $extensao = strtolower ( $extensao );

                if ( strstr ( '.jpg;.jpeg;.png', $extensao ) ) {
                    // Cria um nome único para esta imagem
                    // Evita que duplique as imagens no servidor.
                    // Evita nomes com acentos, espaços e caracteres não alfanuméricos
                    $novoNome = 'banner.'.$extensao;
                    // Concatena a pasta com o nome
                    $destino = '../img/organizacoes/'.$id."/".$novoNome;
                    $destino2 = 'organizacoes/'.$id."/".$novoNome;
                    if(file_exists("../img/organizacoes/".$id."/")){
                        echo "existe pasta";
                        @move_uploaded_file ($arquivo_tmp, $destino);
                    }else{
                        mkdir("../img/organizacoes/".$id."/");
                        @move_uploaded_file($arquivo_tmp, $destino);
                    }
                    mysqli_query($conexao, "UPDATE organizacao SET banner = '$destino2' WHERE codigo = $id");
                }
            }
            
            header("location: ../ptbr/organizacao/$id/painel/");     
            break;
	}
	// strtoupper(md5(uniqid(rand(), true)));
?>