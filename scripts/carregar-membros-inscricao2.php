<?php
	if(isset($_POST['codEquipe'])){
		include "../conexao-banco.php";
		$datahora = date("Y-m-d H:i:s");
		$equipe = $_POST['codEquipe'];
		$jogador = $_POST['jogador'];
		$campeonato = $_POST['codCampeonato'];
		$aux = 0;
		while($aux < $_POST['vagas']){
			mysqli_query($conexao, "INSERT INTO campeonato_inscricao VALUES ($campeonato, $jogador[$aux], $equipe, '$datahora', NULL, 0, NULL)");
			$aux++;
		}
		header("Location: ../campeonato/$campeonato/inscricao/");
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
							<img src="<?php echo "../img/".$membro['foto_perfil']; ?>" >
							<?php echo $membro['nome']." '<strong>".$membro['nick']."</strong>' ".$membro['sobrenome']; ?>
							<input type="checkbox" name="jogador[]" class="limitado3" value="<?php echo $membro['codigo']; ?>">
						</div>
					<?php
					}
				?>
					<br><br><input type="submit" value="REALIZAR INSCRIÇÃO" class="botaoPqLaranja">		
				</form>
			<?php
		}
	}

		
?>