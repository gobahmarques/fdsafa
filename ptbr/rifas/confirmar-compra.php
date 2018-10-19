<?php
    include "../../enderecos.php";
    include "../../session.php";    
    $rifa = mysqli_fetch_array(mysqli_query($conexao, "
        SELECT * FROM rifa
        WHERE codigo = ".$_GET['codrifa']."
    "));
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
          fbq('init', '1812303375512785');
          fbq('track', 'Purchase');
        </script>
        <noscript><img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=1812303375512785&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Facebook Pixel Code -->

    </head>
    <body class="bodyRifa">
        <?php
            include "../header.php";
        ?>
        <div class="container">
            <div class="row justify-content-center">.
                <div class="col-12 centralizar">
                    <h2>A compra do seu cupom foi realizada com sucesso.</h2>
                    Suas chances estão mais altas para ganhar o <?php echo $rifa['nome_produto']; ?>. O sorteio será realizado <?php echo date("d/m/Y - H:i", strtotime($rifa['data_sorteio'])); ?>
                    através da nossa página no facebook.<br><br>
                    <a href="ptbr/rifas/" target="_blank"><input type="button" value="RESERVAR MAIS CUPONS" class="btn btn-success"></a>
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