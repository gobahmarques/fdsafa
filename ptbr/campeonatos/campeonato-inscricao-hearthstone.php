<?php
	if(isset($usuario['codigo'])){
		$verificarInscricao = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$usuario['codigo']."");
		$inscricao = mysqli_fetch_array($verificarInscricao);

		if($campeonato['status'] == 0 && $datahora < $campeonato['fim_inscricao'] && $datahora > $campeonato['inicio_inscricao']){ // INSCRIÇÕES AINDA ESTÃO ABERTAS
			if(mysqli_num_rows($verificarInscricao) == 0){ // NÃO FEZ INSCRIÇÃO AINDA
				if($usuario['battletag'] != NULL){ // Já vinculou sua battletag
				?>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="passoInscricao">
                                <h3>Sua Battletag</h3>
                                <div class="row">
                                    <div class="img col-3 col-md-3">
                                        <img src="http://www.esportscups.com.br/img/icones/battlenet.png" alt="">	
                                    </div>
                                    <div class="conta col-9 col-md-9">
                                        <?php echo $usuario['battletag']; ?>	
                                    </div>
                                </div>
                                <input type="button" class="btn btn-dark" value="TROCAR BATTLE.NET" onClick="window.location.replace('ptbr/usuario/<?php echo $usuario['codigo']; ?>/permissoes/');">
                            </div>                            
                        </div> 
                        <div class="col-12 col-md-4">
                            <div class="passoInscricao draft">
                                <h3>Escolha seus heróis</h3>                                    
                                <form action="ptbr/campeonatos/draft-enviar.php" method="post" onSubmit="return validar();">
                                    <input type="hidden" name="deckstringdruida" id="deckstringdruida" value="" class="form-control" >
                                    <input type="hidden" name="deckstringhunter" id="deckstringhunter" value="" class="form-control" >
                                    <input type="hidden" name="deckstringmage" id="deckstringmage" value="" class="form-control" >
                                    <input type="hidden" name="deckstringpaladin" id="deckstringpaladin" value="" class="form-control" >
                                    <input type="hidden" name="deckstringpriest" id="deckstringpriest" value="" class="form-control" >
                                    <input type="hidden" name="deckstringrogue" id="deckstringrogue" value="" class="form-control" >
                                    <input type="hidden" name="deckstringshaman" id="deckstringshaman" value="" class="form-control" >
                                    <input type="hidden" name="deckstringwarlock" id="deckstringwarlock" value="" class="form-control" >
                                    <input type="hidden" name="deckstringwarrior" id="deckstringwarrior" value="" class="form-control" >
                                    <div class="row">
                                    <input type="text" name="funcao" id="funcao" value="inscricao" hidden="hidden">
                                    <input type="hidden" name="codCampeonato" id="codCampeonato" value="<?php echo $campeonato['codigo']; ?>">
                                        <div class="col-4 col-md-4">
                                            <input type="checkbox" name="heroi[]" class="limitado" value="druida" id="druida" hidden="hidden">
                                            <label for="druida" class="heroi">
                                                <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/druida.png" ?>" width="100">
                                            </label>
                                        </div>
                                        <div class="col-4 col-md-4">
                                            <input type="checkbox" name="heroi[]" class="limitado" value="hunter" id="hunter" hidden="hidden">
                                            <label for="hunter" class="heroi">
                                                <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/hunter.png" ?>" width="100">
                                            </label>
                                        </div>
                                        <div class="col-4 col-md-4">
                                            <input type="checkbox" name="heroi[]" class="limitado" value="mage" id="mage" hidden="hidden">
                                            <label for="mage" class="heroi">
                                                <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/mage.png" ?>" width="100">
                                            </label>
                                        </div>
                                        <div class="col-4 col-md-4">
                                            <input type="checkbox" name="heroi[]" class="limitado" value="paladin" id="paladin" hidden="hidden">
                                            <label for="paladin" class="heroi">
                                                <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/paladin.png" ?>" width="100">
                                            </label>
                                        </div>
                                        <div class="col-4 col-md-4">
                                            <input type="checkbox" name="heroi[]" class="limitado" value="priest" id="priest" hidden="hidden">
                                            <label for="priest" class="heroi">
                                                <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/priest.png" ?>" width="100">
                                            </label>
                                        </div>
                                        <div class="col-4 col-md-4">
                                            <input type="checkbox" name="heroi[]" class="limitado" value="rogue" id="rogue" hidden="hidden">
                                            <label for="rogue" class="heroi">
                                                <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/rogue.png" ?>" width="100">
                                            </label>
                                        </div>
                                        <div class="col-4 col-md-4">
                                            <input type="checkbox" name="heroi[]" class="limitado" value="shaman" id="shaman" hidden="hidden">
                                            <label for="shaman" class="heroi">
                                                <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/shaman.png" ?>" width="100">
                                            </label>
                                        </div>
                                        <div class="col-4 col-md-4">
                                            <input type="checkbox" name="heroi[]" class="limitado" value="warlock" id="warlock" hidden="hidden">
                                            <label for="warlock" class="heroi">
                                                <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/warlock.png" ?>" width="100">
                                            </label>
                                        </div>
                                        <div class="col-4 col-md-4">
                                            <input type="checkbox" name="heroi[]" class="limitado" value="warrior" id="warrior" hidden="hidden">
                                            <label for="warrior" class="heroi">
                                                <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/warrior.png" ?>" width="100">
                                            </label>
                                        </div>
                                        <div class="col-12 col-md-12">
                                            <input type="submit" value="REALIZAR INSCRIÇÃO" class="btn btn-dark">
                                        </div>
                                    </div>                                    
                                </form>
                            </div>                            
                        </div> 
                    </div>
				<?php
				}else{ // AINDA NÃO VINCULOU A BATTLETAG	
				?>
					<div class="passo">
						<h2>Vinculação Battle.net</h2>
						É necessário vincular sua conta battletag com nossa plataforma para poder competir nos torneios de Hearthstone. <br><br>
						<a href="battlenet/battle.php"><input type="button" value="VINCULAR BATTLE.NET" class="btn btn-dark"></a>
					</div>
				<?php
				}
			}else{ // JÁ REALIZOU A INSCRIÇÃO
			?>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="passoInscricao">
                            <h3>Battletag Inscrita</h3>
                            <div class="row">
                                <div class="img col-3 col-md-3">
                                    <img src="http://www.esportscups.com.br/img/icones/battlenet.png" alt="">	
                                </div>
                                <div class="conta col-9 col-md-9">
                                    <?php echo $inscricao['conta']; ?>	
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="col-12 col-md-4 draft">
                        <div class="passoInscricao draft">
                            <h3>Seu draft</h3> 
                            <div class="row">
                            <?php
                                $draft = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_draft WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$usuario['codigo']." "));
                                $herois = explode(";", $draft['picks']);
                                $aux = 0;
                                while($aux < $campeonato['qtd_pick']){
                                ?>
                                    <div class="col-3 col-md-3">
                                    <?php
                                        echo "<img src='http://www.esportscups.com.br/img/draft/".$jogo['abreviacao']."/".$herois[$aux].".png' alt='".$herois[$aux]."' title='".$herois[$aux]."' height='100px'>";
                                    ?>
                                    </div>
                                <?php                                    
                                    $aux++;
                                }
                                if($campeonato['status'] == 0){
                                ?>
                                    <div class="col-12 col-md-12">
                                        <input type="button" class="btn btn-dark" value="ALTERAR" onClick="mudarDraftHs();">
                                    </div>
                                <?php
                                }
                            ?>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="passoInscricao">
                            <h3>Sua Inscrição</h3>
                            <?php
                                if($inscricao['status'] == 0){ // EM ANALISE
                                    echo "<img src='http://www.esportscups.com.br/img/icones/pendente.png' alt='Inscrição em Análise' title='Inscrição em Análise'><br><br>";
                                    if($campeonato['precheckin'] > 0){
                                        echo "Está tudo OK com sua inscrição até o momento. Para confirmá-la basta realizar o <strong>PRÉ CHECK-IN</strong> que inicia <strong>".$campeonato['precheckin']." minutos</strong> antes do início da competição. Bons jogos.";
                                    }else{								
                                        echo "Sua inscrição está sendo analisada pela organização do torneio e em breve você terá uma resposta.";	
                                    }							
                                }elseif($inscricao['status'] == 1){ // APROVADA
                                    echo "<img src='http://www.esportscups.com.br/img/icones/aprovada.png' alt='Inscrição em Análise' title='Inscrição em Análise'><br><br>";
                                    echo "Sua inscrição está <strong>CONFIRMADA.</strong><br>Nos vemos dia ".date("d/m/Y - H:i", strtotime($campeonato['inicio']));
                                }else{ // RECUSADA
                                    echo "<img src='http://www.esportscups.com.br/img/icones/recusada.png' alt='Inscrição em Análise' title='Inscrição em Análise'><br><br>";
                                    echo "Sua inscrição foi recusada pela organização. <br> Para esclarecimentos, entre em contato direto através do e-mail: <strong>".$organizacao['email']."</strong>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
			<?php	
			}
		}else{ // INSCRIÇÕES JÁ FORAM ENCERRADAS
			if(mysqli_num_rows($verificarInscricao) != 0){ // INSCRIÇÃO REALIZADA
			?>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="passoInscricao">
                            <h3>Battletag Inscrita</h3>
                            <div class="row">
                                <div class="img col-3 col-md-3">
                                    <img src="http://www.esportscups.com.br/img/icones/battlenet.png" alt="">	
                                </div>
                                <div class="conta col-9 col-md-9">
                                    <?php echo $inscricao['conta']; ?>	
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="col-12 col-md-4 draft">
                        <div class="passoInscricao draft">
                            <h3>Seu draft</h3> 
                            <div class="row">
                            <?php
                                $draft = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_draft WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$usuario['codigo']." "));
                                $herois = explode(";", $draft['picks']);
                                $aux = 0;
                                while($aux < $campeonato['qtd_pick']){
                                ?>
                                    <div class="col-3 col-md-3">
                                    <?php
                                        echo "<img src='http://www.esportscups.com.br/img/draft/".$jogo['abreviacao']."/".$herois[$aux].".png' alt='".$herois[$aux]."' title='".$herois[$aux]."' height='100px'>";
                                    ?>
                                    </div>
                                <?php                                    
                                    $aux++;
                                }
                            ?>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="passoInscricao">
                            <h3>Sua Inscrição</h3>
                            <?php
                                if($inscricao['status'] == 0){ // EM ANALISE
                                    echo "<img src='http://www.esportscups.com.br/img/icones/pendente.png' alt='Inscrição em Análise' title='Inscrição em Análise'><br><br>";
                                    if($campeonato['precheckin'] > 0){
                                        echo "Está tudo OK com sua inscrição até o momento. Para confirmá-la basta realizar o <strong>PRÉ CHECK-IN</strong> que inicia <strong>".$campeonato['precheckin']." minutos</strong> antes do início da competição. Bons jogos.";
                                    }else{								
                                        echo "Sua inscrição está sendo analisada pela organização do torneio e em breve você terá uma resposta.";	
                                    }							
                                }elseif($inscricao['status'] == 1){ // APROVADA
                                    echo "<img src='http://www.esportscups.com.br/img/icones/aprovada.png' alt='Inscrição em Análise' title='Inscrição em Análise'><br><br>";
                                    echo "Sua inscrição está <strong>CONFIRMADA.</strong><br>Nos vemos dia ".date("d/m/Y - H:i", strtotime($campeonato['inicio']));
                                }else{ // RECUSADA
                                    echo "<img src='http://www.esportscups.com.br/img/icones/recusada.png' alt='Inscrição em Análise' title='Inscrição em Análise'><br><br>";
                                    echo "Sua inscrição foi recusada pela organização. <br> Para esclarecimentos, entre em contato direto através do e-mail: <strong>".$organizacao['email']."</strong>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
			<?php
			}else{
				echo "<h2>Inscrições Encerradas</h2><br>
					As inscrições para esta competição infelizmente já foram encerradas. <br>
					Acesse a página da organização e fique por dentro dos próximos torneios.
				";

			}
		}
	}else{
	?>
		<h2>REALIZE O LOGIN</h2>
		É necessário que você crie sua conta e realize o login <br>
		para poder participar das competições na plataforma. <br><br>
		Utilize o formulário que se encontra no topo da página.
	<?php
	}
?>


