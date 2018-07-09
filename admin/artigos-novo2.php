<?php
	include "session.php";
	include "enderecos.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Novo Artigo | ADMIN eSports Cups</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="adminlte/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="adminlte/dist/css/skins/skin-blue.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
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
        Novo Artigo
        <small>Sua criatividade é o limite.</small>
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
              <h3 class="box-title">Criar novo artigo</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="artigos-novo-enviar.php" method="post" enctype="multipart/form-data">
				<input type="hidden" value="criar" name="funcao">
              <div class="box-body">
                <div class="form-group col-md-7">
                  <label for="exampleInputEmail1">Título do Artigo</label>
                  <input type="text" class="form-control" placeholder="Informe o melhor título aqui" name="nome">
                </div>
				<div class="form-group col-md-2">
					<label for="">Código Autor</label>
					<input type="text" class="form-control" placeholder="Informe o código do Autor do artigo" name="codautor">
				</div>
				<div class="form-group col-md-3">
					<label for="">Categoria</label>
					<select name="codjogo" id="" class="form-control">
						<option value="" hidden>SELECIONE A CATEGORIA</option>
						<option value="0">Plataforma</option>
						<?php
							$jogos = mysqli_query($conexao, "SELECT * FROM jogos ORDER BY nome");
							while($jogo = mysqli_fetch_array($jogos)){
							?>
								<option value="<?php echo $jogo['codigo']; ?>"><?php echo $jogo['nome']; ?></option>
							<?php
							}
						?>
					</select>
				</div>
				  <div class="col-md-12 form-group">
				  	<label for="">Descrição para compartilhamento</label>
					  <textarea rows="5" cols="80" class="form-control" name="descricao"></textarea>
				  </div>
				  <div class="col-md-12 form-group">
				  	<label for="">Artigo</label>
					  <textarea id="editor1" name="artigo" rows="10" cols="80"></textarea>
				  </div>
				  <div class="form-group col-md-6">
					  <label for="exampleInputFile">Thumbnail</label>
					  <input type="file" id="exampleInputFile" name="thumb">

					  <p class="help-block">Tamanho obrigatório: 1200px x 650px</p>
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