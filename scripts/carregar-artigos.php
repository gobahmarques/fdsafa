<?php
	include "../conexao-banco.php";
	$aba = $_POST['aba'];

	if($aba == 0){
		$artigos = mysqli_query($conexao, "SELECT * FROM artigos WHERE cod_jogo is null ORDER BY data DESC LIMIT 10");
	}else{
		$artigos = mysqli_query($conexao, "SELECT * FROM artigos WHERE cod_jogo = $aba ORDER BY data DESC LIMIT 10");
	}
    ?>
    <div class="col-12 col-md-12">
        <h2 class="tituloIndex">últimos <strong>Artigos</strong></h2>
        <div class="detalheTituloIndex"></div>
    </div>  
    <?php
	while($artigo = mysqli_fetch_array($artigos)){
	?>
        
            <div class="col-12 col-md-6">
                <div class="artigo">
                    <img src="http://www.esportscups.com.br/img/artigos/<?php echo $artigo['thumb']; ?>" alt="">
                      <div class="card-body">
                        <h5><?php echo $artigo['nome']; ?></h5>
                        <a href="ptbr/artigo/<?php echo $artigo['codigo'] ?>/" class="btn btn-azul">Ver Tudo</a>
                      </div>
                </div>
              
            </div>     
	<?php
	}
?>