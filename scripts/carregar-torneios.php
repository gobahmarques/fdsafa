<?php
	header("Content-Type: text/html;  charset=UTF-8",true);
	include "../session.php";
	$date = date("Y-m-d H:i:s");
	
	$codJogo = $_POST['codjogo'];
	$jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogos WHERE codigo = $codJogo"));
    if(!isset($_POST['funcao'])){
        $_POST['funcao'] = 3;
    }
	switch($_POST['funcao']){
		case 1: // CAMPEONATOS EM DESTAQUE
			$campeonatos = mysqli_query($conexao, "SELECT * FROM campeonato WHERE destaque != 0 AND status != 2 AND cod_jogo = $codJogo ORDER BY inicio ASC");
			break;
		case 2: // CAMPEONATOS PASSADOS
			$campeonatos = mysqli_query($conexao, "SELECT * FROM campeonato WHERE status = 2 AND cod_jogo = $codJogo  ORDER BY inicio DESC");
			break;
		case 3: // INSCRI��ES ABERTAS
			$campeonatos = mysqli_query($conexao, "SELECT * FROM campeonato
				WHERE inicio_inscricao < '$date'
				AND fim_inscricao > '$date'
				AND status = 0
				AND cod_jogo = $codJogo
				ORDER BY inicio ASC
			");
			break;
		case 4: // EM ANDAMENTO
			$campeonatos = mysqli_query($conexao, "SELECT * FROM campeonato
				WHERE status = 1
				AND cod_jogo = $codJogo
				ORDER BY inicio ASC
			");
			break;
		case 5: // EM BREVE
			$campeonatos = mysqli_query($conexao, "SELECT * FROM campeonato
				WHERE status = 0
				AND cod_jogo = $codJogo
				AND inicio_inscricao > '$date'
				ORDER BY inicio ASC
			");
			break;
			
	}
	
?>
<ul class="menuCups">
    <li class="cupsDestaques" onClick="trocarAba2(1);">Destaques</li>
    <li class="cupsAbertos" onClick="trocarAba2(3);">Abertos</li>
    <li class="cupsPassados" onClick="trocarAba2(2);">Passados</li>
    <li class="cupsAndamento" onClick="trocarAba2(4);">Em Andamento</li>
    <li class="cupsBreve" onClick="trocarAba2(5);">Em Breve</li>
</ul>


<div class="row campeonatos">
<?php
	if(mysqli_num_rows($campeonatos) == 0){
	?>
        <div class="col-12 col-md-12"  >
            <br>
            <h2>NENHUM CAMPEONATO ENCONTRADO</h2>
            Infelizmente n�o encontramos nenhum campeonato para a sua pesquisa. <br><br>
            Estamos procurando alimentar cada vez mais a plataforma com conte�do de qualidade. <br>
            Se est� interessado em organizar competi��es, entre em contato conosco: <br>
            <strong>contato@esportscups.com.br</strong>
        </div>
		
	<?php
	}else{
		while($campeonato = mysqli_fetch_array($campeonatos)){
			$organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$campeonato['cod_organizacao'].""));
		?>
            <div class="col-6 col-md-3 centralizar" onClick="encaminhar('<?php echo "ptbr/campeonato/".$campeonato['codigo']."/"; ?>');">
                <div class="campeonatoLista">
                    <div class="col-12 col-md-12">
                        <h4><?php echo $campeonato['nome']; ?></h4>
                    </div>
                    <div class="col-12 col-md-12">
                        <img src="img/<?php echo $campeonato['thumb']; ?>" alt="">
                    </div>
                    <div class="col-12 col-md-12">
                        <?php echo "Por: <strong>".$organizacao['nome']."</strong><br>";
                        if($campeonato['precheckin'] > 0){
                            echo "Pre check-in: <strong>".date("d/m - H:i", strtotime("-".$campeonato['precheckin']."minutes", strtotime($campeonato['inicio'])))."</strong>";
                        }else{
                            echo "Inicio: <strong>".date("d/m - H:i", strtotime($campeonato['inicio']))."</strong>";   
                        }
                    ?>
                    </div>
                    <div class="col-12 col-md-12">
                    <?php 
                        $inscricoesPendentes = mysqli_num_rows(mysqli_query($conexao, "SELECT cod_jogador FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 0 "));
                        $inscricoesConfirmadas = mysqli_num_rows(mysqli_query($conexao, "SELECT cod_jogador FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." AND status = 1 "));
                        $pctAtual = ($inscricoesConfirmadas / $campeonato['vagas']) * 100;
                    ?>
                        <div class="progress">
                            <div class="progress-bar bg-laranja" role="progressbar" style="width: <?php echo $pctAtual; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo ($inscricoesPendentes + $inscricoesConfirmadas); ?></div>
                        </div>
                    </div>
                </div>
            </div>
		<?php
		}
	}	
	
?>
</div>


	

	
