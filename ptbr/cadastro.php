<form method="post" id="cadastro" action="cadastro-enviar.php" onSubmit="return validarCadastro();">
    <div class="row">
    <div class="form-group col-md-6">
		<label for="">Primeiro Nome</label>
		<input type="text" placeholder="NOME" name="nome" id="nome" autofocus style="width: 100%;" class="form-control">
	</div>
	<div class="form-group col-md-6">
		<label for="">Último Nome</label>
		<input type="text" placeholder="SOBRENOME" name="sobrenome" id="sobrenome" style="width: 100%;" class="form-control">
	</div>
	<div class="form-group col-md-6">
		<label for="">Apelido (nick)</label>
		<input type="text" placeholder="NICKNAME" name="nick" id="nick" style="width: 100%;" class="form-control">
	</div>
	<div class="form-group col-md-6">
		<label for="">E-mail</label>
		<input type="text" placeholder="EMAIL" name="email" id="emailCadastro" style="width: 100%;" class="form-control">
	</div>
	<div class="form-group col-md-6">
		<label for="">Confirmação de E-mail</label>
		<input type="text" placeholder="CONFIRMAR EMAIL" id="emailConfirmar" style="width: 100%;" class="form-control">
	</div>
	<div class="form-group col-md-6">
		<label for="">Senha</label>
		<input type="password" placeholder="SENHA" name="senha" id="senhaCadastro" style="width: 100%;" class="form-control">
	</div>
	<div class="form-group col-md-6">
		<label for="">Confirmação Senha</label>
		<input type="password" placeholder="CONFIRMAR SENHA" id="senhaConfirmar" style="width: 100%;" class="form-control">
	</div>
	<div class="form-group col-md-6">
		<label for="">Data Nascimento</label>
		<input type="text" placeholder="DD/MM/AAAA" style="width: 100%;" class="form-control maskData" name="dataNascimento">
	</div>
	
	<div class="form-group col-md-6">
		<label for="">Sexo</label>
		<select class="form-control" name="sexo">
			<option value=""></option>
			<option value="H">Homem</option>
			<option value="M">Mulher</option>
		</select>
	</div>
    </div>
	
	<br>
	<input id="termos" type="checkbox" name="termos"> Li e Concordo com os <a class="login" href="ptbr/termos/" target="_blank">Termos & Condições</a> e <a class="login" href="ptbr/privacidade/" target="_blank">Política de Privacidade.</a><br><br>	
</form>

<div class="col-xs-12 col-md-12">
	<br>
	<div class="status" id="status">
	</div>
</div>

<script>
    $(".maskData").mask("00/00/0000");
</script>