<?php
	include "../conexao-banco.php";
	
    ?>
        <div class="row">
            <div class="col-12 col-md-12">
                <select name="ultimaEtapa" id="ultimaEtapa" onChange="registrarVencedores(<?php echo $_POST['campeonato'] ?>, '2', $('#ultimaEtapa').val());" class="form-control">
                    <option value="" hidden="hidden"> - Selecione a Etapa decisiva -</option>
                    <?php
                        $etapas = mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_campeonato = ".$_POST['campeonato']." ORDER BY cod_etapa DESC ");
                        while($etapa = mysqli_fetch_array($etapas)){
                            echo "<option value='".$etapa['cod_etapa']."'>".$etapa['cod_etapa']." - ".$etapa['nome']."</option>";
                        }
                    ?>
                </select>
            </div>

    <?php
    if($_POST['passo'] != 1){
        
    }
	switch($_POST['passo']){
		case 2: // PASSO 02 - PREENCHER FORM DE POSIÇÕES
            
			$aux = 0;
			$limite = 32;
			$sementes = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_semente WHERE cod_campeonato = ".$_POST['campeonato']." AND cod_etapa = ".$_POST['etapa']." ORDER BY numero ASC");
			$opcoes = "";
			while($seed = mysqli_fetch_array($sementes)){
				if($seed['cod_equipe'] == NULL){
					$inscricao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_jogador = ".$seed['cod_jogador']." AND cod_campeonato = ".$_POST['campeonato'].""));
					$opcoes .= "<option value='".$seed['codigo']."'>".$inscricao['conta']."</option>";
				}else{
					$equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$seed['cod_equipe'].""));
					$opcoes .= "<option value='".$seed['codigo']."'>".$equipe['nome']."</option>";
				}				
			}
			?>
				<form action="scripts/registrar-vencedores.php" method="post">                    
					<input type="text" name="campeonato" value="<?php echo $_POST['campeonato'] ?>" hidden="hidden">
					<input type="text" name="passo" value="3" hidden="hidden">
					<input type="text" name="etapa" value="<?php echo $_POST['etapa']; ?>" hidden="hidden">
					<input type="text" name="limite" value="<?php echo $limite; ?>" hidden="hidden">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <table cellpadding="0" cellspacing="0" id="tabelaLobbys" class="centralizar">
                                <tr>
                                    <td>#</td>
                                    <td>Semente</td>
                                    <td>P. e$</td>
                                    <td>P. R$</td>
                                    <td>Pontos</td>
                                    <td>Divisão</td>
                                </tr>
                                <?php
                                    while($aux < $limite){
                                        $posicao = $aux+1;
                                        $colocacao = mysqli_fetch_array(mysqli_query($conexao, "
                                            SELECT * FROM campeonato_premiacao 
                                            WHERE cod_campeonato = ".$_POST['campeonato']." 
                                            AND posicao = $posicao"));                                        
                                        ?>
                                            <tr>
                                                <td><?php echo "#".($aux+1); ?></td>
                                                <td>
                                                    <select name="colocado<?php echo $aux; ?>" id="" class="form-control">
                                                        <option value="" hidden="hidden" class="form-control">- SELECIONE A SEMENTE -</option>
                                                        <?php echo $opcoes; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="coin<?php echo $aux; ?>" placeholder="e$ xxx.xxx" size="15" readonly value="<?php echo $colocacao['premio_coin']; ?>" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" name="real<?php echo $aux; ?>" placeholder="R$ xxx.xxx" size="15" readonly value="<?php echo $colocacao['premio_real']; ?>" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" name="pontos<?php echo $aux; ?>" placeholder="0" size="15" readonly value="<?php echo number_format($colocacao['pontos'], 0); ?>" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" name="divisao<?php echo $aux; ?>" placeholder="---------" size="15" readonly value="<?php echo $colocacao['cod_divisao']; ?>" class="form-control">
                                                </td>
                                            </tr>
                                        <?php
                                        $aux++;
                                    }
                                ?>
                            </table>
                        </div>
                        <div class="col">
                            <input type="submit" value="ENVIAR" class="btn btn-dark">
                        </div>
                    </div>
										
				</form>			
			<?php			
			break;
		case 3: // VALIDAR E ENVIAR COLOCAÇÕES
			$aux = 0;
			$limite = $_POST['limite'];
			$datahora = date("Y-m-d H:i:s");
			$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_POST['campeonato']." "));
			$organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$campeonato['cod_organizacao'].""));
			
			$totalAtivos = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_partida_checkin
				INNER JOIN campeonato_partida ON campeonato_partida.codigo = campeonato_partida_checkin.cod_partida
				WHERE campeonato_partida.cod_campeonato = ".$campeonato['codigo']."
				GROUP BY campeonato_partida_checkin.cod_jogador
			"));
			
			if($totalAtivos > 1){
				mysqli_query($conexao, "UPDATE organizacao SET saldo_coin = saldo_coin + ($totalAtivos*30) WHERE codigo = ".$organizacao['codigo']." ");
			}
			
			while($aux < $limite){
				$nome = "colocado".$aux;
				$coin = "coin".$aux;
				$real = "real".$aux;
                $pontos = "pontos".$aux;
                $divisao = "divisao".$aux;
				if($_POST[$nome] != ""){
					$semente = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa_semente WHERE codigo = ".$_POST[$nome]." "));
                    $inscricao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_jogador = ".$semente['cod_jogador']." AND cod_campeonato = ".$campeonato['codigo']." "));
                    
                    // 1 - VERIFICAR SE TORNEIO É DE LIGA
                    // 2 - CASO SEJA, VERIFICAR INSCRIÇÃO NA LIGA -> CASO NÃO TENHO, CRIE UMA.
                    // 3 - VERIFICA AVANÇO DE DIVISÃO E REALIZA O TRATAMENTO
                    // 4 - CASO NÃO TENHO AVANÇO DE DIVISÃO, VERIFICA EXISTENCIA DE PONTUAÇÃO E REALIZA O TRATAMENTO.
                    
                    if($campeonato['cod_liga'] != NULL){ // CAMPEONATO PERTENCE A ALGUMA LIGA
                        $verificaInscricaoLiga = mysqli_query($conexao, "SELECT * FROM liga_inscricao WHERE cod_liga = ".$campeonato['cod_liga']." AND cod_jogador = ".$semente['cod_jogador']." ");
                        if(mysqli_num_rows($verificaInscricaoLiga) == 0){ // NÃO POSSUI INSCRIÇÃO NA LIGA, CRIAR UMA NA DIVISÃO ATUAL.
                            mysqli_query($conexao, "INSERT INTO liga_inscricao VALUES 
                            (".$campeonato['cod_liga'].", ".$campeonato['cod_divisao'].", ".$inscricao['cod_jogador'].", NULL, '".date("Y-m-d H:i:s")."', 0, '".$inscricao['conta']."', 0)");
                            if($inscricao['cod_equipe'] != NULL){
                                $lineUpInscricao = mysqli_query($conexao, "SELECT * FROM campeonato_lineup
                                WHERE cod_campeonato = ".$campeonato['codigo']."
                                AND cod_equipe = ".$inscricao['cod_equipe']."");
                                while($membroLineup = mysqli_fetch_array($liveUpInscricao)){
                                    mysqli_query($conexao, "INSERT INTO liga_inscricao_lineup
                                    VALUES (".$campeonato['cod_liga'].", ".$membroLineup['cod_jogador'].", ".$membroLineup['cod_equipe'].", ".$membroLineup['capitao'].")");
                                }
                            }
                        }
                        if($_POST[$divisao] != ""){ // POSSUI AVANÇO DE DIVISÃO
                            mysqli_query($conexao, "UPDATE liga_inscricao
                            SET cod_divisao = $_POST[$divisao],
                            pontos = 0,
                            status = 1
                            WHERE cod_liga = ".$campeonato['cod_liga']."
                            AND cod_jogador = ".$inscricao['cod_jogador']."");
                        }elseif($_POST[$pontos] > 0){ // PREMIAÇÃO EM PONTOS
                            mysqli_query($conexao, "UPDATE liga_inscricao
                            SET pontos = pontos + $_POST[$pontos]
                            WHERE cod_liga = ".$campeonato['cod_liga']."
                            AND cod_jogador = ".$inscricao['cod_jogador'].""); 
                        }
                    }
                    
                    if($semente['cod_equipe'] == NULL){	// INSCRIÇÕES SOLO
                        mysqli_query($conexao, "INSERT INTO campeonato_colocacao VALUES (".$_POST['campeonato'].", ".$semente['cod_jogador'].", NULL, ".($aux+1).", 0, 0)");	

                        if($_POST[$coin] != "" && $_POST[$coin] > 0){ // PREMIAÇÃO EM COIN
                            if($organizacao['saldo_coin'] >= $_POST[$coin]){ // ORGANIZAÇÃO POSSUI SALDO
                                mysqli_query($conexao, "UPDATE campeonato_colocacao SET premio_coin = $_POST[$coin] WHERE cod_campeonato = ".$_POST['campeonato']." AND cod_jogador = ".$semente['cod_jogador']."");

                                mysqli_query($conexao, "INSERT INTO log_coin VALUES (NULL, ".$semente['cod_jogador'].", ".$_POST[$coin].", 'Premiação torneio <strong>".$campeonato['nome']."</strong>', 1, '$datahora')");
                                mysqli_query($conexao, "UPDATE jogador SET pontos = pontos + ".$_POST[$coin]." WHERE codigo = ".$semente['cod_jogador']." ");
                            }										
                        }

                        if($_POST[$real] != "" && $_POST[$real] > 0){ // PREMIAÇÃO EM R$
                            if($organizacao['saldo_real'] >= $_POST[$real]){ // ORGANIZAÇÃO POSSUI SALDO
                                mysqli_query($conexao, "UPDATE campeonato_colocacao SET premio_real = $_POST[$real] WHERE cod_campeonato = ".$_POST['campeonato']." AND cod_jogador = ".$semente['cod_jogador']."");

                                mysqli_query($conexao, "INSERT INTO log_real VALUES (NULL, ".$semente['cod_jogador'].", ".$_POST[$real].", 'Premiação torneio <strong>".$campeonato['nome']."</strong>', 1, '$datahora')");
                                mysqli_query($conexao, "UPDATE jogador SET saldo = saldo + ".$_POST[$real]." WHERE codigo = ".$semente['cod_jogador']." ");
                            }										
                        }

                        if($_POST[$divisao] != NULL){
                            $infosDivisao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM liga_divisao WHERE codigo = $_POST[$divisao] "));
                            $pesquisaInscricao = mysqli_query($conexao, "SELECT * FROM liga_inscricao WHERE cod_liga = ".$infosDivisao['cod_liga']." AND cod_jogador = ".$semente['cod_jogador']."");
                            if(mysqli_num_rows($pesquisaInscricao) > 0){
                                mysqli_query($conexao, "UPDATE liga_inscricao SET cod_divisao = ".$infosDivisao['codigo'].", status = 1 WHERE cod_liga = ".$infosDivisao['cod_liga']." AND cod_jogador = ".$semente['cod_jogador']." ");
                            }else{
                                mysqli_query($conexao, " INSERT INTO liga_inscricao (cod_liga, cod_divisao, cod_jogador, datahora, status, conta) VALUES (".$infosDivisao['cod_liga'].", ".$infosDivisao['codigo'].", ".$semente['cod_jogador'].", '".date("Y-m-d H:i:s")."', 1, '".$inscricao['conta']."')");
                            }
                        }
                    }else{ // INSCRIÇÕES EM EQUIPE		
                        mysqli_query($conexao, "INSERT INTO campeonato_colocacao VALUES (".$_POST['campeonato'].", ".$semente['cod_jogador'].", ".$semente['cod_equipe'].", ".($aux+1).", 0, 0)");

                        if($_POST[$coin] != "" && $_POST[$coin] > 0){
                            if($organizacao['saldo_coin'] >= $_POST[$coin]){
                                mysqli_query($conexao, "UPDATE campeonato_colocacao SET premio_coin = $_POST[$coin] WHERE cod_campeonato = ".$_POST['campeonato']." AND cod_jogador = ".$semente['cod_jogador']."");

                                mysqli_query($conexao, "UPDATE equipe SET saldo_coin = saldo_coin + ".$_POST[$coin]." WHERE codigo = ".$semente['cod_equipe']." ");
                                mysqli_query($conexao, "INSERT INTO log_coin_equipe VALUES (NULL, ".$semente['cod_equipe'].", ".$_POST[$coin].", 'Premiação torneio <strong>".$campeonato['nome']."</strong>', 0, '".date("Y-m-d H:i:s")."')");
                            }						
                        }

                        if($_POST[$real] != "" && $_POST[$real] > 0){
                            if($organizacao['saldo_real'] >= $_POST[$real]){
                                mysqli_query($conexao, "UPDATE campeonato_colocacao SET premio_real = $_POST[$real] WHERE cod_campeonato = ".$_POST['campeonato']." AND cod_jogador = ".$semente['cod_jogador']."");

                                mysqli_query($conexao, "UPDATE equipe SET saldo_real = saldo_real + ".$_POST[$real]." WHERE codigo = ".$semente['cod_equipe']." ");
                                mysqli_query($conexao, "INSERT INTO log_real_equipe VALUES (NULL, ".$semente['cod_equipe'].", ".$_POST[$real].", 'Premiação torneio <strong>".$campeonato['nome']."</strong>', 0, '".date("Y-m-d H:i:s")."')");
                            }						
                        }

                        if($_POST[$divisao] != NULL){
                            $infosDivisao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM liga_divisao WHERE codigo = $_POST[$divisao] "));
                            $pesquisaInscricao = mysqli_query($conexao, "SELECT * FROM liga_inscricao WHERE cod_liga = ".$infosDivisao['cod_liga']." AND cod_equipe = ".$semente['cod_equipe']."");
                            if(mysqli_num_rows($pesquisaInscricao) > 0){
                                mysqli_query($conexao, "UPDATE liga_inscricao SET cod_divisao = ".$infosDivisao['codigo'].", status = 1 WHERE cod_liga = ".$infosDivisao['cod_liga']." AND cod_jogador = ".$semente['cod_jogador']." ");
                            }else{
                                mysqli_query($conexao, " INSERT INTO liga_inscricao (cod_liga, cod_divisao, cod_jogador, datahora, status, cod_equipe) VALUES (".$infosDivisao['cod_liga'].", ".$infosDivisao['codigo'].", ".$semente['cod_jogador'].", '".date("Y-m-d H:i:s")."', 1, ".$inscricao['cod_equipe'].")");
                            }
                        }
                    }
                }
				$aux++;
			}
			mysqli_query($conexao, "UPDATE campeonato SET status = 2 WHERE codigo = ".$campeonato['codigo']." ");
			$msg = "<li>O torneio <strong>".$campeonato['nome']."</strong> foi finalizado. A premiação será entregue pela organização de acordo com o descrito em seu regulamento.</li>";
			if($campeonato['tipo_inscricao'] == 0){
				$destinos = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']."");
			}else{
				$destinos = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$campeonato['codigo']." ");
			}
			while($destino = mysqli_fetch_array($destinos)){
				mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '".$msg."', ".$destino['cod_jogador'].", 0)");
			}
			
			// DEVOLVER ESCOIN INSCRIÇÕES INATIVAS
			
			if($campeonato['valor_escoin'] > 0){
				$inscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 0");
				while($inscricao = mysqli_fetch_array($inscricoes)){
					mysqli_query($conexao, "UPDATE jogador SET pontos = pontos + ".$campeonato['valor_coin']." WHERE codigo = ".$inscricao['cod_jogador']."");
					mysqli_query($conexoa, "INSERT INTO log_coin VALUES (NULL, ".$inscricao['cod_jogador'].", ".$campeonato['valor_escoin'].", 'Devolução de inscrição campeonato: <strong>".$campeonato['nome']."</strong>', 1, '$datahora')");
				}
			}
			
			// DEVOLVER REAL INSCRIÇÕES INATIVAS
			
			if($campeonato['valor_real'] > 0){
				$inscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 0");
				while($inscricao = mysqli_fetch_array($inscricoes)){
					mysqli_query($conexao, "UPDATE jogador SET saldo = saldo + ".$campeonato['valor_real']." WHERE codigo = ".$inscricao['cod_jogador']."");
					mysqli_query($conexoa, "INSERT INTO log_real VALUES (NULL, ".$inscricao['cod_jogador'].", ".$campeonato['valor_real'].", 'Devolução de inscrição campeonato: <strong>".$campeonato['nome']."</strong>', 1, '$datahora')");
				}
			}
			
			// header("Location: ../organizacao/".$organizacao['codigo']."/painel/");
			break;
	}
    ?>
    </div>