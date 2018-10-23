<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">
<footer>
    <div class="container">
        <div class="row">
            <img src="<?php echo $img; ?>logo.png"  class="logo"/>
            <div class="col text-right">
                <a href="https://discord.gg/RTnrWab" target="_blank">
                    <i class="fab fa-discord" style="font-size:26px"></i>
                </a>
                <a href="https://www.facebook.com/escups/" target="_blank">
                    <i class="fab fa-facebook-f" style="font-size:26px"></i>
                </a>
                <a href="https://twitter.com/cups_e" target="_blank">
                    <i class="fab fa-twitter" style="font-size:26px"></i>
                </a>
                <a href="https://www.twitch.tv/esportscups" target="_blank">
                    <i class="fab fa-twitch" style="font-size:26px"></i>
                </a>
                <a href="https://www.youtube.com/channel/UCmOVIphlEpXqg6L4Sa9EW_g" target="_blank">
                    <i class="fab fa-youtube" style="font-size:26px"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-64433449-2"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-64433449-2');
</script>
<script type="text/javascript">
    window.smartlook||(function(d) {
    var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
    var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
    c.charset='utf-8';c.src='https://rec.smartlook.com/recorder.js';h.appendChild(c);
    })(document);
    smartlook('init', 'e199d1b3fa4b81f35197bbe3451a504bb091469c');
</script>




<script src="<?php echo $js; ?>jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="<?php echo $js; ?>bootstrap.js"></script>
<script src="<?php echo $js; ?>jquery.countdown.js" type="text/javascript"></script>
<script src="<?php echo $js; ?>jquery.carouFredSel.js" type="text/javascript"></script>
<script src="<?php echo $js; ?>jquery.mask.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>jquery.countdown.css"> 
<script type="text/javascript" src="<?php echo $js; ?>jquery.plugin.js"></script> 
<script type="text/javascript" src="<?php echo $js; ?>jquery.countdown.js"></script>
<script type="text/javascript" src="<?php echo $js; ?>jquery.countdown-pt-BR.js"></script>
<script>
    <?php
        if($exibirModal == true){
        ?>
            $( document ).on( "mousemove", function( event ) { 
                if(window.event.clientY < 5){
                    $(".modal").addClass("modalNewsletter");
                    /* MODAL SOBRE NEWSLETTER
                    $(".modalNewsletter .modal-content").html("<div class='conteudo'><div class='bg'><img src='img/bgs/bgnewsletter.jpeg' width='100%' height='100%' /></div><div class='formularioModal'><h3>Saiba das nossas competições e atualizações antes de todos.</h3><link href='//cdn-images.mailchimp.com/embedcode/classic-10_7.css' rel='stylesheet' type='text/css'><style type='text/css'>#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; float:left; width:100%;}</style><div id='mc_embed_signup'><form action='https://esportscups.us18.list-manage.com/subscribe/post?u=491faca4b1b499fd4138aa470&amp;id=f3feeb058d' method='post' id='mc-embedded-subscribe-form' name='mc-embedded-subscribe-form' class='validate' target='_blank' novalidate><div id='mc_embed_signup_scroll'><div class='indicates-required'><span class='asterisk'>*</span> campos obrigatórios</div><div class='mc-field-group'><label for='mce-EMAIL'>Seu melhor e-mail  <span class='asterisk'>*</span></label><input type='email' value='' name='EMAIL' class='required email' id='mce-EMAIL'></div><strong>Jogos de Interesse </strong><div class='mc-field-group input-group'><ul><li><input type='checkbox' value='1' name='group[285][1]' id='mce-group[285]-285-0'><label for='mce-group[285]-285-0'>Dota 2</label></li><li><input type='checkbox' value='2' name='group[285][2]' id='mce-group[285]-285-1'><label for='mce-group[285]-285-1'>GWENT</label></li><li><input type='checkbox' value='4' name='group[285][4]' id='mce-group[285]-285-2'><label for='mce-group[285]-285-2'>Hearthstone</label></li><li><input type='checkbox' value='8' name='group[285][8]' id='mce-group[285]-285-3'><label for='mce-group[285]-285-3'>League of Legends</label></li><li><input type='checkbox' value='16' name='group[285][16]' id='mce-group[285]-285-4'><label for='mce-group[285]-285-4'>Overwatch</label></li></ul></div><div id='mce-responses' class='clear'><div class='response' id='mce-error-response' style='display:none'></div><div class='response' id='mce-success-response' style='display:none'></div></div><div style='position: absolute; left: -5000px;' aria-hidden='true'><input type='text' name='b_491faca4b1b499fd4138aa470_f3feeb058d' tabindex='-1' value=''></div><div class='clear'><input type='submit' value='Enviar' name='subscribe' id='mc-embedded-subscribe' class='button'></div></div></form></div></div></div>");    
                    */
                    // MODAL SOBRE RIFA MENSAL
                    $(".modalNewsletter .modal-content").html("<div class='conteudo'><div class='bg'><img src='img/bgs/bgnewsletter2.png' width='100%' /></div><div class='formularioModal'><h3>Colabore com o cenário competitivo dos Esportes Eletrônicos.</h3>Para podermos fornecer premiações em Torneios ainda maiores, abrimos uma oportunidade da comunidade contribuir diretamente nas premiações e ainda concorrer a um produto a cada contribuição.<br><br><a href='https://www.esportscups.com.br/ptbr/rifas/?codigo=11' target='_blank'><input type='button' class='btn btn-primary' value='Visualizar Rifa'></a></div></div>");  
                    $(".modal").modal();
                    jQuery.ajax({
                        type: "POST",
                        url: "scripts/usuario.php",
                        data: "funcao=cookieModal",
                        success: function(data){
                        }
                    });
                }
            });             
        <?php
        }
    ?>
    function abrirPartidasPendentes(){
        var hPartidasPendentes = $(".partidasPendentesUsuario").height() + 25;
        $(".partidasPendentesUsuario").css("padding-top", ""+(hPartidasPendentes+20)+"");    
        $(".fa-gamepad").attr("onclick", "fecharPartidasPendentes();");
    }
    function fecharPartidasPendentes(){
        var hPartidasPendentes = $(".partidasPendentesUsuario").height() + 25;
        $(".partidasPendentesUsuario").css("padding-top", "0");     
        $(".fa-gamepad").attr("onclick", "abrirPartidasPendentes();");
    }
    $(function(){ 
        var hPartidasPendentes = $(".partidasPendentesUsuario").height() + 25;
        $(".partidasPendentesUsuario").css("top", "-"+hPartidasPendentes+"px");
        $(".partidasPendentesUsuario").css("margin-bottom", "-"+hPartidasPendentes+"px");
        if(Notification.permission === "default"){
            Notification.requestPermission();
        }
    });
</script>

