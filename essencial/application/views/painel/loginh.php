<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login</title>
  
  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url ('assets/bootstrap/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url ('assets/bootstrap/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
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

<body class="bg-gradient-primary">

  <div class="container col-lg-9">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-6 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <center>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"><?php echo $h2 ?></h1>
                  </div>
               		<?php 
           			if($msg = get_msg()):
           			echo '<div class="msg-boxx">'.$msg.'</div>';
           			endif;
          	 		?>
                    <div class="form-group">
                    	<?php 
            				echo form_open();
          				?>
                      <?php 
                    echo form_input('login',set_value('login'),
                    	array(
                    		'class' => 'form-control form-control-user',
                    		'id' => "exampleInputEmail",
                    		'placeholder'=>"Usuário"
                    	));
                  	?>
                    </div>
                    <div class="form-group">
                    <?php 
                    echo form_password('senha',set_value('senha'),
                    	array(
                    		'class' => 'form-control form-control-user',
                    		'id' => "exampleInputPassword",
                    		'placeholder'=>"Senha"
                    	));
                  	?>
                    </div>
        			<?php 
                    echo form_submit('logar','Entrar',
                    	array(
                    		'class' => 'btn btn-primary btn-user btn-block',
                    	));
                     echo form_close();
                  	?>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="<?php echo base_url ('login/instalar') ?>">Não possui conta? Cadastre-se!</a>
                  </div>
                </div>
              </div>
            </center>
          </div>
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
