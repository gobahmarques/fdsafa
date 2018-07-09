<?php
	include "session.php";
	include "enderecos.php";
	$artigo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM artigos WHERE codigo = ".$_GET['artigo']." "));
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>eSC - Painel de Controle</title>
<link rel="stylesheet" href="<?php echo $css; ?>estrutura.css">
<link rel="stylesheet" href="<?php echo $css; ?>artigos.css">
<script src="js/jquery.js"></script>
</head>

<body>
	<?php
		include "header.php";
	?>
	<div class="barraCentral">
		<div class="criarArtigo">
			<form action="artigos-novo-enviar.php" method="post" enctype="multipart/form-data">
				<input type="hidden" value="alterar" name="funcao">
				<input type="hidden" value="<?php echo $artigo['codigo']; ?>" name="codartigo">
				<input type="text" name="nome" placeholder="TÍTULO DO ARTIGO" size="132" value="<?php echo $artigo['nome']; ?>" required>
				<input type="text" name="codautor" placeholder="CODIGO DO AUTOR" value="<?php echo $artigo['autor']; ?>" required>
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
				<textarea name="descricao" id="" cols="192" rows="3" required placeholder="Descrição para compartilhamento no Facebook" maxlength="512"><?php echo $artigo['descricao']; ?></textarea>
				<textarea name="artigo" id="artigo" cols="30" rows="10" required><?php echo $artigo['artigo']; ?></textarea><br>
				<input type="file" name="thumb">
				<input type="submit" class="botaoLaranja" value="ATUALIZAR INFORMAÇÕES">
			</form>
		</div>
	</div>
	<script src="js/ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
		CKEDITOR.replace( 'artigo' );
		jQuery(function($){
			$(".artigos").addClass("ativo");
		});
	</script>
</body>
</html>