<?php
	include "../session.php";
	$datahora = date("Y-m-d H:i:s");
	$nomeEquipe = $_POST['nomeEquipe'];
	$tag = $_POST['tagEquipe'];
	$jogo = $_POST['jogo'];

	if($nomeEquipe == ""){
		echo "Informe o nome da equipe<br>";
	}
	if($tag == ""){
		echo "Informe a TAG da equipe<br>";
	}
	if($jogo == ""){
		echo "Informe o jogo que a equipe disputará<br><br>";
	}

	$checkNome = mysqli_query($conexao, "SELECT codigo FROM equipe WHERE nome LIKE '%$nomeEquipe%' AND cod_jogo = $jogo");
	
	if(mysqli_num_rows($checkNome) == 0){
        mysqli_query($conexao, "INSERT INTO equipe VALUES (NULL, '$nomeEquipe', '$tag', 0, 0, 'equipes/padrao.jpg', $jogo, ".$usuario['codigo'].", NULL, NULL, NULL, NULL, NULL)");
        $id = mysqli_insert_id($conexao);
        mysqli_query($conexao, "INSERT INTO jogador_equipe VALUES (".$usuario['codigo'].", $id, '$datahora', 2)");
	}else{
		echo "O <strong>NOME</strong> informado já está sendo utilizado por outra equipe e para o mesmo jogo.";
	}	
?>