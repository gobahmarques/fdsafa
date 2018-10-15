<?php
	include "../conexao-banco.php";
	$datahora = date("Y-m-d H:i:s");

	function abrirCaixa($caixa){
		include "../conexao-banco.php";
		$datahora = date("Y-m-d H:i:s");
		$aux = 0;
		$vetor[] = 0;
		$itens = mysqli_query($conexao, "SELECT * FROM caixa_produto WHERE cod_caixa = ".$caixa['codigo']." ORDER BY rand() ");
		$maisCaro = 0;
		while($item = mysqli_fetch_array($itens)){
			if($item['recompensa'] > $maisCaro){
				$maisCaro = $item['recompensa'];
			}
			$ocorrencias = $item['chance_drop'] * 100;
			$contador = 0;
			while($contador < $ocorrencias){
				$vetor[$aux] = $item['codigo'];
				$aux++;
				$contador++;
			}
		}
		$recompensa = rand(0,9999);		
		$recompensa = $vetor[$recompensa];
		
		$recompensa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM caixa_produto WHERE codigo = $recompensa "));
		$recompensa['maiscaro'] = $maisCaro;
		return $recompensa;
	}

	switch($_POST['funcao']){
		case "abrir": // ABRIR CAIXA
			$jogador = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$_POST['jogador'].""));
			$caixa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM caixa WHERE codigo = ".$_POST['caixa'].""));
			$jogador = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$_POST['jogador'].""));
			
			if($caixa['status'] == 1){
				$autorizacao = 1;
				if($_POST['tipo'] == 0){ // COMPRAR CHAVE COM eSCoin
					if($jogador['pontos'] >= $caixa['chave_coin']){ // POSSUI SALDO
						mysqli_query($conexao, "UPDATE jogador SET pontos = pontos - ".$caixa['chave_coin']." WHERE codigo = ".$jogador['codigo']."");
						mysqli_query($conexao, "INSERT INTO log_coin VALUES (NULL, ".$jogador['codigo'].", ".$caixa['chave_coin'].", 'Chave da caixa: <strong>".$caixa['nome']."</strong>', 0, '$datahora')");	
						mysqli_query($conexao, "INSERT INTO caixa_chave VALUES (NULL, ".$caixa['codigo'].", ".$jogador['codigo'].", NULL, 'coin', 1, NULL, ".$caixa['categoria'].")");
					}else{
						echo "0";
						$autorizacao = 0;
					}
				}else{ // COMPRAR CHAVE COM REAL
					if($jogador['saldo'] >= $caixa['chave_real']){ // POSSUI SALDO
						mysqli_query($conexao, "UPDATE jogador SET saldo = saldo - ".$caixa['chave_real']." WHERE codigo = ".$jogador['codigo']."");
						mysqli_query($conexao, "INSERT INTO log_real VALUES (NULL, ".$jogador['codigo'].", ".$caixa['chave_real'].", 'Chave da caixa: <strong>".$caixa['nome']."</strong>', 0, '$datahora')");
						mysqli_query($conexao, "INSERT INTO caixa_chave VALUES (NULL, ".$caixa['codigo'].", ".$jogador['codigo'].", NULL, 'real', 1, NULL, ".$caixa['categoria'].")");
					}else{
						echo "0";
						$autorizacao = 0;
					}
				}
				if($autorizacao == 1){
					
					$chave = mysqli_insert_id($conexao);
					mysqli_query($conexao, "UPDATE caixa SET saldo = saldo + ".$caixa['chave_coin']." WHERE codigo = ".$caixa['codigo']." ");

					$recompensa = abrirCaixa($caixa);

					if($recompensa['cod_produto'] != NULL){ // PRODUTO DA LOJA
						$produto = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM produto WHERE codigo = ".$recompensa['cod_produto']." "));

						// TIRAR SALDO DA CAIXA							
						mysqli_query($conexao, "UPDATE caixa SET saldo = saldo - ".$produto['valor']." WHERE codigo = ".$caixa['codigo']." ");

						if($caixa['saldo'] < $recompensa['maiscaro']){
							mysqli_query($conexao, "UPDATE caixa SET status = 0 WHERE codigo = ".$caixa['codigo']."");
						}

						// GERAR CUPOM							
						mysqli_query($conexao, "INSERT INTO produto_cupom VALUES (NULL, ".$produto['codigo'].", ".$jogador['codigo'].", ".$caixa['codigo'].", NULL, 0)");
						
						mysqli_query($conexao, "UPDATE caixa_chave SET recompensa = ".$recompensa['codigo'].", datahora = '$datahora', status = 2 WHERE codigo = $chave ");

					?>
						<div class="col-3 col-md-3">
							<img src="img/produtos/<?php echo $recompensa['cod_produto']; ?>/foto.png" alt="">		
						</div>
						<div class="col-9 col-md-9">
                            Seu cupom já está disponível na loja. Faça seu pedido gratuitamente.
						<?php
							echo "<h2>".$produto['nome']."</h2>";
						?>
						</div>
                        <div class="col-12 col-md-12">
                            <button type="button" onClick="window.location.reload();" class="btn btn-laranja">ABRIR OUTRA</button>
                        </div>
					<?php	
					}else{ // ESCOIN
						mysqli_query($conexao, "UPDATE caixa SET saldo = saldo - ".$recompensa['recompensa']." WHERE codigo = ".$caixa['codigo']."");
						mysqli_query($conexao, "UPDATE jogador SET pontos = pontos + ".$recompensa['recompensa']." WHERE codigo = ".$jogador['codigo']." ");
						mysqli_query($conexao, "INSERT INTO log_coin VALUES (NULL, ".$jogador['codigo'].", ".$recompensa['recompensa'].", 'Drop da Caixa: <strong>".$caixa['nome']."</strong>', 1, '$datahora')");

						mysqli_query($conexao, "UPDATE caixa_chave SET recompensa = ".$recompensa['codigo'].", datahora = '$datahora', status = 2 WHERE codigo = $chave ");

						$caixa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM caixa WHERE codigo = ".$caixa['codigo'].""));

						if($caixa['saldo'] < $recompensa['maiscaro']){
							mysqli_query($conexao, "UPDATE caixa SET status = 0 WHERE codigo = ".$caixa['codigo']."");
						}
					?>
						<div class="col-3 col-md-3 float-left">
						<?php
							if($recompensa['recompensa'] < 100){
							?>
								<img src="img/caixas/coins/100.png" class="coin" alt="">
							<?php	
							}elseif($recompensa['recompensa'] < 300){
							?>
								<img src="img/caixas/coins/300.png" class="coin" alt="">
							<?php	
							}elseif($recompensa['recompensa'] < 700){
							?>
								<img src="img/caixas/coins/700.png" class="coin" alt="">
							<?php	
							}elseif($recompensa['recompensa'] < 1500){
							?>
								<img src="img/caixas/coins/1500.png" class="coin" alt="">
							<?php	
							}else{
							?>
								<img src="img/caixas/coins/++.png" class="coin" alt="">
							<?php	
							}
						?>	
						</div>
						<div class="col-9 col-md-9 float-left">
                            Aqui está o seu prêmio:
                            <h2><?php echo "e$ ".number_format($recompensa['recompensa'], 0, '', '.'); ?></h2>
                        </div>
                        <div class="col-12 col-md-12">
                            <button type="button" onClick="window.location.reload();" class="btn btn-laranja">Abrir Outra</button>
                        </div>
					<?php
					}
                    
                    /* 
                        GATILHO DE GAMEFICAÇÃO 
                        
                        1 - Verificar se jogador possui a missão
                        2 - Caso positivo, acrescentar ao contador
                        3 - realizar tratamento
                    
                    */
                    
                    $pesquisaMissao10 = mysqli_query($conexao, "
                        SELECT * FROM gm_jogador_missao
                        WHERE cod_jogador = ".$jogador['codigo']."
                        AND cod_missao = 10
                    "); // ABRIR 3 CAIXAS DE ESPORTS
                    
                    $pesquisaMissao12 = mysqli_query($conexao, "
                        SELECT * FROM gm_jogador_missao
                        WHERE cod_jogador = ".$jogador['codigo']."
                        AND cod_missao = 12
                    "); // ABRIR 10 CAIXAS DE ESPORTS
                    
                    if(mysqli_num_rows($pesquisaMissao10) > 0){
                        $missao10 = mysqli_fetch_array($pesquisaMissao10);
                        mysqli_query($conexao, "
                            UPDATE gm_jogador_missao
                            SET contador = contador + 1
                            WHERE codigo = ".$missao10['codigo']."
                        ");
                        if(($missao10['contador'] + 1) >= 3){
                            include "gameficacao.php";
                            concluirMissao($jogador['codigo'], 10);
                        }
                    }
                    
                    if(mysqli_num_rows($pesquisaMissao12) > 0){
                        $missao12 = mysqli_fetch_array($pesquisaMissao12);
                        mysqli_query($conexao, "
                            UPDATE gm_jogador_missao
                            SET contador = contador + 1
                            WHERE codigo = ".$missao12['codigo']."
                        ");
                        if(($missao12['contador'] + 1) >= 10){
                            include "gameficacao.php";
                            concluirMissao($jogador['codigo'], 12);
                        }
                    }
                    
				}
			}			
			break;
		case "testar":
			$caixa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM caixa WHERE codigo = ".$_POST['caixa']." "));
			$recompensa = abrirCaixa($caixa);
						
			if($recompensa['cod_produto'] != NULL){ // PRODUTO DA LOJA
				$produto = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM produto WHERE codigo = ".$recompensa['cod_produto']." "));
			?>
				<div class="col-3 col-md-3">
					<img src="img/produtos/<?php echo $recompensa['cod_produto']; ?>/foto.png" alt="">			
				</div>
				<div class="col-9 col-md-9">
					<h2><?php echo $produto['nome']; ?></h2>
				</div>
			<?php	
			}else{ // ESCOIN
			?>
				<div class="col-3 col-md-3">
				<?php
					if($recompensa['recompensa'] < 100){
					?>
						<img src="img/caixas/coins/100.png" class="coin" alt="">
					<?php	
					}elseif($recompensa['recompensa'] < 300){
					?>
						<img src="img/caixas/coins/300.png" class="coin" alt="">
					<?php	
					}elseif($recompensa['recompensa'] < 700){
					?>
						<img src="img/caixas/coins/700.png" class="coin" alt="">
					<?php	
					}elseif($recompensa['recompensa'] < 1500){
					?>
						<img src="img/caixas/coins/1500.png" class="coin" alt="">
					<?php	
					}else{
					?>
						<img src="img/caixas/coins/++.png" class="coin" alt="">
					<?php	
					}
				?>		
				</div>
				<div class="col-9 col-md-9">
                    Este seria seu prêmio se tivesse valendo:
					<h2><?php echo "e$ ".number_format($recompensa['recompensa'], 0, '', '.'); ?></h2>
				</div>
                <div class="col-12 col-md-12">
                    <button type="button" onClick="window.location.reload();" class="btn btn-azul">Vamos tentar de novo?</button>
                </div>
			<?php
			}
			break;
	}

	
?>