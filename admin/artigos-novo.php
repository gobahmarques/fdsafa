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
<link rel="stylesheet" href="<?php echo $css; ?>artigos.css">
<link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
</head>

<body>
	<?php
		include "header.php";
	?>
	<div class="barraCentral">
		<div class="criarArtigo">
			<form action="artigos-novo-enviar.php" method="post" enctype="multipart/form-data">
				<input type="hidden" value="criar" name="funcao">
				<input type="text" name="nome" placeholder="TÍTULO DO ARTIGO" size="125" required>
				<input type="text" name="codautor" placeholder="CODIGO DO AUTOR" required>
				<select name="codjogo" id="">
					<option value="" hidden>SELECIONE A CATEGORIA</option>
					<option value="0">Plataforma</option>
					<?php
						$jogos = mysqli_query($conexao, "SELECT * FROM jogos ORDER BY nome");
						while($jogo = mysqli_fetch_array($jogos)){
						?>
							<option value="<?php echo $jogo['codigo']; ?>"><?php echo $jogo['nome']; ?></option>
						<?php
						}
					?>
				</select>
				<textarea name="descricao" id="descricao" cols="188" rows="3" required placeholder="Descrição para compartilhamento no Facebook" maxlength="512" data-editable data-name="main-content"></textarea>
				<textarea name="artigo" id="artigo" cols="192" rows="10"></textarea><br>
				<input type="file" name="thumb" required>
				<input type="submit" class="botaoLaranja" value="ENVIAR ARTIGO">
			</form>
		</div>
	</div>
	<script src="js/jquery.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>
	<script type="text/javascript">		
		CKEDITOR.replace( 'artigo' );
		jQuery(function($){
			$(".artigos").addClass("ativo");
		});
	</script>
</body>
</html>