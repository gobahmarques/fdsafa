
<div class="container perfilJogador">
    <div class="row d-none d-md-block">
        
        <?php
            if($organizacao['banner'] != NULL){
            ?>
                <img src="img/<?php echo $organizacao['banner']; ?>" class="banner"> 
            <?php
            }else{
                
            }
        ?>
          
    </div>
    <div class="row"> 
        <div class="col-12 col-md-12">
            <img src="img/<?php echo $organizacao['perfil']; ?>" class="fotoPerfil">
            <div class="infosPerfil">
                <h2><?php echo $organizacao['nome']; ?></h2>
                Criada em: <?php echo date("d/m/Y", strtotime($organizacao['datahora'])); ?>               
            </div>            
        </div>
    </div>
    <div class="row">
        <ul class="menuPerfil bg-dark">
            <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/"><li class="inscricoesabertas ">Inscrições Abertas</li></a>
            <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/em-andamento/"><li class="emandamento">Em Andamento</li></a>
            <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/anteriores/"><li class="anteriores">Anteriores</li></a>   
            <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/em-breve/"><li class="embreve">Em Breve...</li></a>
            
            <div class="acoesPerfil">
            <?php
                if(isset($usuario['codigo'])){
                    $pesquisaFollow = mysqli_query($conexao, "SELECT * FROM organizacao_seguidor WHERE cod_organizacao = ".$organizacao['codigo']." AND cod_jogador = ".$usuario['codigo']."");
                    if(mysqli_num_rows($pesquisaFollow) != 0){ // JÁ ESTÁ SEGUINDO
                    ?>
                        <span class="btn btn-seguir unfollow" onMouseOver="unfollowText();" onMouseOut="unfollowText();" onClick="naoSeguirOrganizacao(<?php echo $organizacao['codigo']; ?>,<?php echo $usuario['codigo']; ?>);">Seguindo</span>
                    <?php	
                    }else{
                    ?>
                        <span class="btn btn-seguir" onClick="seguirOrganizacao(<?php echo $organizacao['codigo']; ?>,<?php echo $usuario['codigo']; ?>);">Seguir</span>
                    <?php
                    }
                }else{
                ?>
                    <span class="btn btn-seguir" onClick="abrirLogin();">Seguir</span>
                <?php
                }  
            ?>
            </div>
        </ul>
    </div>
</div>

<script>
    function unfollowText(){
        if($(".unfollow").html() == "Seguindo"){
            $(".unfollow").html("Deixar de seguir");
        }else{
            $(".unfollow").html("Seguindo");
        }
    }
    function seguirOrganizacao(organizacao, jogador){
        $.ajax({
            type: "POST",
            url: "scripts/usuario.php",
            data: "funcao=seguirOrganizacao&organizacao="+organizacao+"&jogador="+jogador,
            success: function(resultado){
                window.location.reload();
            }
        });
    }
    function naoSeguirOrganizacao(organizacao, jogador){
        $.ajax({
            type: "POST",
            url: "scripts/usuario.php",
            data: "funcao=naoSeguirOrganizacao&organizacao="+organizacao+"&jogador="+jogador,
            success: function(resultado){
                window.location.reload();
            }
        });
    }
</script>