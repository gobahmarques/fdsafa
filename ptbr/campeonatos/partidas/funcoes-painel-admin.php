<?php
    include "../../../conexao-banco.php";

    $partida = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida WHERE codigo = ".$_POST['partida']." "));
	$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT cod_organizacao FROM campeonato WHERE codigo = ".$partida['cod_campeonato'].""));

    switch($_POST['funcao']){
        case "attdata":
            if($_POST['data'] != ""){
                $formato = "d/m/Y H:i:s";
                $datahora = DateTime::createFromFormat($formato, $_POST['data']);
                echo $_POST['data'];
                $datahora = $datahora->format("Y-m-d H:i:s");
                mysqli_query($conexao, "UPDATE campeonato_partida SET datahora = '$datahora' WHERE codigo = ".$partida['codigo']." ");
            }  
            break;
        case "resultadofinal":
            if($_POST['placarUm'] != "" && $_POST['placarDois'] != ""){        
                $datahora = date("Y-m-d H:i:s");
                if($_POST['sementeUm'] != ""){
                    mysqli_query($conexao, "DELETE FROM campeonato_partida_resultado WHERE cod_partida = ".$_POST['partida']." AND cod_semente = ".$_POST['sementeUm']." ");
                    mysqli_query($conexao, "INSERT INTO campeonato_partida_resultado VALUES (".$_POST['partida'].", ".$_POST['sementeUm'].",".$_POST['placarUm'].", ".$_POST['placarDois'].", '$datahora')");
                    echo "entrou aqui";
                }		
                if($_POST['sementeDois'] != ""){
                    mysqli_query($conexao, "DELETE FROM campeonato_partida_resultado WHERE cod_partida = ".$_POST['partida']." AND cod_semente = ".$_POST['sementeDois']." ");
                    mysqli_query($conexao, "INSERT INTO campeonato_partida_resultado VALUES (".$_POST['partida'].", ".$_POST['sementeDois'].",".$_POST['placarUm'].", ".$_POST['placarDois'].", '$datahora')");
                }
            }
            require "scripts.php";
		    resultadoPartida($_POST['partida'], $conexao);
            break;
    }
    
?>