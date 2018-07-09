<?php
    include "../../enderecos.php";
    include "../../session.php";

    $campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_GET['codigo'].""));
	$organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$campeonato['cod_organizacao'].""));
	$jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogos WHERE codigo = ".$campeonato['cod_jogo']." "));
	$etapaInfos = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_campeonato = ".$_GET['codigo']." AND cod_etapa = ".$_GET['etapa'].""));
	$grupo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa_grupo WHERE codigo = ".$_GET['grupo']." "));

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

        <title><?php echo $grupo['nome']; ?> - <?php echo $campeonato['nome']; ?> | e-Sports Cups</title>
    </head>
    <body>
        <?php include "../header.php"; ?>
        <?php include "campeonato-perfil.php"; ?>
        
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12">
                <h2 class="tituloIndex"><?php echo $etapaInfos['cod_etapa'].". ".$etapaInfos['nome']; ?></h2>
                <div class="detalheTituloIndex"></div>
                </div>
                
                <?php
                    include "../../scripts/carregar-grupo.php";
                    switch($etapaInfos['tipo_etapa']){
                        case 1: // ELIMINAÇAO SIMPLES
                            break;
                        case 2: // GRUPO PONTOS CORRIDOS
                            pontosCorridos($grupo, $etapaInfos, $campeonato);
                            break;
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
                $(".tabelas").addClass("ativo");
                $(".menuPrincipalHeader .campeonatos").addClass("ativo");
                <?php
                    if($campeonato['precheckin'] != 0){
                        $dataFinal = date("Y-m-d H:i:s", strtotime("-".$campeonato['precheckin']."minutes", strtotime($campeonato['inicio'])));				
                    ?>
                        var ano = <?php echo date("Y",strtotime($dataFinal)); ?>;
                        var mes = <?php echo date("m",strtotime($dataFinal)); ?>;
                        var dia = <?php echo date("d",strtotime($dataFinal)); ?>;
                        var hora = <?php echo date("H",strtotime($dataFinal)); ?>;
                        var minuto = <?php echo date("i",strtotime($dataFinal)); ?>;
                        var segundo = <?php echo date("s",strtotime($dataFinal)); ?>;
                        var dataFinal = new Date(ano, mes-1, dia, hora, minuto, segundo, 0);

                        var ano = <?php echo date("Y",strtotime($datahora)); ?>;
                        var mes = <?php echo date("m",strtotime($datahora)); ?>;
                        var dia = <?php echo date("d",strtotime($datahora)); ?>;
                        var hora = <?php echo date("H",strtotime($datahora)); ?>;
                        var minuto = <?php echo date("i",strtotime($datahora)); ?>;
                        var segundo = <?php echo date("s",strtotime($datahora)); ?>;
                        var dataComeco = new Date(ano, mes-1, dia, hora, minuto, segundo, 0);
                    <?php
                    }else{
                        $dataFinal = date("Y-m-d H:i:s", strtotime($campeonato['inicio']));
                    ?>
                        var ano = <?php echo date("Y",strtotime($dataFinal)); ?>;
                        var mes = <?php echo date("m",strtotime($dataFinal)); ?>;
                        var dia = <?php echo date("d",strtotime($dataFinal)); ?>;
                        var hora = <?php echo date("H",strtotime($dataFinal)); ?>;
                        var minuto = <?php echo date("i",strtotime($dataFinal)); ?>;
                        var segundo = <?php echo date("s",strtotime($dataFinal)); ?>;
                        var dataFinal = new Date(ano, mes-1, dia, hora, minuto, segundo, 0);

                        var ano = <?php echo date("Y",strtotime($datahora)); ?>;
                        var mes = <?php echo date("m",strtotime($datahora)); ?>;
                        var dia = <?php echo date("d",strtotime($datahora)); ?>;
                        var hora = <?php echo date("H",strtotime($datahora)); ?>;
                        var minuto = <?php echo date("i",strtotime($datahora)); ?>;
                        var segundo = <?php echo date("s",strtotime($datahora)); ?>;
                        var dataComeco = new Date(ano, mes-1, dia, hora, minuto, segundo, 0);
                    <?php
                    }
                ?>
                $("#clock").countdown({until: dataFinal, format:'DHMS'});
            });
        </script>
        
    </body>
</html>