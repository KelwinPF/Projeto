<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Colaboradores</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url ('assets/bootstrap/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">

  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url ('assets/bootstrap/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url ('assets/bootstrap/css/pagination.css'); ?>" rel="stylesheet">
   <style type="text/css">
.msg-boxx{
  background: #f1f2ea;
  border:1px solid #c7cbab;
  padding: 5px 5px;
  margin-bottom:15px;
  color:#727272;
}
.msg-boxx p{
  margin: 0;
  padding:2px 0;
}

 </style>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url('painel/home'); ?>">
        <div class="sidebar-brand-text mx-3">Cerberus</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('painel/home'); ?>">
         <i class="fas fa-fw fa-chart-area"></i>
          <span>Inicio</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Sistema
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-table"></i>
          <span>Empresas</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Alterar Empresas</h6>
            <a class="collapse-item" href="<?php echo base_url('empresas/inserir'); ?>">Inserir</a>
            <a class="collapse-item" href="<?php echo base_url('empresas/listar/all'); ?>">Listar</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-user fa-fw"></i>
          <span>Colaboradores</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Alterar Colaboradores:</h6>
            <a class="collapse-item" href="<?php echo base_url('colaboradores/inserir'); ?>">Inserir</a>
            <a class="collapse-item" href="<?php echo base_url('colaboradores/listar/all'); ?>">Listar</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>


            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $User; ?></span>
                <img class="img-profile rounded-circle" src="<?php echo base_url ('assets/bootstrap/img/user.png');?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?php echo base_url('painel/perfil'); ?>">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Perfil
                </a>
                <a class="dropdown-item" href="<?php echo base_url('painel/configuracoes'); ?>">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Alterar Email
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Colaboradores - Listagem de Colaboradores</h1>
          <hr>
          <?php
          echo form_open();
          ?>
          <div class="form-group row">
                  <div class="col-sm-2">
                    <a href="<?php echo base_url('colaboradores/inserir'); ?>" class="btn btn-primary btn-user btn-block">
                      Novo Colaborador
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <?php 
                    echo form_submit('pdf','Gerar PDF',
                      array(
                        'class' => 'btn btn-primary btn-user btn-block',
                      ));
                    ?>
                  </div>
                   <div class="col-sm-2">
                    <?php 
                    echo form_submit('pdfm','Gerar PDF (Mulher)',
                      array(
                        'class' => 'btn btn-primary btn-user btn-block',
                      ));
                    ?>
                  </div>
                   <div class="col-sm-2">
                  </div>
                  <div class="col-sm-4 float-right">
                  <div class="input-group">
                  <?php
                    echo form_input('pesquisarr',set_value('pesquisarr'),
                      array(
                        'class' => 'form-control form-control-user',
                        'id' => "exampleInputPassword",
                        'placeholder'=>" "
                      ));
                    ?>
                  <div class="input-group-append">
                    <?php 
                    echo form_submit('pesquisar','pesquisar',
                      array(
                        'class' => 'btn btn-primary',
                        'Type' => 'button',
                      ));
                    ?>
                    </button>
                  </div>
                  </div>
                </div>
                </div>
                <?php
                 echo form_close();
                ?>
                <hr>
                 <?php 
                  if($msg = get_msg()):
                 echo '<div class="msg-boxx">'.$msg.'</div>';
                endif;
                  ?>
          <?php if(isset($Colaboradores) && sizeof($Colaboradores)>0):
            ?>
            <div class="card shadow mb-4">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead class="card-header py-3">
                    <tr>
                      <th>Nome</th>
                      <th>CPF</th>
                      <th>Email</th>
                      <th>Sexo</th>
                      <th>Empresa</th>
                      <th>Visualizar</th>
                      <th>Editar</th>
                      <th>Excluir</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    foreach ($Colaboradores as $linha): 
                    ?>
                      <tr>
                      <td><?php echo $linha->colaborador_nome; ?></td>
                      <td><?php echo $linha->CPF; ?></td>
                      <td><?php echo $linha->email; ?></td>
                      <td><?php echo $linha->sexo; ?></td>
                      <td><?php echo $linha->empresa_nome; ?></td>
                      <td><center><a class="btn btn-info btn-circle btn-sm" href="<?php echo base_url('colaboradores/visualizar/'.$linha->id_colaborador); ?>"><i class="fas fa-eye"></i></a></center></td>
                      <td><center><a class="btn btn-warning btn-circle btn-sm" href="<?php echo base_url('colaboradores/editar/'.$linha->id_colaborador); ?>"><i class="fas fa-pen"></i></a></center></td>                      
                        <div class="modal fade" id="<?=$linha->colaborador_nome; ?>excluirModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Realmente deseja Excluir?</h5>
                              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div class="modal-body"><?php echo "Colaborador: ".$linha->colaborador_nome ?></div>
                            <div class="modal-footer">
                              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                              <a class="btn btn-primary" href = "<?php echo base_url('colaboradores/excluir/'.$linha->id_colaborador); ?>">Excluir</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <td><center><a class="btn btn-danger btn-circle btn-sm" href="<?php echo base_url('colaboradores/excluir/'.$linha->id_colaborador); ?>" data-toggle="modal" data-target="#<?=$linha->colaborador_nome; ?>excluirModal"><i class="fas fa-trash"></i></a></center></td>
                      </tr>
                    <?php 
                    endforeach;
                    ?>
                  </tbody>
                </table>
                <center>
                <?php
                if($Paginacao):
                    echo $Paginacao;
                endif;
                ?>
              </center>
                </div>
              </div>
            </div>
          </div>
           <?php
          else:
              echo "Nenhum Colaborador Encontrado";
              echo '</div>';
           ?>

           <?php
                endif;
           ?>

      </div>
            <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Cerberus 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Main Content -->
    </div>
      <!-- Footer -->
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  
  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Realmente deseja Sair?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Selecione Logout caso realmente queira sair</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary" href="<?php echo base_url('painel/logout'); ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
 <script src="<?php echo base_url ('assets/bootstrap/vendor/jquery/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url ('assets/bootstrap/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url ('assets/bootstrap/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url ('assets/bootstrap/js/sb-admin-2.min.js'); ?>"></script>

</body>

</html>
