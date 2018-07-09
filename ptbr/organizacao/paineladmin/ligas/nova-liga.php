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
                    <div class="opcoesOrganizacao">
                        <div class="row">
                            <div class="col-5 col-md-12">
                                <img src="img/<?php echo $organizacao['perfil']; ?>" alt="<?php echo $organizacao['nome']; ?>" >
                            </div>
                            <div class="col-7 col-md-12">
                                <h2><?php echo $organizacao['nome']; ?></h2>
                            </div>
                        </div>                         
                    </div>
                    <ul class="menuPainelOrganizacao">
                        <li class="ativo">Campeonatos</li>
                        <li>Caixas</li>
                        <li>Produtos</li>
                    </ul>
                </div>
                <div class="col-12 col-md-9">
                    <ul class="navegacaoPainel">
                        <li><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/"><?php echo $organizacao['nome']; ?></a></li>
                        <li><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/ligas/">Ligas</a></li>
                        <li class="ativo">Nova Liga</li>
                    </ul>
                    <h1>BEM-VINDO À CRIAÇÃO DE LIGAS</h1>
                    Uma Liga é um um circuito de competições em um determinado período de tempo. <br>
                    Cada Liga pode ser compostas por N divisões, onde poderá haver rebaixamento e promoção entre os piores e melhores de cada divisão. <br><br>
                    
                    Cada divisão será composta por torneios, onde cada torneio dará uma premiação para o X primeiros colocados.
                    
                    
                    Se possível, preencha todas as informações, isso dará mais <strong>credibilidade ao seu evento</strong> e ele será aceito por nossa equipe mais facilmente.<br><br>
                    Caso não esteja conseguindo criar sua Liga com sucesso, assista a vídeo-aula que preparamos: <br>
                    <strong>ASSISTIR AULA! (EM BREVE)</strong>
                    <br><br>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Sobre a Liga</a>
                      </li>
                    </ul>
                    <form action="<?php echo "ptbr/organizacao/".$organizacao['codigo']."/painel/ligas/nova-liga/enviar/"; ?>" method="post" enctype="multipart/form-data" onSubmit="return verificarSaldos();">
                        <div class="tab-content" id="myTabContent">				
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <br>
                                <div class="row">
                                    <br>
                                    <div class="form-group col-md-4">
                                        <label for="nome">Nome da Liga</label>
                                        <input type="text" placeholder="Nome do Torneio" name="nome" id="nome" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="jogo">Selecione o JOGO</label>
                                        <select name="codJogo" id="jogo" class="form-control" onChange="$('#regiao').focus();" required>
                                            <option value="" hidden="hidden">SELECIONE O JOGO</option>
                                            <option value="357">Dota 2</option>
                                            <option value="123">GWENT: The Witcher Card Game</option>
                                            <option value="369">Hearthstone</option>
                                            <option value="147">League of Legends</option>
                                            <option value="258">Overwatch</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="logoCamp">Logo do Torneio (500x500px)</label>
                                        <input type="file" name="logo" class="form-control">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <input type="submit" value="Enviar" class="btn btn-dark float-right">
                                    </div>
                                </div>                                
                            </div>                            			
                        </div>
                    </form>	
                </div>
            </div>
        </div>

        <?php include "../../../footer.php"; ?>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script src="//cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
        <script type="text/javascript">
			function tratarJogo(nomeJogo){
				if(codigoJogo == 369){
					
				}
			}
			function attSaldoCoin(){
				var saldoTotal = 0;
				var aux = 0;
				while(aux < 16){
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
				while(aux < 16){
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
					alert("A organização não possui saldo suficiente para criar esta competição!");
					return false;
				}
				
			}
			jQuery(function($){
				$('#myTab li:first-child a').tab('show');
				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
				  e.target // newly activated tab
				  e.relatedTarget // previous active tab
				});
                CKEDITOR.replace( 'descricao' );
                CKEDITOR.replace( 'regulamento' );
                CKEDITOR.replace( 'premiacao' );
                CKEDITOR.replace( 'cronograma' );
			});
		</script>
    </body>
</html>