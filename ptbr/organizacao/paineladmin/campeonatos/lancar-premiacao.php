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
                        <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/campeonato/<?php echo $campeonato['codigo']; ?>/"><li >Campeonatos</li></a>
                        <li class="ativo">Premiação Automática</li>
                    </ul>
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <h2>Premiação Automática de Torneios</h2>
                            Aqui você irá configurar uma premiação automática para quando o torneio finalizar.<br>
                            A premiação será entregue aos jogadores/equipes quando a colocação final for informada.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-2">
                            <label for="">Total e$</label>
                            <input type="text" class="form-control totalCoin" readonly value="0">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="">Total R$</label>
                            <input type="text" class="form-control totalReal" readonly value="0">
                        </div>
                        
                        <div class="form-group col-md-2">
                            <label for="">COLOCAÇÃO</label>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Premiação e$</label>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Premiação R$</label>
                        </div>   
                        <div class="form-group col-md-2">
                            <label for="">Pontos</label>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Avanço Divisão</label>
                        </div>
                        <form method="post" action="scripts/campeonato/registrar-premiacao.php" onsubmit="return verificarSaldos();">
                            <input type="hidden" value="<?php echo $campeonato['codigo']; ?>" name="codcampeonato">
                            <div class="row">
                            <?php
                                $ocorrencias = 0;
                                $contador = 0;
                                $aux = 0;
                                while($ocorrencias < 32){
                                    ?>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control" readonly value="<?php echo "#".($contador+1); ?>">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control <?php echo "coin".$contador; ?>" onChange="attSaldoCoin();" value="0" tabindex="<?php echo $contador+1; ?>" name="<?php echo "coin".$contador; ?>">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control <?php echo "real".$contador; ?>" onChange="attSaldoReal();" value="0" tabindex="<?php echo $contador+2; ?>" name="<?php echo "real".$contador; ?>">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control <?php echo "real".$contador; ?>" value="0" tabindex="<?php echo $contador+2; ?>" name="<?php echo "pontos".$contador; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                        <?php
                                            $divisoesDisponiveis = mysqli_query($conexao, "SELECT *, liga_divisao.nome AS nomeDivisao, liga_divisao.codigo cod_divisao FROM liga_divisao
                                            INNER JOIN liga ON liga.codigo = liga_divisao.cod_liga
                                            WHERE liga.cod_organizacao = ".$organizacao['codigo']."
                                            AND liga.cod_jogo = ".$campeonato['cod_jogo']." ");
                                            if(mysqli_num_rows($divisoesDisponiveis) > 0){
                                            ?>
                                                <select class="form-control" name="<?php echo "divisao".$contador; ?>">
                                                    <option hidden value="">-- SELECIONE --</option>
                                                <?php
                                                    while($divisao = mysqli_fetch_array($divisoesDisponiveis)){
                                                    ?>
                                                        <option value="<?php echo $divisao['cod_divisao']; ?>">Divisão: <?php echo $divisao['nomeDivisao']; ?> - Liga: <?php echo $divisao['nome']; ?></option>
                                                    <?php
                                                    }
                                                ?>
                                                </select>
                                            <?php
                                            }                                        
                                        ?>
                                        </div>
                                    <?php
                                    $contador++;
                                    $ocorrencias++;
                                }
                            ?>
                                <div class="col-md-8">

                                </div>
                                <div class="form-group col-md-4">
                                    <input type="submit" class="form-control alert-success">
                                </div>
                            </div>                        
                        </form>
                        
                        
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
            function attSaldoCoin(){
				var saldoTotal = 0;
				var aux = 0;
				while(aux < 32){
					if($(".coin"+aux).val() != ""){
						saldoTotal = parseInt(saldoTotal) + parseInt($(".coin"+aux).val());						
					}					
					aux++;
				}
				$(".totalCoin").val(saldoTotal);
			}
			function attSaldoReal(){
				var saldoTotal = 0;
				var aux = 0;
				while(aux < 32){
					if($(".real"+aux).val() != ""){
						saldoTotal = parseFloat(saldoTotal) + parseFloat($(".real"+aux).val());						
					}					
					aux++;
				}
				$(".totalReal").val(saldoTotal);
			}
			function verificarSaldos(){
				var totalCoin, totalReal, saldoCoin, saldoReal, status = 0;
				totalCoin = $(".totalCoin").val();
				totalReal = $(".totalReal").val();
				saldoCoin = <?php echo $organizacao['saldo_coin']; ?>;
				saldoReal = <?php echo $organizacao['saldo_real']; ?>;
				if(totalCoin > 0){
					if(totalCoin > saldoCoin){
						status = 1;
					}
				}
				if(totalReal > 0){
					if(totalReal > saldoReal){
						status = 1;
					}
				}
				
				if(status == 0){ // TUDO OK
					return true;
				}else{ // SEM SALDO
					alert("A organização não possui saldo suficiente registrar esta premiação!");
					return false;
				}
				
			}
        </script>
    </body>
</html>