<?php
	include "../conexao-banco.php";
		
	// HEARTHSTONE

	$inicioCamp = date("Y-m-d")." 20:00:00";
	$inicioCamp = date("Y-m-d H:i:s", strtotime("+7days", strtotime($inicioCamp)));
	$fim = date("Y-m-d H:i:s", strtotime("+5hours", strtotime($inicioCamp)));
	$inicioInscricao = date("Y-m-d H:i:s", strtotime("-72hours", strtotime($inicioCamp)));
	$fimInscricao = date("Y-m-d H:i:s", strtotime("-5minutes", strtotime($inicioCamp)));

	$descricao = "<p>Chegou a hora de alcançar o próximo nível da sua gameplay. Ganhe dinheiro jogando as Copas Hearthstone da eSC. Todo dia às 20hrs, entre nessa disputa e aumente o nível de suas jogadas.</p>";
	$regulamento = "
	<ol>
		<li><strong>Formato do Torneio</strong>
		<ul>
			<li>Elimina&ccedil;&atilde;o Simples</li>
			<li>Conquest - 4 escolhas e 1 banimento</li>
			<li>Partidas MD 5 (Melhor de 5)<br />
			&nbsp;</li>
		</ul>
		</li>
		<li><strong>Sobre as Partidas</strong>
		<ul>
			<li>Partidas MD 5</li>
			<li>Ap&oacute;s ganhar com 1 her&oacute;i, n&atilde;o &eacute; poss&iacute;vel mais jogar com ele</li>
			<li>Caso um jogador inicie uma partida com um baralho fora da sele&ccedil;&atilde;o final, ele receber&aacute; derrota nesta partida.</li>
			<li>Caso a tela de desafio seja cancelada por um dos dois jogadores, o mesmo ir&aacute; receber derrota na S&eacute;rie<br />
			&nbsp;</li>
		</ul>
		</li>
		<li><strong>ScreenShots</strong>
		<ul>
			<li>Recomendamos a todos os jogadores a realizarem uma captura de tela das seguintes situa&ccedil;&otilde;es:
			<ol>
				<li>Tela de desafio antes de iniciar a disputa pela s&eacute;rie.</li>
				<li>Final da partida (tanto vit&oacute;ria quanto derrota).</li>
				<li>Seu oponente cancelou o desafio (ou foi derrubado pelo jogo).</li>
				<li>Seu oponente cancelou desafio e abriu sua cole&ccedil;&atilde;o.</li>
				<li>Qualquer situa&ccedil;&atilde;o que voc&ecirc; julgar necess&aacute;ria para poss&iacute;veis disputas.</li>
			</ol>
			</li>
			<li>A troca de printscreens antes do in&iacute;cio da s&eacute;rie &eacute; opcional, por&eacute;m, caso um dos jogadores solicite, &eacute; obrigat&oacute;rio seu envio para o advers&aacute;rio.</li>
		</ul>
		</li>
	</ol>
	";
	$cronograma = "
	<p><strong>Check-in:</strong> ".date("d/m - H:i", strtotime($inicioCamp))."<br />
	<strong>W.O.:</strong> ".date("d/m - H:i", strtotime("+15minutes", strtotime($inicioCamp)))."</p>
	";

	$premiacao = "<img src='img/campeonatos/copas/copa-ouro-hs.png' widt='100%' />";
	$thumb = "../img/campeonatos/copas/copaouro.png";

	$premiacao = addslashes($premiacao);

	mysqli_query($conexao, "
		INSERT INTO campeonato VALUES
		(NULL, 11, 639282, 369, 'Copa Ouro Hearthstone', 16, 1, 0, 10, '$inicioInscricao', '$fimInscricao', '$inicioCamp', '$fim', 'Américas', '$descricao', '$regulamento', '$premiacao', '$cronograma', '$thumb', 0, 'Horário de Brasília', NULL, 'Brasil', 'Online', 0, 0, 1, 4, 1, 'PC', 0)
	");
?>