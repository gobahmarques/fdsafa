<?php
    include "../../enderecos.php";
    include "../../session.php";

    $equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$_GET['codigo'].""));
	$jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogos WHERE codigo = ".$equipe['cod_jogo']." "));

	if(isset($usuario['codigo'])){
		$pesquisaFuncao = mysqli_query($conexao, "SELECT * FROM jogador_equipe WHERE cod_equipe = ".$equipe['codigo']." AND cod_jogador = ".$usuario['codigo']." ");
		$funcao = mysqli_fetch_array($pesquisaFuncao);	
	}
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

        <title><?php echo $equipe['nome']; ?> - <?php echo $jogo['nome']; ?> | e-Sports Cups</title>
    </head>
    <body>
        <?php include "../header.php"; ?>
        
        <div class="bgEquipe <?php echo $jogo['background']; ?> centralizar">
            <br>
            <?php
                if($equipe['logo'] != NULL){
                    echo "<img class='logoEquipe' src='img/".$equipe['logo']."' title='".$equipe['nome']."' alt='".$equipe['nome']."'><br><br>";
                }else{
                    echo "<h1>".$equipe['nome']."</h1>";
                }
                echo $equipe['nome']." - ".$jogo['nome']."";
                $integrantes = mysqli_query($conexao, "SELECT *, jogador_equipe.status AS poder FROM jogador_equipe
                INNER JOIN jogador ON jogador.codigo = jogador_equipe.cod_jogador
                WHERE jogador_equipe.cod_equipe = ".$equipe['codigo']."
                ORDER BY jogador.nick");
                if(mysqli_num_rows($integrantes) != 0){
                ?>
                    <ul class="integrantes">
                    <?php
                        while($integrante = mysqli_fetch_array($integrantes)){
                        ?>
                            <li>							
                                <img class="fotoIntegrante" src="http://www.esportscups.com.br/img/<?php echo $integrante['foto_perfil']; ?>" alt="">
                                <h2><?php echo $integrante['nick']; ?>
                                <?php 
                                    if($integrante['poder'] == 2){
                                        echo "<img class='capitao' src='img/icones/capitao.png' title='' alt=''>";
                                    }
                                    echo "</h2>".$integrante['nome']." ".$integrante['sobrenome'];
                                ?>
                            </li>
                        <?php
                        }
                    ?>
                    </ul>
                <?php
                }
            ?>
        </div>
        
        <?php
            if($funcao['status'] == 2){
                include "painel-capitao.php";
            }
        ?>
        
        <?php include "../footer.php"; ?>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script type="text/javascript">
            function botoes(funcao){
                $.ajax({
                    type: "POST",
                    url: "scripts/funcoes-equipe.php",
                    data: "form="+funcao+"&codequipe=<?php echo $equipe['codigo']; ?>",
                    success: function(resultado){                                           switch(funcao){
                            case '1':
                                $(".modal-title").html("<h2>Adicionar Jogador</h2>");
                                break;
                            case '2':
                                $(".modal-title").html("<h2>Remover Jogador</h2>");
                                break;
                            case '3':
                                $(".modal-title").html("<h2>Enviar EMBLEMA da Equipe</h2>");
                                break;
                        }    
                        $(".modal-body").html(resultado);
                        $(".modal-footer").html("");
                        $(".modal").modal();
                    }
                });
            }
        </script>
    </body>
</html>