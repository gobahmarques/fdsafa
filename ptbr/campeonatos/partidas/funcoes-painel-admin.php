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
                    echo "Resultado semente Um";
                }		
                if($_POST['sementeDois'] != ""){
                    mysqli_query($conexao, "DELETE FROM campeonato_partida_resultado WHERE cod_partida = ".$_POST['partida']." AND cod_semente = ".$_POST['sementeDois']." ");
                    mysqli_query($conexao, "INSERT INTO campeonato_partida_resultado VALUES (".$_POST['partida'].", ".$_POST['sementeDois'].",".$_POST['placarUm'].", ".$_POST['placarDois'].", '$datahora')");
                    echo "Resultado semente Dois";
                }
            }
            require "scripts.php";
		    resultadoPartida($_POST['partida'], $conexao);
            break;
        case "resetarPartida":
            
            $partida = mysqli_fetch_array(mysqli_query($conexao, "
                SELECT * FROM campeonato_partida
                WHERE codigo = ".$_POST['partida']."
            "));
            $etapa = mysqli_fetch_array(mysqli_query($conexao, "
                SELECT * FROM campeonato_etapa
                WHERE cod_campeonato = ".$partida['cod_campeonato']."
                AND cod_etapa = ".$partida['cod_etapa']."
            "));
            
            switch($etapa['tipo_etapa']){
                case 1: // PARTIDA ELIMINAÇÃO SIMPLES
                    break;
                case 2: // PARTIDA DE PONTOS CORRIDOS
                    break;
                case 3: // PARTIDA ELIMINAÇÃO DUPLA
                    
                    // RESETAR PARTIDA SOLICITADA
            
                    mysqli_query($conexao, "
                        DELETE FROM campeonato_partida_resultado
                        WHERE cod_partida = ".$partida['codigo']."
                    ");
                    mysqli_query($conexao, "
                        DELETE FROM campeonato_partida_checkin
                        WHERE cod_partida = ".$partida['codigo']."
                    ");

                    mysqli_query($conexao, "
                        UPDATE campeonato_partida
                        SET
                        placar_um = 0,
                        placar_dois = 0,
                        status = 1,
                        datahora = '".date("Y-m-d H:i:s")."'
                    ");


                    // TRATAR PARTIDAS POSTERIORES
                    
                    
                    
                    break;
            }
            
            
            
            break;
    }
    
?>