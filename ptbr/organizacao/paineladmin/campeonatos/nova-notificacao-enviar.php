<?php
    include "../../../../session.php";

    $campeonato = $_POST['codCampeonato'];
    $infosCampeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome FROM campeonato WHERE codigo = $campeonato "));
    $organizacao = $_POST['codOrganizacao'];
    $infosOrganizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome FROM organizacao WHERE codigo = $organizacao "));

    $notificacao = addslashes($_POST['conteudoNotificacao']);
    $link = addslashes($_POST['linkNotificacao']);

    $inscritosCamp = mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_campeonato = $campeonato ");
    while($inscrito = mysqli_fetch_array($inscritosCamp)){
        if($inscrito['cod_equipe'] == NULL){ // INSCRIÇÃO SOLO
            mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$notificacao', ".$inscrito['cod_jogador'].", '$link', 0)");
            $jogador = mysqli_fetch_array(mysqli_query($conexao, "SELECT email FROM jogador WHERE codigo = ".$inscrito['cod_jogador']." "));
            ini_set('display_errors', 1);
            error_reporting(E_ALL);
            $from = "noreply@esportscups.com.br";
            $to = "".$jogador['email']."";
            $subject = "[Notificação] ".$infosCampeonato['nome'];
            $message = "A organização: ".$infosOrganizacao['nome']." emitiu o seguinte comunicado:<br>
                <h2>".$infosCampeonato['nome']."</h2>
                '$notificacao' <br><br>
            ";
            $headers = "De:". $from;
            mail($to, $subject, $message, $headers);
        }else{ // INSCRIÇÃO DE EQUIPE
            $lineup = mysqli_query($conexao, "SELECT * FROM campeonato_lineup
                WHERE cod_campeonato = $campeonato
                AND cod_equipe = ".$inscrito['cod_equipe']."
            ");
            while($integrante = mysqli_fetch_array($lineup)){
                mysqli_query($conexao, "INSERT INTO notificacao VALUES (NULL, '$notificacao', ".$integrante['cod_jogador'].", '$link', 0)");
                ini_set('display_errors', 1);
                error_reporting(E_ALL);
                $from = "noreply@esportscups.com.br";
                $to = "".$jogador['email']."";
                $subject = "[Notificação] ".$infosCampeonato['nome'];
                $message = "A organização: ".$infosOrganizacao['nome']." emitiu o seguinte comunicado:<br>
                    <h2>".$infosCampeonato['nome']."</h2>
                    '$notificacao' <br><br>
                ";
                $headers = "De:". $from;
                mail($to, $subject, $message, $headers);
            }
        }
    }
    
    // header ("Location: ptbr/organizacao/".$infosCamp['cod_organizacao']."/painel/campeonato/$campeonato/");

?>