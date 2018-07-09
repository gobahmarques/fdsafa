<?php
    include "../../../../enderecos.php";
    include "../../../../session.php";
    $organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$_GET['codigo'].""));
    $liga = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM liga WHERE codigo = ".$_GET['liga']." "));

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
                        <li><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/ligas/">Ligas</a></li>
                        <li class="ativo"><?php echo $liga['nome']; ?></li>                        
                    </ul>
                    <div class="row">
                        <div class="col">
                            <div class="resumoCampPainel">
                                Resumão da Liga.
                            </div>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="acoesPainelOrg">
                                <div class="row centralizar">
                                    <div class="col-6 col-md-4">
                                        <a href="ptbr/liga/<?php echo $campeonato['codigo']; ?>/" target="_blank">
                                            <div class="acao">
                                                <i class="fas fa-search"></i>
                                                <h3>Visualizar</h3>
                                                Como vêem sua Liga.
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/liga/<?php echo $liga['codigo']; ?>/divisoes/">
                                            <div class="acao">
                                                <i class="fas fa-cogs"></i>
                                                <h3>Divisões</h3>
                                                Edite seu torneio.
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/ligas/<?php echo $liga['codigo']; ?>/inscricoes/">				
                                            <div class="acao">
                                                <i class="fas fa-list-ul"></i>                                                
                                                <h2>Inscrições</h2>
                                                Gestione as inscrições.
                                            </div>
                                        </a>
                                    </div>  
                                    <div class="col-6 col-md-4">
                                        <div class="acao" onClick="gerarNotificacao(<?php echo $campeonato['codigo']; ?>)">
                                            <i class="fas fa-flag"></i>
                                            <h3>Notificação</h3>
                                            Emita notificações para os inscritos.
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/liga/<?php echo $liga['codigo']; ?>/circuitos/">				
                                            <div class="acao">
                                                <i class="far fa-calendar-alt"></i>
                                                <h2>Circuitos</h2>
                                                Administre os circuitos da Liga
                                            </div>
                                        </a>
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
        <script>
            jQuery(function($){
                $(".menuPainelOrganizacao .opcao2").addClass("ativo");
            });
        </script>
    </body>
</html>