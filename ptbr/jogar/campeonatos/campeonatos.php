<?php
    include "../../../enderecos.php";
    include "../../../session.php";

    if(isset($_GET['jogo'])){
        $codJogo = $_GET['jogo'];
        $jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogos WHERE codigo = $codJogo"));
    }else{
        $codJogo = 0;
    }
    
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

        <title>Disputar partidas de Dota 2, Hearthstone, GWENT, League of Legends, Overwatch ou Clash Royale | e-Sports Cups</title>
    </head>
    <body>
        <?php include "../../header.php"; ?>
        <?php
            if($codJogo != 0){ // JÁ SELECIONOU O JOGO
            ?>
                <ul class="menuJogar centralizar">
                    <a href="ptbr/jogar/campeonatos/dota2/"><li class="357"><img src="<?php echo $img; ?>icones/dota2.png"></li></a>
                    <a href="ptbr/jogar/campeonatos/gwent/"><li class="123"><img src="<?php echo $img; ?>icones/gwent.png"></li></a>
                    <a href="ptbr/jogar/campeonatos/hearthstone/"><li class="369"><img src="<?php echo $img; ?>icones/hs.png"></li></a>
                    <a href="ptbr/jogar/campeonatos/lol/"><li class="147"><img src="<?php echo $img; ?>icones/lol.png"></li></a>
                    <a href="ptbr/jogar/campeonatos/overwatch/"><li class="258"><img src="<?php echo $img; ?>icones/overwatch2.png"></li></a>
                </ul>
        
                <div class="container">
                    <div class="carregarConteudo centralizar">

                    </div>           
                </div>
            <?php   
            }else{ // AINDA NÃO SELECIONOU O JOGO
            ?>
                <div class="container">
                    <div class="row centralizar">
                        <div class="col">
                            <br>
                            <h2>Dispute Campeonatos de Esportes Eletrônicos</h2>
                            Escolha um dos jogos abaixo para saber os campeonatos que estão rolando, vão rolar ou já rolaram
                        </div>
                        
                    </div>
                    <div class="row barraJogosIndex">
                        <div class="col-xs-12-fluid col-md-12">
                            <h2 class="tituloIndex">Jogos <strong>Disponíveis</strong></h2>
                            <div class="detalheTituloIndex"></div>                    
                        </div>
                        <div class="col-4 col-md-2 jogo">
                            <a href="ptbr/jogar/campeonatos/dota2/"><img src="<?php echo $img; ?>index/dota2.png"></a>
                        </div>
                        <div class="col-4 col-md-2 jogo">
                            <a href="ptbr/jogar/campeonatos/gwent/"><img src="<?php echo $img; ?>index/gwent.png" style="width: 100%;"></a>
                        </div>
                        <div class="col-4 col-md-2 jogo">
                            <a href="ptbr/jogar/campeonatos/hearthstone/"><img src="<?php echo $img; ?>index/hearthstone.png" style="width: 100%;"></a>
                        </div>
                        <div class="col-4 col-md-2 jogo">
                            <a href="ptbr/jogar/campeonatos/lol/"><img src="<?php echo $img; ?>index/lol.png" style="width: 100%;"></a>
                        </div>
                        <div class="col-4 col-md-2 jogo">
                            <a href="ptbr/jogar/campeonatos/overwatch/"><img src="<?php echo $img; ?>index/overwatch.png" style="width: 100%;"></a>
                        </div>
                        <div class="col-4 col-md-2">
                            <img src="<?php echo $img; ?>index/clashroyale2.png" style="width: 100%;">
                        </div>
                    </div>
                </div>
            <?php
            }
        ?>
        
        <?php include "../../footer.php"; ?>
        
        

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script>
            function trocarAba2(numero){
                $(".cupsDestaques").removeClass("ativo");
                $(".cupsPassados").removeClass("ativo");
                $(".cupsAbertos").removeClass("ativo");
                $(".cupsAndamento").removeClass("ativo");
                $(".cupsBreve").removeClass("ativo");
                switch(numero){
                    case 1: // DESTAQUES
                        $.ajax({
                            type: "POST",
                            url: "scripts/carregar-torneios.php",
                            data: "codjogo=<?php echo $codJogo; ?>&funcao="+numero,
                            success: function(resultado){
                                $(".carregarConteudo").html(resultado);
                                $(".cupsDestaques").addClass("ativo");
                                return false;
                            }
                        });
                        break;
                    case 2: // PASSADOS
                        $.ajax({
                            type: "POST",
                            url: "scripts/carregar-torneios.php",
                            data: "codjogo=<?php echo $codJogo; ?>&funcao="+numero,
                            success: function(resultado){
                                $(".carregarConteudo").html(resultado);
                                $(".cupsPassados").addClass("ativo");
                                return false;
                            }
                        });
                        break;
                    case 3: // INSCRIÇÕES ABERTAS
                        $.ajax({
                            type: "POST",
                            url: "scripts/carregar-torneios.php",
                            data: "codjogo=<?php echo $codJogo; ?>&funcao="+numero,
                            success: function(resultado){
                                $(".carregarConteudo").html(resultado);
                                $(".cupsAbertos").addClass("ativo");
                                return false;
                            }
                        });
                        break;
                    case 4: // EM ANDAMENTO
                        $.ajax({
                            type: "POST",
                            url: "scripts/carregar-torneios.php",
                            data: "codjogo=<?php echo $codJogo; ?>&funcao="+numero,
                            success: function(resultado){
                                $(".carregarConteudo").html(resultado);
                                $(".cupsAndamento").addClass("ativo");
                                return false;
                            }
                        });
                        break;
                    case 5: // EM BREVE
                        $.ajax({
                            type: "POST",
                            url: "scripts/carregar-torneios.php",
                            data: "codjogo=<?php echo $codJogo; ?>&funcao="+numero,
                            success: function(resultado){
                                $(".carregarConteudo").html(resultado);
                                $(".cupsBreve").addClass("ativo");
                                return false;
                            }
                        });
                        break;
                }
            }
            function carregarTorneios(){
                $(".<?php echo $codJogo; ?>").addClass("ativo");
                $.ajax({
                    type: "POST",
                    url: "scripts/carregar-torneios.php",
                    data: "codjogo=<?php echo $codJogo; ?>",
                    success: function(resultado){
                        $(".carregarConteudo").html(resultado);
                        trocarAba2(1);
                        return false;
                    }
                });
            }
            function encaminhar(link){
                window.location.href = link;
            }
            jQuery(function($){
                carregarTorneios();
                $(".menuPrincipalHeader .campeonatos").addClass("ativo");
            });
        </script>
    </body>
</html>