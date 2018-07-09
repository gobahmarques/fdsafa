<?php
    include "../../../enderecos.php";
    include "../../../session.php";

    if(isset($_GET['jogo'])){
        $codJogo = $_GET['jogo'];
        $jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogos WHERE codigo = $codJogo"));
    }else{
        $codJogo = 0;
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

        <title>Disputar partidas de Dota 2, Hearthstone, GWENT, League of Legends, Overwatch ou Clash Royale | e-Sports Cups</title>
    </head>
    <body>
        <?php include "../../header.php"; ?>
        <?php
            if($codJogo != 0){ // JÁ SELECIONOU O JOGO
            ?>
                <ul class="menuJogar centralizar">
                    <a href="ptbr/jogar/lobbys/dota2/"><li class="357"><img src="<?php echo $img; ?>icones/dota2.png"></li></a>
                    <a href="ptbr/jogar/lobbys/gwent/"><li class="123"><img src="<?php echo $img; ?>icones/gwent.png"></li></a>
                    <a href="ptbr/jogar/lobbys/hearthstone/"><li class="369"><img src="<?php echo $img; ?>icones/hs.png"></li></a>
                    <a href="ptbr/jogar/lobbys/lol/"><li class="147"><img src="<?php echo $img; ?>icones/lol.png"></li></a>
                    <a href="ptbr/jogar/lobbys/overwatch/"><li class="258"><img src="<?php echo $img; ?>icones/overwatch2.png"></li></a>
                </ul>
        
                <div class="container">
                    <div class="carregarConteudo centralizar">

                    </div>           
                </div>
            <?php   
            }else{ // AINDA NÃO SELECIONOU O JOGO
            ?>
                <div class="container">
                    <div class="row centralizar">
                        <div class="col">
                            <br>
                            <h2>Salas Públicas e Privadas de e-Sports</h2>
                            Escolha um dos jogos abaixo para criar ou participar de lobbys privados ou públicos com seus amigos ou com a comunidade
                        </div>
                        
                    </div>
                    <div class="row barraJogosIndex">
                        <div class="col-xs-12-fluid col-md-12">
                            <h2 class="tituloIndex">Jogos <strong>Disponíveis</strong></h2>
                            <div class="detalheTituloIndex"></div>                    
                        </div>
                        <div class="col-4 col-md-2 jogo">
                            <a href="ptbr/jogar/lobbys/dota2/"><img src="<?php echo $img; ?>index/dota2.png"></a>
                        </div>
                        <div class="col-4 col-md-2 jogo">
                            <a href="ptbr/jogar/lobbys/gwent/"><img src="<?php echo $img; ?>index/gwent.png" style="width: 100%;"></a>
                        </div>
                        <div class="col-4 col-md-2 jogo">
                            <a href="ptbr/jogar/lobbys/hearthstone/"><img src="<?php echo $img; ?>index/hearthstone.png" style="width: 100%;"></a>
                        </div>
                        <div class="col-4 col-md-2 jogo">
                            <a href="ptbr/jogar/lobbys/lol/"><img src="<?php echo $img; ?>index/lol.png" style="width: 100%;"></a>
                        </div>
                        <div class="col-4 col-md-2 jogo">
                            <a href="ptbr/jogar/lobbys/overwatch/"><img src="<?php echo $img; ?>index/overwatch.png" style="width: 100%;"></a>
                        </div>
                        <div class="col-4 col-md-2">
                            <img src="<?php echo $img; ?>index/clashroyale2.png" style="width: 100%;">
                        </div>
                    </div>
                </div>
            <?php
            }
        ?>
        
        <?php include "../../footer.php"; ?>
        
        

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>        
        <script>
            function carregarLobbys(){
                $(".<?php echo $codJogo; ?>").addClass("ativo");
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
            jQuery(function($){
                carregarLobbys();
                $(".menuPrincipalHeader li").removeClass("ativo");
                $(".menuPrincipalHeader .lobbys").addClass("ativo");
            });
        </script>
    </body>
</html>