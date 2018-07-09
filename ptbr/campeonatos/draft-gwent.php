
    <h3>Escolha suas Facções</h3>
    <form action="ptbr/campeonatos/draft-enviar.php" method="post" onSubmit="return validar();">
        <input type="text" name="funcao" id="funcao" value="alterar" hidden="hidden">
        <input type="hidden" name="codCampeonato" id="codCampeonato" value="<?php echo $campeonato['codigo']; ?>">
        <div class="row">
            <div class="col-4 col-md-4">
                <input type="checkbox" name="faccao[]" class="limitado" value="skellige" id="druida" hidden="hidden">
                <label for="druida" class="heroi">
                    <img src="<?php echo "http://www.esportscups.com.br/img/draft/GWENT/skellige.png" ?>" width="100">
                </label>
            </div>
            <div class="col-4 col-md-4">
                <input type="checkbox" name="faccao[]" class="limitado" value="reinosdonorte" id="hunter" hidden="hidden">
                <label for="hunter" class="heroi">
                    <img src="<?php echo "http://www.esportscups.com.br/img/draft/GWENT/reinosdonorte.png" ?>" width="100">
                </label>
            </div>
            <div class="col-4 col-md-4">
                <input type="checkbox" name="faccao[]" class="limitado" value="monstros" id="mage" hidden="hidden">
                <label for="mage" class="heroi">
                    <img src="<?php echo "http://www.esportscups.com.br/img/draft/GWENT/monstros.png" ?>" width="100">
                </label>
            </div>
            <div class="col-4 col-md-4">
                <input type="checkbox" name="faccao[]" class="limitado" value="scoiatael" id="paladin" hidden="hidden">
                <label for="paladin" class="heroi">
                    <img src="<?php echo "http://www.esportscups.com.br/img/draft/GWENT/scoiatael.png" ?>" width="100">
                </label>
            </div>
            <div class="col-4 col-md-4">
                <input type="checkbox" name="faccao[]" class="limitado" value="nilfgaard" id="priest" hidden="hidden">
                <label for="priest" class="heroi">
                    <img src="<?php echo "http://www.esportscups.com.br/img/draft/GWENT/nilfgaard.png" ?>" width="100">
                </label>
            </div>
            <div class="col">
                <input type="submit" value="Enviar Alteração" class="btn btn-dark">
            </div>
        </div>						
    </form>