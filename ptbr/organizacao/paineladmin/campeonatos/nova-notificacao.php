<form method="post" action="ptbr/organizacao/paineladmin/campeonatos/nova-notificacao-enviar.php">
    <input type="hidden" name="codCampeonato" class="codCampeonato" value="<?php echo $_GET['codCampeonato']; ?>">
    <input type="hidden" name="codOrganizacao" class="codOrganizacao" value="<?php echo $_GET['codOrganizacao']; ?>">
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="form-group">
                <label>Conteúdo da Notificação</label>
                <textarea name="conteudoNotificacao" class="form-control"></textarea>
            </div>
        </div>
        <div class="col-12 col-md-12">
            <div class="form-group">
                <label>Link para Iteração (Opcional):</label>
                <input type="text" name="linkNotificacao" placeholder="Link de destino" class="form-control">
            </div>
        </div>
        <div class="col-12 col-md-12">
            <input type="submit" value="Enviar Notificação" class="btn btn-dark">
        </div>
    </div>
    
</form>