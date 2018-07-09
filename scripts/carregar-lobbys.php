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
            <div class="col-12 col-md-8">
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
            <div class="col-12 col-md-4">
                <div class="criarLobby form-control">
                <?php
                    if(isset($usuario['codigo'])){
                        ?>
                                <h2>
                                    <img src="https://www.esportscups.com.br/img/icones/+.png" alt="">
                                    CRIAR LOBBY
                                </h2>
                                <form action="scripts/criar-lobby.php" method="post" onSubmit="return validarLobby();">
                                    <div class="jogo">
                                    <?php
                                        switch($codJogo){
                                            case 369: // HEARTHSTONE
                                                echo "<img src='https://www.esportscups.com.br/img/icones/hs.png' alt='Hearthstone' title='Hearthstone'>";
                                                echo "Hearthstone";
                                                break;
                                            case 123: // GWENT
                                                echo "<img src='https://www.esportscups.com.br/img/icones/gwent.png' alt='GWENT' title='Hearthstone'>";
                                                echo "GWENT: The Witcher Card Game";
                                                break;
                                            case 147: // League of Legends
                                                echo "<img src='https://www.esportscups.com.br/img/icones/lol.png' alt='League of Legends' title='League of Legends'>";
                                                echo "League of Legends";
                                                break;
                                            case 357: // Dota 2
                                                echo "<img src='https://www.esportscups.com.br/img/icones/dota2.png' alt='Dota 2' title='Dota 2'>";
                                                echo "Dota 2";
                                                break;
                                            case 258: // Overwatch
                                                echo "<img src='https://www.esportscups.com.br/img/icones/overwatch.png' alt='Overwatch' title='Overwatch'>";
                                                echo "Overwatch";
                                                break;
                                            case 741: // PUBG
                                                echo "<img src='https://www.esportscups.com.br/img/icones/pubg.png' alt='PUBG' title='PUBG'>";
                                                echo "Playerunknow's: Battlegrounds";
                                                break;
                                            case 653: // CLASH ROYALE
                                                echo "<img src='https://www.esportscups.com.br/img/icones/clashroyale.png' alt='Clash Royale' title='Clash Royale'>";
                                                echo "Clash Royale";
                                                break;
                                        }
                                    ?>
                                    </div>
                                    <input type="hidden" name="codJogo" value="<?php echo $codJogo; ?>">
                                    <input type="text" placeholder="NOME DO LOBBY (Máximo: 32 caracteres)" name="nome" maxlength="32">
                                    <input type="number" placeholder="QTD. TIMES" name="qtdTimes" min="2" class="qtdTimes">
                                    <input type="number" placeholder="JOGADOR P/ TIME" name="jogadorPorTime" min="1">
                                    <select name="tipo" id="">
                                        <option value="1">MD 1</option>
                                    </select><br>
                                    <input type="password" placeholder="SENHA (Máximo: 8 caracteres)" name="senha" class="senha" maxlength="8" onKeyDown="verificarPrivacidade();">
                                    <input type="checkbox" value="1" name="privacidade" class="privacidade"> Lobby Privado? <br><br>
                                    <input type="submit" value="CRIAR LOBBY" class="btn btn-azul">
                                </form>
                        <?php
                    }else{
                        echo "Faça o login para poder participar dos lobbys!";
                    }
                ?>
                </div>
            </div>
        </div>
	<?php
	}	
?>