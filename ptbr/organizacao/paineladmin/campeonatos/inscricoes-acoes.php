<?php	
	include "../../../../session.php";
	include "../../../../enderecos.php";

	$organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$_GET['codigo'].""));
	$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_GET['torneio'].""));
	$datahora = date("Y-m-d H:i:s");
	$jogador = $_GET['jogador'];

	switch($_GET['funcao']){
        case 1: // APROVAR INSCRIÇÃO
            mysqli_query($conexao, "UPDATE campeonato_inscricao SET status = 1 WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = $jogador ");
            $notificacao = "<a href='campeonato/".$campeonato['codigo']."/inscricoes/'><li>
                Sua inscrição no torneio <strong>".$campeonato['nome']."</strong> foi aprovada. Nos vemos dia ".date("d/m/Y", strtotime($campeonato['inicio']))." às ".date("H:i", strtotime($campeonato['inicio']))."</li></a>
            ";
            break;
        case 2: // RECUSAR INSCRIÇÃO
            $inscricao = mysqli_fetch_array(mysqli_query($conexao, " SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = $jogador"));
            
            mysqli_query($conexao, "UPDATE campeonato_inscricao SET status = 2 WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = $jogador ");
            $notificacao = "
                <li>Sua inscrição no torneio <strong>".$campeonato['nome']."</strong> foi recusada. Se discorda dessa decisão, entre em contato com a organização através do e-mail: <strong>".$organizacao['email']."</strong></li>";
            
            if($inscricao['log_real'] != NULL){
                mysqli_query($conexao, "UPDATE jogador SET saldo = saldo + ".$campeonato['valor_real']." WHERE codigo = ".$jogador." ");
                mysqli_query($conexao, "INSERT INTO log_real VALUES (NULL, $jogador, ".$campeonato['valor_real'].", 'Devolução de inscrição campeonato: ".$campeonato['nome']."', 1, '$datahora')"); 
                
                mysqli_query($conexao, "UPDATE organizacao SET saldo_real = saldo_real - ".$campeonato['valor_real']." WHERE codigo = ".$campeonato['cod_organizacao']." ");
                mysqli_query($conexao, "INSERT INTO log_real_organizacao VALUES (NULL, ".$campeonato['cod_organizacao'].", $jogador, ".$campeonato['valor_real'].", 'Cancelamento de inscrição no torneio ".$nomeCamp['nome']."', 0, '".date("Y-m-d H:i:s")."')");
            }
            if($inscricao['log_coin'] != NULL){
                mysqli_query($conexao, "UPDATE jogador SET pontos = pontos + ".$campeonato['valor_escoin']." WHERE codigo = ".$jogador." ");
                mysqli_query($conexao, "INSERT INTO log_coin VALUES (NULL, $jogador, ".$campeonato['valor_escoin'].", 'Devolução de inscrição campeonato: <strong>".$campeonato['nome']."</strong>', 1, '$datahora')");
                
                mysqli_query($conexao, "UPDATE organizacao SET saldo_coin = saldo_coin - ".$campeonato['valor_escoin']." WHERE codigo = ".$campeonato['cod_organizacao']." ");
                mysqli_query($conexao, "INSERT INTO log_coin_organizacao VALUES (NULL, ".$campeonato['cod_organizacao'].", $jogador, ".$campeonato['valor_escoin'].", 'Cancelamento de inscrição no torneio ".$nomeCamp['nome']."', 0, '".date("Y-m-d H:i:s")."')");
            }
            break;
        case 3: // EXCLUIR INSCRIÇÃO
            $inscricao = mysqli_fetch_array(mysqli_query($conexao, " SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = $jogador"));
            
            if($inscricao['cod_equipe'] != NULL){
                mysqli_query($conexao, "DELETE FROM campeonato_lineup WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_equipe = ".$inscricao['cod_equipe']." ");
            }
            mysqli_query($conexao, "DELETE FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND cod_jogador = $jogador ");
    }
    mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$notificacao', NULL, $jogador, 0)");

	header("Location: ../../");