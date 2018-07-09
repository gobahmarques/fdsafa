
<div class="painelPartida">
    <div class="container">
        <input type="hidden" name="codpartida" value="<?php echo $partida['codigo']; ?>">
        <input type="hidden" name="sementeUm" class="sementeUm" value="<?php echo $sementeUm['cod_semente']; ?>">
        <input type="hidden" name="sementeDois" class="sementeDois" value="<?php echo $sementeDois['cod_semente']; ?>">
        <div class="row centralizar">                
            <div class="col-6 col-md-3">                    
                <div class="form-group">
                    <label>Alterar Horário da Partida</label>
                    <input class="form-control novaDataPartida" type="text" placeholder="DATA & HORA" size="71" name="datahora"><br>
                    <input type="button" value="Alterar" class="btn btn-dark" onClick="attData(<?php echo $partida['codigo']; ?>);">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="form-group">
                    <label>Alterar Sementes</label><br>
                    <input type="button" class="btn btn-dark form-group" value="Lado 01">
                    <input type="button" class="btn btn-dark form-group" value="Lado 02">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label>Resultado Final</label><br>
                    <div class="row">
                        <div class="col">
                        </div>
                        <div class="col">
                            <input type="number" name="placarUm"  placeholder="Placar Um" class="placarUm form-control">
                        </div>
                        <div class="col">
                            <input type="number" name="placarDois" placeholder="Placar Dois" class="placarDois form-control">
                        </div>
                        <div class="col">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <br>
                            <input type="submit" value="Enviar" class="btn btn-dark" onclick="resultadoFinal(<?php echo $partida['codigo']; ?>);">	
                        </div>                            
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
<script>
    function attData(partida){
        var novaDataPartida = $(".novaDataPartida").val();
        $.ajax({
			type: "POST",
			url: "ptbr/campeonatos/partidas/funcoes-painel-admin.php",
			data: "funcao=attdata&partida="+partida+"&data="+novaDataPartida,
			success: function(resultado){
				location.reload();
			}
		}); 
    }
    function resultadoFinal(partida){
        var placarUm = $(".placarUm").val();
        var placarDois = $(".placarDois").val();
        var sementeUm = $(".sementeUm").val();
        var sementeDois = $(".sementeDois").val();
        $.ajax({
			type: "POST",
			url: "ptbr/campeonatos/partidas/funcoes-painel-admin.php",
			data: "funcao=resultadofinal&sementeUm="+sementeUm+"&sementeDois="+sementeDois+"&placarUm="+placarUm+"&placarDois="+placarDois+"&partida="+partida,
			success: function(resultado){
				location.reload();
			}
		});
    }
	function jogadoresAusente(codPartida){
		$.ajax({
			type: "POST",
			url: "scripts/partidas.php",
			data: "funcao=1&codpartida="+codPartida,
			success: function(resultado){
				location.reload();
			}
		});
	}
</script>