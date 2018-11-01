<?php
	include "session.php";
	include "enderecos.php";    
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rifas | ADMIN eSports Cups</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="adminlte/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="adminlte/dist/css/skins/skin-blue.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">
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
        Rifas eSC
        <small>Área de administração de Rifas</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
		<div class="box box-info">
            <!-- /.box-header -->
			<div class="box-footer clearfix">
              <a href="painel/rifas/nova/" class="btn btn-sm btn-info btn-flat pull-right">Nova Rifa</a>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Código</th>
                    <th>Rifa</th>
                    <th>Min / Max</th>
                    <th>Cupons Vendidos</th>
					<th>Data Sorteio</th>
                    <th>Status</th>
                    <th class="text-right">Ações</th>
                  </tr>
                  </thead>
                  <tbody>
					<?php
						$rifas = mysqli_query($conexao, "SELECT * FROM rifa ORDER BY codigo DESC");
					  	while($rifa = mysqli_fetch_array($rifas)){
							$totalCupons = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM rifa_cupom WHERE cod_rifa = ".$rifa['codigo'].""));
							?>
					  			<tr>
					  				<td><?php echo $rifa['codigo']; ?></td>
									<td><?php echo $rifa['nome']; ?></td>
									<td>
									<?php echo $rifa['min_cupom']." / ".$rifa['max_cupom']; ?>
									</td>									
									<td>
										<div class="progress-group">
											<?php
												if($totalCupons < $rifa['min_cupom']){
													$porcentagem = ($totalCupons * 100) / $rifa['min_cupom'];
												?>
													<span class="progress-text">Min. Cupons</span>
													<span class="progress-number"><?php echo $totalCupons." / ".$rifa['min_cupom']; ?></span>
													<div class="progress sm">
														<div class="progress-bar progress-bar-red" style="width: <?php echo $porcentagem; ?>%;"></div>
													</div>
												<?php
												}else{
													$porcentagem = ($totalCupons * 100) / $rifa['max_cupom'];
												?>
													<span class="progress-text">Max. Cupons</span>
													<span class="progress-number"><?php echo $totalCupons." / ".$rifa['max_cupom']; ?></span>
													<div class="progress sm">
														<div class="progress-bar progress-bar-green" style="width: <?php echo $porcentagem; ?>%;"></div>
													</div>
												<?php	
												}
											?>
											
										</div>
									</td>
									<td><?php echo date("d/m/Y H:i", strtotime($rifa['data_sorteio'])); ?></td>
                                    <td>
                                    <?php
                                        switch($rifa['status']){
                                            case 0:
                                                echo "Desativada";
                                                break;
                                            case 1:
                                                echo "Ativa";
                                                break;
                                            case 2:
                                                echo "Cancelada";
                                                break;
                                        }
                                    ?>
                                    </td>
                                    <td class="text-right">
                                        <a href="painel/rifa/<?php echo $rifa['codigo']; ?>/"><button type="button" class="btn btn-primary"><i class="fas fa-eye"></i></button></a>
                                    </td>
					  			</tr>
					  		<?php
						}
					?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->            
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
    </section>
    <!-- /.content -->
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

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>