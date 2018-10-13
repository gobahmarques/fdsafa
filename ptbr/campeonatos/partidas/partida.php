<?php
    include "../../../enderecos.php";
    include "../../../session.php";

    $campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_GET['codigo'].""));
	$organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$campeonato['cod_organizacao'].""));
	$jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogos WHERE codigo = ".$campeonato['cod_jogo']." "));
	$partida = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE codigo = ".$_GET['partida']." "));
	$etapa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_etapa = ".$partida['cod_etapa']." AND cod_campeonato = ".$partida['cod_campeonato']."  "));
	$datahora = date("Y-m-d H:i:s");
	$inicioCheckin = date("Y-m-d H:i:s", strtotime("-15minutes", strtotime($partida['datahora'])));
	$fimCheckin = date("Y-m-d H:i:s", strtotime("+15minutes", strtotime($partida['datahora'])));
	$datalimite = date("Y-m-d H:i:s", strtotime($partida['datalimite']));

	if(isset($usuario['codigo'])){
		$pesquisaFuncao = mysqli_query($conexao, "SELECT * FROM jogador_organizacao WHERE cod_organizacao = ".$organizacao['codigo']." AND cod_jogador = ".$usuario['codigo']." ");
		$funcao = mysqli_fetch_array($pesquisaFuncao);
		
		$pesquisaPosicao = mysqli_query($conexao, "
			SELECT * FROM campeonato_partida_semente
			INNER JOIN campeonato_etapa_semente ON campeonato_partida_semente.cod_semente = campeonato_etapa_semente.codigo
			WHERE campeonato_etapa_semente.cod_jogador = ".$usuario['codigo']."
			AND campeonato_partida_semente.cod_partida = ".$partida['codigo']."
		");
		if(mysqli_num_rows($pesquisaPosicao) == 0){
			$pesquisaPosicao = mysqli_query($conexao, "
				SELECT * FROM campeonato_partida_semente
				INNER JOIN campeonato_etapa_semente ON campeonato_partida_semente.cod_semente = campeonato_etapa_semente.codigo
				INNER JOIN campeonato_lineup ON campeonato_etapa_semente.cod_equipe = campeonato_lineup.cod_equipe
				WHERE campeonato_lineup.cod_jogador = ".$usuario['codigo']."
				AND campeonato_partida_semente.cod_partida = ".$partida['codigo']."
				AND campeonato_lineup.cod_campeonato = ".$campeonato['codigo']."
			");
			if(mysqli_num_rows($pesquisaPosicao) != 0){
				$vagaAtual = mysqli_fetch_array($pesquisaPosicao);
			}
		}else{
			$vagaAtual = mysqli_fetch_array($pesquisaPosicao);
		}
				
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

        <title>Partida <?php echo $partida['codigo']; ?> - <?php echo $campeonato['nome']; ?> | e-Sports Cups</title>
    </head>
    <body>
        <?php include "../../header.php"; ?>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb caminhoNavegacao">
                    <li class=""><a href="ptbr/campeonato/<?php echo $campeonato['codigo']; ?>/"><?php echo $campeonato['nome']; ?></a></li>
                    <li class=""><a href="ptbr/campeonato/<?php echo $campeonato['codigo']; ?>/etapa/<?php echo $etapa['cod_etapa']; ?>/"><?php echo $etapa['nome']; ?></a></li>
                    <li class="ativo" aria-current="page"><?php echo "Partida ".$partida['codigo']; ?></li>
                </ul>
            </nav>
        </div>      
        <?php
            include "partida-perfil.php";
            if(isset($sementeUm) && isset($sementeDois) && $partida['status'] == 1 && isset($usuario['codigo'])){
                include "painel-usuario.php";
            }
            if(isset($usuario['codigo']) && mysqli_num_rows($pesquisaFuncao) != 0){
                if($campeonato['status'] < 2){
                    include "painel-admin.php";    
                }                
            }
        ?>
        
        <?php include "../../footer.php"; ?>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
        <script src="<?php echo $js; ?>partida.js"></script>
        <script>
            function realizarCheckin(partida, jogador){
                $.ajax({
                    type: "POST",
                    url: "scripts/realizar-checkin-partida.php",
                    data: "partida="+partida+"&jogador="+jogador,
                    success: function(resposta){
                        location.reload();
                    }
                })
            }
            function validar(){
                var counter = $('.limitado:checked').length;
                var limit = <?php echo $campeonato['qtd_ban']; ?>;
                if(counter < limit){
                    alert("É obrigatório selecionar "+limit+" banimentos!");
                    return false;
                }else{
                    return true;
                }
            }
            function enviarPlacar(codSemente, codPartida){
                $.ajax({
                    type: "POST",
                    url: "scripts/partida-placar.php",
                    data: $("#formPlacar").serialize()+"&partida="+codPartida+"&semente="+codSemente+"&funcao=enviar",
                    success: function(resposta){
                        location.reload();
                        return false;
                    }
                })
                return false;
            }
            function reenviarPlacar(codSemente, codPartida){
                $.ajax({
                    type: "POST",
                    url: "scripts/partida-placar.php",
                    data: "partida="+codPartida+"&semente="+codSemente+"&funcao=reenviar",
                    success: function(resposta){
                        location.reload();
                        return false;
                    }
                })
                return false;
            }
            function receberWo(codPartida, codSemente){
                $.ajax({
                    type: "POST",
                    url: "scripts/partida-placar.php",
                    data: "partida="+codPartida+"&semente="+codSemente+"&funcao=wo",
                    success: function(resposta){
                        location.reload();
                    }
                })
            }
            function carregarMsgEquipe(codEquipe, codJogador, codPartida){
                $.ajax({
                    type: "POST",
                    url: "scripts/funcoes-lobby.php",
                    data: "funcao=13&codequipe="+codEquipe+"&jogador="+codJogador,
                    success: function(resultado){
                        $(".mensagens").html(resultado);
                        $(".mensagens").animate({
                            scrollTop: $(".mensagens").height()+20000000
                        }, 500);
                        return false;
                    }
                });	
            }
            function carregarMsgOponente(codPartida, codJogador){
                $.ajax({
                    type: "POST",
                    url: "ptbr/campeonatos/partidas/scripts.php",
                    data: "funcao=2&codpartida="+codPartida+"&jogador="+codJogador,
                    success: function(resultado){
                        $(".mensagens").html(resultado);
                        $(".mensagens").animate({
                            scrollTop: $(".mensagens").height()+20000000
                        }, 500);
                        return false;
                    }
                });	
            }
            function enviarMsgEquipe(codEquipe, codJogador, codPartida){
                if($(".msgParaEquipe").val() != ""){
                    $.ajax({
                        type: "POST",
                        url: "ptbr/campeonatos/partidas/scripts.php",
                        data: $("#msgEquipe").serialize()+"&funcao=4&codpartida="+codPartida+"&codequipe="+codEquipe+"&jogador="+codJogador,
                        success: function(resultado){
                            $(".mensagem").val("");
                            $(".mensagem").focus();
                            carregarMsgEquipe(codEquipe, codJogador, codPartida);
                            return false;
                        }
                    });	
                    return false;
                }
                return false;
            }
            function enviarMsgOponente(codPartida, codJogador){
                if($(".msgParaGeral").val() != ""){
                    $.ajax({
                        type: "POST",
                        url: "ptbr/campeonatos/partidas/scripts.php",
                        data: $("#msgGeral").serialize()+"&funcao=3&codpartida="+codPartida+"&jogador="+codJogador,
                        success: function(resultado){
                            $(".mensagem").val("");
                            $(".mensagem").focus();
                            carregarMsgOponente(codPartida, codJogador);
                            return false;
                        }
                    });	
                    return false;
                }
                return false;
            }
            function abaChat(aba){
                switch(aba){
                    case '0': // CHAT EQUIPE				
                        $(".chatEquipe").addClass("ativo");
                        $(".chatGeral").removeClass("ativo");
                        $("#msgEquipe").css("display", "block");
                        $("#msgGeral").css("display", "none");
                        <?php
                            if(mysqli_num_rows($pesquisaPosicao) != 0){
                                if($vagaAtual['cod_equipe'] == NULL){
                                ?>
                                    abaChat('1');
                                <?php
                                }else{
                                ?>
                                    conectarChatEquipe(<?php echo $vagaAtual['cod_equipe']; ?>, <?php echo $usuario['codigo']; ?>,<?php echo $partida['codigo']; ?>);
                                    desconectarChatOponente(<?php echo $partida['codigo']; ?>);
                                    carregarMsgEquipe(<?php echo $vagaAtual['cod_equipe']; ?>,<?php echo $usuario['codigo']; ?>,<?php echo $partida['codigo']; ?>);
                                <?php
                                }
                            }	
                        ?>				
                        break;
                    case '1': // CHAT OPONENTE
                        $(".chatGeral").addClass("ativo");
                        $(".chatEquipe").removeClass("ativo");
                        $(".chatSuporte").removeClass("ativo");
                        $("#msgEquipe").css("display", "none");
                        $("#msgGeral").css("display", "block");
                        $("#msgSuporte").css("display", "none");
                        <?php
                            if(mysqli_num_rows($pesquisaPosicao) != 0){
                            ?>
                                conectarChatOponente(<?php echo $partida['codigo']; ?>, <?php echo $usuario['codigo']; ?>);
                                desconectarChatEquipe(<?php echo $vagaAtual['cod_equipe']; ?>);
                                carregarMsgOponente(<?php echo $partida['codigo']; ?>,<?php echo $usuario['codigo']; ?>);
                            <?php
                            }	
                        ?>	
                        break;		
                }
            }

            $(document).on('click', '.limitado', function(){
                var limit = <?php echo $campeonato['qtd_ban']; ?>;
                var counter = $('.limitado:checked').length;
                if(counter > limit) {
                    this.checked = false;  
                    alert('Só é possível realizar '+limit+' banimento!');
                }
            });
            jQuery(function($){
                conectarPartida(<?php echo $partida['codigo']; ?>);
                abaChat('1');
            });	
        </script>
    </body>
</html>