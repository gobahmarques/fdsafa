<?php
    set_time_limit(0);
    include "../../enderecos.php";
    include "../../session.php";

    require_once("../../pagseguro/transparente/config.php");
    require_once("../../pagseguro/transparente/utils.php");
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

        <title>Artigos eSC | e-Sports Cups</title>
        <?php
            $params = array(
                "email" => $PAGSEGURO_EMAIL,
                "token" => $PAGSEGURO_TOKEN
            );
            $header = array();
        
            $response = curlExec($PAGSEGURO_API_URL."/sessions", $params, $header);
            $json = json_decode(json_encode(simplexml_load_string($response)));
            $sessionCode = $json->id;
        ?>
        <style>
            #form_boleto, #form_cartao, #form_deposito{
                display:none
            }
        </style>
    </head>
    <body>
        <?php 
            include "../header.php";
            include "perfil.php";
            $pesqEndereco = mysqli_query($conexao, "SELECT * FROM jogador_enderecos WHERE cod_jogador = ".$usuario['codigo']." ");
            
            if(!isset($usuario['codigo']) || $usuario['codigo'] != $perfil['codigo']){
                header("Location: ../../");
            }else{
                if($usuario['codigo'] != $perfil['codigo']){
                    header("Location: ../../");
                }
            }
        ?>
        
        <div class="container">
            <ul class="menuCarteira">
                <a href="ptbr/usuario/<?php echo $usuario['codigo']; ?>/carteira-real/"><li>Resumo</li></a>
                <a href="ptbr/usuario/<?php echo $usuario['codigo']; ?>/carteira-real/historico/"><li>Histórico (em breve)</li></a>
                <a href="ptbr/usuario/<?php echo $usuario['codigo']; ?>/carteira-real/adicionar-saldo/"><li class="ativo">Adicionar Saldo</li></a>
            </ul>
            <div class="row">                
                <div class="resumoCarteira">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="row">
                                <div class="cartaoCredito col-6">
                                    <input type="button" value="Cartão de Crédito" class="btn btn-dark" id="cartao">
                                </div>
                                <div class="boleto col-6">
                                    <input type="button" value="Boleto Bancário" class="btn btn-dark" id="boleto">
                                </div> 
                            </div>                                                             
                        </div>
                        <div class="col-12 col-md-8">
                            <div id="form_cartao">                                
                                <form action="./pay_cartao.php?ref='creditCard'" method="post" >                                    
                                    <input type="hidden" name="brand">
                                    <input type="hidden" name="token">
                                    <input type="hidden" name="senderHash">
                                    
                                    <div class="row">
                                        <div class="col-8">
                                            <label>Nº Cartão</label>   
                                            <input type="text" name="cardNumber" class="form-control" placeholder="Valid Card Number" autocomplete="cc-number" required autofocus value="4111 1111 1111 1111"/>
                                            <span><i class="glyphicon glyphicon-credit-card"></i></span>
                                        </div>  
                                        <div class="col-4">
                                            <label for="cardExpiry">Validade</label>
                                            <input type="text" class="form-control" name="cardExpiry" placeholder="MM / YY" autocomplete="cc-exp" required value="12/2030"/>
                                        </div>
                                    </div>
                                    
                                    

                                    
                                    

                                    

                                    <label for="cardCVC">CVV</label>
                                    <input type="text" name="cardCVC" placeholder="CVV" autocomplete="cc-csc" required value="123"/>

                                    <button name="creditCard" value="creditCard">Pagar com Cartão</button>
                                </form>
                            </div>

                            <div id="form_boleto">
                                <form action="./pay_boleto.php" method="post" >
                                    <input type="hidden" name="brand">
                                    <input type="hidden" name="token">
                                    <input type="hidden" name="senderHash">
                                    <button name="boleto" value="boleto">Gerar com Boleto</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            
            
            
            
        </div>
        
        <?php include "../footer.php"; ?>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
        <script>
            $(document).ready(function(){
                //Abre a aba do cartão de crédito
                $('#cartao').click(function(){
                    $('#form_cartao').fadeIn(500);
                    $('#form_boleto').fadeOut(500);
                    $('#form_deposito').fadeOut(500);
                    $('#cartao').css({'background':'#fe4a67', 'color': '#fff'});
                    $('#boleto').css({'background':'#eee', 'color': '#333'});
                    $('#deposito').css({'background':'#eee', 'color': '#333'});
                });

                //Abre a aba do boleto bancário
                $('#boleto').click(function(){
                    $('#form_cartao').fadeOut(500);
                    $('#form_deposito').fadeOut(500);
                    $('#form_boleto').fadeIn(500);
                    $('#boleto').css({'display':'inline-block', 'background':'#09c', 'color': '#fff'});
                    $('#cartao').css({'background':'#eee', 'color': '#333'});
                    $('#deposito').css({'background':'#eee', 'color': '#333'});
                });

                //Abre a aba do depósito bancário online
                $('#deposito').click(function(){
                    $('#form_cartao').fadeOut(500);
                    $('#form_deposito').fadeIn(500);
                    $('#form_boleto').fadeOut(500);
                    $('#deposito').css({'display':'inline-block', 'background':'#91f08e', 'color': '#fff'});
                    $('#cartao').css({'background':'#eee', 'color': '#333'});
                    $('#boleto').css({'background':'#eee', 'color': '#333'});
                });
            });
        </script>
    </body>
</html>