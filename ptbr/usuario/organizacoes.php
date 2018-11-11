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

        <title>Sincronizações | e-Sports Cups</title>
    </head>
    <body>
        <?php 
            include "../header.php";
            include "perfil.php";
            if(!isset($usuario['codigo']) || $usuario['codigo'] != $perfil['codigo']){
                header("Location: ../../../");
            }else{
                if($usuario['codigo'] != $perfil['codigo']){
                    header("Location: ../../../");
                }
            }
            $organizacoes = mysqli_query($conexao, "
                SELECT * FROM jogador_organizacao
                INNER JOIN organizacao ON organizacao.codigo = jogador_organizacao.cod_organizacao
                WHERE jogador_organizacao.cod_jogador = ".$usuario['codigo']."                
            ");
        ?>
        
        <div class="container">
            <div class="row">
            <?php
                if(mysqli_num_rows($organizacoes) == 0){ // NÃO POSSUI NENHUMA ORGANIZAÇÃO
                    if(isset($usuario['codigo']) && $usuario['codigo'] == $perfil['codigo']){
                    ?>
                        <div class="centralizar">
                            <h1>CRIE SUA ORGANIZAÇÃO</h1>
                            Você ainda não tem possui e nem faz parte de <br>
                            nenhuma Organização de Esportes Eletrônicos. <br><br>
                            Crie agora mesmo sua Organização e comece a contribuir <br>
                            com o cenário realizando competições de Alto Nível.
                            
                            <div class="barraBotoes">
                                <input type="button" value="CRIAR ORGANIZAÇÃO" class="botaoPqLaranja" onClick="criarOrganizacao();">
                            </div>
                        </div>
                    <?php	
                    }else{
                    ?>
                        <div class="centralizar">
                            <h2>Ops! Nenhuma equipe encontrada.</h2>
                            Este jogador não faz parte de nenhuma Lineup.
                        </div>
                    <?php
                    }			
                }else{ // POSSUI ORGANIZAÇÃO
                    ?>
                        <div class="col-12 col-md-12">
                            <input type="button" value="+ Nova Organização" class="btn btn-dark" onClick="criarOrganizacao();">
                        </div>
                        <br><br>
                    <?php
                    while($organizacao = mysqli_fetch_array($organizacoes)){
                        $totalTorneios = mysqli_num_rows(mysqli_query($conexao, "
                            SELECT codigo FROM campeonato
                            WHERE cod_organizacao = ".$organizacao['codigo']."
                        "));
                    ?>
                        <div class="col-12 col-md-4">
                            
                                <div class="amigo">
                                    <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/"><img src="<?php echo $img.$organizacao['perfil']; ?>" alt=""></a>
                                    <?php echo "<h4>".$organizacao['nome']."</h4>"; ?>
                                    Torneios Criados: <?php echo $totalTorneios; ?>
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
            function criarOrganizacao(){
                $(".modal-title").html("Crie sua organização");
                $(".modal-body").load("ptbr/usuario/nova-organizacao.php");
                $(".modal-footer").html("");
                $(".modal").modal();   
            }
            function validarOrganizacao(){
                $.ajax({
                    type: "POST",
                    url: "scripts/validar-organizacao.php",
                    data: $("#formCriarOrganizacao").serialize(),
                    success: function(resultado){
                        if(resultado != ""){
                            $(".status").html(resultado);
                            $(".status").style("display", "block");
                            return false;
                        }else{
                            $(".status").html(resultado);
                            $(".status").style("display", "block");
                            location.reload();
                            return true;
                        }				
                    }
                });
                return false;
            }
            $(function(){               
                $(".organizacoes").addClass("ativo"); 
            });
        </script>
    </body>
</html>