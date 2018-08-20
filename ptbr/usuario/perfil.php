<?php
    $perfil = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogador WHERE codigo = ".$_GET['perfil'].""));
?>
<div class="container perfilJogador">
    <div class="row d-none d-md-block">
        
        <?php
            if($perfil['foto_banner'] != NULL){
            ?>
                <img src="img/<?php echo $perfil['foto_banner']; ?>" class="banner"> 
            <?php
            }else{
                
            }
        ?>
          
    </div>
    <div class="row">
        <div class="col-12 col-md-12">
            <img src="img/<?php echo $perfil['foto_perfil']; ?>" class="fotoPerfil">
            <div class="col">
                <div class="infosPerfil">
                    <h2><?php echo $perfil['nome']." '".$perfil['nick']."' ".$perfil['sobrenome']; ?></h2>
                    Membro desde: <?php echo date("d/m/Y", strtotime($perfil['cadastro'])); 
                        if(isset($usuario['codigo']) && $usuario['codigo'] == $perfil['codigo']){
                            echo "<br><a href='ptbr/usuario/".$perfil['codigo']."/editar/'><i class='fas fa-cog'></i> Editar</a>";
                        }
                    ?>
                </div>            
            </div>          
        </div>        
    </div>
    <div class="row">
        <ul class="menuPerfil bg-dark">
            <a href="ptbr/usuario/<?php echo $perfil['codigo']; ?>/"><li class="visaogeral">Visão Geral</li></a>
            <a href="ptbr/usuario/<?php echo $perfil['codigo']; ?>/amigos/"><li class="amigos">Amigos</li></a>
            <a href="ptbr/usuario/<?php echo $perfil['codigo']; ?>/times/"><li class="times">Times</li></a>
            <?php
                if(isset($usuario['codigo']) && $usuario['codigo'] == $perfil['codigo']){
                ?>
                    <a href="ptbr/usuario/<?php echo $perfil['codigo']; ?>/partidas-em-aberto/"><li class="partidasemaberto">Partidas em Aberto</li></a>
                    <a href="ptbr/usuario/<?php echo $perfil['codigo']; ?>/carteira-escoin/"><li class="carteiraes">Carteira e$</li></a>
                    <a href="ptbr/usuario/<?php echo $perfil['codigo']; ?>/carteira-real/"><li class="carteirars">Carteira R$</li></a>
                    <a href="ptbr/usuario/<?php echo $perfil['codigo']; ?>/permissoes/"><li class="permissoes">Permissões</li></a>
                <?php
                }
            ?>
            
        </ul>
    </div>
</div>