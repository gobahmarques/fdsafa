<?php
	include "../../../../conexao-banco.php";
	$etapa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_etapa = ".$_GET['etapa']." AND cod_campeonato = ".$_GET['campeonato']." "));
    $campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_GET['campeonato']." "));
?>

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


<script>
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
</script>