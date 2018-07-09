<form action="" method="post" id="formCriarEquipe" onSubmit="return validarEquipe();">
    <div class="row">
        <div class="col-5 col-md-5">
            <div class="form-group">
                <label>Nome da Equipe</label>
                <input type="text" name="nomeEquipe" placeholder="Nome da Equipe" size="60" id="nomeEquipe" class="form-control" autofocus>
            </div>
        </div>
        <div class="col-2 col-md-2">
            <div class="form-group">
                <label>TAG</label>
                <input type="text" name="tagEquipe" placeholder="TAG" size="60" id="tagEquipe" class="form-control">
            </div>
        </div>
        <div class="col-5 col-md-5">
            <div class="form-group">
                <label>Jogo</label>
                <select name="jogo" class="nomeJogo form-control" style="width: 150px;">
                    <option value="" hidden="hidden"> - SELECIONE O JOGO -</option>
                    <?php
                        include "../../conexao-banco.php";
                        $pesquisaJogos = mysqli_query($conexao, "SELECT * FROM jogos ORDER BY nome");
                        while($dados = mysqli_fetch_array($pesquisaJogos)){
                        ?>
                            <option value="<?php echo $dados['codigo']; ?>"><?php echo $dados['nome']; ?></option>
                        <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-12 col-md-12">
            <div class="status" id="status">                
            </div><br>
            <input type="submit" value="CADASTRAR" class="btn btn-laranja">
        </div>
    </div>	
</form>