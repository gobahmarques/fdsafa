<?php
    include "../../enderecos.php";
    include "../../session.php";

    $codJogo = $_GET['jogo'];
	$jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogos WHERE codigo = $codJogo"));
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

        <title>Disputar partidas de Dota 2, Hearthstone, GWENT, League of Legends, Overwatch ou Clash Royale | e-Sports Cups</title>
    </head>
    <body>
        <?php include "../header.php"; ?>
        
        <div id="sideBarJogos" class="sidenav">
            <li>Filtros de Busca</li>
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="ptbr/jogar/dota2/"><img src="img/icones/dota2.png" height="20px"> Dota 2</a>
            <a href="ptbr/jogar/gwent/"><img src="img/icones/gwent.png" height="20px" > GWENT</a>
            <a href="ptbr/jogar/hearthstone/"><img src="img/icones/hs.png" height="20px" > Hearthstone</a>
            <a href="ptbr/jogar/lol/"><img src="img/icones/lol.png" height="20px" > League of Legends</a>
            <a href="ptbr/jogar/overwatch/"><img src="img/icones/overwatch2.png" height="20px" > Overwatch</a>
        </div>
        <div onclick="openNav();" class="botaoMenuJogos">open</div>
        
        <ul class="menuJogar">
            <div class="container">
                <li class="campeonatos ativo" onclick="trocarAba(2)">Campeonatos</li>
                <li class="lobbys" onclick="trocarAba(1);">Lobbys</li>
            </div>
        </ul>
        
        <div class="container">
            <div class="carregarConteudo">
                    
            </div>           
        </div>
        
        <?php include "../footer.php"; ?>
        
        

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script>
            function trocarAba2(numero){
                $(".cupsDestaques").removeClass("ativo");
                $(".cupsPassados").removeClass("ativo");
                $(".cupsAbertos").removeClass("ativo");
                $(".cupsAndamento").removeClass("ativo");
                $(".cupsBreve").removeClass("ativo");
                switch(numero){
                    case 1: // DESTAQUES
                        $.ajax({
                            type: "POST",
                            url: "scripts/carregar-torneios.php",
                            data: "codjogo=<?php echo $codJogo; ?>&funcao="+numero,
                            success: function(resultado){
                                $(".carregarConteudo").html(resultado);
                                $(".cupsDestaques").addClass("ativo");
                                return false;
                            }
                        });
                        break;
                    case 2: // PASSADOS
                        $.ajax({
                            type: "POST",
                            url: "scripts/carregar-torneios.php",
                            data: "codjogo=<?php echo $codJogo; ?>&funcao="+numero,
                            success: function(resultado){
                                $(".carregarConteudo").html(resultado);
                                $(".cupsPassados").addClass("ativo");
                                return false;
                            }
                        });
                        break;
                    case 3: // INSCRIÇÕES ABERTAS
                        $.ajax({
                            type: "POST",
                            url: "scripts/carregar-torneios.php",
                            data: "codjogo=<?php echo $codJogo; ?>&funcao="+numero,
                            success: function(resultado){
                                $(".carregarConteudo").html(resultado);
                                $(".cupsAbertos").addClass("ativo");
                                return false;
                            }
                        });
                        break;
                    case 4: // EM ANDAMENTO
                        $.ajax({
                            type: "POST",
                            url: "scripts/carregar-torneios.php",
                            data: "codjogo=<?php echo $codJogo; ?>&funcao="+numero,
                            success: function(resultado){
                                $(".carregarConteudo").html(resultado);
                                $(".cupsAndamento").addClass("ativo");
                                return false;
                            }
                        });
                        break;
                    case 5: // EM BREVE
                        $.ajax({
                            type: "POST",
                            url: "scripts/carregar-torneios.php",
                            data: "codjogo=<?php echo $codJogo; ?>&funcao="+numero,
                            success: function(resultado){
                                $(".carregarConteudo").html(resultado);
                                $(".cupsBreve").addClass("ativo");
                                return false;
                            }
                        });
                        break;
                }
            }
            function trocarAba(numero){
                $(".campeonatos").removeClass("ativo");
                $(".lobbys").removeClass("ativo");	
                $(".sitego").removeClass("ativo");
                
                $(".campeonatosPagina").css("display", "none");
                $(".lobbysPagina").css("display", "none");
                $(".sitegoPagina").css("display", "none");
                switch(numero){
                    case 2: // CAMPEONATOS
                        $.ajax({
                            type: "POST",
                            url: "scripts/carregar-torneios.php",
                            data: "codjogo=<?php echo $codJogo; ?>",
                            success: function(resultado){
                                $(".campeonatos").addClass("ativo");
                                $(".campeonatosPagina").css("display", "block");                        
                                $(".carregarConteudo").html(resultado);
                                trocarAba2(1);
                                return false;
                            }
                        });
                        break;
                    case 1: //  LOBBYS
                        $.ajax({
                            type: "POST",
                            url: "scripts/carregar-lobbys.php",
                            data: "codjogo=<?php echo $codJogo; ?>",
                            success: function(resultado){
                                $(".lobbys").addClass("ativo");		
                                $(".carregarConteudo").html(resultado);
                                return false;
                            }
                        });
                        break;
                    case 3: //  SIT&GO
                        $.ajax({
                            type: "POST",
                            url: "scripts/carregar-sitego.php",
                            data: "codjogo=<?php echo $codJogo; ?>",
                            success: function(resultado){
                                $(".sitego").addClass("ativo");	
                                $(".lobbysPagina").css("display", "none");
                                $(".campeonatosPagina").css("display", "none");
                                $(".barraEsquerda").html(resultado);
                                return false;
                            }
                        });
                        break;
                }
            }

            function validarLobby(){		
                if($(".nomeLobby").val() == ""){
                    alert("Preencha o nome do Lobby!");
                    $(".nomeLobby").focus();
                    return false;
                }
                if($(".qtdTimes").val() < 2){
                    alert("O Lobby deve ter no mínimo 2 times");
                    return false;
                }
                if($(".jogadorPorTime").val() < 1){
                    alert("Cada time deve ter no mínimo 1 jogador.");
                    return false;
                }
                if($(".privacidade").is(":checked") == true){
                    if($(".senha").val() == ""){
                        alert("É necessário informar uma senha para criar um lobby privado!");
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    return true;
                }
            }
            function validarLobby2(){		
                if($(".nomeLobby2").val() == ""){
                    alert("Preencha o nome do Lobby!");
                    $(".nomeLobby2").focus();
                    return false;
                }
                if($(".qtdTimes2").val() < 2){
                    alert("O Lobby deve ter no mínimo 2 times");
                    return false;
                }
                if($(".jogadorPorTime2").val() < 1){
                    alert("Cada time deve ter no mínimo 1 jogador.");
                    return false;
                }
                if($(".privacidade2").is(":checked") == true){
                    if($(".senha").val() == ""){
                        alert("É necessário informar uma senha para criar um lobby privado!");
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    return true;
                }
            }
            function entrarLobby (privacidade, codLobby){
                if(privacidade == 1){
                    var senha;
                    senha = prompt ("Informe a senha do Lobby");
                    if(senha != null && senha != ""){
                        $.ajax({
                            type: "POST",
                            url: "scripts/funcoes-lobby.php",
                            data: "funcao=6&codlobby="+codLobby+"&senha="+senha,
                            success: function(resultado){
                                if(resultado == ""){
                                    window.location.href = "ptbr/lobby/"+codLobby+"/";
                                }else{
                                    alert(resultado);
                                }
                            }
                        });	
                    }
                }else{
                    window.location.href = "ptbr/lobby/"+codLobby+"/";
                }
            }
            function verificarPrivacidade(){
                if($(".senha").length != 0){
                    $(".privacidade").attr("checked", "true");
                }else{
                    $(".privacidade").attr("checked", "false");
                }
            }
            function verificarPrivacidade2(){
                if($(".senha2").length != 0){
                    $(".privacidade2").attr("checked", "true");
                }else{
                    $(".privacidade2").attr("checked", "false");
                }
            }
            function encaminhar(link){
                window.location.href = link;
            }
            jQuery(function($){
                trocarAba(2);
                $(".botaoMenuJogos").html("Filtro<br><img src='img/icones/<?php echo $jogo['background']; ?>.png'>");
            });
        </script>
    </body>
</html>