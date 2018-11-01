<?php
    if(isset($_POST['funcao'])){
        include "../conexao-banco.php";
        // 0 -> CARREGAR PEDIDO
        // 1 -> Confirmar Pagamento
        switch($_POST['funcao']){
            case "cancelarRifa":
                $rifa = mysqli_fetch_array(mysqli_query($conexao, "
                    SELECT * FROM rifa
                    WHERE codigo = ".$_POST['codrifa']." 
                "));
                $cupons = mysqli_query($conexao, "
                    SELECT * FROM rifa_cupom
                    WHERE cod_rifa = ".$_POST['codrifa']."
                ");           
                while($cupom = mysqli_fetch_array($cupons)){
                    /*
                        1 - Devolver Saldo
                        2 - Gerar Logo
                    */
                    if($cupom['tipo_compra'] == 0){ // COMPRADO COM ESCOIN
                        mysqli_query($conexao, "
                            UPDATE jogador
                            SET pontos = pontos + ".$rifa['preco_coin']."
                            WHERE codigo = ".$cupom['cod_jogador']."
                        ");
                        mysqli_query($conexao, "
                            INSERT INTO log_coin
                            VALUES 
                            (NULL, ".$cupom['cod_jogador'].", ".$rifa['preco_coin'].", 'Cancelamento da rifa <strong>".$rifa['nome']."</strong>, devolução do cupom <strong>".$cupom['codigo']."</strong>', 1, '".date("Y-m-d H:i:s")."')
                        ");
                    }else{ // COMPRADO COM REAL
                        mysqli_query($conexao, "
                            UPDATE jogador
                            SET saldo = saldo + ".$rifa['preco_real']."
                            WHERE codigo = ".$cupom['cod_jogador']."
                        ");
                        mysqli_query($conexao, "
                            INSERT INTO log_real
                            VALUES 
                            (NULL, ".$cupom['cod_jogador'].", ".$rifa['preco_real'].", 'Cancelamento da rifa <strong>".$rifa['nome']."</strong>, devolução do cupom <strong>".$cupom['codigo']."</strong>', 1, '".date("Y-m-d H:i:s")."')
                        ");
                        
                    }
                }
                
                // DESATIVAR RIFA - STATUS = 2
                
                mysqli_query($conexao, "
                    UPDATE rifa
                    SET status = 2
                    WHERE codigo = ".$rifa['codigo']."
                ");
                
                break;
            case "ativarRifa":
                $codrifa = $_POST['codrifa'];
                $status = $_POST['status'];
                
                mysqli_query($conexao, "
                    UPDATE rifa
                    SET status = $status
                    WHERE codigo = $codrifa
                ");
                
                break;
        }    
    }    
?>