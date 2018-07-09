<?php
	if(isset($_POST['codEquipe'])){
		include "../session.php";
		$datahora = date("Y-m-d H:i:s");
		$equipe = $_POST['codEquipe'];
		$nomeEquipe = mysqli_query($conexao, "SELECT nome FROM equipe WHERE codigo = $equipe");
		$jogador = $_POST['jogador'];
		$campeonato = $_POST['codCampeonato'];
		$nomeCamp = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = $campeonato"));
		$aux = 0;
		$msg = "Você foi convocado para jogar o torneio <strong>".$nomeCamp['nome']."</strong> junto com a equipe <strong>".$infosEquipe['nome']."</strong>.";
        
        mysqli_query($conexao, "INSERT INTO campeonato_inscricao VALUES (".$campeonato.", ".$usuario['codigo'].", $equipe, '".date("Y-m-d H:i:s")."', 0, NULL, NULL, NULL)");
		while($aux < $_POST['vagas']){
			mysqli_query($conexao, "INSERT INTO campeonato_lineup VALUES ($campeonato, $equipe, $jogador[$aux], 0)");
			mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$msg', $jogador[$aux], 0)");
			$aux++;
		}
		mysqli_query($conexao, "UPDATE campeonato_lineup SET capitao = 1 WHERE cod_campeonato = $campeonato AND cod_jogador = ".$usuario['codigo']."");
		
        
        if($nomeCamp['valor_escoin'] > 0){
            if($usuario['pontos'] >= $nomeCamp['valor_escoin']){
                mysqli_query($conexao, "UPDATE jogador SET pontos = pontos - ".$nomeCamp['valor_coin']." WHERE codigo = ".$usuario['codigo']." ");
                mysqli_query($conexao, "INSERT INTO log_coin VALUES (NULL, ".$usuario['codigo'].", ".$nomeCamp['valor_coin'].", 'Inscrição no torneio ".$nomeCamp['nome']."', 0, '".date("Y-m-d H:i:s")."')");  
                mysqli_query($conexao, "UPDATE campeonato_inscricao SET log_coin = ".mysqli_insert_id($conexao).", status = 1 WHERE cod_campeonato = ".$nomeCamp['codigo']." AND cod_jogador = ".$usuario['codigo']." ");
                
                mysqli_query($conexao, "UPDATE organizacao SET saldo_coin = saldo_coin + ".$nomeCamp['valor_escoin']." WHERE codigo = ".$nomeCamp['cod_organizacao']." ");
                mysqli_query($conexao, "INSERT INTO log_coin_organizacao VALUES (NULL, ".$nomeCamp['cod_organizacao'].", ".$usuario['codigo'].", ".$nomeCamp['valor_escoin'].", 'Inscrição Torneio ".$nomeCamp['nome']."', 1, '".date("Y-m-d H:i:s")."')");
            }            
        }else if($nomeCamp['valor_real'] > 0){
            if($usuario['saldo'] >= $nomeCamp['valor_real']){
                mysqli_query($conexao, "UPDATE jogador SET saldo = saldo - ".$nomeCamp['valor_real']." WHERE codigo = ".$usuario['codigo']." ");
                mysqli_query($conexao, "INSERT INTO log_real VALUES (NULL, ".$usuario['codigo'].", ".$nomeCamp['valor_real'].", 'Inscrição no torneio ".$nomeCamp['nome']."', 0, '".date("Y-m-d H:i:s")."')");
                mysqli_query($conexao, "UPDATE campeonato_inscricao SET log_real = ".mysqli_insert_id($conexao).", status = 1 WHERE cod_campeonato = ".$nomeCamp['codigo']." AND cod_jogador = ".$usuario['codigo']." ");
                
                mysqli_query($conexao, "UPDATE organizacao SET saldo_real = saldo_real + ".$nomeCamp['valor_real']." WHERE codigo = ".$nomeCamp['cod_organizacao']." ");
                mysqli_query($conexao, "INSERT INTO log_real_organizacao VALUES (NULL, ".$nomeCamp['cod_organizacao'].", ".$usuario['codigo'].", ".$nomeCamp['valor_real'].", 'Inscrição Torneio ".$nomeCamp['nome']."', 1, '".date("Y-m-d H:i:s")."')");
            }
        }
		header("Location: ../ptbr/campeonato/$campeonato/inscricao/");
	}else{
		include "../conexao-banco.php";
		$membros = mysqli_query($conexao, "SELECT * FROM jogador_equipe
		INNER JOIN jogador ON jogador.codigo = jogador_equipe.cod_jogador
		WHERE jogador_equipe.cod_equipe = ".$_POST['equipe']."
		ORDER BY jogador_equipe.status DESC");

		if(mysqli_num_rows($membros) < $_POST['vagas']){ // NÃO POSSUI JOGADORES SUFICIENTES
			echo "<h2>Jogadores</h2>";
			echo "É necessário ".$_POST['vagas']." jogadores para participar desta competição.";
		}else{
			?>
				<h2>Selecione os Jogadores</h2>
				<form action="scripts/carregar-membros-inscricao.php" onSubmit="return validar3();" method="post">
					<input type="hidden" value="<?php echo $_POST['equipe']; ?>" name="codEquipe">
					<input type="hidden" value="<?php echo $_POST['vagas']; ?>" name="vagas">
					<input type="hidden" value="<?php echo $_POST['campeonato']; ?>" name="codCampeonato">
				<?php
					while($membro = mysqli_fetch_array($membros)){
					?>
						<div class="jogador">						
							<img src="<?php echo "../img/".$membro['foto_perfil']; ?>" height="30px" >
							<?php echo $membro['nome']." '<strong>".$membro['nick']."</strong>' ".$membro['sobrenome']; ?>
							<input type="checkbox" name="jogador[]" class="limitado3" value="<?php echo $membro['codigo']; ?>">
						</div>
					<?php
					}
				?>
					<br><br><input type="submit" value="REALIZAR INSCRIÇÃO" class="btn btn-dark">		
				</form>
			<?php
		}
	}

		
?>