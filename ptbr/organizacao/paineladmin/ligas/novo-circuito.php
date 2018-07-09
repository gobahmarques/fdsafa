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
                        <li><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/liga/<?php echo $liga['codigo']; ?>/"><?php echo $liga['nome']; ?></a></li> 
                        <li class="ativo">Novo Circuito</li> 
                    </ul>
                    <div class="row">
                        <div class="col">
                            <div class="acoesPainelOrg">
                                <form method="post" action="ptbr/organizacao/paineladmin/ligas/scripts.php">
                                    <input type="hidden" name="funcao" value="criarCircuito">
                                    <input type="hidden" name="codliga" value="<?php echo $liga['codigo']; ?>">
                                    <div class="row centralizar novoCircuito">
                                    <?php
                                        $divisoes = mysqli_query($conexao, "SELECT * FROM liga_divisao_campeonato
                                        INNER JOIN liga_divisao ON liga_divisao.codigo = liga_divisao_campeonato.cod_divisao
                                        WHERE liga_divisao.cod_liga = 7");
                                        while($divisao = mysqli_fetch_array($divisoes)){ // MOSTRAR FAIXA PARA CONFIGURAÇÕES DE CADA DIVISÃO
                                        ?>
                                            <input type="hidden" name="codDivisoes[]" value="<?php echo $divisao['codigo']; ?>">
                                            <div class="col-6 col-md-6">
                                                <div class="faixaEtapa">
                                                    <div class="row">
                                                        <div class="col-12 col-md-12">
                                                            <img src="<?php echo $divisao['logo_caminho']; ?>">
                                                        </div>
                                                        <div class="col-12 col-md-12">
                                                            <h3><?php echo $divisao['nome']; ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-2 col-md-2">
                                                            Início Inscrição
                                                        </div>
                                                        <div class="col-8 col-md-6">
                                                            <input type="date" class="form-control" name="dataInicioInsc<?php echo $divisao['codigo']; ?>">
                                                        </div>
                                                        <div class="col-4 col-md-4">
                                                            <input type="time" class="form-control" name="horaInicioInsc<?php echo $divisao['codigo']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-2 col-md-2">
                                                            Fim Inscrição
                                                        </div>
                                                        <div class="col-6 col-md-6">
                                                            <input type="date" class="form-control" name="dataFimInsc<?php echo $divisao['codigo']; ?>">
                                                        </div>
                                                        <div class="col-4 col-md-4">
                                                            <input type="time" class="form-control" name="horaFimInsc<?php echo $divisao['codigo']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-2 col-md-2">
                                                            Início Torneio
                                                        </div>
                                                        <div class="col-6 col-md-6">
                                                            <input type="date" class="form-control" name="dataInicioTorneio<?php echo $divisao['codigo']; ?>">
                                                        </div>
                                                        <div class="col-4 col-md-4">
                                                            <input type="time" class="form-control" name="horaInicioTorneio<?php echo $divisao['codigo']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-2 col-md-2">
                                                            Fim Torneio
                                                        </div>
                                                        <div class="col-6 col-md-6">
                                                            <input type="date" class="form-control" name="dataFimTorneio<?php echo $divisao['codigo']; ?>">
                                                        </div>
                                                        <div class="col-4 col-md-4">
                                                            <input type="time" class="form-control" name="horaFimTorneio<?php echo $divisao['codigo']; ?>">
                                                        </div>
                                                    </div>
                                                </div>                                                
                                            </div>
                                        <?php
                                        }
                                    ?>   
                                        <div class="col-12 col-md-12">
                                            * Caso alguma Divisão não esteja sendo mostrada, certifique-se de que configurou os padrões de competição desta Divisão.<br><br>
                                            <input type="submit" value="CRIAR CIRCUITO" class="btn btn-dark">    
                                        </div>
                                    </div>                                   
                                </form>                                
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