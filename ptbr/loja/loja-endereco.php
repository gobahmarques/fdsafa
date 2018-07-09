<?php
	include "../../conexao-banco.php";
	include "../../session.php";
	$enderecos = mysqli_query($conexao, "SELECT * FROM jogador_enderecos WHERE cod_jogador = ".$usuario['codigo']."");
	if(mysqli_num_rows($enderecos) != 0){
		echo "<select class='listaEnderecos' class='form-control'>";
		while($endereco = mysqli_fetch_array($enderecos)){
			echo "<option  value='".$endereco['codigo']."'>
				".$endereco['cep']." - 
				".$endereco['endereco']."
				".$endereco['complemento'].", ".$endereco['numero']." - 
				".$endereco['cidade']." - ".$endereco['estado']." - ".$endereco['pais']."	</option>";
		}
		echo "</select> ";
	}else{
		include "loja-endereco-novo.html";
        ?>
        <script>
            $(".modal-footer").html("");
            $(".modal-footer").html("<input type='button' class='btn btn-laranja' value='Cadastrar Endereço' onClick='novoEnderecoEnviar();'>");
        </script>
    <?php
	}
?>