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

        <title>Editar Perfil de Usuário | e-Sports Cups</title>
    </head>
    <body>
        <?php 
            include "../header.php";
            include "perfil.php";
            if(!isset($usuario['codigo']) || $usuario['codigo'] != $perfil['codigo']){
                header("Location: http://www.esportscups.com.br/");	
            }
        ?>
        
        <div class="container">
            <div class="row">
                
                <div class="col-4 col-md-2 text-right font-weight-bold">
                    <div class="row">
                        <div class="col">
                            Nome Completo
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            E-mail
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Cadastro
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Data Nascimento
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Apelido<br><br><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Foto Perfil (1:1)<br><br><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Foto Banner
                        </div>
                    </div>
                </div>
                
                <div class="col-6 col-md-4">
                    <form method="post" id="atualizarPerfil" action="scripts/usuario.php" enctype="multipart/form-data">
                        <input type="hidden" name="funcao" value="atualizarPerfil">
                        <input type="hidden" name="jogador" value="<?php echo $perfil['codigo']; ?>">
                        <div class="row">
                            <div class="col">
                                <?php echo $perfil['nome']." ".$perfil['sobrenome']; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?php echo $perfil['email']; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?php echo date("d/m/Y - H:i", strtotime($perfil['cadastro'])); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?php echo date("d/m/Y", strtotime($perfil['data_nascimento'])); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="text" name="nick" value="<?php echo $perfil['nick']; ?>" class="form-control" required><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="file" name="perfil" class="form-control"><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="file" name="banner" class="form-control"><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="submit" class="form-control btn btn-dark" value="Atualizar">
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
        
        <?php include "../footer.php"; ?>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script>
            $(function(){   
                // $(".visaogeral").addClass("ativo"); 
            });
        </script>
    </body>
</html>