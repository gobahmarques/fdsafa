<?php
    include "../../conexao-banco.php";

    switch($_POST['funcao']){
        case "definirDivisaoPadrao": // DEFINIR DIVISÃO PADRÃO DE INSCRIÇÃO NA LIGA
            $divisao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM liga_divisao WHERE codigo = ".$_POST['codDivisao']." "));
            mysqli_query($conexao, "UPDATE liga SET divisao_padrao = ".$divisao['codigo']." WHERE codigo = ".$divisao['cod_liga']." ");
            break;
    }
?>