<?php
	include_once("scripts.php");
	$sementeUm = mysqli_fetch_array(mysqli_query($conexao, "
		SELECT * FROM campeonato_partida_semente
		INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
		INNER JOIN jogador ON campeonato_etapa_semente.cod_jogador = jogador.codigo
		WHERE cod_partida = ".$partida['codigo']." AND lado = 1
	"));
	$sementeDois = mysqli_fetch_array(mysqli_query($conexao, "
		SELECT * FROM campeonato_partida_semente
		INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
		INNER JOIN jogador ON campeonato_etapa_semente.cod_jogador = jogador.codigo
		WHERE cod_partida = ".$partida['codigo']." AND lado = 2
	"));
	if($sementeUm['cod_jogador'] != NULL){
		$draftUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_draft WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$sementeUm['cod_jogador'].""));	
	}
	if($sementeDois['cod_jogador'] != NULL){
		$draftDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_draft WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$sementeDois['cod_jogador'].""));	
	}
?>

<div class="bgjogo bgjogo2 <?php echo $jogo['background']; ?>">
	<div class="container">
        <div class="infosJogadoresPartida centralizar">
            <div class="row-fluid">
                <div class="jogador jogadorUm <?php if($partida['status'] == 2){ if($partida['placar_um'] > $partida['placar_dois']){echo "vencedor";}} ?>">
            <?php
                if(isset($sementeUm)){				
                    if($sementeUm['cod_equipe'] == NULL){ // JOGADOR SOLO
                        $inscUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$sementeUm['codigo']." "));	
                        $checkinUm = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_partida_checkin WHERE cod_partida = ".$partida['codigo']." AND cod_jogador = ".$sementeUm['codigo'].""));
                        ?>
                            <div class="row centralizar">
                                <div class="col-3 col-md-3">
                                    <div class="placar">
                                        <?php echo $partida['placar_um']; ?>
                                    </div>                                        
                                </div>
                                <div class="col-6 col-md-6 conta">
                                    <?php echo $inscUm['conta'];  ?>                                       
                                </div>
                                <div class="col-3 col-md-3 d-none d-sm-block d-md-block no-gutters">
                                    <img src="http://www.esportscups.com.br/img/<?php echo $sementeUm['foto_perfil']; ?>" alt="" title="" class="<?php if($checkinUm != 0){ echo "checkin"; } ?>" id="<?php echo "img".$sementeUm['codigo']; ?>"> 
                                </div>
                            </div>


                        <?php
                    }else{ // EQUIPE
                        $inscUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$sementeUm['cod_equipe']." "));
                        $checkinUm = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_partida_checkin WHERE cod_partida = ".$partida['codigo']." AND cod_jogador = ".$sementeUm['codigo'].""));
                        ?>
                            <div class="row centralizar">
                                <div class="col-3 col-md-3">
                                    <div class="placar">
                                        <?php echo $partida['placar_um']; ?>
                                    </div>                                        
                                </div>
                                <div class="col col-md conta ">
                                    <?php echo $inscUm['nome'];  ?> 
                                </div> 
                                <div class="col-3 col-md-3 d-none d-sm-block d-md-block no-gutters">
                                    <img src='img/<?php echo $inscUm['logo']; ?>' alt='' title='' class="<?php if($checkinUm != 0){ echo "checkin"; } ?>">	
                                </div>
                            </div>
                        <?php
                    }		
                }else{
                    echo "A SER DEFINIDO";
                    echo "<img src='http://www.esportscups.com.br/img/usuarios/padrao.jpg' alt='' title=''>";
                }
            ?>
            </div>
            <div class="versus">
                VS
            </div>
            <div class="jogador jogadorDois <?php if($partida['status'] == 2){ if($partida['placar_um'] < $partida['placar_dois']){echo "vencedor";}} ?>">
            <?php
                if(isset($sementeDois)){
                    if($sementeDois['cod_equipe'] == NULL){ // JOGADOR SOLO
                        $inscDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$sementeDois['codigo']." "));
                        $checkinDois = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_partida_checkin WHERE cod_partida = ".$partida['codigo']." AND cod_jogador = ".$sementeDois['codigo'].""));
                        ?>
                            <div class="row centralizar">
                                <div class="col-3 col-md-3 d-none d-sm-block d-md-block no-gutters">
                                    <img src="http://www.esportscups.com.br/img/<?php echo $sementeDois['foto_perfil']; ?>" alt="" title="" class="<?php if($checkinDois != 0){ echo "checkin"; } ?>" id="<?php echo "img".$sementeDois['codigo']; ?>">
                                </div>
                                <div class="col col-md conta">
                                    <?php echo $inscDois['conta'];  ?>                                       
                                </div>                                
                                <div class="col-3 col-md-3">
                                    <div class="placar">
                                        <?php echo $partida['placar_dois']; ?>
                                    </div>                                        
                                </div>
                            </div>
                        <?php 
                        
                        ?>
                            
                        <?php
                    }else{ // EQUIPE
                        $inscDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$sementeDois['cod_equipe']." "));
                        $checkinDois = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_partida_checkin WHERE cod_partida = ".$partida['codigo']." AND cod_jogador = ".$sementeDois['codigo'].""));
                        ?>
                            <div class="row centralizar">
                                <div class="col-3 col-md-3 d-none d-sm-block d-md-block no-gutters">
                                    <img src='img/<?php echo $inscDois['logo']; ?>' alt='' title='' class="<?php if($checkinDois != 0){ echo "checkin"; } ?>">
                                </div>
                                <div class="col col-md conta">
                                    <?php echo $inscDois['nome'];  ?>                                     
                                </div>                                
                                <div class="col-3 col-md-3">
                                    <div class="placar">
                                        <?php echo $partida['placar_dois']; ?>
                                    </div>                                        
                                </div>
                            </div>
                        <?php
                    }	
                }else{
                    echo "<img src='http://www.esportscups.com.br/img/usuarios/padrao.jpg' alt='' title=''>";
                    echo "A SER DEFINIDO";				
                }
			?>
            </div>   
            </div>    
            
        </div>
        <div class="barraDrafts">
        <?php
			if($sementeUm['bans'] != NULL && $sementeDois['bans'] != NULL){
			?>
                <div class="draft draftUm">
                    <?php carregarDraft($draftUm['picks'], $sementeDois['bans'], $jogo['abreviacao'], $campeonato['qtd_pick']); ?>				
                </div>
                <div class="draft draftDois">
                    <?php carregarDraft($draftDois['picks'], $sementeUm['bans'], $jogo['abreviacao'], $campeonato['qtd_pick']); ?>				
                </div>
			<?php	
			}
		?>
        </div>
        <div class="infosPartida">
		<?php
			if($partida['datahora'] != NULL){
				echo date("d/m/Y - H:i", strtotime($partida['datahora']))."
					<strong><br>MD ".$partida['tipo']."</strong>
				";	
			}elseif($partida['datalimite'] != NULL){
				echo date("d/m/Y - H:i", strtotime($partida['datalimite']))."
					<strong><br>MD ".$partida['tipo']."</strong>
				";	
			}
			
		?>
		</div>
        <div class="row-fluid infosCamp centralizar align-items-center">
            <div class="col-12 col-md-5 float-left sobreCampeonato">
                <div class="row">
                    <div class="col-4 col-md-4">
                    <?php
                        if($campeonato['thumb'] != NULL){
                            echo "<img src='img/".$campeonato['thumb']."' title='' alt=''>";
                        }  
                    ?>
                    </div>
                    <div class="col-8 col-md-8">
                        <?php  echo "<br><h3>".$campeonato['nome']."</h3>"; ?>
                        ID Torneio: <?php echo $campeonato['codigo']; ?> / ID Partida: <?php echo $partida['codigo']; ?><br> Organizado por: <a href="<?php echo "organizacao/".$organizacao['codigo']."/"; ?>"><?php echo $organizacao['nome']; ?></a>
                    </div>
                </div>
            </div>
            <div class="col-md"></div>
            <div class="col-12 col-md-5 float-right text-right statusCampeonato">
                <div class="row">
                    <div class="col-8 col-md-8 texto cetralizar">
                    <?php
                        if($campeonato['status'] == 0){
                            $status = "INSCRIÇÕES ABERTAS";
                            $complemento = "até <strong>".date("d/m/Y - H:i", strtotime($campeonato['fim_inscricao']))."</strong>";
                        }elseif($campeonato['status'] == 1){
                            $status = "TORNEIO EM ANDAMENTO";
                            $complemento = "começou <strong>".date("d/m/Y - H:i", strtotime($campeonato['inicio']))."</strong>";
                        }else{
                            $status = "TORNEIO FINALIZADO";
                            $complemento = "obrigado a todos!";
                        }
                    ?>
                        <div class="titulo">
                            <?php echo $status; ?>
                        </div>
                        <div class="complemento">
                            <?php echo $complemento; ?>
                        </div>
                    </div>
                    <div class="col-4 col-md-4 botao">
                        <a href="<?php echo "ptbr/campeonato/".$campeonato['codigo']."/"; ?>"><input type="button" value="VER TORNEIO"></a>
                    </div>
                </div>
            
                
                <div class="status">
                    
                </div>			
            </div>
		</div>
	</div>
</div> 
