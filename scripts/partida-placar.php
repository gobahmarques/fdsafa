<?php
   function verificarPlacar($codSemente, $codPartida){
      global $conexao;
      $pesquisaPlacar = mysqli_query($conexao, "SELECT * FROM campeonato_partida_resultado WHERE cod_partida = $codPartida && cod_semente = $codSemente");
      if(mysqli_num_rows($pesquisaPlacar) == 0){ // JOGADOR AINDA NÃO LANÇOU PLACAR
         return 0;
      }else{ // JOGADOR LANÇOU PLACAR FINAL
         $placar = mysqli_fetch_array($pesquisaPlacar);
         return $placar;
      }
   }

	if(isset($_POST['funcao'])){
		include "../conexao-banco.php";
		switch($_POST['funcao']){
			case "enviar":
				$partida = $_POST['partida'];
				$semente = $_POST['semente'];
				$placarUm = $_POST['placarUm'];
				$placarDois = $_POST['placarDois'];
				$datahora = date("Y-m-d H:i:s");
				mysqli_query($conexao, "INSERT INTO campeonato_partida_resultado VALUES ($partida, $semente, $placarUm, $placarDois, '$datahora')");
				
				$placarOponente = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato_partida_resultado WHERE cod_partida = $partida AND cod_semente != $semente"));
				
				if($placarOponente['placar_um'] == $placarUm && $placarOponente['placar_dois'] == $placarDois){		
					include "../ptbr/campeonatos/partidas/scripts.php";
					resultadoPartida($partida, $conexao);
				}
				
				require "../js/vendor/autoload.php";
				$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
				$pusher->trigger('partida'.$partida, 'atualizar');
				
				break;
			case "reenviar":
				$partida = $_POST['partida'];
				$semente = $_POST['semente'];
				mysqli_query($conexao, "DELETE FROM campeonato_partida_resultado WHERE cod_partida = $partida AND cod_semente = $semente");
				require "../js/vendor/autoload.php";
				$pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
				$pusher->trigger('partida'.$_POST['partida'], 'atualizar');
				break;
			case "wo":
				$datahora = date("Y-m-d H:i:s");
				$partida = $_POST['partida'];
				$tipoPartida = mysqli_fetch_array(mysqli_query($conexao, "SELECT tipo FROM campeonato_partida WHERE codigo = $partida"));
				$ptsWin = round($tipoPartida['tipo']/2);
				$ganhador = mysqli_fetch_array(mysqli_query($conexao, "SELECT cod_semente, lado FROM campeonato_partida_semente WHERE cod_partida = $partida AND cod_semente = ".$_POST['semente'].""));
				
				$perdedor = mysqli_fetch_array(mysqli_query($conexao, "SELECT cod_semente FROM campeonato_partida_semente WHERE cod_partida = $partida AND cod_semente != ".$ganhador['cod_semente'].""));
				
				// LANÇAR RESULTADO PARA OS DOIS JOGADORES
				
				if($ganhador['lado'] == 1){
					mysqli_query($conexao, "INSERT INTO campeonato_partida_resultado VALUES ($partida, ".$ganhador['cod_semente'].", $ptsWin, 0, '$datahora')");
					mysqli_query($conexao, "INSERT INTO campeonato_partida_resultado VALUES ($partida, ".$perdedor['cod_semente'].", $ptsWin, 0, '$datahora')");
				}else{
					mysqli_query($conexao, "INSERT INTO campeonato_partida_resultado VALUES ($partida, ".$ganhador['cod_semente'].", 0, $ptsWin, '$datahora')");
					mysqli_query($conexao, "INSERT INTO campeonato_partida_resultado VALUES ($partida, ".$perdedor['cod_semente'].", 0, $ptsWin, '$datahora')");
				}
				
				
				
				include "../ptbr/campeonatos/partidas/scripts.php";
				resultadoPartida($partida, $conexao);	
				// require "../js/vendor/autoload.php";
				// $pusher = new Pusher("40415e4e25c159832d51", "b9c2207863070b1055a0", "399063", array('cluster' => 'us2'));
				// $pusher->trigger('partida'.$_POST['partida'], 'atualizar');
				break;
		}
	}

?>