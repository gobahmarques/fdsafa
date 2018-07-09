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
                        <li><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/ligas/">Ligas</a></li>
                        <li><?php echo $liga['nome']; ?></li> 
                        <li class="ativo">Divisões</li> 
                    </ul>
                    <div class="row">
                        <div class="col">
                            <div class="acoesPainelOrg">
                                <div class="row centralizar">
                                    <div class="col-6 col-md-4">
                                        <div class="acao" onClick="modalNovaDivisao();">
                                            <img src="img/icones/+.png">
                                            <h3>Nova Divisão</h3>
                                            Crie uma Divisão à sua Liga
                                        </div>
                                    </div>
                                    <?php
                                        $divisoes = mysqli_query($conexao, "SELECT * FROM liga_divisao WHERE cod_liga = ".$liga['codigo']." ");
                                        while($divisao = mysqli_fetch_array($divisoes)){
                                            $totalInscritos = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM liga_inscricao WHERE cod_liga = ".$liga['codigo']." AND cod_divisao = ".$divisao['codigo'].""));
                                        ?>
                                            <div class="col-6 col-md-4">
                                                <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/liga/<?php echo $liga['codigo']; ?>/divisao/<?php echo $divisao['codigo']; ?>/">
                                                    <div class="acao">
                                                        <img src="<?php echo $divisao['logo_caminho']; ?>">
                                                        <h3><?php echo $divisao['nome']; ?></h3>
                                                        <?php echo $totalInscritos." / ".$divisao['vagas']; ?>
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