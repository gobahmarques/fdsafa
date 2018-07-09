<?php
    include "../../../../enderecos.php";
    include "../../../../session.php";
    $organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$_GET['codigo'].""));

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
                        <li class="ativo">Ligas</li>
                    </ul>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/ligas/nova-liga/">
                                <div class="torneioPainelOrganizacao">
                                    <div class="row">
                                        <div class="col-4 col-md-4">
                                            <img class="thumb" src="img/icones/+.png" alt="Criar Nova Liga" title="Criar Nova Liga">
                                        </div>
                                        <div class="col-8 col-md-7">
                                            <div class="row">
                                                <h4><strong>NOVA LIGA</strong></h4>
                                            </div>		
                                            <div class="row">
                                                Crie uma liga e suas respectivas divisões para compor um circuito de competições
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>                         						
                        </div>
                        <?php
                            $pesquisaLigas = mysqli_query($conexao, "SELECT * FROM liga WHERE cod_organizacao = ".$organizacao['codigo']." ORDER BY nome");	
                            while($liga = mysqli_fetch_array($pesquisaLigas)){
                                $jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogos WHERE codigo = ".$liga['cod_jogo'].""));
                                $totalDivisoes = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM liga_divisao WHERE cod_liga =  ".$liga['codigo']." "));
                                $totalInscricoes = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM liga_inscricao WHERE cod_liga = ".$liga['codigo'].""));
                            ?>
                                <div class="col-12 col-md-6">
                                    <a href="ptbr/organizacao/<?php echo $liga['cod_organizacao']; ?>/painel/liga/<?php echo $liga['codigo']; ?>/">
                                        <div class="torneioPainelOrganizacao">
                                            <div class="row">
                                                <div class="col-4 col-md-4">
                                                <?php
                                                    if($liga['logo_caminho'] != NULL){
                                                    ?>
                                                        <img class="thumb" src="<?php echo $liga['logo_caminho']; ?>" alt="<?php echo $liga['nome']; ?>" title="<?php echo $liga['nome']; ?>">
                                                    <?php
                                                    }else{
                                                        switch($liga['cod_jogo']){
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
                                                        <h4><strong><?php echo $liga['nome']; ?></strong></h4>
                                                        Divisões: <?php echo $totalDivisoes; ?><br>
                                                        Participantes: <?php echo $totalInscricoes; ?>
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