<!DOCTYPE html>
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
.header {
  overflow: hidden;
  background-color: white;
  padding: 20px 10px;
}
 </style>
</head>
<div class="header">
  <div class="text-center"><img src="<?php echo base_url ('assets/bootstrap/img/icon.png'); ?>" alt="icon" width=50 height=50><h1 class="sidebar-brand-text mx-3">Cerberus</h1></div>
</div>
<center><h3 class="sidebar-brand-text mx-3">Listagem de Colaboradoras</h3></center>
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
                      </tr>
                    <?php 
                    endforeach;
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <?php
          else:
              echo "Nenhuma colaboradora encontrada";
          endif;
          date_default_timezone_set('America/Sao_Paulo');
           ?>
          <footer>
          <div class="text-right">PDF Criado em: <?php echo date('d/m/Y - H:i:s'); ?></div>
          </footer>
          </html>