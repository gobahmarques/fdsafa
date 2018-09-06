<?php	
	include "../../session.php";
	include "../../enderecos.php";

    $id = $_POST['codcampeonato'];
    $campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = $id"));
    $organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$campeonato['cod_organizacao']." "));

	// REGISTRAR PREMIAÇÃO AUTOMATICA

	$contador = 0;
	$totalCoin = $totalReal = 0;

	while($contador < 32){
        
        mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, ($contador + 1), NULL, NULL, NULL, NULL)");
        
        if($_POST['coin'.$contador] > 0){ // TEM PREMIAÇÃO EM COIN
            mysqli_query($conexao, "UPDATE campeonato_premiacao
                SET premio_coin = ".$_POST['coin'.$contador]."
                WHERE cod_campeonato = $id
                AND posicao = ($contador + 1)
            ");
        }
        if($_POST['real'.$contador] > 0){ // TEM PREMIAÇÃO REAL
            mysqli_query($conexao, "UPDATE campeonato_premiacao
                SET premio_real = ".$_POST['real'.$contador]."
                WHERE cod_campeonato = $id
                AND posicao = ($contador + 1)
            ");
        }
        if($_POST['divisao'.$contador] != ""){ // TEM AVANÇO DE DIVISÃO
            mysqli_query($conexao, "UPDATE campeonato_premiacao
                SET cod_divisao = ".$_POST['divisao'.$contador]."
                WHERE cod_campeonato = $id
                AND posicao = ($contador + 1)
            ");
        }
        if($_POST['pontos'.$contador] > 0){ // TEM PREMIAÇÃO EM PONTOS
            mysqli_query($conexao, "UPDATE campeonato_premiacao
                SET pontos = ".$_POST['pontos'.$contador]."
                WHERE cod_campeonato = $id
                AND posicao = ($contador + 1)
            ");
        }
        $contador++;
	}

    // EXCLUIR PREMIAÇÕES SEM PREMIOS

    mysqli_query($conexao, "
        DELETE FROM campeonato_premiacao
        WHERE cod_campeonato = $id
        AND premio_coin is NULL
        AND premio_real is NULL
        AND pontos is NULL
        AND cod_divisao is NULL
    ");

	// REGISTRAR MOVIMENTAÇÃO ORGANIZACAO

	if($totalCoin > 0){
		mysqli_query($conexao, "INSERT INTO log_coin_organizacao VALUES (NULL, ".$organizacao['codigo'].", ".$usuario['codigo'].", $totalCoin, 'Premiação do Torneio: $nome', 0, '".date("Y-m-d H:i:s")."')");
		mysqli_query($conexao, "UPDATE organizacao SET saldo_coin = saldo_coin - $totalCoin WHERE codigo = ".$organizacao['codigo']." ");
	}
	if($totalReal > 0){
		mysqli_query($conexao, "INSERT INTO log_real_organizacao VALUES (NULL, ".$organizacao['codigo'].", ".$usuario['codigo'].", $totalReal, 'Premiação do Torneio: ".$campeonato['nome']."', 0, '".date("Y-m-d H:i:s")."')");
		mysqli_query($conexao, "UPDATE organizacao SET saldo_real = saldo_real - $totalReal WHERE codigo = ".$organizacao['codigo']." ");
	}

	// header("Location: campeonato/".$id."/");
	