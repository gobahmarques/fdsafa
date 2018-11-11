<?php
	include "../session.php";
	$datahora = date("Y-m-d H:i:s");

    $nomeOrganizacao = $_POST['nomeOrganizacao'];
    $descricao = $_POST['descricao'];
    $email = $_POST['emailResponsavel'];

	if($nomeOrganizacao == ""){
		echo "Informe o nome da Organização a ser criada.<br>";
	}
	if($email == ""){
		echo "Informe o E-mail do responsável pela organização.<br>";
	}

	$checkNome = mysqli_query($conexao, "SELECT codigo FROM organizacao WHERE nome LIKE '%$nomeOrganizacao%'");
	
	if(mysqli_num_rows($checkNome) == 0){
        mysqli_query($conexao, "INSERT INTO organizacao VALUES (NULL, ".$usuario['codigo'].", '$nomeOrganizacao', '".date("Y-m-d H:i:s")."', '$descricao', NULL, '$email', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0)");
        $id = mysqli_insert_id($conexao);
        mysqli_query($conexao, "INSERT INTO jogador_organizacao VALUES (".$usuario['codigo'].", $id, 9)");
	}else{
		echo "O <strong>NOME</strong> informado já está sendo utilizado.";
	}	
?>