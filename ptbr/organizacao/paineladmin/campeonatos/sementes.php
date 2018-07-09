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
                    <div class="listagemSementes">
                        <h3>Sementes</h3>
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
                            window.location = "organizacao/<?php echo $organizacao['codigo']; ?>/painel/campeonato/"+codCampeonato+"/etapas/";
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