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
                        <li><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/liga/<?php echo $liga['codigo']; ?>/"><?php echo $liga['nome']; ?></a></li>  
                        <li><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/liga/<?php echo $liga['codigo']; ?>/divisao/<?php echo $divisao['codigo']; ?>/"><?php echo $divisao['nome']; ?></a></li>  
                        <li class="ativo">Torneio Padrão</li>    
                    </ul>
                    <h1>DEFINIÇÕES PADRÕES DE TORNEIO</h1>
                    Quando um novo circuito é iniciado, o torneio gerado para esta divisão seguirá os padrões dessa página.
                    <br><br>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Informações Básicas</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Descrição do Torneio</a>
                      </li>
                    </ul>
                    <form action="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/liga/<?php echo $liga['codigo']; ?>/divisao/<?php echo $divisao['codigo']; ?>/definicao-torneio/enviar/" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="codDivisao" id="codDivisao" class="form-control" value="<?php echo $divisao['codigo']; ?>">                        
                        <?php
                            $definicaoDivisao = mysqli_query($conexao, "SELECT * FROM liga_divisao_campeonato WHERE cod_divisao = ".$divisao['codigo']." ");
                            if($definicaoDivisao = mysqli_fetch_array($definicaoDivisao)){
                            ?>
                                <input type="hidden" name="funcao" id="funcao" class="form-control" value="alterarpadrao">
                                <div class="tab-content" id="myTabContent">				
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <br>
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="nome">Nome do Torneio</label>
                                                <input type="text" placeholder="Nome do Torneio" name="nome" id="nome" class="form-control" value="<?php echo $definicaoDivisao['nome']; ?>" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="jogo">Selecione o JOGO</label>
                                                <select name="codJogo" id="jogo" class="form-control" onChange="$('#regiao').focus();" required readonly>
                                                    <?php
                                                        $jogoLiga = mysqli_fetch_array(mysqli_query($conexao, "SELECT codigo, nome FROM jogos WHERE codigo = ".$liga['cod_jogo'].""));
                                                    ?>
                                                    <option value="<?php echo $jogoLiga['codigo']; ?>"><?php echo $jogoLiga['nome']; ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="regiao">Região</label>
                                                <input type="text" name="regiao" placeholder="Ex: Américas, Europa, Ásia..." class="form-control" id="regiao" value="<?php echo $definicaoDivisao['regiao']; ?>" required>			
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="plataforma">Plataforma de Disputa</label>
                                                <select name="plataforma" id="plataforma" class="form-control" onChange="$('#vagas').focus();" required>
                                                    <option value="<?php echo $definicaoDivisao['plataforma']; ?>" hidden="hidden"><?php echo $definicaoDivisao['plataforma']; ?></option>
                                                    <option value="PC">PC</option>
                                                    <option value="PS4">PS4</option>
                                                    <option value="XONE">X-ONE</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="vagas">Vagas</label>
                                                <input type="number" min="2" max="1024" placeholder="Qtd. Vagas" name="vagas" id="vagas" class="form-control" value="<?php echo $definicaoDivisao['vagas']; ?>" required>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="valorCoin">Inscrição em e$</label>
                                                <input type="number" name="valor" placeholder="Inscrição (e$)" step="50" id="valorCoin" class="form-control" value="<?php echo $definicaoDivisao['valor_escoin']; ?>">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="valorReal">Inscrição em R$</label>
                                                <input type="number" name="valorReal" placeholder="Inscrição (R$)" step="0.05" id="valorReal" class="form-control" value="<?php echo $definicaoDivisao['valor_real']; ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="fusoHorario">Fuso Horário</label>
                                                <input type="text" name="fusoHorario" placeholder="Brasília, New York, -3 UCT, ..." id="fusoHorario" class="form-control" value="<?php echo $definicaoDivisao['fuso_horario']; ?>" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="url">Site do Torneio (URL)</label>
                                                <input type="text" placeholder="URL Site torneio (opcional)" name="link" id="url" value="<?php echo $definicaoDivisao['link']; ?>" class="form-control">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="precheckin">Pré Check-in (minutos)</label>
                                                <input type="number" placeholder="MINUTOS" name="minprecheckin" class="form-control" id="precheckin" value="<?php echo $definicaoDivisao['precheckin']; ?>" required>
                                            </div>
                                            <div class="form-group col-md-2 qtdPick">
                                                <label for="qtdPicks">Quantidade de Picks?</label>
                                                <input type="number" name="qtdPick" value="<?php echo $definicaoDivisao['qtd_pick']; ?>" class="form-control">
                                            </div>
                                            <div class="form-group col-md-2 qtdPick">
                                                <label for="qtdPicks">Quantidade de Bans?</label>
                                                <input type="number" name="qtdBans" value="<?php echo $definicaoDivisao['qtd_ban']; ?>" class="form-control">
                                            </div>					
                                            <div class="form-group col-md-2">
                                                <label for="presencial">Haverá Etapas Presenciais?</label>
                                                <br>
                                                <input type="radio" name="etapaPresencial" value="0" <?php if($definicaoDivisao['presencial'] == 0){ echo "checked"; }; ?>> Sim <br>
                                                <input type="radio" name="etapaPresencial" value="1" <?php if($definicaoDivisao['presencial'] == 1){ echo "checked"; }; ?>> Não
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="tipoInsc">Tipo de Inscrição</label>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <input type="radio" name="tipoInsc" value="0" onClick="$('#jogTime').css('display', 'none');" <?php if($definicaoDivisao['tipo_inscricao'] == 0){ echo "checked"; }; ?>> Jogadores <br>
                                                        <input type="radio" name="tipoInsc" value="1" onClick="$('#jogTime').css('display', 'block');$('#jogTime').focus();" <?php if($definicaoDivisao['tipo_inscricao'] == 1){ echo "checked"; }; ?>> Equipes
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="number" min="1" max="100" placeholder="Jogador / Time" name="jogTime" id="jogTime" class="form-control" style="display: none;" value="<?php echo $definicaoDivisao['jogador_por_time']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="dispInsc">Disponibilidade Inscrição</label><br>
                                                <input type="radio" name="dispInsc" value="0" <?php if($definicaoDivisao['status_inscricao'] == 0){ echo "checked"; }; ?>> Público 
                                                <input type="radio" name="dispInsc" value="1" <?php if($definicaoDivisao['status_inscricao'] == 1){ echo "checked"; }; ?>> Privado
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">    
                                        <br>
                                        <div class="row">                                    
                                            <div class="form-group col-md-6">
                                                <label for="descricao">Descrição do Torneio</label>
                                                <textarea name="descricao" id="descricao" class="form-control" cols="30" rows="10" placeholder="DESCRIÇÃO" required><?php echo $definicaoDivisao['descricao']; ?></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="regulamento">Regulamento</label>
                                                <textarea name="regulamento" id="regulamento" class="form-control" cols="30" rows="10" placeholder="REGULAMENTO" required><?php echo $definicaoDivisao['regulamento']; ?></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="premiacao">Premiação Fora do Padrão?</label>
                                                <textarea name="premiacao" id="premiacao" class="form-control" cols="30" rows="10" placeholder="Premiações em R$ ou e$ são configurados na aba 'Premiação Automática'" required><?php echo $definicaoDivisao['premiacao']; ?></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="cronograma">Cronograma Completo da Competição</label>
                                                <textarea name="cronograma" id="cronograma" class="form-control" cols="30" rows="10" placeholder="Exemplo: 05/06/2019 13h00 -> Início do Pré Check-in" required><?php echo $definicaoDivisao['cronograma']; ?></textarea>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="local">Local / Estado</label>
                                                <input type="text" name="local" placeholder="Local" id="local" class="form-control" value="<?php echo $definicaoDivisao['local']; ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="pais">País</label>
                                                <input type="text" name="pais" placeholder="País" id="pais" class="form-control" value="<?php echo $definicaoDivisao['pais']; ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="submit" class="form-control alert-success">
                                            </div>
                                        </div>
                                    </div>			
                                </div>
                            <?php
                            }else{
                            ?>
                                <input type="hidden" name="funcao" id="funcao" class="form-control" value="criarpadrao">
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
                                                <select name="codJogo" id="jogo" class="form-control" onChange="$('#regiao').focus();" required readonly>
                                                    <?php
                                                        $jogoLiga = mysqli_fetch_array(mysqli_query($conexao, "SELECT codigo, nome FROM jogos WHERE codigo = ".$liga['cod_jogo'].""));
                                                    ?>
                                                    <option value="<?php echo $jogoLiga['codigo']; ?>"><?php echo $jogoLiga['nome']; ?></option>
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
                                            <div class="form-group col-md-4">
                                                <label for="dispInsc">Disponibilidade Inscrição</label><br>
                                                <input type="radio" name="dispInsc" value="0"> Público 
                                                <input type="radio" name="dispInsc" value="1"> Privado
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
                                            <div class="form-group col-md-6">
                                                <input type="submit" class="form-control alert-success">
                                            </div>
                                        </div>
                                    </div>				
                                </div>
                            <?php
                            }
                        ?>
                        
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