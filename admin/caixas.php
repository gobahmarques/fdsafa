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
</head>

<body>
	<?php
		include "header.php";
	?>
	<div class="barraCentral">
		<table class="caixas">
			<tr>
				<td>
					Em Análise
					<?php
						$caixas = mysqli_query($conexao, "SELECT * FROM caixa WHERE status = 0");
						while($caixa = mysqli_fetch_array($caixas)){
						?>
							<a href="painel/caixas/<?php echo $caixa['codigo']; ?>/">
								<div class="caixa">
									<?php echo $caixa['nome']; ?>
								</div>	
							</a>
							
						<?php
						}
					?>						
				</td>
				<td>
					Ativas
				</td>
				<td>
					Mais Rentáveis
				</td>
			</tr>
		</table>
		
	</div>
	<script type="text/javascript">
		jQuery(function($){
			$(".cxs").addClass("ativo");
		});
	</script>
</body>
</html>