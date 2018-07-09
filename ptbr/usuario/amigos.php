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

        <title>Amigos eSC | e-Sports Cups</title>
    </head>
    <body>
        <?php 
            include "../header.php";
            include "perfil.php";
        ?>
        <div class="container amizades">
            <?php
                if(isset($usuario['codigo']) && $usuario['codigo'] == $perfil['codigo']){
                ?>
                    <input type="text" name="busca" placeholder="E-mail, nome ou nick que deseja achar" size="50" class="campoPesquisa">
                    <input type="button" class="botaoPqLaranja" value="PESQUISAR" onClick="pesquisarAmizade();"><br><br>
                <?php
                }
            ?>
            <div class="row">
                <?php            
                    $amigos = mysqli_query($conexao, "SELECT * FROM jogador_amizades WHERE cod_jogador1 = ".$perfil['codigo']." OR cod_jogador2 = ".$perfil['codigo']." ORDER BY rand()");
                    while($amigo = mysqli_fetch_array($amigos)){
                        $um = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$amigo['cod_jogador1'].""));
                        $dois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$amigo['cod_jogador2'].""));
                        if($amigo['cod_jogador1'] == $perfil['codigo']){ // MOSTRAR JOGADOR DOIS (ESSE PERFIL QUE ENVIOU PEDIDO)
                            $dois = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$amigo['cod_jogador2'].""));
                        ?>
                            <div class="col-12 col-md-3">
                                <div class="amigo bg-laranja">
                                    <a href="ptbr/usuario/<?php echo $dois['codigo']; ?>/">
                                        <img src="http://www.esportscups.com.br/img/<?php echo $dois['foto_perfil']; ?>" alt="">
                                    </a>                                    					
                                    <?php echo "<strong>".$dois['nome']." ".$dois['sobrenome']."</strong>"; ?><br>
                                    <?php echo $dois['nick']; ?><br>
                                    <div class="acoes">
                                    <?php
                                        if(isset($usuario['codigo']) && $usuario['codigo'] == $perfil['codigo']){
                                            if($amigo['status'] == 0){
                                                echo "Convite Enviado";
                                                ?>
                                                    <div class="acao" onClick="excluirAmizade(<?php echo $um['codigo']; ?>,<?php echo $dois['codigo']; ?>);">
                                                        Cancelar
                                                    </div>
                                                <?php
                                            }else{
                                                ?>
                                                    <div class="acao" onClick="excluirAmizade(<?php echo $um['codigo']; ?>,<?php echo $dois['codigo']; ?>);">
                                                        Excluir
                                                    </div>
                                                <?php
                                            }
                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>
                            
                        <?php
                        }else{ // MOSTRAR JOGADOR UM (ENVIARAM PEDIDO PARA ESTE PERFIL)
                            $um = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$amigo['cod_jogador1'].""));
                        ?>
                            <div class="col-12 col-md-3">
                                <div class="amigo bg-laranja">
                                    <a href="ptbr/usuario/<?php echo $um['codigo']; ?>/">
                                        <img src="http://www.esportscups.com.br/img/<?php echo $um['foto_perfil']; ?>" alt="">
                                    </a>
                                    <?php echo "<strong>".$um['nome']." ".$um['sobrenome']."</strong>"; ?><br>
                                    <?php echo $um['nick']; ?><br>
                                    <div class="acoes">
                                    <?php
                                        if(isset($usuario['codigo']) && $usuario['codigo'] == $perfil['codigo']){
                                            if($amigo['status'] == 0){
                                            ?>
                                                <div class="acao" onClick="aceitarAmizade(<?php echo $um['codigo']; ?>,<?php echo $dois['codigo']; ?>);">
                                                    Aceitar
                                                </div>
                                                <div class="acao" onClick="excluirAmizade(<?php echo $um['codigo']; ?>,<?php echo $dois['codigo']; ?>);">
                                                    Recusar
                                                </div>
                                            <?php
                                            }else{
                                                echo "Desde ".date("d/m/Y", strtotime($amigo['data']));
                                                ?>
                                                    <div class="acao" onClick="excluirAmizade(<?php echo $um['codigo']; ?>,<?php echo $dois['codigo']; ?>);">
                                                        Excluir
                                                    </div>
                                                <?php
                                            }
                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        <?php	
                        }
                    }
                ?>
            </div>
        </div>
        
        <?php include "../footer.php"; ?>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script>
            function enviarPedido(jogadorUm, jogadorDois){
                $.ajax({
                    type: "POST",
                    url: "scripts/usuario.php",
                    data: "funcao=enviarPedido&jogadorUm="+jogadorUm+"&jogadorDois="+jogadorDois,
                    success: function(resultado){
                        window.location.reload();
                    }
                });
            }
            function aceitarAmizade(jogadorUm, jogadorDois){
                $.ajax({
                    type: "POST",
                    url: "scripts/usuario.php",
                    data: "funcao=aceitarAmizade&jogadorUm="+jogadorUm+"&jogadorDois="+jogadorDois,
                    success: function(resultado){
                        window.location.reload();
                    }
                });
            }
            function excluirAmizade(jogadorUm, jogadorDois){
                $.ajax({
                    type: "POST",
                    url: "scripts/usuario.php",
                    data: "funcao=excluirAmizade&jogadorUm="+jogadorUm+"&jogadorDois="+jogadorDois,
                    success: function(resultado){
                        window.location.reload();
                    }
                });
            }
            function pesquisarAmizade(){
                $.ajax({
                    type: "POST",
                    url: "scripts/usuario.php",
                    data: "funcao=pesquisarAmizade&pesquisa="+$(".campoPesquisa").val(),
                    success: function(resultado){
                        $(".amizades").html(resultado);
                    }
                });
            }
            $(function(){   
                $(".amigos").addClass("ativo"); 
            });
        </script>
    </body>
</html>