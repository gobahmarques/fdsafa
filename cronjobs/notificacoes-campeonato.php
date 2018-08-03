<?php
	include "../conexao-banco.php";

	// NOTIFICAÇÕES 3 DIAS //

	$data = date("Y-m-d", strtotime("+3days"));
	$campeonatos = mysqli_query($conexao, "SELECT * FROM campeonato WHERE inicio = '$data'");
	while($campeonato = mysqli_fetch_array($campeonatos)){
		$msg = "
			<a href='campeonato/".$campeonato['codigo']."/'>
				<li>
					Prepare-se para a batalha. Faltam apenas 3 dias para o torneio <strong>".$campeonato['nome']."</strong>.
				</li>
			</a>
		";
		$inscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 1");
		while($inscricao = mysqli_fetch_array($inscricoes)){
			if($inscricao['cod_equipe'] == NULL){
				mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$msg', ".$inscricao['cod_jogador'].", 0)");
			}else{
				$lineup = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_equipe = ".$inscricao['cod_equipe']."");
				while($membro = mysqli_fetch_array($lineup)){
					mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$msg', ".$membro['cod_jogador'].", 0)");	
				}
			}
		}
	}

	// NOTIFICAÇÕES 1 DIAS //

	$data = date("Y-m-d", strtotime("+1day"));
	$campeonatos = mysqli_query($conexao, "SELECT * FROM campeonato WHERE inicio = '$data'");
	while($campeonato = mysqli_fetch_array($campeonatos)){
		$msg = "
			<a href='campeonato/".$campeonato['codigo']."/'>
				<li>
					Prepare-se para a batalha. O torneio <strong>".$campeonato['nome']."</strong> ocorrerá amanhã, ".date("d/m/Y", strtotime($campeonato['inicio']))." às ".date("H:i", strtotime($campeonato['inicio'])).".
				</li>
			</a>
		";
		$inscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 1");
		while($inscricao = mysqli_fetch_array($inscricoes)){
			if($inscricao['cod_equipe'] == NULL){
				mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$msg', ".$inscricao['cod_jogador'].", 0)");
			}else{
				$lineup = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_equipe = ".$inscricao['cod_equipe']."");
				while($membro = mysqli_fetch_array($lineup)){
					mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$msg', ".$membro['cod_jogador'].", 0)");	
				}
			}
		}
	}

	// É HOJE //

	$data = date("Y-m-d");
	$campeonatos = mysqli_query($conexao, "SELECT * FROM campeonato WHERE inicio = '$data'");
	while($campeonato = mysqli_fetch_array($campeonatos)){
		$msg = "
			<a href='campeonato/".$campeonato['codigo']."/'>
				<li>
					O torneio <strong>".$campeonato['nome']."</strong> é hoje, nos vemos às ".date("H:i", strtotime($campeonato['inicio'])).".
				</li>
			</a>
		";
		$inscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 1");
		while($inscricao = mysqli_fetch_array($inscricoes)){
			if($inscricao['cod_equipe'] == NULL){
				mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$msg', ".$inscricao['cod_jogador'].", 0)");
			}else{
				$lineup = mysqli_query($conexao, "SELECT * FROM campeonato_lineup WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_equipe = ".$inscricao['cod_equipe']."");
				while($membro = mysqli_fetch_array($lineup)){
					mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$msg', ".$membro['cod_jogador'].", 0)");	
				}
			}
		}
	}
?>