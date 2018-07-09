<?php
    include "../../enderecos.php";
    include "../../session.php";
?>
<!doctype html>
<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.css">
        <link rel="stylesheet" href="<?php echo $css; ?>esportscups.css">

        <title>Rifas de eSports - Ajude o crescimento do cenário | e-Sports Cups</title>
    </head>
    <body>
        <?php 
            include "../header.php";        
            if(isset($_GET['codigo'])){
                $rifa2 = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM rifa WHERE codigo = ".$_GET['codigo']." "));	
                $pesquisaCupons = mysqli_query($conexao, "
                    SELECT rifa_cupom.*, jogador.nick, jogador.foto_perfil FROM rifa_cupom
                    INNER JOIN jogador ON jogador.codigo = rifa_cupom.cod_jogador
                    WHERE rifa_cupom.cod_rifa = ".$rifa2['codigo']."");
                $totalCupons = mysqli_num_rows($pesquisaCupons);
                ?>		
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        ...
                      </div>
                      <div class="modal-footer">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="visualizarRifa">
                    <br>
                    <div class="container centralizar">
                        <h1><strong><?php echo $rifa2['nome']; ?></strong></h1><br>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-12 col-md-4">
                                <img src="img/rifas/<?php echo $rifa2['codigo']."/".$rifa2['foto_produto']; ?>" alt="" width="100%" class="img-fluid">
                            </div>
                            <div class="col-12 col-md-7">
                                <div class="row text-white">
                                    <div class="col-12 col-md-6">
                                        <div class="bg-azul alert" role="alert">
                                            <strong>PRODUTO RIFADO</strong><br>
                                            <?php echo $rifa2['nome_produto']; ?>
                                        </div>
                                    </div>						
                                    <div class="col-12 col-md-6">
                                        <div class="bg-azul alert" role="alert">
                                            <strong>VALOR PRODUTO</strong><br>
                                            <?php echo "R$ ".number_format($rifa2['preco_produto'], 2, ',', '.'); ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6" data-toggle="tooltip" data-html="true" data-placement="bottom" title="O cupom vencedor será sorteado através do site: sorteador.com.br, será transmitido pelo Facebook da eSC e o link do resultado estará visível para todos aqui nesta página.">
                                        <div class="bg-azul alert" role="alert">
                                            <span class="glyphicon glyphicon-question-sign"></span> <strong>DATA & HORA SORTEIO</strong><br>
                                            <?php echo date("d/m/Y H:i", strtotime($rifa2['data_sorteio'])); ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="bg-azul alert" role="alert">
                                            <strong>VALOR DO CUPOM</strong><br>
                                            <?php
                                                if($rifa2['preco_coin'] > 0){
                                                    echo "e$ ".number_format($rifa2['preco_coin'], 0, '', '.'). " ou ";
                                                }
                                                echo "R$ ".number_format($rifa2['preco_real'], 2, ',', '.');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="progress-group">
                                            <span class="progress-number"><?php echo $totalCupons." / ".$rifa2['min_cupom']." / ".$rifa2['max_cupom']; ?></span>
                                            <div class="progress sm">
                                                <div class="progress-bar bg-laranja" role="progressbar" style="width: <?php echo ($totalCupons/$rifa2['max_cupom'])*100; ?>%;" aria-valuenow="<?php echo $totalCupons; ?>"><?php echo $totalCupons; ?></div>

                                                <div class="progress-bar bg-dark" role="progressbar" style="width: <?php echo (($rifa2['min_cupom']/$rifa2['max_cupom'])*100)-(($totalCupons/$rifa2['max_cupom'])*100); ?>%;" aria-valuenow="<?php echo $totalCupons; ?>">Mínimo Cupons</div>
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="clock clockrifa col-md-12" id="clock" style="background: none;"></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                            <?php
                                $contador = 1;
                                while($contador <= $rifa2['max_cupom']){
                                ?>
                                    <div class="cupomRifa cupom<?php echo $contador; ?>" data-placement="bottom" title="Comprar Cupom <?php echo $contador; ?>" data-toggle="modal" data-target="#exampleModal" onClick="selecionarCupom(<?php echo $contador; ?>);">
                                        <?php echo $contador; ?>
                                    </div>
                                <?php
                                    $contador++;
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            <?php
            }
        ?>
        
        <br>
        <div class="container">
        <?php
            $rifas = mysqli_query($conexao, "SELECT * FROM rifa WHERE data_sorteio > '".date("Y-m-d H:i:s")."' AND status = 1");
            if(mysqli_num_rows($rifas) > 0){
                while($rifa = mysqli_fetch_array($rifas)){
                    $totalCupons = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM rifa_cupom WHERE cod_rifa = ".$rifa['codigo'].""));
                    $porcentagem = ($totalCupons * 100) / $rifa['max_cupom'];
                ?>
                    <div class="col-6 col-md-3 centralizar" style="border:solid 1px #ccc; padding: 15px;">
                        <?php echo "<h3><strong>".$rifa['nome_produto']."</strong></h3>"; ?>
                        <img src="img/rifas/<?php echo $rifa['codigo']."/".$rifa['foto_produto']; ?>" alt="" width="100%">
                        <div class="progress-group">
                            <span class="progress-number"><?php echo $totalCupons." / ".$rifa['min_cupom']." / ".$rifa['max_cupom']; ?></span>
                            <div class="progress sm">
                                <div class="progress-bar bg-laranja" role="progressbar" style="width: <?php echo ($totalCupons/$rifa['max_cupom'])*100; ?>%;" aria-valuenow="<?php echo $totalCupons; ?>"><?php echo $totalCupons; ?></div>

                                <div class="progress-bar bg-azul" role="progressbar" style="width: <?php echo (($rifa['min_cupom']/$rifa['max_cupom'])*100)-(($totalCupons/$rifa['max_cupom'])*100); ?>%;" aria-valuenow="<?php echo $totalCupons; ?>"></div>
                            </div>
                        </div><br>
                        <a href="ptbr/rifas/?codigo=<?php echo $rifa['codigo']; ?>"><input type="button" class="btn btn-laranja" data-toggle="tooltip" data-placement="bottom" title="Preços" value="VISUALIZAR RIFA" style="width: 100%;"></input></a>		
                    </div>
                <?php
                }
            }else{
                echo "<h2>Nenhuma rifa disponível!</h2>";
            }
        ?>
        </div>
    
        <?php include "../footer.php"; ?>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script>
            function comprarCupom(numCupom, numRifa, codJogador, tipoPagamento){
                $.ajax({
                    type: "POST",
                    url: "scripts/rifas.php",
                    data: "funcao=comprarCupom&numCupom="+numCupom+"&numRifa="+numRifa+"&jogador="+codJogador+"&tipoPagamento="+tipoPagamento,
                    success: function(resultado){
                        if(resultado == 0){
                            $(".modal-body").html("Infelizmente você não possui saldo suficiente para comprar o cupom.");
                            $(".modal-footer").append("<button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>");
                        }else if(resultado == 1){
                            window.location.reload();
                        }
                    }
                });
            }
            function selecionarCupom(numCupom){
                <?php
                    if(isset($usuario['codigo'])){
                    ?>
                        $(".modal-title").html("<h3><?php echo $rifa2['nome']; ?></h3>");
                        $(".modal-body").html("Você está preste a comprar o <strong>CUPOM "+numCupom+"</strong>, selecione o tipo de pagamento para confirmar esta transação.<br><br>Seu cupom só será reembolsável, e 100%, somente quando o número mínimo de cupons não forem atingidos até a data e hora do sorteio, caso contrário, você não poderá a nenhum momento desistir do seu investimento.");
                        $(".modal-footer").html("");
                    <?php
                        if($rifa2['preco_coin'] > 0){
                        ?>
                            $(".modal-footer").append("<button type='button' class='btn btn-warning' onClick='comprarCupom("+numCupom+", <?php echo $rifa2['codigo']; ?>, <?php echo $usuario['codigo']; ?>, 0);'>e$ <?php echo number_format($rifa2['preco_coin'], 0, '', '.') ?></button>");
                        <?php
                        }

                        if($rifa2['preco_real'] > 0){
                        ?>
                            $(".modal-footer").append("<button type='button' class='btn btn-success' onClick='comprarCupom("+numCupom+", <?php echo $rifa2['codigo']; ?>, <?php echo $usuario['codigo']; ?>, 1);'>R$ <?php echo number_format($rifa2['preco_real'], 2, ',', '.') ?></button>");
                        <?php
                        }
                    }else{
                    ?>
                        $(".modal-title").html("<h3><?php echo $rifa['nome']; ?></h3>");
                        $(".modal-body").html("É necessário que você realize o login para que possa comprar seus cupons.");
                        $(".modal-footer").html("");
                    <?php	
                    }
                ?>
                $(".modal-footer").append("<button type='button' class='btn btn-secondary' data-dismiss='modal'>Pensar mais um pouco!</button>");
            }
            $(function () {		  
                <?php
                    if(isset($_GET['codigo'])){
                        while($cupom = mysqli_fetch_array($pesquisaCupons)){
                        ?>
                            $(".cupom<?php echo $cupom['codigo']; ?>").html("<?php echo $cupom['codigo']; ?>");
                            $(".cupom<?php echo $cupom['codigo']; ?>").css("background", "url('img/<?php echo $cupom['foto_perfil']; ?>')");
                            $(".cupom<?php echo $cupom['codigo']; ?>").css("border", "none");
                            $(".cupom<?php echo $cupom['codigo']; ?>").css("line-height", "50px");
                            $(".cupom<?php echo $cupom['codigo']; ?>").removeAttr("data-toggle");
                            $(".cupom<?php echo $cupom['codigo']; ?>").removeAttr("data-placemente");
                            $(".cupom<?php echo $cupom['codigo']; ?>").attr("title", "<?php echo $cupom['nick']; ?>");
                            $(".cupom<?php echo $cupom['codigo']; ?>").css("background-size", "100% 100%");
                        <?php
                        }
                        ?>
                        $('[data-toggle="tooltip"]').tooltip();
                        <?php
                        $dataFinal = date("Y-m-d H:i:s", strtotime($rifa2['data_sorteio']));			
                        ?>
                        var ano = <?php echo date("Y",strtotime($dataFinal)); ?>;
                        var mes = <?php echo date("m",strtotime($dataFinal)); ?>;
                        var dia = <?php echo date("d",strtotime($dataFinal)); ?>;
                        var hora = <?php echo date("H",strtotime($dataFinal)); ?>;
                        var minuto = <?php echo date("i",strtotime($dataFinal)); ?>;
                        var segundo = <?php echo date("s",strtotime($dataFinal)); ?>;
                        var dataFinal = new Date(ano, mes-1, dia, hora, minuto, segundo, 0);
                        $("#clock").countdown({until: dataFinal, format:'DHMS'});
                    <?php
                    }
                ?>		 							
            })
        </script>
    </body>
</html>