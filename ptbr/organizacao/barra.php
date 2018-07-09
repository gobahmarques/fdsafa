<div class="barraOrganizacao bg-dark">
    <h3>Integrantes</h3>
    <div class="row">

        <div class="col">
        <?php
            $integrantes = mysqli_query($conexao, "SELECT *, jogador_organizacao.status AS statusIntegrante FROM jogador_organizacao 
                                    INNER JOIN jogador ON jogador.codigo = jogador_organizacao.cod_jogador
                                    WHERE jogador_organizacao.cod_organizacao = ".$organizacao['codigo']."
                                    ORDER BY jogador_organizacao.status DESC");
            while($integrante = mysqli_fetch_array($integrantes)){
            ?>
                <div class="integrante">
                    <img src="http://www.esportscups.com.br/img/<?php echo $integrante['foto_perfil']; ?>" title="<?php echo $integrante['nick']; ?>" alt="<?php echo $integrante['nick']; ?>">
                    <?php 
                        echo $integrante['nome']." '".$integrante['nick']."' ".$integrante['sobrenome']."<br>"; 
                        switch($integrante['statusIntegrante']){
                            case "1": // GESTORES DE SUPORTE
                                echo "<strong>Gestor de Suporte</strong>";
                                break;
                            case "2": // MODERADOR
                                echo "<strong>Moderador</strong>";
                                break;
                            case "3": // ADMINISTRADOR
                                echo "<strong>Administrador</strong>";
                                break;
                            case "9": // CRIADOR
                                echo "<strong>Proprietário</strong>";
                                break;
                            default:
                                echo "<strong>TBD</strong>";
                                break;
                        }
                    ?><br>
                </div>
            <?php
            }
            if(isset($funcao) && $funcao['status'] >= 3){
            ?>
                <input type="button" value="Adicionar Integrante" class="btn btn-laranja">
            <?php
            }
        ?>
        </div>                            
    </div>
    <br>
    <h3>Links</h3>
    <div class="row">
        <div class="col linksOrganizacao">
        <?php
            if($organizacao['site'] != ""){
            ?>
                <a href="<?php echo $organizacao['site']; ?>" target="_blank"><img src="http://www.esportscups.com.br/img/logos/site.png" title="WebSite" alt="WebSite"></a>
            <?php
            }
            if($organizacao['facebook'] != ""){
            ?>
                <a href="<?php echo $organizacao['facebook']; ?>" target="_blank"><img src="http://www.esportscups.com.br/img/logos/facebook.png" title="Facebook" alt="Facebook"></a>
            <?php
            }
            if($organizacao['discord'] != ""){
            ?>
                <a href="<?php echo $organizacao['discord']; ?>" target="_blank"><img src="http://www.esportscups.com.br/img/logos/discord.png" title="Discord" alt="Discord"></a>
            <?php
            }
            if($organizacao['twitter'] != ""){
            ?>
                <a href="<?php echo $organizacao['twitter']; ?>" target="_blank"><img src="http://www.esportscups.com.br/img/logos/twitter.png" title="Twitter" alt="Twitter"></a>
            <?php
            }
            if($organizacao['twitch'] != ""){
            ?>
                <a href="<?php echo $organizacao['twitch']; ?>" target="_blank"><img src="http://www.esportscups.com.br/img/logos/twitch.png" title="Twitch" alt="Twitch"></a>
            <?php
            }
            if($organizacao['azubu'] != ""){
            ?>
                <a href="<?php echo $organizacao['azubu']; ?>" target="_blank"><img src="http://www.esportscups.com.br/img/logos/azubu.png" title="Azubu" alt="Azubu"></a>
            <?php
            }
            if($organizacao['youtube'] != ""){
            ?>
                <a href="<?php echo $organizacao['youtube']; ?>" target="_blank"><img src="http://www.esportscups.com.br/img/logos/youtube.png" title="YouTube" alt="YouTube"></a>
            <?php
            }
        ?>
        </div>
    </div>                        
</div>