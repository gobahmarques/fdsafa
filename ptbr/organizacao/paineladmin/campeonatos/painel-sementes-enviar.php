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
    }

    









    /*
	$jogadores = $_POST['inscricao'];
	$etapa = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_etapa WHERE cod_etapa = ".$_POST['etapa']." AND cod_campeonato = ".$_POST['campeonato']." "));
	$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_POST['campeonato']." "));

	$sementesDestino = mysqli_query($conexao, "SELECT * FROM campeonato_etapa_semente WHERE cod_campeonato = ".$_POST['campeonato']." AND cod_etapa = ".$_POST['etapa']." ORDER BY rand() ");

	$auxJogador = 0;

	while($seed = mysqli_fetch_array($sementesDestino)){
		$jogador = explode(" ", $jogadores[$auxJogador]);
		if($jogador[1] != 0){
			mysqli_query($conexao, "UPDATE campeonato_etapa_semente SET cod_jogador = ".$jogador[0].", cod_equipe = ".$jogador[1]." WHERE codigo = ".$seed['codigo']."");
		}else{
			mysqli_query($conexao, "UPDATE campeonato_etapa_semente SET cod_jogador = ".$jogador[0]." WHERE codigo = ".$seed['codigo']."");
		}
		$auxJogador++;
	}

	header("Location: ../../../organizacao/".$campeonato['cod_organizacao']."/painel/campeonato/".$campeonato['codigo']."/etapa/".$etapa['cod_etapa']."/");
    */
?>