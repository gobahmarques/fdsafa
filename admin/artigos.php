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
<script src="js/jquery.js"></script>
</head>

<body>
	<?php
		include "header.php";
	?>
	<div class="barraCentral">
		<div class="acoes">
			<a href="painel/artigos/novo/"><input type="button" value="NOVO ARTIGO" class="botaoLaranja"></a>
		</div>
		<?php
			$artigos = mysqli_query($conexao, "SELECT * FROM artigos ORDER BY data DESC");
			if(mysqli_num_rows($artigos) > 0){
			?>
				<table class="listaArtigos" cellpadding="0" cellspacing="0">
					<tr>
						<td>COD.</td>
						<td>Nome</td>
						<td>Autor</td>
						<td>Criado</td>
						<td>Jogo</td>
					</tr>
					<?php
						while($artigo = mysqli_fetch_array($artigos)){
							if($artigo['autor'] != NULL){
								$autor = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome, sobrenome, nick FROM jogador WHERE codigo = ".$artigo['autor']." "));
							}
							if($artigo['cod_jogo'] != NULL){
								$jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome FROM jogos WHERE codigo = ".$artigo['cod_jogo']." "));
							}else{
								$jogo['nome'] = "eSports Cups";
							}
						?>
							<tr>
								<td><?php echo $artigo['codigo'] ?></td>
								<td><a href="painel/artigos/<?php echo $artigo['codigo']; ?>/"><?php echo $artigo['nome']; ?></a></td>
								<td>
								<?php 
									if($artigo['autor'] != NULL){
										echo $autor['nome']." '".$autor['nick']."' ".$autor['sobrenome']; 	
									}else{
										echo "INDISPONÍVEL";
									}
									
								?>
								</td>
								<td><?php echo date("d/m/Y H:i", strtotime($artigo['data'])); ?></td>
								<td><?php echo $jogo['nome']; ?></td>
							</tr>
						<?php
						}
					?>
				</table>
			<?php
			}
		?>
	</div>
	<script type="text/javascript">
		jQuery(function($){
			$(".artigos").addClass("ativo");
		});
	</script>
</body>
</html>