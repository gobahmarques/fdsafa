<?php
    include "../../enderecos.php";
    include "../../session.php";

    $campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_GET['codigo'].""));
	$organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$campeonato['cod_organizacao'].""));
	$jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogos WHERE codigo = ".$campeonato['cod_jogo']." "));

	$datahora = date("Y-m-d H:i:s");

	if(isset($usuario['codigo'])){
		$pesquisaFuncao = mysqli_query($conexao, "SELECT * FROM jogador_organizacao WHERE cod_organizacao = ".$organizacao['codigo']." AND cod_jogador = ".$usuario['codigo']." ");
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

        <title>Resultado Final <?php echo $campeonato['nome']; ?> | e-Sports Cups</title>
    </head>
    <body>
        <?php include "../header.php"; ?>
        <?php include "campeonato-perfil.php"; ?>
        
        <div class="container">
            <div class="row">
            <?php
                $colocados = mysqli_query($conexao, "SELECT * FROM campeonato_colocacao WHERE cod_campeonato = ".$campeonato['codigo']." ORDER BY posicao ASC");
                while($posicao = mysqli_fetch_array($colocados)){
                    if($posicao['cod_equipe'] == NULL){ // INSCRIÇÕES SOLO
                        $inscrito = mysqli_fetch_array(mysqli_query($conexao, "SELECT conta FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$posicao['cod_jogador']." "));
                        $jogador = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$posicao['cod_jogador']." "));
                        ?>
                            
                            <div class="col-12 col-md-3">
                                <div class="row-fluid inscrito no-gutters <?php echo "posicao".$posicao['posicao']; ?>">
                                    <div class="col-4 col-md-4 float-left">
                                        <a href="<?php echo "ptbr/usuario/".$jogador['codigo']."/"; ?>">
                                            <img src="http://www.esportscups.com.br/img/<?php echo $jogador['foto_perfil'];  ?>" alt="">
                                        </a>
                                    </div>
                                    <div class="col-8 col-md-8 float-left">
                                        <?php echo $inscrito['conta']; ?><br>
                                    <?php echo $posicao['posicao']."º Lugar"; ?>
                                    </div>
                                </div>  
                            </div>
                        <?php
                    }else{
                        $equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$posicao['cod_equipe'].""));
                        ?>
                            <div class="col-12 col-md-3">
                                <div class="row-fluid inscrito no-gutters <?php echo "posicao".$posicao['posicao']; ?>">
                                    <div class="col-4 col-md-4 float-left">
                                        <a href="<?php echo "ptbr/equipe/".$equipe['codigo']."/"; ?>">
                                            <img src="http://www.esportscups.com.br/img/<?php echo $equipe['logo'];  ?>" alt="">
                                        </a>
                                    </div>
                                    <div class="col-8 col-md-8 float-left">
                                        <?php echo $equipe['nome']; ?><br>
                                        <?php echo $equipe['tag']; ?>
                                    </div>
                                </div>  
                            </div>                           
                        <?php
                    }
                }
            ?>
            </div>
            <div class="row">
                <div class="col-12 col-md-12">
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- Barra lateral página de Artigo -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-3038725769937948"
                         data-ad-slot="7294511218"
                         data-ad-format="auto"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div>
        </div>

        <?php include "../footer.php"; ?>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script>
            jQuery(function($){
                $(".premiados").addClass("ativo");
                $(".menuPrincipalHeader .campeonatos").addClass("ativo");
            });
        </script>
    </body>
</html>