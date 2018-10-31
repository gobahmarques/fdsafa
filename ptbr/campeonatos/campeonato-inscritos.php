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

        <title>Participantes <?php echo $campeonato['nome']; ?> | e-Sports Cups</title>
    </head>
    <body>
        <?php include "../header.php"; ?>
        <?php include "campeonato-perfil.php"; ?>
        
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12">
                    <h2 class="tituloIndex">Inscrições <strong>Confirmadas</strong></h2>
                    <div class="detalheTituloIndex"></div>
                </div>
            <?php
                if($campeonato['tipo_inscricao'] == 0){ // INSCRIÇÕES SOLO			
                    $pesquisaInscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_equipe is null AND status = 1 ORDER BY conta ASC");
                    while($inscricao = mysqli_fetch_array($pesquisaInscricoes)){ // LOOP PARA MOSTRAR TODAS AS INSCRIÇÕES
                        
                        $buscarDraft = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_draft WHERE cod_campeonato = ".$inscricao['cod_campeonato']." AND cod_jogador = ".$inscricao['cod_jogador'].""));
                        
                        $inscrito = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$inscricao['cod_jogador'].""));
                        $lvlInscrito = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM gm_jogador_level WHERE cod_jogador = ".$inscricao['cod_jogador'].""));
                    ?>
                        <div class="col-6 col-md-3">
                            <div class="row-fluid inscrito no-gutters" onClick="abrirInscricao(<?php echo $inscricao['cod_campeonato']; ?>, <?php echo $inscricao['cod_jogador']; ?>);">
                                <div class="col-4 col-md-4 float-left">
                                    <img src="http://www.esportscups.com.br/img/<?php echo $inscrito['foto_perfil'];  ?>" alt="">
                                </div>
                                <div class="col-8 col-md-8 float-left">
                                    <?php echo $inscricao['conta']; ?><br>
                                    Lvl. <?php echo $lvlInscrito['level']; ?>
                                </div>
                            </div>  
                        </div>
                    <?php
                    }
                    ?>
                        <div class="col-12 col-md-12">
                            <?php
                                if($campeonato['precheckin'] == 0){
                                    echo "<h2 class='tituloIndex'>Aguardando <strong>Confirmação</strong></h2>";
                                }else{
                                    echo "<h2 class='tituloIndex'>Check-in <strong>Pendente</strong></h2>";
                                }
                            ?>                    
                            <div class="detalheTituloIndex"></div>
                        </div>
                    <?php
                    
                    
                    $pesquisaInscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_equipe is null AND status = 0 ORDER BY conta ASC");
                    while($inscricao = mysqli_fetch_array($pesquisaInscricoes)){ // LOOP PARA MOSTRAR TODAS AS INSCRIÇÕES
                        $inscrito = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$inscricao['cod_jogador'].""));
                        $lvlInscrito = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM gm_jogador_level WHERE cod_jogador = ".$inscricao['cod_jogador'].""));
                    ?>
                        <div class="col-6 col-md-3">
                            <div class="row-fluid inscrito no-gutters" onClick="abrirInscricao(<?php echo $inscricao['cod_campeonato']; ?>, <?php echo $inscricao['cod_jogador']; ?>);">
                                <div class="col-4 col-md-4 float-left">
                                    <img src="http://www.esportscups.com.br/img/<?php echo $inscrito['foto_perfil'];  ?>" alt="">
                                </div>
                                <div class="col-8 col-md-8 float-left">
                                    <?php echo $inscricao['conta']; ?><br>
                                    Lvl. <?php echo $lvlInscrito['level']; ?>
                                </div>
                            </div>  
                        </div>
                    <?php
                    }
                }else{ // INSCRIÇÕES DE EQUIPES
                    $pesquisaInscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_equipe is not null AND status = 1 GROUP BY cod_equipe");
                    while($inscricao = mysqli_fetch_array($pesquisaInscricoes)){ // LOOP PARA MOSTRAR TODAS AS INSCRIÇÕES
                        $equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$inscricao['cod_equipe'].""));
                    ?>
                        <div class="col-6 col-md-3">
                            <div class="row-fluid inscrito no-gutters">
                                <div class="col-4 col-md-4 float-left">
                                    <a href="ptbr/campeonato/<?php echo $campeonato['codigo']; ?>/lineup/<?php echo $inscricao['cod_equipe']; ?>/"><img src="http://www.esportscups.com.br/img/<?php echo $equipe['logo'];  ?>" alt=""></a>
                                </div>
                                <div class="col-8 col-md-8 float-left">
                                    <?php echo $equipe['nome']; ?><br>
                                    <?php echo $equipe['tag']; ?>
                                </div>
                            </div>  
                        </div>
                    <?php
                    }
                    if($campeonato['precheckin'] == 0){
                    ?>
                        <div class="col-12 col-md-12">
                            <h2 class="tituloIndex">Aguardando <strong>Confirmação</strong></h2>
                            <div class="detalheTituloIndex"></div>
                        </div>
                    <?php
                    }else{
                    ?>
                        <div class="col-12 col-md-12">
                            <h2 class="tituloIndex">Check-in <strong>Pendente</strong></h2>
                            <div class="detalheTituloIndex"></div>
                        </div>
                    <?php
                    }
                    $pesquisaInscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 0 AND cod_equipe is not null");
                    while($inscricao = mysqli_fetch_array($pesquisaInscricoes)){ // LOOP PARA MOSTRAR TODAS AS INSCRIÇÕES
                        $equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$inscricao['cod_equipe'].""));
                    ?>
                        <div class="col-6 col-md-3">
                            <div class="row-fluid inscrito no-gutters">
                                <div class="col-4 col-md-4 float-left">
                                    <a href="ptbr/campeonato/<?php echo $campeonato['codigo']; ?>/lineup/<?php echo $inscricao['cod_equipe']; ?>/"><img src="http://www.esportscups.com.br/img/<?php echo $equipe['logo'];  ?>" alt=""></a>
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
            function abrirInscricao(torneio, jogador){
                jQuery.ajax({
                    type: "POST",
                    url: "scripts/campeonato/resumo-inscricao.php",
                    data: "codjogador="+jogador+"&codcampeonato="+torneio,
                    success: function(data){
                        $(".modal-title").html("Notificações Recentes");
                        $(".modal-body").html(data);
                        $(".modal-footer").html("");
                        $(".modal").modal();
                    }
                });
            }
            jQuery(function($){
                $(".participantes").addClass("ativo");
                $(".menuPrincipalHeader .campeonatos").addClass("ativo");
            });
        </script>
        
    </body>
</html>