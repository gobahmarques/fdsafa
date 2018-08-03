<?php
	include "../../session.php";
	include "../../enderecos.php";

	$codCampeonato = $_POST['codCampeonato'];
	$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = $codCampeonato"));

	$data = date("Y-m-d H:i:s");	
	$funcao = $_POST['funcao'];
		
	$jogo = mysqli_query($conexao, "SELECT * FROM jogos
						INNER JOIN campeonato ON campeonato.cod_jogo = jogos.codigo
						WHERE campeonato.codigo = $codCampeonato");
	$jogo = mysqli_fetch_assoc($jogo);

	switch($jogo['abreviacao']){
		case "Hearthstone":
			switch($funcao){
				case "inscricao":
                    $heroi = $_POST['heroi'];					
                    $aux = 0;					
                    $listaHerois = "";
                    while($aux < $campeonato['qtd_pick']){
                        $listaHerois = $listaHerois.$heroi[$aux].";";
                        $aux++;
                    }

                    $draft = mysqli_query($conexao, "INSERT INTO campeonato_draft VALUES (".$campeonato['codigo'].", ".$usuario['codigo'].", '$data', '$listaHerois')");
                    mysqli_query($conexao, "INSERT INTO campeonato_inscricao VALUES (".$campeonato['codigo'].", ".$usuario['codigo'].", NULL, '$data', 0, '".$usuario['battletag']."', NULL, NULL)");	
					if($campeonato['valor_escoin'] > 0){ // INSCRIÇÃO PAGA COM ESCOIN
						if($usuario['pontos'] >= $camponato['valor_escoin']){
							mysqli_query($conexao, "UPDATE jogador SET pontos = pontos - ".$campeonato['valor_escoin']." WHERE codigo = ".$usuario['codigo']."");
							mysqli_query($conexao, "INSERT INTO log_coin VALUES (NULL, ".$usuario['codigo'].", ".$campeonato['valor_escoin'].", 'Inscrição campeonato: <strong>".$campeonato['nome']."</strong>', 0, '$data')");
                            mysqli_query($conexao, "UPDATE campeonato_inscricao SET log_coin = ".mysqli_insert_id($conexao).", status = 1 WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$usuario['codigo']."");
						}
					}elseif($campeonato['valor_real'] > 0){ // INSCRIÇÃO COM REAL
						if($usuario['saldo'] >= $camponato['valor_real']){                            
							mysqli_query($conexao, "UPDATE jogador SET saldo = saldo - ".$campeonato['valor_real']." WHERE codigo = ".$usuario['codigo']."");
							mysqli_query($conexao, "INSERT INTO log_real VALUES (NULL, ".$usuario['codigo'].", ".$campeonato['valor_real'].", 'Inscrição campeonato: <strong>".$campeonato['nome']."</strong>', 0, '$data')");
                            mysqli_query($conexao, "UPDATE campeonato_inscricao SET log_real = ".mysqli_insert_id($conexao).", status = 1 WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$usuario['codigo']."");
						}					
					}
					header("Location: ../campeonato/".$campeonato['codigo']."/inscricao/");
					break;
				case "alterar":
					$heroi = $_POST['heroi'];					
					$aux = 0;					
					$listaHerois = "";
					while($aux < $campeonato['qtd_pick']){
						$listaHerois = $listaHerois.$heroi[$aux].";";
						$aux++;
					}
					mysqli_query($conexao, "UPDATE campeonato_draft SET picks = '$listaHerois' WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$usuario['codigo']."");
					header("Location: ../campeonato/".$campeonato['codigo']."/inscricao/");
					break;
				case "ban":
					$heroi = $_POST['heroi'];
					$aux = 0;					
					$listaHerois = "";
					while($aux < $campeonato['qtd_ban']){
						$listaHerois = $listaHerois.$heroi[$aux].";";
						$aux++;
					}
					
					mysqli_query($conexao, "UPDATE campeonato_partida_semente SET bans = '$listaHerois' WHERE cod_semente = ".$_POST['codSemente']." AND cod_partida = ".$_POST['codPartida']."");
					
					require "../../js/vendor/autoload.php";
					$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
					$pusher->trigger('partida'.$_POST['codPartida'], 'atualizar', array('mensagem' => 'tudo ok'));
					
					header("Location: ../campeonato/".$campeonato['codigo']."/partida/".$_POST['codPartida']."/");
					break;
			}
			break;
		case "GWENT":
			switch($funcao){
				case "inscricao":
					if($campeonato['valor_escoin'] > 0){ // INSCRIÇÃO PAGA COM ESCOIN
						if($usuario['pontos'] >= $camponato['valor_escoin']){
							$faccao = $_POST['faccao'];					
							$aux = 0;					
							$listaFaccoes = "";
							while($aux < $campeonato['qtd_pick']){
								$listaFaccoes = $listaFaccoes.$faccao[$aux].";";
								$aux++;
							}
							$draft = mysqli_query($conexao, "INSERT INTO campeonato_draft VALUES (".$campeonato['codigo'].", ".$usuario['codigo'].", '$data', '$listaFaccoes')");
							mysqli_query($conexao, "INSERT INTO campeonato_inscricao VALUES (".$campeonato['codigo'].", ".$usuario['codigo'].", NULL, '$data', NULL, 0, '".$_POST['conta']."')");
							mysqli_query($conexao, "UPDATE jogador SET pontos = pontos - ".$campeonato['valor_escoin']." WHERE codigo = ".$usuario['codigo']."");
							mysqli_query($conexao, "INSERT INTO log_coin VALUES (NULL, ".$usuario['codigo'].", ".$campeonato['valor_escoin'].", 'Inscrição campeonato: <strong>".$campeonato['nome']."</strong>', 0, '$data')");
						}
					}elseif($campeonato['valor_real'] > 0){ // INSCRIÇÃO PAGA COM REAL
						if($usuario['saldo'] >= $camponato['valor_real']){
							$faccao = $_POST['faccao'];					
							$aux = 0;					
							$listaFaccoes = "";
							while($aux < $campeonato['qtd_pick']){
								$listaFaccoes = $listaFaccoes.$faccao[$aux].";";
								$aux++;
							}
							$draft = mysqli_query($conexao, "INSERT INTO campeonato_draft VALUES (".$campeonato['codigo'].", ".$usuario['codigo'].", '$data', '$listaFaccoes')");
							mysqli_query($conexao, "INSERT INTO campeonato_inscricao VALUES (".$campeonato['codigo'].", ".$usuario['codigo'].", NULL, '$data', NULL, 0, '".$_POST['conta']."')");
							mysqli_query($conexao, "UPDATE jogador SET saldo = saldo - ".$campeonato['valor_real']." WHERE codigo = ".$usuario['codigo']."");
							mysqli_query($conexao, "INSERT INTO log_real VALUES (NULL, ".$usuario['codigo'].", ".$campeonato['valor_real'].", 'Inscrição campeonato: <strong>".$campeonato['nome']."</strong>', 0, '$data')");
						}
					}else{ // INSCRIÇÃO GRATUITA
						$faccao = $_POST['faccao'];					
						$aux = 0;					
						$listaFaccoes = "";
						while($aux < $campeonato['qtd_pick']){
							$listaFaccoes = $listaFaccoes.$faccao[$aux].";";
							$aux++;
						}

						$draft = mysqli_query($conexao, "INSERT INTO campeonato_draft VALUES (".$campeonato['codigo'].", ".$usuario['codigo'].", '$data', '$listaFaccoes')");
						mysqli_query($conexao, "INSERT INTO campeonato_inscricao VALUES (".$campeonato['codigo'].", ".$usuario['codigo'].", NULL, '$data', NULL, 0, '".$_POST['conta']."')");	
					}				
					header("Location: ../campeonato/".$campeonato['codigo']."/inscricao/");
					break;
				case "alterar":
					$faccao = $_POST['faccao'];					
					$aux = 0;					
					$listaFaccoes = "";
					while($aux < $campeonato['qtd_pick']){
						$listaFaccoes = $listaFaccoes.$faccao[$aux].";";
						$aux++;
					}
					mysqli_query($conexao, "UPDATE campeonato_draft SET picks = '$listaFaccoes' WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$usuario['codigo']."");
					header("Location: ../campeonato/".$campeonato['codigo']."/inscricao/");
					break;
				case "ban":
					$heroi = $_POST['heroi'];
					$aux = 0;					
					$listaHerois = "";
					while($aux < $campeonato['qtd_ban']){
						$listaHerois = $listaHerois.$heroi[$aux].";";
						$aux++;
					}
					
					mysqli_query($conexao, "UPDATE campeonato_partida_semente SET bans = '$listaHerois' WHERE cod_semente = ".$_POST['codSemente']." AND cod_partida = ".$_POST['codPartida']."");
					
					require "../js/vendor/autoload.php";
					$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
					$pusher->trigger('partida'.$_POST['codPartida'], 'atualizar', array('mensagem' => 'tudo ok'));
					
					header("Location: ../campeonato/".$campeonato['codigo']."/partida/".$_POST['codPartida']."/");
					break;
			}
			break;
	};
?>