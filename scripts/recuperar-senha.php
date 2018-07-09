<?php
	if(isset($_POST['email'])){
		include "../conexao-banco.php";
		$pesquisa = mysqli_query($conexao, "SELECT * FROM jogador WHERE email = '".$_POST['email']."'");
		if(mysqli_num_rows($pesquisa) == 0){ // EMAIL NÃO ENCONTRADO
			echo"<script>alert('E-mail não cadastrado em nosso sistema'),window.open('../','_self')</script>";
		}else{ // E-MAIL ENCONTRADO
			$jogador = mysqli_fetch_array($pesquisa);
			$senha = rand(100000, 999999);
			$email_conteudo = "Olá <strong>".$jogador['nick']."</strong>,<br>
				Você solicitou a recuperação de senha em nosso sistema.<br><br>
				Como medida de segurança, geramos uma senha temporária que está sendo exibida apenas aqui, neste e-mail, para você.<br>
				Não temos como te informar sua senha atual, pois todas as senhas são codificadas sem chave de decodificação.<br><br>
				<strong>SENHA: $senha</strong> <br><br>
				Caso tenha lembrado sua senha antiga, apenas desconsidere este e-mail e realize o login com sua senha normal.<br>
				Esta senha temporária será excluida assim que o login for realizado com sua atual senha.
			";
			//REMETENTE --> ESTE EMAIL TEM QUE SER VALIDO DO DOMINIO
			//==================================================== 
			$email_remetente = "noreply@esportscups.com.br"; // deve ser uma conta de email do seu dominio 
			//====================================================

			//Configurações do email, ajustar conforme necessidade
			//==================================================== 
			$email_destinatario = "".$jogador['email'].""; // pode ser qualquer email que receberá as mensagens
			$email_reply = "noreply@esportscups.com.br"; 
			$email_assunto = "[ESC] Recuperação de Senha"; // Este será o assunto da mensagem
			
			$email_headers = implode ( "\n",array ( "From: $email_remetente", "Reply-To: $email_reply", "Return-Path: $email_remetente","MIME-Version: 1.0","X-Priority: 3","Content-Type: text/html; charset=UTF-8" ) );
			
			if (mail ($email_destinatario, $email_assunto, nl2br($email_conteudo), $email_headers)){
				mysqli_query($conexao, "INSERT INTO jogador_senha VALUES (".$jogador['codigo'].", '".sha1($senha)."')");
				echo"<script>alert('Enviamos instruções para recuperar a senha no email informado.'),window.open('../','_self')</script>";
			}else{
				echo"<script>alert('Não conseguimos recuperar a senha no momento. Tente novamente em alguns minutos.'),window.open('../','_self')</script>";
			}
		}
	}else{
	?>		
		INFORME O E-MAIL DE SEU LOGIN<Br>
		<form method="post" id="cadastro" action="scripts/recuperar-senha.php">
			<input type="text" placeholder="SEU E-MAIL AQUI" name="email" id="nemailome" autofocus class="form-control"><br><br>
			<div class="status" id="status">
			</div>
			<input type="submit" class="cadastro btn btn-dark" value="RECUPERAR SENHA">
		</form>
	<?php	
	}
?>


