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
                <div class="col-12 col-md-3">
                    <?php
                        include "../perfil.php";
                    ?>
                </div>
                <div class="col-12 col-md-9">
                    <ul class="navegacaoPainel">
                        <li><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/"><?php echo $organizacao['nome']; ?></a></li>
                        <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/"><li >Campeonatos</li></a>
                        <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/campeonato/<?php echo $campeonato['codigo']; ?>/"><li><?php echo $campeonato['nome']; ?></li></a>
                        <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/campeonato/<?php echo $campeonato['codigo']; ?>/etapas/"><li>Tabelas e Partidas</li></a>
                        <li class="ativo"><?php echo $etapa['cod_etapa']." - ".$etapa['nome']; ?></li>
                    </ul>
                    <div class="row">
                        <div class="col">
                            <input type="button" value="Apagar Tabela" class="btn btn-dark" onClick="apagarEtapa(<?php echo $etapa['cod_etapa']; ?>, <?php echo $etapa['cod_campeonato']; ?>);">
                            <input type="button" value="Recomeçar" class="btn btn-azul" onClick="resetarEtapa(<?php echo $etapa['cod_etapa'].", ".$campeonato['codigo']; ?>);">
                            <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/campeonato/<?php echo $campeonato['codigo']; ?>/etapa/<?php echo $etapa['cod_etapa']; ?>/sementes/"><input type="button" value="Preencher Sementes" class="btn btn-azul"></a>
                        </div> 
                        <div class="col">
                            <input type="button" value="Liberar Tabela" class="btn btn-dark" onClick="statusPartida(1);">
				            <input type="button" value="Bloquear Tabela" class="btn btn-laranja" onClick="statusPartida(0);">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <br>
                    <?php
                        require "../../../../scripts/carregar-bracket-painel-organizacao.php";
                        switch($etapa['tipo_etapa']){
                            case 1: // ELIMINAÇÃO SIMPLES
                                elimSimples($_GET['etapa'], $campeonato['codigo']);	
                                break;
                            case 2: // GRUPOS PONTOS CORRIDOS
                                gruposPontosCorridos($etapa, $campeonato);
                                break;
                            case 3:
                                elimDupla($_GET['etapa'], $campeonato['codigo']);
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
            function selecionarEtapa(etapa, campeonato, vagas){
                $.ajax({
                    type: "POST",
                    url: "scripts/etapa.php",
                    data: "funcao=carregarjogadores&etapa="+etapa+"&campeonato="+campeonato+"&vagas="+vagas,
                    success: function(resposta){
                        $(".listajogadores").html(resposta);
                    }
                })
            }
            function painelSementes(codcampeonato, codetapa){
                $(".painelSementes").load("ptbr/organizacao/paineladmin/campeonatos/painel-sementes.php?campeonato="+codcampeonato+"&etapa="+codetapa);
                setTimeout(function(){
                    // selecionarEtapa(0,codcampeonato, codetapa);
                }, 200);                
            }
            function distJogadores(funcao){
                var resposta = confirm("REDISTRIBUIR SEMENTES? Esta ação não poderá ser desfeita!");		
                if(resposta == true){
                    var torneio = <?php echo $_GET['torneio']; ?>;
                    var etapa = <?php echo $_GET['etapa']; ?>;
                    $.ajax({
                        type: "POST",
                        url: "scripts/distribuir-jogadores.php",			
                        data: "funcao="+funcao+"&campeonato="+torneio+"&etapa="+etapa+"",
                        success: function(mensagem){
                            location.reload();
                        }
                    });
                }		
            }
            function statusPartida(status){
                var torneio = <?php echo $_GET['torneio']; ?>;
                var etapa = <?php echo $_GET['etapa']; ?>;
                $.ajax({
                    type: "POST",
                    url: "scripts/status-partida.php",			
                    data: "campeonato="+torneio+"&etapa="+etapa+"&status="+status,
                    success: function(mensagem){
                        location.reload();
                    }
                });
            }
            function resetarEtapa(codEtapa, codCampeonato){
                var resposta = confirm("Deseja realmente RESETAR esta etapa? Esta ação não poderá ser desfeita!");		
                if(resposta == true){
                    $.ajax({
                        type: "POST",
                        url: "scripts/etapa.php",			
                        data: "etapa="+codEtapa+"&funcao=resetar&campeonato="+codCampeonato,
                        success: function(mensagem){
                            alert(mensagem);
                        }
                    });
                }		
            }
            function apagarEtapa(codEtapa, codCampeonato){
                var resposta = confirm("Deseja realmente EXCLUIR esta etapa? Esta ação não poderá ser desfeita!");		
                if(resposta == true){
                    $.ajax({
                        type: "POST",
                        url: "scripts/etapa.php",			
                        data: "etapa="+codEtapa+"&funcao=apagar&campeonato="+codCampeonato,
                        success: function(mensagem){
                            alert(mensagem);
                            window.location.href = "organizacao/<?php echo $organizacao['codigo']; ?>/painel/campeonato/"+codCampeonato+"/etapas/";
                        }
                    });	
                }		
            }
            function validar(){
                var counter = $('.limitado3:checked').length;
                var limit = <?php echo $etapa['vagas']; ?>;

                if(counter != limit){
                    alert('É obrigatório selecionar '+limit+' avanços!');
                    return false;
                }else{
                    return true;
                }
                return false;
            }
            $(document).on('click', '.limitado3', function(){
               
                var limit = <?php echo $etapa['vagas']; ?>;                
                var counter = $('.limitado3:checked').length;
                alert(counter);
                if(counter > limit) {
                    this.checked = false;
                    alert('Só é permito selecionar '+limit+' jogadores!');
                }
            });
        </script>
    </body>
</html>