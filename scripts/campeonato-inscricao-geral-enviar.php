<?php
	include "../session.php";
	$codCampeonato = $_POST['codcampeonato'];
	$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = $codCampeonato"));

	$data = date("Y-m-d H:i:s");

	if(isset($usuario['codigo'])){
		if($campeonato['jogador_por_time'] == 1){ // INSCRIÇÕES SOLO
			if($campeonato['valor_escoin'] > 0){
				if($usuario['pontos'] >= $campeonato['valor_escoin']){
					mysqli_query($conexao, "UPDATE jogador SET pontos = pontos - ".$campeonato['valor_escoin']." WHERE codigo = ".$usuario['codigo']."");
					mysqli_query($conexao, "INSERT INTO log_coin VALUES (NULL, ".$usuario['codigo'].", ".$campeonato['valor_escoin'].", 'Inscrição campeonato: <strong>".$campeonato['nome']."</strong>', 0, '$data')");
					mysqli_query($conexao, "INSERT INTO campeonato_inscricao VALUES (".$_POST['codcampeonato'].", ".$usuario['codigo'].", NULL, '$data', 0, '".$_POST['conta']."', NULL, ".mysqli_insert_id($conexao).")");
				}
			}else{
				mysqli_query($conexao, "INSERT INTO campeonato_inscricao VALUES (".$_POST['codcampeonato'].", ".$usuario['codigo'].", NULL, '$data', 0, '".$_POST['conta']."', NULL, NULL)");
			}			
		}
	}
	header("Location: ../ptbr/campeonato/$codCampeonato/inscricao/")
?>


