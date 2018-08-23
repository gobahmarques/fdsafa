<?php
    include "../../../enderecos.php";
    include "../../../session.php";
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
        <?php include "../../header.php"; ?>
        
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
                        <li><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/">Campeonatos</a></li>
                        <li class="ativo">Novo Torneios</li>
                    </ul>
                    <h1>BEM-VINDO À CRIAÇÃO DE TORNEIOS</h1>
                    Estamos felizes em poder te ajudar, de alguma forma, a contribuir com o crescimento do cenário competitivo do eSports. <br>
                    Se possível, preencha todas as informações, isso dará mais <strong>credibilidade ao seu evento</strong> e ele será aceito por nossa equipe mais facilmente.<br><br>
                    Caso não esteja conseguindo criar seu torneio com sucesso, assista a vídeo-aula que preparamos: <br>
                    <strong>ASSISTIR AULA!</strong>
                    <br><br>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Informações Básicas</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Descrição do Torneio</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Premiação Automática</a>
                      </li>
                    </ul>
                    <form action="<?php echo "ptbr/organizacao/".$organizacao['codigo']."/novo-torneio/enviar/"; ?>" method="post" enctype="multipart/form-data" onSubmit="return verificarSaldos();">
                        <div class="tab-content" id="myTabContent">				
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <br>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="nome">Nome do Torneio</label>
                                        <input type="text" placeholder="Nome do Torneio" name="nome" id="nome" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-3">
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
                                    <div class="form-group col-md-3">
                                        <label for="regiao">Região</label>
                                        <input type="text" name="regiao" placeholder="Ex: Américas, Europa, Ásia..." class="form-control" id="regiao" required>			
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="plataforma">Plataforma de Disputa</label>
                                        <select name="plataforma" id="plataforma" class="form-control" onChange="$('#vagas').focus();" required>
                                            <option value="" hidden="hidden">SELECIONE A PLATAFORMA</option>
                                            <option value="PC">PC</option>
                                            <option value="PS4">PS4</option>
                                            <option value="XONE">X-ONE</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="vagas">Vagas</label>
                                        <input type="number" min="2" max="1024" placeholder="Qtd. Vagas" name="vagas" id="vagas" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="valorCoin">Inscrição em e$</label>
                                        <input type="number" name="valor" placeholder="Inscrição (e$)" step="50" id="valorCoin" class="form-control">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="valorReal">Inscrição em R$</label>
                                        <input type="number" name="valorReal" placeholder="Inscrição (R$)" step="0.05" id="valorReal" class="form-control">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="fusoHorario">Fuso Horário</label>
                                        <input type="text" name="fusoHorario" placeholder="Brasília, New York, -3 UCT, ..." id="fusoHorario" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="url">Site do Torneio (URL)</label>
                                        <input type="text" placeholder="URL Site torneio (opcional)" name="link" id="url" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="inicioInsc">Início das Inscrições</label>
                                        <div class="row">
                                            <div class="col-md-7">
                                                <input type="date" placeholder="Inicio das Inscrições (dd/mm/aaaa H:m:s)" name="inicioInscData" class="datahora form-control" id="inicioInsc" required>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="time" placeholder="Fim das Inscrições (dd/mm/aaaa H:m:s)" name="inicioInscHora" class="datahora form-control" id="fimInsc" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="fimInsc">Fim das Inscrições</label>
                                        <div class="row">
                                            <div class="col-md-7">									
                                                <input type="date" placeholder="Fim das Inscrições (dd/mm/aaaa H:m:s)" name="fimInscData" class="datahora form-control" id="fimInsc" required>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="time" placeholder="Fim das Inscrições (dd/mm/aaaa H:m:s)" name="fimInscHora" class="datahora form-control" id="fimInsc" required>
                                            </div>
                                        </div>							
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="inicioTorneio">Inicio do Torneio</label>
                                        <div class="row">
                                            <div class="col-md-7">	
                                                <input type="date" placeholder="Inicio (dd/mm/aaaa H:m:s)" name="inicioData" class="datahora form-control" id="inicioTorneio" required>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="time" placeholder="Fim das Inscrições (dd/mm/aaaa H:m:s)" name="inicioHora" class="datahora form-control" id="fimInsc" required>
                                            </div>
                                        </div>							
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="fimTorneio">Fim do Torneio</label>
                                        <div class="row">
                                            <div class="col-md-7">	
                                                <input type="date" placeholder="Fim (dd/mm/aaaa H:m:s)" name="fimData" class="datahora form-control" id="fimTorneio" required>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="time" placeholder="Fim das Inscrições (dd/mm/aaaa H:m:s)" name="fimHora" class="datahora form-control" id="fimTorneio" required>
                                            </div>
                                        </div>							
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="precheckin">Pré Check-in (minutos)</label>
                                        <input type="number" placeholder="MINUTOS" name="minprecheckin" class="form-control" id="precheckin" value="0" required>
                                    </div>
                                    <div class="form-group col-md-2 qtdPick">
                                        <label for="qtdPicks">Quantidade de Picks?</label>
                                        <input type="number" name="qtdPick" class="form-control">
                                    </div>
                                    <div class="form-group col-md-2 qtdPick">
                                        <label for="qtdPicks">Quantidade de Bans?</label>
                                        <input type="number" name="qtdBans" class="form-control">
                                    </div>					
                                    <div class="form-group col-md-2">
                                        <label for="presencial">Haverá Etapas Presenciais?</label>
                                        <br>
                                        <input type="radio" name="etapaPresencial" value="0"> Sim <br>
                                        <input type="radio" name="etapaPresencial" value="1"> Não
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="tipoInsc">Tipo de Inscrição</label>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <input type="radio" name="tipoInsc" value="0" onClick="$('#jogTime').css('display', 'none');"> Jogadores <br>
                                                <input type="radio" name="tipoInsc" value="1" onClick="$('#jogTime').css('display', 'block');$('#jogTime').focus();" > Equipes
                                            </div>
                                            <div class="col-md-7">
                                                <input type="number" min="1" max="100" placeholder="Jogador / Time" name="jogTime" id="jogTime" class="form-control" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="dispInsc">Inscrição</label><br>
                                        <input type="radio" name="dispInsc" value="0"> Público <br>
                                        <input type="radio" name="dispInsc" value="1"> Privado
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="dispInsc">Deck List</label><br>
                                        <input type="radio" name="decklist" value="1"> Aberto <br>
                                        <input type="radio" name="decklist" value="0"> Fechado
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="logoCamp">Logo do Torneio (500x500px)</label>
                                        <input type="file" name="logo" class="form-control">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">    
                                <br>
                                <div class="row">                                    
                                    <div class="form-group col-md-6">
                                        <label for="descricao">Descrição do Torneio</label>
                                        <textarea name="descricao" id="descricao" class="form-control" cols="30" rows="10" placeholder="DESCRIÇÃO" required></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="regulamento">Regulamento</label>
                                        <textarea name="regulamento" id="regulamento" class="form-control" cols="30" rows="10" placeholder="REGULAMENTO" required></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="premiacao">Premiação Fora do Padrão?</label>
                                        <textarea name="premiacao" id="premiacao" class="form-control" cols="30" rows="10" placeholder="Premiações em R$ ou e$ são configurados na aba 'Premiação Automática'" required></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="cronograma">Cronograma Completo da Competição</label>
                                        <textarea name="cronograma" id="cronograma" class="form-control" cols="30" rows="10" placeholder="Exemplo: 05/06/2019 13h00 -> Início do Pré Check-in" required></textarea>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="local">Local / Estado</label>
                                        <input type="text" name="local" placeholder="Local" id="local" class="form-control">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="pais">País</label>
                                        <input type="text" name="pais" placeholder="País" id="pais" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <br>
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
                                        <label for="">Premiação e$</label>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="">COLOCAÇÃO</label>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="">Premiação e$</label>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="">Premiação e$</label>
                                    </div>
                                    <?php
                                        $ocorrencias = 0;
                                        $contador = 0;
                                        $aux = 0;
                                        while($ocorrencias < 16){
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
                                            <?php
                                            if($aux == 0){
                                                $contador += 8;
                                                $aux = 1;
                                            }else{
                                                $contador -= 7;
                                                $aux = 0;
                                            }
                                            $ocorrencias++;
                                        }
                                    ?>
                                    <div class="col-md-8">

                                    </div>
                                    <div class="form-group col-md-4">
                                        <input type="submit" class="form-control alert-success">
                                    </div>
                                </div>
                                						
                            </div>				
                        </div>
                    </form>	
                </div>
            </div>
        </div>

        <?php include "../../footer.php"; ?>
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