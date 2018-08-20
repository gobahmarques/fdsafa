<?php
	function pontosCorridos($grupo, $etapa, $campeonato){
		include "../../conexao-banco.php";
	?>
        <div class="col-12 col-md-12">
            <div class="titulogrupo">
                <?php echo $grupo['nome']; ?>
            </div>
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
                                    <td><?php echo $totalPartidasConcluidas."/".$totalPartidas; ?></td>
                                    <td><?php echo $seed['vitorias']; ?></td>
                                    <td><?php echo $seed['derrotas']; ?></td>
                                    <td><?php echo $seed['partidas_pro']; ?></td>
                                    <td><?php echo $seed['partidas_contra']; ?></td>
                                    <td><?php echo $seed['partidas_pro'] - $seed['partidas_contra']; ?></td>
                                    <td>
                                    <?php 
                                        if($totalPartidasConcluidas != 0){
                                            echo (($seed['vitorias'] / $totalPartidasConcluidas)*100)." %"; 
                                        }else{
                                            echo "---";
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
                                    <td class="nome"><a href="ptbr/usuario/<?php echo $inscricao['cod_jogador']; ?>/"><?php echo $inscricao['conta']; ?></a></td>								
                                    <td><?php echo $totalPartidasConcluidas."/".$totalPartidas; ?></td>
                                    <td><?php echo $seed['vitorias']; ?></td>
                                    <td><?php echo $seed['derrotas']; ?></td>
                                    <td><?php echo $seed['partidas_pro']; ?></td>
                                    <td><?php echo $seed['partidas_contra']; ?></td>
                                    <td><?php echo $seed['partidas_pro'] - $seed['partidas_contra']; ?></td>
                                    <td>
                                    <?php 
                                        if($totalPartidasConcluidas != 0){
                                            echo number_format((($seed['vitorias'] / $totalPartidasConcluidas)*100), 2, '.', '')." %"; 
                                        }else{
                                            echo "---";
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
                                <td>TBD</td>
                                <td>---</td>
                                <td></td>
                            </tr>
                        <?php
                        }					
                    }
                ?>
            </table>
        </div>
		
		<div class="col-12 col-md-12 grupoPartidasGrupo">
            <div class="row">
                <div class="col-12 col-md-12">
                    <h2>Partidas Pendentes</h2>
                </div>                
                <?php
                $partidasPendentes = mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_grupo = ".$grupo['codigo']." AND status = 1");
                if(mysqli_num_rows($partidasPendentes) != 0){
                    while($partida = mysqli_fetch_array($partidasPendentes)){
                        $sementeUm = mysqli_fetch_array(mysqli_query($conexao, "
                            SELECT * FROM campeonato_partida_semente
                            INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
                            WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 1
                        "));
                        $sementeDois = mysqli_fetch_array(mysqli_query($conexao, "
                            SELECT * FROM campeonato_partida_semente
                            INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
                            WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 2
                        "));
                        if($sementeUm['cod_jogador'] != NULL && $sementeDois['cod_jogador'] != NULL){
                        ?>
                            <div class="col-6 col-md-3">
                                <a href="<?php echo "ptbr/campeonato/".$campeonato['codigo']."/partida/".$partida['codigo']."/"; ?>">
                                    <div class="partidaGrupo">
                                        <div class="row">

                                            <?php
                                                if($sementeUm['cod_equipe'] == NULL){ // PARTIDA ENTRE JOGADORES
                                                    if($sementeUm['cod_jogador'] != NULL){
                                                        $inscUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$sementeUm['cod_jogador']." "));
                                                        ?>
                                                            <div class="col-12 col-md-12">
                                                                <?php echo $inscUm['conta']; ?>           
                                                            </div>
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <div class="col-12 col-md-12">
                                                                À definir         
                                                            </div>
                                                        <?php
                                                    }

                                                    if($sementeDois['cod_jogador'] != NULL){
                                                        $inscDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$sementeDois['cod_jogador']." "));
                                                        ?>
                                                            <div class="col-12 col-md-12">
                                                                <?php echo $inscDois['conta']; ?>           
                                                            </div>
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <div class="col-12 col-md-12">
                                                                À definir         
                                                            </div>
                                                        <?php
                                                    }				
                                                }else{ // PARTIDA ENTRE EQUIPES
                                                    if($sementeUm['cod_equipe'] != NULL){
                                                        $inscUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$sementeUm['cod_equipe'].""));
                                                        ?>
                                                            <div class="col-12 col-md-12">
                                                                <?php echo $inscUm['nome']; ?>           
                                                            </div>
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <div class="col-12 col-md-12">
                                                                À definir        
                                                            </div>
                                                        <?php
                                                    }

                                                    if($sementeDois['cod_equipe'] != NULL){
                                                        $inscDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$sementeDois['cod_equipe'].""));
                                                        ?>
                                                            <div class="col-12 col-md-12">
                                                                <?php echo $inscDois['nome']; ?>           
                                                            </div>
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <div class="col-12 col-md-12">
                                                                À definir          
                                                            </div>
                                                        <?php
                                                    }	
                                                }
                                            ?>                                        
                                        </div>
                                    </div>
                                </a>   
                            </div>
                        <?php   
                        }                        
                    }	
                }				
            ?>
                
            </div>
        </div>


        <div class="col-12 col-md-12 grupoPartidasGrupo">
            <div class="row-fluid">
                <h2>Partidas Concluídas</h2>
                <?php
                    $partidasPendentes = mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_grupo = ".$grupo['codigo']." AND status = 2");
                    if(mysqli_num_rows($partidasPendentes) == 0){

                    }else{
                        while($partida = mysqli_fetch_array($partidasPendentes)){
                            $sementeUm = mysqli_fetch_array(mysqli_query($conexao, "
                                SELECT * FROM campeonato_partida_semente
                                INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
                                WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 1
                            "));
                            $sementeDois = mysqli_fetch_array(mysqli_query($conexao, "
                                SELECT * FROM campeonato_partida_semente
                                INNER JOIN campeonato_etapa_semente ON campeonato_etapa_semente.codigo = campeonato_partida_semente.cod_semente
                                WHERE campeonato_partida_semente.cod_partida = ".$partida['codigo']." AND lado = 2
                            "));
                            if($sementeUm['cod_equipe'] == NULL){ // PARTIDA ENTRE JOGADORES
                                $inscUm = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$sementeUm['cod_jogador']." "));
                                $inscDois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$sementeDois['cod_jogador']." "));
                                ?>
                                    <div class="col-6 col-md-3 float-left">
                                        <div class="partidaGrupo">
                                            <div class="row">
                                                <a href="<?php echo "ptbr/campeonato/".$campeonato['codigo']."/partida/".$partida['codigo']."/"; ?>">
                                                    <div class="col-10 col-md-10">
                                                        <?php echo $inscUm['conta']; ?>           
                                                    </div>
                                                    <div class="col-2 col-md-2">
                                                        <?php echo $partida['placar_um']; ?>
                                                    </div>
                                                    <div class="col-10 col-md-10">
                                                        <?php echo $inscDois['conta']; ?>           
                                                    </div>
                                                    <div class="col-2 col-md-2">
                                                        <?php echo $partida['placar_dois']; ?>
                                                    </div>
                                                </a>
                                            </div>	
                                        </div>                                        
                                    </div>
                                <?php
                            }else{ // PARTIDA ENTRE EQUIPES

                            }
                        }	
                    }				
                ?>
            </div>
        </div>
	<?php	
	}
?>


