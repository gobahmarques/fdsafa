<?php
	include "../conexao-banco.php";
		
	// TERÇA-FERIA: HEARTHSTONE

	$inicio = date("Y-m-d")." 19:00:00";
	$inicioCamp = date("Y-m-d H:i:s", strtotime("+1days", strtotime($inicio)));
	$fim = date("Y-m-d H:i:s", strtotime("+4hours 59minutes", strtotime($inicioCamp)));
	$inicioInscricao = date("Y-m-d H:i:s", strtotime("-7days", strtotime($inicioCamp)));
	$fimInscricao = date("Y-m-d H:i:s", strtotime("-5minutes", strtotime($inicioCamp)));

	$descricao = "<p>A eSCoin Cup &eacute; um torneio que visa premiar o usu&aacute;rio com eSCoins. Ajudando-o a acumular recursos muito mais r&aacute;pido.</p>";
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
	$premiacao = "<p><strong>1st&nbsp;</strong>- e$ 800<br />
	<strong>2nd</strong>&nbsp;- e$ 400<br />
	<strong>3rd~4th</strong>&nbsp;- e$ 200<br />
	";
	$cronograma = "
	<p><strong>Check-in:</strong> ".date("d/m", strtotime($inicioCamp))." - ".date("H:i", strtotime("-60minutes", strtotime($inicioCamp)))." ~ ".date("H:i", strtotime($inicioCamp))."<br />
	<strong>W.O.:</strong> ".date("d/m - H:i", strtotime("+15minutes", strtotime($inicioCamp)))."</p>
	";

	$thumb = "../img/campeonatos/escoincup/hs.png";

	mysqli_query($conexao, "
		INSERT INTO campeonato VALUES
		(NULL, 11, 639282, 369, 'eSCoin Cup Hearthstone', 32, 1, 0, 0, '$inicioInscricao', '$fimInscricao', '$inicioCamp', '$fim', 'Américas', '$descricao', '$regulamento', '$premiacao', '$cronograma', '$thumb', 0, 'Horário de Brasília', NULL, 'Brasil', 'Online', 0, 0, 1, 4, 1, 'PC', 60, NULL, 0, NULL)
	");

	$id = mysqli_insert_id($conexao);
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 1, 800, 0, NULL, NULL)");
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 2, 400, 0, NULL, NULL)");
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 3, 200, 0, NULL, NULL)");
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 4, 200, 0, NULL, NULL)");

	// QUARTA-FEIRA: DOTA 2 X1 MID

	$inicioCamp = date("Y-m-d")." 19:00:00";
	$inicioCamp = date("Y-m-d H:i:s", strtotime("+2days", strtotime($inicioCamp)));
	$fim = date("Y-m-d H:i:s", strtotime("+4hours 59minutes", strtotime($inicioCamp)));
	$inicioInscricao = date("Y-m-d H:i:s", strtotime("-7days", strtotime($inicioCamp)));
	$fimInscricao = date("Y-m-d H:i:s", strtotime("-5minutes", strtotime($inicioCamp)));

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
	";
	$cronograma = "
	<p><strong>Check-in:</strong> ".date("d/m", strtotime($inicioCamp))." - ".date("H:i", strtotime("-60minutes", strtotime($inicioCamp)))." ~ ".date("H:i", strtotime($inicioCamp))."<br />
	<strong>W.O.:</strong> ".date("d/m - H:i", strtotime("+15minutes", strtotime($inicioCamp)))."</p>
	";

	$thumb = "../img/campeonatos/escoincup/dota2.png";

	mysqli_query($conexao, "
		INSERT INTO campeonato VALUES
		(NULL, 11, 639282, 357, 'eSCoin Cup Dota 2 X1', 16, 1, 0, 0, '$inicioInscricao', '$fimInscricao', '$inicioCamp', '$fim', 'Américas', '$descricao', '$regulamento', '$premiacao', '$cronograma', '$thumb', 0, 'Horário de Brasília', NULL, 'Brasil', 'Online', 0, 0, 1, 0, 0, 'PC', 60, NULL, 0, NULL)
	");

	$id = mysqli_insert_id($conexao);
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 1, 800, 0, NULL, NULL)");
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 2, 400, 0, NULL, NULL)");
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 3, 200, 0, NULL, NULL)");
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 4, 200, 0, NULL, NULL)");

	// QUINTA-FEIRA: LEAGUE OF LEGENDS X5

	$inicioCamp = date("Y-m-d")." 19:00:00";
	$inicioCamp = date("Y-m-d H:i:s", strtotime("+3days", strtotime($inicioCamp)));
	$fim = date("Y-m-d H:i:s", strtotime("+4hours 59minutes", strtotime($inicioCamp)));
	$inicioInscricao = date("Y-m-d H:i:s", strtotime("-7days", strtotime($inicioCamp)));
	$fimInscricao = date("Y-m-d H:i:s", strtotime("-5minutes", strtotime($inicioCamp)));

	$descricao = "<p>Torneio semanal de League of Legends organizado pela e-Sports Cups para premiar seus ganhadores com eSCoins.</p>";
	$regulamento = addslashes("
	<ol>
		<li>Formato do Torneio:
		<ul>
			<li>Salvo se houver alguma instabilidade no servidor durante o torneio, ele ser&aacute; realizado em uma &uacute;nica etapa online.</li>
			<li>N&atilde;o h&aacute; limite m&iacute;nimo de inscri&ccedil;&otilde;es e o limite m&aacute;ximo &eacute; de 8 equipes de 5 jogadores. Caso o n&uacute;mero m&aacute;ximo seja excedido, ter&atilde;o prioridades definidas de acordo com Data &amp; Hora da inscri&ccedil;&atilde;o.</li>
			<li>Todas as partidas do torneio ser&atilde;o melhores de um (MD 1), incluindo a final.</li>
			<li>Todas as partidas ser&atilde;o disputadas no mapa <strong>Summoner&#39;s Rift</strong>, no modo Draft Competitivo, usando os c&oacute;digos gerados por um dos capit&atilde;es dos times em confronto.</li>
			<li>Todas as partidas ser&atilde;o disputadas no <strong>SERVIDOR BR.</strong></li>
		</ul>
		</li>
		<li>Regras das Partidas:
		<ul>
			<li>O tempo limite de atraso para QUALQUER PARTIDA &eacute; de 15 (quinze) minutos. Para confirmar sua presen&ccedil;a em cada partida, &eacute; necess&aacute;rio (O CAPIT&Atilde;O DA EQUIPE) apertar o bot&atilde;o &quot;READY/PRONTO&quot; na p&aacute;gina da partida.</li>
			<li>Cada equipe tem o direita a um total de 10 minutos de <em>pause</em>, que devem ser usados para resolver problemas t&eacute;cnicos <strong>APENAS</strong>.</li>
			<li>Em caso de abandono de partida durante os picks e bans, dever&aacute; a mesma ser refeita de onde parou (com os picks e bans que j&aacute; foram realizados sendo repetidos).</li>
			<li>Proibido uso de pick coringa. Em caso de desconectar durante a sele&ccedil;&atilde;o de picks ou ban os jogadores dever&atilde;o iniciar novamente repetindo exatamente os msmos bans e picks em ordem.</li>
			<li>Equipes do lado de cima da partida na tabela, (lado esquerda da tela de partida) tem o direito de escolher qual lado do mapa vai jogar.</li>
		</ul>
		</li>
		<li>Durante o torneio:
		<ul>
			<li>O modo espectador deve ficar liberado o campeonato todo. Os coachs, em especial, est&atilde;o liberados para assistir tudo, incluindo os picks.</li>
			<li>A pr&oacute;pria plataforma da eSports Cups atualiza a tabela ap&oacute;s a confirma&ccedil;&atilde;o dos resultados de uma partida, caso haja algum problema com a tabela do torneio, entre em nosso discord, estaremos sempre l&aacute;: <a href='https://discord.gg/QNnP9hr' target='_blank'><strong>DISCORD ESPORTS CUPS.</strong></a></li>
			<li>Cada time tem o direito de utilizar 1 (um) jogador que n&atilde;o est&aacute; inscrito (completer). Vale lembrar que ainda assim, &eacute; necess&aacute;rio que o jogador esteja cadastrado na Plataforma da e-Sports Cups para receber a premia&ccedil;&atilde;o.</li>
			<li>Fair Play &eacute; um ato louv&aacute;vel, mas n&atilde;o &eacute; considerado obrigat&oacute;rio. Ao tomar essa conduta (por qualquer motivo que seja), voc&ecirc; est&aacute; assumindo seus riscos. A organiza&ccedil;&atilde;o n&atilde;o obriga e nem condena algu&eacute;m que n&atilde;o fa&ccedil;a uso desse recurso.</li>
			<li>Administradores tem poderes totais e absolutos para quaisquer decis&otilde;es em rela&ccedil;&atilde;o ao torneio e &agrave;s partidas.</li>
		</ul>
		</li>
	</ol>
	");
	$premiacao = "<p><strong>1st&nbsp;</strong>- e$ 5.000<br />
	<strong>2nd</strong>&nbsp;- e$ 2.500<br />
	<strong>3rd~4th</strong>&nbsp;- e$ 1.250<br />
	";
	$cronograma = "
	<p><strong>Check-in:</strong> ".date("d/m", strtotime($inicioCamp))." - ".date("H:i", strtotime("-60minutes", strtotime($inicioCamp)))." ~ ".date("H:i", strtotime($inicioCamp))."<br />
	<strong>W.O.:</strong> ".date("d/m - H:i", strtotime("+15minutes", strtotime($inicioCamp)))."</p>
	";

	$thumb = "../img/campeonatos/escoincup/lol.png";

	mysqli_query($conexao, "
		INSERT INTO campeonato VALUES
		(NULL, 11, 639282, 147, 'eSCoin Cup LoL', 16, 5, 0, 0, '$inicioInscricao', '$fimInscricao', '$inicioCamp', '$fim', 'Américas', '$descricao', '$regulamento', '$premiacao', '$cronograma', '$thumb', 1, 'Horário de Brasília', NULL, 'Brasil', 'Online', 0, 0, 1, 0, 0, 'PC', 60, NULL, 0, NULL)
	");
	
	$id = mysqli_insert_id($conexao);
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 1, 5000, 0, NULL, NULL)");
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 2, 2500, 0, NULL, NULL)");
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 3, 1250, 0, NULL, NULL)");
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 4, 1250, 0, NULL, NULL)");

	// SABADO: GWENT The Witcher Card Game

	$inicio = date("Y-m-d")." 19:00:00";
	$inicioCamp = date("Y-m-d H:i:s", strtotime("+5days", strtotime($inicio)));
	$fim = date("Y-m-d H:i:s", strtotime("+4hours 59minutes", strtotime($inicioCamp)));
	$inicioInscricao = date("Y-m-d H:i:s", strtotime("-7days", strtotime($inicioCamp)));
	$fimInscricao = date("Y-m-d H:i:s", strtotime("-5minutes", strtotime($inicioCamp)));

	$descricao = "<p>A eSCoin Cup &eacute; um torneio que visa premiar o usu&aacute;rio com eSCoins. Ajudando-o a acumular recursos muito mais r&aacute;pido.</p><p><strong>Torneio não oficial CD Projekt Red </strong></p>";
	$regulamento = "
	<ol>
		<li><strong>Formato do Torneio</strong>
		<ul>
			<li>Elimina&ccedil;&atilde;o Simples</li>
			<li>4 escolhas na inscrição e 1 ban a cada partida.</li>
			<li>Partidas MD 5 (Melhor de 5)<br />
			&nbsp;</li>
		</ul>
		</li>
		<li><strong>Sobre as Partidas</strong>
		<ul>
			<li>Partidas MD 5</li>
			<li>Ap&oacute;s ganhar com 1 facção, n&atilde;o &eacute; poss&iacute;vel mais jogar com ela</li>
			<li>Caso um jogador inicie uma partida com um baralho não incluso na sele&ccedil;&atilde;o final, ele receber&aacute; derrota nesta partida.</li>
			<li>Caso a tela de desafio seja cancelada por um dos dois jogadores, o mesmo ir&aacute; receber derrota na S&eacute;rie</li>
			<li>Se um jogo for interrompido por falha no PC, rede ou software de um jogador, seu oponente recebrá vitória nesta partida da série.</li>
		</ul>
		</li>
	</ol>
	";
	$premiacao = "<p><strong>1st&nbsp;</strong>- e$ 800<br />
	<strong>2nd</strong>&nbsp;- e$ 400<br />
	<strong>3rd~4th</strong>&nbsp;- e$ 200<br />
	";
	$cronograma = "
	<p><strong>Check-in:</strong> ".date("d/m", strtotime($inicioCamp))." - ".date("H:i", strtotime("-60minutes", strtotime($inicioCamp)))." ~ ".date("H:i", strtotime($inicioCamp))."<br />
	<strong>W.O.:</strong> ".date("d/m - H:i", strtotime("+15minutes", strtotime($inicioCamp)))."</p>
	";

	$thumb = "../img/campeonatos/escoincup/gwent.png";

	mysqli_query($conexao, "
		INSERT INTO campeonato VALUES
		(NULL, 11, 639282, 123, 'eSCoin Cup GWENT', 32, 1, 0, 0, '$inicioInscricao', '$fimInscricao', '$inicioCamp', '$fim', 'Américas', '$descricao', '$regulamento', '$premiacao', '$cronograma', '$thumb', 0, 'Horário de Brasília', NULL, 'Brasil', 'Online', 0, 0, 1, 4, 1, 'PC', 60, NULL, 0, NULL)
	");

	$id = mysqli_insert_id($conexao);
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 1, 800, 0, NULL, NULL)");
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 2, 400, 0, NULL, NULL)");
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 3, 200, 0, NULL, NULL)");
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 4, 200, 0, NULL, NULL)");

	// SEXTA: Overwatch

	$inicio = date("Y-m-d")." 19:00:00";
	$inicioCamp = date("Y-m-d H:i:s", strtotime("+4days", strtotime($inicio)));
	$fim = date("Y-m-d H:i:s", strtotime("+4hours 59minutes", strtotime($inicioCamp)));
	$inicioInscricao = date("Y-m-d H:i:s", strtotime("-7days", strtotime($inicioCamp)));
	$fimInscricao = date("Y-m-d H:i:s", strtotime("-5minutes", strtotime($inicioCamp)));

	$descricao = "<p>A eSCoin Cup &eacute; um torneio que visa premiar o usu&aacute;rio com eSCoins. Ajudando-o a acumular recursos muito mais r&aacute;pido.</p>";
	$regulamento = "
	<p>Os capit&atilde;es das equipes ser&atilde;o respons&aacute;veis por:</p>
	<ol>
		<li>Criar e finalizar o processo de Draft atrav&eacute;s do link (http://owdraft.com/create)</li>
		<li>Criar o lobby dentro do jogo e convidar os jogadores.</li>
		<li>Ao final da s&eacute;rie, informar o resultado final na plataforma.</li>
	</ol>

	";
	$premiacao = "<p><strong>1st</strong> - e$ 4.800<br />
		<strong>2nd</strong> - e$ 2.400<br />
		<strong>3rd~4th</strong> - e$ 1.200</p><br>
	";
	$cronograma = "
	<p><strong>Check-in:</strong> ".date("d/m", strtotime($inicioCamp))." - ".date("H:i", strtotime("-60minutes", strtotime($inicioCamp)))." ~ ".date("H:i", strtotime($inicioCamp))."<br />
	<strong>W.O.:</strong> ".date("d/m - H:i", strtotime("+15minutes", strtotime($inicioCamp)))."</p>
	";

	$thumb = "../img/campeonatos/escoincup/ow.png";

	mysqli_query($conexao, "
		INSERT INTO campeonato VALUES
		(NULL, 11, 639282, 258, 'eSCoin Cup Overwatch', 16, 6, 0, 0, '$inicioInscricao', '$fimInscricao', '$inicioCamp', '$fim', 'Américas', '$descricao', '$regulamento', '$premiacao', '$cronograma', '$thumb', 1, 'Horário de Brasília', NULL, 'Brasil', 'Online', 0, 0, 1, 0, 0, 'PC', 60, NULL, 0, NULL)
	");

	$id = mysqli_insert_id($conexao);
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 1, 4800, 0, NULL, NULL)");
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 2, 2400, 0, NULL, NULL)");
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 3, 1200, 0, NULL, NULL)");
	mysqli_query($conexao, "INSERT INTO campeonato_premiacao VALUES ($id, 4, 1200, 0, NULL, NULL)");

?>