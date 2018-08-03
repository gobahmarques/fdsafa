<?php
	include "session.php";
	include "enderecos.php";
    $rifa = mysqli_fetch_array(mysqli_query($conexao, "
        SELECT * FROM rifa WHERE codigo = ".$_GET['rifa']."
    "));
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Nova Rifa | ADMIN eSports Cups</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="adminlte/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="adminlte/dist/css/skins/skin-blue.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="css/estrutura.css">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php
	include_once "header2.php";
  ?>  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $rifa['nome']; ?>
        <small>página de administração de rifa.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="painel/"><i class="fa fa-dashboard"></i> Home</a></li>
		  <li><a href="painel/artigos/">Artigos</a></li>
		  <li class="active">Novo Artigo</li>
      </ol>
    </section>
	  <br>
	<div class="col-md-10">
		<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">* Campos obrigatórios</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="rifas-nova-enviar.php" method="post" enctype="multipart/form-data">
				<input type="hidden" value="criar" name="funcao">
              <div class="box-body">
                <div class="form-group col-md-6">
                  <label for="exampleInputEmail1">Nome de Rifa *</label>
                  <input type="text" class="form-control" placeholder="Informe o melhor título aqui" name="nome" value="<?php echo $rifa['nome']; ?>">
                </div>
				  <div class="form-group col-md-6">
					<label for="">Data Sorteio *</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input type="date" class="form-control" name="dataSorteio" value="<?php echo date("Y-m-d", strtotime($rifa['data_sorteio'])); ?>"> 
						<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
						<input type="time" class="form-control" name="horaSorteio" value="<?php echo date("H:i", strtotime($rifa['data_sorteio'])); ?>">
					  </div>
				</div>
				<div class="form-group col-md-2">
					<label for="">Cupom em e$*</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
						<input type="text" class="form-control" name="precoCupomCoin" value="<?php echo $rifa['preco_coin']; ?>">
					  </div>
				</div>
				  
				  <div class="form-group col-md-2">
					<label for="">Cupom em R$*</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
						<input type="text" class="form-control" name="precoCupom" value="<?php echo $rifa['preco_real']; ?>">
					  </div>
				</div>
				
				  <div class="form-group col-md-2">
				  	<label for="">Min. Cupons *</label>
					  <input type="number" class="form-control" name="minCupons" value="<?php echo $rifa['min_cupom']; ?>">
				  </div>
				  <div class="form-group col-md-2">
				  	<label for="">Max. Cupons</label>
					  <input type="number" class="form-control" name="maxCupons" value="<?php echo $rifa['max_cupom']; ?>">
				  </div>
				  <hr>
				  
				  <div class="form-group col-md-4">
				  	<label for="">Nome do Produto *</label>
					  <input type="text" class="form-control" placeholder="Informe o nome do produto a ser sorteado" name="nomeProduto" value="<?php echo $rifa['nome_produto']; ?>">
				  </div>
				  <div class="form-group col-md-6">
				  	<label for="">Link Produto</label>
					  <input type="text" class="form-control" placeholder="Link Web do produto" name="linkProduto" value="<?php echo $rifa['link_produto']; ?>">
				  </div>
				  <div class="form-group col-md-2">
				  	<label for="">Preço Produto *</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
						<input type="text" class="form-control" name="precoProduto" value="<?php echo $rifa['preco_produto']; ?>">
					  </div>
				  </div>
				  <div class="form-group col-md-4">
					  <label for="exampleInputFile">Foto Produto</label>
					  <input type="file" id="exampleInputFile" name="thumb">

					  <p class="help-block">Tamanho obrigatório: 750px x 750px; Fundo Transparente e PNG</p>
					</div>
				  <div class="col-md-12">
				      <div class="with-border">
                          <?php
                            $cupons = mysqli_query($conexao, "SELECT * FROM rifa_cupom WHERE cod_rifa = ".$rifa['codigo']." ORDER BY codigo");
                            echo "Cupons (".mysqli_num_rows($cupons).")<br>";
                            while($cupom = mysqli_fetch_array($cupons)){
                                $jogador = mysqli_fetch_array(mysqli_query($conexao, "SELECT nome, sobrenome, nick, foto_perfil FROM jogador WHERE codigo = ".$cupom['cod_jogador'].""));
                                ?>
                                    <div class="cupom-rifa">
                                        <img src="../img/<?php echo $jogador['foto_perfil']; ?>" alt="<?php echo $jogador['nome']." '".$jogador['nick']."' ".$jogador['sobrenome']; ?>" title="<?php echo $jogador['nome']." '".$jogador['nick']."' ".$jogador['sobrenome']; ?>">
                                        <?php echo $cupom['codigo']; ?>
                                    </div>
                                <?php
                            }
                          ?>
                      </div>
				  </div>
                  
                  <div class="col-md-12">
				  	<div class="box-footer">
						<button type="submit" class="btn btn-primary">Enviar</button>
					  </div>
				  </div>
				  
				</div>
            </form>
          </div>  
	</div> 
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2016 <a href="#">Company</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="pull-right-container">
                    <span class="label label-danger pull-right">70%</span>
                  </span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="adminlte/dist/js/adminlte.min.js"></script>
	<script src="js/ckeditor/ckeditor.js"></script>
<script>
	$(function () {
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace('editor1')
		//bootstrap WYSIHTML5 - text editor
		$('.textarea').wysihtml5()
	  })
</script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>