<?php
    include "../../enderecos.php";
    include "../../session.php";

    $equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$_GET['codequipe'].""));
	$jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogos WHERE codigo = ".$equipe['cod_jogo']." "));
    $campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome FROM campeonato WHERE codigo = ".$_GET['codigo'].""));

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

        <title>Line-up da Equipe <?php echo $equipe['nome']; ?> em <?php echo $campeonato['nome']; ?> | e-Sports Cups</title>
    </head>
    <body>
        <?php include "../header.php"; ?>
        <div class="row-fluid centralizar text-white infoLineup" style="padding: 10px; background: rgba(0,0,0,0.5);">
            Line-up da Equipe <span><?php echo $equipe['nome']; ?></span> inscrita no campeonato <span><?php echo $campeonato['nome']; ?></span>
        </div>
        <div class="bgEquipe <?php echo $jogo['background']; ?> centralizar">
            <br>
            <?php
                if($equipe['logo'] != NULL){
                    echo "<img class='logoEquipe' src='http://www.esportscups.com.br/img/".$equipe['logo']."' title='".$equipe['nome']."' alt='".$equipe['nome']."'><br><br>";
                }else{
                    echo "<h1>".$equipe['nome']."</h1>";
                }
                echo $equipe['nome']." - ".$jogo['nome']."";
                $integrantes = mysqli_query($conexao, "
                    SELECT * FROM campeonato_lineup
                    INNER JOIN jogador ON jogador.codigo = campeonato_lineup.cod_jogador
                    WHERE campeonato_lineup.cod_equipe = ".$equipe['codigo']."
                    AND campeonato_lineup.cod_campeonato = ".$_GET['codigo']."
                    ORDER BY jogador.nick
                ");
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
                                    if($integrante['capitao'] == 1){
                                        echo "<img class='capitao' src='http://www.esportscups.com.br/img/capitao.png' title='' alt=''>";
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
        <?php include "../footer.php"; ?>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
    </body>
</html>