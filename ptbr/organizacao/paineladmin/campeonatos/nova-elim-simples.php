<form action="ptbr/organizacao/paineladmin/campeonatos/nova-elim-simples-enviar.php" id="criarElimSimples" method="post" onSubmit="return validarElimSimples();">
	<input type="hidden" name="codCampeonato" id="codCampeonato">	
	<fieldset class="grupo">
        <div class="row">
            <div class="col-6 col-md-6">
                <div class="form-group">
                    <label>Nome da Etapa</label>
                    <input type="text" name="nome" id="nome" placeholder="Ex (Playoffs, Fase de Grupos)" class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="form-group">
                    <label>Quantidade de Vagas</label>
                    <input type="number" id="vagas" name="vagas" class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="form-group">
                    <label for="formatoPartidas">Formato das Partidas</label>
                    <select name="formatoPartidas" id="formatoPartidas"class="form-control">
                        <option value="1">Jogo único</option>
                        <option value="3">Melhor de 3</option>
                        <option value="5">Melhor de 5</option>
                        <option value="7">Melhor de 7</option>
                        <option value="9">Melhor de 9</option>
                        <option value="11">Melhor de 11</option>
                    </select>
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="form-group">
                    <label>Haverá disputa de <strong>3rd/4th</strong> lugar?</label> <br>
                    <input type="radio" name="disputaTerceiro" value="1"> Sim
                    <input type="radio" name="disputaTerceiro" value="0" checked> Não
                </div>
            </div>
        </div>
        
		
	</fieldset>
	<fieldset class="grupo">		
		
	</fieldset>
	<div class="campo">
		<input type="submit" value="CRIAR" class="btn btn-dark">
	</div>
</form>