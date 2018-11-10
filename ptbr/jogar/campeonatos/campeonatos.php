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
                <input type="hidden" name="filtro" value="0" class="filtro">
                <input type="hidden" name="qtdexibir" value="10" class="qtdexibir">
                
        
                <div class="container mt-5">
                    <div class="row">
                        <div class="carregarConteudo col-9">

                        </div> 
                        <div class="col-3">
                            <h2 class="tituloLateral">Filtre sua <strong>Busca</strong></h2>
                            <div class="detalheTituloLateral"></div>
                            <ul class="menuJogar centralizar">
                                <a href="ptbr/jogar/campeonatos/dota2/"><li class="357"><img src="<?php echo $img; ?>icones/dota2.png"></li></a>
                                <a href="ptbr/jogar/campeonatos/gwent/"><li class="123"><img src="<?php echo $img; ?>icones/gwent.png"></li></a>
                                <a href="ptbr/jogar/campeonatos/hearthstone/"><li class="369"><img src="<?php echo $img; ?>icones/hs.png"></li></a>
                                <a href="ptbr/jogar/campeonatos/lol/"><li class="147"><img src="<?php echo $img; ?>icones/lol.png"></li></a>
                                <a href="ptbr/jogar/campeonatos/overwatch/"><li class="258"><img src="<?php echo $img; ?>icones/overwatch2.png"></li></a>
                            </ul>
                            <div class="bg-light border border-secondary p-2 centralizar">
                                Crie ou Jogue em <strong>Partidas Personalizadas</strong> nos Lobbys da e-SPorts Cups <br>
                                <a href="ptbr/jogar/lobbys/<?php echo $jogo['background']; ?>/"><input type="button" class="btn btn-dark form-control mt-2" value="IR PARA LOBBYS"></a>
                            </div>
                            <br>
                            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                            <!-- Barra lateral página de Artigo -->
                            <ins class="adsbygoogle"
                                 style="display:block"
                                 data-ad-client="ca-pub-3038725769937948"
                                 data-ad-slot="7294511218"
                                 data-ad-format="auto"></ins>
                            <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                            </script>
                            
                        </div> 
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
                $(".cupsTodos").removeClass("ativo");
                $(".cupsDestaques").removeClass("ativo");
                $(".cupsPassados").removeClass("ativo");
                $(".cupsAbertos").removeClass("ativo");
                $(".cupsAndamento").removeClass("ativo");
                $(".cupsBreve").removeClass("ativo");
                $(".exibir10").removeClass("ativo");
                $(".exibir20").removeClass("ativo");
                $(".exibir50").removeClass("ativo");
                $(".exibir100").removeClass("ativo");
                $(".exibirtodos").removeClass("ativo");
                setTimeout(function(){
                    var qtdexibir = $(".qtdexibir").val();
                    switch(numero){
                        case '0': // TODOS
                            $(".filtro").val(0);
                            $.ajax({
                                type: "POST",
                                url: "scripts/carregar-torneios.php",
                                data: "codjogo=<?php echo $codJogo; ?>&funcao="+numero+"&qtdexibir="+qtdexibir,
                                success: function(resultado){
                                    $(".carregarConteudo").html(resultado);
                                    $(".cupsTodos").addClass("ativo");
                                    return false;
                                }
                            });
                            break;
                        case '1': // DESTAQUES
                            $(".filtro").val(1);
                            $.ajax({
                                type: "POST",
                                url: "scripts/carregar-torneios.php",
                                data: "codjogo=<?php echo $codJogo; ?>&funcao="+numero+"&qtdexibir="+qtdexibir,
                                success: function(resultado){
                                    $(".carregarConteudo").html(resultado);
                                    $(".cupsDestaques").addClass("ativo");
                                    return false;
                                }
                            });
                            break;
                        case '2': // PASSADOS
                            $(".filtro").val(2);
                            $.ajax({
                                type: "POST",
                                url: "scripts/carregar-torneios.php",
                                data: "codjogo=<?php echo $codJogo; ?>&funcao="+numero+"&qtdexibir="+qtdexibir,
                                success: function(resultado){
                                    $(".carregarConteudo").html(resultado);
                                    $(".cupsPassados").addClass("ativo");
                                    return false;
                                }
                            });
                            break;
                        case '3': // INSCRIÇÕES ABERTAS
                            $(".filtro").val(3);
                            $.ajax({
                                type: "POST",
                                url: "scripts/carregar-torneios.php",
                                data: "codjogo=<?php echo $codJogo; ?>&funcao="+numero+"&qtdexibir="+qtdexibir,
                                success: function(resultado){
                                    $(".carregarConteudo").html(resultado);
                                    $(".cupsAbertos").addClass("ativo");
                                    return false;
                                }
                            });
                            break;
                        case '4': // EM ANDAMENTO
                            $(".filtro").val(4);
                            $.ajax({
                                type: "POST",
                                url: "scripts/carregar-torneios.php",
                                data: "codjogo=<?php echo $codJogo; ?>&funcao="+numero+"&qtdexibir="+qtdexibir,
                                success: function(resultado){
                                    $(".carregarConteudo").html(resultado);
                                    $(".cupsAndamento").addClass("ativo");
                                    return false;
                                }
                            });
                            break;
                        case '5': // EM BREVE
                            $(".filtro").val(5);
                            $.ajax({
                                type: "POST",
                                url: "scripts/carregar-torneios.php",
                                data: "codjogo=<?php echo $codJogo; ?>&funcao="+numero+"&qtdexibir="+qtdexibir,
                                success: function(resultado){
                                    $(".carregarConteudo").html(resultado);
                                    $(".cupsBreve").addClass("ativo");
                                    return false;
                                }
                            });
                            break;
                    }
                    $(".exibir20").addClass("ativo");
                }, 500);
            }
            function carregarTorneios(){
                $(".<?php echo $codJogo; ?>").addClass("ativo");
                trocarAba2('1');
            }
            function qtdexibir(qtd){
                $(".qtdexibir").val(qtd);
                var filtro = $(".filtro").val();
                trocarAba2(filtro);
            }
            function encaminhar(link){
                window.location.href = link;
            }
            jQuery(function($){
                carregarTorneios();
                qtdexibir(10);
                $(".menuPrincipalHeader .campeonatos").addClass("ativo");
            });
        </script>
    </body>
</html>