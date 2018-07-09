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
		if($_POST['coin'.$contador] > 0 && $_POST['real'.$contador] > 0){ // TEM PREMIAÇÃO EM COIN E EM REAL
            if($_POST['divisao'.$contador] != ""){
                mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, ($contador + 1), ".$_POST['coin'.$contador].", ".$_POST['real'.$contador].", NULL, ".$_POST['divisao'.$contador].")");
            }else{
                mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, ($contador + 1), ".$_POST['coin'.$contador].", ".$_POST['real'.$contador].", NULL, NULL)");
            }			
			$totalCoin += $_POST['coin'.$contador];
			$totalReal += $_POST['real'.$contador];
		}else{
			if($_POST['coin'.$contador] > 0){
                if($_POST['divisao'.$contador] != ""){
                    mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, ($contador + 1), ".$_POST['coin'.$contador].", 0, NULL, ".$_POST['divisao'.$contador].")");
                }else{
                    mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, ($contador + 1), ".$_POST['coin'.$contador].", 0, NULL, NULL)");
                }				
				$totalCoin += $_POST['coin'.$contador];
			}elseif($_POST['real'.$contador] > 0){
                if($_POST['divisao'.$contador] != ""){
                    mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, ($contador + 1), 0, ".$_POST['real'.$contador].", NULL, ".$_POST['divisao'.$contador].")");
                    echo $_POST['divisao'.$contador];
                }else{
                    mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, ($contador + 1), 0, ".$_POST['real'.$contador].", NULL, NULL)");
                }				
				$totalReal += $_POST['real'.$contador];
			}
		}
		$contador++;
	}

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
	