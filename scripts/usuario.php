<?php
    if(!function_exists("carregarNotificacoes")){
	   function carregarNotificacoes($codJogador){
            include "../conexao-banco.php";
            $notificacoes = mysqli_query($conexao, "SELECT * FROM notificacao WHERE cod_jogador = $codJogador AND status = 0");
            ?>
                <ul class="notificacoeslista">
                <?php
                    while($notificacao = mysqli_fetch_array($notificacoes)){
                        if($notificacao['link'] != "" && $notificacao['link'] != NULL){
                         ?>
                            <a href="ptbr/<?php echo $notificacao['link']; ?>" target="_blank">
                                <li onMouseOver="validarNotificacao(<?php echo $notificacao['codigo']; ?>);">
                                    <?php echo $notificacao['mensagem']; ?>
                                </li>
                            </a>
                        <?php   
                        }else{
                        ?>
                            <li onMouseOver="validarNotificacao(<?php echo $notificacao['codigo']; ?>);">
                                <?php echo $notificacao['mensagem']; ?>
                            </li>
                        <?php      
                        }

                    }
                ?>
                </ul>
            <?php

        }
    }

    if(!function_exists("validarNotificacao")){
	   function validarNotificacao($codigo){
		include "../conexao-banco.php";
		mysqli_query($conexao, "UPDATE notificacao SET status = 1 WHERE codigo = $codigo");
	}
    }

    if(!function_exists("creditarCoin")){
        function creditarCoin($codJogador, $quantidade, $motivo){
            global $conexao;

            mysqli_query($conexao, "
                INSERT INTO log_coin
                VALUES
                (NULL, $codJogador, $quantidade, '$motivo', 1, '".date("Y-m-d H:i:s")."')
            ");
            mysqli_query($conexao, "
                UPDATE jogador
                SET pontos = pontos + $quantidade
                WHERE codigo = $codJogador
            ");
        }
    }

    if(isset($_POST['funcao'])){
        switch($_POST['funcao']){
            case "notificacoes":
                carregarNotificacoes($_POST['codjogador']);
                break;
            case "validar":
                validarNotificacao($_POST['codnotificacao']);
                break;
            case "transacao":
                include "../session.php";
                $transacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador_pagamentos WHERE cod_jogador = ".$usuario['codigo']." ORDER BY datahora DESC LIMIT 1 "));
                mysqli_query($conexao, "UPDATE jogador_pagamentos SET cod_transacao = '".$_POST['transacao']."' WHERE codigo = ".$transacao['codigo']." ");			
                break;
            case "battlenet":
                include "../session.php";
                mysqli_query($conexao, "UPDATE jogador SET battletag = NULL WHERE codigo = ".$usuario['codigo']." ");
                break;
            case "steam":
                include "../session.php";
                mysqli_query($conexao, "UPDATE jogador SET steam = NULL WHERE codigo = ".$usuario['codigo']." ");
                break;
            case "atualizarPerfil":
                include "../session.php";
                mysqli_query($conexao, "UPDATE jogador SET nick = '".$_POST['nick']."' WHERE codigo = ".$usuario['codigo']." ");
                if(isset($_FILES['perfil']) && $_FILES['perfil']['error'] == 0){
                    $arquivo_tmp = $_FILES['perfil']['tmp_name'];
                    $nome = $_FILES['perfil']['name'];
                    // Pega a extensão
                    $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
                    // Converte a extensão para minúsculo
                    $extensao = strtolower ( $extensao );

                    if ( strstr ( '.jpg;.jpeg;.png', $extensao ) ) {
                        // Cria um nome único para esta imagem
                        // Evita que duplique as imagens no servidor.
                        // Evita nomes com acentos, espaços e caracteres não alfanuméricos
                        $novoNome = $usuario['codigo'].".".$extensao;
                        // Concatena a pasta com o nome
                        $destino = '../img/usuarios/'.$novoNome;
                        if(file_exists("../img/usuarios/")){
                            @move_uploaded_file ($arquivo_tmp, $destino);
                        }else{
                            mkdir("../img/usuarios/");
                            @move_uploaded_file($arquivo_tmp, $destino);
                        }
                        mysqli_query($conexao, "UPDATE jogador SET foto_perfil = 'usuarios/$novoNome' WHERE codigo = ".$usuario['codigo']." ");
                        echo "funcionando";
                    }
                }
                if(isset($_FILES['banner']) && $_FILES['banner']['error'] == 0){
                    $arquivo_tmp = $_FILES['banner']['tmp_name'];
                    $nome = $_FILES['banner']['name'];
                    // Pega a extensão
                    $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
                    // Converte a extensão para minúsculo
                    $extensao = strtolower ( $extensao );

                    if ( strstr ( '.jpg;.jpeg;.png', $extensao ) ) {
                        // Cria um nome único para esta imagem
                        // Evita que duplique as imagens no servidor.
                        // Evita nomes com acentos, espaços e caracteres não alfanuméricos
                        $novoNome = $usuario['codigo']."banner.".$extensao;
                        // Concatena a pasta com o nome
                        $destino = '../img/usuarios/'.$novoNome;
                        if(file_exists("../img/usuarios/")){
                            @move_uploaded_file ($arquivo_tmp, $destino);
                        }else{
                            mkdir("../img/usuarios/");
                            @move_uploaded_file($arquivo_tmp, $destino);
                        }
                        mysqli_query($conexao, "UPDATE jogador SET foto_banner = 'usuarios/$novoNome' WHERE codigo = ".$usuario['codigo']." ");
                    }
                }
                header("Location: ../ptbr/usuario/".$usuario['codigo']."/editar/");            
                break;
            case "alterarFoto":
                include "../session.php";
                ?>
                <h2>Enviar FOTO PERFIL de Usuário (500x500)</h2>
                <form action="scripts/usuario.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="funcao" value="enviarFoto">
                    <input type="hidden" name="jogador" value="<?php echo $usuario['codigo']; ?>"><br>
                    <input type="file" name="file"><br><br>
                    <input type="submit" value="Enviar" class="botaoPqLaranja">
                </form>
                <?php
                break;
            case "enviarFoto":
                include "../session.php";
                if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
                    $arquivo_tmp = $_FILES['file']['tmp_name'];
                    $nome = $_FILES['file']['name'];
                    // Pega a extensão
                    $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
                    // Converte a extensão para minúsculo
                    $extensao = strtolower ( $extensao );

                    if ( strstr ( '.jpg;.jpeg;.png', $extensao ) ) {
                        // Cria um nome único para esta imagem
                        // Evita que duplique as imagens no servidor.
                        // Evita nomes com acentos, espaços e caracteres não alfanuméricos
                        $novoNome = $usuario['codigo'].".".$extensao;
                        // Concatena a pasta com o nome
                        $destino = '../../img/usuarios/'.$novoNome;
                        if(file_exists("../../img/usuarios/")){
                            @move_uploaded_file ($arquivo_tmp, $destino);
                        }else{
                            mkdir("../../img/usuarios/");
                            @move_uploaded_file($arquivo_tmp, $destino);
                        }
                        mysqli_query($conexao, "UPDATE jogador SET foto_perfil = 'usuarios/$novoNome' WHERE codigo = ".$usuario['codigo']." ");
                    }
                }
                header("Location: ../usuario/".$usuario['codigo']."/");
                break;
            case "alterarBanner":
                include "../session.php";
                ?>
                <h2>Enviar FOTO PERFIL de Usuário (1024x250)</h2>
                <form action="scripts/usuario.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="funcao" value="enviarBanner">
                    <input type="hidden" name="jogador" value="<?php echo $usuario['codigo']; ?>"><br>
                    <input type="file" name="file"><br><br>
                    <input type="submit" value="Enviar" class="botaoPqLaranja">
                </form>
                <?php
                break;
            case "enviarBanner":
                include "../session.php";
                if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
                    $arquivo_tmp = $_FILES['file']['tmp_name'];
                    $nome = $_FILES['file']['name'];
                    // Pega a extensão
                    $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
                    // Converte a extensão para minúsculo
                    $extensao = strtolower ( $extensao );

                    if ( strstr ( '.jpg;.jpeg;.png', $extensao ) ) {
                        // Cria um nome único para esta imagem
                        // Evita que duplique as imagens no servidor.
                        // Evita nomes com acentos, espaços e caracteres não alfanuméricos
                        $novoNome = $usuario['codigo']."banner.".$extensao;
                        // Concatena a pasta com o nome
                        $destino = '../../img/usuarios/'.$novoNome;
                        if(file_exists("../../img/usuarios/")){
                            @move_uploaded_file ($arquivo_tmp, $destino);
                        }else{
                            mkdir("../../img/usuarios/");
                            @move_uploaded_file($arquivo_tmp, $destino);
                        }
                        mysqli_query($conexao, "UPDATE jogador SET foto_banner = 'usuarios/$novoNome' WHERE codigo = ".$usuario['codigo']." ");
                    }
                }
                header("Location: ../usuario/".$usuario['codigo']."/");
                break;
            case "aceitarAmizade":
                include "../session.php";
                mysqli_query($conexao, "UPDATE jogador_amizades SET status = 1 WHERE cod_jogador1 = ".$_POST['jogadorUm']." AND cod_jogador2 = ".$_POST['jogadorDois']." ");
                
                include "gameficacao.php";
                concluirMissao($_POST['jogadorUm'], 9);
                concluirMissao($_POST['jogadorDois'], 9);
                
                break;
            case "excluirAmizade":
                include "../session.php";
                mysqli_query($conexao, "DELETE FROM jogador_amizades WHERE cod_jogador1 = ".$_POST['jogadorUm']." AND cod_jogador2 = ".$_POST['jogadorDois']." ");
                break;
            case "pesquisarAmizade":
                include "../session.php";
                $pesquisa = $_POST['pesquisa'];

                $resultados = mysqli_query($conexao, "SELECT * FROM jogador WHERE nome LIKE '%$pesquisa%' OR nick LIKE '%$pesquisa%' OR email LIKE '%$pesquisa%' LIMIT 60");
                ?>
                    Você pesquisou <strong><em><?php echo $pesquisa; ?></em></strong> <br>
                    Está pesquisa retornou () resultados <br><br>
                    <input type="button" class="botaoPqLaranja" value="VOLTAR" onClick="window.location.reload();"><br><br>
                <?php
                if(mysqli_num_rows($resultados) > 0){ // MOSTRAR RESULTADOS
                    while($resultado = mysqli_fetch_array($resultados)){		
                    ?>	
                        <div class="col-12 col-md-3 float-left">
                            <div class="amigo bg-laranja">
                                <a href="usuario/<?php echo $resultado['codigo']; ?>/">
                                    <img src="http://www.esportscups.com.br/img/<?php echo $resultado['foto_perfil']; ?>" alt="">
                                </a>					
                                <?php echo "<strong>".$resultado['nome']." ".$resultado['sobrenome']."</strong>"; ?><br>
                                <?php echo $resultado['nick']; ?><br>
                                <div class="acoes">
                                <?php
                                    $pesquisaAmizade = mysqli_query($conexao, "SELECT * FROM jogador_amizades WHERE (cod_jogador1 = ".$usuario['codigo']." AND cod_jogador2 = ".$resultado['codigo'].") OR (cod_jogador1 = ".$resultado['codigo']." AND cod_jogador2 = ".$usuario['codigo'].")");
                                    if(mysqli_num_rows($pesquisaAmizade) > 0){ // JÁ SÃO AMIGOS
                                        $amizade = mysqli_fetch_array($pesquisaAmizade);
                                        if($amizade['status'] == 0){
                                            echo "Convite Pendente";
                                        }else{
                                            echo "Amigos";
                                        }
                                    }else{ // AINDA NÃO SÃO AMIGOS
                                    ?>
                                        <div class="acao" onClick="enviarPedido(<?php echo $usuario['codigo']; ?>,<?php echo $resultado['codigo']; ?>);">
                                            Enviar Pedido
                                        </div>
                                    <?php
                                    }
                                ?>
                                </div>
                            </div>
                        </div>
                    <?php	
                    }			
                }else{
                    echo ok;
                }		
                break;
            case "enviarPedido":
                include "../session.php";
                mysqli_query($conexao, "INSERT INTO jogador_amizades VALUES (".$_POST['jogadorUm'].", ".$_POST['jogadorDois'].", '".date("Y-m-d H:i:s")."', 0)");
                break;
            case "seguirOrganizacao":
                include "../conexao-banco.php";
                mysqli_query($conexao, "INSERT INTO organizacao_seguidor VALUES (".$_POST['organizacao'].", ".$_POST['jogador'].")");
                break;
            case "naoSeguirOrganizacao":
                include "../conexao-banco.php";
                mysqli_query($conexao, "DELETE FROM organizacao_seguidor WHERE cod_organizacao = ".$_POST['organizacao']." AND cod_jogador = ".$_POST['jogador']." ");
                break;
            case "cookieModal":
                $tempo = 7;
                setcookie("modalRifas", "Ok", time()+3600*24*$tempo, "/", "www.esportscups.com.br", 1);
                break;
            case "pesquisaHistoricoReal":
                include "../session.php";
                $inicio = $_POST['inicio'];
                $fim = $_POST['fim'];
                $tipo = $_POST['tipoTransacao'];

                if($tipo != ""){
                    if($inicio != ""){
                        if($fim != ""){ // POSSUI FILTRO DE COMEÇO E FIM
                            $transacoes = mysqli_query($conexao, "SELECT * FROM log_real WHERE datahora >= '$inicio' AND datahora <= '$fim' AND tipo = $tipo AND cod_jogador = ".$_POST['codjogador']."");
                        }else{ // POSSUI APENAS FILTRO DE COMEÇO
                            $transacoes = mysqli_query($conexao, "SELECT * FROM log_real WHERE datahora >= '$inicio' AND tipo = $tipo AND cod_jogador = ".$_POST['codjogador']."");   
                        }
                    }else{
                        if($fim != ""){ // POSSUI APENAS FILTRO DE FIM
                            $transacoes = mysqli_query($conexao, "SELECT * FROM log_real WHERE datahora <= '$fim' AND tipo = $tipo AND cod_jogador = ".$_POST['codjogador']."");    
                        }else{ // POSSUI APENAS TIPO DE TRANSACAO
                            $transacoes = mysqli_query($conexao, "SELECT * FROM log_real WHERE tipo = $tipo AND cod_jogador = ".$_POST['codjogador']."");
                        }
                    }    
                }else{
                    if($inicio != ""){
                        if($fim != ""){ // POSSUI FILTRO DE COMEÇO E FIM
                            $transacoes = mysqli_query($conexao, "SELECT * FROM log_real WHERE datahora >= '$inicio' AND datahora <= '$fim' AND cod_jogador = ".$_POST['codjogador']."");
                        }else{ // POSSUI APENAS FILTRO DE COMEÇO
                            $transacoes = mysqli_query($conexao, "SELECT * FROM log_real WHERE datahora >= '$inicio' AND cod_jogador = ".$_POST['codjogador']."");   
                        }
                    }else{
                        if($fim != ""){ // POSSUI APENAS FILTRO DE FIM
                            $transacoes = mysqli_query($conexao, "SELECT * FROM log_real WHERE datahora <= '$fim' AND cod_jogador = ".$_POST['codjogador']."");    
                        }
                    } 
                }

                ?>
                    <thead>
                        <tr>
                            <td>Cod.</td>
                            <td>Data</td>
                            <td>Descrição</td>
                            <td class="valor">Valor</td>
                        </tr>	
                    </thead>								
                    <?php
                        while($transacao = mysqli_fetch_array($transacoes)){
                        ?>
                            <tr>
                                <td><?php echo $transacao['codigo'];?></td>
                                <td><?php echo date("d/m/Y H:i",strtotime($transacao['datahora'])); ?></td>
                                <td><?php echo $transacao['descricao'];?></td>
                                <td>
                                <?php
                                    if($transacao['tipo'] == 0){
                                        echo "<div class='debito'>
                                            -
                                        ";
                                    }else{
                                        echo "<div class='credito'>
                                            +
                                        ";
                                    }

                                    echo "R$ ".number_format($transacao['valor'], 2, ',', '.');
                                ?>
                                </td>
                            </tr>
                        <?php
                        }        
                break;
            case "pesquisaHistoricoCoin":
                include "../session.php";
                $inicio = $_POST['inicio'];
                $fim = $_POST['fim'];
                $tipo = $_POST['tipoTransacao'];

                if($_POST['tipoTransacao'] != ""){
                    if($inicio != ""){
                        if($fim != ""){ // POSSUI FILTRO DE COMEÇO E FIM
                            $transacoes = mysqli_query($conexao, "SELECT * FROM log_coin WHERE datahora >= '$inicio' AND datahora <= '$fim' AND tipo = $tipo AND cod_jogador = ".$_POST['codjogador']."");
                        }else{ // POSSUI APENAS FILTRO DE COMEÇO
                            $transacoes = mysqli_query($conexao, "SELECT * FROM log_coin WHERE datahora >= '$inicio' AND tipo = $tipo AND cod_jogador = ".$_POST['codjogador']."");   
                        }
                    }else{
                        if($fim != ""){ // POSSUI APENAS FILTRO DE FIM
                            $transacoes = mysqli_query($conexao, "SELECT * FROM log_coin WHERE datahora <= '$fim' AND tipo = $tipo AND cod_jogador = ".$_POST['codjogador']."");    
                        }else{ // POSSUI APENAS TIPO DE TRANSACAO
                            $transacoes = mysqli_query($conexao, "SELECT * FROM log_coin WHERE tipo = $tipo AND cod_jogador = ".$_POST['codjogador']."");
                        }
                    }    
                }else{
                    if($inicio != ""){
                        if($fim != ""){ // POSSUI FILTRO DE COMEÇO E FIM
                            $transacoes = mysqli_query($conexao, "SELECT * FROM log_coin WHERE datahora >= '$inicio' AND datahora <= '$fim' AND cod_jogador = ".$_POST['codjogador']."");
                        }else{ // POSSUI APENAS FILTRO DE COMEÇO
                            $transacoes = mysqli_query($conexao, "SELECT * FROM log_coin WHERE datahora >= '$inicio' AND cod_jogador = ".$_POST['codjogador']."");   
                        }
                    }else{
                        if($fim != ""){ // POSSUI APENAS FILTRO DE FIM
                            $transacoes = mysqli_query($conexao, "SELECT * FROM log_coin WHERE datahora <= '$fim' AND cod_jogador = ".$_POST['codjogador']."");    
                        }
                    } 
                }

                ?>
                    <thead>
                        <tr>
                            <td>Cod.</td>
                            <td>Data</td>
                            <td>Descrição</td>
                            <td class="valor">Valor</td>
                        </tr>	
                    </thead>								
                    <?php
                        while($transacao = mysqli_fetch_array($transacoes)){
                        ?>
                            <tr>
                                <td><?php echo $transacao['codigo'];?></td>
                                <td><?php echo date("d/m/Y H:i",strtotime($transacao['datahora'])); ?></td>
                                <td><?php echo $transacao['descricao'];?></td>
                                <td>
                                <?php
                                    if($transacao['tipo'] == 0){
                                        echo "<div class='debito'>
                                            -
                                        ";
                                    }else{
                                        echo "<div class='credito'>
                                            +
                                        ";
                                    }

                                    echo number_format($transacao['valor'], '0', '', '.');
                                    echo "<img class='coin' src='../img/icones/escoin.png' alt='eSCoins' title='eSCoins'>";
                                ?>
                                </td>
                            </tr>
                        <?php
                        }    
                break;
        }
    }
?>