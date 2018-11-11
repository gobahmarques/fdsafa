<div class="opcoesOrganizacao">
    <div class="row">
        <div class="col-5 col-md-12">
        <?php
            if($organizacao['perfil'] != NULL){
            ?>
                <img src="img/<?php echo $organizacao['perfil']; ?>" alt="<?php echo $organizacao['nome']; ?>" >
            <?php
            }  
        ?>            
        </div>
        <div class="col-7 col-md-12">
            <h2><?php echo $organizacao['nome']; ?></h2>
            <?php
                if($funcao['status'] == 9){
                ?>
                    <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/editar/"><i class="fas fa-cog"></i> Editar</a>
                <?php
                }
            ?>
        </div>
    </div>                         
</div>
<ul class="menuPainelOrganizacao">
    <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/"><li class="opcao1">Campeonatos</li></a>
    <a href="ptbr/organizacao/<?php echo $organizacao['codigo']; ?>/painel/ligas/"><li class="opcao2">Ligas</li></a>
    <li class="opcao3">Caixas</li>
    <li class="opcao4">Produtos</li>
</ul>