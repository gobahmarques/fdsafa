<?php
    include "../session.php";
	include "../enderecos.php";

    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $recompensa = $_POST['recompensa'];
    $experiencia = $_POST['experiencia'];
    $repeticao = $_POST['repeticao'];

    mysqli_query($conexao, "
        INSERT INTO gm_missoes
        VALUES
        (NULL, '$titulo', '$descricao', $recompensa, $experiencia, $repeticao);
    ");

    header("Location: ../painel/gameficacao/missoes/");
?>