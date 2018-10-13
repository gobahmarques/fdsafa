<?php
    include "../conexao-banco.php";

    $jogadores = mysqli_query($conexao, "
        SELECT codigo FROM jogador
        ORDER BY codigo
    ");
    $data = date("Y-m-d");

    while($jogador = mysqli_fetch_array($jogadores)){
        mysqli_query($conexao, "
            INSERT INTO gm_jogador_level
            VALUES
            (".$jogador['codigo'].", 1, 0, 50, 0, '$data', 1, 0, 50)
        ");
    }
?>