<?php
    header ('Content-type: text/html; charset=utf-8');
	include "../session.php";
	$date = date("Y-m-d H:i:s");
	
	$codJogo = $_POST['codjogo'];
	$jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogos WHERE codigo = $codJogo"));
    if(!isset($_POST['funcao'])){
        $_POST['funcao'] = 3;
    }
    if(isset($_POST['qtdexibir'])){
        $quantidade = $_POST['qtdexibir'];
    }else{
        $quantidade = 10;
    }
	switch($_POST['funcao']){
        case 0: // TODOS OS TORNEIOS
            $campeonatos = mysqli_query($conexao, "SELECT * FROM campeonato
				WHERE cod_jogo = $codJogo
                ORDER BY inicio DESC 
                LIMIT $quantidade	               
			");
            break;
		case 1: // CAMPEONATOS EM DESTAQUE
			$campeonatos = mysqli_query($conexao, "
            SELECT * FROM campeonato 
            WHERE destaque != 0 
            AND status != 2 
            AND cod_jogo = $codJogo 
            ORDER BY inicio ASC 
            LIMIT $quantidade");
			break;
		case 2: // CAMPEONATOS PASSADOS
			$campeonatos = mysqli_query($conexao, "SELECT * FROM campeonato WHERE status = 2 AND cod_jogo = $codJogo ORDER BY inicio DESC LIMIT $quantidade");
			break;
		case 3: // INSCRIÇÕES ABERTAS
			$campeonatos = mysqli_query($conexao, "SELECT * FROM campeonato
				WHERE inicio_inscricao < '$date'
				AND fim_inscricao > '$date'
				AND status = 0
				AND cod_jogo = $codJogo
                ORDER BY inicio ASC
				LIMIT $quantidade                
			");
			break;
		case 4: // EM ANDAMENTO
			$campeonatos = mysqli_query($conexao, "SELECT * FROM campeonato
				WHERE status = 1
				AND cod_jogo = $codJogo
                ORDER BY inicio ASC
				LIMIT $quantidade
			");
			break;
		case 5: // EM BREVE
			$campeonatos = mysqli_query($conexao, "SELECT * FROM campeonato
				WHERE status = 0
				AND cod_jogo = $codJogo
				AND inicio_inscricao > '$date'
                ORDER BY inicio ASC
				LIMIT $quantidade
			");
			break;
			
	}
	
?>
<div class="row">
    <div class="col-12 mt-3">
        <h2 class="tituloIndex"><strong>Torneios de <?php echo $jogo['nome']; ?></strong></h2>
        <div class="detalheTituloIndex"></div>
    </div>
    <div class="col-12 col-md-8">
        <ul class="menuCups">      
            <li class="cupsTodos" onClick="trocarAba2('0');">Todos</li>
            <li class="cupsDestaques" onClick="trocarAba2('1');">Destaques</li>
            <li class="cupsAbertos" onClick="trocarAba2('3');">Abertos</li>
            <li class="cupsPassados" onClick="trocarAba2('2');">Passados</li>
            <li class="cupsAndamento" onClick="trocarAba2('4');">Em Andamento</li>
            <li class="cupsBreve" onClick="trocarAba2('5');">Em Breve</li>
        </ul>
    </div>
    <div class="col-12 col-md-4 text-right">
        <ul class="menuCups">            
            <li class="exibir10" onClick="qtdexibir(10);">10</li>
            <li class="exibir20" onClick="qtdexibir(20);">20</li>
            <li class="exibir50" onClick="qtdexibir(50);">50</li>
            <li class="exibir100" onClick="qtdexibir(100);">100</li>
        </ul>
    </div>
    <hr>
</div>



<div class="row campeonatos">
<?php
	if(mysqli_num_rows($campeonatos) == 0){
	?>
        <div class="col-12 col-md-12"  >
            <br>
            <h2>NENHUM CAMPEONATO ENCONTRADO</h2>
            Infelizmente não encontramos nenhum campeonato para a sua pesquisa. <br><br>
            Estamos procurando alimentar cada vez mais a plataforma com conteúdo de qualidade. <br>
            Se está interessado em organizar competições, entre em contato conosco: <br>
            <strong>contato@esportscups.com.br</strong>
        </div>
		
	<?php
	}else{
		while($campeonato = mysqli_fetch_array($campeonatos)){
			$organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$campeonato['cod_organizacao'].""));
            $inscricoes = mysqli_num_rows(mysqli_query($conexao, "SELECT status FROM campeonato_inscricao WHERE cod_campeonato = ".$campeonato['codigo']." "));
            /*
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
            */
        ?>
            <div class="col-12" onClick="encaminhar('<?php echo "ptbr/campeonato/".$campeonato['codigo']."/"; ?>');" >
                <div class="campeonatoLista row centralizar">
                    <div class="col-md-2 align-self-center">
                        <img src="img/<?php echo $campeonato['thumb']; ?>" alt="">
                    </div>
                    <div class="col-md-4 align-self-center">
                        <span class="h4">
                            <?php echo $campeonato['nome']; ?>
                        </span><br>
                        <?php echo $jogo['nome']; ?> - por: <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/"><strong><?php echo $organizacao['nome']; ?></strong></a>
                    </div>
                    <div class="col-md-2 align-self-center">
                        <strong><?php echo date("d/m/Y", strtotime($campeonato['inicio'])); ?></strong><br>
                        as <strong><?php echo date("H:i", strtotime($campeonato['inicio'])); ?></strong>
                    </div>
                    <div class="col-md-2 align-self-center">
                        Inscrições<br>
                        <?php echo $inscricoes; ?> / <strong><?php echo $campeonato['vagas']; ?></strong>
                    </div>
                    <div class="col-md-2 align-self-center">
                    <?php
                        switch($campeonato['status']){
                            case 0: // TORNEIO ABERTO
                                echo "<span class='text-success'>Inscrições Abertas</span>";
                                break;
                            default:
                                echo "<span class='text-secondary'>Inscrições Encerradas</span>";
                                break;
                        }
                    ?>
                    </div>
                </div>    
            </div>
        <?php
		}
	}	
	
?>
</div>


	

	
