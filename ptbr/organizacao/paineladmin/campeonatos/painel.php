<?php
    include "../../../../enderecos.php";
    include "../../../../session.php";
    
    $organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$_GET['codigo'].""));
	$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_GET['torneio'].""));
	$totalPartidas = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_campeonato = ".$campeonato['codigo']." AND status != 3 "));
	$totalPartidasConcluidas = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 2"));

	if($campeonato['tipo_inscricao'] == 0){
		$totalInscricao = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_equipe is null AND status = 1"));
		$totalInscricaoPendente = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_equipe is null AND status = 0"));
	}else{
		$totalInscricao = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_equipe is not null AND status = 1 GROUP BY cod_equipe"));
		$totalInscricaoPendente = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_equipe is not null AND status = 0 GROUP BY cod_equipe"));
	}

	$datahora = date("Y-m-d H:i:s");

	if(isset($usuario['codigo'])){
		$pesquisaFuncao = mysqli_query($conexao, "SELECT * FROM jogador_organizacao WHERE cod_organizacao = ".$organizacao['codigo']." AND cod_jogador = ".$usuario['codigo']." ");
		$funcao = mysqli_fetch_array($pesquisaFuncao);	
		if(!isset($funcao['status'])){
			header("Location: http://www.esportscups.com.br/");	
		}
	}else{
		header("Location: http://www.esportscups.com.br/");
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
                        <li class="ativo"><?php echo $campeonato['nome']; ?></li>
                    </ul>
                    <div class="row">
                        <div class="col">
                            <div class="resumoCampPainel">
                                Resumão do torneio.
                            </div>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="acoesPainelOrg">
                                <div class="row centralizar">
                                    <div class="col-6 col-md-4">
                                        <a href="ptbr/campeonato/<?php echo $campeonato['codigo']; ?>/" target="_blank">
                                            <div class="acao">
                                                <img src="img/icones/lupa.png">
                                                <h3>Visualizar</h3>
                                                Como vêem seu torneio.
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/campeonato/<?php echo $campeonato['codigo']; ?>/editar/">
                                            <div class="acao">
                                                <img src="img/icones/configuracoes.png">
                                                <h3>Editar</h3>
                                                Edite seu torneio.
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                        $pesqPremiacao = mysqli_query($conexao, "SELECT * FROM campeonato_premiacao WHERE cod_campeonato = ".$campeonato['codigo']." ");
                                        if(mysqli_num_rows($pesqPremiacao) == 0){
                                        ?>
                                            <div class="col-6 col-md-4">
                                                <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/campeonato/<?php echo $campeonato['codigo']; ?>/lancar-premiacao/">
                                                    <div class="acao">
                                                        <i class="fas fa-dollar-sign" style="font-size: 60px; margin: 20px 0px;"></i>
                                                        <h3>Premiação</h3>
                                                        Configura a premiação automática
                                                    </div>
                                                </a>
                                            </div>
                                        <?php
                                        }
                                    ?>
                                    
                                    <div class="col-6 col-md-4">
                                        <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/campeonato/<?php echo $campeonato['codigo']; ?>/etapas/">				
                                            <div class="acao">
                                                <img src="img/icones/partidas.png" alt="Partida" title="Partidas">
                                                <h2>Partidas</h2>
                                                <?php
                                                    if($totalPartidas != 0){
                                                        echo $totalPartidasConcluidas." / ".$totalPartidas;
                                                    }else{
                                                        echo "Nenhuma partida encontrada";
                                                    }
                                                ?>
                                            </div>
                                        </a>
                                    </div>
                                    
                                    <?php
                                        if($campeonato['status'] != 0){ // INSCRIÇÕES JÁ FORAM ENCERRADAS
                                            if($campeonato['status'] == 1){ // CAMPEONATO EM ANDAMENTO
                                            ?>
                                                <div class="col-6 col-md-4">
                                                    <div class="acao" onClick="registrarVencedores(<?php echo $campeonato['codigo']; ?>, '1', '0')">
                                                        <img src="img/icones/finalizar.png" alt="Finalizar Competição" title="Finalização Competição">
                                                    <h2>Finalizar</h2>
                                                    Registrar Vencedores!
                                                    </div>	
                                                </div>
                                            <?php
                                            }elseif($campeonato['status'] == 2){ // CAMPEONATO CONCLUÍDO

                                            }else{ // CAMPEONATO CANCELADO

                                            }
                                        }else{
                                        ?>
                                            <div class="col-6 col-md-4">
                                                <div class="acao" onClick="statusCampeonato(<?php echo $campeonato['codigo'].", 1"; ?>)">
                                                    <img src="img/icones/encerrarInscricoes.png" alt="Partida" title="Partidas">
                                                    <h2>Começar</h2>
                                                    Tudo pronto? Então está na hora.
                                                </div>	
                                            </div>						
                                        <?php
                                        }
                                    ?>
                                    <div class="col-6 col-md-4">
                                        <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/campeonato/<?php echo $campeonato['codigo']; ?>/inscricoes/">
                                            <div class="acao">
                                                <img src="img/icones/inscricoes.png">
                                                <h3>Inscrições</h3>
                                                <?php echo $totalInscricaoPendente." pendentes"; ?>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="acao" onClick="gerarNotificacao(<?php echo $campeonato['codigo']; ?>)">
                                            <img src="img/icones/artigos.png">
                                            <h3>Notificação</h3>
                                            Emita notificações para os inscritos.
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="acao" onClick="statusCampeonato(<?php echo $campeonato['codigo'].", 4"; ?>)">
                                            <img src="img/icones/recusada.png">
                                            <h3>Excluir</h3>
                                            Excluir torneio.
                                        </div>
                                    </div>
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
            function gerarNotificacao(campeonato){
                $(".modal-title").html("Gerar notificação para Inscritos");
                $(".modal-body").load("ptbr/organizacao/paineladmin/campeonatos/nova-notificacao.php?codCampeonato=<?php echo $campeonato['codigo']; ?>&codOrganizacao=<?php echo $organizacao['codigo']; ?>");
                $(".modal-footer").html("");
                $(".modal").modal();
            }
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
                        $(".modal-title").html("Informe os Campeões da competição.");
                        $(".modal-body").html(resultado);
                        $(".modal-footer").html("");
                        $(".modal").modal();
                    }
                });
            }
            $(document).ready(function(){

            });
        </script>
    </body>
</html>