<?php
    include "../../session.php";
    include "../../enderecos.php";
    
    if(isset($_GET['caixa'])){
		$codCaixa = $_GET['caixa'];
	}else{
		$codCaixa = 0;
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

        <title>Caixas eSports | e-Sports Cups</title>
    </head>
    <body>
        <?php include "../header.php"; ?>
        
        <ul class="menuJogar centralizar">
            <li onClick="trocarAba(0);" class="esc"><img src="<?php echo $img; ?>logo.png"></li>
            <li onClick="trocarAba(357);" class="357"><img src="<?php echo $img; ?>icones/dota2.png"></li>
            <li onClick="trocarAba(123);" class="123"><img src="<?php echo $img; ?>icones/gwent.png"></li>
            <li onClick="trocarAba(369);" class="369"><img src="<?php echo $img; ?>icones/hs.png"></li>
            <li onClick="trocarAba(147);" class="147"><img src="<?php echo $img; ?>icones/lol.png"></li>
            <li onClick="trocarAba(258);" class="258"><img src="<?php echo $img; ?>icones/overwatch2.png"></li>
        </ul>
        
        <div class="visualizarCaixa">
            <div class="container">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 caixas">
                </div>
                <div class="col-xs-12 col-md-4">
                    <h2 class="tituloLateral">Nosso <strong>Facebook</strong></h2>
                    <div class="detalheTituloLateral"></div>
                    <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fescups&tabs&width=500&height=214&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="100%" height="214" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                    <h2 class="tituloLateral">Fique por <strong>Dentro</strong></h2>
                    <div class="detalheTituloLateral"></div>
                    <div class="newsletter">
                        <div class="quadroum">
                            Seja sempre o primeiro a saber
                        </div>	
                        Assine nosso <strong>Newsletter</strong> e fique por dentro <br>
                        de tudo que acontece na plataforma!
                        <form action="https://esportscups.us16.list-manage.com/subscribe/post?u=a834600c251090e6177674a3b&amp;id=a145cc8cad" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                            <div id="mc_embed_signup_scroll">
                            <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="seu@email.com.br" required>
                            <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                            <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_a834600c251090e6177674a3b_a145cc8cad" tabindex="-1" value=""></div>
                            <div class="clear"><input type="submit" value="CADASTRE-SE" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                            </div>
                        </form>

                        <!--End mc_embed_signup-->
                    </div>
                </div>
            </div>
        </div>

        <?php include "../footer.php"; ?>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script type="text/javascript">
            function trocarAba(aba){
                $(".menuJogar .ativo").removeClass("ativo");
                switch(aba){
                    case 0:
                        $(".esc").addClass("ativo");
                        $(".botaoMenuJogos").html("Filtro<br><img src='img/logo.png' height='20px'>");
                        break;
                    case 357: // DOTA 2
                        $(".357").addClass("ativo");
                        $(".botaoMenuJogos").html("Filtro<br><img src='img/icones/dota2.png' height='20px'>");
                        break;
                    case 369: // HEARTHSTONE
                        $(".369").addClass("ativo");
                        $(".botaoMenuJogos").html("Filtro<br><img src='img/icones/hs.png' height='20px'>");
                        break;
                    case 147: // LEAGUE OF LEGENDS
                        $(".147").addClass("ativo");
                        $(".botaoMenuJogos").html("Filtro<br><img src='img/icones/lol.png' height='20px'>");
                        break;
                    case 258: // OVERWATCH
                        $(".258").addClass("ativo");
                        $(".botaoMenuJogos").html("Filtro<br><img src='img/icones/overwatch.png' height='20px'>");
                        break;
                    case 123: // GWENT
                        $(".123").addClass("ativo");
                        $(".botaoMenuJogos").html("Filtro<br><img src='img/icones/gwent.png' height='20px'>");
                        break;
                }
                $.ajax({
                    type: "POST",
                    url: "scripts/carregar-caixas.php",
                    data: "aba="+aba,
                    success: function(resultado){
                        $(".caixas").html(resultado);
                    }
                });
                $(".visualizarCaixa").css("display", "none");
            }

            function carregarCaixa(caixa){
                $.ajax({
                    type: "POST",
                    url: "scripts/carregar-caixas.php",
                    data: "caixa="+caixa,
                    success: function(resultado){
                        $(".visualizarCaixa .container").html(resultado);
                        $(".visualizarCaixa").css("display", "block");
                        return false;
                    }
                });	
            }

            function abrirCaixa(jogador, caixa, tipo){ // jogador, codigo caixa, quantidade de chaves, coin ou real.
                $(".recompensa").css("display", "none");
                $.ajax({
                        type: "POST",
                        url: "scripts/caixas.php",
                        data: "jogador="+jogador+"&caixa="+caixa+"&tipo="+tipo+"&funcao=abrir",
                        success: function(resultado){
                            if(resultado == "0"){ // SALDO INSUFICIENTE
                                alert("Saldo insuficiente para abrir esta caixa!");
                            }else{
                                $(".valoresCaixa").css("display", "none");
                                $(".recompensa").html(resultado);
                                $(".recompensa").css("display", "block");
                            }
                            return false;
                        }
                    });		
            }

            function testarSorte(caixa){
                $.ajax({
                    type: "POST",
                    url: "scripts/caixas.php",
                    data: "caixa="+caixa+"&funcao=testar",
                    success: function(resultado){
                        $(".valoresCaixa").css("display", "none");
                        $(".recompensa .row").html(resultado);
                        $(".recompensa").css("display", "block");
                        return false;
                    }
                });	
            }

            jQuery(function($){                
                if(<?php echo $codCaixa; ?> != 0){ // POSSUI CAIXA
                    carregarCaixa(<?php echo $codCaixa; ?>);
                }else{
                    trocarAba(0);
                }
                /*
                var aux = 0;
                while(aux < 500){
                    abrirCaixa(639282, 37, 0);
                    aux++;
                }
                */
            });
        </script>
    </body>
</html>