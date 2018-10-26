<!DOCTYPE html>
<?php
    include "../../enderecos.php";
    include "../../session.php";
?>
<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.css">
        <link rel="stylesheet" href="<?php echo $css; ?>esportscups.css">

        <title>Artigos eSC | e-Sports Cups</title>
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
            <div class="row-fluid">
                <div class="resumoCarteira">
                    <form action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post" onsubmit="PagSeguroLightbox(this); return false;" id="pagseguro">
                        <input type="hidden" name="code" id="code" value="">
                    </form>
                    <h1>Adicionar saldo à sua Carteira eSC</h1>
                    O saldo de sua Carteira eSC poderá ser utilizado na compra de chaves para caixas e inscrições em campeonatos pagos (por enquanto). <br><br>
                    Você ainda terá a oportunidade de revisar o seu pedido antes que ele seja finalizado. <br><br>
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="row-fluid">
                                <div class="plano">
                                    <h3>Adicionar R$ 5</h3>
                                    <div class="caixaBotao acoes">
                                        R$ 5,00
                                        <button type="button" class="btn-laranja btn" onClick="solicitarPagamento(5, <?php echo $usuario['codigo']; ?>);">ADICIONAR SALDO</button>
                                    </div>
                                    <div class="caixaBotao aviso" >
                                        <input type="button" class="btn btn-azul" value="Cadastrar Endereço" onClick="novoEndereco();">
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="plano">
                                    <h3>Adicionar R$ 10</h3>
                                    <div class="caixaBotao acoes">
                                        R$ 10,00
                                        <button type="button" class="btn-laranja btn" onClick="solicitarPagamento(10, <?php echo $usuario['codigo']; ?>);">ADICIONAR SALDO</button>
                                    </div>
                                    <div class="caixaBotao aviso" style="display=none;">
                                        <input type="button" class="btn btn-azul" value="Cadastrar Endereço" onClick="novoEndereco();">
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="plano">
                                    <h3>Adicionar R$ 25</h3>
                                    <div class="caixaBotao acoes">
                                        R$ 25,00
                                        <button type="button" class="btn-laranja btn" onClick="solicitarPagamento(25, <?php echo $usuario['codigo']; ?>);">ADICIONAR SALDO</button>
                                    </div>
                                    <div class="caixaBotao aviso" style="display=none;">
                                        <input type="button" class="btn btn-azul" value="Cadastrar Endereço" onClick="novoEndereco();">
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="plano">
                                    <h3>Adicionar R$ 50</h3>
                                    <div class="caixaBotao acoes">
                                        R$ 50,00
                                        <button type="button" class="btn-laranja btn" onClick="solicitarPagamento(50, <?php echo $usuario['codigo']; ?>);">ADICIONAR SALDO</button>
                                    </div>
                                    <div class="caixaBotao aviso" style="display=none;">
                                        <input type="button" class="btn btn-azul" value="Cadastrar Endereço" onClick="novoEndereco();">
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="plano">
                                    <h3>Adicionar R$ 100</h3>
                                    <div class="caixaBotao acoes">
                                        R$ 100,00
                                        <button type="button" class="btn-laranja btn" onClick="solicitarPagamento(100, <?php echo $usuario['codigo']; ?>);">ADICIONAR SALDO</button>
                                    </div>
                                    <div class="caixaBotao aviso" style="display=none;">
                                        <input type="button" class="btn btn-azul" value="Cadastrar Endereço" onClick="novoEndereco();">
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="plano">
                                    <h3>Adicionar R$ 150</h3>
                                    <div class="caixaBotao acoes">
                                        R$ 150,00
                                        <button type="button" class="btn-laranja btn" onClick="solicitarPagamento(150, <?php echo $usuario['codigo']; ?>);">ADICIONAR SALDO</button>
                                    </div>
                                    <div class="caixaBotao aviso" style="display=none;">
                                        <input type="button" class="btn btn-azul" value="Cadastrar Endereço" onClick="novoEndereco();">
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="plano">
                                    <h3>Adicionar R$ 200</h3>
                                    <div class="caixaBotao acoes">
                                        R$ 200,00
                                        <button type="button" class="btn-laranja btn" onClick="solicitarPagamento(200, <?php echo $usuario['codigo']; ?>);">ADICIONAR SALDO</button>
                                    </div>
                                    <div class="caixaBotao aviso" style="display=none;">
                                        <input type="button" class="btn btn-azul" value="Cadastrar Endereço" onClick="novoEndereco();">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-4">
                            <div class="saldoAtual" >
                                SALDO ATUAL: R$ <?php echo number_format($usuario['saldo'], 2, ',', '.'); ?>
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
        <script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
        <script>
            
            function enviaPagseguro(){
                $.post('pagseguro/pagseguro/pagseguro.php','',function(data){
                    $('#code').val(data);
                    $('#comprar').submit();
                })
            }
            function novoEnderecoEnviar(){
                $("#cadastroEndereco").submit();
            }
            function novoEndereco(){
                var produto = $("#codProduto").val();
                $(".modal-title").html("Cadastrar Novo Endereço")
                $(".modal-body").load('ptbr/loja/loja-endereco-novo.html');
                $(".modal-footer").html("<input type='button' class='btn btn-laranja' value='Cadastrar Endereço' onClick='novoEnderecoEnviar();'>");
                $(".modal").modal();
                setTimeout(function(){ $("#codProduto").val(produto); }, 1000);
            }
            function solicitarPagamento(valor, jogador){
                /*
                jQuery.ajax({
                    type: "POST",
                    url: "scripts/solicitar-pagamento.php",
                    data: "valor="+valor,
                    success: function(data){
                        PagSeguroLightbox({
                            code: ''+data+''
                            }, {
                            success : function(transactionCode) {
                                jQuery.ajax({
                                    type: "POST",
                                    url: "scripts/usuario.php",
                                    data: "funcao=transacao&transacao="+transactionCode,
                                    success: function(data){
                                        windows.location.reload();
                                    }
                                });
                            }
                        });
                    }
                });
                */
                
                var taxa = valor*0.06 + 0.4;
                var total = valor + taxa; 
                
                jQuery.ajax({
                    type: "POST",
                    url: "scripts/solicitar-pagamento.php",
                    data: "jogador="+jogador+"&valor="+valor,
                    success: function(data){
                        total = total.toFixed(2);
                        $.post("pagseguro/pagseguro/pagseguro.php", {codPagamento: data, totalPedido: total, emailUsuario: "<?php echo $usuario['email']; ?>"}, function(data){
                            $("#code").val(data);
                            $("#pagseguro").submit();
                        });
                    }
                });                        
            }
            
            $(function(){  
                $(".carteirars").addClass("ativo"); 
                var endereco = <?php echo mysqli_num_rows($pesqEndereco); ?>;
                if(endereco == 0){
                    $(".acoes").css("display", "none");
                    $(".aviso").css("display", "block");
                }
            });
        </script>
    </body>
</html>