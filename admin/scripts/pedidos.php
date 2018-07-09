<?php
    function carregarPedido($numPedido, $conexao){
        $pedido = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM pedido WHERE codigo = $numPedido"));
        $produto = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM produto WHERE codigo = ".$pedido['cod_produto']." "));
        ?>
            <div class="row">
                <div class="col-4 col-md-3">
                    <img src="../img/produtos/<?php echo $produto['codigo']; ?>/foto.png" width="100%">
                </div>
                <div class="col-8 col-md-9">
                    <h3><?php echo $produto['nome']; ?></h3>
                    <?php
                        if($pedido['data_entrega'] != NULL){
                        ?>
                            <p style="border: solid 1px #666; padding: 5px 10px; background: #f60;">CONCLUÍDO</p><br>
                            Data Pedido: <?php echo date("d/m/Y H:i", strtotime($pedido['data_pedido'])); ?> Data Pagamento: <?php echo date("d/m/Y H:i", strtotime($pedido['data_entrega'])); ?>
                        <?php
                        }else{
                        ?>
                            <p style="border: solid 1px #666; padding: 5px 10px; background: #f2f2f2; text-align:center;">EM ABERTO</p>
                            <p >
                                Data Pedido: <?php echo date("d/m/Y H:i", strtotime($pedido['data_pedido'])); ?>
                            </p>                            
                        <?php
                            if($pedido['instrucao'] != NULL){
                            ?>
                                <p >
                                    Instrução Pagamento: <?php echo $pedido['instrucao']; ?>
                                </p>
                            <?php
                            }
                        }
                    ?>
                </div>
            </div>
        <?php
    }

    function confirmarPagamento($numPedido, $conexao){
        $pedido = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM pedido WHERE codigo = $numPedido"));
        mysqli_query($conexao, "UPDATE pedido SET data_entrega = '".date("Y-m-d")."' WHERE codigo = ".$pedido['codigo']."");
    }

    if(isset($_POST['funcao'])){
        include "../conexao-banco.php";
        // 0 -> CARREGAR PEDIDO
        // 1 -> Confirmar Pagamento
        switch($_POST['funcao']){
            case 0:
                carregarPedido($_POST['numPedido'], $conexao);
                break;
            case 1:
                confirmarPagamento($_POST['numPedido'], $conexao);
                break;
        }    
    }    
?>