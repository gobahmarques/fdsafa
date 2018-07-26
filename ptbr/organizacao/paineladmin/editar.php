<?php
    include "../../../enderecos.php";
    include "../../../session.php";
    $organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$_GET['codigo'].""));

	$datahora = date("Y-m-d H:i:s");

	if(isset($usuario['codigo'])){
		$pesquisaFuncao = mysqli_query($conexao, "SELECT * FROM jogador_organizacao WHERE cod_organizacao = ".$organizacao['codigo']." AND cod_jogador = ".$usuario['codigo']." ");
		$funcao = mysqli_fetch_array($pesquisaFuncao);	
		if(!isset($funcao['status']) || $funcao['status'] < 9){
			header("Location: http://www.esportscups.com.br/");	
		}
	}else{
		header("Location: http://www.esportscups.com.br/");
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
        <?php include "../../header.php"; ?>
        
        <br>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3">
                    <?php
                        include "perfil.php";
                    ?>
                </div>
                <div class="col-12 col-md-9">
                    <form method="post" id="editarOrganizacao" action="scripts/organizacao.php" enctype="multipart/form-data">
                        <input type="hidden" name="funcao" value="atualizarInfos"> 
                        <input type="hidden" name="codorganizacao" value="<?php echo $organizacao['codigo']; ?>"> 
                        <div class="row">
                            <div class="col-4 col-md-4">
                                Nome:<br>
                                <input type="text" name="nome" class="form-control" value="<?php echo $organizacao['nome']; ; ?>" readonly>    
                            </div>
                            <div class="col-8 col-md-8">
                                Descrição:<br>
                                <input type="text" name="descricao" class="form-control" value="<?php echo $organizacao['descricao']; ; ?>"> 
                            </div>
                            <div class="col-4 col-md-4">
                                E-mail contato:<br>
                                <input type="text" name="email" class="form-control" value="<?php echo $organizacao['email']; ; ?>"> 
                            </div>
                            <div class="col-4 col-md-4">
                                Site (link):<br>
                                <input type="text" name="site" class="form-control" value="<?php echo $organizacao['site']; ; ?>">                             
                            </div>
                            <div class="col-4 col-md-4">
                                Facebook (link):<br>
                                <input type="text" name="facebook" class="form-control" value="<?php echo $organizacao['facebook']; ; ?>"> 
                            </div>
                            <div class="col-4 col-md-4">
                                Discord (link):<br>
                                <input type="text" name="discord" class="form-control" value="<?php echo $organizacao['discord']; ; ?>">
                            </div>
                            <div class="col-4 col-md-4">
                                Twitter (link):<br>
                                <input type="text" name="twitter" class="form-control" value="<?php echo $organizacao['twitter']; ; ?>">                             
                            </div>
                            <div class="col-4 col-md-4">
                                Twitch (link):<br>
                                <input type="text" name="twitch" class="form-control" value="<?php echo $organizacao['twitch']; ; ?>"> 
                            </div>
                            <div class="col-4 col-md-4">
                                Azubu (link):<br>
                                <input type="text" name="azubu" class="form-control" value="<?php echo $organizacao['azubu']; ; ?>"> 
                            </div>
                            <div class="col-4 col-md-4">
                                YouTube (link):<br>
                                <input type="text" name="youtube" class="form-control" value="<?php echo $organizacao['youtube']; ; ?>"> 
                            </div>
                            <div class="col-4 col-md-4">
                                Foto Perfil <br>
                                <input type="file" name="perfil" class="form-control">
                            </div>
                            <div class="col-4 col-md-4">
                                Banner:<br>
                                <input type="file" name="fotobanner" class="form-control">                             
                            </div>
                            <div class="col-4 col-md-4">
                                <input type="submit" name="">                             
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
        <?php include "../../footer.php"; ?>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script>
            function atualizarInfos(){
                $.ajax({
                    type: "POST",
                    url: "scripts/organizacao.php",
                    data: $("#editarOrganizacao").serialize(),
                    processData: false,
                    contentType: false,
                    success: function(resultado){
                        alert(resultado);
                        return false;
                    }
                });
            }
            jQuery(function($){
                
            });
        </script>
    </body>
</html>