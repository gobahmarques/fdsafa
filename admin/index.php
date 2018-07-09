<?php
	include "session.php";
	include "enderecos.php";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>eSC - Painel de Controle</title>
<link rel="stylesheet" href="<?php echo $css; ?>estrutura.css">
<script src="js/jquery.js"></script>
<script>
	function validarLogin(){
		if($("#email").val() == "" || $("#senha").val() == ""){
			$("#modal").html("E-mail ou senha não informados");
			$("#modal").modal();
		}else{
			$.ajax({
				type: "POST",
				url: "validar_login.php",
				data: "email="+$("#email").val()+"&senha="+$("#senha").val(),
				success: function(resultado){
					if(resultado == "1"){
						window.location.href = "painel/";
					}else if(resultado == "2"){
						alert("E-mail ou senha incorretos.\nTente novamente.");
					}else if(resultado == "0"){
						alert("Conta não encontrada!");
					}				
					return false;
				}
			});
		}
		return false;
	}
</script>
</head>

<body>
	<form action="" class="login" method="post" onSubmit="return validarLogin();">
		<h1>Painel de Controle</h1>
		informe seus dados de entrada. <br><br>
		<input type="text" name="login" placeholder="E-MAIL" id="email"><br>
		<input type="password" name="senha" placeholder="SENHA" id="senha"><br><br>
		<input type="submit" value="ENTRAR">
	</form>
	
</body>
</html>