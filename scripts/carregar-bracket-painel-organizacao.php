<?php
	function elimSimples($etapa, $campeonato){
		include "../../../../enderecos.php";
		include "../../../../conexao-banco.php";
		$etapa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_etapa = $etapa AND cod_campeonato = $campeonato "));
		$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = $campeonato"));		
		$datahora = date("Y-m-d H:i:s");
	?>
		<div class="bracket" id="brackets">
			<div class="acoes">
				<input type="hidden" name="valZoom" id="valZoom" value="1">
				<div class="acao" onClick="maisZoom();">
					+
				</div>
				<div class="acao" onClick="menosZoom();">
					-
				</div>
			</div>
			<div class="pesquisa">
				
			</div>
			<?php
				$maxJogos = 2;
				while($maxJogos < $etapa['vagas']){
					$maxJogos *= 2;
				}
				$maxRounds = log($maxJogos, 2);
				$coluna = 1;
				$mTop = 0;
				$mBot = 20;
				$contador = 0;
				$xRound = 0;
				$avancoYpoly = 25;
			?>
			<svg class="jogostabelas" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				<g transform="scale(1)" id="elimSimples">
					<g>	<!-- MOSTRAR ROUNDS -->			
						<g>
						<?php
							while($coluna <= $maxRounds){
								// $partidas = mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$campeonato['codigo']." AND coluna = $coluna ORDER BY codigo ASC ");								
								?>
									<g class="round" transform="translate(<?php echo $xRound; ?>, 0)">
										<rect height="25" width="200" fill="#666"></rect>
										<text y="17" x="5" fill="#ccc">Rodada <?php echo $coluna; ?></text>
									</g>
								<?php
								$coluna++;
								$xRound += 210;
							}
						?>
						</g>
					</g>
					<g> <!-- MOSTRAR PARTIDAS -->	
					<?php
						$coluna = 1;
						$xPartida = 2;
						$yPartida = 50;
						$avancoYinicial = $yPartida;
						$avancoY = 75;
						while($coluna <= $maxRounds){
							$partidas = mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$campeonato['codigo']." AND coluna = $coluna ORDER BY codigo ASC LIMIT $maxJogos");
							if($coluna == 1){
								$alturaR1 = mysqli_num_rows($partidas) * 75 + 75;
							}
							while($partida = mysqli_fetch_array($partidas)){
								if($partida['status'] != 3){
									$ladoUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente 
										INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
										WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 1 "));
									$ladoDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente 
										INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
										WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 2 "));
									?>
										<a href="ptbr/campeonato/<?php echo $partida['cod_campeonato']; ?>/partida/<?php echo $partida['codigo']; ?>/">
											<g>
												

												<rect width="160" height="25" y="<?php echo $yPartida; ?>" x="<?php echo $xPartida; ?>" fill="#fff" stroke="#ccc" stroke-width="2"></rect>
												<rect width="25" height="25" y="<?php echo $yPartida; ?>" x="<?php echo $xPartida+160; ?>" fill="#ccc" stroke="#ccc" stroke-width="2"></rect>
												
												<?php
													if(!isset($ladoUm)){
														if($coluna != 1){	
															$jogoOrigem = ($partida['linha'] * 2) - 1;
															?>
																<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																<?php
																	echo "Vencedor de ".($coluna-1)."-".$jogoOrigem;
																?>
																</text>
															<?php														
														}else{	
														?>
															<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																A ser definido
															</text>
														<?php		
														}							
													}else{
														if($ladoUm['cod_jogador'] == NULL){ // MOSTRAR NUMERO DA SEMENTE
														?>
															<text y="<?php echo $yPartida+17; ?>" x="<?php echo $xPartida+2; ?>"><?php echo "Semente #".$ladoUm['numero'];	 ?></text>
														<?php
														}else{
															if($ladoUm['cod_equipe'] == NULL){ // BUSCAR E MOSTRAR JOGADOR
																$inscUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$ladoUm['cod_jogador'].""));
																$player = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$ladoUm['cod_jogador']." "));
																?>
																	<text y="<?php echo $yPartida+17; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																	<?php
																		echo $inscUm['conta'];
																	?>
																	</text>
																<?php
															}else{ // BUSCAR E MOSTRAR EQUIPE
																$equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$ladoUm['cod_equipe']." "));	
																?>
																	<text y="<?php echo $yPartida+17; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																	<?php
																		echo $equipe['nome'];
																	?>
																	</text>
																<?php
															}
														}										
													}
												?>		


												<rect width="160" height="25" y="<?php echo $yPartida+25; ?>" x="<?php echo $xPartida; ?>" fill="#fff" stroke="#ccc" stroke-width="2"></rect>	
												<rect width="25" height="25" y="<?php echo $yPartida+25; ?>" x="<?php echo $xPartida+160; ?>" fill="#ccc" stroke="#ccc" stroke-width="2"></rect>
												
												<!-- PLACARES -->
												
												<?php
													if($ladoUm['status'] == 1){ // VENCEDOR
													?>
														<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+168; ?>" fill="#f60" font-weight="bold" font-size="18"><?php echo $partida['placar_um']; ?></text>
													<?php	
													}else{
													?>
														<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+168; ?>" fill="#fff" font-weight="bold" font-size="18"><?php echo $partida['placar_um']; ?></text>
													<?php		
													}
									
													if($ladoDois['status'] == 1){ // VENCEDOR
													?>
														<text  width="25" height="25" y="<?php echo $yPartida+43; ?>" x="<?php echo $xPartida+168; ?>" fill="#f60" font-weight="bold" font-size="18"><?php echo $partida['placar_dois']; ?></text>
													<?php	
													}else{
													?>
														<text  width="25" height="25" y="<?php echo $yPartida+43; ?>" x="<?php echo $xPartida+168; ?>" fill="#fff" font-weight="bold" font-size="18"><?php echo $partida['placar_dois']; ?></text>
													<?php		
													}
												?>
												
												
												
												
												<?php
													if(!isset($ladoDois)){
														if($coluna != 1){	
															$jogoOrigem = ($partida['linha'] * 2) ;
															?>
																<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																<?php
																	echo "Vencedor de ".($coluna-1)."-".$jogoOrigem;
																?>
																</text>
															<?php														
														}else{	
														?>
															<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																A ser definido
															</text>
														<?php		
														}							
													}else{
														if($ladoDois['cod_jogador'] == NULL){ // MOSTRAR NUMERO DA SEMENTE
														?>
															<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+2; ?>"><?php echo "Semente #".$ladoDois['numero'];	 ?></text>
														<?php
														}else{
															if($ladoDois['cod_equipe'] == NULL){ // BUSCAR E MOSTRAR JOGADOR
																$inscDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$ladoDois['cod_jogador'].""));
																$player = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$ladoDois['cod_jogador']." "));
																?>
																	<text y="<?php echo $yPartida+43; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																	<?php
																		echo $inscDois['conta'];
																	?>
																	</text>
																<?php
															}else{ // BUSCAR E MOSTRAR EQUIPE
																$equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$ladoDois['cod_equipe']." "));	
																?>
																	<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																	<?php
																		echo $equipe['nome'];
																	?>
																	</text>
																<?php
															}
														}										
													}
												?>
												<g>
													<rect width="50" height="20" fill="#fff" stroke="#ccc" stroke-width="2" x="<?php echo $xPartida+100; ?>" y="<?php echo $yPartida+40; ?>"></rect>
													<text x="<?php echo $xPartida+117; ?>" y="<?php echo $yPartida+55; ?>" font-size="14" font-weight="bold" fill="#666"><?php echo $partida['coluna']."-".$partida['linha'] ?></text>
												</g>
												<rect width="165" height="50" fill="transparent" y="<?php echo $yPartida; ?>" x="<?php echo $xPartida; ?>"></rect>
											</g>
										</a>
										<?php
											if($coluna != $maxRounds){	
												?>
												<polyline points="<?php echo $xPartida+185; ?>,<?php echo $yPartida+25; ?> <?php echo $xPartida+195; ?>,<?php echo $yPartida+25; ?>" fill="white" stroke="#ccc" stroke-width="2"></polyline>
												<?php
												if(($partida['linha'] % 2) == 0){ // É PARTIDA PAR
												?>
													<polyline points="<?php echo $xPartida+195; ?>,<?php echo $yPartida+25; ?> <?php echo $xPartida+195; ?>,<?php echo $yPartida+25-$avancoYpoly; ?> <?php echo $xPartida+205; ?>,<?php echo $yPartida+25-$avancoYpoly; ?>" fill="white" stroke="#ccc" stroke-width="2"></polyline>
												<?php
												}else{ // É PARTIDA IMPAR
												?>
													<polyline points="<?php echo $xPartida+195; ?>,<?php echo $yPartida+25; ?> <?php echo $xPartida+195; ?>,<?php echo $yPartida+25+$avancoYpoly; ?> <?php echo $xPartida+205; ?>,<?php echo $yPartida+25+$avancoYpoly; ?>" fill="white" stroke="#ccc" stroke-width="2"></polyline>
												<?php	
												}	
											}
																										
																			
								}								
								$yPartida += $avancoY;
							}
							$avancoYpoly = $avancoYpoly + 37.5*pow(2, ($coluna-1));
							$xPartida += 205;
							$yPartida = $avancoY + 12;
							$avancoY = ($avancoY * 2);
							$coluna++;
						} 
						if($etapa['desempate'] != NULL && $etapa['desempate'] != 0){
							$avancoY /= 2;
							$yPartida = $avancoY/2 + 100;
							$xPartida = $xPartida - 170;
							
							$partida = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$campeonato['codigo']." AND coluna = $coluna AND linha = 1 ORDER BY codigo ASC "));
							$ladoUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente 
								INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
								WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 1 "));
							$ladoDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente 
								INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
								WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 2 "));			
							?>
							<a href="campeonato/<?php echo $partida['cod_campeonato']; ?>/partida/<?php echo $partida['codigo']; ?>/">
								<g>


									<rect width="160" height="25" y="<?php echo $yPartida; ?>" x="<?php echo $xPartida; ?>" fill="#fff" stroke="#ccc" stroke-width="2"></rect>
									<rect width="25" height="25" y="<?php echo $yPartida; ?>" x="<?php echo $xPartida+160; ?>" fill="#ccc" stroke="#ccc" stroke-width="2"></rect>

									<?php
										if(!isset($ladoUm)){
											if($coluna != 1){	
												$jogoOrigem = ($partida['linha'] * 2) - 1;
												?>
													<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
													<?php
														echo "Perdedor de ".($coluna-2)."-1";
													?>
													</text>
												<?php														
											}else{	
											?>
												<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
													A ser definido
												</text>
											<?php		
											}							
										}else{
											if($ladoUm['cod_jogador'] == NULL){ // MOSTRAR NUMERO DA SEMENTE
											?>
												<text y="<?php echo $yPartida+17; ?>" x="<?php echo $xPartida+2; ?>"><?php echo "Semente #".$ladoUm['numero'];	 ?></text>
											<?php
											}else{
												if($ladoUm['cod_equipe'] == NULL){ // BUSCAR E MOSTRAR JOGADOR
													$inscUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$ladoUm['cod_jogador'].""));
													$player = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$ladoUm['cod_jogador']." "));
													?>
														<text y="<?php echo $yPartida+17; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
														<?php
															echo $inscUm['conta'];
														?>
														</text>
													<?php
												}else{ // BUSCAR E MOSTRAR EQUIPE
													$equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$ladoUm['cod_equipe']." "));	
													?>
														<text y="<?php echo $yPartida+17; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
														<?php
															echo $equipe['nome'];
														?>
														</text>
													<?php
												}
											}										
										}
									?>		


									<rect width="160" height="25" y="<?php echo $yPartida+25; ?>" x="<?php echo $xPartida; ?>" fill="#fff" stroke="#ccc" stroke-width="2"></rect>	
									<rect width="25" height="25" y="<?php echo $yPartida+25; ?>" x="<?php echo $xPartida+160; ?>" fill="#ccc" stroke="#ccc" stroke-width="2"></rect>

									<!-- PLACARES -->

									<?php
										if($ladoUm['status'] == 1){ // VENCEDOR
										?>
											<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+168; ?>" fill="#f60" font-weight="bold" font-size="18"><?php echo $partida['placar_um']; ?></text>
										<?php	
										}else{
										?>
											<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+168; ?>" fill="#fff" font-weight="bold" font-size="18"><?php echo $partida['placar_um']; ?></text>
										<?php		
										}

										if($ladoDois['status'] == 1){ // VENCEDOR
										?>
											<text  width="25" height="25" y="<?php echo $yPartida+43; ?>" x="<?php echo $xPartida+168; ?>" fill="#f60" font-weight="bold" font-size="18"><?php echo $partida['placar_dois']; ?></text>
										<?php	
										}else{
										?>
											<text  width="25" height="25" y="<?php echo $yPartida+43; ?>" x="<?php echo $xPartida+168; ?>" fill="#fff" font-weight="bold" font-size="18"><?php echo $partida['placar_dois']; ?></text>
										<?php		
										}
									?>




									<?php
										if(!isset($ladoDois)){
											if($coluna != 1){	
												$jogoOrigem = ($partida['linha'] * 2) ;
												?>
													<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
													<?php
														echo "Perdedor de ".($coluna-2)."-2";
													?>
													</text>
												<?php														
											}else{	
											?>
												<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
													A ser definido
												</text>
											<?php		
											}							
										}else{
											if($ladoDois['cod_jogador'] == NULL){ // MOSTRAR NUMERO DA SEMENTE
											?>
												<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+2; ?>"><?php echo "Semente #".$ladoDois['numero'];	 ?></text>
											<?php
											}else{
												if($ladoDois['cod_equipe'] == NULL){ // BUSCAR E MOSTRAR JOGADOR
													$inscDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$ladoDois['cod_jogador'].""));
													$player = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$ladoDois['cod_jogador']." "));
													?>
														<text y="<?php echo $yPartida+43; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
														<?php
															echo $inscDois['conta'];
														?>
														</text>
													<?php
												}else{ // BUSCAR E MOSTRAR EQUIPE
													$equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$ladoUm['cod_equipe']." "));	
													?>
														<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
														<?php
															echo $equipe['nome'];
														?>
														</text>
													<?php
												}
											}										
										}
									?>
									<g>
										<rect width="50" height="20" fill="#fff" stroke="#ccc" stroke-width="2" x="<?php echo $xPartida+100; ?>" y="<?php echo $yPartida+40; ?>"></rect>
										<text x="<?php echo $xPartida+117; ?>" y="<?php echo $yPartida+55; ?>" font-size="14" font-weight="bold" fill="#666">3rd</text>
									</g>
									<rect width="165" height="50" fill="transparent" y="<?php echo $yPartida; ?>" x="<?php echo $xPartida; ?>"></rect>
								</g>
							</a>
							<?php
							
						}
					?>
					</g>					
				</g>						
			</svg>			
		</div>
		
		<script src="https://www.esportscups.com.br/js/jquery.js"></script>
		<script>
			function maisZoom(){
				var zoom = parseFloat($("#valZoom").val()) + 0.05;
				$("#elimSimples").attr("transform","scale("+zoom+")");
				$("#valZoom").val(zoom);
				$(".jogostabelas").attr("height",""+(<?php echo $alturaR1; ?>*zoom)+"");
			}
			function menosZoom(){
				var zoom = parseFloat($("#valZoom").val()) - 0.05;
				$("#elimSimples").attr("transform","scale("+zoom+")");
				$("#valZoom").val(zoom);
				$(".jogostabelas").attr("height",""+(<?php echo $alturaR1; ?>*zoom)+"");
			}
			
			var xTabela, yTabela, xMouse, yMouse, down=false, posicaoGeral, posicaoBracket;
			
			$("body").mouseup(function(e){
				down = false;
				posicaoGeral =$("#brackets").position();
				posicaoBracket =$("#elimSimples").position();
			})
			
			$(".jogostabelas").mousedown(function(e){
				down=true;
				posicaoGeral =$("#brackets").position();
				posicaoBracket =$("#elimSimples").position();
				
				xTabela = posicaoBracket.left - posicaoGeral.left - 190;
				yTabela = posicaoBracket.top - posicaoGeral.top - (50 * parseFloat($("#valZoom").val()));
				
				xMouse = e.pageX;
				yMouse = e.pageY;
				$(this).css("cursor","crosshair");
			});
			
			$(".jogostabelas").mousemove(function(e){
				if(down){
					var avancoX = (xMouse - e.pageX)*2;
					var avancoY = (yMouse - e.pageY)*2;
					//console.log(y+", "+newY+", "+top+", "+(top+(newY-y))); 
					$("#elimSimples").attr("transform", "scale("+parseFloat($("#valZoom").val())+") translate("+(xTabela + avancoX+180)+","+(yTabela + avancoY-1)+")");
				}
			});
			jQuery(function($){
				$(".jogostabelas").attr("height","<?php echo $alturaR1; ?>");
			});
		</script>
	<?php	
	}

	function gruposPontosCorridos($etapa, $campeonato){
		include "../../../../conexao-banco.php";
		$grupos = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_grupo WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_etapa = ".$etapa['cod_etapa']."");
		?>
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8">
                    <?php
                        while($grupo = mysqli_fetch_array($grupos)){
                        ?>
                            <div class="titulogrupo">
                                <?php echo $grupo['nome']; ?>
                            </div>
                            <a href="<?php echo "ptbr/campeonato/".$campeonato['codigo']."/etapa/".$etapa['cod_etapa']."/grupo/".$grupo['codigo']."/"; ?>">
                                <table class="grupopontoscorridos" cellspacing="0" cellpadding="0">			
                                    <thead>
                                        <tr>
                                            <td></td>										
                                            <td>J</td>
                                            <td>V</td>
                                            <td>D</td>
                                            <td>PP</td>
                                            <td>PC</td>
                                            <td>SP</td>
                                            <td>%</td>
                                            <td>PTS</td>
                                        </tr>
                                    </thead>
                                    <?php
                                        $seeds = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_semente WHERE cod_grupo = ".$grupo['codigo']." ORDER BY vitorias DESC, empates DESC, derrotas DESC, (partidas_pro - partidas_contra) DESC, partidas_pro DESC, partidas_contra ASC");
                                        while($seed = mysqli_fetch_array($seeds)){
                                            $totalPartidas = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente WHERE cod_semente = ".$seed['codigo'].""));
                                            $totalPartidasConcluidas = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente WHERE cod_semente = ".$seed['codigo']." AND status != 0"));
                                            if($seed['cod_jogador'] != NULL){ // SEMENTE PREENCHIDA							
                                                if($seed['cod_equipe'] != NULL){ // PARTIDA ENTRE EQUIPES
                                                    $equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$seed['cod_equipe'].""));								
                                                ?>
                                                    <tr>
                                                        <td class="nome"><?php echo $equipe['nome']; ?></td>

                                                        <td><?php echo $totalPartidas."/".$totalPartidasConcluidas; ?></td>
                                                        <td><?php echo $seed['vitorias']; ?></td>
                                                        <td><?php echo $seed['derrotas']; ?></td>
                                                        <td><?php echo $seed['partidas_pro']; ?></td>
                                                        <td><?php echo $seed['partidas_contra']; ?></td>
                                                        <td><?php echo $seed['partidas_pro'] - $seed['partidas_contra']; ?></td>
                                                        <td>
                                                        <?php 
                                                            if($totalPartidasConcluidas != 0){
                                                                echo number_format((($seed['vitorias'] / $totalPartidasConcluidas) * 100), 0, '.', '');	
                                                            }else{
                                                                echo "0";
                                                            }
                                                        ?>
                                                        </td>
                                                        <td><strong><?php echo ($seed['vitorias'] * $etapa['pts_vitoria']) + ($seed['empates'] * $etapa['pts_empate']) + ($seed['derrotas'] * $etapa['pts_derrota']); ?></strong></td>
                                                    </tr>
                                                <?php	
                                                }else{ // PARTIDA ENTRE JOGADORES
                                                    $inscricao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$seed['cod_jogador'].""));
                                                ?>
                                                    <tr>
                                                        <td class="nome"><?php echo $inscricao['conta']; ?></td>													
                                                        <td><?php echo $totalPartidasConcluidas."/".$totalPartidas; ?></td>
                                                        <td><?php echo $seed['vitorias']; ?></td>
                                                        <td><?php echo $seed['derrotas']; ?></td>
                                                        <td><?php echo $seed['partidas_pro']; ?></td>
                                                        <td><?php echo $seed['partidas_contra']; ?></td>
                                                        <td><?php echo $seed['partidas_pro'] - $seed['partidas_contra']; ?></td>
                                                        <td><?php 
                                                            if($totalPartidasConcluidas != 0){
                                                                echo number_format((($seed['vitorias'] / $totalPartidasConcluidas) * 100), 0, '.', '');	
                                                            }else{
                                                                echo "0";
                                                            }
                                                        ?>
                                                        </td>
                                                        <td><strong><?php echo ($seed['vitorias'] * $etapa['pts_vitoria']) + ($seed['empates'] * $etapa['pts_empate']) + ($seed['derrotas'] * $etapa['pts_derrota']); ?></strong></td>
                                                    </tr>
                                                <?php
                                                }
                                            }else{ // SEMENTE VAZIA
                                            ?>
                                                <tr>
                                                    <td class="nome"><?php echo "#".$seed['numero'].""; ?></td>
                                                    <td>---</td>
                                                    <td></td>
                                                </tr>
                                            <?php
                                            }					
                                        }
                                    ?>
                                </table>	
                            </a>

                        <?php
                        }
                    ?>
                    </div>
                    <div class="col-12 col-md-4">
                    <?php
                        if(isset($usuario['codigo'])){

                        }
                        if($etapa['avanco_por_grupo'] != NULL && $etapa['avanco_por_grupo'] != 0 && $etapa['avanco_por_grupo'] != ""){ // TEM CLASSIFICADOS PARA PROXIMA FASE
                        ?>
                            <div class="tituloRank">
                                CLASSIFICADOS (<?php echo $etapa['avanco_por_grupo']; ?> POR GRUPO)
                            </div>
                            <table class="rankTop">
                                <tr>
                                    <td>G</td>
                                    <td></td>
                                    <td>SP</td>
                                    <td>P</td>								
                                </tr>
                                <?php
                                    $grupos = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_grupo WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_etapa = ".$etapa['cod_etapa']."");
                                    while($grupo = mysqli_fetch_array($grupos)){
                                        $seeds = mysqli_query($conexao, "SELECT campeonato_etapa_semente.*, campeonato_etapa_grupo.nome FROM campeonato_etapa_semente
                                        INNER JOIN campeonato_etapa_grupo ON campeonato_etapa_grupo.codigo = campeonato_etapa_semente.cod_grupo
                                        WHERE campeonato_etapa_semente.cod_grupo = ".$grupo['codigo']."
                                        ORDER BY campeonato_etapa_semente.vitorias DESC, 
                                        campeonato_etapa_semente.empates DESC, 
                                        campeonato_etapa_semente.derrotas DESC,
                                        (campeonato_etapa_semente.partidas_pro - campeonato_etapa_semente.partidas_contra) DESC,
                                        campeonato_etapa_semente.partidas_pro DESC,
                                        campeonato_etapa_semente.partidas_contra ASC
                                        LIMIT ".$etapa['avanco_por_grupo']."");
                                        while($semente = mysqli_fetch_array($seeds)){
                                            $grupo = explode(" ", $semente['nome']);
                                        ?>
                                            <tr>
                                                <td><?php echo $grupo[1]; ?></td>
                                                <td class="nome">
                                                <?php	
                                                    if($semente['cod_equipe'] == NULL){
                                                        if($semente['cod_jogador'] != NULL){ // BUSCAR INSCRIÇÃO
                                                            $inscricao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$semente['cod_jogador'].""));
                                                            echo $inscricao['conta'];
                                                        }else{
                                                            echo "#semente ".$semente['numero'];
                                                        }
                                                    }else{ // BUSCAR EQUIPE
                                                        $equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$seed['cod_equipe'].""));
                                                        echo $equipe['nome'];
                                                    }	
                                                ?>
                                                </td>
                                                <td><?php echo $semente['partidas_pro'] - $semente['partidas_contra'];?></td>
                                                <td><strong><?php echo ($semente['vitorias'] * $etapa['pts_vitoria']) + ($semente['empates'] * $etapa['pts_empate']) + ($semente['derrotas'] * $etapa['pts_derrota']); ?></strong></td>
                                            </tr>
                                        <?php
                                        }
                                    }


                                ?>
                            </table>
                        <?php	
                        }
                        ?>

                        <div class="tituloGrupo">
                            RANK GERAL
                        </div>
                        <table class="rankGeral">
                            <tr>
                                <td>G</td>
                                <td></td>
                                <td>SP</td>
                                <td>P</td>
                            </tr>
                            <?php
                                $seeds = mysqli_query($conexao, "SELECT campeonato_etapa_semente.*, campeonato_etapa_grupo.nome FROM campeonato_etapa_semente
                                INNER JOIN campeonato_etapa_grupo ON campeonato_etapa_grupo.codigo = campeonato_etapa_semente.cod_grupo
                                WHERE campeonato_etapa_semente.cod_campeonato = ".$campeonato['codigo']."
                                AND campeonato_etapa_semente.cod_etapa = ".$etapa['cod_etapa']."
                                ORDER BY campeonato_etapa_semente.vitorias DESC, 
                                campeonato_etapa_semente.empates DESC, 
                                campeonato_etapa_semente.derrotas DESC, 
                                (campeonato_etapa_semente.partidas_pro - campeonato_etapa_semente.partidas_contra) DESC,
                                campeonato_etapa_semente.partidas_pro DESC,
                                campeonato_etapa_semente.partidas_contra ASC");
                                while($semente = mysqli_fetch_array($seeds)){
                                    $grupo = explode(" ", $semente['nome']);
                                ?>
                                    <tr>
                                        <td><?php echo $grupo[1]; ?></td>
                                        <td class="nome">
                                        <?php	
                                            if($semente['cod_equipe'] == NULL){
                                                if($semente['cod_jogador'] != NULL){ // BUSCAR INSCRIÇÃO
                                                    $inscricao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$semente['cod_jogador'].""));
                                                    echo $inscricao['conta'];
                                                }else{
                                                    echo "#semente ".$semente['numero'];
                                                }
                                            }else{ // BUSCAR EQUIPE
                                                $equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$seed['cod_equipe'].""));
                                                echo $equipe['nome'];
                                            }	
                                        ?>
                                        </td>
                                        <td><?php echo $semente['partidas_pro'] - $semente['partidas_contra'];?></td>
                                        <td><strong><?php echo ($semente['vitorias'] * $etapa['pts_vitoria']) + ($semente['empates'] * $etapa['pts_empate']) + ($semente['derrotas'] * $etapa['pts_derrota']); ?></strong></td>
                                    </tr>
                                <?php
                                }
                            ?>
                        </table>
                    </div>
                </div>
            </div>

			<div class="barraCentral">
				<div class="barraEsquerda2">
				
				</div>
				<div class="barraDireita2">
				
				</div>			
			</div>
		<?php		
	}

	function elimDupla($etapa, $campeonato){
		include "../../../../enderecos.php";
		include "../../../../conexao-banco.php";
		$etapa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_etapa = $etapa AND cod_campeonato = $campeonato "));
		$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = $campeonato"));		
		$datahora = date("Y-m-d H:i:s");
	?>
		<div class="bracket" id="brackets">
			<div class="acoes">
				<input type="hidden" name="valZoom" id="valZoom" value="1">
				<div class="acao" onClick="maisZoom();">
					+
				</div>
				<div class="acao" onClick="menosZoom();">
					-
				</div>
			</div>
			<div class="pesquisa">
				
			</div>
			<?php
				$maxJogos = 2;
				while($maxJogos < $etapa['vagas']){
					$maxJogos *= 2;
				}
				$maxRounds = log($maxJogos, 2);
				$coluna = 1;
				$mTop = 0;
				$mBot = 20;
				$contador = 0;
				$xRound = 0;
				$avancoYpoly = 25;
			?>
			<svg class="jogostabelas" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				<g transform="scale(1)" id="elimSimples">
					<g>	<!-- MOSTRAR ROUNDS -->			
						<g>
						<?php
							while($coluna <= $maxRounds){
								// $partidas = mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$campeonato['codigo']." AND coluna = $coluna ORDER BY codigo ASC ");								
								?>
									<g class="round" transform="translate(<?php echo $xRound; ?>, 0)">
										<rect height="25" width="200" fill="#666"></rect>
										<text y="17" x="5" fill="#ccc">Superior - Rodada <?php echo $coluna; ?></text>
									</g>
								<?php
								$coluna++;
								$xRound += 210;
							}
						?>
						</g>
					</g>
					<g> <!-- MOSTRAR PARTIDAS -->	
					<?php
						$coluna = 1;
						$xPartida = 2;
						$yPartida = 50;
						$avancoYinicial = $yPartida;
						$avancoY = 75;
						while($coluna <= $maxRounds){							
							$partidas = mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$campeonato['codigo']." AND coluna = $coluna AND sup_inf = 'U' ORDER BY codigo ASC LIMIT $maxJogos");
							if($coluna == 1){
								$alturaR1 = mysqli_num_rows($partidas) * 75 + 75;
							}
							while($partida = mysqli_fetch_array($partidas)){
								if($partida['status'] != 3){
									$ladoUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente 
										INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
										WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 1 "));
									$ladoDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente 
										INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
										WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 2 "));
									?>
										<a href="ptbr/campeonato/<?php echo $partida['cod_campeonato']; ?>/partida/<?php echo $partida['codigo']; ?>/">
											<g>
												

												<rect width="160" height="25" y="<?php echo $yPartida; ?>" x="<?php echo $xPartida; ?>" fill="#fff" stroke="#ccc" stroke-width="2"></rect>
												<rect width="25" height="25" y="<?php echo $yPartida; ?>" x="<?php echo $xPartida+160; ?>" fill="#ccc" stroke="#ccc" stroke-width="2"></rect>
												
												<?php
													if(!isset($ladoUm)){
														if($coluna != 1){	
															$jogoOrigem = ($partida['linha'] * 2) - 1;
															?>
																<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																<?php
																	echo "Vencedor de U ".($coluna-1)."-".$jogoOrigem;
																?>
																</text>
															<?php														
														}else{	
														?>
															<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																A ser definido
															</text>
														<?php		
														}							
													}else{
														if($ladoUm['cod_jogador'] == NULL){ // MOSTRAR NUMERO DA SEMENTE
														?>
															<text y="<?php echo $yPartida+17; ?>" x="<?php echo $xPartida+2; ?>"><?php echo "Semente #".$ladoUm['numero'];	 ?></text>
														<?php
														}else{
															if($ladoUm['cod_equipe'] == NULL){ // BUSCAR E MOSTRAR JOGADOR
																$inscUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$ladoUm['cod_jogador'].""));
																$player = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$ladoUm['cod_jogador']." "));
																?>
																	<text y="<?php echo $yPartida+17; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																	<?php
																		echo $inscUm['conta'];
																	?>
																	</text>
																<?php
															}else{ // BUSCAR E MOSTRAR EQUIPE
																$equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$ladoUm['cod_equipe']." "));	
																?>
																	<text y="<?php echo $yPartida+17; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																	<?php
																		echo $equipe['nome'];
																	?>
																	</text>
																<?php
															}
														}										
													}
												?>		


												<rect width="160" height="25" y="<?php echo $yPartida+25; ?>" x="<?php echo $xPartida; ?>" fill="#fff" stroke="#ccc" stroke-width="2"></rect>	
												<rect width="25" height="25" y="<?php echo $yPartida+25; ?>" x="<?php echo $xPartida+160; ?>" fill="#ccc" stroke="#ccc" stroke-width="2"></rect>
												
												<!-- PLACARES -->
												
												<?php
													if($ladoUm['status'] == 1){ // VENCEDOR
													?>
														<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+168; ?>" fill="#f60" font-weight="bold" font-size="18"><?php echo $partida['placar_um']; ?></text>
													<?php	
													}else{
													?>
														<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+168; ?>" fill="#fff" font-weight="bold" font-size="18"><?php echo $partida['placar_um']; ?></text>
													<?php		
													}
									
													if($ladoDois['status'] == 1){ // VENCEDOR
													?>
														<text  width="25" height="25" y="<?php echo $yPartida+43; ?>" x="<?php echo $xPartida+168; ?>" fill="#f60" font-weight="bold" font-size="18"><?php echo $partida['placar_dois']; ?></text>
													<?php	
													}else{
													?>
														<text  width="25" height="25" y="<?php echo $yPartida+43; ?>" x="<?php echo $xPartida+168; ?>" fill="#fff" font-weight="bold" font-size="18"><?php echo $partida['placar_dois']; ?></text>
													<?php		
													}
												?>
												
												
												
												
												<?php
													if(!isset($ladoDois)){
														if($coluna != 1){	
															$jogoOrigem = ($partida['linha'] * 2) ;
															?>
																<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																<?php
																	echo "Vencedor de U ".($coluna-1)."-".$jogoOrigem;
																?>
																</text>
															<?php														
														}else{	
														?>
															<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																A ser definido
															</text>
														<?php		
														}							
													}else{
														if($ladoDois['cod_jogador'] == NULL){ // MOSTRAR NUMERO DA SEMENTE
														?>
															<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+2; ?>"><?php echo "Semente #".$ladoDois['numero'];	 ?></text>
														<?php
														}else{
															if($ladoDois['cod_equipe'] == NULL){ // BUSCAR E MOSTRAR JOGADOR
																$inscDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$ladoDois['cod_jogador'].""));
																$player = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$ladoDois['cod_jogador']." "));
																?>
																	<text y="<?php echo $yPartida+43; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																	<?php
																		echo $inscDois['conta'];
																	?>
																	</text>
																<?php
															}else{ // BUSCAR E MOSTRAR EQUIPE
																$equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$ladoUm['cod_equipe']." "));	
																?>
																	<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																	<?php
																		echo $equipe['nome'];
																	?>
																	</text>
																<?php
															}
														}										
													}
												?>
												<g>
													<rect width="30" height="17" fill="#fff" stroke="#ccc" stroke-width="2" x="<?php echo $xPartida; ?>" y="<?php echo $yPartida+50; ?>"></rect>
													<text x="<?php echo $xPartida+6; ?>" y="<?php echo $yPartida+62; ?>" font-size="10" font-weight="bold" fill="#666">U <?php echo $partida['coluna']."-".$partida['linha'] ?></text>
												</g>
												<rect width="165" height="50" fill="transparent" y="<?php echo $yPartida; ?>" x="<?php echo $xPartida; ?>"></rect>
											</g>
										</a>
										<?php
											if($coluna != $maxRounds){
												?>
												<polyline points="<?php echo $xPartida+185; ?>,<?php echo $yPartida+25; ?> <?php echo $xPartida+195; ?>,<?php echo $yPartida+25; ?>" fill="white" stroke="#ccc" stroke-width="2"></polyline>
												<?php
												if(($partida['linha'] % 2) == 0){ // É PARTIDA PAR
												?>
													<polyline points="<?php echo $xPartida+195; ?>,<?php echo $yPartida+25; ?> <?php echo $xPartida+195; ?>,<?php echo $yPartida+25-$avancoYpoly; ?> <?php echo $xPartida+210; ?>,<?php echo $yPartida+25-$avancoYpoly; ?>" fill="white" stroke="#ccc" stroke-width="2"></polyline>
												<?php
												}else{ // É PARTIDA IMPAR
												?>
													<polyline points="<?php echo $xPartida+195; ?>,<?php echo $yPartida+25; ?> <?php echo $xPartida+195; ?>,<?php echo $yPartida+25+$avancoYpoly; ?> <?php echo $xPartida+210; ?>,<?php echo $yPartida+25+$avancoYpoly; ?>" fill="white" stroke="#ccc" stroke-width="2"></polyline>
												<?php	
												}	
											}else{
												?>
												<polyline points="<?php echo $xPartida+185; ?>,<?php echo $yPartida+25; ?> <?php echo $xPartida+195; ?>,<?php echo $yPartida+25; ?> <?php echo $xPartida+195; ?>,<?php echo $yPartida+50; ?> <?php echo $xPartida+210; ?>,<?php echo $yPartida+50; ?>" fill="white" stroke="#ccc" stroke-width="2"></polyline>
												<?php
											}
																										
																			
								}								
								$yPartida += $avancoY;
							}
							$avancoYpoly = $avancoYpoly + 37.5*pow(2, ($coluna-1));
							$xPartida += 210;
							$yPartida = $avancoY + 12;
							$avancoY = ($avancoY * 2);
							$coluna++;
						}
						$partidas = mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$campeonato['codigo']." AND sup_inf is null AND status != 3 ORDER BY codigo");
						$yPartida = ($avancoY/4) + 50;
						$contador = 0;
						while($partida = mysqli_fetch_array($partidas)){
							$ladoUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente 
								INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
								WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 1 "));
							$ladoDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente 
								INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
								WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 2 "));
							?>
								<a href="campeonato/<?php echo $partida['cod_campeonato']; ?>/partida/<?php echo $partida['codigo']; ?>/">
									<g>


										<rect width="160" height="25" y="<?php echo $yPartida; ?>" x="<?php echo $xPartida; ?>" fill="#fff" stroke="#ccc" stroke-width="2"></rect>
										<rect width="25" height="25" y="<?php echo $yPartida; ?>" x="<?php echo $xPartida+160; ?>" fill="#ccc" stroke="#ccc" stroke-width="2"></rect>

										<?php
											if(!isset($ladoUm)){
												if($contador == 0){
													$jogoOrigem = ($partida['linha'] * 2) - 1;
													?>
														<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
														<?php
															echo "Vencedor de U ".($coluna-1)."-".$jogoOrigem;
														?>
														</text>
													<?php	
												}else{
													?>
														<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
														<?php
															echo "Vencedor de FINAL";
														?>
														</text>
													<?php	
												}
																				
											}else{
												if($ladoUm['cod_jogador'] == NULL){ // MOSTRAR NUMERO DA SEMENTE
												?>
													<text y="<?php echo $yPartida+17; ?>" x="<?php echo $xPartida+2; ?>"><?php echo "Semente #".$ladoUm['numero'];	 ?></text>
												<?php
												}else{
													if($ladoUm['cod_equipe'] == NULL){ // BUSCAR E MOSTRAR JOGADOR
														$inscUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$ladoUm['cod_jogador'].""));
														$player = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$ladoUm['cod_jogador']." "));
														?>
															<text y="<?php echo $yPartida+17; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
															<?php
																echo $inscUm['conta'];
															?>
															</text>
														<?php
													}else{ // BUSCAR E MOSTRAR EQUIPE
														$equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$ladoUm['cod_equipe']." "));	
														?>
															<text y="<?php echo $yPartida+17; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
															<?php
																echo $equipe['nome'];
															?>
															</text>
														<?php
													}
												}										
											}
										?>		


										<rect width="160" height="25" y="<?php echo $yPartida+25; ?>" x="<?php echo $xPartida; ?>" fill="#fff" stroke="#ccc" stroke-width="2"></rect>	
										<rect width="25" height="25" y="<?php echo $yPartida+25; ?>" x="<?php echo $xPartida+160; ?>" fill="#ccc" stroke="#ccc" stroke-width="2"></rect>

										<!-- PLACARES -->

										<?php
											if($ladoUm['status'] == 1){ // VENCEDOR
											?>
												<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+168; ?>" fill="#f60" font-weight="bold" font-size="18"><?php echo $partida['placar_um']; ?></text>
											<?php	
											}else{
											?>
												<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+168; ?>" fill="#fff" font-weight="bold" font-size="18"><?php echo $partida['placar_um']; ?></text>
											<?php		
											}

											if($ladoDois['status'] == 1){ // VENCEDOR
											?>
												<text  width="25" height="25" y="<?php echo $yPartida+43; ?>" x="<?php echo $xPartida+168; ?>" fill="#f60" font-weight="bold" font-size="18"><?php echo $partida['placar_dois']; ?></text>
											<?php	
											}else{
											?>
												<text  width="25" height="25" y="<?php echo $yPartida+43; ?>" x="<?php echo $xPartida+168; ?>" fill="#fff" font-weight="bold" font-size="18"><?php echo $partida['placar_dois']; ?></text>
											<?php		
											}
										?>




										<?php
											if(!isset($ladoDois)){
												if($contador == 0){
													$jogoOrigem = ($partida['linha'] * 2) - 1;
													?>
														<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
														<?php
															echo "Vencedor de L ".(($coluna-1)+($coluna-3))."-".$jogoOrigem;
														?>
														</text>
													<?php	
												}else{
													?>
														<text y="<?php echo $yPartida+43; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
														<?php
															echo "Perdedor de FINAL";
														?>
														</text>
													<?php
												}
																			
											}else{
												if($ladoDois['cod_jogador'] == NULL){ // MOSTRAR NUMERO DA SEMENTE
												?>
													<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+2; ?>"><?php echo "Semente #".$ladoDois['numero'];	 ?></text>
												<?php
												}else{
													if($ladoDois['cod_equipe'] == NULL){ // BUSCAR E MOSTRAR JOGADOR
														$inscDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$ladoDois['cod_jogador'].""));
														$player = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$ladoDois['cod_jogador']." "));
														?>
															<text y="<?php echo $yPartida+43; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
															<?php
																echo $inscDois['conta'];
															?>
															</text>
														<?php
													}else{ // BUSCAR E MOSTRAR EQUIPE
														$equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$ladoDois['cod_equipe']." "));	
														?>
															<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
															<?php
																echo $equipe['nome'];
															?>
															</text>
														<?php
													}
												}										
											}
										?>
										<g>
										<?php
											if($contador == 0){
											?>
												<rect width="50" height="20" fill="#fff" stroke="#ccc" stroke-width="2" x="<?php echo $xPartida; ?>" y="<?php echo $yPartida+50; ?>"></rect>
												<text x="<?php echo $xPartida+11; ?>" y="<?php echo $yPartida+65; ?>" font-size="14" font-weight="bold" fill="#666">FINAL</text>
												<?php
													if(mysqli_num_rows($partidas) > 1){
													?>
														<polyline points="<?php echo $xPartida+185; ?>,<?php echo $yPartida+25; ?> <?php echo $xPartida+195; ?>,<?php echo $yPartida+25; ?> <?php echo $xPartida+195; ?>,<?php echo $yPartida+12; ?> <?php echo $xPartida+210; ?>,<?php echo $yPartida+12; ?>" fill="white" stroke="#ccc" stroke-width="2"></polyline>
													<?php
													}
												?>												
												<polyline points="<?php echo $xPartida; ?>,<?php echo $yPartida+37; ?> <?php echo $xPartida-10; ?>,<?php echo $yPartida+37; ?> <?php echo $xPartida-10; ?>,<?php echo $yPartida+50; ?>" fill="white" stroke="#ccc" stroke-width="2"></polyline>
												<?php
											}else{
											?>
												<rect width="95" height="20" fill="#fff" stroke="#ccc" stroke-width="2" x="<?php echo $xPartida; ?>" y="<?php echo $yPartida+50; ?>"></rect>
												<text x="<?php echo $xPartida+11; ?>" y="<?php echo $yPartida+65; ?>" font-size="14" font-weight="bold" fill="#666">GRANDE FINAL</text>
												<polyline points="<?php echo $xPartida; ?>,<?php echo $yPartida+37; ?> <?php echo $xPartida-10; ?>,<?php echo $yPartida+37; ?> <?php echo $xPartida-10; ?>,<?php echo $yPartida+50; ?>" fill="white" stroke="#ccc" stroke-width="2"></polyline>
											<?php
											}
										?>
											
											
										</g>
										<rect width="165" height="50" fill="transparent" y="<?php echo $yPartida; ?>" x="<?php echo $xPartida; ?>"></rect>
									</g>
								</a>
								<?php
							$xPartida += 210;
							$contador++;
						}
					?>
					</g>
					<?php
						$maxRounds += ($maxRounds - 2);
						$coluna = 1;
						$xRound = 0;
					?>
					<g>	<!-- MOSTRAR ROUNDS -->			
						<g>
						<?php
							while($coluna <= $maxRounds){
								// $partidas = mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$campeonato['codigo']." AND coluna = $coluna ORDER BY codigo ASC ");								
								?>
									<g class="round" transform="translate(<?php echo $xRound; ?>, <?php echo $alturaR1; ?>)">
										<rect height="25" width="200" fill="#666"></rect>
										<text y="17" x="5" fill="#ccc">Inferior - Rodada <?php echo $coluna; ?></text>
									</g>
								<?php
								$coluna++;
								$xRound += 210;
							}
						?>
						</g>
					</g>
					<g> <!-- MOSTRAR PARTIDAS -->	
					<?php
						$coluna = 1;
						$xPartida = 2;
						$yPartida = $alturaR1 + 50;
						$avancoYinicial = $yPartida;
						$avancoY = 75;
						$contador = 0;
						$avancoYpoly = 25;
						$roundOrigem = 2;
						while($coluna <= $maxRounds){
							$partidas = mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_etapa = ".$etapa['cod_etapa']." AND cod_campeonato = ".$campeonato['codigo']." AND coluna = $coluna AND sup_inf = 'L' ORDER BY codigo ASC LIMIT $maxJogos");
							if($coluna == 1){
								$alturaR1l = mysqli_num_rows($partidas) * 75 + 75;
							}
							while($partida = mysqli_fetch_array($partidas)){
								if($partida['status'] != 3){
									$ladoUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente 
										INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
										WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 1 "));
									$ladoDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_semente 
										INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
										WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 2 "));
									?>
										<a href="campeonato/<?php echo $partida['cod_campeonato']; ?>/partida/<?php echo $partida['codigo']; ?>/">
											<g>
												

												<rect width="160" height="25" y="<?php echo $yPartida; ?>" x="<?php echo $xPartida; ?>" fill="#fff" stroke="#ccc" stroke-width="2"></rect>
												<rect width="25" height="25" y="<?php echo $yPartida; ?>" x="<?php echo $xPartida+160; ?>" fill="#ccc" stroke="#ccc" stroke-width="2"></rect>
												
												<?php
													if(!isset($ladoUm)){
														if($coluna != 1){	
															$jogoOrigem = ($partida['linha'] * 2) - 1;
															?>
																<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																<?php
																	if($contador == 0){
																		echo "Vencedor de L ".($coluna-1)."-".$jogoOrigem;	
																	}else{
																		echo "Perdedor de U ".$roundOrigem."-".$partida['linha'];	
																	}
																	
																?>
																</text>
															<?php														
														}else{
															$linhaOrigem = ($partida['linha'] * 2) - 1;
														?>
															<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																Perdedor de U 1-<?php echo $linhaOrigem; ?>
															</text>
														<?php		
														}							
													}else{
														if($ladoUm['cod_jogador'] == NULL){ // MOSTRAR NUMERO DA SEMENTE
														?>
															<text y="<?php echo $yPartida+17; ?>" x="<?php echo $xPartida+2; ?>"><?php echo "Semente #".$ladoUm['numero'];	 ?></text>
														<?php
														}else{
															if($ladoUm['cod_equipe'] == NULL){ // BUSCAR E MOSTRAR JOGADOR
																$inscUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$ladoUm['cod_jogador'].""));
																$player = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$ladoUm['cod_jogador']." "));
																?>
																	<text y="<?php echo $yPartida+17; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																	<?php
																		echo $inscUm['conta'];
																	?>
																	</text>
																<?php
															}else{ // BUSCAR E MOSTRAR EQUIPE
																$equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$ladoUm['cod_equipe']." "));	
																?>
																	<text y="<?php echo $yPartida+17; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																	<?php
																		echo $equipe['nome'];
																	?>
																	</text>
																<?php
															}
														}										
													}
												?>		


												<rect width="160" height="25" y="<?php echo $yPartida+25; ?>" x="<?php echo $xPartida; ?>" fill="#fff" stroke="#ccc" stroke-width="2"></rect>	
												<rect width="25" height="25" y="<?php echo $yPartida+25; ?>" x="<?php echo $xPartida+160; ?>" fill="#ccc" stroke="#ccc" stroke-width="2"></rect>
												
												<!-- PLACARES -->
												
												<?php
													if($ladoUm['status'] == 1){ // VENCEDOR
													?>
														<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+168; ?>" fill="#f60" font-weight="bold" font-size="18"><?php echo $partida['placar_um']; ?></text>
													<?php	
													}else{
													?>
														<text y="<?php echo $yPartida+18; ?>" x="<?php echo $xPartida+168; ?>" fill="#fff" font-weight="bold" font-size="18"><?php echo $partida['placar_um']; ?></text>
													<?php		
													}
									
													if($ladoDois['status'] == 1){ // VENCEDOR
													?>
														<text  width="25" height="25" y="<?php echo $yPartida+43; ?>" x="<?php echo $xPartida+168; ?>" fill="#f60" font-weight="bold" font-size="18"><?php echo $partida['placar_dois']; ?></text>
													<?php	
													}else{
													?>
														<text  width="25" height="25" y="<?php echo $yPartida+43; ?>" x="<?php echo $xPartida+168; ?>" fill="#fff" font-weight="bold" font-size="18"><?php echo $partida['placar_dois']; ?></text>
													<?php		
													}
												?>
												
												
												
												
												<?php
													if(!isset($ladoDois)){
														if($coluna != 1){
															if($contador == 0){
																$jogoOrigem = ($partida['linha'] * 2) ;	
															}else{
																$jogoOrigem = $partida['linha'];
															}
															
															?>
																<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																<?php
																	echo "Vencedor de L ".($coluna-1)."-".$jogoOrigem;
																?>
																</text>
															<?php														
														}else{	
															$linhaOrigem = ($partida['linha'] * 2);
														?>
															<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																Perdedor de U 1-<?php echo $linhaOrigem; ?>
															</text>
														<?php		
														}							
													}else{
														if($ladoDois['cod_jogador'] == NULL){ // MOSTRAR NUMERO DA SEMENTE
														?>
															<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+2; ?>"><?php echo "Semente #".$ladoDois['numero'];	 ?></text>
														<?php
														}else{
															if($ladoDois['cod_equipe'] == NULL){ // BUSCAR E MOSTRAR JOGADOR
																$inscDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$ladoDois['cod_jogador'].""));
																$player = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$ladoDois['cod_jogador']." "));
																?>
																	<text y="<?php echo $yPartida+43; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																	<?php
																		echo $inscDois['conta'];
																	?>
																	</text>
																<?php
															}else{ // BUSCAR E MOSTRAR EQUIPE
																$equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$ladoUm['cod_equipe']." "));	
																?>
																	<text y="<?php echo $yPartida+45; ?>" x="<?php echo $xPartida+5; ?>" data-position="top">
																	<?php
																		echo $equipe['nome'];
																	?>
																	</text>
																<?php
															}
														}										
													}
												?>
												<g>
													<rect width="30" height="17" fill="#fff" stroke="#ccc" stroke-width="2" x="<?php echo $xPartida; ?>" y="<?php echo $yPartida+50; ?>"></rect>
													<text x="<?php echo $xPartida+6; ?>" y="<?php echo $yPartida+62; ?>" font-size="10" font-weight="bold" fill="#666">L <?php echo $partida['coluna']."-".$partida['linha'] ?></text>
												</g>
												<rect width="165" height="50" fill="transparent" y="<?php echo $yPartida; ?>" x="<?php echo $xPartida; ?>"></rect>
											</g>
										</a>
										<?php
											if($coluna != $maxRounds){
											?>
												<polyline points="<?php echo $xPartida+185; ?>,<?php echo $yPartida+25; ?> <?php echo $xPartida+200; ?>,<?php echo $yPartida+25; ?>" fill="white" stroke="#ccc" stroke-width="2"></polyline>
											<?php
											}else{
											?>
												<polyline points="<?php echo $xPartida+185; ?>,<?php echo $yPartida+25; ?> <?php echo $xPartida+200; ?>,<?php echo $yPartida+25; ?> <?php echo $xPartida+200; ?>,<?php echo $yPartida; ?>" fill="white" stroke="#ccc" stroke-width="2"></polyline>
											<?php	
											}
											if($contador != 0){
												if($coluna != $maxRounds){
													if(($partida['linha'] % 2) == 0){ // É PARTIDA PAR
													?>
														<polyline points="<?php echo $xPartida+200; ?>,<?php echo $yPartida+25; ?> <?php echo $xPartida+200; ?>,<?php echo $yPartida+25-$avancoYpoly; ?> <?php echo $xPartida+210; ?>,<?php echo $yPartida+25-$avancoYpoly; ?>" fill="white" stroke="#ccc" stroke-width="2"></polyline>
													<?php
													}else{ // É PARTIDA IMPAR
													?>
														<polyline points="<?php echo $xPartida+200; ?>,<?php echo $yPartida+25; ?> <?php echo $xPartida+200; ?>,<?php echo $yPartida+25+$avancoYpoly; ?> <?php echo $xPartida+210; ?>,<?php echo $yPartida+25+$avancoYpoly; ?>" fill="white" stroke="#ccc" stroke-width="2"></polyline>
													<?php	
													}	
												}
											}else{
												if($coluna != $maxRounds){
													?>
														<polyline points="<?php echo $xPartida+200; ?>,<?php echo $yPartida+25; ?> <?php echo $xPartida+200; ?>,<?php echo $yPartida+37; ?> <?php echo $xPartida+210; ?>,<?php echo $yPartida+37; ?>" fill="white" stroke="#ccc" stroke-width="2"></polyline>
													<?php
												}													
											}								
								}								
								$yPartida += $avancoY;
							}
							if($contador == 0){
								$contador++;
								$yPartida = $avancoYinicial;
							}else{
								$contador--;
								$yPartida = $avancoYinicial + ($avancoY/2);
								$avancoYinicial = $yPartida;
								$avancoY = ($avancoY * 2);
								$avancoYpoly = $avancoYpoly*2 + 12.5;
								$roundOrigem++;
							}								
							$xPartida += 210;							
							$coluna++;
						}						
					?>
					</g>					
				</g>						
			</svg>			
		</div>
		
		
		<script>
			function maisZoom(){
				var zoom = parseFloat($("#valZoom").val()) + parseFloat($("#valZoom").val()) * 0.05;
				$("#elimSimples").attr("transform","scale("+zoom+")");
				$("#valZoom").val(zoom);
			}
			function menosZoom(){
				var zoom = parseFloat($("#valZoom").val()) - parseFloat($("#valZoom").val()) * 0.05;
				$("#elimSimples").attr("transform","scale("+zoom+")");
				$("#valZoom").val(zoom);
			}
			
			var xTabela, yTabela, xMouse, yMouse, down=false, posicaoGeral, posicaoBracket;
			
			$("body").mouseup(function(e){
				down = false;
				posicaoGeral =$("#brackets").position();
				posicaoBracket =$("#elimSimples").position();
				$(this).css("cursor","context-menu");
			})
			
			$(".jogostabelas").mousedown(function(e){
				down=true;
				posicaoGeral =$("#brackets").position();
				posicaoBracket =$("#elimSimples").position();
				
				xTabela = posicaoBracket.left - posicaoGeral.left - 190;
				yTabela = posicaoBracket.top - posicaoGeral.top - (50 * parseFloat($("#valZoom").val()));
				
				xMouse = e.pageX;
				yMouse = e.pageY;
				$(this).css("cursor","move");
			});
			
			$(".jogostabelas").mouseup(function(e){
				$(this).css("cursor","context-menu");
			});
			
			$(".jogostabelas").mousemove(function(e){
				if(down){
					var avancoX = (xMouse - e.pageX)*2.5;
					var avancoY = (yMouse - e.pageY)*2.5;
					//console.log(y+", "+newY+", "+top+", "+(top+(newY-y))); 
					$("#elimSimples").attr("transform", "scale("+parseFloat($("#valZoom").val())+") translate("+((xTabela*parseFloat($("#valZoom").val())) + avancoX)+","+((yTabela*parseFloat($("#valZoom").val())) + avancoY)+")");
					
				}
			});
			jQuery(function($){
				$(".jogostabelas").attr("height","<?php echo $alturaR1+$alturaR1l; ?>");
			});
		</script>
	<?php	
	}
?>
