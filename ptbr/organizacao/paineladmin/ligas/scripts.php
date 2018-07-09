<?php
    include "../../../../session.php";
    $divisoes = $_POST['codDivisoes'];
    $maxDivisoes = count($divisoes);
    $liga = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM liga WHERE codigo = ".$_POST['codliga']." "));
    $contador = 0;

    if($maxDivisoes > 0){
        // CRIAR CIRCUITO        
        mysqli_query($conexao, "INSERT INTO liga_circuito VALUES (NULL, ".$_POST['codliga'].", '".date('Y-m-d H:i:s')."')");
        $idcircuito = mysqli_insert_id($conexao);
    }

    while($contador < $maxDivisoes){
        if($_POST['dataInicioInsc'.$divisoes[$contador]] != "" && $_POST['horaInicioInsc'.$divisoes[$contador]] != "" && $_POST['dataFimInsc'.$divisoes[$contador]] != "" && $_POST['horaFimInsc'.$divisoes[$contador]] != "" && $_POST['dataInicioTorneio'.$divisoes[$contador]] != "" && $_POST['horaInicioTorneio'.$divisoes[$contador]] != "" && $_POST['dataFimTorneio'.$divisoes[$contador]] != "" && $_POST['horaFimTorneio'.$divisoes[$contador]] != ""){
            $padraoDivisao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM liga_divisao_campeonato WHERE cod_divisao = $divisoes[$contador]"));
            
            $inicioInscricao = $_POST['dataInicioInsc'.$divisoes[$contador]]." ".$_POST['horaInicioInsc'.$divisoes[$contador]];
            $fimInscricao = $_POST['dataFimInsc'.$divisoes[$contador]]." ".$_POST['horaFimInsc'.$divisoes[$contador]];
            $inicioTorneio = $_POST['dataInicioTorneio'.$divisoes[$contador]]." ".$_POST['horaInicioTorneio'.$divisoes[$contador]];
            $fimTorneio = $_POST['dataFimTorneio'.$divisoes[$contador]]." ".$_POST['horaFimTorneio'.$divisoes[$contador]];  
            
            $descricao = addslashes($padraoDivisao['descricao']);
            $regulamento = addslashes($padraoDivisao['regulamento']);
            $premiacao = addslashes($padraoDivisao['premiacao']);
            $cronograma = addslashes($padraoDivisao['cronograma']);
            
            $idcamp = mysqli_fetch_array(mysqli_query($conexao, "SELECT codigo FROM campeonato ORDER BY codigo DESC LIMIT 1"));
            $idcamp = $idcamp['codigo'];
            $idcamp++;
            
            $sql = mysqli_query($conexao, "
                INSERT INTO campeonato VALUES 
                ($idcamp,
                ".$liga['cod_organizacao'].", 
                ".$usuario['codigo'].", 
                ".$padraoDivisao['cod_jogo'].", 
                '".$padraoDivisao['nome']."', 
                ".$padraoDivisao['vagas'].", 
                ".$padraoDivisao['jogador_por_time'].", 
                ".$padraoDivisao['valor_escoin'].", 
                ".$padraoDivisao['valor_real'].", 
                '$inicioInscricao', 
                '$fimInscricao', 
                '$inicioTorneio', 
                '$fimTorneio', 
                '".$padraoDivisao['regiao']."', 
                '$descricao', 
                '$regulamento', 
                '$premiacao', 
                '$cronograma', 
                '".$padraoDivisao['thumb']."', 
                ".$padraoDivisao['tipo_inscricao'].", 
                '".$padraoDivisao['fuso_horario']."', 
                '".$padraoDivisao['link']."', 
                '".$padraoDivisao['pais']."', 
                '".$padraoDivisao['local']."', 
                ".$padraoDivisao['presencial'].", 
                0, 
                ".$padraoDivisao['destaque'].", 
                ".$padraoDivisao['qtd_pick'].", 
                ".$padraoDivisao['qtd_ban'].", 
                '".$padraoDivisao['plataforma']."', 
                ".$padraoDivisao['precheckin'].", 
                ".$padraoDivisao['cod_divisao'].", 
                ".$padraoDivisao['status_inscricao'].")"
            );
            
            mysqli_query($conexao, "INSERT INTO liga_circuito_campeonato VALUES ($idcircuito, $idcamp)");
        }
        $contador++;
    }
    header("Location: ../../../../ptbr/organizacao/".$liga['cod_organizacao']."/painel/liga/".$liga['codigo']."/circuitos/");
?>