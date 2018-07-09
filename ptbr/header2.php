<script>
	function validarLogin(){
		if($("#email").val() == "" || $("#senha").val() == ""){
			$(".modal-body").html("E-mail ou senha não informados");
		}else{
			$.ajax({
				type: "POST",
				url: "ptbr/validar_login.php",
				data: $("#login").serialize(),
				success: function(resultado){
					if(resultado == "0"){						
						$(".modal-body").html("<h2>QUE BOM QUE VOCÊ ESTÁ AQUI!</h2>  RECEBA ESTA RECOMPENSA PELO SEU PRIMEIRO LOGIN DO DIA!<br> <div class='valor' style='margin: 3% 0%; font-size: 300%;'><img class='coin' src='<?php echo $img; ?>icones/escoin.png' height='4%'> 100</div><br><a href='https://www.esportscups.com.br/ptbr/jogar/dota2/'><input type='button' value='CONTINUAR'></a> ");
					}else if(resultado == "1"){
						window.location.href = "https://www.esportscups.com.br/ptbr/";
					}else if(resultado == "2"){
						$(".modal-body").html("E-mail ou senha incorretos.<br>Tente novamente.");
						$(".modal-footer").html("<button type='button' value='Tentar Novamente' class='btn btn-primary' onClick='abrirLogin();'>Tentar Novamente</button>");
					}else{
						$(".modal-body").load("scripts/alterar-senha.php");
						setTimeout(function(){
							$("#codJogador").val(resultado);
						}, 500);						
					}				
					return false;
				}
			});
		}
		return false;
	}
	function enviarCadastro(){
		$("#cadastro").submit();
	}
	function cadastro(){
		$(".modal-title").html("<h3>Junte-se a milhares de campeões.</h3>");
		$(".modal-body").load("ptbr/cadastro.php");
		$(".modal-footer").html("<button type='button' value='Enviar' class='btn btn-primary' onClick='enviarCadastro();'>Enviar</button>");
		$(".modal").modal();
	}
	function validarCadastro(){
		if($("#nome").val() == "" || $("#sobrenome").val() == "" || $("#nick").val() == "" || $("#emailCadastro").val() == "" || $("#emailConfirmar").val() == "" || $("#senhaCadastro").val() == "" || $("#senhaConfirmar").val() == ""){
			$("#status").html("Todos os dados devem ser preenchidos!<br><br>");
			document.getElementById("status").style.display = "block";			
			return	false;
		}else if($("#emailCadastro").val() != $("#emailConfirmar").val()){
			alert($("#email").val());
			alert($("#emailConfirmar").val());
			$("#status").html("Os e-mail não conferem!<br><br>");
			document.getElementById("status").style.display = "block";			
			return	false;
		}else if($("#senhaCadastro").val() != $("#senhaConfirmar").val()){
			$("#status").html("As senhas não conferem!<br><br>");
			document.getElementById("status").style.display = "block";			
			return	false;
		}else if(!document.getElementById("termos").checked){
			$("#status").html("Você precisa aceitar nossos Termos! <br><br>");
			document.getElementById("status").style.display = "block";			
			return	false;
		}else{
			jQuery.ajax({
				type: "POST",
				url: "ptbr/cadastro-checar.php",
				data: jQuery("#cadastro").serialize(),
				success: function( data )
				{
					$("#status").html(data);
					if($("#status").text() == "0"){
						document.getElementById("status").style.display = "none";
						window.location.replace("ptbr/cadastro-enviar.php");
					}else {										
						document.getElementById("status").style.display = "block";
					}
					
				}
			});
		}
		return false;
	}
	function esqueciSenha(){
        $(".modal-title").html("<h1>RECUPERAÇÃO DE SENHA</h1>");
		$(".modal-body").load("scripts/recuperar-senha.php");
        $(".modal-footer").html("");
		$("#modal").modal();
	}
	function abrirNotificacoes(codJogador){
		jQuery.ajax({
			type: "POST",
			url: "scripts/usuario.php",
			data: "codjogador="+codJogador+"&funcao=notificacoes",
			success: function(data){
                $(".modal-title").html("Notificações Recentes");
				$(".modal-body").html(data);
				$(".modal-footer").html("");
                $(".modal").modal();
			}
		});
	}
	function validarNotificacao(codNotificacao){
		jQuery.ajax({
			type: "POST",
			url: "scripts/usuario.php",
			data: "codnotificacao="+codNotificacao+"&funcao=validar",
			success: function(data){
			}
		});
	}
	function enviarLogin(){
		$("#login").submit();
	}
	function abrirLogin(){
		$(".modal-title").html("<h3>Entre com seus dados cadastrados</h3>");
		$(".modal-body").html("<form action='' method='post' id='login' onSubmit='return validarLogin();' ><div class='form-group'><label for=''>E-mail</label><input type='text' name='email' id='email' placeholder='E-MAIL' class='form-control'></div><div class='form-group'><label for=''>Senha</label><input type='password' name='senha' id='senha' placeholder='SENHA' class='form-control'></div><div class='col-md-6 esqueciSenha' onClick='esqueciSenha();'>Esqueci minha senha!</div><div class='col-md-6'><input type='checkbox' name='remember' value='1' checked id='remember'>PERMANECER LOGADO</div><br></form>");
		$(".modal-footer").html("<button type='button' value='Entrar' class='btn btn-primary' onClick='enviarLogin();'>Entrar</button>");
        $(".modal").modal();
	}   
</script>
<?php
	if(!isset($lobby['codigo'])){
		if(isset($usuario['codigo'])){
			$pesquisaLobby = mysqli_query($conexao, "
					SELECT * FROM lobby_equipe_semente
					INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
					WHERE lobby_equipe_semente.cod_jogador = ".$usuario['codigo']."
					AND lobby_equipe.posicao = 0
				");
			if($lobby = mysqli_fetch_array($pesquisaLobby)){
				header("Location: https://www.esportscups.com.br/ptbr/lobby/".$lobby['cod_lobby']."/");
			}			
		}	
	}	
?>
<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title centralizar" id="exampleModalLabel">Modal title</h5>
      </div>
      <div class="modal-body centralizar">
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle">Toggle Menu</a>
<div id="wrapper">
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="">e-Sports Cups</a>
            </li>
            <li>Ok</li>
            <li>Ok</li>
            <li>Ok</li>
            <li>Ok</li>
            <li>Ok</li>
        </ul>
    </div>    





