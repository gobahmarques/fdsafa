<?php
    include "../../enderecos.php";
    include "../../session.php";

    $campeonato = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM campeonato WHERE codigo = ".$_GET['codigo'].""));
	$organizacao = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM organizacao WHERE codigo = ".$campeonato['cod_organizacao'].""));
	$jogo = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM jogos WHERE codigo = ".$campeonato['cod_jogo']." "));

	$datahora = date("Y-m-d H:i:s");

	if(isset($usuario['codigo'])){
		$pesquisaFuncao = mysqli_query($conexao, "SELECT * FROM jogador_organizacao WHERE cod_organizacao = ".$organizacao['codigo']." AND cod_jogador = ".$usuario['codigo']." ");
		$funcao = mysqli_fetch_array($pesquisaFuncao);	
	}
?>
<!doctype html>
<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.css">
        <link rel="stylesheet" href="<?php echo $css; ?>esportscups.css">

        <title>Inscrição <?php echo $campeonato['nome']; ?> | e-Sports Cups</title>
    </head>
    <body>
        <?php include "../header.php"; ?>
        <?php include "campeonato-perfil.php"; ?>
        <div class="container centralizar">
        <?php
            function mostrarPaginaInsc($codJogo){
                global $usuario, $conexao, $campeonato, $datahora, $jogo;
                switch($codJogo){
                    case 369: // HEARTHSTONE
                        include "campeonato-inscricao-hearthstone.php";  
                        break;
                    case 123: // GWENT
                        include "campeonato-inscricao-gwent.php";
                        break;
                    case 357: // DOTA 2
                        include "campeonato-inscricao-dota2.php";
                        break;
                    default: // INSCRIÇÃO GERAL
                        include "campeonato-inscricao-geral.php";                        
                        break;
                }  
            }
            
            if(isset($usuario['codigo'])){ // POSSUI USUÁRIO LOGADO
                $pesquisaInscricao = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM campeonato_inscricao WHERE cod_jogador = ".$usuario['codigo']." AND cod_campeonato = ".$campeonato['codigo']." "));
                if($pesquisaInscricao > 0){ // JÁ POSSUI INSCRIÇÃO
                    mostrarPaginaInsc($campeonato['cod_jogo']);
                }else{ // NÃO REALIZOU INSCRIÇÃO AINDA
                    if($campeonato['cod_divisao'] != NULL){ // CAMPEONATO PERTENCE A ALGUMA DIVISÃO
                        $pesquisaInscricao = mysqli_query($conexao, "SELECT * FROM liga_inscricao WHERE cod_jogador = ".$usuario['codigo']." AND cod_liga = ".$liga['codigo']." ");
                        if(mysqli_num_rows($pesquisaInscricao) > 0){ // É INSCRITO DA LIGA
                            $inscricaoLiga = mysqli_fetch_array($pesquisaInscricao);
                            if($inscricaoLiga['cod_divisao'] == $campeonato['cod_divisao']){ // É INTEGRANTE DA DIVISÃO DO CAMPEONATO
                                mostrarPaginaInsc($campeonato['cod_jogo']);
                            }else{ // NÃO É INTEGRANTE DA DIVISÃO
                                   
                            }
                        }else{ // NÃO É INSCRITO NA LIGA
                            mostrarPaginaInsc($campeonato['cod_jogo']);
                        }
                    }else{ // CAMPEONATO INDIVIDUAL
                        mostrarPaginaInsc($campeonato['cod_jogo']);
                    }                  
                }
            }else{ // MENSAGEM PARA REALIZAR LOGIN
            ?>
                <h2>REALIZE O LOGIN</h2>
                É necessário que você crie sua conta e realize o login <br>
                para poder participar das competições na plataforma. <br><br>
                Clique no botão "Entrar" no topo do site.
            <?php 
            }           
        ?>
            <div class="row">
                <div class="col-12 col-md-12">
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- Barra lateral página de Artigo -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-3038725769937948"
                         data-ad-slot="7294511218"
                         data-ad-format="auto"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div>
        </div>
        
        <?php include "../footer.php"; ?>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo $js; ?>jquery.js"></script>
        <script src="<?php echo $js; ?>bootstrap.js"></script>
        <script>
            function garantirVagaPaga(codCampeonato){
                jQuery.ajax({
                    type: "POST",
                    url: "ptbr/campeonatos/scripts.php",
                    data: "campeonato="+codCampeonato+"&funcao=confirmarVagaPaga",
                    success: function(data){
                        window.location.reload();
                    }
                });
            }
            function desistirVaga(codCampeonato){
                jQuery.ajax({
                    type: "POST",
                    url: "ptbr/campeonatos/scripts.php",
                    data: "campeonato="+codCampeonato+"&funcao=desistirVaga",
                    success: function(data){
                        window.location.reload();
                    }
                });
            }
            function validar(){
                <?php
                    if(isset($usuario['codigo'])){
                    ?>
                        var valorReal = <?php echo $campeonato['valor_real'] ?>;
                        var valorCoin = <?php echo $campeonato['valor_escoin'] ?>;
                        var saldoReal = <?php echo $usuario['saldo']; ?>;
                        var saldoCoin = <?php echo $usuario['pontos']; ?>;	
                    <?php
                    }
                ?>
                if(valorCoin > 0){ 
                    if(saldoCoin < valorCoin){ // NÃO POSSUI SALDO
                        alert("Saldo em e$ insuficiente.");
                        return false;
                    }else{ // POSSUI SALDO
                        var counter = $('.limitado:checked').length;
                        var limit = <?php echo $campeonato['qtd_pick']; ?>;
                        switch("<?php echo $jogo['abreviacao']; ?>"){
                            case "Hearthstone":
                                if(counter < limit){
                                    alert('É obrigatório selecionar '+limit+' heróis!');
                                    return false;
                                }else{
                                    return true;
                                }
                                break;
                            case "GWENT":
                                if(counter < limit){
                                    alert('É obrigatório selecionar '+limit+' facções!');
                                    return false;
                                }else{
                                    return true;
                                }
                                break;
                            default:
                                return true;
                        }
                    }
                }else if(valorReal > 0){
                    if(saldoReal < valorReal){ // NÃO POSSUI SALDO
                        $(".modal-title").html("<h3>Saldo insuficiente</h3>");
                        $(".modal-body").html("Para realizar esta inscrição, é necessário o saldo de R$ "+valorReal+" em sua carteira.<br>Para adicionar os fundos necessários, basta clicar no botão abaixo e seguir o procedimento apresentado.");
                        $(".modal-footer").html("<a href='<?php echo "ptbr/usuario/".$usuario['codigo']."/carteira-real/adicionar-saldo/"; ?>'><input type='button' value='Adicionar Saldo' class='btn btn-dark'></a>");
                        $(".modal").modal();
                        return false;
                    }else{ // POSSUI SALDO
                        var counter = $('.limitado:checked').length;
                        var limit = <?php echo $campeonato['qtd_pick']; ?>;
                        switch("<?php echo $jogo['abreviacao']; ?>"){
                            case "Hearthstone":
                                if(counter < limit){
									$(".modal-title").html("<h3>Informações Incompletas</h3>");
									$(".modal-body").html("Para realizar esta inscrição, é necessário selecionar "+limit+" heróis!");
									$(".modal-footer").html("<button type='button' class='btn btn-dark' data-dismiss='modal'>Ok, entendi!</button>");
									$(".modal").modal();
                                    return false;
                                }else{
                                    return true;
                                }
                                break;
                            case "GWENT":
                                if(counter < limit){
                                    alert('É obrigatório selecionar '+limit+' facções!');
                                    return false;
                                }else{
                                    return true;
                                }
                                break;
                            default:
                                return true;
                        }		
                    }
                }else{ // INSCRIÇÃO GRATUITA
                    var counter = $('.limitado:checked').length;
                    var limit = <?php echo $campeonato['qtd_pick']; ?>;
                    switch("<?php echo $jogo['abreviacao']; ?>"){
                        case "Hearthstone":
                            if(counter < limit){
                                alert('É obrigatório selecionar '+limit+' heróis!');
                                return false;
                            }else{
                                return true;
                            }
                            break;
                        case "GWENT":
                            if(counter < limit){
                                alert('É obrigatório selecionar '+limit+' facções!');
                                return false;
                            }else{
                                return true;
                            }
                            break;
                        default:
                            return true;
                    }	
                }
            }
            function validar2(){
                var counter = $('.limitado2:checked').length;
                switch("<?php echo $jogo['abreviacao']; ?>"){
                    case "Hearthstone":
                        if(counter < 1){
                            alert("É obrigatório selecionar 1 herói para banir!");
                            return false;
                        }else{
                            return true;
                        }
                        break;
                    default:
                        return true;
                }
            }
            function validar3(){
                var limit = <?php echo $campeonato['jogador_por_time']; ?>;
                var counter = $('.limitado3:checked').length;
                if(counter < limit) {
                    this.checked = false;
                    $(".modal-title").html("<h3>Informações Incompletas</h3>");
					$(".modal-body").html("Para realizar esta inscrição, é necessário selecionar "+limit+" jogadores!");
					$(".modal-footer").html("<button type='button' class='btn btn-dark' data-dismiss='modal'>Ok, entendi!</button>");
					$(".modal").modal();
                    return false;
                }
                return true;
            }         
            function mudarDraftGwent(){
                $(".draft").load("ptbr/campeonatos/draft-gwent.php");
                setTimeout(function(){
                    $("#funcao").val("alterar");
                    $("#codCampeonato").val(<?php echo $campeonato['codigo']; ?>);
                }, 300)
            }
            function trocarEquipe(vagas){
                var codEquipe = $("#codEquipe").val();
                $.ajax({
                    type: "POST",
                    url: "scripts/carregar-membros-inscricao.php",
                    data: "equipe="+codEquipe+"&vagas="+vagas+"&campeonato=<?php echo $campeonato['codigo']; ?>",
                    success: function(resposta){
                        $(".passo2").html(resposta);
                        $(".passo2").css("display", "block");
                    }
                })
            }
            function enviarDeckString(){
                if($(".deckstring").val() != ""){
                    var classe = $(".deckstring").attr("class").split(" ");
                    var deckstring = $(".deckstring").val();
                    var nomeCampo = "deckstring"+classe[3];
                    $("#"+nomeCampo).val(deckstring);
                    $(".modal").modal("hide");   
                }else{
                    alert("Você deve informar o DECKSTRING");   
                }                
            }
            $(document).on('click', '.limitado', function(){		
                var limit = <?php echo $campeonato['qtd_pick']; ?>;
                var counter = $('.limitado:checked').length;
                var campo = this;
                if(counter > limit) {
                    this.checked = false;
                    alert('Só é permito selecionar '+limit+'!');
                }else{
                    if(this.checked == true){
                        if(<?php echo $campeonato['open_decklist']; ?> == 1){
                            $(document).ready(function(){
                              $(document).keydown(function(e){
                                if(e.wich == 27 || e.keyCode == 27){
                                    $(".modal").removeAttr("data-backdrop");
                                    campo.checked = false;
                                }
                              })
                            })                            
                            $(".modal-title").html("<h3>Deckstring</h3>");
                            $(".modal-body").html("Informe o Deckstring do seu baralho de  <strong>"+this.value.toUpperCase()+"</strong> para que seu baralho seja visível a todos.<br><br><input type='text' name='deckstring' class='deckstring form-control btn-dark' placeholder='Informe o Deckstring do seu baralho de "+this.value.toUpperCase()+"'>");
                            $(".modal-footer").html("<button type='button' class='btn btn-dark' onClick='enviarDeckString();'>ENVIAR</button>");
                            $(".deckstring").addClass(""+this.value+"");
                            $(".modal").attr("data-backdrop", "static");
                            $(".modal").modal();
                        }   
                    }else{
                        $("#deckstring"+this.value).val("");
                        
                    }
                }                
            });	
            $(document).on('click', '.limitado2', function(){
                var limit = 1;
                var counter = $('.limitado2:checked').length;
                if(counter > limit) {
                    this.checked = false;
                    alert('Só é permito selecionar 1 herói para banir!');
                }
            });
            $(document).on('click', '.limitado3', function(){
                var limit = <?php echo $campeonato['jogador_por_time']; ?>;
                var counter = $('.limitado3:checked').length;
                if(counter > limit) {
                    this.checked = false;
                    alert('Só é possível selecionar '+limit+' jogadores');
                }
            });
            jQuery(function($){
                $(".inscricao").addClass("ativo");
                $(".menuPrincipalHeader .campeonatos").addClass("ativo");
            });
        </script>
        
    </body>
</html>