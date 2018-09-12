<?php
    include "../../../../enderecos.php";
    include "../../../../session.php";
    
    $organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$_GET['codigo'].""));
	$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_GET['torneio'].""));
	$etapa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_etapa = ".$_GET['etapa']." AND cod_campeonato = ".$campeonato['codigo']." "));
	$datahora = date("Y-m-d H:i:s");

	if(isset($usuario['codigo'])){
		$pesquisaFuncao = mysqli_query($conexao, "SELECT * FROM jogador_organizacao WHERE cod_organizacao = ".$organizacao['codigo']." AND cod_jogador = ".$usuario['codigo']." ");
		$funcao = mysqli_fetch_array($pesquisaFuncao);	
		if(!isset($funcao['status'])){
			header("Location: http://www.esportscups.com.br/http://www.esportscups.com.br/http://www.esportscups.com.br/");	
		}
	}else{
		header("Location: http://www.esportscups.com.br/http://www.esportscups.com.br/http://www.esportscups.com.br/");
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
        <div class="container painelSementes">
            <div class="row">
                <div class="col-12 col-md-4">
                    <h3>Sementes</h3>
                    <input type="button" value="Distribuir Aleatoriamente" class="btn btn-dark" onClick="distribuirAleatoriamente(<?php echo $etapa['cod_etapa']; ?>, <?php echo $campeonato['codigo']; ?>);"><br>
                    ou clique em cada semente para preencher manualmente.
                    <br>
                    <div class="listagemSementes">                        
                        <?php
                            $sementes = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_semente WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_etapa = ".$etapa['cod_etapa']." ");
                        ?>
                        <table class="listajogadores" id="tabelaLobbys" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>#</td>
                                <td>Nome</td>
                            </tr>
                            <?php
                                while($seed = mysqli_fetch_array($sementes)){
                                    if($seed['cod_jogador'] != NULL){
                                    ?>
                                        <tr>
                                            <td><?php echo $seed['numero']; ?></td>
                                            <td>
                                            <?php
                                                if($seed['cod_equipe'] != NULL){
                                                    $equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome FROM equipe WHERE codigo = ".$seed['cod_equipe']." "));
                                                    echo $equipe['nome'];
                                                }else{
                                                    $inscricao = mysqli_fetch_array(mysqli_query($conexao, "SELECT conta FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$seed['cod_jogador']." "));
                                                    echo $inscricao['conta'];
                                                }
                                            ?>
                                            </td>
                                        </tr>
                                    <?php    
                                    }else{
                                    ?>
                                        <tr onClick="abrirPreencherSemente(<?php echo $etapa['cod_etapa'].",".$campeonato['codigo'].",".$seed['codigo'].",".$seed['numero']; ?>);">
                                            <td><?php echo $seed['numero']; ?></td>
                                            <td>
                                                <img src="img/icones/+.png" height="30" /> -----------------------
                                            </td>
                                        </tr>
                                    <?php    
                                    }                    
                                }
                            ?>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="row-fluid">
                    <?php
                        require "../../../../scripts/carregar-bracket-painel-organizacao.php";
                        switch($etapa['tipo_etapa']){
                            case 1: // ELIMINAÇÃO SIMPLES
                                elimSimples($_GET['etapa'], $campeonato['codigo']);		
                                break;
                            case 2: // GRUPOS PONTOS CORRIDOS
                                gruposPontosCorridos($etapa, $campeonato);
                                break;
                            case 3: // ELIMINAÇÃO DUPLA
                                elimDupla($_GET['etapa'], $campeonato['codigo']);
                                break;
                        }            
                    ?>
                    </div>
                </div>
            </div>
        </div>

        <?php include "../../../footer.php"; ?>
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script>
            function abrirPreencherSemente(etapa, campeonato, codSemente, numero){  
                $.ajax({
                    type: "POST",
                    url: "scripts/etapa.php",
                    data: "funcao=carregarJogadoresSemSemente&etapa="+etapa+"&campeonato="+campeonato,
                    success: function(resposta){
                        $(".modal-body").html(resposta);  
                    }
                })
                $(".modal-title").html("Preencher semente #"+numero);
                setTimeout(function(){
                    $(".codSemente").val(codSemente);                    
                }, 1000);
                $(".modal").modal();
            }
            function distribuirAleatoriamente(etapa, campeonato){
                $.ajax({
                    type: "POST",
                    url: "ptbr/organizacao/paineladmin/campeonatos/painel-sementes-enviar.php",
                    data: "funcao=preencherAleatorio&codEtapa="+etapa+"&codCampeonato="+campeonato,
                    success: function(resposta2){
                        window.location.reload();
                    }
                })
            }
        </script>
    </body>
</html>