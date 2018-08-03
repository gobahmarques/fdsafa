<?php
	include "../conexao-banco.php";
		
	// DOTA 2

	$inicioCamp = date("Y-m-d")." 19:00:00";
	$fim = date("Y-m-d H:i:s", strtotime("+4hours 59minutes", strtotime($inicioCamp)));
	$inicioInscricao = date("Y-m-d H:i:s", strtotime("-9 hours", strtotime($inicioCamp)));
	$fimInscricao = date("Y-m-d H:i:s", strtotime("-30minutes", strtotime($inicioCamp)));

	$descricao = "<p>A eSCoin Cup &eacute; um torneio que visa premiar o usu&aacute;rio com eSCoins. Ajudando-o a acumular recursos muito mais r&aacute;pido.</p>";
	$regulamento = "
	<ol>
		<li><strong>Regras do Torneio</strong>
		<ul>
			<li>Elimina&ccedil;&atilde;o-Simples com at&eacute; 16 jogadores.</li>
			<li>Tipos de S&eacute;ries:
			<ul>
				<li>Oitavas, Quartas e&nbsp;Semis: MD1</li>
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
	$premiacao = "<p><strong>1st&nbsp;</strong>- e$ 800<br />
	<strong>2nd</strong>&nbsp;- e$ 400<br />
	<strong>3rd~4th</strong>&nbsp;- e$ 200<br />
	<strong>5th~8th</strong>&nbsp;- e$ 100</p>
	";
	$cronograma = "
	<p><strong>Check-in:</strong> ".date("d/m", strtotime($inicioCamp))." - ".date("H:i", strtotime("-15minutes", strtotime($inicioCamp)))." ~ ".date("H:i", strtotime("+15minutes", strtotime($inicioCamp)))."<br />
	<strong>W.O.:</strong> ".date("d/m - H:i", strtotime("+15minutes", strtotime($inicioCamp)))."</p>
	";

	$thumb = "../img/campeonatos/escoincup/dota2.png";

	mysqli_query($conexao, "
		INSERT INTO campeonato VALUES
		(NULL, 11, 639282, 357, 'eSCoin Cup', 16, 1, 0, '$inicioInscricao', '$fimInscricao', '$inicioCamp', '$fim', 'Américas', '$descricao', '$regulamento', '$premiacao', '$cronograma', '$thumb', 0, 'Horário de Brasília', NULL, 'Brasil', 'Online', 0, 0, 1, 4, 1, 'PC', 60)
	");
?>