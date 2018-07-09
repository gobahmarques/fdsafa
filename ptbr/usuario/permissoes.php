<?php
    include "../../enderecos.php";
    include "../../session.php";
    include "../../steam/steamauth/steamauth.php";    
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

        <title>Sincronizações | e-Sports Cups</title>
    </head>
    <body>
        <?php 
            include "../header.php";
            include "perfil.php";
        ?>
        
        <div class="container">
            <div class="row conexoes">
                <div class="col-12 col-md-4">
                    <div class="conexao battlenet">
                        <div class="icone">
                            <img src="http://www.esportscups.com.br/img/icones/battlenet.png" alt="">	
                        </div>
                        <?php
                            if($usuario['battletag'] != NULL){
                            ?>
                                <div class="acao" onClick="desvincularBattlenet();">
                                    <img src="img/icones/trocar.png" alt="Desvincular Battle.net" title="Desvincular Battle.net">
                                </div>
                                <div class="">
                                    <?php echo $usuario['battletag']; ?>
                                </div>
                            <?php					
                            }else{
                            ?>
                                <a href="battlenet/battle.php"><input type="button" value="VINCULAR" class="btn btn-dark"></a>
                            <?php
                            }
                            ?>
                    </div>                    
                </div>
                <div class="col-12 col-md-4">
                    <div class="conexao steam">
                        <div class="icone">
                            <img src="http://www.esportscups.com.br/img/icones/steam.png" alt="">	
                        </div>
                        <?php
                            if($usuario['steam'] == NULL){
                                loginbutton($usuario['codigo']);  
                            }else{
                            ?>
                                <div class="acao" onClick="desvincularSteam();">
                                    <img src="img/icones/trocar.png" alt="Desvincular Steam" title="Desvincular Steam">
                                </div>
                                <div class="">
                                    Steam ID: <?php echo $usuario['steam']; ?>
                                </div>
                            <?php       
                            }
                            
                        ?>
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
            function desvincularBattlenet(){
                jQuery.ajax({
                    type: "POST",
                    url: "scripts/usuario.php",
                    data: "funcao=battlenet",
                    success: function( data )
                    {
                        window.location.reload();
                    }
                });
            }
            function desvincularSteam(){
                jQuery.ajax({
                    type: "POST",
                    url: "scripts/usuario.php",
                    data: "funcao=steam",
                    success: function( data )
                    {
                        window.location.reload();
                    }
                });
            }
            $(function(){               
                $(".permissoes").addClass("ativo"); 
            });
        </script>
    </body>
</html>