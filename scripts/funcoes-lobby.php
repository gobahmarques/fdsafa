<?php
	header("Content-Type: text/html;  charset=ISO-8859-1",true);
	include "gameficacao.php";
	function realizarApostas($lobby){
		include "../conexao-banco.php";
		
		$minimoValido = mysqli_fetch_array(mysqli_query($conexao, "SELECT MIN(palpite) AS minimo FROM lobby_equipe_semente
		INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
		WHERE lobby_equipe.cod_lobby = ".$lobby['codigo']."
		AND lobby_equipe_semente.palpite > 0"));
		
		$apostas = mysqli_query($conexao, "SELECT *, lobby_equipe_semente.codigo AS codSeed FROM lobby_equipe_semente
		INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
		WHERE lobby_equipe.cod_lobby = ".$lobby['codigo']." AND lobby_equipe_semente.palpite > 0");
		
		while($aposta = mysqli_fetch_array($apostas)){
			mysqli_query($conexao, "UPDATE lobby_equipe_semente SET palpite = ".$minimoValido['minimo']." WHERE codigo = ".$aposta['codSeed']."");
			mysqli_query($conexao, "UPDATE jogador SET pontos = pontos - ".$minimoValido['minimo']." WHERE codigo = ".$aposta['cod_jogador']."");
			mysqli_query($conexao, "INSERT INTO log_coin VALUES (NULL, ".$aposta['cod_jogador'].", ".$minimoValido['minimo'].", 'Aposta no Lobby ".$lobby['codigo']."', 0, '".date("Y-m-d H:i:s")."')");
		}
	}

	function verificarCheckins($codLobby){
		include "../conexao-banco.php";
		$lobby = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM lobby WHERE codigo = $codLobby"));
		$qtdProntos = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM lobby_equipe_semente 
		INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
		WHERE lobby_equipe_semente.status = 1 AND lobby_equipe.cod_lobby = $codLobby "));
		
		if($qtdProntos == $lobby['times'] * $lobby['jogador_por_time']){
			$datahora = date("Y-m-d H:i:s");
			mysqli_query($conexao, "UPDATE lobby SET status = 1 WHERE codigo = $codLobby");
			
			$capitaes = mysqli_query($conexao, "SELECT *, lobby_equipe_semente.codigo AS codSeed FROM lobby_equipe_semente 
			INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
			WHERE lobby_equipe.cod_lobby = $codLobby
			GROUP BY lobby_equipe_semente.cod_equipe");
			
			while($capitao = mysqli_fetch_array($capitaes)){
				mysqli_query($conexao, "UPDATE lobby_equipe_semente SET capitao = 1 WHERE codigo = ".$capitao['codSeed']." ");
			}
			
			realizarApostas($lobby);
			
			require "../../js/vendor/autoload.php";
			$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
			$pusher->trigger('lobby'.$_POST['codlobby'], 'atualizar', array('message' => 'hello world'));
		}
	}

	function distribuirPote($codEquipe, $codLobby){ // DISTRIBUIR POTE PARA A EQUIPE GANHADORA DO LOBBY
		include "../conexao-banco.php";
		$datahora = date("Y-m-d H:i:s");
		$lobby = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM lobby WHERE codigo = $codLobby"));
		$valorPote = mysqli_fetch_array(mysqli_query($conexao, "
			SELECT SUM(lobby_equipe_semente.palpite) AS pote FROM lobby_equipe_semente
			INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
			WHERE lobby_equipe.cod_lobby = $codLobby
		"));
		
		$valorTime = mysqli_fetch_array(mysqli_query($conexao, "
			SELECT SUM(lobby_equipe_semente.palpite) AS poteTime FROM lobby_equipe_semente
			INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
			WHERE lobby_equipe.codigo = $codEquipe
		"));
		
		if($valorTime['poteTime'] != 0){
			$ganhadores = mysqli_query($conexao, "
				SELECT * FROM lobby_equipe_semente
				INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
				WHERE lobby_equipe.codigo = $codEquipe
			");	
			while($ganhador = mysqli_fetch_array($ganhadores)){
				$porcentagem = $ganhador['palpite'] / $valorTime['poteTime']; // CALCULA PORCENTAGEM DA APOSTA DELE NA APOSTA DO SEU TIME.
				$valorRecebido = ($valorPote['pote'] + $lobby['pote_inicial']) * $porcentagem; // VALOR QUE O USUÁRIO IRÁ RECEBER.
				if($valorRecebido != 0){ // SÓ FAZ O LANÇAMENTO SE ELE TIVER QUE RECEBER ALGUM VALOR
					mysqli_query($conexao, "
						INSERT INTO log_coin
						VALUES (NULL, ".$ganhador['cod_jogador'].", $valorRecebido, 'Vitória no Lobby $codLobby', 1, '$datahora')
					"); // LANÇAMENTO DO LOG
					mysqli_query($conexao, "
						UPDATE jogador
						SET pontos = pontos + $valorRecebido
						WHERE codigo = ".$ganhador['cod_jogador']."
					"); // ADICIONAR O SALDO PARA O JOGADOR.	
				}		
			}	
		}
        
        $apostadores = mysqli_query($conexao, "
            SELECT * FROM lobby_equipe_semente
            INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
            WHERE lobby_equipe.cod_lobby = $codLobby
            AND lobby_equipe_semente.palpite > 0
        ");
        
        while($apostador = mysqli_fetch_array($apostadores)){
            // GATILHOS DE GAMEFICAÇÃO
            include "gameficacao.php";
            concluirMissao($apostador['cod_jogador'], 5); // APOSTAR NO LOBBY
        }
		
	}

	function confirmarResultado($codEquipe, $codLobby){
		include "../conexao-banco.php";		
		$lobby = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM lobby WHERE codigo = $codLobby"));
		$resultado = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM lobby_resultado WHERE cod_equipe = $codEquipe"));
		mysqli_query($conexao, "
			UPDATE lobby_equipe
			SET posicao = ".$resultado['resultado']."
			WHERE codigo = ".$resultado['cod_equipe']."
		");
		mysqli_query($conexao, "
			UPDATE lobby_resultado
			SET confirmacao = 1
			WHERE cod_equipe = ".$resultado['cod_equipe']."
		");
		
		$membros = mysqli_query($conexao, "SELECT * FROM lobby_equipe_semente WHERE cod_equipe = ".$resultado['cod_equipe']."");
		if($resultado['resultado'] == 1){ // EQUIPE FOI VENCEDORA DO LOBBY					
			while($membro = mysqli_fetch_array($membros)){ // LANÇAR XP PARA USUARIOS (25xp) - VITÓRIA
				// GATILHOS DE GAMEFICAÇÃO
                include "gameficacao.php";
                concluirMissao($membro['cod_jogador'], 4); // FICAR EM PRIMEIRO NO LOBBY
                concluirMissao($membro['cod_jogador'], 8); // MINIMO EM TERCEIRO NO LOBBY
                if($membro['cod_jogador'] == $lobby['cod_jogador']){
                    concluirMissao($membro['cod_jogador'], 6); // CRIAR UM LOBBY E JOGA-LO 
                }
			}            
			distribuirPote($resultado['cod_equipe'], $lobby['codigo']);
		}else{  // EQUIPE NAO FOI VENCEDORA
            if($resultado['resultado'] <= 3){ // NO MÍNIMO EM TERCEIRO
                while($membro = mysqli_fetch_array($membros)){
                    // GATILHOS DE GAMEFICAÇÃO
                    include "gameficacao.php";
                    concluirMissao($membro['cod_jogador'], 8); // MINIMO EM TERCEIRO NO LOBBY
                    concluirMissao($membro['cod_jogador'], 7); // JOGAR QUALQUER LOBBY
                    if($membro['cod_jogador'] == $lobby['cod_jogador']){
                        concluirMissao($membro['cod_jogador'], 6); // CRIAR UM LOBBY E JOGA-LO 
                    }
                }
            }else{
                while($membro = mysqli_fetch_array($membros)){
                    // GATILHOS DE GAMEFICAÇÃO
                    include "gameficacao.php";
                    concluirMissao($membro['cod_jogador'], 7); // JOGAR QUALQUER LOBBY
                    if($membro['cod_jogador'] == $lobby['cod_jogador']){
                        concluirMissao($membro['cod_jogador'], 6); // CRIAR UM LOBBY E JOGA-LO 
                    }
                }
            }
			
		}
		require "../js/vendor/autoload.php";
		$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
		$pusher->trigger('lobby'.$codLobby, 'attEquipe', array('codequipe' => $resultado['cod_equipe']));
	}

	function checarResultados($codLobby){
		include "../conexao-banco.php";
		$lobby = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM lobby WHERE codigo = $codLobby"));
		$totalResultados = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM lobby_resultado
			INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_resultado.cod_equipe
			WHERE lobby_equipe.cod_lobby = $codLobby
		"));
		if($totalResultados >= $lobby['times']){ // TODAS AS EQUIPES ENVIARAM O RESULTADO			
			
			// APROVAR RESULTADOS
			
			$resultadosAprovados = mysqli_query($conexao, "SELECT * FROM lobby_resultado
				INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_resultado.cod_equipe
				WHERE lobby_equipe.cod_lobby = $codLobby AND lobby_resultado.confirmacao = 0
				GROUP BY lobby_resultado.resultado
			");
			while($resultado = mysqli_fetch_array($resultadosAprovados)){
				confirmarResultado($resultado['cod_equipe'], $lobby['codigo']);
			}
			
			// RESULTADOS DUPLICADOS
			
			$resultadosDuplicados = mysqli_query($conexao, "SELECT * FROM lobby_resultado
				INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_resultado.cod_equipe
				WHERE lobby_equipe.cod_lobby = $codLobby AND lobby_equipe.posicao = 0
			");				
			
			if(mysqli_num_rows($resultadosDuplicados) == 0){ // NÃO EXISTEM RESULTADOS DUPLICADOS			
				mysqli_query($conexao, "UPDATE lobby SET status = 2 WHERE codigo = $codLobby");
			}else{
				while($resultado = mysqli_fetch_array($resultadosDuplicados)){
					mysqli_query($conexao, "UPDATE lobby_resultado SET conflito = 1, confirmacao = 0 WHERE cod_equipe = ".$resultado['cod_equipe']."");
				}
			}
		}
	}

	function checarVotos($codEquipe, $codLobby){
		include "../conexao-banco.php";
		$lobby = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM lobby WHERE codigo = $codLobby"));
		$resultado = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM lobby_resultado WHERE cod_equipe = $codEquipe"));
		if($resultado['pros'] >= (($lobby['times'] * $lobby['jogador_por_time']) / 2) + 1){ // RESULTADO APROVADO POR 50% + 1 JOGADORES
			$resultadosIguais = mysqli_query($conexao, "
				SELECT * FROM lobby_resultado
				INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_resultado.cod_equipe
				WHERE lobby_resultado.resultado = ".$resultado['resultado']." AND lobby_equipe.cod_lobby = $codLobby AND lobby_resultado.cod_equipe != ".$resultado['cod_equipe']."
			");
			while($resultadoExcluir = mysqli_fetch_array($resultadosIguais)){
				mysqli_query($conexao, "DELETE FROM lobby_resultado_voto WHERE cod_equipe = ".$resultadoExcluir['cod_equipe']."");
				mysqli_query($conexao, "DELETE FROM lobby_resultado WHERE cod_equipe = ".$resultadoExcluir['cod_equipe']."");
			}
			
			confirmarResultado($resultado['cod_equipe'], $codLobby);
		}
	}

	switch($_POST['funcao']){
		case '1': // EXCLUIR LOBBY
			include "../conexao-banco.php";
			$codLobby = $_POST['codlobby'];
			
			$equipes = mysqli_query($conexao, "SELECT codigo FROM lobby_equipe WHERE cod_lobby = $codLobby");
			echo mysqli_num_rows($equipes);
			while($equipe = mysqli_fetch_array($equipes)){
				mysqli_query($conexao, "DELETE FROM lobby_resultado WHERE cod_equipe = ".$equipe['codigo']."");
				mysqli_query($conexao, "DELETE FROM lobby_equipe_semente WHERE cod_equipe = ".$equipe['codigo']."");
				mysqli_query($conexao, "DELETE FROM lobby_chat_equipe WHERE cod_equipe = ".$equipe['codigo']."");
				mysqli_query($conexao, "DELETE FROM lobby_equipe WHERE codigo = ".$equipe['codigo']."");				
				echo $equipe['codigo']."<br>";
			}
			mysqli_query($conexao, "DELETE FROM lobby_chat WHERE cod_lobby = ".$_POST['codlobby']." ");
			mysqli_query($conexao, "DELETE FROM lobby WHERE codigo = ".$_POST['codlobby']." ");
			
			require "../../js/vendor/autoload.php";
			$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
			$pusher->trigger('lobby'.$codLobby, 'sair', array('message' => 'hello world'));
			
			break;
		case '2': // OCUPAR VAGA ALEATORIA
			include "../conexao-banco.php";
			$codLobby = $_POST['codlobby'];
			$lobby = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM lobby WHERE codigo = $codLobby"));
			
			$pesquisaDestino = mysqli_query($conexao, "SELECT *, lobby_equipe_semente.codigo AS codSemente FROM lobby_equipe_semente
			INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
			WHERE lobby_equipe.cod_lobby = ".$codLobby." AND lobby_equipe_semente.cod_jogador is null
			ORDER BY rand() LIMIT 1");
			$sementeDestino = mysqli_fetch_array($pesquisaDestino);
			
			if(mysqli_num_rows($pesquisaDestino) == 0){
				
			}else{
				mysqli_query($conexao, "UPDATE lobby_equipe_semente SET cod_jogador = ".$_POST['jogador']." WHERE codigo = ".$sementeDestino['codSemente']." ");
			}
			
			require "../js/vendor/autoload.php";
			$qtdOcupadas = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM lobby_equipe_semente 
			INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
			WHERE lobby_equipe_semente.cod_jogador is not null AND lobby_equipe.cod_lobby = $codLobby"));
			$qtdMax = $lobby['times'] * $lobby['jogador_por_time'];
			
			$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
			$pusher->trigger('lobby'.$codLobby, 'attEquipe', array('codequipe' => $sementeDestino['cod_equipe']));
			if($qtdOcupadas == $qtdMax){
				$pusher->trigger('lobby'.$codLobby, 'atualizar', array('atual' => $qtdOcupadas, 'max' => $qtdMax));
			}else{
				$pusher->trigger('lobby'.$codLobby, 'attSlots', array('atual' => $qtdOcupadas, 'max' => $qtdMax));	
			}
			
			
			break;
		case '3': // OCUPAR VAGA ESPECIFICA
			include "../conexao-banco.php";
			require "../js/vendor/autoload.php";
			$codLobby = $_POST['codlobby'];
			$lobby = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM lobby WHERE codigo = $codLobby"));
			
			$vagaAtual = mysqli_query($conexao, "
				SELECT *, lobby_equipe_semente.codigo AS codSeed FROM lobby_equipe_semente
				INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
				WHERE lobby_equipe_semente.cod_jogador = ".$_POST['jogador']."
				AND lobby_equipe.cod_lobby = ".$_POST['codlobby']."
			");
			
			if($vaga = mysqli_fetch_array($vagaAtual)){
				mysqli_query($conexao, "
					UPDATE lobby_equipe_semente 
					SET cod_jogador = NULL, capitao = 0, status = 0, palpite = 0
					WHERE codigo = ".$vaga['codSeed']."
				");
				$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
				$pusher->trigger('lobby'.$codLobby, 'attEquipe', array('codequipe' => $vaga['cod_equipe']));
				$soma = mysqli_fetch_array(mysqli_query($conexao, "
					SELECT SUM(lobby_equipe_semente.palpite) AS soma FROM lobby_equipe_semente
					INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
					WHERE lobby_equipe.cod_lobby = $codLobby
				"));	
				$soma['soma'] = $soma['soma'] + $lobby['pote_inicial'];
				$pusher->trigger('lobby'.$_POST['codlobby'], 'attPote', array('valor' => $soma['soma']));
			}
			
			mysqli_query($conexao, "
				UPDATE lobby_equipe_semente SET cod_jogador = ".$_POST['jogador']."
				WHERE codigo = ".$_POST['semente']."
			");		
			
			$semente = mysqli_fetch_array(mysqli_query($conexao, "SELECT cod_equipe FROM lobby_equipe_semente WHERE codigo = ".$_POST['semente'].""));
			
			$qtdOcupadas = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM lobby_equipe_semente 
			INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
			WHERE lobby_equipe_semente.cod_jogador is not null AND lobby_equipe.cod_lobby = $codLobby"));
			$qtdMax = $lobby['times'] * $lobby['jogador_por_time'];
			
			$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
			$pusher->trigger('lobby'.$codLobby, 'attEquipe', array('codequipe' => $semente['cod_equipe']));
			if($qtdOcupadas == $qtdMax){
				$pusher->trigger('lobby'.$codLobby, 'atualizar', array('atual' => $qtdOcupadas, 'max' => $qtdMax));
			}else{
				$pusher->trigger('lobby'.$codLobby, 'attSlots', array('atual' => $qtdOcupadas, 'max' => $qtdMax));	
			}
			
			break;
		case '4': // SAIR DO SLOT
			include "../conexao-banco.php";
			require "../js/vendor/autoload.php";
			
			
			$codLobby = $_POST['codlobby'];
			$lobby = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM lobby WHERE codigo = $codLobby"));
			$semente = mysqli_fetch_array(mysqli_query($conexao, "SELECT cod_equipe FROM lobby_equipe_semente WHERE codigo = ".$_POST['semente'].""));
			
			mysqli_query($conexao, "UPDATE lobby_equipe_semente
			SET cod_jogador = NULL, capitao = 0, status = 0, palpite = 0
			WHERE codigo = ".$_POST['semente']."");	
			
			$qtdOcupadas = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM lobby_equipe_semente 
			INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
			WHERE lobby_equipe_semente.cod_jogador is not null AND lobby_equipe.cod_lobby = $codLobby"));
			$qtdMax = $lobby['times'] * $lobby['jogador_por_time'];
			
			$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
			
			$soma = mysqli_fetch_array(mysqli_query($conexao, "
				SELECT SUM(lobby_equipe_semente.palpite) AS soma FROM lobby_equipe_semente
				INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
				WHERE lobby_equipe.cod_lobby = $codLobby
			"));			
			$soma['soma'] = $soma['soma'] + $lobby['pote_inicial'];
			$pusher->trigger('lobby'.$_POST['codlobby'], 'attPote', array('valor' => $soma['soma']));
			$pusher->trigger('lobby'.$codLobby, 'attEquipe', array('codequipe' => $semente['cod_equipe']));
			$pusher->trigger('lobby'.$codLobby, 'attSlots', array('atual' => $qtdOcupadas, 'max' => $qtdMax));
			
			break;
		case '5': // CHECK-IN DO LOBBY
			include "../conexao-banco.php";
			$codLobby = $_POST['codlobby'];
			
			$vagaAtual = mysqli_query($conexao, "
				SELECT *, lobby_equipe_semente.codigo AS codSeed FROM lobby_equipe_semente
				INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
				WHERE lobby_equipe_semente.cod_jogador = ".$_POST['jogador']."
				AND lobby_equipe.cod_lobby = ".$_POST['codlobby']."
			");
			
			if($vaga = mysqli_fetch_array($vagaAtual)){
				mysqli_query($conexao, "
					UPDATE lobby_equipe_semente SET status = ".$_POST['status']."
					WHERE codigo = ".$vaga['codSeed']."
				");
			}
			
			verificarCheckins($codLobby);
			require "../js/vendor/autoload.php";
			$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
			$pusher->trigger('lobby'.$codLobby, 'attEquipe', array('codequipe' => $vaga['cod_equipe']));
			
			break;
		case '6': // VERIFICAR SENHA
			include "../conexao-banco.php";
			$lobby = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM lobby WHERE codigo = ".$_POST['codlobby']." "));
			if($lobby['senha'] != $_POST['senha']){
				echo "A senha informada nÃ£o confere com a senha do lobby!";
			}
			break;
		case '7': // ENVIAR PALPITE
			include "../conexao-banco.php";
			require "../js/vendor/autoload.php";
			
			$semente = mysqli_fetch_array(mysqli_query($conexao, "SELECT cod_equipe FROM lobby_equipe_semente WHERE codigo = ".$_POST['codsemente'].""));		
			mysqli_query($conexao, "UPDATE lobby_equipe_semente SET palpite = ".$_POST['valor']." WHERE codigo = ".$_POST['codsemente']."");
			
			
			$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
			
			$soma = mysqli_fetch_array(mysqli_query($conexao, "
				SELECT SUM(lobby_equipe_semente.palpite) AS soma FROM lobby_equipe_semente
				INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
				WHERE lobby_equipe.cod_lobby = ".$_POST['codlobby']."
			"));
			$soma['soma'] = $soma['soma'] + $lobby['pote_inicial'];
			$pusher->trigger('lobby'.$_POST['codlobby'], 'attPote', array('valor' => $soma['soma']));
			
			$pusher->trigger('lobby'.$_POST['codlobby'], 'attEquipe', array('codequipe' => $semente['cod_equipe']));
			
			break;
        case '8': // ENVIAR RESULTADO (APENAS CAPITÕES)			
            include "../session.php";
			$datahora = date("Y-m-d H:i:s");
            if(isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] == 0){
                $arquivo_tmp = $_FILES['screenshot']['tmp_name'];
                $nome = $_FILES['screenshot']['name'];
                // Pega a extensÃ£o
		        $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
		        // Converte a extensÃ£o para minÃºsculo
		        $extensao = strtolower ( $extensao );

		        if ( strstr ( '.jpg;.jpeg;.png', $extensao ) ) {
                    $novoNome = $_POST['codequipe'].".".$extensao;
			        // Concatena a pasta com o nome
			        $destino = "../../img/lobbys/".$_POST['codlobby']."/".$novoNome;
			        if(file_exists("../../img/lobbys/".$_POST['codlobby']."/")){
				        @move_uploaded_file ($arquivo_tmp, $destino);
                    }else{
				        mkdir("../../img/lobbys/".$_POST['codlobby']."/");
				        @move_uploaded_file($arquivo_tmp, $destino);
                    }
                }
	        }else{
				$extensao = NULL;
			}
			
			
			$verificacao = mysqli_query($conexao, "
				SELECT * FROM lobby_resultado
				INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_resultado.cod_equipe
				WHERE lobby_resultado.resultado = ".$_POST['colocacao']." AND lobby_resultado.confirmacao = 1 AND lobby_equipe.cod_lobby = ".$_POST['codlobby']."
			");
			
			if(mysqli_num_rows($verificacao) == 0){
				mysqli_query($conexao, "DELETE FROM lobby_resultado_voto WHERE cod_equipe = ".$_POST['codequipe']."");
				mysqli_query($conexao, "DELETE FROM lobby_resultado WHERE cod_equipe = ".$_POST['codequipe']."");
				mysqli_query($conexao, "INSERT INTO lobby_resultado VALUES (".$_POST['codequipe'].", '$extensao',".$_POST['colocacao'].", 0, 0, 0, 0)");
				checarResultados($_POST['codlobby']);
			}
			
			require "../js/vendor/autoload.php";
			$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
			$pusher->trigger('lobby'.$_POST['codlobby'], 'atualizar', array('message' => 'hello world'));
			
			header("Location: ../lobby/".$_POST['codlobby']."/");
            break;
		case '9': // CARREGAR TELA DE CONFLITOS
			include "../session.php";
			$resultados = mysqli_query($conexao, "SELECT * FROM lobby_resultado
				INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_resultado.cod_equipe
				WHERE lobby_equipe.cod_lobby = ".$_POST['codlobby']."
				AND lobby_resultado.conflito = 1
				AND lobby_resultado.confirmacao = 0
				ORDER BY lobby_resultado.resultado
			");
			?>
				<ul class="listaConflitos">
					<h3>Conflitos de Resultado</h3><br>
				<?php
					while($resultado = mysqli_fetch_array($resultados)){
					?>
						<li onClick="carregarConflito(<?php echo $resultado['cod_equipe'].",".$_POST['codlobby']; ?>);">
							<img src="../img/lobbys/<?php echo $_POST['codlobby']."/".$resultado['cod_equipe'].".".$resultado['extensao']; ?>" alt="">
							<?php echo $resultado['nome']; ?><br>
							<?php echo "Resultado: #".$resultado['resultado']; ?>
						</li>
					<?php
					}
				?>
				</ul>
				<div class="areaVotacao">					
				</div>
				<ul class="listaVotos">					
				</ul>
			<?php
			break;
		case '10': // ENVIAR VOTO
			include "../conexao-banco.php";
			$datahora = date("Y-m-d H:i:s");
			mysqli_query($conexao, "REPLACE INTO lobby_resultado_voto VALUES (".$_POST['codequipe'].", ".$_POST['jogador'].", ".$_POST['voto'].", '$datahora')");
			if($_POST['voto'] == 0){
				mysqli_query($conexao, "UPDATE lobby_resultado SET contra = contra + 1 WHERE cod_equipe = ".$_POST['codequipe']." ");	
			}else{
				mysqli_query($conexao, "UPDATE lobby_resultado SET pros = pros + 1 WHERE cod_equipe = ".$_POST['codequipe']." ");
			}			
			// CHAMAR FUNÇÃO PARA VERIFICAR VOTOS RESULTADO
			
			checarVotos($_POST['codequipe'], $_POST['codlobby']);
			
			require "../js/vendor/autoload.php";
			$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
			$pusher->trigger('lobby'.$_POST['codlobby'], 'atualizar', array('message' => 'hello world'));
			
			break;
		case '11': // CARREGAR TRANSPARENCIA DE VOTOS
			include "../conexao-banco.php";	
			$votos = mysqli_query($conexao, "SELECT * FROM lobby_resultado_voto
			INNER JOIN jogador ON jogador.codigo = lobby_resultado_voto.cod_jogador
			WHERE lobby_resultado_voto.cod_equipe = ".$_POST['codequipe']."
			ORDER BY datahora ASC");
			echo "<h3>Votos Computados</h3><br>";
			while($voto = mysqli_fetch_array($votos)){
			?>
				<li>
					<img src="../img/<?php echo $voto['foto_perfil']; ?>" alt="">
					<?php 
						echo $voto['nick'];
						if($voto['voto'] == 0){ // VOTO CONTRA
						?>
							<img src="../img/icones/deslike.png" alt="">
						<?php	
						}else{ // VOTO A FAVOR
						?>
							<img src="../img/icones/like.png" alt="">
						<?php	
						}
					?>
				</li>
			<?php	
			}
			break;
		case '12': // ENVIAR MENSAGEM CHAT DE EQUIPE
			include "../conexao-banco.php";			
			
			$jogador = $_POST['jogador'];
			$equipe = $_POST['codequipe'];
			$mensagem = $_POST['mensagem'];
			$datahora = date("Y-m-d H:i:s");
			
			mysqli_query($conexao, "INSERT INTO lobby_chat_equipe
			VALUES (NULL, $equipe, $jogador, '$mensagem', '$datahora')");
			
			require "../js/vendor/autoload.php";
			$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
			$pusher->trigger('chatequipe'.$equipe, 'atualizarChat', array('message' => 'hello world'));
			
			break;
		case '13': // CARREGAR MENSAGENS CHAT DE EQUIPE
			include "../conexao-banco.php";
			$equipe = $_POST['codequipe'];
			$jogador = $_POST['jogador'];
			
			$mensagens = mysqli_query($conexao, "SELECT * FROM lobby_chat_equipe
			INNER JOIN jogador ON jogador.codigo = lobby_chat_equipe.cod_jogador
			WHERE lobby_chat_equipe.cod_equipe = $equipe
			ORDER BY datahora ASC");
			
			while($msg = mysqli_fetch_array($mensagens)){
			?>
				<div class="msg <?php if($msg['cod_jogador'] == $jogador){ echo "destaque"; } ?>">
					<?php
						echo "<strong>".$msg['nick'].":</strong> ".htmlentities($msg['mensagem']);
					?>
				</div>
			<?php
			}			
			break;
		case '14': // ENVIAR MENSAGEM CHAT GERAL DO LOBBY
			include "../conexao-banco.php";
			$jogador = $_POST['jogador'];
			$lobby = $_POST['codlobby'];
			$mensagem = $_POST['mensagem'];
			$datahora = date("Y-m-d H:i:s");
			
			mysqli_query($conexao, "INSERT INTO lobby_chat
			VALUES (NULL, $lobby, $jogador, '$mensagem', '$datahora')");
			
			require "../js/vendor/autoload.php";
			$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
			$pusher->trigger('chatlobby'.$lobby, 'atualizarChat', array('message' => 'hello world'));
			
			break;
		case '15': // CARREGAR MENSAGENS CHAT GERAL DO LOBBY
			include "../conexao-banco.php";
			$lobby = $_POST['codlobby'];
			$jogador = $_POST['jogador'];
			
			
			$mensagens = mysqli_query($conexao, "SELECT * FROM lobby_chat
			INNER JOIN jogador ON jogador.codigo = lobby_chat.cod_jogador
			WHERE lobby_chat.cod_lobby = $lobby
			ORDER BY datahora ASC");
			
			if(mysqli_num_rows($mensagens) == 0){
			?>
				<div class="centralizar">
					<h3>CHAT GERAL DO LOBBY</h3>
					aqui irá aparecer todo o histórico de mensagens <br>
					trocadas entre todos os jogadores do lobby. <br><br>
					Para trocar informações entre os seus adversários (battle.tag, steam, riot) <br>
					ou passar informações do lobby (dentro do jogo), utilize esta aba.
				</div>
			<?php
			}else{
				while($msg = mysqli_fetch_array($mensagens)){
				?>
					<div class="msg <?php if($msg['cod_jogador'] == $jogador){ echo "destaque"; } ?>">
						<?php
							echo "<strong>".$msg['nick'].":</strong> ".htmlentities($msg['mensagem']);
						?>
					</div>
				<?php
				}	
			}
						
			break;
		case '16': // CARREGAR EQUIPE
			include "../session.php";
			$equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM lobby_equipe WHERE codigo = ".$_POST['codequipe']." "));
			$lobby = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM lobby WHERE codigo = ".$equipe['cod_lobby']." "));
			$seeds = mysqli_query($conexao, "SELECT * FROM lobby_equipe_semente WHERE cod_equipe = ".$equipe['codigo']." ORDER BY posicao");
			?>
				<h2>
				<?php
					echo $equipe['nome']; 
					if($equipe['posicao'] != 0){
						echo " - #".$equipe['posicao'];
					}
				?>
				</h2>	
				<ul class="membros <?php echo "membros".$equipe['codigo']; ?>">
				<?php
					while($semente = mysqli_fetch_array($seeds)){
						if($semente['cod_jogador'] != NULL){
							$jogador = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$semente['cod_jogador']." "));
						?>
							<li class="<?php if($semente['status'] == 1){ echo "ready"; }  ?>">
								<img class="fotoMembro" src="../img/<?php echo $jogador['foto_perfil']; ?>" alt="<?php echo $membro['nick']; ?>" title="<?php echo $jogador['nick']; ?>">
								<?php 
									echo $jogador['nick'];
									if(isset($usuario['codigo']) && ($semente['cod_jogador'] == $usuario['codigo'] || $usuario['codigo'] == $lobby['cod_jogador']) && $lobby['status'] == 0){ // JOGADOR LOGADO É O JOGADOR DO SLOT
										echo "<img src='../img/icones/recusar.png' class='sairSlot' onClick='sairSlot(".$semente['codigo'].",".$lobby['codigo'].");'>";
									}
								?>
								<div class="palpite">
									<img src="../img/icones/escoin.png" alt=""> <?php echo $semente['palpite']; ?>
								</div>
							</li>
						<?php	
						}elseif(isset($usuario['codigo'])){
						?>
							<li class="vaga" onClick='vagaEspecifica(<?php echo $usuario['codigo'].",".$lobby['codigo'].",".$semente['codigo']; ?>);'>
								<img class="fotoMembro" src="../img/usuarios/padrao.jpg" alt="<?php echo $membro['nick']; ?>" title="<?php echo $membro['nick']; ?>">
								OCUPAR VAGA
							</li>
						<?php	
						}						
					}
				?>
				</ul>
			<?php
			
			break;
		case '17': // CARREGAR CONFLITO
			include "../session.php";
			$resultado = mysqli_fetch_array(mysqli_query($conexao, "
				SELECT * FROM lobby_resultado
				WHERE cod_equipe = ".$_POST['codequipe']."
			"));
			?>
				<div class="printVotacao">
					<img src="../img/lobbys/<?php echo $_POST['codlobby']."/".$resultado['cod_equipe'].".".$resultado['extensao']; ?>" alt="">		
				</div>	
				<div class="colocacaoVotacao">
					COLOCAÇÃO <br> INFORMADA <br>
					<?php echo "#".$resultado['resultado']; ?>
				</div>
				<div class="votoVotacao">
					<h3>SEU VOTO</h3>
					<div class="voto" onClick="enviarVoto(<?php echo $usuario['codigo'].",".$resultado['cod_equipe'].",1,".$_POST['codlobby']; ?>);">
						<img src="../img/icones/like.png" alt="">
					</div>
					<div class="voto" onClick="enviarVoto(<?php echo $usuario['codigo'].",".$resultado['cod_equipe'].",0,".$_POST['codlobby']; ?>);">
						<img src="../img/icones/deslike.png" alt="">
					</div>
				</div>
				<div class="totalVotacao">
					<h3>SOMA DE VOTOS</h3>
					<img src="../img/icones/like.png" alt=""> 12
					<img src="../img/icones/deslike.png" alt=""> 5					
				</div>
			<?php
			break;
	}
?>
