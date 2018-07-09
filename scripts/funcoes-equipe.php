<?php
	if(isset($_POST['form'])){ // EXIBIR FORMULARIO
		include "../conexao-banco.php";
		switch($_POST['form']){
			case '1': // ADICIONAR JOGADOR
				?>				
				<form action="scripts/funcoes-equipe.php" method="post">   
					<input type="hidden" name="funcao" value="1">
					<input type="hidden" name="equipe" value="<?php echo $_POST['codequipe']; ?>">
                    
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label>Email de jogador</label>
                                <input type="text" name="email" placeholder="E-MAIL DO JOGADOR" class="form-control" autofocus>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <input type="submit" value="CONTRATAR" class="btn btn-dark">  
                        </div>
                    </div>
					
				</form>
				<?php
				break;
			case '2': // REMOVER JOGADOR
				?>
				
				<form action="scripts/funcoes-equipe.php" method="post">
					<input type="hidden" name="funcao" value="2">
					<input type="hidden" name="equipe" value="<?php echo $_POST['codequipe']; ?>">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label>Email de jogador</label>
                                <select name="jogador" id="" class="form-control">
                                <option value="" hidden=""> - JOGADOR - </option>
                                <?php
                                    $integrantes = mysqli_query($conexao, "SELECT *, jogador_equipe.status AS poder FROM jogador_equipe
                                    INNER JOIN jogador ON jogador.codigo = jogador_equipe.cod_jogador
                                    WHERE jogador_equipe.cod_equipe = ".$_POST['codequipe']."
                                    ORDER BY jogador.nick");
                                    while($integrante = mysqli_fetch_array($integrantes)){
                                        echo "<option value='".$integrante['codigo']."'>".$integrante['nick']." - ".$integrante['nome']." ".$integrante['sobrenome']."</options>";
                                    }
                                ?>
                            </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <input type="submit" value="DEMITIR" class="btn btn-dark">  
                        </div>
                    </div>
				</form>
				<?php
				break;
			case '3': // ENVIAR LOGO
				?>
				
				<form action="scripts/funcoes-equipe.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="funcao" value="3">
					<input type="hidden" name="equipe" value="<?php echo $_POST['codequipe']; ?>"><br>
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <input type="file" name="file" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <input type="submit" value="Enviar" class="btn btn-dark">  
                        </div>
                    </div>
				</form>
				<?php
				break;
		}
	}else{ // EXECUTAR FORMULARIO
		include "../conexao-banco.php";
		$datahora = date("Y-m-d H:i:s");
		switch($_POST['funcao']){
			case '1': // ADICIONAR JOGADOR
				$codContratado = mysqli_fetch_array(mysqli_query($conexao, "SELECT codigo FROM jogador WHERE email = '".$_POST['email']."'"));
				$codEquipe = $_POST['equipe'];				
				mysqli_query($conexao, "INSERT INTO jogador_equipe VALUES (".$codContratado['codigo'].", $codEquipe, '$datahora', 1)");
				header("Location: ../ptbr/time/".$codEquipe."/");
				break;
			case '2': // REMOVER JOGADOR
				$statusContrato = mysqli_fetch_array(mysqli_query($conexao, "SELECT status FROM jogador_equipe WHERE cod_jogador = ".$_POST['jogador']." AND cod_equipe = ".$_POST['equipe'].""));
				if($statusContrato['status'] == 2){
					$novoLider = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador_equipe WHERE cod_equipe = ".$_POST['equipe']." AND status != 2 ORDER BY rand()"));
					mysqli_query($conexao, "UPDATE jogador_equipe SET status = 2 WHERE cod_jogador = ".$novoLider['cod_jogador']." AND cod_equipe = ".$novoLider['cod_equipe']."");
				}
				mysqli_query($conexao, "DELETE FROM jogador_equipe WHERE cod_jogador = ".$_POST['jogador']." AND cod_equipe = ".$_POST['equipe']."");
				
				$nIntegrantes = mysqli_num_rows(mysqli_query($conexao, "SELECT cod_jogador FROM jogador_equipe WHERE cod_equipe = ".$_POST['equipe']." LIMIT 1"));
				header("Location: ../ptbr/time/".$_POST['equipe']."/");
				break;
			case '3': // ENVIAR LOGO
				if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
					$arquivo_tmp = $_FILES['file']['tmp_name'];
					$nome = $_FILES['file']['name'];
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
						$destino = '../img/equipes/'.$_POST['equipe']."/".$novoNome;
						if(file_exists("../img/equipes/".$_POST['equipe']."/")){
							@move_uploaded_file ($arquivo_tmp, $destino);
						}else{
							mkdir("../img/equipes/".$_POST['equipe']."/");
							@move_uploaded_file($arquivo_tmp, $destino);
						}
						mysqli_query($conexao, "UPDATE equipe SET logo = '../img/equipes/".$_POST['equipe']."/$novoNome' WHERE codigo = ".$_POST['equipe']."");
					}
				}
				// header("Location: ../ptbr/time/".$_POST['equipe']."/");
				break;
		}
	}
?>