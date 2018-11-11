<?php
	include "../session.php";

	if(isset($_POST['aba'])){
		$aba = $_POST['aba'];
		if($aba == 0){
			$caixas = mysqli_query($conexao, "SELECT * FROM caixa WHERE cod_organizacao = 11 AND status = 1 ORDER BY chave_coin ASC");
		}else{
			$caixas = mysqli_query($conexao, "SELECT * FROM caixa WHERE cod_jogo = $aba AND status = 1 ORDER BY chave_coin ASC");
		}

		while($caixa = mysqli_fetch_array($caixas)){
		?>
				<a href="ptbr/caixas?caixa=<?php echo $caixa['codigo']; ?>">
					<div class="caixa col-6 col-md-4 centralizar">
                        <div>
                            <img src="img/caixas/<?php echo $caixa['codigo']; ?>.png" alt="">
                            <h3><?php echo $caixa['nome']; ?></h3>
                            <div class="valorCoin valor">
                            <?php
                                echo "e$ ".number_format($caixa['chave_coin'], 0, '', '.');
                            ?>		
                            </div>
                            <div class="valorReal valor">
                            <?php
                                echo "R$ ".number_format($caixa['chave_real'], 2, ',', '.');
                            ?>	
                            </div>
                        </div>
					</div>	
				</a>
		<?php
		}	
	}else{
		$caixa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM caixa WHERE codigo = ".$_POST['caixa'].""));
		$organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome FROM organizacao WHERE codigo = ".$caixa['cod_organizacao'].""));
		$autorizacao = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM caixa_autorizacao WHERE cod_caixa = ".$caixa['codigo']." "));
		?>
            <div class="row">      
                <div class="col-6 col-md-6">
                    <div class="infosCaixa centralizar">
                        <h2><?php echo $caixa['nome'] ; ?></h2>
                        <img src="img/caixas/<?php echo $caixa['codigo']; ?>.png" alt="" width="80%">
                    </div>
                </div>
                <div class="col-12 col-md-12 float-left">
                    <div class="row infosCaixa">
                        <div class="col-12 col-md-4 centralizar">
                            <img src="img/caixas/<?php echo $caixa['codigo']; ?>.png" alt="" width="80%">
                        </div>
                        <div class="col-12 col-md-8 centralizar">                            
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    
                                    <h2><?php echo $caixa['nome'] ; ?></h2>
                                </div>
                            </div>
                            
                                <div class="row valoresCaixa justify-content-center">
                                    <div class="col-12 col-md-4">
                                    <?php
                                        if(isset($usuario['codigo'])){
                                        ?>
                                            <input type="button" value="TESTAR A SORTE" class="btn btn-laranja btn-full" onClick="testarSorte(<?php echo $caixa['codigo']; ?>);">
                                        <?php	
                                        }else{
                                        ?>
                                            <input type="button" value="ENTRAR" class="btn btn-laranja btn-full float-left" onClick="abrirLogin();">
                                        <?php	
                                        }    
                                    ?>
                                    </div>
                                    <?php	
                                        if($caixa['status'] == 1 && $autorizacao != 0){
                                            if(isset($usuario['codigo'])){
                                                switch($caixa['categoria']){
                                                    case 1:
                                                        $limite = 3;
                                                        break;
                                                    case 2:
                                                        $limite = 3;
                                                        break;
                                                    case 3:
                                                        $limite = 5;
                                                        break;
                                                    case 4:
                                                        $limite = 7;
                                                        break;
                                                }
                                                $totalChaves = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM caixa_chave WHERE cod_jogador = ".$usuario['codigo']." AND categoria = ".$caixa['categoria']." AND datahora LIKE '%".date("Y-m-d")."%' AND coin_real = 'coin'"));
                                                ?>
                                                    <div class="col-12 col-md-4">
                                                <?php
                                                if($totalChaves < $limite){
                                                    $valorBotao = "e$ ".number_format($caixa['chave_coin'], 0, '', '.');
                                                ?>
                                                        <input type="button" value="<?php echo $valorBotao; ?>" class="btn btn-azul btn-full float-left" onClick="abrirCaixa(<?php echo $usuario['codigo']; ?>, <?php echo $caixa['codigo']; ?>, <?php echo 0; ?>);">
                                                <?php
                                                }else{
                                                ?>
                                                        <input type="button" value="Amanhã tem mais!" class="btn btn-azul btn-full float-left">
                                                <?php
                                                }
                                                ?>
                                                    </div>
                                                <?php
                                                switch($caixa['categoria']){
                                                    case 1:
                                                        $limite = 10;
                                                        break;
                                                    case 2:
                                                        $limite = 10;
                                                        break;
                                                    case 3:
                                                        $limite = 15;
                                                        break;
                                                    case 4:
                                                        $limite = 20;
                                                        break;
                                                }
                                                $totalChaves = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM caixa_chave WHERE cod_jogador = ".$usuario['codigo']." AND categoria = ".$caixa['categoria']." AND coin_real = 'real' AND datahora LIKE '%".date("Y-m-d")."%'"));
                                                ?>
                                                    <div class="col-12 col-md-4">
                                                <?php
                                                if($totalChaves < $limite){
                                                    $valorBotao = "R$ ".number_format($caixa['chave_real'], 2, ',', '.');
                                                ?>	
                                                        <input type="button" value="<?php echo $valorBotao; ?>" class="btn btn-dark btn-full float-left" onClick="abrirCaixa(<?php echo $usuario['codigo']; ?>, <?php echo $caixa['codigo']; ?>, 1);">
                                                <?php	
                                                }else{
                                                ?>		
                                                        <input type="button" value="Xii, por hoje é só." class="btn btn-dark btn-full float-left">
                                                <?php		
                                                }
                                                ?>
                                                    </div>
                                                <?php
                                            }						
                                        }
                                    ?> 
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-12 recompensa">
                                        <div class="row">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row dropsCaixa">
                        <?php
                            $itens = mysqli_query($conexao, "SELECT * FROM caixa_produto WHERE cod_caixa = ".$caixa['codigo']." ORDER BY recompensa DESC, chance_drop ASC");
                            while($item = mysqli_fetch_array($itens)){
                                if($item['chance_drop'] <= 0.10){ // LENDÁRIO
                                    $tipo = "lendario";
                                }else if($item['chance_drop'] <= 1){ // ÉPICO
                                    $tipo = "epico";
                                }else if($item['chance_drop'] <= 5){ // MÍTICO
                                    $tipo = "mitico";
                                }else if($item['chance_drop'] <= 10){ // SUPER RARO
                                    $tipo = "superraro";
                                }else if($item['chance_drop'] <= 20){ // RARO
                                    $tipo = "raro";
                                }else if($item['chance_drop'] <= 40){ // INCOMUM
                                    $tipo = "incomum";
                                }else{ // COMUM
                                    $tipo = "comum";
                                }
                            ?>
                                <div class="col-6 col-md-4">                                
                                    <div class="item <?php echo $tipo; ?> centralizar">
                                    <?php
                                        if($item['cod_produto'] != NULL){
                                            $produto = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome FROM produto WHERE codigo = ".$item['cod_produto']." "));
                                        ?>
                                            <img src="img/produtos/<?php echo $item['cod_produto']; ?>/foto.png" alt="">
                                        <?php
                                            echo "<h4>".$produto['nome']."</h4>";
                                        }else{
                                            if($item['recompensa'] < 100){
                                            ?>
                                                <img src="mg/caixas/coins/100.png" class="coin" alt="">
                                            <?php	
                                            }elseif($item['recompensa'] < 300){
                                            ?>
                                                <img src="img/caixas/coins/300.png" class="coin" alt="">
                                            <?php	
                                            }elseif($item['recompensa'] < 700){
                                            ?>
                                                <img src="img/caixas/coins/700.png" class="coin" alt="">
                                            <?php	
                                            }elseif($item['recompensa'] < 1500){
                                            ?>
                                                <img src="img/caixas/coins/1500.png" class="coin" alt="">
                                            <?php	
                                            }else{
                                            ?>
                                                <img src="img/caixas/coins/++.png" class="coin" alt="">
                                            <?php	
                                            }
                                        ?>

                                        <?php
                                            echo "<h3>e$ ".$item['recompensa']."</h3>";
                                        }
                                    ?>
                                    </div>
                                </div>
                            <?php					
                            }
                        ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 float-left centralizar">
                        <div class="ultimosDrops">
                            <h3>ULTIMOS DROPS</h3>
                            <?php
                                $drops = mysqli_query($conexao, "SELECT *, caixa_produto.recompensa AS valorProduto FROM caixa_chave
                                    INNER JOIN caixa_produto ON caixa_chave.recompensa = caixa_produto.codigo
                                    WHERE caixa_chave.cod_caixa = ".$caixa['codigo']."
                                    ORDER BY datahora DESC
                                    LIMIT 30
                                ");
                                while($drop = mysqli_fetch_array($drops)){
                                    $jogador = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome, sobrenome, nick FROM jogador WHERE codigo = ".$drop['cod_jogador']." "));
                                    if($drop['cod_produto'] == NULL){
                                        $recompensa = "e$ ".number_format($drop['valorProduto'],0,'','.');
                                    }else{
                                        $produtoDrop = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome FROM produto WHERE codigo = ".$drop['cod_produto'].""));
                                        $recompensa = $produtoDrop['nome'];
                                    }
                                    echo date("d/m H:i", strtotime($drop['datahora']))." - ".$jogador['nick']." - <strong>".$recompensa."</strong><br>";
                                }
                            ?>
                        </div>
                        
                    </div>
                </div>          
                
		<?php
	}
?>