<?php
	include "../session.php";	
	include "../enderecos.php";
	if(!isset($_SESSION)){
		session_start();
	}
	$nome = $_SESSION['nome'];
	$sobrenome = $_SESSION['sobrenome'];
	$nick = $_SESSION['nick'];
	$email = $_SESSION['email'];
	$senha = sha1($_SESSION['senha']);
	$datahora = date('Y-m-d H:i:s');

    $dataNascimento = DateTime::createFromFormat('d/m/Y', $_SESSION['dataNascimento']);
    $dataNascimento = $dataNascimento->format('Y-m-d');

	do{
		$id = rand(000000,999999);	
		$consulta = mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = $id");
	}while(mysqli_num_rows($consulta) > 0);
	$foto = "usuarios/padrao.jpg";

	$inserir = mysqli_query($conexao, "INSERT INTO jogador (codigo, nome, sobrenome, nick, email, senha, cadastro, status, foto_perfil, data_nascimento, sexo) VALUES ('$id', '$nome', '$sobrenome', '$nick', '$email', '$senha', '$datahora', '1', '$foto', '$dataNascimento', '".$_SESSION['sexo']."')");
	if(!$inserir){				
	?>
		<h1>OPS...</h1>
		<h2>ALGUM ERRO INESPERADO OCORREU!</h2>
		TENTE NOVAMENTE!
	<?php
	}else{
        $id = mysqli_insert_id($conexao);
        
        mysqli_query($conexao, "
            INSERT INTO gm_jogador_level
            VALUES
            ($id, 1, 0, 50, 0, '".date("Y-m-d")."', 1, 0, 50)
        ");
        
		//REMETENTE --> ESTE EMAIL TEM QUE SER VALIDO DO DOMINIO
		//==================================================== 
		$email_remetente = "contato@esportscups.com.br"; // deve ser uma conta de email do seu dominio 
		//====================================================

		//Configurações do email, ajustar conforme necessidade
		//==================================================== 
		$email_destinatario = "$email"; // pode ser qualquer email que receberá as mensagens
		$email_reply = "$email"; 
		$email_assunto = "eSC - Confirmação de Cadastro"; // Este será o assunto da mensagem
		//====================================================

		//Monta o Corpo da Mensagem
		//====================================================
		$email_conteudo = "<img src='http://www.esportscups.com.br/img/logo.png' title='e-Sports Cups' width='150'><br>";
		$email_conteudo .= "<h2>CONFIRMAÇÃO DE CADASTRO</h2>";
		$email_conteudo .= "Olá <strong>".$nome." '".$nick."' ".$sobrenome."</strong>! <br>";
		$email_conteudo .= "Agradecemos pelo seu cadastro na <strong>e-Sports Cups.</strong><br><br>";
		$email_conteudo .= "Você já pode participar de nossos campeonatos.<br><br>";
		$email_conteudo .= "Atenciosamente,<Br>";
		$email_conteudo .= "Equipe e-Sports Cups.<br><br>";
		$email_conteudo .= "Este é um e-mail gerado automaticamente pelo nosso sistema. Favor não respondê-lo, pois esta conta não é monitorada.";
		//====================================================

		//Seta os Headers (Alterar somente caso necessario) 
		//==================================================== 
		$email_headers = implode ( "\n",array ( "From: $email_remetente", "Reply-To: $email_reply", "Return-Path: $email_remetente","MIME-Version: 1.0","X-Priority: 3","Content-Type: text/html; charset=UTF-8" ) );
		//====================================================

		//Enviando o email 
		//==================================================== 
		mail ($email_destinatario, $email_assunto, nl2br($email_conteudo), $email_headers);
	?>
		<h1>BEM-VINDO(A)</h1>
		<h2>CADASTRO EFETUADO COM SUCESSO!</h2>
		Faça já o seu login e inscreva-se em um de nosso torneios!
	<?php
		header("Location: ../ptbr/");
	}
?>