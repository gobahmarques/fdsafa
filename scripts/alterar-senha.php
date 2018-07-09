<?php
	if(isset($_POST['senha'])){
		include "../conexao-banco.php";
		
		if($_POST['senha'] == $_POST['confSenha']){			
			$jogador = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$_POST['codJogador']." "));
			
			mysqli_query($conexao, "UPDATE jogador SET senha = '".sha1($_POST['senha'])."' WHERE codigo = ".$jogador['codigo']."");
			mysqli_query($conexao, "DELETE FROM jogador_senha WHERE cod_jogador = ".$jogador['codigo']."");
			echo"<script>alert('Sua senha foi alterada com sucesso.'),window.open('../','_self')</script>";
		}else{
			echo"<script>alert('As senhas informadas não coincidem.'),window.open('../','_self')</script>";
		}
	}else{
		include "../session.php";
	?>
		<h1>RECUPERAÇÃO DE SENHA</h1>
		INFORME O E-MAIL DE SEU LOGIN<Br>
		<form method="post" id="cadastro" action="scripts/alterar-senha.php">
			<input type="hidden" name="codJogador" id="codJogador">
			<input type="password" placeholder="NOVA SENHA" name="senha" id="senha" autofocus style="width: 100%;"><br>
			<input type="password" placeholder="CONFIRMAR SENHA" name="confSenha" id="confSenha" autofocus style="width: 100%;"><br><br>
			<div class="status" id="status">
			</div>
			<input type="submit" class="cadastro botaoPqLaranja" value="RECUPERAR SENHA">
		</form>
	<?php	
	}
?>
