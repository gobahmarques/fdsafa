<?php
    include "../../session.php";
    $campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_POST['campeonato']." "));

    switch($_POST['funcao']){
        case "confirmarVagaPaga":
            if($campeonato['valor_escoin'] > 0){
                if($usuario['pontos'] >= $campeonato['valor_escoin']){
                    mysqli_query($conexao, "INSERT INTO log_coin VALUES (NULL, ".$usuario['codigo'].", ".$campeonato['valor_escoin'].", 'Inscrição no torneio <strong>".$campeonato['nome']."</strong>', 0, '".date("Y-m-d H:i:s")."')");
                    mysqli_query($conexao, "UPDATE campeonato_inscricao SET log_coin = ".mysqli_insert_id($conexao).", status = 1 WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$usuario['codigo']." ");
                    mysqli_query($conexao, "UPDATE jogador SET pontos = pontos - ".$campeonato['valor_escoin']." WHERE codigo = ".$usuario['codigo']." ");
                    
                    mysqli_query($conexao, "UPDATE organizacao SET saldo_coin = saldo_coin + ".$campeonato['valor_escoin']." WHERE codigo = ".$campeonato['cod_organizacao']." ");
                    mysqli_query($conexao, "INSERT INTO log_coin_organizacao VALUES (NULL, ".$campeonato['cod_organizacao'].", ".$usuario['codigo'].", ".$campeonato['valor_escoin'].", 'Inscrição Torneio ".$campeonato['nome']."', 0, '".date("Y-m-d H:i:s")."')");
                }
            }elseif($campeonato['valor_real'] > 0){
                if($usuario['saldo'] >= $campeonato['valor_real']){
                    mysqli_query($conexao, "INSERT INTO log_real VALUES (NULL, ".$usuario['codigo'].", ".$campeonato['valor_real'].", 'Inscrição no torneio <strong>".$campeonato['nome']."</strong>', 0, '".date("Y-m-d H:i:s")."')");
                    mysqli_query($conexao, "UPDATE campeonato_inscricao SET log_real = ".mysqli_insert_id($conexao).", status = 1 WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = ".$usuario['codigo']." ");
                    mysqli_query($conexao, "UPDATE jogador SET saldo = saldo - ".$campeonato['valor_real']." WHERE codigo = ".$usuario['codigo']." ");
                    
                    mysqli_query($conexao, "UPDATE organizacao SET saldo_real = saldo_real + ".$campeonato['valor_real']." WHERE codigo = ".$campeonato['cod_organizacao']." ");
                    mysqli_query($conexao, "INSERT INTO log_real_organizacao VALUES (NULL, ".$campeonato['cod_organizacao'].", ".$usuario['codigo'].", ".$campeonato['valor_real'].", 'Inscrição Torneio ".$campeonato['nome']."', 0, '".date("Y-m-d H:i:s")."')");
                }
            }
            break;
        default:
            break;
    }
?>