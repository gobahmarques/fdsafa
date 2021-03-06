﻿<?php
	include "enderecos.php";
    include "../../conexao-banco.php";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>eSCoin League de Hearthstone - eSports Cups</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $css; ?>estrutura.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-64433449-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-64433449-2');
    </script>

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
      fbq('init', '1812303375512785');
      fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=1812303375512785&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->

</head>

<body>
    <div class="row-fluid linha-um">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12">
                    <h1>eSCoin League de Hearthstone</h1>
                    A Liga de Hearthstone mais desafiadora no Servidor das Américas.<br>
                    <br>
                    <img src="<?php echo $img; ?>logo.png" class="logo">
                </div>
                
                <div class="col-12 col-md-2">                    
                </div>
                <div class="col-6 col-md-3">
                    <div class="info">
                        <label>PREMIAÇÃO</label><br>
                        e$ 500.000+
                    </div>                    
                </div>
                <div class="col-6 col-md-2">
                    <div class="info">
                        <label>PARTIDAS / circuito</label><br>
                        500+
                    </div>                    
                </div>
                <div class="col-6 col-md-3">
                    <div class="info">
                        <label>DURAÇÃO</label><br>
                        SEMESTRAL
                    </div>                    
                </div>
                
                <div class="col-12 col-md-42">                    
                </div>
            </div>
        </div>        
    </div>
    <div class="row-fluid linha-dois">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12">
                    <h2>CLASSIFICAÇÃO</h2> 
                    Iremos realizar 4 etapas classificatórias para definir os 16 jogadores que serão <br>
                    convidados para o Evento Principal. Cada etapa pontuará os 10 melhores, ao final das <br>
                    4 etapas iremos convidar os 16 mais pontuados (de acordo com o Rank Geral da Liga) <br>
                    para o Torneio Principal com uma premiação de e$ 500.000 (eSCoin).
                    <br><br>
                </div>
                <div class="col-md-12">
                    <table>
                        <tr>
                            <td>
                                
                            </td>
                            <td>
                                <img src="img/gema-comum.png" class="gema">
                                <h3>ETAPA COMUM</h3>
                            </td>
                            <td>
                                <img src="img/gema-rara.png" class="gema">
                                <h3>ETAPA RARA</h3>
                            </td>
                            <td>
                                <img src="img/gema-epica.png" class="gema">
                                <h3>ETAPA ÉPICA</h3>
                            </td>
                            <td>
                                <img src="img/gema-lendaria.png" class="gema">
                                <h3>ETAPA LENDÁRIA</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                DURAÇÃO  
                            </td>
                            <td>
                                30 DIAS<br>  
                            </td>
                            <td>
                                31 DIAS<br> 
                            </td>
                            <td>
                                30 DIAS<br> 
                            </td>
                            <td>
                                30 DIAS<br> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                FORMATO  
                            </td>
                            <td>
                                PONTOS CORRIDOS<br>  
                            </td>
                            <td>
                                PONTOS CORRIDOS<br> 
                            </td>
                            <td>
                                PONTOS CORRIDOS<br> 
                            </td>
                            <td>
                                PONTOS CORRIDOS<br> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 MODO DE JOGO
                            </td>
                            <td>
                                <strong>PADRÃO</strong><br>  
                            </td>
                            <td>
                                <strong>PADRÃO</strong><br> 
                            </td>
                            <td>
                                <strong>PADRÃO</strong><br> 
                            </td>
                            <td>
                                <strong>PADRÃO</strong><br> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 REGRA 
                            </td>
                            <td>
                                Apenas <strong>Cartas Básicas</strong> e <strong>Cartas Comuns</strong><br>  
                            </td>
                            <td>
                                Apenas <strong>Cartas Básicas</strong>, <strong>Cartas Comuns</strong> e <strong>Cartas Raras</strong><br> 
                            </td>
                            <td>
                                Apenas <strong>Cartas Básicas</strong>, <strong>Cartas Comuns</strong>, <strong>Cartas Raras</strong> e <strong>Cartas Épicas</strong><br>
                            </td>
                            <td>
                                <strong>Todas</strong> as cartas são permitidas aqui
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <a href="https://www.esportscups.com.br/ptbr/campeonato/340/" target="_blank"><input type="button" class="btn btn-danger" value="FINALIZADO"></a>
                            </td>
                            <td>
                                <a href="https://www.esportscups.com.br/ptbr/campeonato/341/" target="_blank"><input type="button" class="btn btn-danger" value="FINALIZADO"></a>
                            </td>
                            <td>
                                <a href="https://www.esportscups.com.br/ptbr/campeonato/342/" target="_blank"><input type="button" class="btn btn-primary" value="EM ANDAMENTO"></a>
                            </td>
                            <td>
                                <input type="button" class="btn btn-dark" value="INSCRIÇÕES DIA 05/11" disabled>
                            </td>
                        </tr>
                    </table>
                    <br>
                </div>
                <div class="col-12 col-md-12">
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
    </div>
    <div class="linha-quatro row-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-6">                    
                    <h2>EVENTO PRINCIPAL</h2>                    
                    Os 16 mais pontuados após a execução das 4 etapas classificatórias <br>
                    irão se enfrentar em uma Eliminação Dupla para disputar o <br>
                    prêmio de 500 mil eSCoins (e$).<br><br>
                    <img src="<?php echo $img; ?>logo.png" class="logo-min" width="150px"><br><br>                    
                </div>
                <div class="col-md-6 text-right">
                    <h4>CLASSIFICAÇÃO GERAL</h4>
                    Atualizado dia 06 de Setembro de 2018 <br><br>
                    <table>
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>JOGADOR</td>
                                <td>PTS</td>
                            </tr>
                        </thead>
                        <?php
                            $aux = 1;
                            $inscricoesLiga = mysqli_query($conexao, "SELECT * FROM liga_inscricao
                            WHERE cod_liga = 1
                            ORDER BY pontos DESC
                            LIMIT 16");
                            while($inscricao = mysqli_fetch_array($inscricoesLiga)){
                            ?>
                                <tr>
                                    <td><?php echo $aux; ?></td>
                                    <td><?php echo $inscricao['conta']; ?></td>
                                    <td><?php echo $inscricao['pontos']; ?></td>
                                </tr>
                            <?php
                                $aux++;
                            }
                            $restante = 16 - mysqli_num_rows($inscricoesLiga);
                            while($restante > 0){
                            ?>
                                <tr>
                                    <td><?php echo $aux; ?></td>
                                    <td><?php echo "EM BREVE"; ?></td>
                                    <td><?php echo "-----"; ?></td>
                                </tr>
                            <?php
                                $restante--;  
                                $aux++;
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid linha-tres">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-left">
                    <br>
                    <img src="<?php echo $img; ?>transmissao.png" width="350px">                    
                </div>
                <div class="col-md-6 text-right">
                    <h2>TRANSMISSÕES</h2>
                    Realizaremos transmissões ao vivo com narração e comentários periodicamente, <br>
                    divulgando sempre a programação em nossas redes sociais (Facebook e Instagram). <br><br>
                    Queremos transmitir a maioria de jogos que pudermos para alimentar ainda mais <br>
                    a comunidade com conteúdo de qualidade e conteúdo. <br>Siga nosso canal e      acompanhe as disputas. <br><br>
                    <div class="twitch">
                        <i class="fab fa-twitch"></i>/ESPORTSCUPS
                    </div>                 
                </div>                
            </div>
        </div>
    </div>
    <div class="row-fluid linha-cinco text-center">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2>FIQUE POR DENTRO DE TUDO</h2>
                    Informe-nos o seu melhor e-mail onde gostaria de receber todas as notíficas da eSCoin League de Hearthstone. <br>
                    Transmissões, ofertas, dias e horários de partidas, erratas, etc...
                    <!-- Begin MailChimp Signup Form -->
                    <link href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css" rel="stylesheet" type="text/css">
                    <style type="text/css">
                        #mc_embed_signup{clear:left; font:14px Helvetica,Arial,sans-serif; width:100%;}
                        /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
                           We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
                    </style>
                    <div id="mc_embed_signup">
                    <form action="https://esportscups.us18.list-manage.com/subscribe/post?u=491faca4b1b499fd4138aa470&amp;id=910895c8da" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                        <div id="mc_embed_signup_scroll">

                        <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Seu melhor E-MAIL aqui" required>
                        <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_491faca4b1b499fd4138aa470_910895c8da" tabindex="-1" value=""></div>
                        <div class="clear"><input type="submit" value="Enviar" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                        </div>
                    </form>
                    </div>

                    <!--End mc_embed_signup-->
                </div>
            </div>
        </div>
    </div>
    
    
	<script src="../../js/jquery.js"></script>
    <script src="../../js/bootstrap.js"></script>
</body>
</html>