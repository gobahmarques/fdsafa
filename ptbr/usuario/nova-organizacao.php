<form action="" method="post" id="formCriarOrganizacao" onSubmit="return validarOrganizacao();">
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="form-group">
                <label>Nome da Organizacao</label>
                <input type="text" name="nomeOrganizacao" placeholder="Nome da Organizacao" id="nomeOrganizacao" class="form-control" autofocus>
            </div>
        </div>
        <div class="col-12 col-md-12">
            <div class="form-group">
                <label>Descrição</label>
                <textarea class="form-control" placeholder="Descrição da Organização" name="descricao"></textarea>
            </div>
        </div>
        <div class="col-12 col-md-12">
            <div class="form-group">
                <label>E-mail responsável:</label>
                <input type="text" name="emailResponsavel" placeholder="digite o e-mail do responsável" id="emailResponsavel" class="form-control">
            </div>
        </div>
        <div class="col-12 col-md-12">
            <div class="status" id="status">                
            </div><br>
            <input type="submit" value="CADASTRAR" class="btn btn-laranja">
        </div>
    </div>	
</form>