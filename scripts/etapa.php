<?php
	function apagarEtapa($codEtapa, $codCampeonato){
		include "../conexao-banco.php";
		$partidas = mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_campeonato = $codCampeonato AND cod_etapa = $codEtapa");
		while($partida = mysqli_fetch_array($partidas)){
			mysqli_query($conexao, "DELETE FROM campeonato_partida_semente WHERE cod_partida = ".$partida['codigo']."");
			mysqli_query($conexao, "DELETE FROM campeonato_partida_checkin WHERE cod_partida = ".$partida['codigo']."");
			mysqli_query($conexao, "DELETE FROM campeonato_partida_chat WHERE cod_partida = ".$partida['codigo']."");
			mysqli_query($conexao, "DELETE FROM campeonato_partida_resultado WHERE cod_partida = ".$partida['codigo']."");
			mysqli_query($conexao, "DELETE FROM campeonato_partida WHERE codigo = ".$partida['codigo']."");
		}
		mysqli_query($conexao, "DELETE FROM campeonato_etapa_semente WHERE cod_etapa = $codEtapa AND cod_campeonato = $codCampeonato");
		mysqli_query($conexao, "DELETE FROM campeonato_etapa_grupo WHERE cod_campeonato = $codCampeonato AND cod_etapa = $codEtapa");
		mysqli_query($conexao, "DELETE FROM campeonato_etapa WHERE cod_campeonato = $codCampeonato AND cod_etapa = $codEtapa");
	}

	if(isset($_POST['funcao'])){
		switch($_POST['funcao']){
			case "resetar": // RESETAR ETAPA
				$datahora = date("Y-m-d H:i:s", strtotime("+15minutes", strtotime(date("Y-m-d H:i:s"))));
				$codEtapa = $_POST['etapa'];
				
				include "../conexao-banco.php";
				include "../enderecos.php";
				
				$partidas = mysqli_query($conexao, "SELECT codigo FROM campeonato_partida WHERE cod_etapa = $codEtapa AND cod_campeonato = ".$_POST['campeonato']." AND status != 3");
				$etapa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_campeonato = ".$_POST['campeonato']." AND cod_etapa = $codEtapa "));

				while($partida = mysqli_fetch_array($partidas)){
					mysqli_query($conexao, "DELETE FROM campeonato_partida_semente WHERE cod_partida = ".$partida['codigo']."");
					mysqli_query($conexao, "DELETE FROM campeonato_partida_resultado WHERE cod_partida = ".$partida['codigo']."");
					mysqli_query($conexao, "DELETE FROM campeonato_partida_checkin WHERE cod_partida = ".$partida['codigo']."");
					mysqli_query($conexao, "DELETE FROM campeonato_partida_chat WHERE cod_partida = ".$partida['codigo']."");
					mysqli_query($conexao, "DELETE FROM campeonato_partida WHERE codigo = ".$partida['codigo']."");
				}
				$sementes = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_semente WHERE cod_campeonato = ".$_POST['campeonato']." AND cod_etapa = ".$etapa['cod_etapa']." ");
				while($seed = mysqli_fetch_array($sementes)){
					mysqli_query($conexao, "
						UPDATE campeonato_etapa_semente
						SET total_jogos = 0, vitorias = 0, empates = 0, derrotas = 0, partidas_pro = 0, partidas_contra = 0
						WHERE codigo = ".$seed['codigo']."
					");
				}
				include "gerar-jogos.php";
				
				switch($etapa['tipo_etapa']){
					case 1: // ELIMINAÇÃO SIMPLES
						jogosElimSimples($codEtapa, $_POST['campeonato'], $etapa['vagas'], $etapa['formato_partidas'], $etapa['desempate']);
						distribuirSementesElimSimples($codEtapa, $_POST['campeonato']);
						break;
					case 2: // GRUPO PONTOS CORRIDOS
						$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_POST['campeonato']." "));
						jogosPontosCorridos($etapa, $campeonato);
						break;
					case 3: // ELIMINAÇÃO SIMPLES
						jogosElimDupla($codEtapa, $_POST['campeonato'], $etapa['vagas'], $etapa['formato_partidas'], $etapa['desempate']);
						distribuirSementesElimDupla($codEtapa, $_POST['campeonato']);
						break;
				}
				break;
			case "apagar": // DELETAR ETAPA
				apagarEtapa($_POST['etapa'], $_POST['campeonato']);
				include "../conexao-banco.php";
				$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_POST['campeonato']." "));
				header("Location: ../organizacao/".$campeonato['cod_organizacao']."/painel/campeonato/".$campeonato['codigo']."/");
				break;
			case "carregarjogadores": // CARREGAR JOGADORES
				include "../conexao-banco.php";
				if($_POST['etapa'] == 0){ // CARREGAR TODAS AS INSCRIÇÕES DO CAMPEONATO
					$inscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$_POST['campeonato']." AND status = 1");
					$etapa['vagas'] = 0;
				}else{
					$inscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_semente WHERE cod_campeonato = ".$_POST['campeonato']." AND cod_etapa = ".$_POST['etapa']." ORDER BY vitorias DESC, empates DESC, derrotas DESC");
				}
				?>  
                    <thead>
                        <tr>
                            <td></td>
                            <td>Conta/Equipe</td>
                            <td>Semente</td>
                        </tr>
                    </thead>  
				<?php
				$contador = 0;
				while($seed = mysqli_fetch_array($inscricoes)){
					$contador++;
					if($seed['cod_equipe'] == NULL){
						if($seed['cod_jogador'] != NULL){ // MOSTRAR JOGADOR
							$inscricao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_jogador = ".$seed['cod_jogador']." AND cod_campeonato = ".$_POST['campeonato']." "));
							?>
								<tr>
									<td class="checkbox">
										<input type="checkbox" name="inscricao[]" class="limitado3" value="<?php echo $seed['cod_jogador']." 0"; ?>" >
										<label for="checkbox"></label>
									</td>
									<td class="nome"><?php echo $inscricao['conta']; ?></td>
									<td>
									<?php
										if(isset($seed['numero'])){ // É SEMENTE
											echo "# ".$seed['numero'];
										}else{
											echo "---";
										}
									?>										
									</td>
								</tr>
							<?php							
						}
					}else{ // PARTIDA ENTRE EQUIPES
						$inscricao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_jogador = ".$seed['cod_jogador']." AND cod_campeonato = ".$_POST['campeonato']." "));
						$equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$seed['cod_equipe']." "));
						?>
							<tr>
								<td class="checkbox"><input type="checkbox" name="inscricao[]" class="limitado" value="<?php echo $seed['cod_jogador']." ".$seed['cod_equipe']; ?>" id="" <?php if($contador <= $_POST['vagas']){ echo "checked='checked'"; } ?>>
								<label for="checkbox"></label></td>
								<td><?php echo $equipe['nome']; ?></td>
								<td>
								<?php
									if(isset($seed['numero'])){ // ´É SEMENTE
										echo "#".$seed['numero'];
									}else{
										echo "---";
									}
								?>										
								</td>
							</tr>
						<?php
					}					
				}
				
				break;
            case "carregarJogadoresSemSemente":
                include "../conexao-banco.php";
                $jogadores = mysqli_query($conexao, "
                    SELECT * FROM campeonato_inscricao
                    WHERE cod_campeonato = ".$_POST['campeonato']."
                    AND status = 1
                ");
                ?>
                    <form method="post" action="ptbr/organizacao/paineladmin/campeonatos/painel-sementes-enviar.php">
                        <input type="hidden" value="" name="codSemente" class="codSemente">
                        <input type="hidden" value="preencherSemente" name="funcao">
                        <input type="hidden" value="<?php echo $_POST['etapa']; ?>" name="codEtapa">
                        <input type="hidden" value="<?php echo $_POST['campeonato']; ?>" name="codCampeonato">
                        
                        <div class="row">
                            <div class="col-8 col-md-8">
                                <select class="form-control" name="codInscricao">
                                <?php
                                    while($jogador = mysqli_fetch_array($jogadores)){
                                    ?>
                                        <option value="<?php echo $jogador['cod_jogador']; ?>">
                                        <?php
                                            if($jogador['cod_equipe'] == NULL){
                                                echo $jogador['conta'];
                                            }else{
                                                $equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome FROM equipe WHERE codigo = ".$jogador['cod_equipe']." "));
                                                echo $equipe['nome'];
                                            }
                                        ?>
                                        </option>
                                    <?php
                                    }
                                ?>
                                </select>                            
                            </div>
                            <div class="col-4 col-md-4">
                                <input type="submit" value="PREENCHER" class="btn btn-dark" />
                            </div>
                        </div>
                    </form>
                <?php
                break;
		}
	}

?>