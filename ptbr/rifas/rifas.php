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
        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '2173345296319711');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=2173345296319711&ev=PageView&noscript=1" />
        </noscript>
        <!-- End Facebook Pixel Code -->

    </head>
    <body class="bodyRifa">
        <?php 
            include "../header.php";        
            if(isset($_GET['codigo'])){     
                $rifa2 = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM rifa WHERE codigo = ".$_GET['codigo']." "));
                $countdown1 = date("M", strtotime($rifa2['data_sorteio']));
                $countdown2 = date("j", strtotime($rifa2['data_sorteio']));
                $countdown3 = date("Y", strtotime($rifa2['data_sorteio']));
                $countdown4 = date("H", strtotime($rifa2['data_sorteio']));
                $countdown5 = date("i", strtotime($rifa2['data_sorteio']));
                $countdown6 = date("s", strtotime($rifa2['data_sorteio']));
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
                                <?php
                                    if($rifa2['link_produto'] != ""){
                                    ?>
                                        <a href="<?php echo $rifa2['link_produto']; ?>" target="_blank">
                                            <img src="img/rifas/<?php echo $rifa2['codigo']."/".$rifa2['foto_produto']; ?>" alt="" width="100%" class="img-fluid">
                                        </a>
                                    <?php
                                    }
                                ?>
                                
                            </div>
                            <div class="col-12 col-md-7">
                                <div class="row text-white">
                                    <div class="col-12 col-md-6">
                                        <div class="bg-azul alert" role="alert">
                                            <strong>PRODUTO RIFADO</strong><br>
                                            <a href="<?php echo $rifa2['link_produto']; ?>" target="_blank"><?php echo $rifa2['nome_produto']; ?></a>
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
                                        <div class="bg-azul alert" role="alert" data-toggle="tooltip" data-placement="bottom" title="Toda a quantia arrecadada com cupons serão destinadas exclusivamente à organização de Torneios com premiações para os demais jogos disponíveis na plataforma.">
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
                                if($rifa2['status'] == 1 && date('Y-m-d H:i:s') < strtotime($rifa2['data_sorteio'])){
                                    $contador = 1;
                                    while($contador <= $rifa2['max_cupom']){
                                    ?>
                                        <div class="cupomRifa cupom<?php echo $contador; ?>" data-placement="bottom" title="Comprar Cupom <?php echo $contador; ?>" data-toggle="modal" data-target="#exampleModal" onClick="selecionarCupom(<?php echo $contador; ?>);">
                                            <?php echo $contador; ?>
                                        </div>
                                    <?php
                                        $contador++;
                                    }   
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
            <div class="row justify-content-center">.
                <div class="col-12 centralizar">
                    <h2>Colabore com o crescimento do Esporte Eletrônico</h2>
                    Toda quantia arrecadada por estas ações serão destinadas à premiação de alguma competição realizada pela e-Sports Cups.<br>
                    Cada mês rodam novos produtos e cada mês será para premiação em um torneio diferente.<br><br>
                    Dia e Hora do Sorteio:<br>
                    <span class="h1">31/10/2018 - 16:00</span><br>
                    <a href="https://www.facebook.com/escups/" target="_blank">Facebook eSports Cups</a><br><br>
                </div>
            <?php
                $rifas = mysqli_query($conexao, "SELECT * FROM rifa WHERE data_sorteio > '".date("Y-m-d H:i:s")."' AND status = 1");
                if(mysqli_num_rows($rifas) > 0){
                    while($rifa = mysqli_fetch_array($rifas)){
                        $totalCupons = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM rifa_cupom WHERE cod_rifa = ".$rifa['codigo'].""));
                        $porcentagem = ($totalCupons * 100) / $rifa['max_cupom'];
                    ?>
                        <div class="col-6 col-md-3 centralizar rifa">
                            <div style="border:solid 1px #ccc; padding: 15px; background: #fff;">
                                <div class="row">
                                    <div class="col-12">
                                        <span class="h3"><?php echo $rifa['nome']; ?></span>
                                    </div>
                                    <div class="col-12">
                                        <img src="img/rifas/<?php echo $rifa['codigo']."/".$rifa['foto_produto']; ?>" alt="" width="100%">
                                    </div>
                                    <div class="col-12">
                                        <!--
                                        <div class="progress-group">
                                            <span class="progress-number"><?php echo $totalCupons." / ".$rifa['min_cupom']." / ".$rifa['max_cupom']; ?></span>
                                            <div class="progress sm">
                                                <div class="progress-bar bg-laranja" role="progressbar" style="width: <?php echo ($totalCupons/$rifa['max_cupom'])*100; ?>%;" aria-valuenow="<?php echo $totalCupons; ?>"><?php echo $totalCupons; ?></div>

                                                <div class="progress-bar bg-azul" role="progressbar" style="width: <?php echo (($rifa['min_cupom']/$rifa['max_cupom'])*100)-(($totalCupons/$rifa['max_cupom'])*100); ?>%;" aria-valuenow="<?php echo $totalCupons; ?>"></div>
                                            </div>
                                        </div>
                                        -->
                                    </div>
                                </div>
                                <br>
                                <a href="ptbr/rifas/?codigo=<?php echo $rifa['codigo']; ?>"><input type="button" class="btn btn-dark" data-toggle="tooltip" data-placement="bottom" title="Preços" value="VISUALIZAR RIFA" style="width: 100%;"></a>	
                            </div>                          	
                        </div>
                    <?php
                    }
                }else{
                    echo "<h2>Nenhuma rifa disponível!</h2>";
                }
            ?>
            </div>        
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
                            $(".modal-footer").html("<a href='ptbr/usuario/"+codJogador+"/carteira-real/adicionar-saldo/'><button type='button' class='btn btn-warning'>Adicionar Saldo</button></a>");
                        }else if(resultado == 1){
                            window.location.href = "ptbr/rifas/confirmar-compra/"+numRifa+"/";
                        }
                    }
                });
            }
            function selecionarCupom(numCupom){
                $(".modal-title").html("<h3><?php echo $rifa['nome']; ?></h3>");
                $(".modal-body").html("É necessário que você realize o login para que possa comprar seus cupons.");
                $(".modal-footer").html("<input type='button' value='Realizar Login' class='btn btn-warning' onClick='abrirLogin();'>");
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
                            $(".modal-footer").append("<button type='button' class='btn btn-success' onClick='comprarCupom("+numCupom+", <?php echo $rifa2['codigo']; ?>, <?php echo $usuario['codigo']; ?>, 1);'>CUPOM <strong>R$ <?php echo number_format($rifa2['preco_real'], 2, ',', '.') ?></strong></button>");
                        <?php
                        }
                    }
                ?>
            }
            // Set the date we're counting down to
            var countDownDate = new Date("<?php echo $countdown1." ".$countdown2.", ".$countdown3." ".$countdown4.":".$countdown5.":".$countdown6; ?>").getTime();

            // Update the count down every 1 second
            var x = setInterval(function() {

                // Get todays date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result in the element with id="demo"
                $("#clock").html("<div class='row h4 mt-2'><div class='col-3'>" +days + "<br>dias </div><div class='col-3'> " + hours + "<br>horas </div><div class='col-3'>" + minutes + "<br>minutos </div><div class='col-3'>" + seconds + "<br>segundos </div></div> ");

                // If the count down is finished, write some text 
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("clock").innerHTML = "EXPIRED";
                }
            }, 1000);
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