<?php
    include "../../session.php";
    $campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_POST['codcampeonato']." "));
    $inscricao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$_POST['codcampeonato']." AND cod_jogador = ".$_POST['codjogador']." "));

    switch($campeonato['cod_jogo']){
        case 369: // HEARTHSTONE
            $draft = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_draft WHERE cod_campeonato = ".$inscricao['cod_campeonato']." AND cod_jogador = ".$inscricao['cod_jogador'].""));
            $draft = explode(";", $draft['picks']);
            $aux = count($draft) - 1;
            ?>
                <div class="row justify-content-between resumoInscricao">
                    <?php
                        if($campeonato['open_decklist'] == 1){
                        ?>
                            
                            <?php
                                for($x = 0; $x < $aux; $x++){
                                    $decklist = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao_deckstring WHERE cod_campeonato = ".$inscricao['cod_campeonato']." AND cod_jogador = ".$inscricao['cod_jogador']." AND heroi = '".$draft[$x]."'"));
                                ?>
                                    <div class="col-3 draft">
                                        <a href="https://deck.codes/<?php echo $decklist['deckstring']; ?>" target="_blank">
                                            <img src="img/draft/Hearthstone/<?php echo $draft[$x]; ?>.png" width="100%" onClick="mostrarDeck('<?php echo $decklist['deckstring']; ?>');" >
                                        </a>                                        
                                    </div>
                                <?php
                                }   
                            ?>
                            
                        <?php
                        }else{
                        ?>                          
                            <?php
                                for($x = 0; $x < $aux; $x++){
                                ?>
                                    <div class="col">
                                        <img src="img/draft/Hearthstone/<?php echo $draft[$x]; ?>.png" width="100%" >
                                    </div>
                                <?php
                                }   
                            ?>
                            
                        <?php    
                        }
                    ?>                    
                </div>
            <?php
            break;
        case 123: // GWENT
            break;
        case 357: // DOTA 2
            break;
        default: // INSCRIÇÃO GERAL                     
            break;
    }  
?>
<script src="js/deckstring-hs/package/index.js"></script>
<script>
    function mostrarDeck(deckstring){
        imageFromDeckstring(deckstring, outputFile);
    }
</script>