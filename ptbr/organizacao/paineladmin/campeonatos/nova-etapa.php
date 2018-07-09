<?php
    include "../../../../enderecos.php";
    include "../../../../session.php";
    
    $organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$_GET['codigo'].""));
	$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_GET['torneio'].""));
	$datahora = date("Y-m-d H:i:s");

	if(isset($usuario['codigo'])){
		$pesquisaFuncao = mysqli_query($conexao, "SELECT * FROM jogador_organizacao WHERE cod_organizacao = ".$organizacao['codigo']." AND cod_jogador = ".$usuario['codigo']." ");
		$funcao = mysqli_fetch_array($pesquisaFuncao);	
		if(!isset($funcao['status']) || $campeonato['status'] == 2){
			header("Location: ../");	
		}
	}else{
		header("Location: organizacao/../");
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

        <title>Artigos eSC | e-Sports Cups</title>
    </head>
    <body>
        <?php include "../../../header.php"; ?>
        
        <br>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3">
                    <?php
                        include "../perfil.php";
                    ?>
                </div>
                <div class="col-12 col-md-9">
                    <ul class="navegacaoPainel">
                        <li><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/"><?php echo $organizacao['nome']; ?></a></li>
                        <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/"><li >Campeonatos</li></a>
                        <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/campeonato/<?php echo $campeonato['codigo']; ?>/"><li><?php echo $campeonato['nome']; ?></li></a>
                        <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/campeonato/<?php echo $campeonato['codigo']; ?>/etapas/"><li>Tabelas e Partidas</li></a>
                        <li class="ativo">Nova Etapa</li>
                    </ul>
                    <div class="row">
                        <div class="col">
                            <div class="acoesPainelOrg">
                                <div class="row centralizar">
                                    <div class="col-6 col-md-4">
                                        <div class="acao centralizar" onClick="abrirForm(1);">
                                            <img src="img/icones/eliminacao-simples.png" alt="Partida" title="Partidas">
                                            <h2>Eliminação Simples</h2>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="acao centralizar" onClick="abrirForm(3);">
                                            <img src="img/icones/eliminacao-dupla.png" alt="Partida" title="Partidas">
                                            <h2>Eliminação Dupla</h2>
                                        </div>	
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="acao centralizar" onClick="abrirForm(2);">
                                            <img src="img/icones/grupo-pontos-corridos.png" alt="Partida" title="Partidas">
                                            <h2>Pontos Corridos</h2>
                                        </div>
                                    </div>
                                    <!--
                                    <div class="col-6 col-md-4">
                                        <div class="acao centralizar">
                                            <img src="img/icones/grupo-chaveado.png" alt="Partida" title="Partidas">
                                            <h2>Grupo Chaveado</h2>
                                        </div>
                                    </div>
                                    -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>

        <?php include "../../../footer.php"; ?>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script type="text/javascript">
            function abrirForm(tipo){
                switch(tipo){
                    case 1: // ELIM. SIMPLES
                        $(".modal-title").html("Criação de etapa Eliminação Simples");
                        $(".modal-body").load("ptbr/organizacao/paineladmin/campeonatos/nova-elim-simples.php");
                        $(".modal-footer").html("");
                        $(".modal").modal();
                        setTimeout(function(){$("#codCampeonato").val("<?php echo $campeonato['codigo']; ?>");}, 1500);
                        break;
                    case 2: // PONTOS CORRIDOS
                        $(".modal-title").html("Criação de etapa Pontos Corridos");
                        $(".modal-body").load("ptbr/organizacao/paineladmin/campeonatos/nova-pontos-corridos.php");
                        $(".modal-footer").html("");
                        $(".modal").modal();
                        
                        setTimeout(function(){$("#codCampeonato").val("<?php echo $campeonato['codigo']; ?>");}, 1500);
                        break;
                    case 3: // ELIM. DUPLA
                        $(".modal-title").html("Criação de etapa Eliminação Dupla");
                        $(".modal-body").load("ptbr/organizacao/paineladmin/campeonatos/nova-elim-dupla.php");
                        $(".modal-footer").html("");
                        $(".modal").modal();
                        
                        $("#modal").load("organizacao-etapa-elim-dupla.php");
                        $("#modal").modal();
                        setTimeout(function(){$("#codCampeonato").val("<?php echo $campeonato['codigo']; ?>");}, 1500);
                        break;
                }
            }
            function elimSimples(){

            }
            jQuery(function($){
                $(".torneiosAtivos").addClass("ativo");
                $(".torneiosAtivos").html('<?php echo $campeonato['nome']; ?>');
            });
            $(document).ready(function(){
            $('table tr').click(function(){
                window.location = $(this).data('url');
                returnfalse;
            });

        });
        </script>
    </body>
</html>