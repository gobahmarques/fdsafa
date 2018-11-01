<?php
	include "session.php";
	include "enderecos.php";

    $codRifa = $_POST['codRifa'];
    $linkSorteio = $_POST['linkSorteio'];
    $linkTransmissao = $_POST['linkTransmissao'];
    $cupomSorteado = $_POST['cupomSorteado'];
    $dataSorteio = date("Y-m-d H:i:s");

    mysqli_query($conexao, "
        UPDATE rifa
        SET link_sorteio = '$linkSorteio',
        link_transmissao = '$linkTransmissao',
        data_sorteio = '$dataSorteio'
        WHERE codigo = $codRifa
    ");

    mysqli_query($conexao, "
        UPDATE rifa_cupom
        SET status = 1
        WHERE codigo = $cupomSorteado
        AND cod_rifa = $codRifa
    ");