<form action="ptbr/organizacao/paineladmin/campeonatos/nova-elim-simples-enviar.php" id="criarElimSimples" method="post" onSubmit="return validarElimSimples();">
	<input type="hidden" name="codCampeonato" id="codCampeonato">	
	<fieldset class="grupo">
        <div class="row">
            <div class="col-6 col-md-6">
                <div class="form-group">
                    <label>Nome da Etapa</label>
                    <input type="text" name="nome" id="nome" placeholder="Ex (Playoffs, Fase de Grupos)" class="form-control" required>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="form-group">
                    <label>Vagas</label>
                    <input type="number" id="vagas" name="vagas" class="form-control" required>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="form-group">
                    <label><strong>3rd/4th</strong> lugar?</label> <br>
                    <input type="radio" name="disputaTerceiro" value="1"> Sim
                    <input type="radio" name="disputaTerceiro" value="0" checked> Não
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="form-group">
                    <label for="formatoPartidas">Formato das Partidas</label>
                    <select name="formatoPartidas" id="formatoPartidas"class="form-control" required>
                        <option value="1">Jogo único</option>
                        <option value="3">Melhor de 3</option>
                        <option value="5">Melhor de 5</option>
                        <option value="7">Melhor de 7</option>
                        <option value="9">Melhor de 9</option>
                        <option value="11">Melhor de 11</option>
                    </select>
                </div>
            </div>
            <div class="col-6 col-md-8">
                <div class="form-group">
                    <label for="number">Data e Hora Início</label>
                    <div class="row">
                        <div class="col-7">
                            <input type="date" name="dataInicio" id="inicio" placeholder="DD/MM/AAAA" class="form-control">
                        </div>
                        <div class="col-5">
                            <input type="time" name="horaInicio" id="inicio" placeholder="HH:MM" class="form-control">            
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="form-group">
                    <label>Última etapa do torneio?</label> <br>
                    <input type="radio" name="ultimaEtapa" value="1" required> Sim
                    <input type="radio" name="ultimaEtapa" value="0" checked required> Não
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