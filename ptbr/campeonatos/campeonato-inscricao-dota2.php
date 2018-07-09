<?php
	if(isset($usuario['codigo'])){
		$verificarInscricao = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$usuario['codigo']."");
		$inscricao = mysqli_fetch_array($verificarInscricao);
        
        if(mysqli_num_rows($verificarInscricao) == 0){ // NÃO FEZ INSCRIÇÃO AINDA
            if($campeonato['status'] == 0 && $datahora < $campeonato['fim_inscricao'] && $datahora > $campeonato['inicio_inscricao']){
                if($campeonato['jogador_por_time'] == 1){ // TORNEIO SOLO
                ?>
                    <form action="scripts/campeonato-inscricao-geral-enviar.php" method="post">
                        <!-- <input type="hidden" name="conta" required value="<?php echo $usuario['steam']; ?>"> -->
                        <input type="hidden" name="codcampeonato" value="<?php echo $campeonato['codigo']; ?>">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="passoInscricao">
                                    <h3>Sua conta Steam</h3><br>
                                    <div class="row">
                                        <div class="img col-3 col-md-3">
                                            <img src="http://www.esportscups.com.br/img/icones/steam.png" alt="">	
                                        </div>
                                        <div class="conta col-9 col-md-9">
                                            <input type="text" name="conta" class="form-control" placeholder="Qual o seu nick na Steam?">
                                        </div>
                                    </div>
                                    <br>
                                    <!-- <input type="button" class="btn btn-dark" value="TROCAR CONTA" onClick="window.location.replace('ptbr/usuario/<?php echo $usuario['codigo']; ?>/permissoes/');">-->
                                    * Não será possível alterar a conta ou time após realizar a inscrição.
                                </div>                            
                            </div> 
                            <div class="col-12 col-md-4">
                                <div class="passoInscricao draft">
                                    <h3>Entrar na disputa?</h3>
                                    <input type="submit" value="Sim, entrar agora!" class="btn btn-dark">
                                </div>                            
                            </div> 
                        </div>
                    </form>
                <?php       
                }else{ // TORNEIO EM EQUIPE
                    $equipes = mysqli_query($conexao, "SELECT * FROM jogador_equipe
                    INNER JOIN equipe ON equipe.codigo = jogador_equipe.cod_equipe
                    WHERE jogador_equipe.cod_jogador = ".$usuario['codigo']." AND status = 2 AND equipe.cod_jogo = ".$campeonato['cod_jogo']."
                    ");   
                    ?>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="passo">
                                    <h2>Selecione sua Equipe</h2>
                                    <?php
                                    if(mysqli_num_rows($equipes) == 0){ // NÃO É CAPITÃO DE NENHUMA EQUIPE
                                        echo "Para realizar sua inscrição no campeonato, você precisa ser Capitão de alguma equipe de <br><strong>".$jogo['nome']."</strong><br>com no mínimo ".$campeonato['jogador_por_time']." integrantes";
                                    }else{ // É CAPITÃO DE ALGUMA EQUIPE
                                    ?>
                                        <br>
                                        <select name="codEquipe" id="codEquipe" onChange="trocarEquipe(<?php echo $campeonato['jogador_por_time']; ?>);" class="form-control">
                                            <option value="" hidden> - SELECIONE SUA EQUIPE - </option>
                                            <?php
                                                while($equipe = mysqli_fetch_array($equipes)){
                                                    echo "<option value='".$equipe['codigo']."'>".$equipe['tag']." - ".$equipe['nome']."</option>";
                                                }
                                            ?>
                                        </select><br><br>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="passo passo2">
                               </div>
                            </div>
                        </div>				
                    <?php
                }
            }else{
                if($datahora < $campeonato['inicio_inscricao']){ // INSCRIÇÕES NÃO FORAM ABERTAS AINDA
					echo "
						<h2>FORA DO PRAZO DE INSCRIÇÃO</h2>
						As inscrições para este campeonato não estão ativas.<br><br>
						No box acima e à direita você pode se informar melhor quanto as datas de inscrição.
					";
				}elseif($datahora > $campeonato['fim_inscricao']){ // INSCRIÇÕES FORAM ENCERRADAS
					echo "
						<h2>PRAZO DE INSCRIÇÃO ENCERRADO</h2>
						As inscrições para este campeonato foram encerradas.<br><br>
						Fique atento às datas de inscrição para não perder nenhuma oportunidade.
					";
				}elseif($totalInscricoes < $campeonato['vagas']){ // SEM VAGAS DISPONÍVEIS
					echo "
						<h2>TODAS AS VAGAS FORAM PREENCHIDAS</h2>
						Felizmente, este campeonato não possui mais vaga disponível.<br><br>
						Fique atento às mídias sociais da organização para ficar por dentro das novidades.
					";
				}else{ // INSCRIÇÕES ENCERRADAS
					echo "
						<h2>PRAZO DE INSCRIÇÃO ENCERRADO</h2>
						As inscrições para este campeonato foram encerradas.<br><br>
						Fique atento às datas de inscrição para não perder nenhuma oportunidade.
					";
				}        
            }
        }else{ // JÁ REALIZOU INSCRIÇÃO
            if($campeonato['jogador_por_time'] == 1){ // INSCRIÇÃO SOLO
            ?>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="passoInscricao">
                            <h3>Sua conta Steam</h3>
                            <div class="row">
                                <div class="img col-3 col-md-3">
                                    <img src="http://www.esportscups.com.br/img/icones/steam.png" alt="">	
                                </div>
                                <div class="conta col-9 col-md-9">
                                    <?php echo $inscricao['conta']; ?>	
                                </div>
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
            }else{ // TORNEIO EM EQUIPE
                $equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$inscricao['cod_equipe'].""));
                $lineup = mysqli_query($conexao, "
                    SELECT * FROM campeonato_lineup
                    INNER JOIN jogador ON jogador.codigo = campeonato_lineup.cod_jogador
                    WHERE campeonato_lineup.cod_equipe = ".$equipe['codigo']." AND campeonato_lineup.cod_campeonato = ".$campeonato['codigo']."
                ");
                ?>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="passoInscricao">
                            <h3>Equipe Inscrita</h3>
                            <img src="<?php echo $equipe['logo']; ?>" alt="" class="logo" width="80%"><br>
                            <?php echo "<h1>".$equipe['nome']."</h1>"; ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="passoInscricao passo3">
                            <h3>Formação</h3>
                            <?php
                                while($integrante = mysqli_fetch_array($lineup)){
                                ?>
                                    <div class="jogador">						
                                        <img src="<?php echo "http://www.esportscups.com.br/img/".$integrante['foto_perfil']; ?>" height="30px" width="30px" >
                                        <?php echo $integrante['nome']." '<strong>".$integrante['nick']."</strong>' ".$integrante['sobrenome']; ?>
                                    </div>
                                <?php
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="passoInscricao">
                            <h2>Status Inscrição</h2>
                            <?php
                                if($inscricao['status'] == 0){ // EM ANALISE
                                    echo "<img src='http://www.esportscups.com.br/img/icones/pendente.png' alt='Inscrição em Análise' title='Inscrição em Análise'><br><br>";
                                    if($campeonato['valor_escoin'] > 0){
                                        echo "O investimento neste torneio é de e$ ".number_format($campeonato['valor_escoin'], 0, '', '.');
                                    }elseif($campeonato['valor_real'] > 0){
                                        echo "O investimento neste torneio é de <strong>R$ ".number_format($campeonato['valor_real'], 2, ',', '.')."</strong><br>";
                                        if($usuario['saldo'] >= $campeonato['valor_real']){
                                            echo "Felizmente você tem saldo disponível em sua carteira, para confirmar sua inscrição basta clicar no botão abaixo.<br><br>
                                            <input type='button' value='Garantir Vaga' class='btn btn-dark' onClick='garantirVagaPaga(".$campeonato['codigo'].");' >";
                                        }else{
                                            echo "Para adicionar saldo em sua Carteira R$, basta clicar no botão abaixo. Após seguir o procedimento basta retornar a esta página para mais informações.<br><br>
                                            <a href='ptbr/usuario/".$usuario['codigo']."/carteira-real/adicionar-saldo/'><input type='button' value='Adicionar Fundos' class='btn btn-dark' ></a>
                                            ";
                                        }
                                    }else{
                                        if($campeonato['precheckin'] > 0){
                                            echo "Está tudo OK com sua inscrição até o momento. Para confirmá-la basta realizar o <strong>PRÉ CHECK-IN</strong> que inicia ".$campeonato['precheckin']." minutos antes do início da competição. Bons jogos.";
                                        }else{								
                                            echo "Sua inscrição está sendo analisada pela organização do torneio e em breve você terá uma resposta.";	
                                        }   
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
        }
	}else{ // USUÁRIO NAO ESTÁ LOGADO.
	?>
		<h2>REALIZE O LOGIN</h2>
		É necessário que você crie sua conta e realize o login <br>
		para poder participar das competições na plataforma. <br><br>
		Utilize o formulário que se encontra no topo da página.
	<?php		
	}
?>


