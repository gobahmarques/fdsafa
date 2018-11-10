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
                <div class="container">
                    <div class="row">
                        <div class="carregarConteudo col-md-8 mt-5">

                        </div>  
                        <div class="col-md-4">
                            <h2 class="tituloLateral">Filtre sua <strong>Busca</strong></h2>
                            <div class="detalheTituloLateral"></div>
                            <ul class="menuJogar centralizar">
                                <a href="ptbr/jogar/lobbys/dota2/"><li class="357"><img src="<?php echo $img; ?>icones/dota2.png"></li></a>
                                <a href="ptbr/jogar/lobbys/gwent/"><li class="123"><img src="<?php echo $img; ?>icones/gwent.png"></li></a>
                                <a href="ptbr/jogar/lobbys/hearthstone/"><li class="369"><img src="<?php echo $img; ?>icones/hs.png"></li></a>
                                <a href="ptbr/jogar/lobbys/lol/"><li class="147"><img src="<?php echo $img; ?>icones/lol.png"></li></a>
                                <a href="ptbr/jogar/lobbys/overwatch/"><li class="258"><img src="<?php echo $img; ?>icones/overwatch2.png"></li></a>
                            </ul>
                        <?php
                            if(isset($usuario['codigo'])){
                                // EXIBIR LEVEL
                            ?>
                                <div class="lvlLobby">
                                    <div class="row">
                                        <div class="col-md-4 col-3">
                                            <img src="img/<?php echo $usuario['foto_perfil']; ?>">
                                        </div>
                                        <div class="col-md-8 col-9">
                                            <div class="row">
                                                <div class="col">
                                                    <?php echo $usuario['nome']." '".$usuario['nick']."' ".$usuario['sobrenome']; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <?php
                                                        $lvlJogador = mysqli_query($conexao, "SELECT * FROM gm_jogador_level WHERE cod_jogador = ".$usuario['codigo']."");
                                                        $lvlJogador = mysqli_fetch_array($lvlJogador);
                                                        $tamBarra = ($lvlJogador['xp_atual'] / $lvlJogador['xp_final']) * 100; 
                                                    ?>
                                                        Level <?php echo $lvlJogador['level']; ?>
                                                        <div class="progress centralizar" style="height: 15px;">
                                                            <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: <?php echo $tamBarra; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($tamBarra, 0); ?> %</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6 text-left">
                                                                0
                                                            </div>
                                                            <div class="col-6 text-right">
                                                                <?php echo $lvlJogador['xp_final']; ?>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="criarLobby">
                                <?php
                                    if(isset($usuario['codigo'])){
                                        ?>
                                                <h2>
                                                    <img src="https://www.esportscups.com.br/img/icones/+.png" alt="">
                                                    CRIAR LOBBY
                                                </h2>
                                                <form action="scripts/criar-lobby.php" method="post" onSubmit="return validarLobby();">
                                                    <div class="jogo">
                                                    <?php
                                                        switch($codJogo){
                                                            case 369: // HEARTHSTONE
                                                                echo "<img src='https://www.esportscups.com.br/img/icones/hs.png' alt='Hearthstone' title='Hearthstone'>";
                                                                echo "Hearthstone";
                                                                break;
                                                            case 123: // GWENT
                                                                echo "<img src='https://www.esportscups.com.br/img/icones/gwent.png' alt='GWENT' title='Hearthstone'>";
                                                                echo "GWENT: The Witcher Card Game";
                                                                break;
                                                            case 147: // League of Legends
                                                                echo "<img src='https://www.esportscups.com.br/img/icones/lol.png' alt='League of Legends' title='League of Legends'>";
                                                                echo "League of Legends";
                                                                break;
                                                            case 357: // Dota 2
                                                                echo "<img src='https://www.esportscups.com.br/img/icones/dota2.png' alt='Dota 2' title='Dota 2'>";
                                                                echo "Dota 2";
                                                                break;
                                                            case 258: // Overwatch
                                                                echo "<img src='https://www.esportscups.com.br/img/icones/overwatch.png' alt='Overwatch' title='Overwatch'>";
                                                                echo "Overwatch";
                                                                break;
                                                            case 741: // PUBG
                                                                echo "<img src='https://www.esportscups.com.br/img/icones/pubg.png' alt='PUBG' title='PUBG'>";
                                                                echo "Playerunknow's: Battlegrounds";
                                                                break;
                                                            case 653: // CLASH ROYALE
                                                                echo "<img src='https://www.esportscups.com.br/img/icones/clashroyale.png' alt='Clash Royale' title='Clash Royale'>";
                                                                echo "Clash Royale";
                                                                break;
                                                        }
                                                    ?>
                                                    </div>
                                                    <input type="hidden" name="codJogo" value="<?php echo $codJogo; ?>">
                                                    <input type="text" placeholder="NOME DO LOBBY (Máximo: 32 caracteres)" name="nome" maxlength="32">
                                                    <input type="number" placeholder="QTD. TIMES" name="qtdTimes" min="2" class="qtdTimes">
                                                    <input type="number" placeholder="JOGADOR P/ TIME" name="jogadorPorTime" min="1">
                                                    <select name="tipo" id="">
                                                        <option value="1">MD 1</option>
                                                    </select><br>
                                                    <input type="password" placeholder="SENHA (Máximo: 8 caracteres)" name="senha" class="senha" maxlength="8" onKeyDown="verificarPrivacidade();">
                                                    <input type="checkbox" value="1" name="privacidade" class="privacidade"> Lobby Privado? <br><br>
                                                    <input type="submit" value="CRIAR LOBBY" class="btn btn-azul">
                                                </form>
                                        <?php
                                    }else{
                                        echo "Faça o login para poder participar dos lobbys!";
                                    }
                                ?>
                                </div>
                            <?php
                                // EXIBIR CRIAÇÃO
                                
                            }else{
                                // PEDIR LOGIN
                            }                    
                        ?>                            
                        </div>
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