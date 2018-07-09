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

        <title>Equipes eSports | e-Sports Cups</title>
    </head>
    <body>
        <?php 
            include "../header.php";
            include "perfil.php";
            $equipes = mysqli_query($conexao, "SELECT jogador_equipe.*, equipe.*, jogos.nome AS nomeJogo FROM jogador_equipe
	INNER JOIN equipe ON equipe.codigo = jogador_equipe.cod_equipe
	INNER JOIN jogos ON jogos.codigo = equipe.cod_jogo
	WHERE jogador_equipe.cod_jogador = ".$perfil['codigo']."");
        ?>
        <div class="container">
            <div class="row">
            <?php
                if(mysqli_num_rows($equipes) == 0){ // NÃO POSSUI NENHUMA EQUIPE
                    if(isset($usuario['codigo']) && $usuario['codigo'] == $perfil['codigo']){
                    ?>
                        <div class="centralizar">
                            <h1>CRIE UMA EQUIPE</h1>
                            Você não faz parte de nenhuma equipe, ainda.<br><br>
                            Crie sua própria equipe e chame seus amigos para treinar e competir. <br>
                            Atingir o topo só depende de vocês. <br><br>
                            <div class="barraBotoes">
                                <input type="button" value="CRIAR EQUIPE" class="botaoPqLaranja" onClick="criarEquipe();">
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
                }else{ // POSSUI EQUIPE
                    ?>
                        <div class="col-12 col-md-12">
                            <input type="button" value="+ Novo Time" class="btn btn-dark" onClick="criarEquipe();">
                        </div>
                        <br><br>
                    <?php
                    while($equipe = mysqli_fetch_array($equipes)){
                    ?>
                        <div class="col-12 col-md-3">
                            
                                <div class="amigo">
                                    <a href="ptbr/time/<?php echo $equipe['codigo']; ?>/"><img src="img/<?php echo $equipe['logo']; ?>" alt=""></a>
                                    <?php echo "<hmysq4>".$equipe['nome']."</h4>"; ?>
                                    <?php echo $equipe['nomeJogo']; ?>
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
            function criarEquipe(){
                $(".modal-title").html("Crie seu Time e conquiste o cenário!");
                $(".modal-body").load("ptbr/usuario/novo-time.php");
                $(".modal-footer").html("");
                $(".modal").modal();
            }
            function validarEquipe(){
                $.ajax({
                    type: "POST",
                    url: "scripts/validar-equipe.php",
                    data: $("#formCriarEquipe").serialize(),
                    success: function(resultado){
                        if(resultado != ""){
                            $(".status").html(resultado);
                            $(".status").style("display", "block");
                            return false;
                        }else{
                            alert(resultado);
                            $(".status").html(resultado);
                            $(".status").style("display", "block");
                            // location.reload();
                            return true;
                        }				
                    }
                });
                return false;
            }
            $(function(){   
                $(".times").addClass("ativo"); 
            });
        </script>
    </body>
</html>