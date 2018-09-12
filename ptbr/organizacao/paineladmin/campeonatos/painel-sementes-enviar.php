<?php
	include "../../../../conexao-banco.php";

    switch($_POST['funcao']){
        case "preencherSemente":            
            $inscricao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$_POST['codCampeonato']." AND cod_jogador = ".$_POST['codInscricao'].""));   
            $campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT cod_organizacao FROM campeonato WHERE codigo = ".$_POST['codCampeonato'].""));
            mysqli_query($conexao, "UPDATE campeonato_etapa_semente
                SET cod_jogador = ".$inscricao['cod_jogador']."
                WHERE codigo = ".$_POST['codSemente']."
            ");
            if($inscricao['cod_equipe'] != NULL){
                mysqli_query($conexao, "UPDATE campeonato_etapa_semente
                    SET cod_equipe = ".$inscricao['cod_equipe']."
                    WHERE codigo = ".$_POST['codSemente']."
                ");
            }
            header("Location: ../../../organizacao/".$campeonato['cod_organizacao']."/painel/campeonato/".$_POST['codCampeonato']."/etapa/".$_POST['codEtapa']."/sementes/");
            break;
        case "preencherAleatorio":
            $etapa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_etapa = ".$_POST['codEtapa']." AND cod_campeonato = ".$_POST['codCampeonato']." "));
            $campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_POST['codCampeonato']." "));            
            
            $sementesDestino = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_semente 
            WHERE cod_campeonato = ".$_POST['codCampeonato']." 
            AND cod_etapa = ".$_POST['codEtapa']." 
            AND cod_jogador is null
            ORDER BY rand() ");
            
            $qtdSementes = mysqli_num_rows($sementesDestino);
            echo $qtdSementes." <- QTD SEMENTES";
            
            $inscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$_POST['codCampeonato']." AND status = 1 LIMIT $qtdSementes");
            echo "<br>".mysqli_num_rows($inscricoes)." <- QTD INSCRICOES";
            $auxJogador = 0;
            while($inscricao = mysqli_fetch_array($inscricoes)){
                if($inscricao['cod_equipe'] != NULL){
                    $jogadores[$auxJogador] = $inscricao['cod_jogador']." ".$inscricao['cod_equipe'];   
                }else{
                    $jogadores[$auxJogador] = $inscricao['cod_jogador']." 0";   
                }   
                $auxJogador++;
            }
            $auxJogador = 0;

            while($seed = mysqli_fetch_array($sementesDestino)){
                $jogador = explode(" ", $jogadores[$auxJogador]);
                echo $auxJogador." ";
                if($jogador[1] != 0){
                    mysqli_query($conexao, "UPDATE campeonato_etapa_semente SET cod_jogador = ".$jogador[0].", cod_equipe = ".$jogador[1]." WHERE codigo = ".$seed['codigo']."");
                }else{
                    mysqli_query($conexao, "UPDATE campeonato_etapa_semente SET cod_jogador = ".$jogador[0]." WHERE codigo = ".$seed['codigo']."");
                }
                $auxJogador++;
            }
            // header("Location: ../../../organizacao/".$campeonato['cod_organizacao']."/painel/campeonato/".$_POST['codCampeonato']."/etapa/".$_POST['codEtapa']."/sementes/");
            break;
    }

    









    /*
	
    */
?>