<?php
	include "../conexao-banco.php";
		
	// Dota 2

	$inicioCamp = date("Y-m-d")." 20:00:00";
	$inicioCamp = date("Y-m-d H:i:s", strtotime("+15days", strtotime($inicioCamp)));

	

	$fim = date("Y-m-d H:i:s", strtotime("+6days", strtotime($inicioCamp)));

	

	$inicioInscricao = date("Y-m-d H:i:s", strtotime("-14days", strtotime($inicioCamp)));
	$fimInscricao = date("Y-m-d H:i:s", strtotime("-5minutes", strtotime($inicioCamp)));

	$descricao = "<p>Chegou a hora de alcançar o próximo nível da sua gameplay. Ganhe dinheiro jogando as Copas eSC de Dota 2. Entre nessa disputa e aumente o nível de suas jogadas.</p>";

	
	$regulamento = "
	<ol>
		<li><strong>Regras do Torneio</strong>
		<ul>
			<li>Elimina&ccedil;&atilde;o-Simples com at&eacute; 16 jogadores.</li>
			<li>Tipos de S&eacute;ries:
			<ul>
				<li>Quartas e&nbsp;Semis: MD1</li>
				<li>Final: MD3<br />
				&nbsp;</li>
			</ul>
			</li>
		</ul>
		</li>
		<li><strong>Escolhas de Her&oacute;is</strong>
		<ul>
			<li>Aplica-se &agrave;s Oitavas, Quartas e Semis:
			<ul>
				<li>Est&aacute; permitido aos jogadores escolher qualquer her&oacute;i dispon&iacute;vel no modo X1 MID.</li>
			</ul>
			</li>
			<li>Aplica-se &agrave; Final:
			<ul>
				<li>Os jogadores poder&atilde;o escolher qualquer her&oacute;i dispon&iacute;vel no modo X1 MID.</li>
				<li>Em caso de empate, placar 1x1, os dois jogadores dever&atilde;o realizar a partida de desempate com o her&oacute;i <strong>Shadow Fiend.</strong><br />
				&nbsp;</li>
			</ul>
			</li>
		</ul>
		</li>
		<li><strong>Regras de Partida</strong>
		<ul>
			<li>O Lobby dentro do jogo dever&aacute; ser criado por um dos jogadores envolvidos na partida, que ser&aacute; decidido atrav&eacute;s do chat de partida.</li>
			<li>O vencedor de uma partida &eacute; definido com um dos seguintes crit&eacute;rios:
			<ol>
				<li>Advers&aacute;rio morrer 2 vezes.</li>
				<li>Destruir torre T1 do advers&aacute;rio.</li>
			</ol>
			</li>
			<li>Proibido o uso de qualquer tipo de <strong>RUNA.</strong></li>
			<li>Proibida a compra de <strong>GARRAFA (BOTTLE).</strong></li>
			<li>Proibido qualquer tipo de farm na <strong>JUNGLE.</strong></li>
			<li>Proibida a utiliza&ccedil;&atilde;o do <strong>SANTU&Aacute;RIO.</strong></li>
			<li>Proibida a utiliza&ccedil;&atilde;o de<strong> GOTA INFUNDIDA (RAIN DROP).</strong></li>
			<li>Proibida a utiliza&ccedil;&atilde;o de<strong> ANEL DA ALMA (SOUL RING).</strong></li>
			<li>Proibido desviar o caminho dos creeps (Exemplo: Fissure - Earthshaker), ficando apenas permitido o atraso dos creeps com Body Block (bloqueio de corpo).<br />
			&nbsp;</li>
		</ul>
		</li>
		<li><strong>PrintScreens</strong>
		<ul>
			<li>Ao final de cada partida, realize uma captura de tela do Score final da partida.<br />
			Caso haja uma disputa de resultado, provas ser&atilde;o solicitadas. Com penalidade para os que n&atilde;o apresentarem de acordo com julgamento da organiza&ccedil;&atilde;o.</li>
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

	$cronograma = "<strong>Partida 1-1: </strong>".date("d/m - H:i", strtotime("+1day", strtotime($inicioCamp)))."
	";

	$thumb = "../img/campeonatos/copas/copabronze.png";

	echo $premiacao;

	mysqli_query($conexao, "
		INSERT INTO campeonato VALUES
		(NULL, 11, 639282, 369, 'Copa Bronze Hearthstone', 16, 1, 0, 1, '$inicioInscricao', '$fimInscricao', '$inicioCamp', '$fim', 'Américas', '$descricao', '$regulamento', '$premiacao', '$cronograma', '$thumb', 0, 'Horário de Brasília', NULL, 'Brasil', 'Online', 0, 0, 1, 4, 1, 'PC', 0)
	");
?>