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
                        <li class="ativo">Tabelas e Partidas</li>
                    </ul>
                    <div class="row">
                        <div class="col">
                            <div class="acoesPainelOrg">
                                <div class="row centralizar">
                                    <div class="col-6 col-md-4">
                                        <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/campeonato/<?php echo $campeonato['codigo']; ?>/etapas/nova/">
                                            <div class="acao centralizar">
                                                <img src="http://www.esportscups.com.br/img/icones/+.png" alt="Partida" title="Partidas">
                                                <h2>NOVA ETAPA</h2>
                                                Criar nova etapa
                                            </div>	
                                        </a>
                                    </div>
                                    
                                <?php
                                    $pesquisaEtapas = mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_campeonato = ".$campeonato['codigo']." ORDER BY cod_etapa ASC");
                                    while($etapa = mysqli_fetch_array($pesquisaEtapas)){
                                    ?>
                                        <div class="col-6 col-md-4">
                                            <a href="<?php echo "ptbr/organizacao/".$organizacao['codigo']."/painel/campeonato/".$campeonato['codigo']."/etapa/".$etapa['cod_etapa']."/"; ?>">
                                                <div class="acao centralizar">
                                                <?php
                                                    switch($etapa['tipo_etapa']){						
                                                        case 1: // Eliminação Simples
                                                            ?>
                                                            <img src="http://www.esportscups.com.br/img/icones/eliminacao-simples.png" alt="<?php echo $etapa['nome']; ?>" title="<?php echo $etapa['nome']; ?>">
                                                            <h2><?php echo $etapa['cod_etapa'].". ".$etapa['nome']; ?></h2>							
                                                            <?php echo "Eliminação Simples";
                                                            break;
                                                        case 2: // Grupo Pontos Corridos
                                                            ?>
                                                            <img src="http://www.esportscups.com.br/img/icones/grupo-pontos-corridos.png" alt="<?php echo $etapa['nome']; ?>" title="<?php echo $etapa['nome']; ?>">
                                                            <h2><?php echo $etapa['cod_etapa'].". ".$etapa['nome']; ?></h2>							
                                                            <?php echo "Grupo Pontos Corridos";

                                                            break;
                                                        case 3: // Eliminação Dupla
                                                            ?>
                                                            <img src="http://www.esportscups.com.br/img/icones/eliminacao-dupla.png" alt="<?php echo $etapa['nome']; ?>" title="<?php echo $etapa['nome']; ?>">
                                                            <h2><?php echo $etapa['cod_etapa'].". ".$etapa['nome']; ?></h2>							
                                                            <?php echo "Eliminação Dupla";
                                                            break;
                                                        case 4: // Grupo Chaveado
                                                            ?>
                                                            <img src="http://www.esportscups.com.br/img/icones/grupo-chaveado.png" alt="<?php echo $etapa['nome']; ?>" title="<?php echo $etapa['nome']; ?>">
                                                            <h2><?php echo $etapa['cod_etapa'].". ".$etapa['nome']; ?></h2>							
                                                            <?php echo "Grupo Chaveado";
                                                            break;
                                                    }
                                                ?>
                                                </div>
                                            </a>
                                        </div>
                                        
                                    <?php
                                    }
                                ?>  
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
            function statusCampeonato(campeonato,status){
                if(status == 4){
                    var resposta = confirm("Deseja realmente EXCLUIR este campeonato? Esta ação não poderá ser desfeita! Todas as informações serão excluidas (tabelas, jogos, inscrições, etc).");		
                    if(resposta == true){
                        $.ajax({
                            type: "POST",
                            url: "scripts/status-campeonato.php",
                            data: "campeonato="+campeonato+"&status="+status,
                            success: function(resultado){                               
                                window.location = "ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/";
                            }
                        });
                    }
                }else{
                    $.ajax({
                        type: "POST",
                        url: "scripts/status-campeonato.php",
                        data: "campeonato="+campeonato+"&status="+status,
                        success: function(resultado){
                            alert(resultado);
                            window.location.reload();
                        }
                    });
                }	
            }
            function registrarVencedores(campeonato, passo, etapa){
                $.ajax({
                    type: "POST",
                    url: "scripts/registrar-vencedores.php",
                    data: "campeonato="+campeonato+"&passo="+passo+"&etapa="+etapa,
                    success: function(resultado){
                        $("#modal").html(resultado);
                        $("#modal").modal();
                    }
                });
            }
        </script>
    </body>
</html>