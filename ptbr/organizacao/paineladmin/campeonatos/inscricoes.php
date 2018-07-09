<?php
    include "../../../../enderecos.php";
    include "../../../../session.php";
    
    $organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$_GET['codigo'].""));
	$campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_GET['torneio'].""));
	$datahora = date("Y-m-d H:i:s");

	if(isset($usuario['codigo'])){
		$pesquisaFuncao = mysqli_query($conexao, "SELECT * FROM jogador_organizacao WHERE cod_organizacao = ".$organizacao['codigo']." AND cod_jogador = ".$usuario['codigo']." ");
		$funcao = mysqli_fetch_array($pesquisaFuncao);	
		if(!isset($funcao['status'])){
			header("Location: http://www.esportscups.com.br/http://www.esportscups.com.br/http://www.esportscups.com.br/");	
		}
	}else{
		header("Location: http://www.esportscups.com.br/http://www.esportscups.com.br/http://www.esportscups.com.br/");
	}

	if($campeonato['jogador_por_time'] == 1){
		$pesquisaInscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." ORDER BY status ASC, datahora ASC ");
		$solicitacoes = mysqli_num_rows($pesquisaInscricoes);
		$pendentes = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 0"));
		$recusadas = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 2"));
		$aceitas = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 1"));
	}else{
		$pesquisaInscricoes = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." GROUP BY cod_equipe ORDER BY status ASC, datahora ASC ");		
		$solicitacoes = mysqli_num_rows($pesquisaInscricoes);
		
		$pendentes = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 0 GROUP BY cod_equipe"));
		$recusadas = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 2 GROUP BY cod_equipe"));
		$aceitas = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 1 GROUP BY cod_equipe"));
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

        <title>Artigos eSC | e-Sports Cups</title>
    </head>
    <body>
        <?php include "../../../header.php"; ?>
        
        <br>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3">
                    <?php
                        include "../perfil.php";
                    ?>
                </div>
                <div class="col-12 col-md-9">
                    <ul class="navegacaoPainel">
                        <li><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/"><?php echo $organizacao['nome']; ?></a></li>
                        <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/"><li >Campeonatos</li></a>
                        <li><a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/campeonato/<?php echo $campeonato['codigo']; ?>/"><?php echo $campeonato['nome']; ?></a></li>
                        <li class="ativo">Inscrições</li>
                    </ul>
                    <div class="row centralizar">
                        <div class="col-6 col-md-3">
                            <div class="contagemInscricao">
                            <?php

                                echo "<h2>$solicitacoes</h2>";
                            ?>
                                Solicitações
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="contagemInscricao">
                            <?php

                                echo "<h2>$pendentes</h2>";
                            ?>
                                Pendentes
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="contagemInscricao">
                            <?php

                                echo "<h2>$recusadas</h2>";
                            ?>
                                Recusadas
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="contagemInscricao">
                            <?php

                                echo "<h2>$aceitas</h2>";
                            ?>
                                Aceitas
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <table cellspacing="0" cellpadding="0" id="tabelaLobbys" class="centralizar">
                                <thead>
                                    <tr>
                                        <td>Status</td>
                                        <td>Jogador</td>					
                                        <td>E-mail</td>
                                        <td>Equipe</td>
                                        <td>Data</td>
                                        <td>Ações</td>
                                    </tr>
                                </thead>
                                <?php

                                    while($inscricao = mysqli_fetch_array($pesquisaInscricoes)){
                                        $jogadorInscricao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$inscricao['cod_jogador']." "));
                                    ?>
                                        <tr>
                                            <td>
                                            <?php
                                                switch($inscricao['status']){
                                                    case 0:
                                                        echo "<img src='img/icones/loading.gif' alt='Pendente' title='Pendente'>";
                                                        break;
                                                    case 1:
                                                        echo "<img src='img/icones/aprovar.png' alt='Aprovado' title='Aprovado'>";
                                                        break;
                                                    case 2:
                                                        echo "<img src='img/icones/recusar.png' alt='Recusado' title='Recusado'>";
                                                        break;
                                                }
                                            ?>
                                            </td>
                                            <td><?php echo $jogadorInscricao['nome']." '".$jogadorInscricao['nick']."' ".$jogadorInscricao['sobrenome']; ?></td>
                                            <td><?php echo $jogadorInscricao['email']; ?></td>
                                            <td>
                                            <?php
                                                if($inscricao['cod_equipe'] != NULL){
                                                    $equipe = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM equipe WHERE codigo = ".$inscricao['cod_equipe']." "));
                                                    echo $equipe['tag']." - ".$equipe['nome'];
                                                }else{
                                                    echo "----------";
                                                }
                                            ?>
                                            </td>
                                            <td><?php echo date("d m Y - H:i", strtotime($inscricao['datahora'])); ?></td>
                                            <td>
                                            <?php
                                                if($inscricao['status'] == 0){ // PENDENTE
                                                ?>
                                                    <a href="<?php echo "ptbr/organizacao/".$organizacao['codigo']."/painel/campeonato/".$campeonato['codigo']."/inscricoes/".$inscricao['cod_jogador']."/1/"; ?>"><img src="http://www.esportscups.com.br/img/icones/aprovar.png" alt="Aprovar" title="Aprovar"></a>
                                                    <a href="<?php echo "ptbr/organizacao/".$organizacao['codigo']."/painel/campeonato/".$campeonato['codigo']."/inscricoes/".$inscricao['cod_jogador']."/2/"; ?>"><img src="http://www.esportscups.com.br/img/icones/recusar.png" alt="Recusar" title="Recusar"></a>
                                                <?php
                                                }elseif($inscricao['status'] == 2){ // RECUSADA                                                
                                                ?>
                                                    <a href="<?php echo "ptbr/organizacao/".$organizacao['codigo']."/painel/campeonato/".$campeonato['codigo']."/inscricoes/".$inscricao['cod_jogador']."/3/"; ?>"><img src="http://www.esportscups.com.br/img/icones/excluir.png" alt="Excluir" title="Excluir"></a>
                                                <?php	
                                                }else{
                                                ?>
                                                    <a href="<?php echo "ptbr/organizacao/".$organizacao['codigo']."/painel/campeonato/".$campeonato['codigo']."/inscricoes/".$inscricao['cod_jogador']."/3/"; ?>"><img src="http://www.esportscups.com.br/img/icones/excluir.png" alt="Excluir" title="Excluir"></a>
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
                </div>
            </div>
        </div>

        <?php include "../../../footer.php"; ?>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script type="text/javascript">
            function statusCampeonato(campeonato,status){
                if(status == 4){
                    var resposta = confirm("Deseja realmente EXCLUIR este campeonato? Esta ação não poderá ser desfeita! Todas as informações serão excluidas (tabelas, jogos, inscrições, etc).");		
                    if(resposta == true){
                        $.ajax({
                            type: "POST",
                            url: "scripts/status-campeonato.php",
                            data: "campeonato="+campeonato+"&status="+status,
                            success: function(resultado){                               
                                window.location = "organizacao/<?php echo $organizacao['codigo']; ?>/painel/";
                            }
                        });
                    }
                }else{
                    $.ajax({
                        type: "POST",
                        url: "scripts/status-campeonato.php",
                        data: "campeonato="+campeonato+"&status="+status,
                        success: function(resultado){
                            alert(resultado);
                            window.location.reload();
                        }
                    });
                }	
            }
            function registrarVencedores(campeonato, passo, etapa){
                $.ajax({
                    type: "POST",
                    url: "scripts/registrar-vencedores.php",
                    data: "campeonato="+campeonato+"&passo="+passo+"&etapa="+etapa,
                    success: function(resultado){
                        $("#modal").html(resultado);
                        $("#modal").modal();
                    }
                });
            }
            $(document).ready(function(){

            });
        </script>
    </body>
</html>