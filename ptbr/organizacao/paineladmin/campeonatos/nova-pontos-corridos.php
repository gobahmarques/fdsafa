<form action="ptbr/organizacao/paineladmin/campeonatos/nova-pontos-corridos-enviar.php" method="post" onSubmit="return validarPtsCorridos();">
	<input type="hidden" name="codCampeonato" id="codCampeonato">	
	<fieldset class="grupo">
        <div class="row">
            <div class="col-6 col-md-6">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" placeholder="Ex (Playoffs, Fase de Grupos)" autofocus class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="form-group">
                    <label for="nome">Vagas Totais</label>
                    <input type="number" id="vagas" name="vagas" class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="form-group">
                    <label for="formatoPartidas">Formato</label>
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
            <div class="col-6 col-md-3">
                <div class="form-group">
                    <label for="number">Qtd. Grupos</label>
                    <input type="number" name="grupos" min="2" value="2" class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="form-group">
                    <label for="number">Avanços/Grupo</label>
                    <input type="number" name="classificados" min="1" value="1" class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="form-group">
                    <label for="number">Data Limite</label>
                    <input type="text" name="datalimite" placeholder="DD/MM/AAAA HH:MM:SS" class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="form-group">
                    <label for="number">Pts por vitória</label>
                    <input type="number" id="vagas" name="vitoria" value="3" class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="form-group">
                    <label for="number">Pts por empate</label>
                    <input type="number" id="vagas" name="empate" value="0" class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="form-group">
                    <label for="number">Pts por derrota</label>
                    <input type="number" id="vagas" name="derrota" value="1" class="form-control">
                </div>
            </div>
            <div class="col-12 col-md-12">
                <input type="submit" value="CRIAR" class="btn btn-dark">
            </div>
        </div>
	</fieldset>
	
</form>