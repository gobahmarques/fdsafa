<?php
    include "../../enderecos.php";
    include "../../session.php";
    $lobby = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM lobby WHERE codigo = ".$_GET['codigo'].""));
	$equipes = mysqli_query($conexao, "SELECT * FROM lobby_equipe WHERE cod_lobby = ".$lobby['codigo']." ORDER BY codigo");
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

        <title><?php echo $lobby['nome']; ?> | e-Sports Cups</title>
    </head>
    <body>
        <?php include "../header.php"; ?>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="row">
                    <?php
                        while($equipe = mysqli_fetch_array($equipes)){
                            $seeds = mysqli_query($conexao, "SELECT * FROM lobby_equipe_semente WHERE cod_equipe = ".$equipe['codigo']." ORDER BY posicao");
                            $pesquisaConflito = mysqli_query($conexao, "SELECT * FROM lobby_resultado WHERE cod_equipe = ".$equipe['codigo']." AND conflito = 1");
                        ?>
                        <div class="col-6 col-md-4">
                            <div class="equipe <?php echo "equipe".$equipe['codigo']; ?>" <?php if(mysqli_num_rows($pesquisaConflito) != 0){ echo "onClick='mostrarVotos(".$equipe['codigo'].",".$lobby['codigo'].")'"; } ?>>
                                <h2>
                                <?php
                                    echo $equipe['nome']; 
                                    if($equipe['posicao'] != 0){
                                        echo " - #".$equipe['posicao'];
                                    }
                                ?>
                                </h2>	
                                <ul class="membros <?php echo "membros".$equipe['codigo']; ?>">
                                <?php
                                    while($semente = mysqli_fetch_array($seeds)){
                                        if($semente['cod_jogador'] != NULL){
                                            $jogador = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$semente['cod_jogador']." "));
                                        ?>
                                            <li class="<?php if($semente['status'] == 1){ echo "ready"; }  ?>">
                                                <?php
                                                    if($semente['capitao'] == 1){
                                                    ?>
                                                        <img src="../img/capitao.png" alt="" class="iconeCapitao">
                                                    <?php
                                                    }
                                                ?>
                                                <img class="fotoMembro" src="img/<?php echo $jogador['foto_perfil']; ?>" alt="<?php echo $membro['nick']; ?>" title="<?php echo $jogador['nick']; ?>">
                                                <?php 
                                                    echo $jogador['nick'];
                                                    if(isset($usuario['codigo']) && ($semente['cod_jogador'] == $usuario['codigo'] || $usuario['codigo'] == $lobby['cod_jogador']) && $lobby['status'] == 0){ // JOGADOR LOGADO É O JOGADOR DO SLOT
                                                        echo "<img src='img/icones/recusar.png' class='sairSlot' onClick='sairSlot(".$semente['codigo'].",".$lobby['codigo'].");'>";
                                                    }
                                                ?>
                                                <div class="palpite">
                                                    <img src="../img/icones/escoin.png" alt=""> <?php echo $semente['palpite']; ?>
                                                </div>
                                            </li>
                                        <?php	
                                        }elseif(isset($usuario['codigo'])){
                                        ?>
                                            <li class="vaga" onClick='vagaEspecifica(<?php echo $usuario['codigo'].",".$lobby['codigo'].",".$semente['codigo']; ?>);'>
                                                <img class="fotoMembro" src="img/usuarios/padrao.jpg" alt="<?php echo $membro['nick']; ?>" title="<?php echo $membro['nick']; ?>">
                                                OCUPAR VAGA
                                            </li>
                                        <?php	
                                        }						
                                    }
                                ?>
                                </ul>
                            </div>
                        </div>
                        
                        <?php
                        }
                    ?>	
                    </div>  
                </div>
                <div class="col-12 col-md-4">
                    <div class="barraInfos">
                        <?php
                            if((isset($usuario['codigo']) && $usuario['codigo'] == $lobby['cod_jogador'] && $lobby['status'] == 0) || $usuario['codigo'] == 639282 ){
                                echo "<input type='button' value='EXCLUIR LOBBY' class='btn btn-dark' onClick='excluirLobby(".$lobby['codigo'].")' style='margin: 0px auto;'><br>";
                            }
                        ?>
                        <div class="infos">				
                            <h1>
                                <?php
                                    switch($lobby['cod_jogo']){
                                        case 369: // HEARTHSTONE
                                            echo "<img src='img/icones/hearthstone.png' alt='Hearthstone' title='Hearthstone'>";
                                            break;
                                        case 147: // League of Legends
                                            echo "<img src='img/icones/lol.png' alt='League of Legends' title='League of Legends'>";
                                            break;
                                        case 357: // Dota 2
                                            echo "<img src='img/icones/dota2.png' alt='Dota 2' title='Dota 2'>";
                                            break;
                                        case 258: // Overwatch
                                            echo "<img src='img/icones/overwatch2.png' alt='Overwatch' title='Overwatch'>";
                                            break;
                                        case 741: // PUBG
                                            echo "<img src='https://www.esportscups.com.br/img/icones/pubg.png' alt='Overwatch' title='Overwatch'>";
                                            break;
                                    }
                                    echo $lobby['nome'];
                                ?>
                            </h1>
                            <p>ID Lobby: <?php echo $lobby['codigo']." - <strong>MD ".$lobby['tipo']."</strong>"; ?></p>				
                            <label for="infos">
                                SOBRE O LOBBY
                            </label>
                        </div>
                        <div class="pote">	
                            <?php
                                $soma = mysqli_fetch_array(mysqli_query($conexao, "
                                    SELECT SUM(lobby_equipe_semente.palpite) AS soma FROM lobby_equipe_semente
                                    INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
                                    WHERE lobby_equipe.cod_lobby = ".$lobby['codigo']."
                                "));
                                $soma['soma'] = $soma['soma'] + $lobby['pote_inicial'];
                            ?>
                            <p class="duvida">?</p>
                            <p class="valorPote"><img src="img/icones/escoin.png" alt="" class="iconeCoin"><?php echo $soma['soma']; ?></p>
                            <label for="infos">					
                                POTE
                            </label>
                        </div>
                        <div class="slots">

                            <?php
                                $qtdOcupadas = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM lobby_equipe_semente 
                                INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
                                WHERE lobby_equipe_semente.cod_jogador is not null AND lobby_equipe.cod_lobby = ".$lobby['codigo'].""));
                                $qtdProntos = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM lobby_equipe_semente 
                                INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
                                WHERE lobby_equipe_semente.status = 1 AND lobby_equipe.cod_lobby = ".$lobby['codigo']." "));
                            ?>
                            <h2 class="slotsTxt"><?php echo $qtdOcupadas." / ".$lobby['times']*$lobby['jogador_por_time']; ?></h2>
                            <label for="infos">
                                VAGAS
                            </label>
                        </div>
                        <div class="texto">				
                            <?php
                                if($lobby['status'] == 0){
                                    echo "<img src='img/icones/loading.gif' title='Aguardando Jogadores' alt='Aguardando...' /><br><p>Aguardando Jogadores...</p>";
                                }elseif($lobby['status'] == 1){
                                    echo "<img src='img/icones/loading.gif' title='Em Andamento...' alt='Em Andamento...' /><br>
                                    <p>Em Andamento</p>";
                                }elseif($lobby['status'] == 2){
                                    echo "<img src='img/icones/aprovar.png' title='Lobby Finalizado' alt='Lobby Finalizado' /><br>
                                    <h2>Concluído</h2>";
                                }
                            ?>
                            <label for="infos">
                                STATUS
                            </label>
                        </div>
                        <?php
                            if(isset($usuario['codigo'])){ // USUÁRIO ESTÁ LOGADO
                                $pesquisaPosicao = mysqli_query($conexao, "SELECT *, lobby_equipe_semente.codigo AS codSeed FROM lobby_equipe_semente 
                                    INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
                                    WHERE lobby_equipe.cod_lobby = ".$lobby['codigo']." AND lobby_equipe_semente.cod_jogador = ".$usuario['codigo']." ");
                                $vagaAtual = mysqli_fetch_array($pesquisaPosicao);
                                if($lobby['status'] == 0) { // LOBBY EM ABERTO								
                                    if($qtdOcupadas < ($lobby['times']*$lobby['jogador_por_time'])){ // POSSUI SLOT VAGO
                                        if(mysqli_num_rows($pesquisaPosicao) == 0){ // AINDA NÃO OCUPA SLOT
                                            echo "<input type='button' value='VAGA ALEATÓRIA' class='vagarapida' onClick='vagaAleatoria(".$usuario['codigo'].",".$lobby['codigo'].");'>";	
                                        }
                                    }else{ // NÃO POSSUI SLOT VAZIO
                                        if(mysqli_num_rows($pesquisaPosicao) != 0){ // OCUPA UM SLOT
                                            ?>
                                                <div class="opcoesAposta">
                                                    <input type='button' value='e$ 50' class='btPalpite <?php if($vagaAtual['palpite'] == 50){ echo "ativo";} ?>' onClick='palpite(50, <?php echo $vagaAtual['codSeed']; ?>, <?php echo $lobby['codigo']; ?>);'>
                                                    <input type='button' value='e$ 100' class='btPalpite <?php if($vagaAtual['palpite'] == 100){ echo "ativo";} ?>' onClick='palpite(100, <?php echo $vagaAtual['codSeed']; ?>, <?php echo $lobby['codigo']; ?>);'>
                                                    <input type='button' value='e$ 250' class='btPalpite <?php if($vagaAtual['palpite'] == 250){ echo "ativo";} ?>' onClick='palpite(250, <?php echo $vagaAtual['codSeed']; ?>, <?php echo $lobby['codigo']; ?>);'>
                                                    <input type='button' value='e$ 500' class='btPalpite <?php if($vagaAtual['palpite'] == 500){ echo "ativo";} ?>' onClick='palpite(500, <?php echo $vagaAtual['codSeed']; ?>, <?php echo $lobby['codigo']; ?>);'>
                                                    <input type='button' value='e$ 1000' class='btPalpite <?php if($vagaAtual['palpite'] == 1000){ echo "ativo";} ?>' onClick='palpite(1000, <?php echo $vagaAtual['codSeed']; ?>, <?php echo $lobby['codigo']; ?>);'><br>
                                                    <label for="infos">
                                                        QUANTO VALE SUA VIT&Oacute;RIA?
                                                    </label>	
                                                </div>
                                            <?php

                                            if($vagaAtual['status'] == 0){
                                                echo "<input type='button' value='ESTOU PRONTO' class='vagarapida estoupronto' onClick='checkin(".$usuario['codigo'].",".$lobby['codigo'].",1);'>";	
                                            }else{
                                                echo "<input type='button' value='NÃO ESTOU PRONTO' class='vagarapida naoestoupronto' onClick='checkin(".$usuario['codigo'].",".$lobby['codigo'].",0);'>";
                                            }
                                        }
                                    }
                                }elseif($lobby['status'] == 1){ // LOBBY EM ANDAMENTO
                                    if(mysqli_num_rows($pesquisaPosicao) != 0){ // OCUPA ALGUM SLOT				

                                        $resultadoEquipe = mysqli_query($conexao, "
                                            SELECT * FROM lobby_resultado WHERE cod_equipe = ".$vagaAtual['cod_equipe']."
                                        ");
                                        if(mysqli_num_rows($resultadoEquipe) == 0){ // EQUIPE AINDA NAO LANÇOU RESULTADO
                                            if($vagaAtual['capitao'] == 1){ // É CAPITÃO DA EQUIPE
                                            ?>
                                                <div class="analise">
                                                    <form method='post' action='scripts/funcoes-lobby.php' enctype='multipart/form-data'>
                                                        <h3>ScreenShot</h3>
                                                        <input type='file' name='screenshot' id="screenshot" require>
                                                        <label for="screenshot" id="labelss">ESCOLHER ARQUIVO</label><br><br><br>
                                                        <h3>Coloca&ccedil;&atilde;o Final</h3>
                                                        <input type='number' min='1' max="<?php echo $lobby['times']; ?>" name='colocacao' size='60' require><br><br>

                                                        <input type='hidden' name='codequipe' value='<?php echo $vagaAtual['cod_equipe']; ?>'>
                                                        <input type='hidden' name='codlobby' value='<?php echo $lobby['codigo']; ?>'>
                                                        <input type='hidden' name='funcao' value='8'>
                                                        <input type='submit' value='ENVIAR' class='botaoPqLaranja'><br><br>
                                                    </form>
                                                    <label for="infos">
                                                        ENVIAR RESULTADO
                                                    </label>
                                                </div>
                                            <?php
                                            }else{ // NÃO É CAPITAO DA EQUIPE
                                            ?>
                                                <div class="analise">
                                                    Aguardando envio de resultado pelo capit&atilde;o de sua equipe.
                                                    <label for="infos">
                                                        RESULTADO DA SUA EQUIPE
                                                    </label>
                                                </div>
                                            <?php
                                            }
                                        }else{
                                            $resultadoEquipe = mysqli_fetch_array($resultadoEquipe);
                                        ?>
                                            <div class="analise">
                                                VER PRINTSCREEN <br>
                                                VOTOS A FAVOR: <?php echo $resultadoEquipe['pros']; ?><br>
                                                VOTOS CONTRA: <?php echo $resultadoEquipe['contra']; ?><br><br>
                                                VEREDITO: <br>
                                                <label for="infos">
                                                    RESULTADO DA SUA EQUIPE
                                                </label>
                                            </div>
                                        <?php
                                        }							
                                    }
                                }
                            }else{
                            ?>
                                <div class="analise">
                                    <strong>FA&Ccedil;A LOGIN PARA PARTICIPAR DOS LOBBYS</strong>
                                </div>
                            <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
		if(isset($pesquisaPosicao) && mysqli_num_rows($pesquisaPosicao) != 0){
		?>
			<div class="chats">
				<div class="container">
					<div class="suporte">
						<h2>SUPORTE</h2><br>
						Conflito de resultado? Lobby congelado ou travado? Qualquer outro problemas inesperado apareceu? <br><br>
						Caso n&atilde;o consiga solucion&aacute;-lo, basta deixar uma mensagem em nosso servidor Discord e iremos solucionar o mais breve poss&iacute;vel. POR ENQUANTO, &eacute; nossa &uacute;nica forma de contato.<br><br>
						Conte-nos o que ocorreu, envie print (se necess&aacute;rio) e pronto, s&oacute; aguardar. <br><br>
						<a href="https://discord.gg/QNnP9hr" target="_blank"><input type="button" class="botaoMdPreto" value="MANDAR MENSAGEM"></a>
					</div>
					<ul class="abasChat">
						<li class="chatGeral" onClick="trocarAbaLobby('1');">GERAL</li>
						<li class="chatEquipe" onClick="trocarAbaLobby('0');">EQUIPE</li>						
						<!-- <li class="chatSuporte" onClick="trocarAbaLobby('2');">SUPORTE</li> -->
					</ul>
					<div class="chat chatEquipe">
						<div class="mensagens">

						</div>
						<form action="" id="msgEquipe" onSubmit="return enviarMsgEquipe(<?php echo $vagaAtual['cod_equipe']; ?>,<?php echo $usuario['codigo']; ?>);">
							<input type="text" name="mensagem" placeholder="ESCREVER MENSAGEM" class="msgParaEquipe mensagem">
							<input type="submit" value="ENVIAR">
						</form>
						<form action="" id="msgGeral" onSubmit="return enviarMsgGeral(<?php echo $lobby['codigo']; ?>,<?php echo $usuario['codigo']; ?>);">
							<input type="text" name="mensagem" placeholder="ESCREVER MENSAGEM" class="msgParaGeral mensagem">
							<input type="submit" value="ENVIAR">
						</form>
						<form action="" id="msgSuporte" onSubmit="return enviarMsgSuporte();">
							<input type="text" name="mensagem" placeholder="ESCREVER MENSAGEM" class="msgParaSuporte mensagem">
							<input type="submit" value="ENVIAR">
						</form>
					</div>			
				</div>
			</div>
		<?php
		}
        ?>

        <?php include "../footer.php"; ?>
        
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
        <script src="<?php echo $js; ?>lobby.js"></script>
        <script src="js/lobby.js"></script>
        <script src="<?php echo $js; ?>../dota2/examples/example.js"></script>
        <script>
            function excluirLobby(codLobby){
                $.ajax({
                    type: "POST",
                    url: "scripts/funcoes-lobby.php",
                    data: "funcao=1&codlobby="+codLobby,
                    success: function(resultado){
                        window.location.href = "jogar/dota2/";
                    }
                });
            }
            function vagaAleatoria(codJogador, codLobby){
                $.ajax({
                    type: "POST",
                    url: "scripts/funcoes-lobby.php",
                    data: "funcao=2&codlobby="+codLobby+"&jogador="+codJogador,
                    success: function(resultado){
                        location.reload();
                    }
                });
            }
            function vagaEspecifica(codJogador, codLobby, semente){
                $.ajax({
                    type: "POST",
                    url: "scripts/funcoes-lobby.php",
                    data: "funcao=3&codlobby="+codLobby+"&jogador="+codJogador+"&semente="+semente,
                    success: function(resultado){
                        location.reload();
                    }
                });
            }
            function sairSlot(semente, codLobby){
                $.ajax({
                    type: "POST",
                    url: "scripts/funcoes-lobby.php",
                    data: "funcao=4&semente="+semente+"&codlobby="+codLobby,
                    success: function(resultado){
                        location.reload();
                    }
                });
            }
            function checkin(codJogador, codLobby, status){
                $.ajax({
                    type: "POST",
                    url: "scripts/funcoes-lobby.php",
                    data: "funcao=5&codlobby="+codLobby+"&jogador="+codJogador+"&status="+status,
                    success: function(resultado){
                        location.reload();
                    }
                });
            }
            function palpite(valor, codSemente, codLobby){
                if(valor <= <?php echo $usuario['pontos']; ?>){
                   $.ajax({
                        type: "POST",
                        url: "scripts/funcoes-lobby.php",
                        data: "funcao=7&valor="+valor+"&codsemente="+codSemente+"&codlobby="+codLobby,
                        success: function(resultado){
                            location.reload();
                        }
                    });
                }else{
                    alert("Você nao possui e$ (eSCoins) suficientes para essa aposta!");
                }
            }
            function votarResultado(codJogador, codLobby){
                $.ajax({
                    type: "POST",
                    url: "scripts/funcoes-lobby.php",
                    data: "funcao=9&jogador="+codJogador+"&codlobby="+codLobby,
                    success: function(resultado){
                        $("#modal").html(resultado);
                        $("#modal").modal();
                    }
                });
            }
            function mostrarVotos(codEquipe, codLobby){
                $.ajax({
                    type: "POST",
                    url: "scripts/funcoes-lobby.php",
                    data: "funcao=11&codequipe="+codEquipe+"&codlobby="+codLobby,
                    success: function(resultado){	
                        $(".listaVotos").html(resultado);
                    }
                });
            }
            function carregarConflito(codEquipe, codLobby){
                mostrarVotos(codEquipe, codLobby);
                $.ajax({
                    type: "POST",
                    url: "scripts/funcoes-lobby.php",
                    data: "funcao=17&codequipe="+codEquipe+"&codlobby="+codLobby,
                    success: function(resultado){	
                        $(".areaVotacao").html(resultado);
                    }
                });
            }
            function enviarVoto(codJogador, codEquipe, voto, codLobby){
                $.ajax({
                    type: "POST",
                    url: "scripts/funcoes-lobby.php",
                    data: "funcao=10&jogador="+codJogador+"&codequipe="+codEquipe+"&voto="+voto+"&codlobby="+codLobby,
                    success: function(resultado){
                        alert(resultado);
                        location.reload();
                    }
                });
            }

            function carregarMsgEquipe(codEquipe, codJogador){
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
            function carregarMsgGeral(codLobby, codJogador){
                $.ajax({
                    type: "POST",
                    url: "scripts/funcoes-lobby.php",
                    data: "funcao=15&codlobby="+codLobby+"&jogador="+codJogador,
                    success: function(resultado){
                        $(".mensagens").html(resultado);
                        $(".mensagens").animate({
                            scrollTop: $(".mensagens").height()+20000000
                        }, 500);
                        return false;
                    }
                });	
            }
            function enviarMsgEquipe(codEquipe, codJogador){
                if($(".msgParaEquipe").val() != ""){
                    $.ajax({
                        type: "POST",
                        url: "scripts/funcoes-lobby.php",
                        data: $("#msgEquipe").serialize()+"&funcao=12&codequipe="+codEquipe+"&jogador="+codJogador,
                        success: function(resultado){
                            $(".mensagem").val("");
                            $(".mensagem").focus();
                            carregarMsgEquipe(codEquipe, codJogador);
                            return false;
                        }
                    });	
                    return false;
                }
                return false;
            }
            function enviarMsgGeral(codLobby, codJogador){
                if($(".msgParaGeral").val() != ""){
                    $.ajax({
                        type: "POST",
                        url: "scripts/funcoes-lobby.php",
                        data: $("#msgGeral").serialize()+"&funcao=14&codlobby="+codLobby+"&jogador="+codJogador,
                        success: function(resultado){
                            $(".mensagem").val("");
                            $(".mensagem").focus();
                            carregarMsgGeral(codLobby, codJogador);
                            return false;
                        }
                    });	
                    return false;
                }
                return false;
            }
            function trocarAbaLobby(aba){
                switch(aba){
                    case '0': // CHAT EQUIPE
                        $(".chatEquipe").addClass("ativo");
                        $(".chatGeral").removeClass("ativo");
                        $(".chatSuporte").removeClass("ativo");
                        $("#msgEquipe").css("display", "block");
                        $("#msgGeral").css("display", "none");
                        $("#msgSuporte").css("display", "none");
                        <?php
                            if(mysqli_num_rows($pesquisaPosicao) != 0){
                            ?>
                                conectarChatEquipe(<?php echo $vagaAtual['cod_equipe']; ?>, <?php echo $usuario['codigo']; ?>);
                                desconectarChatGeral(<?php echo $lobby['codigo']; ?>);
                                carregarMsgEquipe(<?php echo $vagaAtual['cod_equipe']; ?>,<?php echo $usuario['codigo']; ?>);				
                            <?php
                            }	
                        ?>

                        break;
                    case '1': // CHAT GERAL
                        $(".chatGeral").addClass("ativo");
                        $(".chatEquipe").removeClass("ativo");
                        $(".chatSuporte").removeClass("ativo");
                        $("#msgEquipe").css("display", "none");
                        $("#msgGeral").css("display", "block");
                        $("#msgSuporte").css("display", "none");
                        <?php
                            if(mysqli_num_rows($pesquisaPosicao) != 0){
                            ?>
                                conectarChatGeral(<?php echo $lobby['codigo']; ?>, <?php echo $usuario['codigo']; ?>);
                                desconectarChatEquipe(<?php echo $vagaAtual['cod_equipe']; ?>);
                                carregarMsgGeral(<?php echo $lobby['codigo']; ?>,<?php echo $usuario['codigo']; ?>);
                            <?php
                            }	
                        ?>	
                        break;
                    case '2': // CHAT SUPORTE
                        $(".chatSuporte").addClass("ativo");
                        $(".chatGeral").removeClass("ativo");
                        $(".chatEquipe").removeClass("ativo");
                        $("#msgEquipe").css("display", "none");
                        $("#msgGeral").css("display", "none");
                        $("#msgSuporte").css("display", "block");
                        break;
                }	
            }
            jQuery(function($){
                conectarLobby(<?php echo $lobby['codigo']; ?>,<?php echo $usuario['codigo']; ?>);
            <?php
                $votosFeitos = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM lobby_resultado_voto
                INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_resultado_voto.cod_equipe
                WHERE lobby_resultado_voto.cod_jogador = ".$usuario['codigo']." AND lobby_equipe.cod_lobby = ".$lobby['codigo']."
                "));
                $totalResultados = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM lobby_resultado
                INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_resultado.cod_equipe
                WHERE lobby_equipe.cod_lobby = ".$lobby['codigo']." AND lobby_resultado.conflito = 1
                "));
                if($votosFeitos < $totalResultados){
                ?>
                    votarResultado(<?php echo $usuario['codigo'].",".$lobby['codigo']; ?>);
                <?php	
                }
                if(mysqli_num_rows($pesquisaPosicao) != 0){			
                ?>
                    trocarAbaLobby('1');
                <?php
                }	
            ?>
                $("#screenshot").change(function(){
                    $("#labelss").html($("#screenshot").val());
                });
                $(".menuPrincipalHeader li").removeClass("ativo");
                $(".menuPrincipalHeader .lobbys").addClass("ativo");
            });	
        </script>
    </body>
</html>