<?php
    if($campeonato['codigo'] == NULL){
        echo "ok";
    }else{
    ?>
        <div class="bgjogo <?php echo $jogo['background']; ?>">
            <div class="container">
                <div class="row justify-content-between">
                    <?php
                        if($campeonato['thumb'] != NULL){
                        ?>
                            <div class="col-4 col-md-3">
                                <img src="img/<?php echo $campeonato['thumb']; ?>" width="100%">
                            </div>
                        <?php
                        }
                    ?>   
                    <div class="col-8 col-md-5">
                        <br>
                        <div class="row">
                            <div class="col-12 col-md-12">
                            <?php
                                switch($campeonato['cod_jogo']){
                                    case 369: // HEARTHSTONE
                                        echo "<img src='https://www.esportscups.com.br/img/icones/hs.png' alt='Hearthstone' title='Hearthstone' class='iconeJogo'>";
                                        break;
                                    case 123: // GWENT
                                        echo "<img src='https://www.esportscups.com.br/img/icones/gwent.png' alt='GWENT: The Witcher Card Game' title='GWENT: The Witcher Card Game' class='iconeJogo'>";
                                        break;
                                    case 147: // League of Legends
                                        echo "<img src='https://www.esportscups.com.br/img/icones/lol.png' alt='League of Legends' title='League of Legends' class='iconeJogo'>";
                                        break;
                                    case 357: // Dota 2
                                        echo "<img src='https://www.esportscups.com.br/img/icones/dota2.png' alt='Dota 2' title='Dota 2' class='iconeJogo'>";
                                        break;
                                    case 258: // Overwatch
                                        echo "<img src='https://www.esportscups.com.br/img/icones/overwatch2.png' alt='Overwatch' title='Overwatch' class='iconeJogo'>";
                                        break;
                                }
                                echo $jogo['nome']." - ".$campeonato['plataforma'];
                            ?>
                            </div>
                            <div class="col-12 col-md-12">
                                <h1><?php echo $campeonato['nome']; ?></h1>
                            </div>                    
                            <?php
                                if($campeonato['cod_divisao'] != NULL){
                                    $liga = mysqli_fetch_array(mysqli_query($conexao, "
                                        SELECT * FROM liga_divisao
                                        RIGHT JOIN liga ON liga.codigo = liga_divisao.cod_liga
                                        WHERE liga_divisao.codigo = ".$campeonato['cod_divisao']."
                                    "));
                                    ?>
                                        <div class="col-12 col-md-12">
                                            Liga eSports <strong><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/"><?php echo $liga['nome']; ?></a></strong>
                                        </div>
                                    <?php
                                }
                            ?>
                            <div class="col-12 col-md-12">
                                Por <strong><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/"><?php echo $organizacao['nome']; ?></strong></a>
                            </div>
                            <br><br>  
                            <div class="col-12 col-md-12">
                                <button type="button" class="btn btn-azul btn-lg" role="button" disabled>
                                    <strong>INSCRIÇÃO</strong><br>
                                    <?php 
                                        if($campeonato['valor_escoin'] > 0){
                                            echo "e$ ".number_format($campeonato['valor_escoin'], 0, '', '.');	
                                        }elseif($campeonato['valor_real'] > 0){
                                            echo "R$ ".number_format($campeonato['valor_real'], 2, ',' , '.');
                                        }else{
                                            echo "GRATUITA";
                                        }											
                                    ?>
                                </button>
                                <?php
                                    if($campeonato['precheckin'] > 0){
                                    ?>
                                        <button type="button" class="btn btn-azul btn-lg" role="button" disabled>
                                            <strong>CHECK-IN</strong><br>
                                            <?php echo date("d/m - H:i", strtotime("-".$campeonato['precheckin']."minutes", strtotime($campeonato['inicio']))); ?>
                                        </button>
                                    <?php	
                                    }
                                ?>
                                <button type="button" class="btn btn-azul btn-lg" role="button" disabled>
                                    <strong>INÍCIO DO TORNEIO</strong><br>
                                    <?php 
                                        echo date("d/m/Y - H:i", strtotime($campeonato['inicio'])); 
                                    ?>                            
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="boxInscricao">
                            <div class="row centralizar">
                                <div class="col-8 col-md-8" style="padding: 15px 10px;">
                                <?php
                                    if($datahora > $campeonato['inicio_inscricao']){ // Inscrição já foi iniciada
                                        if($datahora < $campeonato['fim_inscricao'] && $campeonato['status'] == 0){ // Inscrições abertas ainda
                                        ?>
                                            <h4>Inscrições Abertas</h4>
                                            até <?php echo date("d/m/Y - H:i", strtotime($campeonato['fim_inscricao'])); ?>
                                        <?php
                                        }else{ // Inscrições encerradas
                                            if($campeonato['status'] == 1){ // TORNEIO EM ANDAMENTO
                                            ?>
                                                <h4>Em Andamento</h4>
                                                até <?php echo date("d/m/Y - H:i", strtotime($campeonato['fim_inscricao'])); ?>
                                            <?php	
                                            }elseif($campeonato['status'] == 2){ // FINALIZADO (mostrar ganhador)
                                                $campeao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_colocacao WHERE cod_campeonato = ".$campeonato['codigo']." AND posicao = 1"));

                                                if($campeao['cod_equipe'] == NULL){
                                                    if($campeao['cod_jogador'] != NULL){
                                                        $campeao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato =  ".$campeonato['codigo']." AND cod_jogador = ".$campeao['cod_jogador']." "));
                                                        echo "<h3>".$campeao['conta']."</h3>";
                                                        echo "Grande Campeão";
                                                    }else{
                                                    ?>
                                                        <h3>Inscrições Encerradas</h3>
                                                        em <?php echo date("d/m/Y - H:i", strtotime($campeonato['fim_inscricao'])); ?>
                                                    <?php	
                                                    }							
                                                }else{
                                                    $campeao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo =  ".$campeao['cod_equipe'].""));
                                                    echo "<h3>".$campeao['conta']."</h3>";
                                                    echo "Grande Campeão";
                                                }

                                            }elseif($campeonato['status'] == 3){ // TORNEIO CANCELADO
                                            ?>
                                                <h4>Torneio Cancelado</h4>
                                                pela organização.
                                            <?php	
                                            }else{
                                            ?>
                                                <h4>O torneio começa</h4>
                                                <?php echo date("d/m/Y - H:i", strtotime($campeonato['inicio'])); ?>
                                            <?php	
                                            }					
                                        }
                                    }else{ // Inscrições em breve...
                                    ?>
                                        <h4>Inscrições Em Breve...</h4>
                                        ...abrem <?php echo date("d/m/Y - H:i", strtotime($campeonato['inicio_inscricao'])); ?>
                                    <?php
                                    }
                                ?>
                                </div>
                                <div class="col-4 col-md-4">
                                    <div class="atual">
                                    <?php
                                        $inscricoesPendentes = mysqli_num_rows(mysqli_query($conexao, "SELECT cod_jogador FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 0 "));
                                        $inscricoesConfirmadas = mysqli_num_rows(mysqli_query($conexao, "SELECT cod_jogador FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 1 "));
                                        $totalInscricoes = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_equipe is null AND status != 2"));
                                        echo $totalInscricoes;
                                    ?>
                                    </div>
                                    <div class="max">
                                        <?php echo $campeonato['vagas']; ?>
                                    </div>
                                    <div class="tipo">
                                    <?php
                                        if($campeonato['tipo_inscricao'] == 0){
                                            echo "jogadores";
                                        }else{
                                            echo "times";
                                        }
                                    ?>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12"> 
                                <br>
                                <?php
                                    if(isset($usuario['codigo'])){
                                        $verificarInscricao = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$usuario['codigo']."");
                                        if(mysqli_num_rows($verificarInscricao) != 0){ // JÁ REALIZOU INSCRIÇÃO
                                            if($campeonato['precheckin'] != 0){
                                                $checkin = date("Y-m-d H:i:s", strtotime("-".$campeonato['precheckin']."minutes", strtotime($campeonato['inicio'])));
                                            }else{
                                                $checkin = date("Y-m-d H:i:s", strtotime($campeonato['inicio']));
                                            }
                                            $wo = date("Y-m-d H:i:s", strtotime($campeonato['inicio']));
                                            if($datahora < $checkin){ // MOSTRAR CONTADOR
                                            ?>
                                                <div class="clock" id="clock"></div>
                                            <?php		
                                            }else{

                                                $inscricao = mysqli_fetch_array($verificarInscricao);
                                                if($datahora < $wo){									
                                                    if($inscricao['status'] == 0){
                                                    ?>
                                                        <input type="button" value="REALIZAR CHECK-IN" onClick="realizarCheckin(<?php echo $campeonato['codigo'].",".$usuario['codigo']; ?>);">
                                                    <?php	
                                                    }else{
                                                    ?>
                                                        <div class="barraAviso">
                                                            INSCRIÇÃO CONFIRMADA
                                                        </div>
                                                    <?php
                                                    }								
                                                }else{
                                                    if($inscricao['status'] == 0){
                                                    ?>
                                                        <div class="barraAviso">
                                                            DESCLASSIFICADO
                                                        </div>
                                                    <?php		
                                                    }else{
                                                    ?>
                                                        <div class="barraAviso">
                                                            INSCRIÇÃO CONFIRMADA
                                                        </div>
                                                    <?php	
                                                    }								
                                                }
                                            }						
                                        }else{ // MOSTRAR BOTÃO INSCREVER-SE
                                            if($datahora > $campeonato['inicio_inscricao'] && $datahora < $campeonato['fim_inscricao'] && $campeonato['status'] == 0){
                                            ?>
                                                <a href="ptbr/campeonato/<?php echo $campeonato['codigo']; ?>/inscricao/">
                                                    <input type="button" value="Inscreva-se">
                                                </a>						
                                            <?php	
                                            }

                                        }
                                    }else{ // MOSTRAR BOTÃO DE LOGIN
                                    ?>
                                        <div class="barraAviso">
                                            REALIZE O LOGIN PARA INSCREVER-SE
                                        </div>
                                    <?php
                                    }

                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ul class="menuCampeonato">
            <div class="container">
                <a href="ptbr/campeonato/<?php echo $campeonato['codigo']; ?>/"><li class="informacoes">Informações</li></a>
                <a href="ptbr/campeonato/<?php echo $campeonato['codigo']; ?>/inscricao/"><li class="inscricao">Inscrição</li></a>
                <a href="ptbr/campeonato/<?php echo $campeonato['codigo']; ?>/participantes/"><li class="participantes">Participantes</li></a>
                <a href="ptbr/campeonato/<?php echo $campeonato['codigo']; ?>/etapas/"><li class="tabelas">Tabelas / Partidas</li></a>
                <a href="ptbr/campeonato/<?php echo $campeonato['codigo']; ?>/premiados/"><li class="premiados">Premiados</li></a>
            </div>
        </ul>

        <script>
            function realizarCheckin(campeonato, jogador){
                $.ajax({
                    type: "POST",
                    url: "scripts/realizar-checkin-campeonato.php",
                    data: "campeonato="+campeonato+"&jogador="+jogador,
                    success: function(resposta){
                        location.reload();
                    }
                })
            }
        </script>
    <?php
    }
?>
