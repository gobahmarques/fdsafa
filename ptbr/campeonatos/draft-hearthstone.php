<div class="passoInscricao draft">
    <h3>Escolha seus novos heróis</h3>  
    <form action="ptbr/campeonatos/draft-enviar.php" method="post" onSubmit="return validar();">	
        <div class="row">
        <input type="text" name="funcao" id="funcao" value="alterar" hidden="hidden">
        <input type="hidden" name="codCampeonato" id="codCampeonato" value="<?php echo $campeonato['codigo']; ?>">
            <div class="col-4 col-md-4">
                <input type="checkbox" name="heroi[]" class="limitado" value="druida" id="druida" hidden="hidden">
                <label for="druida" class="heroi">
                    <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/druida.png" ?>" width="100">
                </label>
            </div>
            <div class="col-4 col-md-4">
                <input type="checkbox" name="heroi[]" class="limitado" value="hunter" id="hunter" hidden="hidden">
                <label for="hunter" class="heroi">
                    <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/hunter.png" ?>" width="100">
                </label>
            </div>
            <div class="col-4 col-md-4">
                <input type="checkbox" name="heroi[]" class="limitado" value="mage" id="mage" hidden="hidden">
                <label for="mage" class="heroi">
                    <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/mage.png" ?>" width="100">
                </label>
            </div>
            <div class="col-4 col-md-4">
                <input type="checkbox" name="heroi[]" class="limitado" value="paladin" id="paladin" hidden="hidden">
                <label for="paladin" class="heroi">
                    <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/paladin.png" ?>" width="100">
                </label>
            </div>
            <div class="col-4 col-md-4">
                <input type="checkbox" name="heroi[]" class="limitado" value="priest" id="priest" hidden="hidden">
                <label for="priest" class="heroi">
                    <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/priest.png" ?>" width="100">
                </label>
            </div>
            <div class="col-4 col-md-4">
                <input type="checkbox" name="heroi[]" class="limitado" value="rogue" id="rogue" hidden="hidden">
                <label for="rogue" class="heroi">
                    <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/rogue.png" ?>" width="100">
                </label>
            </div>
            <div class="col-4 col-md-4">
                <input type="checkbox" name="heroi[]" class="limitado" value="shaman" id="shaman" hidden="hidden">
                <label for="shaman" class="heroi">
                    <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/shaman.png" ?>" width="100">
                </label>
            </div>
            <div class="col-4 col-md-4">
                <input type="checkbox" name="heroi[]" class="limitado" value="warlock" id="warlock" hidden="hidden">
                <label for="warlock" class="heroi">
                    <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/warlock.png" ?>" width="100">
                </label>
            </div>
            <div class="col-4 col-md-4">
                <input type="checkbox" name="heroi[]" class="limitado" value="warrior" id="warrior" hidden="hidden">
                <label for="warrior" class="heroi">
                    <img src="<?php echo "http://www.esportscups.com.br/img/draft/Hearthstone/warrior.png" ?>" width="100">
                </label>
            </div>
            <div class="col-12 col-md-12">
                <input type="submit" value="ENVIAR ALTERAÇÃO" class="btn btn-dark">
            </div>
        </div>
    </form>
</div>