<form action="ptbr/organizacao/paineladmin/campeonatos/nova-elim-dupla-enviar.php" method="post" onSubmit="return validarElimSimples();">
	<input type="hidden" name="codCampeonato" id="codCampeonato">	
	<fieldset class="grupo">
        <div class="row">
            <div class="col-6 col-md-6">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" class="form-control" id="nome" placeholder="Ex (Playoffs, Fase de Grupos)">
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="form-group">
                    <label for="number">Vagas</label>
			         <input type="number" id="vagas" name="vagas" class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="form-group">
                    <label for="number">Fomato das Partidas</label>
			        <select name="formatoPartidas" id="formatoPartidas" class="form-control">
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
                    <label for="number">Data e Hora Início</label>
                    <input type="text" name="inicio" id="inicio" placeholder="DD/MM/AAAA HH:MM:SS" class="form-control">
                </div>
            </div>
        </div>
	</fieldset>
	<div class="campo">
		<input type="submit" value="CRIAR" class="btn btn-dark">
	</div>
</form>