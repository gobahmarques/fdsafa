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
        <meta property="og:url"           content="https://www.esportscups.com.br/ptbr/campeonato/<?php echo $campeonato['codigo']; ?>/" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="<?php echo $campeonato['nome']." | eSports Cups"; ?>" />
        <meta property="og:description"   content="<?php echo $campeonato['descricao']; ?>" />
        <meta property="og:image"         content="https://www.esportscups.com.br/img/campeonatos/<?php echo $campeonato['codigo']; ?>/logo.png" />
        <meta property="og:image:width" content="50">
        <meta property="og:image:height" content="50">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.css">
        <link rel="stylesheet" href="<?php echo $css; ?>esportscups.css">

        <title><?php echo $campeonato['nome']; ?> | e-Sports Cups</title>
    </head>
    <body>
        <?php include "../header.php"; ?>
        <?php include "campeonato-perfil.php"; ?>
        
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-7">
                    <div class="row">
                        <div class="col-12 col-md-12 textosCampeonato">
                            <h2>Descrição</h2>                        
                            <?php echo $campeonato['descricao']; ?>	
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12 col-md-12 textosCampeonato">
                            <h2>Regulamento</h2>                        
                            <?php echo $campeonato['regulamento']; ?>	
                        </div>	
                    </div>
                </div>
                <div class="col-12 col-md-1">
                    
                </div>
                <div class="col-12 col-md-4">
                    <div class="row">
                        <div class="col-12 col-md-12 textosCampeonato">
                            <h2>Etapas</h2>                        
                            <?php
                                $etapas = mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_campeonato = ".$campeonato['codigo']." ORDER BY cod_etapa");
                                if(mysqli_num_rows($etapas) == 0){
                                    echo "A serem definidas";
                                }else{
                                    while($etapa = mysqli_fetch_array($etapas)){
                                        echo $etapa['cod_etapa'].". ".$etapa['nome']." | ";
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12 col-md-12 textosCampeonato">
                            <h2>Fuso Horário</h2>                        
                            <?php echo $campeonato['fuso_horario']; ?>	
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12 col-md-12 textosCampeonato">
                            <h2>Cronograma</h2>                        
                            <?php echo $campeonato['cronograma']; ?>	
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12 col-md-12 textosCampeonato">
                            <h2>Premiação</h2>                        
                            <?php echo $campeonato['premiacao']; ?>	
                        </div>
                    </div>
                </div>
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
                $(".informacoes").addClass("ativo");
                $(".menuPrincipalHeader .campeonatos").addClass("ativo");
            });
        </script>
    </body>
</html>