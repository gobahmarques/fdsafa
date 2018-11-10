<?php
	include "../session.php";
	$lobbys = mysqli_query($conexao, "SELECT * FROM lobby WHERE cod_jogo = ".$_POST['codjogo']." AND status = 0 ORDER BY data");

    $codJogo = $_POST['codjogo'];
	$jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogos WHERE codigo = $codJogo"));

	if(mysqli_num_rows($lobbys) == 0){
	?>
		<br><h2>NENHUM LOBBY ENCONTRADO</h2>
		Infelizmente não encontramos nenhum lobby para este jogo. <br><br>
		
		Mas você mesmo pode criar o seu lobby e chamar seus amigos para jogar. <br>
		Só preencher o formulário ao lado, leva só alguns segundos. <br><br>
	<?php
	}else{
	?>
        <div class="row">
            <div class="col-12 col-md-12">
                <table cellspacing="0" cellpadding="0" id="tabelaLobbys" class="centralizar">
                    <thead>
                        <tr>
                            <td>NOME</td>
                            <td>SLOTS</td>
                            <td>CRIADO</td>
                            <td>RECOMPENSA</td>
                            <td>TIPO</td>
                            <td>PUB/PRIV</td>
                        </tr>
                    </thead>
                    <?php
                        while($lobby = mysqli_fetch_array($lobbys)){
                            $slots = $lobby['times'] * $lobby['jogador_por_time'];
                            $ocupados = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM lobby_equipe_semente 
                            INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
                            WHERE lobby_equipe.cod_lobby = ".$lobby['codigo']." AND lobby_equipe_semente.cod_jogador is not null"));

                            $soma = mysqli_fetch_array(mysqli_query($conexao, "
                                SELECT SUM(lobby_equipe_semente.palpite) AS soma FROM lobby_equipe_semente
                                INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
                                WHERE lobby_equipe.cod_lobby = ".$lobby['codigo']."
                            "));
                            $soma['soma'] = $soma['soma'] + $lobby['pote_inicial'];

                        ?>
                            <tr onClick="entrarLobby(<?php echo $lobby['privacidade'].",".$lobby['codigo']; ?>);">
                                <td><?php echo $lobby['nome']; ?></td>
                                <td><?php echo $ocupados." / ".$slots; ?></td>
                                <td><?php echo date("d/m - H:i", strtotime($lobby['data'])); ?></td>
                                <td>
                                    <img src="https://www.esportscups.com.br/img/icones/escoin.png" alt="eSCoin" title="eSCoin" class="coin">
                                    <?php echo $soma['soma']; ?>
                                </td>
                                <td>MD <?php echo $lobby['tipo']; ?></td>
                                <td>
                                <?php
                                    if($lobby['privacidade'] == 0){
                                    ?>
                                        <img src="https://www.esportscups.com.br/img/icones/cadeadoaberto.png" alt="Lobby Público" title="Lobby Público">
                                    <?php
                                    }else{
                                    ?>
                                        <img src="https://www.esportscups.com.br/img/icones/cadeadofechado.png" alt="Lobby Privado" title="Lobby Privado">
                                    <?php
                                    }
                                ?>
                                </td>
                            </tr>
                        <?php
                        }
                    ?>
                </table>
            </div>
        </div>
	<?php
	}	
?>