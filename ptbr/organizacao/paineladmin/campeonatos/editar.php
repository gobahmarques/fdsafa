<?php
    include "../../../../enderecos.php";
    include "../../../../session.php";
    $organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$_GET['codigo'].""));
    $campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_GET['torneio'].""));
	$jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogos WHERE codigo = ".$campeonato['cod_jogo']." "));

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
                    </ul>
                    <form action="ptbr/organizacao/paineladmin/campeonatos/editar-enviar.php" method="post" enctype="multipart/form-data">
                        <input type="text" name="codCampeonato" value="<?php echo $campeonato['codigo']; ?>" hidden="hidden">
                        <div class="tab-content" id="myTabContent">				
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <br>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="nome">Nome do Torneio</label>
                                        <input type="text" placeholder="Nome do Torneio" name="nome" class="form-control" value="<?php echo $campeonato['nome']; ?>">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="jogo">Selecione o JOGO</label>
                                        <select name="codJogo" disabled class="form-control">
                                            <option value="<?php echo $jogo['codigo']; ?>">Jogo -> <?php echo $jogo['nome']; ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="regiao">Região</label>
                                        <input type="text" name="regiao" class="form-control" placeholder="REGIÃO (ex: Américas, Europa...)" value="<?php echo $campeonato['regiao']; ?>">		
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="plataforma">Plataforma de Disputa</label>
                                        <select class="form-control" name="plataforma">
                                            <option value="<?php echo $campeonato['plataforma']; ?>" hidden="hidden"><?php echo $campeonato['plataforma']; ?></option>
                                            <option value="PC">PC</option>
                                            <option value="PS4">PS4</option>
                                            <option value="XONE">X-ONE</option>
                                        </select>   
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="vagas">Vagas</label>
                                        <input type="number" min="2" max="1024" placeholder="Qtd. Vagas" name="vagas" id="vagas" class="form-control" value="<?php echo $campeonato['vagas']; ?>" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="valorCoin">Inscrição em e$</label>
                                        <input type="number" name="valor" placeholder="Inscrição (e$)" step="50" id="valorCoin" class="form-control" value="<?php echo $campeonato['valor_escoin']; ?>" disabled>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="valorReal">Inscrição em R$</label>
                                        <input type="number" name="valorReal" placeholder="Inscrição (R$)" step="0.05" id="valorReal" class="form-control" value="<?php echo $campeonato['valor_real']; ?>" disabled>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="fusoHorario">Fuso Horário</label>
                                        <input type="text" name="fusoHorario" placeholder="Brasília, New York, -3 UCT, ..." id="fusoHorario" class="form-control" value="<?php echo $campeonato['fuso_horario']; ?>" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="url">Site do Torneio (URL)</label>
                                        <input type="text" placeholder="URL Site torneio (opcional)" name="link" id="url" value="<?php echo $campeonato['link']; ?>" class="form-control">
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-3">
                                        <label for="url">Inicio das Inscrições</label>
                                        <input type="text" placeholder="dd/mm/aaaa hh:mm:ss" name="inicioInsc" id="url" value="<?php echo date("d/m/Y H:i:s", strtotime($campeonato['inicio_inscricao'])) ?>" class="form-control" data-mask="00/00/0000 00:00:00">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="url">Fim das Inscrições</label>
                                        <input type="text" placeholder="dd/mm/aaaa hh:mm:ss" name="fimInsc" id="url" value="<?php echo date("d/m/Y H:i:s", strtotime($campeonato['fim_inscricao'])) ?>" class="form-control" data-mask="00/00/0000 00:00:00">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="url">Inicio do Torneio</label>
                                        <input type="text" placeholder="dd/mm/aaaa hh:mm:ss" name="inicioTorneio" id="url" value="<?php echo date("d/m/Y H:i:s", strtotime($campeonato['inicio'])) ?>" class="form-control" data-mask="00/00/0000 00:00:00">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="url">Fim do Torneio (previsão)</label>
                                        <input type="text" placeholder="dd/mm/aaaa hh:mm:ss" name="fimTorneio" id="url" value="<?php echo date("d/m/Y H:i:s", strtotime($campeonato['fim'])) ?>" class="form-control" data-mask="00/00/0000 00:00:00">
                                    </div>

                                    

                                    <div class="form-group col-md-3">
                                        <label for="precheckin">Pré Check-in (minutos)</label>
                                        <input type="number" placeholder="MINUTOS" name="minprecheckin" class="form-control" id="precheckin" required value="<?php echo $campeonato['precheckin']; ?>">
                                    </div>                                 
                                    <div class="form-group col-md-6">
                                        <label for="logoCamp">Logo do Torneio (500x500px)</label>
                                        <input type="file" name="logo" class="form-control">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="submit" value="ATUALIZAR" class="btn btn-dark">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">                              
                                <br>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <div class="border p-3 text-center">
                                            <label for="descricao" class="h4">Descrição do Torneio</label>
                                            <textarea name="descricao" id="descricao" class="form-control" cols="30" rows="10" placeholder="DESCRIÇÃO"><?php echo $campeonato['descricao']; ?></textarea>
                                        </div>                                        
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="border p-3 text-center">
                                            <label for="regulamento" class="h4">Regulamento</label>
                                            <textarea name="regulamento" id="regulamento" class="form-control" cols="30" rows="10" placeholder="REGULAMENTO" required><?php echo $campeonato['regulamento']; ?></textarea>
                                        </div>                                            
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="border p-3 text-center">
                                            <label for="premiacao" class="h4">Premiação Fora do Padrão?</label>
                                            <textarea name="premiacao" id="premiacao" class="form-control" cols="30" rows="10" placeholder="Premiações em R$ ou e$ são configurados na aba 'Premiação Automática'" required><?php echo $campeonato['premiacao']; ?></textarea>
                                        </div>                                            
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="border p-3 text-center">
                                            <label for="cronograma" class="h4">Cronograma Completo da Competição</label>
                                            <textarea name="cronograma" id="cronograma" class="form-control" cols="30" rows="10" placeholder="Exemplo: 05/06/2019 13h00 -> Início do Pré Check-in" required><?php echo $campeonato['cronograma']; ?></textarea>
                                        </div>                                            
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="local">Local / Estado</label>
                                        <input type="text" name="local" placeholder="Local" id="local" class="form-control" value="<?php echo $campeonato['local']; ?>">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="pais">País</label>
                                        <input type="text" name="pais" placeholder="País" id="pais" value="<?php echo $campeonato['pais']; ?>" class="form-control">
                                    </div>                                
                                    <div class="form-group col-md-6">
                                        <input type="submit" value="ATUALIZAR" class="btn btn-dark">
                                    </div>
                                </div>
                            </div>				
                        </div>
                    </form>	
                </div>
            </div>
        </div>

        <?php include "../../../footer.php"; ?>
        
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=xk83vu3tqnzfzqfckbr4scsj3mzmi8cqvi6s0u6ed34nfnxu"></script>
        <script type="text/javascript">
			jQuery(function($){
				$('#myTab li:first-child a').tab('show');
				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
				  e.target // newly activated tab
				  e.relatedTarget // previous active tab
				});
                tinymce.init({
                   selector: "#descricao",
                    toolbar: 'styleselect | bold, italic, underline, strikethrough | alignleft, aligncenter, alignright, alignjustify | bullist, numlist, outdent, indent, undo, redo',
                    menubar: false
                    
                });
                tinymce.init({
                    selector: '#regulamento',
                    theme: 'modern',
                    height: 300,
                    plugins: [
                      'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                      'save table contextmenu directionality emoticons template paste textcolor'
                    ],
                    content_css: 'css/content.css',
                    toolbar: 'insertfile undo redo | styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media preview fullpage',
                    menubar: false
                  });
                tinymce.init({
                   selector: "#premiacao",
                    toolbar: 'styleselect | bold, italic, underline, strikethrough | alignleft, aligncenter, alignright, alignjustify | bullist, numlist, outdent, indent, undo, redo',
                    menubar: false
                    
                });
                tinymce.init({
                   selector: "#cronograma",
                    toolbar: 'styleselect | bold, italic, underline, strikethrough | alignleft, aligncenter, alignright, alignjustify | bullist, numlist, outdent, indent, undo, redo',
                    menubar: false
                    
                });
			});
		</script>
    </body>
</html>