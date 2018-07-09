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

        <title>Troque suas eSCoins por produtos do eSports | e-Sports Cups</title>
    </head>
    <body>
        <?php include "../header.php"; ?>
        <input type="hidden" id="codProduto">
        <div class="container">
            <div class="row">
                <nav class="navbar navbar-expand-lg navbar-light bg-light menuLoja">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <?php
                                $categorias = mysqli_query($conexao, "SELECT * FROM categoria ORDER BY nome");
                                while($categoria = mysqli_fetch_array($categorias)){
                                ?>
                                    <a href="ptbr/loja/?filtro=<?php echo $categoria['codigo']; ?>"><li class="<?php if(isset($_GET['filtro']) && $_GET['filtro'] == $categoria['codigo']){ echo "active"; } ?>"><?php echo $categoria['nome']; ?></li></a>
                                <?php
                                }
                            ?>
                        </ul>
                    </div>
                </nav>
                <?php
                    if(isset($_GET['filtro'])){
                        $subcategorias = mysqli_query($conexao, "SELECT * FROM categoria_sub WHERE cod_categoria = ".$_GET['filtro']." ORDER BY codigo ");
                        if(mysqli_num_rows($subcategorias) != 0){
                        ?>
                            <nav class="navbar navbar-expand-lg subMenuLoja d-sm-block">
                                <div class="collapse navbar-collapse" id="navbarNav">
                                    <ul class="navbar-nav">
                                        <?php
                                            $categorias = mysqli_query($conexao, "SELECT * FROM categoria ORDER BY nome");
                                            while($sub = mysqli_fetch_array($subcategorias)){
                                        ?>
                                            <a href="ptbr/loja/?filtro=<?php echo $sub['cod_categoria']; ?>&subfiltro=<?php echo $sub['codigo']; ?>"><li class="<?php if(isset($_GET['subfiltro']) && $_GET['subfiltro'] == $sub['codigo']){ echo "ativo"; } ?>"><?php echo $sub['nome']; ?></li></a>
                                        <?php
                                        }
                                        ?>
                                        <a href="ptbr/loja/?filtro=<?php echo $_GET['filtro']; ?>"><li class="<?php if(!isset($_GET['subfiltro'])){ echo "ativo"; } ?>">TODOS</li></a>
                                    </ul>
                                </div>
                            </nav>
                            <div class="subcategorias">
                                <div class="barraCentral">
                                    <ul>
                                        
                                    <?php
                                        
                                    ?>
                                    </ul>
                                </div>
                            </div>
                        <?php				
                        }
                    }
                ?>
            </div>
            <div class="row">
                <?php
                    if(isset($_GET['filtro'])){
                        if(isset($_GET['subfiltro'])){
                            $produtos = mysqli_query($conexao, "SELECT * FROM produto WHERE cod_categoria = ".$_GET['filtro']." AND cod_sub_categoria = ".$_GET['subfiltro']." AND status = 1 ORDER BY valor ASC");
                        }else{
                            $produtos = mysqli_query($conexao, "SELECT * FROM produto WHERE cod_categoria = ".$_GET['filtro']." AND status = 1 ORDER BY valor ASC");
                        }

                    }else{
                        $produtos = mysqli_query($conexao, "SELECT * FROM produto WHERE status = 1 ORDER BY valor ASC");
                    }
                    while($produto = mysqli_fetch_array($produtos)){
                        $categoriaProduto = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM categoria WHERE codigo = ".$produto['cod_categoria'].""));
                        $subCategoriaProduto = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM categoria_sub WHERE codigo = ".$produto['cod_sub_categoria'].""));
                    ?>
                        <div class="col-4 col-md-2 produto">
                            <div class="col-md-12-fluid centralizar categoria">
                                <?php echo $categoriaProduto['nome']; ?>
                            </div>
                            <div class="col-xs-4 col-md-12 foto centralizar">
                                <a href="<?php echo $produto['link']; ?>" target="_blank">
                                    <img src="<?php echo "http://www.esportscups.com.br/img/produtos/".$produto['codigo']."/foto.png"; ?>" alt="">
                                </a>							
                            </div>		
                            <div class="titulo">
                                <?php echo $produto['nome']; ?>
                            </div>
                            <div class="subCategoria">
                                <?php echo $subCategoriaProduto['nome']; ?>
                            </div>
                            <div class="valor">
                                <img src="<?php echo "http://www.esportscups.com.br/img/icones/escoin.png"; ?>" alt="">
                                <strong><?php	
                                    echo number_format($produto['valor'], 0, '', '.');
                                ?></strong>							
                            </div>
                            <div class="andamento">
                            <?php
                                if(isset($usuario['codigo'])){
                                    $pesquisaCupom = mysqli_query($conexao, "SELECT * FROM produto_cupom WHERE cod_produto = ".$produto['codigo']." AND cod_jogador = ".$usuario['codigo']." AND status = 0");
                                    if(mysqli_num_rows($pesquisaCupom) > 0){ // POSSUI CUPOM PARA TROCA
                                    ?>
                                        <input type="button" value="CUPOM DISPONÍVEL" onClick="abrirEnderecos(<?php echo $produto['codigo']; ?>);">
                                    <?php	
                                    }else{
                                        if($usuario['pontos'] < $produto['valor']){ // USUARIO NAO POSSUI SALDO PARA COMPRA
                                            $barraAtual = ($usuario['pontos'] / $produto['valor']) * 100;
                                        ?>
                                            <div class="barratotal" style="width: 100%;">
                                                <div class="barraatual" style="width: <?php echo $barraAtual; ?>%;">										
                                                </div>
                                            </div>
                                            <img src="<?php echo $img."icones/escoin.png"; ?>" alt="">
                                            <?php echo "FALTAM ".number_format($produto['valor'] - $usuario['pontos'], 0, '', '.'); ?>
                                        <?php
                                        }else{ // USUARIO POSSUI SALDO PARA A COMPRA									
                                        ?>
                                            <input type="button" value="COMPRAR" onClick="abrirEnderecos(<?php echo $produto['codigo']; ?>);">
                                        <?php	
                                        }	
                                    }	
                                }else{								
                                ?>
                                    <div class="alertaLogin">
                                        LOGUE PARA COMPRAR
                                    </div>
                                <?php
                                }
                            ?>
                            </div>
                        </div>
                    <?php
                    }
                ?>
            </div>
        </div>
        
        <?php include "../footer.php"; ?>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script type="text/javascript">
            function abrirEnderecos(produto){
                $(".modal-title").html("Selecione o endereço");
                $(".modal-body").load("ptbr/loja/loja-endereco.php");
                $(".modal-footer").html("<input type='button' value='+ NOVO ENDEREÇO' onClick='novoEndereco();' class='btn btn-dark'><input type='button' value='AVANÇAR' onClick='irCheckout();' class='btn btn-laranja'>")
                $(".modal").modal();
                $("#codProduto").val(produto);
            }
            function novoEnderecoEnviar(){
                $("#cadastroEndereco").submit();
            }
            function novoEndereco(){
                var produto = $("#codProduto").val();
                $(".modal-title").html("Cadastrar Novo Endereço")
                $(".modal-body").load('ptbr/loja/loja-endereco-novo.html');
                $(".modal-footer").html("<input type='button' class='btn btn-laranja' value='Cadastrar Endereço' onClick='novoEnderecoEnviar();'>");
                setTimeout(function(){ $("#codProduto").val(produto); }, 1500);
            }
            function irCheckout(){
                $(location).attr("href","ptbr/loja/check-out/"+$("#codProduto").val()+"/"+$(".listaEnderecos").val()+"/");
            }
        </script>
    </body>
</html>