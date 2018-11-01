<div class="painelPartida">
    <div class="container">
        <div class="row">
        <?php
            if($usuario['codigo'] == $sementeUm['codigo'] || $usuario['codigo'] == $sementeDois['codigo']){
            ?>
                <div class="col-12 col-md-8">
                    <div class="">
                        <ul class="menuChatPartida">
                            <li class="ativo" onClick="abaChat('1');">OPONENTE</li>
                            <?php
                                if($campeonato['tipo_inscricao'] != 0){
                                ?>
                                    <li class="chatEquipe" onClick="abaChat('0');">EQUIPE</li>
                                <?php
                                }
                            ?>
                        </ul> 
                        <div class="chatPartida">
                            <div class="mensagens">
                            </div>
                            <form action="" id="msgEquipe" onSubmit="return enviarMsgEquipe(<?php echo $vagaAtual['cod_equipe']; ?>,<?php echo $usuario['codigo']; ?>,<?php echo $partida['codigo']; ?>);">
                                <input type="text" name="mensagem" placeholder="ESCREVER MENSAGEM" class="msgParaEquipe mensagem">
                                <input type="submit" value="ENVIAR">
                            </form>
                            <form action="" id="msgGeral" onSubmit="return enviarMsgOponente(<?php echo $partida['codigo']; ?>,<?php echo $usuario['codigo']; ?>);">
                                <input type="text" name="mensagem" placeholder="ESCREVER MENSAGEM" class="msgParaGeral mensagem">
                                <input type="submit" value="ENVIAR">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                <?php
                    if($usuario['codigo'] == $sementeUm['codigo']){ // É O JOGADOR 01
                        $checkin = mysqli_query($conexao, "SELECT * FROM campeonato_partida_checkin WHERE cod_jogador = ".$sementeUm['codigo']." AND cod_partida = ".$partida['codigo']."");
                        if(mysqli_num_rows($checkin) == 0){ // CHECK-IN AINDA NÃO REALIZADO
                            if($partida['datahora'] != NULL){
                                if($datahora < $fimCheckin && $datahora > $inicioCheckin){ // CHECK-IN AINDA ESTÁ ABERTO
                                ?>
                                    <div class="alerta">
                                        Assim que estiver pronto para jogar, aperte o botão para realizar seu check-in e sinalizar seu oponente. <br><br>
                                        <input type="button" value="ESTOU PRONTO" class="btn btn-dark" onClick="realizarCheckin(<?php echo $partida['codigo'].",".$sementeUm['codigo']; ?>)"><br><br>
                                        Após realizar o check-in você declara que está pronto para jogar e o não comparecimento será considerado W.O.
                                    </div>
                                <?php   
                                }  
                            }elseif($partida['datalimite'] != NULL){
                                if($datahora < $partida['datalimite']){ // CHECK-IN AINDA ESTÁ ABERTO
                                ?>
                                    <div class="alerta">
                                        Assim que estiver pronto para jogar, aperte o botão para realizar seu check-in e sinalizar seu oponente. <br><br>
                                        <input type="button" value="ESTOU PRONTO" class="btn btn-dark" onClick="realizarCheckin(<?php echo $partida['codigo'].",".$sementeUm['codigo']; ?>);"><br><br>
                                        Após realizar o check-in você declara que está pronto para jogar e o não comparecimento será considerado W.O.
                                    </div>
                                <?php	
                                }else{ // CHECK-IN ENCERRADO (PERDEU DE W.O.)
                                ?>
                                    <div class="alerta">
                                        <h2>VOCÊ RECEBEU W.O.</h2>
                                        O limite era <?php echo date("d/m/Y - H:i", strtotime("+15minutes", strtotime($partida['datahora']))); ?>.
                                    </div>
                                <?php
                                }
                            }   
                        }else{
                            $checkin = mysqli_query($conexao, "SELECT * FROM campeonato_partida_checkin WHERE cod_jogador = ".$sementeDois['codigo']." AND cod_partida = ".$partida['codigo']."");
                            if(mysqli_num_rows($checkin) != 0){ // OPONENTE JÁ ESTÁ PRONTO
                                if($campeonato['qtd_ban'] != 0){ // É OBRIGATORIO FAZER BAN
                                    if($sementeUm['bans'] == NULL){ // MOSTRAR HERÓIS PARA BAN
                                        $herois = explode(";", $draftDois['picks']);
                                        $aux = 0;							
                                        echo "<h2>Você deve realizar ".$campeonato['qtd_ban']." banimento</h2><br>";
                                        echo "<form action='ptbr/campeonatos/draft-enviar.php' method='post' onSubmit='return validar();'>";
                                        echo "<input type='text' name='funcao' id='funcao' value='ban' hidden='hidden'>";
                                        echo "<input type='text' name='codSemente' id='codSemente' value='".$sementeUm['cod_semente']."' hidden='hidden'>";
                                        echo "<input type='hidden' name='codPartida' id='codPartida' value='".$partida['codigo']."'>";
                                        echo "<input type='hidden' name='codCampeonato' id='codCampeonato' value='".$campeonato['codigo']."'>";
                                        ?>
                                        <div class="row centralizar">
                                        <?php
                                        while($aux < $campeonato['qtd_pick']){
                                        ?>
                                            <div class="col">
                                                <input type="checkbox" name="heroi[]" class="escolha limitado" value="<?php echo $herois[$aux]; ?>" id="<?php echo $herois[$aux]; ?>" hidden="hidden">
                                                <label for="<?php echo $herois[$aux]; ?>" class="heroi">
                                                    <img src="<?php echo "http://www.esportscups.com.br/img/draft/".$jogo['abreviacao']."/".$herois[$aux].".png" ?>" title="<?php echo $herois[$aux]; ?>" alt= "<?php echo $herois[$aux]; ?>" width="100">
                                                </label>
                                            </div>                                            
                                        <?php
                                            $aux++;
                                        }
                                        ?>
                                        </div>
                                        <?php
                                        echo "<br><input type='submit' value='REALIZAR BAN' class='btn btn-dark'>";
                                        echo "</form>";									
                                    }else{
                                        if($sementeDois['bans'] == NULL){
                                        ?>
                                            <div class="alerta">
                                                <h2>AGUARDANDO BANIMENTO DO OPONENTE</h2>
                                                <img src="http://www.esportscups.com.br/img/loading.gif" alt="Aguardando" title="Aguardando">
                                            </div>
                                        <?php
                                        }else{								
                                        ?>
                                            <div class="alerta centralizar">
                                            <?php
                                             include "../../../scripts/partida-placar.php";
                                             $placar = verificarPlacar($sementeUm['cod_semente'], $partida['codigo']);
                                             if($placar == 0){ // JOGADOR AINDA NÃO LANÇOU RESULTADO
                                              ?>
                                                <form action="" method="post" onSubmit="return enviarPlacar(<?php echo $sementeUm['cod_semente'].", ".$partida['codigo']; ?>);" id="formPlacar">
                                                    <h2>Resultado Final</h2>
                                                    Informe o resultado final da série.<br><br>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div>
                                                                <input type="number" class="form-control" value="0" name="placarUm"><br>
                                                                <strong><?php echo $inscUm['conta']; ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div>
                                                                <input type="number" class="form-control" value="0" name="placarDois"><br>
                                                                <strong><?php echo $inscDois['conta']; ?></strong>
                                                            </div>
                                                        </div>
                                                    </div><br>
                                                    <input type="submit" value="ENVIAR RESULTADO" class="btn btn-dark">						
                                                </form>
                                            <?php
                                             }else{ // JOGADOR JÁ LANÇOU RESULTADO (AGUARDANDO CONFIRMAÇÃO)
                                             ?>
                                                <h2>Valores Recebidos</h2>
                                                Placares informados pelos responsáveis.<br><br>
                                                <div class="esquerda">
                                                   <?php echo "<strong>".$sementeUm['nick'].":</strong> ".$placar['placar_um']." x ".$placar['placar_dois']; ?>
                                                </div>
                                                <div class="direita">
                                                    <?php
                                                    $placar2 = verificarPlacar($sementeDois['cod_semente'], $partida['codigo']);
                                                    if($placar2 == 0){
                                                       echo "Aguardando...";
                                                    }else{
                                                      echo "<strong>".$sementeDois['nick'].":</strong> ".$placar2['placar_um']." x ".$placar2['placar_dois'];
                                                    }
                                                    ?>
                                                </div><br><br>
                                                É obrigatório que os dois responsáveis pela partida informem o msmo placar para que o mesmo seja confirmado e validado. <br><br>
                                                <input type="button" value="ENVIAR NOVO PLACAR" class="btn btn-dark" onClick="reenviarPlacar(<?php echo $sementeUm['cod_semente'].", ".$partida['codigo']; ?>)">							
                                                <?php
                                             }
                                            ?>																		
                                            </div>
                                        <?php
                                        }
                                    }
                                }else{ // NÃO É OBRIGATORIO REALIZAR BAN
                                    ?>
                                        <div class="draftUm">
                                            <?php carregarDraft($draftUm['picks'], $sementeDois['bans'], $jogo['abreviacao'], $campeonato['qtd_pick']); ?>
                                        </div>										
                                        <div class="draftDois">
                                            <?php carregarDraft($draftDois['picks'], $sementeUm['bans'], $jogo['abreviacao'], $campeonato['qtd_pick']); ?>
                                        </div>
                                        <div class="alerta centralizar">
                                        <?php
                                            include "../../../scripts/partida-placar.php";
                                            $placar = verificarPlacar($sementeUm['cod_semente'], $partida['codigo']);
                                            if($placar == 0){ // JOGADOR AINDA NÃO LANÇOU RESULTADO
                                            ?>
                                                <form action="" method="post" onSubmit="return enviarPlacar(<?php echo $sementeUm['cod_semente'].", ".$partida['codigo']; ?>);" id="formPlacar">
                                                    <h2>Resultado Final</h2>
                                                    Informe o resultado final da série.<br><br>
                                                    <div class="esquerda">
                                                        <div class="quantity">
                                                            <input type="number" value="0" name="placarUm">
                                                        </div>
                                                        <?php echo $inscUm['conta']; ?>
                                                    </div>
                                                    <div class="direita">
                                                        <div class="quantity">
                                                            <input type="number" value="0" name="placarDois">
                                                        </div>
                                                        <?php echo $inscDois['conta']; ?>
                                                    </div>
                                                    <br><br><br>
                                                    <input type="submit" value="ENVIAR RESULTADO" class="btn btn-dark">						
                                                </form>
                                            <?php
                                            }else{ // JOGADOR JÁ LANÇOU RESULTADO (AGUARDANDO CONFIRMAÇÃO)
                                             ?>
                                                <h2>Valores Recebidos</h2>
                                                Placares informados pelos responsáveis.<br><br>
                                                <div class="esquerda">
                                                   <?php echo "<strong>".$sementeUm['nick'].":</strong> ".$placar['placar_um']." x ".$placar['placar_dois']; ?>
                                                </div>
                                                <div class="direita">
                                                    <?php
                                                    $placar2 = verificarPlacar($sementeDois['cod_semente'], $partida['codigo']);
                                                    if($placar2 == 0){
                                                       echo "Aguardando...";
                                                    }else{
                                                      echo "<strong>".$sementeDois['nick'].":</strong> ".$placar2['placar_um']." x ".$placar2['placar_dois'];
                                                    }
                                                    ?>
                                                </div><br><br>
                                                É obrigatório que os dois responsáveis pela partida informem o msmo placar para que o mesmo seja confirmado e validado. <br><br>
                                                <input type="button" value="ENVIAR NOVO PLACAR" class="btn btn-dark" onClick="reenviarPlacar(<?php echo $sementeUm['cod_semente'].", ".$partida['codigo']; ?>)">							
                                                <?php
                                            }
                                            ?>	
                                        </div>
                                    <?php						
                                }
                            }else{ // OPONENTE AINDA NÃO ESTÁ PRONTO.
                                if($partida['datahora'] != NULL){
                                    if($datahora > $fimCheckin){ // JÁ PODE PEDIR W.O.
                                    ?>
                                        <div class="alerta">
                                            Seu oponente infelizmente não realizou o check-in. <br>
                                            Você recebeu vitória por W.O.<br><br>
                                            <input type="button" value="RECEBER W.O." class="btn btn-dark" onClick="receberWo(<?php echo $partida['codigo']; ?>,<?php echo $sementeUm['cod_semente']; ?>);">						
                                        </div>
                                    <?php	
                                    }else{ // AINDA ESTÁ NO PRAZO PARA REALIZAR CHECK-IN
                                    ?>

                                        <div class="alerta">
                                            Seu oponente ainda não realizou o check-in. <br>
                                            O prazo máximo é até +15min do horário marcado da partida. <br><br>
                                            Caso ele não esteja pronto até <strong><?php echo date("d/m/Y - H:i", strtotime("+15minutes", strtotime($partida['datahora']))); ?></strong>, aparecerá aqui botão para você reinvindicar seu W.O. <br>
                                            Caso não apareça, basta atualizar sua página.
                                        </div>
                                    <?php	
                                    }	
                                }elseif($partida['datalimite'] != NULL){
                                    if($datahora > $datalimite){ // JÁ PODE PEDIR W.O.
                                    ?>
                                        <div class="alerta">
                                            Seu oponente infelizmente não realizou o check-in. <br>
                                            Você recebeu vitória por W.O.<br><br>
                                            <input type="button" value="RECEBER W.O." class="btn btn-dark" onClick="receberWo(<?php echo $partida['codigo']; ?>,<?php echo $sementeUm['cod_semente']; ?>);">								
                                        </div>
                                    <?php	
                                    }else{ // AINDA ESTÁ NO PRAZO PARA REALIZAR CHECK-IN
                                    ?>
                                        <div class="alerta">
                                            Seu oponente ainda não realizou o check-in. <br>
                                            Você deve entrar em contato com ele para marcar o melhor horário para jogarem.<br><br>	
                                            Caso ele não esteja pronto até <strong><?php echo date("d/m/Y - H:i", strtotime($datalimite)); ?></strong>, aparecerá aqui botão para você reinvindicar seu W.O. <br>
                                            Caso não apareça, basta atualizar sua página.
                                        </div>
                                    <?php	
                                    }
                                }

                            }    
                        }
                    }else{ // É O JOGADOR 02
                        $checkin = mysqli_query($conexao, "SELECT * FROM campeonato_partida_checkin WHERE cod_jogador = ".$sementeDois['codigo']." AND cod_partida = ".$partida['codigo']."");
                        if(mysqli_num_rows($checkin) == 0){ // CHECK-IN AINDA NÃO REALIZADO
                            if($partida['datahora'] != NULL){
                                if($datahora < $fimCheckin && $datahora > $inicioCheckin){ // CHECK-IN AINDA ESTÁ ABERTO
                                ?>
                                    <div class="alerta">
                                        Assim que estiver pronto para jogar, aperte o botão para realizar seu check-in e sinalizar seu oponente. <br><br>
                                        <input type="button" value="ESTOU PRONTO" class="btn btn-dark" onClick="realizarCheckin(<?php echo $partida['codigo'].",".$sementeDois['codigo']; ?>)"><br><br>
                                        Após realizar o check-in você declara que está pronto para jogar e o não comparecimento será considerado W.O.
                                    </div>
                                <?php	
                                }else{ // CHECK-IN ENCERRADO (PERDEU DE W.O.)
                                ?>
                                    <div class="alerta">
                                        <h2>VOCÊ RECEBEU W.O.</h2>
                                        O limite era <?php echo date("d/m/Y - H:i", strtotime("+15minutes", strtotime($partida['datahora']))); ?>.
                                    </div>
                                <?php
                                }
                            }elseif($partida['datalimite'] != NULL){
                                if($datahora < $datalimite){ // CHECK-IN AINDA ESTÁ ABERTO
                                ?>
                                    <div class="alerta">
                                        Assim que estiver pronto para jogar, aperte o botão para realizar seu check-in e sinalizar seu oponente. <br><br>
                                        <input type="button" value="ESTOU PRONTO" class="botaoPqLaranja" onClick="realizarCheckin(<?php echo $partida['codigo'].",".$sementeDois['codigo']; ?>)"><br><br>
                                        Após realizar o check-in você declara que está pronto para jogar e o não comparecimento será considerado W.O.
                                    </div>
                                <?php	
                                }else{ // CHECK-IN ENCERRADO (PERDEU DE W.O.)
                                ?>
                                    <div class="alerta">
                                        <h2>VOCÊ RECEBEU W.O.</h2>
                                        O limite era <?php echo date("d/m/Y - H:i", strtotime("+15minutes", strtotime($partida['datahora']))); ?>.
                                    </div>
                                <?php
                                }
                            }


                        }else{ // JÁ REALIZOU O CHECK-IN
                            $checkin = mysqli_query($conexao, "SELECT * FROM campeonato_partida_checkin WHERE cod_jogador = ".$sementeUm['codigo']." AND cod_partida = ".$partida['codigo']."");
                            if(mysqli_num_rows($checkin) != 0){ // OPONENTE JÁ ESTÁ PRONTO
                                if($campeonato['qtd_ban'] != 0){ // É OBRIGATORIO FAZER BAN
                                    if($sementeDois['bans'] == NULL){ // MOSTRAR HERÓIS PARA BAN
                                        $herois = explode(";", $draftUm['picks']);
                                        $aux = 0;							
                                        echo "<h2>Você deve realizar ".$campeonato['qtd_ban']." banimento</h2><br>";
                                        echo "<form action='ptbr/campeonatos/draft-enviar.php' method='post' onSubmit='return validar();' class='text-center'>";
                                        echo "<input type='text' name='funcao' id='funcao' value='ban' hidden='hidden'>";
                                        echo "<input type='text' name='codSemente' id='codSemente' value='".$sementeDois['cod_semente']."' hidden='hidden'>";
                                        echo "<input type='hidden' name='codPartida' id='codPartida' value='".$partida['codigo']."'>";
                                        echo "<input type='hidden' name='codCampeonato' id='codCampeonato' value='".$campeonato['codigo']."'>";
                                        ?>
                                        <div class="row centralizar">
                                        <?php
                                        while($aux < $campeonato['qtd_pick']){
                                        ?>
                                            <div class="col">
                                                <input type="checkbox" name="heroi[]" class="escolha limitado" value="<?php echo $herois[$aux]; ?>" id="<?php echo $herois[$aux]; ?>" hidden="hidden">
                                                <label for="<?php echo $herois[$aux]; ?>" class="heroi">
                                                    <img src="<?php echo "http://www.esportscups.com.br/img/draft/".$jogo['abreviacao']."/".$herois[$aux].".png" ?>" title="<?php echo $herois[$aux]; ?>" alt= "<?php echo $herois[$aux]; ?>" width="100">
                                                </label>
                                            </div>                                            
                                        <?php
                                            $aux++;
                                        }
                                        ?>
                                        </div>
                                        <?php
                                        echo "<br><input type='submit' value='REALIZAR BAN' class='btn btn-dark'>";
                                        echo "</form>";
                                    }else{
                                        if($sementeUm['bans'] == NULL){
                                        ?>
                                            <div class="alerta">
                                                <h2>AGUARDANDO BANIMENTO DO OPONENTE</h2>
                                                <img src="http://www.esportscups.com.br/img/loading.gif" alt="Aguardando" title="Aguardando">
                                            </div>
                                        <?php
                                        }else{
                                            ?>
                                            <div class="alerta centralizar">
                                            <?php
                                            include "../../../scripts/partida-placar.php";
                                            $placar = verificarPlacar($sementeDois['cod_semente'], $partida['codigo']);
                                            if($placar == 0){ // JOGADOR AINDA NÃO LANÇOU RESULTADO
                                            ?>
                                            <form action="" method="post" onSubmit="return enviarPlacar(<?php echo $sementeDois['cod_semente'].", ".$partida['codigo']; ?>);" id="formPlacar">
                                                <h2>Resultado Final</h2>
                                                Informe o resultado final da série.<br><br>
                                                <div class="row">
                                                    <div class="col">
                                                        <div>
                                                            <input type="number" class="form-control" value="0" name="placarUm"><br>
                                                            <strong><?php echo $inscUm['conta']; ?></strong>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div>
                                                            <input type="number" class="form-control" value="0" name="placarDois"><br>
                                                            <strong><?php echo $inscDois['conta']; ?></strong>
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <input type="submit" value="ENVIAR RESULTADO" class="btn btn-dark">							
                                            </form>
                                            <?php
                                             }else{ // JOGADOR JÁ LANÇOU RESULTADO (AGUARDANDO CONFIRMAÇÃO)
                                             ?>
                                                <h2>Valores Recebidos</h2>
                                                Placares informados pelos responsáveis.<br><br>
                                                <div class="esquerda">
                                                <?php 
                                                    $placar2 = verificarPlacar($sementeUm['cod_semente'], $partida['codigo']);
                                                    if($placar2 == 0){
                                                        echo "Aguardando...";
                                                    }else{
                                                        echo "<strong>".$sementeUm['nick'].":</strong> ".$placar2['placar_um']." x ".$placar2['placar_dois'];
                                                    }												 
                                                ?>
                                                </div>
                                                <div class="direita">
                                                <?php												
                                                    echo "<strong>".$sementeDois['nick'].":</strong> ".$placar['placar_um']." x ".$placar['placar_dois'];
                                                ?>
                                                </div><br><br>
                                                É obrigatório que os dois responsáveis pela partida informem o msmo placar para que o mesmo seja confirmado e validado. <br><br>
                                                <input type="button" value="ENVIAR NOVO PLACAR" class="botaoPqLaranja" onClick="reenviarPlacar(<?php echo $sementeDois['cod_semente'].", ".$partida['codigo']; ?>)">							
                                                <?php
                                             }
                                            ?>																		
                                            </div>
                                            <?php
                                        }
                                    }
                                }else{ // NÃO É OBRIGATORIO REALIZAR BAN
                                    ?>
                                        <div class="alerta centralizar">
                                        <?php
                                            include "../../../scripts/partida-placar.php";
                                            $placar = verificarPlacar($sementeDois['cod_semente'], $partida['codigo']);
                                            if($placar == 0){ // JOGADOR AINDA NÃO LANÇOU RESULTADO
                                            ?>
                                            <form action="" method="post" onSubmit="return enviarPlacar(<?php echo $sementeDois['cod_semente'].", ".$partida['codigo']; ?>);" id="formPlacar">
                                                <h2>Resultado Final</h2>
                                                Informe o resultado final da série.<br><br>
                                                <div class="esquerda">
                                                    <div class="quantity">
                                                        <input type="number" value="0" name="placarUm">
                                                    </div>
                                                </div>
                                                <div class="direita">
                                                    <div class="quantity">
                                                        <input type="number" value="0" name="placarDois">
                                                    </div>
                                                </div>
                                                <br><br><br>
                                                <input type="submit" value="ENVIAR RESULTADO" class="botaoPqLaranja">						
                                            </form>
                                            <?php
                                            }else{ // JOGADOR JÁ LANÇOU RESULTADO (AGUARDANDO CONFIRMAÇÃO)
                                            ?>
                                                <h2>Valores Recebidos</h2>
                                                Placares informados pelos responsáveis.<br><br>
                                                <div class="esquerda">
                                                <?php 
                                                    $placar2 = verificarPlacar($sementeUm['cod_semente'], $partida['codigo']);
                                                    if($placar2 == 0){
                                                        echo "Aguardando...";
                                                    }else{
                                                        echo "<strong>".$sementeUm['nick'].":</strong> ".$placar2['placar_um']." x ".$placar2['placar_dois'];
                                                    }												 
                                                ?>
                                                </div>
                                                <div class="direita">
                                                <?php												
                                                    echo "<strong>".$sementeDois['nick'].":</strong> ".$placar['placar_um']." x ".$placar['placar_dois'];
                                                ?>
                                                </div><br><br>
                                                É obrigatório que os dois responsáveis pela partida informem o msmo placar para que o mesmo seja confirmado e validado. <br><br>
                                                <input type="button" value="ENVIAR NOVO PLACAR" class="btn btn-dark" onClick="reenviarPlacar(<?php echo $sementeDois['cod_semente'].", ".$partida['codigo']; ?>)">							
                                                <?php
                                             }
                                            ?>
                                        </div>
                                    <?php						
                                }
                            }else{ // OPONENTE AINDA NÃO ESTÁ PRONTO.
                                if($partida['datahora'] != NULL){
                                    if($datahora > $fimCheckin){ // JÁ PODE PEDIR W.O.
                                    ?>
                                        <div class="alerta">
                                            <h3>Seu oponente infelizmente não realizou o check-in.</h3>
                                            Você recebeu vitória por W.O.<br><br>
                                            <input type="button" value="RECEBER W.O." class="botaoPqLaranja" onClick="receberWo(<?php echo $partida['codigo']; ?>,<?php echo $sementeDois['cod_semente']; ?>)">									
                                        </div>
                                    <?php	
                                    }else{ // AINDA ESTÁ NO PRAZO PARA REALIZAR CHECK-IN
                                    ?>
                                        <div class="alerta">
                                            Seu oponente ainda não realizou o check-in. <br>
                                            O prazo máximo é até +15min do horário marcado da partida. <br><br>
                                            Caso ele não esteja pronto até <strong><?php echo date("d/m/Y - H:i", strtotime("+15minutes", strtotime($partida['datahora']))); ?></strong>, aparecerá aqui botão para você reinvindicar seu W.O. <br>
                                            Caso não apareça, basta atualizar sua página.
                                        </div>
                                    <?php	
                                    }
                                }elseif($partida['datalimite'] != NULL){
                                    if($datahora > $datalimite){ // JÁ PODE PEDIR W.O.
                                    ?>
                                        <div class="alerta">
                                            <h3>Seu oponente infelizmente não realizou o check-in.</h3>
                                            Você recebeu vitória por W.O.<br><br>
                                            <input type="button" value="RECEBER W.O." class="botaoPqLaranja" onClick="receberWo(<?php echo $partida['codigo']; ?>,<?php echo $sementeDois['cod_semente']; ?>)">									
                                        </div>
                                    <?php	
                                    }else{ // AINDA ESTÁ NO PRAZO PARA REALIZAR CHECK-IN
                                    ?>
                                        <div class="alerta">
                                            Seu oponente ainda não realizou o check-in. <br>
                                            Você deve entrar em contato com ele para marcar o melhor horário para jogarem.<br><br>	
                                            Caso ele não esteja pronto até <strong><?php echo date("d/m/Y - H:i", strtotime($datalimite)); ?></strong>, aparecerá aqui botão para você reinvindicar seu W.O. <br>
                                            Caso não apareça, basta atualizar sua página.
                                        </div>
                                    <?php	
                                    }
                                }

                            }
                        }  
                    }
                ?>
                </div>
            <?php
            }
        ?>
        </div>
    </div>
</div>