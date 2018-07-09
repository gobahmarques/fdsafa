<?php
    include "../../../../enderecos.php";
    include "../../../../session.php";
    $organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$_GET['codigo'].""));
    $liga = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM liga WHERE codigo = ".$_GET['liga']." "));
    $divisao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM liga_divisao WHERE codigo = ".$_GET['divisao']." "));

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
                        <li><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/ligas/">Ligas</a></li>
                        <li><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/liga/<?php echo $liga['codigo']; ?>/"><?php echo $liga['nome']; ?></a></li>
                        <li><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/liga/<?php echo $liga['codigo']; ?>/divisao/<?php echo $divisao['codigo']; ?>/"><?php echo $divisao['nome']; ?></a></li>
                        <li class="ativo">Torneios</li>    
                    </ul>
                    <div class="row">
                        <div class="col">
                            <div class="acoesPainelOrg">
                                <div class="row centralizar">    
                                <?php
                                    $pesquisaTorneios = mysqli_query($conexao, "SELECT * FROM campeonato WHERE cod_organizacao = ".$organizacao['codigo']." AND status != 2 AND cod_divisao = ".$divisao['codigo']." ORDER BY inicio ASC");	
                                    while($torneio = mysqli_fetch_array($pesquisaTorneios)){
                                        if($torneio['tipo_inscricao'] == 0){
                                            $totalInscricao = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$torneio['codigo']." AND cod_equipe is null"));
                                        }else{
                                            $totalInscricao = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$torneio['codigo']." AND cod_equipe is not null"));
                                        }
                                        $jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogos WHERE codigo = ".$torneio['cod_jogo'].""));
                                    ?>
                                        <div class="col-12 col-md-6">
                                            <a href="ptbr/organizacao/<?php echo $torneio['cod_organizacao']; ?>/painel/campeonato/<?php echo $torneio['codigo']; ?>/">
                                                <div class="torneioPainelOrganizacao">
                                                    <div class="row">
                                                        <div class="col-4 col-md-4">
                                                        <?php
                                                            if($torneio['thumb'] != NULL){
                                                            ?>
                                                                <img class="thumb" src="img/<?php echo $torneio['thumb']; ?>" alt="<?php echo $torneio['nome']; ?>" title="<?php echo $torneio['nome']; ?>">
                                                            <?php
                                                            }else{
                                                                switch($torneio['cod_jogo']){
                                                                    case 369: // HEARTHSTONE
                                                                        echo "<img src='http://www.esportscups.com.br/img/icones/hearthstone.png' alt='Hearthstone' title='Hearthstone'>";
                                                                        break;
                                                                    case 147: // League of Legends
                                                                        echo "<img src='http://www.esportscups.com.br/img/icones/lol.png' alt='League of Legends' title='League of Legends'>";
                                                                        break;
                                                                    case 357: // Dota 2
                                                                        echo "<img src='http://www.esportscups.com.br/img/icones/dota2.png' alt='Dota 2' title='Dota 2'>";
                                                                        break;
                                                                    case 258: // Overwatch
                                                                        echo "<img src='http://www.esportscups.com.br/img/icones/overwatch.png' alt='Overwatch' title='Overwatch'>";
                                                                        break;
                                                                }
                                                            }				
                                                        ?>
                                                        </div>
                                                        <div class="col-8 col-md-7">
                                                            <div class="row">
                                                                <h4><strong><?php echo $torneio['nome']; ?></strong></h4>
                                                            </div>		
                                                            <div class="row">
                                                                <strong>Início:</strong> <?php echo date("d/m - H:i", strtotime($torneio['inicio'])); ?>
                                                                <br><br>
                                                            </div>
                                                            <div class="row">
                                                                <div class="progress" style="width:100%;">
                                                                    <div class="progress-bar bg-laranja" role="progressbar" style="width: <?php echo ($totalInscricao/$torneio['vagas'])*100; ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><?php echo $totalInscricao; ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
        <script>
            function modalNovaDivisao(){
                $(".modal-body").load("ptbr/organizacao/paineladmin/ligas/form-nova-divisao.php?organizacao=<?php echo $organizacao['codigo']; ?>&liga=<?php echo $liga['codigo']; ?>");
                $(".modal-title").html("Criar nova Divisão");
                $(".modal").modal();
            }
            jQuery(function($){
                $(".menuPainelOrganizacao .opcao2").addClass("ativo");
            });
        </script>
    </body>
</html>