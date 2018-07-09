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
<link rel="stylesheet" href="<?php echo $css; ?>sitego.css">
<script src="js/jquery.js"></script>
</head>

<body>
	<?php
		include "header.php";
	?>
	<div class="barraCentral">
		<div class="hexagono novo">
			<img src="../img/siego/novo.png" alt="">
		</div>
		<div class="hexagono novo">
			<img src="../img/siego/hexagono-padrao.png" alt="">
		</div>
		<div class="hexagono novo">
			<img src="../img/siego/hexagono-padrao.png" alt="">
		</div>
		<div class="hexagono novo">
			<img src="../img/siego/hexagono-padrao.png" alt="">
		</div>
		<div class="hexagono novo">
			<img src="../img/siego/hexagono-padrao.png" alt="">
		</div>
		<div class="hexagono novo margem">
			<img src="../img/siego/hexagono-padrao.png" alt="">
		</div>
		<div class="hexagono novo">
			<img src="../img/siego/hexagono-padrao.png" alt="">
		</div>
		<div class="hexagono novo">
			<img src="../img/siego/hexagono-padrao.png" alt="">
		</div>
		<div class="hexagono novo">
			<img src="../img/siego/hexagono-padrao.png" alt="">
		</div>
		<div class="hexagono novo">
			<img src="../img/siego/hexagono-padrao.png" alt="">
		</div>
	</div>
	<script type="text/javascript">
		jQuery(function($){
			$(".sitego").addClass("ativo");
		});
	</script>
</body>
</html>