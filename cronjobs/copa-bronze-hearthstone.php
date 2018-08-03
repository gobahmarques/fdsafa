<?php
	include "../conexao-banco.php";
		
	// HEARTHSTONE

	$inicioCamp = date("Y-m-d")." 20:00:00";
	$inicioCamp = date("Y-m-d H:i:s", strtotime("+48hours", strtotime($inicioCamp)));

	

	$fim = date("Y-m-d H:i:s", strtotime("+5hours", strtotime($inicioCamp)));

	

	$inicioInscricao = date("Y-m-d H:i:s", strtotime("-72hours", strtotime($inicioCamp)));
	$fimInscricao = date("Y-m-d H:i:s", strtotime("-5minutes", strtotime($inicioCamp)));

	$descricao = "<p>Chegou a hora de alcançar o próximo nível da sua gameplay. Ganhe dinheiro jogando as Copas eSC. Todo dia às 20hrs, entre nessa disputa e aumente o nível de suas jogadas.</p>";

	
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
	
	$premiacao = "<table align='center' border='0' cellpadding='5' cellspacing='1' style='width:100%'>
		<tbody>
			<tr>
				<td>&nbsp;</td>
				<td><strong>1st</strong></td>
				<td><strong>2nd</strong></td>
				<td><strong>3rd~4th</strong></td>
				<td><strong>5th~8th</strong></td>
			</tr>
			<tr>
				<td><strong>2 Inscrições</strong></td>
				<td>R$ 1,90</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><strong>3 Inscrições</strong></td>
				<td>R$ 2,00</td>
				<td>R$ 0,85</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><strong>4 Inscrições</strong></td>
				<td>R$ 2,50</td>
				<td>R$ 1,30</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><strong>5 Inscrições</strong></td>
				<td>R$ 2,50</td>
				<td>R$ 1,50</td>
				<td>R$ 0,30</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><strong>6 Inscrições</strong></td>
				<td>R$ 2,80</td>
				<td>R$ 1,80</td>
				<td>R$ 0,50</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><strong>7 Inscrições</strong></td>
				<td>R$ 3,00</td>
				<td>R$ 2,00</td>
				<td>R$ 0,75</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><strong>8 Inscrições</strong></td>
				<td>R$ 3,60</td>
				<td>R$ 2,00</td>
				<td>R$ 1,00</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><strong>9 Inscrições</strong></td>
				<td>R$ 3,55</td>
				<td>R$ 2,00</td>
				<td>R$ 1,00</td>
				<td>R$ 0,25</td>
			</tr>
			<tr>
				<td><strong>10 Inscrições</strong></td>
				<td>R$ 3,50</td>
				<td>R$ 2,00</td>
				<td>R$ 1,00</td>
				<td>R$ 0,50</td>
			</tr>
			<tr>
				<td><strong>11 Inscrições</strong></td>
				<td>R$ 3,45</td>
				<td>R$ 2,00</td>
				<td>R$ 1,00</td>
				<td>R$ 0,75</td>
			</tr>
			<tr>
				<td><strong>12 Inscrições</strong></td>
				<td>R$ 3,45</td>
				<td>R$ 2,45</td>
				<td>R$ 1,25</td>
				<td>R$ 0,75</td>
			</tr>
			<tr>
				<td><strong>13 Inscrições</strong></td>
				<td>R$ 3,90</td>
				<td>R$ 2,45</td>
				<td>R$ 1,50</td>
				<td>R$ 0,75</td>
			</tr>
			<tr>
				<td><strong>14 Inscrições</strong></td>
				<td>R$ 3,90</td>
				<td>R$ 2,40</td>
				<td>R$ 1,50</td>
				<td>R$ 1,00</td>
			</tr>
			<tr>
				<td><strong>15 Inscrições</strong></td>
				<td>R$ 4,25</td>
				<td>R$ 3,00</td>
				<td>R$ 1,50</td>
				<td>R$ 1,00</td>
			</tr>
			<tr>
				<td><strong>16 Inscrições</strong></td>
				<td>R$ 5,00</td>
				<td>R$ 3,00</td>
				<td>R$ 1,50</td>
				<td>R$ 1,00</td>
			</tr>
		</tbody>
	</table>
	";

	$premiacao = addslashes($premiacao);

	$cronograma = "
	<p><strong>Check-in:</strong> ".date("d/m - H:i", strtotime($inicioCamp))."<br />
	<strong>W.O.:</strong> ".date("d/m - H:i", strtotime("+15minutes", strtotime($inicioCamp)))."</p>
	";

	$thumb = "../img/campeonatos/copas/copabronze.png";

	echo $premiacao;

	mysqli_query($conexao, "
		INSERT INTO campeonato VALUES
		(NULL, 11, 639282, 369, 'Copa Bronze Hearthstone', 16, 1, 0, 1, '$inicioInscricao', '$fimInscricao', '$inicioCamp', '$fim', 'Américas', '$descricao', '$regulamento', '$premiacao', '$cronograma', '$thumb', 0, 'Horário de Brasília', NULL, 'Brasil', 'Online', 0, 0, 1, 4, 1, 'PC', 0)
	");
?>