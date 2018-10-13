<?php
    include "../../enderecos.php";
    include "../../session.php";

    $organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$_GET['codigo'].""));

	$datahora = date("Y-m-d H:i:s");

	if(isset($usuario['codigo'])){
		$pesquisaFuncao = mysqli_query($conexao, "SELECT * FROM jogador_organizacao WHERE cod_organizacao = ".$organizacao['codigo']." AND cod_jogador = ".$usuario['codigo']." ");
		$funcao = mysqli_fetch_array($pesquisaFuncao);	
	}
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

        <title>Torneios Anteriores - <?php echo $organizacao['nome']; ?> | e-Sports Cups</title>
    </head>
    <body>
        <?php 
            include "../header.php";
            include "perfil.php";
        ?>
        
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">
                    <?php
                        if(isset($funcao['status'])){
                        ?>
                            <a href="<?php echo "ptbr/organizacao/".$organizacao['codigo']."/painel/"; ?>">
                                <input type="button" value="PAINEL DE CONTROLE" class="btn btn-azul">
                            </a><br><br>
                        <?php
                        }
                    ?>
                    <table cellspacing="0" cellpadding="0" id="tabelaLobbys" class="centralizar">
                        <thead>
                            <tr>
                                <td>JOGO</td>
                                <td>NOME</td>
                                <td>VAGAS</td>
                                <td>DATA & HORA</td>
                                <td>INSCRIÇÃO</td>
                            </tr>
                        </thead>
                        <?php
                        $torneios = mysqli_query($conexao, "SELECT * FROM campeonato WHERE cod_organizacao = ".$organizacao['codigo']." AND status = 2 ORDER BY fim DESC");
                        while($torneio = mysqli_fetch_array($torneios)){
                            $qtdInscritos = mysqli_num_rows(mysqli_query($conexao, "
                                SELECT * FROM campeonato_inscricao
                                WHERE cod_campeonato = ".$torneio['codigo']."
                            "));
                        ?>
                                <tr data-url="ptbr/campeonato/<?php echo $torneio['codigo']; ?>/">
                                    <td>
                                    <?php
                                        switch($torneio['cod_jogo']){
                                            case 369: // HEARTHSTONE
                                                echo "<img src='http://www.esportscups.com.br/img/icones/hs.png' alt='Hearthstone' title='Hearthstone'>";
                                                break;
                                            case 123:
                                                echo "<img src='http://www.esportscups.com.br/img/icones/gwent.png' alt='GWENT' title='GWENT'>";
                                                break;
                                            case 147: // League of Legends
                                                echo "<img src='http://www.esportscups.com.br/img/icones/lol.png' alt='League of Legends' title='League of Legends'>";
                                                break;
                                            case 357: // Dota 2
                                                echo "<img src='http://www.esportscups.com.br/img/icones/dota2.png' alt='Dota 2' title='Dota 2'>";
                                                break;
                                            case 258: // Overwatch
                                                echo "<img src='http://www.esportscups.com.br/img/icones/overwatch2.png' alt='Overwatch' title='Overwatch'>";
                                                break;
                                        }
                                    ?>
                                    </td>
                                    <td><?php echo $torneio['nome']; ?></td>
                                    <td><?php echo $qtdInscritos." / ".$torneio['vagas']; ?></td>
                                    <td><?php echo date("d/m/Y - H:i", strtotime($torneio['inicio'])); ?></td>
                                    <td>
                                    <?php
                                        if($torneio['valor_escoin'] == 0){
                                            echo "Gratuito";	
                                        }else{
                                            echo "e$ ".number_format($torneio['valor_escoin'], 0, '', '.'); 	
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
                    <?php include "barra.php"; ?>
                </div> 
            </div>
        </div>
        
        <?php include "../footer.php"; ?>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script>
            $('table tr').click(function(){
                window.location = $(this).data('url');
                returnfalse;
            });
            jQuery(function($){
                $(".anteriores").addClass("ativo");
            });
        </script>
    </body>
</html>