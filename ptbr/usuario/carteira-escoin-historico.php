<?php
    include "../../enderecos.php";
    include "../../session.php";
    
    
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

        <title>Carteira eSCoin e$ | e-Sports Cups</title>
    </head>
    <body>
        <?php 
            include "../header.php";
            include "perfil.php";
            if(!isset($usuario['codigo']) || $usuario['codigo'] != $perfil['codigo']){
                header("Location: ../../../");
            }else{
                if($usuario['codigo'] != $perfil['codigo']){
                    header("Location: ../../../");
                }
            }

            $totalInvestimento = mysqli_fetch_array(mysqli_query($conexao, "SELECT SUM(valor) AS valor FROM log_coin WHERE cod_jogador = ".$usuario['codigo']." AND tipo = 0 "));
            $totalFaturamento = mysqli_fetch_array(mysqli_query($conexao, "SELECT SUM(valor) AS valor FROM log_coin WHERE cod_jogador = ".$usuario['codigo']." AND tipo = 1 "));
            $totalMovimentacoes = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM log_coin WHERE cod_jogador = ".$usuario['codigo'].""));
        ?>
        
        <div class="container">
            <ul class="menuCarteira">
                <a href="ptbr/usuario/<?php echo $usuario['codigo']; ?>/carteira-escoin/"><li>Resumo</li></a>
                <li class="ativo">Histórico</li>
            </ul>
            <div class="row-fluid">
                <div class="resumoCarteira">
                <div class="col-12 col-md-12 float-left">
                    <h2>Resumo de sua Carteira eSCoin</h2>
                    <div class="filtros-busca-carteira">
                        <form id="filtrosTransacoes">
                            <input type="hidden" name="funcao" value="pesquisaHistoricoCoin">
                            <input type="hidden" name="codjogador" value="<?php echo $usuario['codigo']; ?>">
                            Início: <input type="date" name="inicio" onchange="atualizarTransacoes();">
                            Fim: <input type="date" name="fim" onchange="atualizarTransacoes();">
                            Tipo: <select name="tipoTransacao" onchange="atualizarTransacoes();">
                                <option hidden value="">Selecione</option>
                                <option value="1">Créditos</option>
                                <option value="0">Débitos</option>
                            </select>
                        </form>
                    </div>
                <?php
                    $transacoes = mysqli_query($conexao, "SELECT * FROM log_coin WHERE cod_jogador = ".$usuario['codigo']." ORDER BY datahora DESC LIMIT 10");
                    if(mysqli_num_rows($transacoes) != 0){
                    ?>
                        <table cellpadding="0" cellspacing="0" class="tabela-historico">
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
                                            echo "<img class='coin' src='".$img."icones/escoin.png' alt='eSCoins' title='eSCoins'>";
                                        ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                            ?>
                        </table>
                    <?php	
                    }
                ?>
                </div>               
            </div>
        </div>

        <?php include "../footer.php"; ?>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script>
            function atualizarTransacoes(){
                $.ajax({
                    type: "POST",
                    url: "scripts/usuario.php",
                    data: $("#filtrosTransacoes").serialize(),
                    success: function(resultado){
                        $(".tabela-historico").html(resultado);
                    }
                });
            }
            $(function(){   
                $(".carteiraes").addClass("ativo"); 
            });
        </script>
    </body>
</html>