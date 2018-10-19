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

    <title>Artigos eSports | e-Sports Cups</title>
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
      
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="row artigos">
                </div>
            </div>
            <div class="col-12 col-md-4">
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
                <h2 class="tituloLateral">Aumente seu <strong>Nível</strong></h2>
                <div class="detalheTituloLateral"></div>
                <a href="https://go.hotmart.com/H9153842R" target="_blank"><img src="<?php echo $img; ?>artigos/afiliado01.png" width="100%" class="mb-3"></a>
                <a href="https://go.hotmart.com/W9080866G" target="_blank"><img src="<?php echo $img; ?>artigos/afiliado02.png" width="100%" class="mb-3"></a>
                <a href="https://go.hotmart.com/J9530117U" target="_blank"><img src="<?php echo $img; ?>artigos/afiliado03.png" width="100%"></a>
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
    <script>
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
				url: "scripts/carregar-artigos.php",
				data: "aba="+aba,
				success: function(resultado){
					$(".artigos").html(resultado);
					return false;
				}
			});	
            closeNav();
		}
		jQuery(function($){
			trocarAba(0);
		});
	</script>
  </body>
</html>