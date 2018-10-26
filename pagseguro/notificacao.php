<?php
    $notificationCode = preg_replace("/[^[:alnum:]-]/", "", $_POST['notificationCode']);

    $data['token'] ='BBE73746D35E431E858B704FB027E8F6';
    $data['email'] = 'gobahmarques@live.com';

    $url = 'https://ws.pagseguro.uol.com.br/v2/transactions/notifications/'.$notificationCode.'?'.$data;

    $data = http_build_query($data);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, $url);
    $xml= curl_exec($curl);
    curl_close($curl);

    $xml= simplexml_load_string($xml);

    $reference = $xml->reference;
    $status = $xml->status;

    if($status && $reference){
        include "../conexao-banco.php";
        $transacao = mysqli_fetch_array(mysqli_query($conexao, "
            SELECT * FROM jogador_pagamentos
            WHERE codigo = $reference
        "));
        
        switch($status){
            case "3": // PAGAMENTO APROVADO
                // 1 - ADICIONAR SALDO
                // 2 - ATUALIZAR PAGAMENTO
                
                include "../scripts/usuario.php";
                creditarSaldo($transacao['cod_jogador'], $transacao['valor'], 'Saldo Adicionado, Pedido '.$reference);
                
                mysqli_query($conexao, "
                    UPDATE jogador_pagamentos
                    SET status = 1
                    WHERE codigo = $reference
                ");
                
                break;
            case "6": // PEDIDO CANCELADO E VALOR DEVOLVIDO A COMPRADOR
                // 1 - RETIRAR SALDO DO JOGADOR
                
                include "../scripts/usuario.php";
                debitarSaldo($transacao['cod_jogador'], $transacao['valor'], 'Pedido '.$reference.' contestado');                
                
                break;
        }
        
        $pedido = mysqli_query($conexao, "
            UPDATE jogador_pagamentos
            SET cod_transacao = $xml->code
            WHERE codigo = $reference
        ");
    }

?>