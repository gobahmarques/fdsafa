<?php
	require("../session.php");

    $valor = $_POST['valor'];
    $taxa = ($valor * 0.06) + 0.4;
    mysqli_query($conexao, "
        INSERT INTO jogador_pagamentos
        VALUES
        (NULL, ".$_POST['jogador'].", NULL, '".date("Y-m-d H:i:s")."', $valor, $taxa, 0)
    ");
    echo mysqli_insert_id($conexao);
?>