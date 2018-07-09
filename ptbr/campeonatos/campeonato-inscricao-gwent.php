<?php
	if(isset($usuario['codigo'])){
		$verificarInscricao = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$usuario['codigo']."");
		$inscricao = mysqli_fetch_array($verificarInscricao);
		
		if(mysqli_num_rows($verificarInscricao) == 0){
			if($campeonato['status'] == 0 && $datahora < $campeonato['fim_inscricao'] && $datahora > $campeonato['inicio_inscricao']){ // INSCRIÇÕES ESTÃO ABERTAS
			?>
				<form action="ptbr/campeonatos/draft-enviar.php" method="post" onSubmit="return validar();">
                    <input type="text" name="funcao" id="funcao" value="inscricao" hidden="hidden">
                    <input type="hidden" name="codCampeonato" id="codCampeonato" value="<?php echo $campeonato['codigo']; ?>">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="passoInscricao">
                                <h3>Sua conta GOG.com</h3>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" name="conta" placeholder="Seu apelido no GOG" required class="form-control">  
                                    </div>                                     
                                </div>                                
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="passoInscricao">
                                <h3>Escolha suas Facções</h3>
                                <div class="row">
                                    <div class="col-4 col-md-4">
                                        <input type="checkbox" name="faccao[]" class="limitado" value="skellige" id="druida" hidden="hidden">
                                        <label for="druida" class="heroi">
                                            <img src="<?php echo "http://www.esportscups.com.br/img/draft/GWENT/skellige.png" ?>" width="100">
                                        </label>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <input type="checkbox" name="faccao[]" class="limitado" value="reinosdonorte" id="hunter" hidden="hidden">
                                        <label for="hunter" class="heroi">
                                            <img src="<?php echo "http://www.esportscups.com.br/img/draft/GWENT/reinosdonorte.png" ?>" width="100">
                                        </label>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <input type="checkbox" name="faccao[]" class="limitado" value="monstros" id="mage" hidden="hidden">
                                        <label for="mage" class="heroi">
                                            <img src="<?php echo "http://www.esportscups.com.br/img/draft/GWENT/monstros.png" ?>" width="100">
                                        </label>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <input type="checkbox" name="faccao[]" class="limitado" value="scoiatael" id="paladin" hidden="hidden">
                                        <label for="paladin" class="heroi">
                                            <img src="<?php echo "http://www.esportscups.com.br/img/draft/GWENT/scoiatael.png" ?>" width="100">
                                        </label>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <input type="checkbox" name="faccao[]" class="limitado" value="nilfgaard" id="priest" hidden="hidden">
                                        <label for="priest" class="heroi">
                                            <img src="<?php echo "http://www.esportscups.com.br/img/draft/GWENT/nilfgaard.png" ?>" width="100">
                                        </label>
                                    </div>
                                    <div class="col">
                                        <input type="submit" value="REALIZAR INSCRIÇÃO" class="btn btn-dark">
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>						
                </form>
			<?php	
			}else{ // INSCRIÇÕES ENCERRADAS
				echo "<h2>Inscrições Encerradas</h2><br>
					As inscrições para esta competição infelizmente já foram encerradas. <br>
					Acesse a página da organização e fique por dentro dos próximos torneios.
				";
			}
		}else{ // JÁ POSSUI INSCRIÇÃO
		?>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="passoInscricao">
                        <h3>Conta GOG.com Inscrita</h3>
                        <div class="row">
                            <div class="col conta">
                                <?php echo $inscricao['conta']; ?>
                            </div>
                        </div>                                
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="passoInscricao draft">
                        <h3>Facções Solicitadas</h3>
                        <div class="row">
                        <?php
                            $draft = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_draft WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$usuario['codigo']." "));
                            $faccao = explode(";", $draft['picks']);
                            $aux = 0;
                            while($aux < $campeonato['qtd_pick']){
                            ?>
                                <div class="col-4 col-md-4">
                                <?php
                                    echo "<img src='http://www.esportscups.com.br/img/draft/".$jogo['abreviacao']."/".$faccao[$aux].".png' alt='".$faccao[$aux]."' title='".$faccao[$aux]."' height='100px'>";
                                    $aux++;
                                ?>
                                </div>
                            <?php
                            }
                            if($inscricao['status'] == 0){
                            ?>
                                <div class="col-4 col-md-4">
                                    <br>
                                    <input type="button" class="btn btn-dark" value="ALTERAR" onClick="mudarDraftGwent();">
                                </div>
                            <?php
                            }
                        ?>
                        </div>                                
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="passoInscricao">
                        <h3>Status de Inscrição</h3>
                        <div class="row">
                            <div class="col">
                            <?php
                                if($inscricao['status'] == 0){ // EM ANALISE
                                    echo "<img src='http://www.esportscups.com.br/img/icones/pendente.png' alt='Inscrição em Análise' title='Inscrição em Análise'><br><br>";
                                    if($campeonato['precheckin'] > 0){
                                        echo "Está tudo OK com sua inscrição até o momento. Para confirmá-la basta realizar o <strong>PRÉ CHECK-IN</strong> que inicia ".$campeonato['precheckin']." minutos antes do início da competição. Bons jogos.";
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
                </div>
            </div>
		<?php
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


