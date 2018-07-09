<form method='post' action='ptbr/organizacao/paineladmin/ligas/form-nova-divisao.php' enctype="multipart/form-data">
    <input type="hidden" name="codOrganizacao" value="<?php echo $_GET['organizacao']; ?>">
    <input type="hidden" name="codLiga" value="<?php echo $_GET['liga']; ?>">
    <div class="row">
        <div class='col-8 col-md-8'>
            <label>Nome da Divisão</label>
            <input type='text' placeholder='Nome da Divisão  (ex: Divisão de Base)' name='nome' class='form-control' id="nome">
        </div>
        <div class='col-4 col-md-4'>
            <label>Vagas</label>
            <input type='number' name='vagas' class='form-control'>
        </div>
        <div class="col-8 col-md-8">
            <br>
            <label>Logo da Divisão</label>
            <input type="file" name="logoDivisao">
        </div>
        <div class="col-4 col-md-4">
            <br>
            <input type="submit" value="CRIAR" class="btn btn-dark">
        </div>
    </div>
</form>

<?php
    if(isset($_POST['codOrganizacao'])){
        include "../../../../conexao-banco.php";
        mysqli_query($conexao, "INSERT INTO liga_divisao VALUES (NULL, ".$_POST['codLiga'].", '".$_POST['nome']."', ".$_POST['vagas'].", NULL)");
        $id = mysqli_insert_id($conexao);
        if(isset($_FILES['logoDivisao']) && $_FILES['logoDivisao']['error'] == 0){
            $arquivo_tmp = $_FILES['logoDivisao']['tmp_name'];
            $nome = $_FILES['logoDivisao']['name'];
            // Pega a extensão
            $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
            // Converte a extensão para minúsculo
            $extensao = strtolower ( $extensao );

            if ( strstr ( '.jpg;.jpeg;.png', $extensao ) ) {
                // Cria um nome único para esta imagem
                // Evita que duplique as imagens no servidor.
                // Evita nomes com acentos, espaços e caracteres não alfanuméricos
                $novoNome = mysqli_insert_id($conexao).".".$extensao;
                // Concatena a pasta com o nome
                $destino = "../../../../img/ligas/".$_POST['codLiga']."/divisoes/".$novoNome;
                $destino2 = "img/ligas/".$_POST['codLiga']."/divisoes/".$novoNome;
                if(file_exists("../../../../img/ligas/".$_POST['codLiga']."/divisoes/")){
                    @move_uploaded_file ($arquivo_tmp, $destino);
                }else{
                    if(file_exists("../../../../img/ligas/".$_POST['codLiga']."/")){
                        mkdir("../../../../img/ligas/".$_POST['codLiga']."/divisoes/");
                        @move_uploaded_file($arquivo_tmp, $destino);   
                    }else{
                        mkdir("../../../../img/ligas/".$_POST['codLiga']."/");
                        mkdir("../../../../img/ligas/".$_POST['codLiga']."/divisoes/");
                        @move_uploaded_file($arquivo_tmp, $destino);
                    }            
                }
                mysqli_query($conexao, "UPDATE liga_divisao SET logo_caminho = '$destino2' WHERE codigo = $id");
            }
        }
    }
?>