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

        <title>Perfil de Usuário | e-Sports Cups</title>
    </head>
    <body>
        <?php 
            include "../header.php";
            include "perfil.php";
        ?>
        
        <div class="container">
            <div class="row text-center text-white">
                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-12 text-dark text-center">
                            <div class="border p-2 mb-3">
                                <?php
                                    $lvlJogador = mysqli_query($conexao, "SELECT * FROM gm_jogador_level WHERE cod_jogador = ".$perfil['codigo']."");
                                    if(mysqli_num_rows($lvlJogador) > 0){
                                        $lvlJogador = mysqli_fetch_array($lvlJogador);
                                        $tamBarra = ($lvlJogador['xp_atual'] / $lvlJogador['xp_final']) * 100; 
                                    ?>
                                        Level <?php echo $lvlJogador['level']; ?>
                                        <div class="progress centralizar" style="height: 15px;">
                                            <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: <?php echo $tamBarra; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($tamBarra, 0); ?> %</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 text-left">
                                                0
                                            </div>
                                            <div class="col-6 text-right">
                                                <?php echo $lvlJogador['xp_final']; ?>
                                            </div>
                                        </div>    
                                        <div class="row text-white">
                                            <div class="col-4">
                                                <div class="bg-dark p-2">
                                                    Level<br>
                                                    <span class="h2">
                                                        <?php echo $lvlJogador['level']; ?>
                                                    </span>
                                                </div>  
                                            </div>
                                            <div class="col-4">
                                                <div class="bg-dark p-2">
                                                    Resets<br>
                                                    <span class="h2">
                                                        <?php echo $lvlJogador['resets']; ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-4 mb-4">
                                                <div class="bg-dark p-2">
                                                    Multiplicador<br>
                                                    <span class="h2">
                                                        <?php echo "x ".number_format($lvlJogador['multiplicador'], 2, '.', ','); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }else{
                                        mysqli_query($conexao, "
                                            INSERT INTO gm_jogador_level
                                            VALUES
                                            (".$perfil['codigo'].", 1, 0, 50, 0, '".date("Y-m-d")."', 1, 0, 50)
                                        ");
                                        header("Location: ptbr/usuario/".$perfil['codigo']."/");
                                    }   
                                ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="col-12 col-md-6">
                    <div class="border p-2 text-left text-dark">                        
                        <span class="h2">
                            Missões Diárias
                        </span><br>
                        Você receberá 1 missão cada dia que logar e poderá acumular no máximo 3.<br><br>
                        
                        <?php
                            $missoesUsuario = mysqli_query($conexao, "
                                SELECT * FROM gm_jogador_missao 
                                WHERE cod_jogador = ".$perfil['codigo']."
                                AND data_conclusao is null
                            ");
                            while($missao = mysqli_fetch_array($missoesUsuario)){
                                $missao = mysqli_fetch_array(mysqli_query($conexao, "
                                    SELECT * FROM gm_missoes
                                    WHERE id = ".$missao['cod_missao']."
                                "));
                                echo "<hr><span class='h4 font-weight-bold'>".$missao['titulo']."</span><br>".$missao['descricao']."<br>Recompensa: e$ ".$missao['recompensa']." / ".$missao['xp']." XP";                                
                            }
                        ?>
                    </div>
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
                $(".visaogeral").addClass("ativo"); 
            });
        </script>
    </body>
</html>