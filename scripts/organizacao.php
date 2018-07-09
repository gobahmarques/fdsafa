<?php
	include "../session.php";

	switch($_POST['funcao']){
		case "carregarSubCategorias":
			$subcategorias = mysqli_query($conexao, "SELECT * FROM categoria_sub WHERE cod_categoria = ".$_POST['categoria']." ");
			while($sub = mysqli_fetch_array($subcategorias)){
				echo "<option value='".$sub['codigo']."'>".$sub['nome']."</option>";
			}
			break;
		case "carregarValorProduto":
			$produto = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM produto WHERE codigo = ".$_POST['produto'].""));
			echo $produto['valor'];
			break;
		case "addSaldoCaixa":
			$valor = $_POST['valor'];
			$organizacao = $_POST['organizacao'];			
			$organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = $organizacao"));
			$caixa = mysqli_fetch_array(mysqli_query($conexao, "SELECT codigo, saldo FROM caixa WHERE codigo = ".$_POST['caixa']." "));
			
			if($organizacao['saldo_coin'] >= $valor){ // Realiza o deposito
				if($caixa['saldo'] < 0){
					mysqli_query($conexao, "UPDATE caixa SET saldo = $valor WHERE codigo = ".$caixa['codigo']."");	
				}else{
					mysqli_query($conexao, "UPDATE caixa SET saldo = saldo + $valor WHERE codigo = ".$_POST['caixa']."");
				}				
				mysqli_query($conexao, "UPDATE organizacao SET saldo_coin = saldo_coin - $valor WHERE codigo = ".$organizacao['codigo']."");
				mysqli_query($conexao, "INSERT INT log_coin_organizacao VALUES (NULL, ".$organizacao['codigo'].", ".$usuario['codigo'].", $valor, 'Depósito na Caixa de ID ".$_POST['caixa']."', 0, '$datahora')");
			}else{
				echo "0";
			}	
			break;
		case "convidarJogador":
			
			/*
				1 - VERIFICA SE EMAIL EXISTE
				2 - VERIFICA SE JÁ ESTÁ INSCRITO NO TORNEIO
				3 - CASO 2 SEJA FALSO, REALIZA A INSCRIÇÃO
				4 - GERA UMA NOTIFICAÇÃO PARA O USUÁRIO
			*/
			
			$jogador = mysqli_query($conexao, "SELECT * FROM jogador WHERE email = '".$_POST['email']."' ");
			if(isset($jogador)){ // EXISTE JOGADOR COM O EMAIL INFORMADO
				$inscricao = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_jogador = ".$jogador['codigo']." AND cod_campeonato = ".$_POST['campeonato']." ");
				if(!isset($inscricao)){ // NÃO EXISTE INSCRIÇÃO
					mysqli_query($conexao, "INSERT INTO campeonato_inscricao VALUES (".$_POST['campeonato'].", ".$jogador['codigo'].", NULL, '".date("Y-m-d H:i:s")."', NULL, 1, NULL)");
				}else{ // JOGADOR JÁ INSCRITO NA COMPETIÇÃO
					
				}
			}
			
			break;
	}
	// strtoupper(md5(uniqid(rand(), true)));
?>