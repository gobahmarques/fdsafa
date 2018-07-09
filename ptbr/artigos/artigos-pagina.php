<?php
	include "../../session.php";
	include "../../enderecos.php";
    
	$artigo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM artigos WHERE codigo = ".$_GET['codigo'].""));
	if($artigo['cod_jogo'] != NULL){
		$jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogos WHERE codigo = ".$artigo['cod_jogo']." "));	
	}	
	$autor = @mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$artigo['autor']." "));

	$ipLeitor = $_SERVER['REMOTE_ADDR'];
	$pesquisaVisita = mysqli_query($conexao, "SELECT * FROM visitas WHERE ip = '$ipLeitor' AND pagina = 'ptbr/artigo/".$artigo['codigo']."/'");
	if(mysqli_num_rows($pesquisaVisita) == 0){
		mysqli_query($conexao, "INSERT INTO visitas VALUES (NULL, '$ipLeitor', 'ptbr/artigo/".$artigo['codigo']."/')");
	}
	$visualizacoes = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM visitas WHERE pagina = 'ptbr/artigo/".$artigo['codigo']."/'"));
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

    <title><?php echo $artigo['nome']; if(isset($jogo)){ echo " - ".$jogo['nome']; }?> | e-Sports Cups</title>
    <meta property="og:url"           content="https://www.esportscups.com.br/ptbr/artigo/<?php echo $artigo['codigo']; ?>/" />
    <meta property="og:type"          content="article" />
    <meta property="og:title"         content="<?php echo $artigo['nome']." | eSports Cups"; ?>" />
    <meta property="og:description"   content="<?php echo $artigo['descricao']; ?>" />
    <meta property="og:image"         content="https://www.esportscups.com.br/img/artigos/<?php echo $artigo['thumb']; ?>" />
  </head>
  <body>
    <?php include "../header.php"; ?>
      <div class="linhaTituloArtigo">
        <div class="container">
            <div class="jogo">
			<?php
				if(isset($jogo['nome'])){
					echo strtoupper($jogo['nome']);	
				}else{
					echo "eSports Cups";
				}
				 
			?>
			</div>
            <div class="tituloArtigo">
                <?php echo "<h1>".$artigo['nome']."</h1>"; ?>
            </div>			
			<div class="infos">
			<?php 
				echo date("d/m/Y", strtotime($artigo['data']))." - $visualizacoes visualizações<br>";
				echo strtoupper($autor['nome'])." '<strong>".strtoupper($autor['nick'])."</strong>' ".strtoupper($autor['sobrenome']);
			?>	
			</div>
        </div>
      </div>
      <div class="container">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="row-fluid apresentacaoArtigo">
                    <img src="http://www.esportscups.com.br/img/artigos/<?php echo $artigo['thumb']; ?>" alt="" width="100%"><br><br>
                    <?php echo $artigo['artigo']; ?>
                    
                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = 'https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.12';
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));
                    </script>
                    <div class="fb-comments" data-href="https://www.esportscups.com.br/ptbr/artigo/<?php echo $artigo['codigo']; ?>/" data-width="100%" data-numposts="5"></div>
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
                <h2 class="tituloLateral">Nosso <strong>Facebook</strong></h2>
                <div class="detalheTituloLateral"></div>
                <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fescups&tabs&width=500&height=214&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="100%" height="214" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                <h2 class="tituloLateral">Últimos <strong>Artigos</strong></h2>
                <div class="detalheTituloLateral"></div>
                
                <?php
                    $artigos = mysqli_query($conexao, "SELECT * FROM artigos WHERE cod_jogo is not null ORDER BY data DESC LIMIT 6");
                    while($destaque = mysqli_fetch_array($artigos)){
                    ?>
                        <a href="ptbr/artigo/<?php echo $destaque['codigo']; ?>/">
                            <div class="destaqueArtigo">						
                                <img src="https://www.esportscups.com.br/img/artigos/<?php echo $destaque['thumb']; ?>" alt="">
                                <h5><?php echo $destaque['nome']; ?></h5>
                                <?php echo date("d/m/Y", strtotime($destaque['data'])); ?>
                            </div>
                        </a>
                    <?php
                    }
                ?>
                
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
  </body>
</html>