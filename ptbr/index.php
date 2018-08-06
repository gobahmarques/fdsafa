<?php
    include "../enderecos.php";
    include "../session.php";
?>
<!doctype html>
<html>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.css">
    <link rel="stylesheet" href="<?php echo $css; ?>esportscups.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">
    <link href="<?php echo $css; ?>simple-sidebar.css" rel="stylesheet">

    <title>Sua plataforma de eSports | e-Sports Cups</title>
  </head>
  <body>
    <?php 
        include "header.php";
        $torneiosDestaque = mysqli_query($conexao, "
            SELECT * FROM campeonato
            WHERE destaque >= 2
            AND inicio > '".date("Y-m-d H:i:s")."'
            ORDER BY inicio ASC
        ");
    ?>
    <div id="page-content-wrapper">
    <div class="container">
            <br>
            <div class="row">                
                <div class="col-12 col-md-12 text-center">
                    <h3>Sua plataforma de eSports para alcançar o próximo nível</h3>
                    Jogue e organize competições de Dota 2, Hearthstone, GWENT, League of Legends e Overwatch, abra caixas, junte eSCoins (e$) e muito mais...
                </div>               
            </div>
            <br>
            <div class="row barraJogosIndex">
                <div class="col-xs-12-fluid col-md-12">
                    <h2 class="tituloIndex">Jogos <strong>Disponíveis</strong></h2>
                    <div class="detalheTituloIndex"></div>                    
                </div>
                <div class="col-4 col-md-2 jogo">
                    <a href="ptbr/jogar/campeonatos/dota2/"><img src="<?php echo $img; ?>index/dota2.png"></a>
                </div>
                <div class="col-4 col-md-2 jogo">
                    <a href="ptbr/jogar/campeonatos/gwent/"><img src="<?php echo $img; ?>index/gwent.png" style="width: 100%;"></a>
                </div>
                <div class="col-4 col-md-2 jogo">
                    <a href="ptbr/jogar/campeonatos/hearthstone/"><img src="<?php echo $img; ?>index/hearthstone.png" style="width: 100%;"></a>
                </div>
                <div class="col-4 col-md-2 jogo">
                    <a href="ptbr/jogar/campeonatos/lol/"><img src="<?php echo $img; ?>index/lol.png" style="width: 100%;"></a>
                </div>
                <div class="col-4 col-md-2 jogo">
                    <a href="ptbr/jogar/campeonatos/overwatch/"><img src="<?php echo $img; ?>index/overwatch.png" style="width: 100%;"></a>
                </div>
                <div class="col-4 col-md-2">
                    <img src="<?php echo $img; ?>index/clashroyale2.png" style="width: 100%;">
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8 d-none d-md-block">
                    <h2 class="tituloIndex">Últimos <strong>Artigos</strong></h2>
                    <div class="detalheTituloIndex"></div>
                    <div class="row">
                                <div id="carousel">	
                                    <?php
                                        $artigos = mysqli_query($conexao, "SELECT * FROM artigos WHERE autor is not null ORDER BY data DESC LIMIT 6");
                                    ?>
                                    <div class="grupoArtigos">
                                        <?php
                                            $artigo = mysqli_fetch_array($artigos);
                                            $visualizacoes = mysqli_num_rows(mysqli_query($conexao, "SELECT codigo FROM visitas WHERE pagina = 'ptbr/artigo/".$artigo['codigo']."/'"));
                                            $autor = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome, nick, sobrenome FROM jogador WHERE codigo = ".$artigo['autor'].""));								
                                        ?>
                                        <a href="ptbr/artigo/<?php echo $artigo['codigo']; ?>/">
                                            <div class="slide slide1">
                                                <img src="img/artigos/<?php echo $artigo['thumb']; ?>" alt="" id="thumb1">
                                                <div class="textoPrincipal">
                                                    <span class="label label-primary">
                                                    <?php 
                                                        if($artigo['cod_jogo'] != NULL){
                                                            $jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome FROM jogos WHERE codigo = ".$artigo['cod_jogo'].""));
                                                            echo $jogo['nome']; 
                                                        }else{
                                                            echo "e-Sports Cups";
                                                        }											
                                                    ?>
                                                    </span>
                                                    <h2><?php echo $artigo['nome']; ?></h2>
                                                    <span class="glyphicon glyphicon-time"></span> <?php echo date("d/m/Y", strtotime($artigo['data'])); ?> 
                                                    <span class="glyphicon glyphicon-eye-open"></span> <?php echo $visualizacoes; ?><br>
                                                    <span class="glyphicon glyphicon-user"></span><?php echo $autor['nome']." ".$autor['sobrenome']; ?>
                                                </div>
                                            </div>
                                        </a>							
                                        <?php
                                            $artigo = mysqli_fetch_array($artigos);
                                            $visualizacoes = mysqli_num_rows(mysqli_query($conexao, "SELECT codigo FROM visitas WHERE pagina = 'ptbr/artigo/".$artigo['codigo']."/'"));
                                            $autor = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome, nick, sobrenome FROM jogador WHERE codigo = ".$artigo['autor'].""));
                                        ?>
                                        <a href="ptbr/artigo/<?php echo $artigo['codigo']; ?>/">
                                            <div class="slide slide2">
                                                <img src="img/artigos/<?php echo $artigo['thumb']; ?>" alt="" id="thumb1">
                                                <div class="textoSecundario">
                                                    <span class="label label-primary">
                                                    <?php 
                                                        if($artigo['cod_jogo'] != NULL){
                                                            $jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome FROM jogos WHERE codigo = ".$artigo['cod_jogo'].""));
                                                            echo $jogo['nome']; 
                                                        }else{
                                                            echo "e-Sports Cups";
                                                        }											
                                                    ?>
                                                    </span>
                                                    <h2><?php echo $artigo['nome']; ?></h2>
                                                    <span class="glyphicon glyphicon-time"></span> <?php echo date("d/m/Y", strtotime($artigo['data'])); ?> 
                                                    <span class="glyphicon glyphicon-eye-open"></span> <?php echo $visualizacoes; ?><br>
                                                    <span class="glyphicon glyphicon-user"></span><?php echo $autor['nome']." ".$autor['sobrenome']; ?>
                                                </div>
                                            </div>
                                        </a>
                                        <?php
                                            $artigo = mysqli_fetch_array($artigos);
                                            $visualizacoes = mysqli_num_rows(mysqli_query($conexao, "SELECT codigo FROM visitas WHERE pagina = 'ptbr/artigo/".$artigo['codigo']."/'"));
                                            $autor = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome, nick, sobrenome FROM jogador WHERE codigo = ".$artigo['autor'].""));
                                        ?>
                                        <a href="ptbe/artigo/<?php echo $artigo['codigo']; ?>/">	
                                            <div class="slide slide3">
                                                <img src="img/artigos/<?php echo $artigo['thumb']; ?>" alt="" id="thumb1">
                                                <div class="textoSecundario">
                                                    <span class="label label-primary">
                                                    <?php 
                                                        if($artigo['cod_jogo'] != NULL){
                                                            $jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome FROM jogos WHERE codigo = ".$artigo['cod_jogo'].""));
                                                            echo $jogo['nome']; 
                                                        }else{
                                                            echo "e-Sports Cups";
                                                        }											
                                                    ?>
                                                    </span>
                                                    <h2><?php echo $artigo['nome']; ?></h2>
                                                    <span class="glyphicon glyphicon-time"></span> <?php echo date("d/m/Y", strtotime($artigo['data'])); ?> 
                                                    <span class="glyphicon glyphicon-eye-open"></span> <?php echo $visualizacoes; ?><br>
                                                    <span class="glyphicon glyphicon-user"></span><?php echo $autor['nome']." ".$autor['sobrenome']; ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="grupoArtigos">
                                        <?php
                                            $artigo = mysqli_fetch_array($artigos);
                                            $visualizacoes = mysqli_num_rows(mysqli_query($conexao, "SELECT codigo FROM visitas WHERE pagina = 'ptbr/artigo/".$artigo['codigo']."/'"));
                                            $autor = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome, nick, sobrenome FROM jogador WHERE codigo = ".$artigo['autor'].""));
                                        ?>
                                        <a href="ptbr/artigo/<?php echo $artigo['codigo']; ?>/">
                                            <div class="slide slide1">
                                                <img src="img/artigos/<?php echo $artigo['thumb']; ?>" alt="" id="thumb1">
                                                <div class="textoPrincipal">
                                                    <span class="label label-primary">
                                                    <?php 
                                                        if($artigo['cod_jogo'] != NULL){
                                                            $jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome FROM jogos WHERE codigo = ".$artigo['cod_jogo'].""));
                                                            echo $jogo['nome']; 
                                                        }else{
                                                            echo "e-Sports Cups";
                                                        }											
                                                    ?>
                                                    </span>
                                                    <h2><?php echo $artigo['nome']; ?></h2>
                                                    <span class="glyphicon glyphicon-time"></span> <?php echo date("d/m/Y", strtotime($artigo['data'])); ?> 
                                                    <span class="glyphicon glyphicon-eye-open"></span> <?php echo $visualizacoes; ?><br>
                                                    <span class="glyphicon glyphicon-user"></span><?php echo $autor['nome']." ".$autor['sobrenome']; ?>
                                                </div>
                                            </div>
                                        </a>
                                        <?php
                                            $artigo = mysqli_fetch_array($artigos);
                                            $visualizacoes = mysqli_num_rows(mysqli_query($conexao, "SELECT codigo FROM visitas WHERE pagina = 'ptbr/artigo/".$artigo['codigo']."/'"));
                                            $autor = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome, nick, sobrenome FROM jogador WHERE codigo = ".$artigo['autor'].""));
                                        ?>
                                        <a href="ptbr/artigo/<?php echo $artigo['codigo']; ?>/">
                                            <div class="slide slide2">
                                                <img src="img/artigos/<?php echo $artigo['thumb']; ?>" alt="" id="thumb1">
                                                <div class="textoSecundario">
                                                    <span class="label label-primary">
                                                    <?php 
                                                        if($artigo['cod_jogo'] != NULL){
                                                            $jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome FROM jogos WHERE codigo = ".$artigo['cod_jogo'].""));
                                                            echo $jogo['nome']; 
                                                        }else{
                                                            echo "e-Sports Cups";
                                                        }											
                                                    ?>
                                                    </span>
                                                    <h2><?php echo $artigo['nome']; ?></h2>
                                                    <span class="glyphicon glyphicon-time"></span> <?php echo date("d/m/Y", strtotime($artigo['data'])); ?> 
                                                    <span class="glyphicon glyphicon-eye-open"></span> <?php echo $visualizacoes; ?><br>
                                                    <span class="glyphicon glyphicon-user"></span><?php echo $autor['nome']." ".$autor['sobrenome']; ?>
                                                </div>
                                            </div>
                                        </a>
                                        <?php
                                            $artigo = mysqli_fetch_array($artigos);
                                            $visualizacoes = mysqli_num_rows(mysqli_query($conexao, "SELECT codigo FROM visitas WHERE pagina = 'ptbr/artigo/".$artigo['codigo']."/'"));
                                            $autor = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome, nick, sobrenome FROM jogador WHERE codigo = ".$artigo['autor'].""));
                                        ?>
                                        <a href="ptbr/artigo/<?php echo $artigo['codigo']; ?>/">
                                            <div class="slide slide3">
                                                <img src="img/artigos/<?php echo $artigo['thumb']; ?>" alt="" id="thumb1">
                                                <div class="textoSecundario">
                                                    <span class="label label-primary">
                                                    <?php 
                                                        if($artigo['cod_jogo'] != NULL){
                                                            $jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome FROM jogos WHERE codigo = ".$artigo['cod_jogo'].""));
                                                            echo $jogo['nome']; 
                                                        }else{
                                                            echo "e-Sports Cups";
                                                        }											
                                                    ?>
                                                    </span>
                                                    <h2><?php echo $artigo['nome']; ?></h2>
                                                    <span class="glyphicon glyphicon-time"></span> <?php echo date("d/m/Y", strtotime($artigo['data'])); ?> 
                                                    <span class="glyphicon glyphicon-eye-open"></span> <?php echo $visualizacoes; ?><br>
                                                    <span class="glyphicon glyphicon-user"></span><?php echo $autor['nome']." ".$autor['sobrenome']; ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 listaTorneios">
                    <h2 class="tituloIndex">Torneios <strong>eSC</strong></h2>
                    <div class="detalheTituloIndex"></div>
                    <?php
                        $torneiosesc = mysqli_query($conexao, "SELECT * FROM campeonato WHERE inicio > '".date("Y-m-d H:i:s")."' AND status = 0 AND cod_organizacao = 11 ORDER BY inicio LIMIT 4");
                        while($torneio = mysqli_fetch_array($torneiosesc)){
                            if($torneio['valor_escoin'])
                    ?>
                            <a href="ptbr/campeonato/<?php echo $torneio['codigo']; ?>/">
                                <div class="row campeonato text-dark">
                                    <div class="col-3 col-md-3">
                                        <img src="<?php echo $img.$torneio['thumb']; ?>" style="width:100%;" >
                                    </div>
                                    <div class="col-7 col-md-7">
                                        <h5><?php echo $torneio['nome']; ?></h5>
                                        <strong>Inscrição:</strong>
                                        <?php
											if($torneio['valor_escoin'] > 0){
												echo "e$ ".number_format($torneio['valor_escoin'], 0, '.', '');
											}elseif($torneio['valor_real'] > 0){
												echo "R$ ".number_format($torneio['valor_real'], 2, '.', ',');
											}else{
												echo "Gratuita";
											}
										?><br>                                        
                                        Data & Hora: <?php echo date("d/m - H:i", strtotime($torneio['inicio'])); ?>
                                    </div>
                                    <div class="col-2 col-md-2">
                                        Logo
                                    </div>
                                </div>
                            </a>                            
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <h2 class="tituloIndex">Level <strong>Rank</strong></h2>
                    <div class="detalheTituloIndex"></div>
                    <?php
                        $leveis = mysqli_query($conexao, "
                            SELECT *, gm_jogador_level.cod_jogo AS codigojogo FROM gm_jogador_level
                            INNER JOIN jogador ON jogador.codigo = gm_jogador_level.cod_jogador
                            INNER JOIN jogos ON jogos.codigo = gm_jogador_level.cod_jogo
                            WHERE gm_jogador_level.cod_jogo is not null
                            ORDER BY level DESC
                            LIMIT 10
                        ");						
                        $aux = 1;
                        while($posicao = mysqli_fetch_array($leveis)){
                    ?>
                            <div class="row posicaoRank">
                                <div class="col-1 col-md-1">
                                    <strong>#<?php echo $aux; ?></strong>
                                </div>
                                <div class="col-2 col-md-2">
                                    <img src="<?php echo "img/".$posicao['foto_perfil']; ?>" width="100%" >
                                </div>
                                <div class="col-6 col-md-5">
                                    <?php echo $posicao['nick']; ?>
                                </div>
                                <div class="col-3 col-md-3">
                                    Lvl. <?php echo $posicao['level']; ?>
                                </div> 
                            </div>                                               
                    <?php
                            $aux++;
                        }
                    ?>
                </div>
                <div class="col-12 col-md-4">
                    <h2 class="tituloIndex">Liga eSCoin <strong>Hearthstone</strong></h2>
                    <div class="detalheTituloIndex"></div>
                    <a href="ptbr/escoinleaguehs/"><img src="<?php echo $img; ?>index/anuncio-escoin-league-hs.png" width="100%" ></a>
                </div>
                <div class="col-12 col-md-4 listaLobbys">
                    <h2 class="tituloIndex">Salas <strong>Públicas</strong></h2>
                    <div class="detalheTituloIndex"></div>
                    <?php
                        $lobbys = mysqli_query($conexao, "SELECT * FROM lobby WHERE privacidade = 0 AND status = 0 GROUP BY cod_jogo ORDER BY data ASC LIMIT 6");
                        while($lobby = mysqli_fetch_array($lobbys)){
                            $soma = mysqli_fetch_array(mysqli_query($conexao, "
                                SELECT SUM(lobby_equipe_semente.palpite) AS soma FROM lobby_equipe_semente
                                INNER JOIN lobby_equipe ON lobby_equipe.codigo = lobby_equipe_semente.cod_equipe
                                WHERE lobby_equipe.cod_lobby = ".$lobby['codigo']."
                            "));
                            $soma['soma'] = $soma['soma'] + $lobby['pote_inicial'];
                            ?>
                                <a href="ptbr/lobby/<?php echo $lobby['codigo']; ?>/">
                                    <div class="row lobby text-dark">
                                        <div class="col-2 col-md-2">
                                        <?php
                                            switch($lobby['cod_jogo']){
                                                case 369: // HEARTHSTONE
                                                    echo "<img src='http://www.esportscups.com.br/img/icones/hs.png' alt='Hearthstone' title='Hearthstone' width='100%'>";
                                                    break;
                                                case 123:
                                                    echo "<img src='http://www.esportscups.com.br/img/icones/gwent.png' alt='GWENT' title='GWENT' width='100%'>";
                                                    break;
                                                case 147: // League of Legends
                                                    echo "<img src='http://www.esportscups.com.br/img/icones/lol.png' alt='League of Legends' title='League of Legends' width='100%'>";
                                                    break;
                                                case 357: // Dota 2
                                                    echo "<img src='http://www.esportscups.com.br/img/icones/dota2.png' alt='Dota 2' title='Dota 2' width='100%'>";
                                                    break;
                                                case 258: // Overwatch
                                                    echo "<img src='http://www.esportscups.com.br/img/icones/overwatch2.png' alt='Overwatch' title='Overwatch' width='100%'>";
                                                    break;
                                            }
                                        ?>
                                        </div>
                                        <div class="col-7 col-md-7">
                                            <h5><?php echo $lobby['nome']; ?></h5>
                                            Recompensa Atual: e$ <?php echo $soma['soma']; ?>
                                        </div>
                                        <div class="col-3 col-md-3">
                                        <?php
                                            $vagasOcupadas = mysqli_num_rows(mysqli_query($conexao, "
                                                SELECT * FROM lobby_equipe_semente
                                                INNER JOIN lobby_equipe ON lobby_equipe_semente.cod_equipe = lobby_equipe.codigo
                                                WHERE lobby_equipe.cod_lobby = ".$lobby['codigo']."
                                                AND lobby_equipe_semente.cod_jogador is not null
                                            "));
                                        ?>
                                            <h3><?php echo $vagasOcupadas." / ".($lobby['times'] * $lobby['jogador_por_time']); ?></h3>
                                        </div>
                                    </div>
                                </a>
                                
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        
        <div class="barraSociais row text-center">
            
            <div class="col-3 facebook">
                <a href="https://www.facebook.com/escups/" target="_blank">
                    <div class="col-xs-12 col-md-12">		
                        <i class="fab fa-facebook-f" style="font-size:48px"></i><br>
                    </div>
                </a>                
            </div>
            <div class="col-3 twitter">
                <a href="https://twitter.com/cups_e" target="_blank">
                    <div class="col-xs-12 col-md-12">		
                        <i class="fab fa-twitter" style="font-size:48px"></i><br>
                    </div>
                </a>                
            </div>
            <div class="col-3 twitch">
                <a href="https://www.twitch.tv/esportscups" target="_blank">
                    <div class="col-xs-12 col-md-12">		
                        <i class="fab fa-twitch" style="font-size:48px"></i><br>
                    </div>
                </a>  
            </div>
            <div class="col-3 youtube">
                <a href="https://www.youtube.com/channel/UCmOVIphlEpXqg6L4Sa9EW_g" target="_blank">
                    <div class="col-xs-12 col-md-12">		
                        <i class="fab fa-youtube" style="font-size:48px"></i><br>
                    </div>
                </a> 
            </div>
        </div>
        
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h2 class="tituloIndex">Caixas com <strong>Drop</strong></h2>
                    <div class="detalheTituloIndex"></div>
                    <div class="row">
                    <?php
                        $caixas = mysqli_query($conexao, "SELECT * FROM caixa WHERE status = 1 ORDER BY rand() LIMIT 4");
                        while($caixa = mysqli_fetch_array($caixas)){
                        ?>
                            <div class="col-3 col-md-3">
                                <a href="ptbr/caixas?caixa=<?php echo $caixa['codigo']; ?>"><img src="<?php echo $img; ?>caixas/<?php echo $caixa['codigo'].".png"; ?>" alt="" width="100%" height="auto"></a>
                            </div>
                        <?php
                        }
                    ?>
                    </div>                    
                </div>
                <div class="col-12 col-md-6">
                    <h2 class="tituloIndex">Troque suas <strong>eSCoins</strong></h2>
                    <div class="detalheTituloIndex"></div>
                    <div class="row">
                    <?php
                        $produtos = mysqli_query($conexao, "SELECT * FROM produto WHERE status = 1 ORDER BY rand() LIMIT 4");
                        while($produto = mysqli_fetch_array($produtos)){
                        ?>
                            
                                <div class="col-3 col-md-3">
                                    <a href="ptbr/loja/">
                                    <img src="<?php echo $img; ?>produtos/<?php echo $produto['codigo']; ?>/foto.png" alt="" width="100%"></a>
                                </div>
                            					
                        <?php
                        }
                    ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12">
                    <h2 class="tituloIndex">Nossos <strong>Parceiros</strong></h2>
                    <div class="detalheTituloIndex"></div>
                    <div class="row centralizar">
                        <div class="col-12 col-md-4">
                            <h3 class="centralizar"><strong>Criadores</strong></h3>
                            <div class="row">
                                <div class="col-4 col-md-6 parceiro">
                                    <img src="<?php echo $img; ?>logos/dotirinhas.png" alt="" width="100%">
                                </div>
                                <div class="col-4 col-md-6 parceiro">
                                    <img src="<?php echo $img; ?>logos/mundodeeluna.png" alt="" width="100%">
                                </div>
                                <div class="col-4 col-md-6 parceiro">
                                    <img src="<?php echo $img; ?>logos/overfun.png" alt="" width="100%">
                                </div>
                                <div class="col-4 col-md-6 parceiro">
                                    <img src="<?php echo $img; ?>logos/tavernadaslendas.jpg" alt="" width="100%">
                                </div>
                                <div class="col-4 col-md-6 parceiro">
                                    <img src="<?php echo $img; ?>logos/pooch.jpg" alt="" width="100%">
                                </div>
                                 <div class="col-4 col-md-6 parceiro">
                                    <img src="<?php echo $img; ?>logos/tavernaderivia.png" alt="" width="100%">
                                </div>
                                <div class="col-4 col-md-6 parceiro">
                                    <img src="<?php echo $img; ?>logos/valedopontar.png" alt="" width="100%">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 parceiros">
                            <h3 class="centralizar"><strong>Organizações</strong></h3>
                            <div class="row">
                                <div class="col-6 col-md-6 parceiro">
                                    <img src="<?php echo $img; ?>logos/bros.png" alt="" width="100%">
                                </div>
                                <div class="col-6 col-md-6 parceiro">
                                    <img src="<?php echo $img; ?>logos/ecopointbrasil.png" alt="" width="100%">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <h3 class="centralizar"><strong>Empresas</strong></h3>
                            <div class="row">
                                <div class="col-2 col-md-2">
                                </div>
                                <div class="col-xs-8 col-md-8">
                                    <img src="<?php echo $img; ?>logos/hibrida2.png" alt="" width="100%">
                                </div>					
                                <div class="col-2 col-md-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>  
    </div>
    
      <?php include "footer.php"; ?>
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-64433449-2"></script>
      <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-64433449-2');
      </script>
      <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
		jQuery(function($){				
			$("#carousel2").carouFredSel();
			// Using custom configuration
			$("#carousel2").carouFredSel({
				items     : <?php echo mysqli_num_rows($torneiosDestaque); ?>,
				direction : "up",
				auto: {
					timeoutDuration: 8000
				},
				items: {
					start	: 0
				},
				scroll: {
					items: 1,
					fx: "scroll",
					easing: "quadratic",
					duration: 1500,
					queue: true,
					direction: "up"
				}
			});
			
			<?php
				$contador = 0;
				$torneiosDestaque2 = mysqli_query($conexao, "
					SELECT * FROM campeonato
					WHERE destaque >= 2
					AND inicio > '".date("Y-m-d H:i:s")."'
					ORDER BY inicio ASC
				");
				while($destaque = mysqli_fetch_array($torneiosDestaque2)){
					$ano = date("Y", strtotime($destaque['inicio']));
					$mes = date("m", strtotime($destaque['inicio'])) - 1;
					$dia = date("d", strtotime($destaque['inicio']));
					
				?>
					var dataFinal = new Date(2018, <?php echo $mes; ?>, <?php echo date("d", strtotime($destaque['inicio'])); ?>, <?php echo date("H", strtotime($destaque['inicio'])); ?>, <?php echo date("i", strtotime($destaque['inicio'])); ?>, <?php echo date("s", strtotime($destaque['inicio'])); ?>, 00);
					$("#clock<?php echo $contador; ?>").countdown({until: dataFinal, format:'DHMS'});
				<?php
					$contador++;
				}
			?>
			var dataFinal = new Date(2018, <?php echo date("m", strtotime("-1month", strtotime($destaque['inicio']))); ?>, <?php echo date("d", strtotime($destaque['inicio'])); ?>, <?php echo date("H", strtotime($destaque['inicio'])); ?>, <?php echo date("i", strtotime($destaque['inicio'])); ?>, <?php echo date("s", strtotime($destaque['inicio'])); ?>, 00);
			$("#clock<?php echo $contador; ?>").countdown({until: dataFinal, format:'DHMS'});
			
			$("#carousel").carouFredSel();
			// Using custom configuration
			$("#carousel").carouFredSel({
				items     : 1,
				direction : "up",
				auto: {
					timeoutDuration: 5000
				},
				items: {
					start	: 0
				},
				scroll: {
					items: 1,
					fx: "scroll",
					easing: "quadratic",
					duration: 1500,
					queue: true,
					direction: "up"
				}
			});
		});
	</script>
  </body>
</html>