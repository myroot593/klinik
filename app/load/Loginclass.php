<?php 
class Loginclass
{
	protected $obj;
	protected $obj2;
	protected $app;
	public $err;
	public $success;

	public function __construct($app, $obj, $obj2)
	{
		$this->obj=$obj;
		$this->obj2 = $obj2;
		$this->app=$app;
		$this->info = self::getinfoklinik();
	}
	public function getinfoklinik()
	{
		$d = $this->obj->selectTable('profile_klinik',"klinik_id=1");
		$d->execute();
		$this->info = $d->fetch(PDO::FETCH_BOTH);
		return $this->info;
	}

	public function loginheader($path='themes/adminlte')
	{
		?>
		<!DOCTYPE html>
			<html lang="en">
			<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title><?=$this->info['klinik_name']?> | Login</title>
			<link rel="icon" href="content/web/<?=$this->info['klinik_icon']?>">
			<meta name="description" content="<?=$this->info['klinik_description']?>" />	

		  <!-- Google Font: Source Sans Pro -->
		  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		  <!-- Font Awesome -->
		  <link rel="stylesheet" href="<?=$path?>/plugins/fontawesome-free/css/all.min.css">
		  <!-- icheck bootstrap -->
		  <link rel="stylesheet" href="<?=$path?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
		  <!-- Theme style -->
		  <link rel="stylesheet" href="<?=$path?>/dist/css/adminlte.min.css">
		</head>
		<body class="hold-transition login-page">
		<?php 
	}
	public function loginfooter($path='themes/adminlte')
	{
		?>
			<!-- jQuery -->
			<script src="<?=$path?>/plugins/jquery/jquery.min.js"></script>
			<!-- Bootstrap 4 -->
			<script src="<?=$path?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
			<!-- AdminLTE App -->
			<script src="<?=$path?>/dist/js/adminlte.min.js"></script>
			</body>
			</html>

		<?php
	}
	public function loginform()
	{
		?>

				<div class="login-box">
				  <!-- /.login-logo -->
				  <div class="card card-outline card-primary">
				    <div class="card-header text-center">
				      <a href="#" class="h1"><b>Klinik</b> Ansena</a>
				    </div>
				    <div class="card-body">
				      <p class="login-box-msg">Sign in to start your session</p>

				      <form action="<?php htmlentities($_SERVER['PHP_SELF'])?>" method="post">
				        <div class="input-group mb-3">
				          <input type="email" name="email" class="form-control" placeholder="Email">
				          <div class="input-group-append">
				            <div class="input-group-text">
				              <span class="fas fa-envelope"></span>
				            </div>
				          </div>
				        </div>
				        <div class="input-group mb-3">
				          <input type="password" name="password" class="form-control" placeholder="Password">
				          <div class="input-group-append">
				            <div class="input-group-text">
				              <span class="fas fa-lock"></span>
				            </div>
				          </div>
				        </div>
				        <div class="row">
				          
				          <div class="col-4">
				            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
				          </div>
				        
				        </div>
				      </form>

				      <div class="social-auth-links text-center mt-2 mb-3">
				       	<?php

				       		echo $this->success;					     
		                      if(count($this->err)>0)
		                      {
		                        $this->app->getError($this->err);
		                      }
				       	?>
				      </div>
				      <!-- /.social-auth-links -->

				      <p class="mb-1">
				        <a href="forgot-password.html">I forgot my password</a>
				      </p>
				      <p class="mb-0">
				        <a href="register.html" class="text-center">Register a new membership</a>
				      </p>
				    </div>
				    <!-- /.card-body -->
				  </div>
				  <!-- /.card -->
				</div>
		<?php 
	}
	public function loginproses()
	{
		$this->err = array();
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			
			if(empty($this->app->post('email')))
			{
				array_push($this->err, "Email tidak boleh kosong");
			}
			else
			{
				$email = $this->app->post('email');

			}
			if(empty($_POST['password']))
			{
				array_push($this->err, "Password tidak boleh kosong");
			}
			else
			{
				$password = $_POST['password'];
			}
			if(count($this->err)==0)
			{
				if($this->obj2->loginAuth($email, $password,'users','email'))
				{
					$this->success = $this->app->alert('success','Login berhasil');
					$_SESSION['user_id']=$this->obj2->user_id;
					$_SESSION['created']=time();
					$this->app->reload(3,'user/?page=home');
				}
				else
				{
					$this->success = $this->app->alert('danger','Gagal melakukan login');
					$this->app->noresubmit();
				}
			}
			else
			{
				$this->app->noresubmit();
			}
		}
	}
	public function login_index()
	{
		Loginclass::loginheader();
		Loginclass::loginproses();
		Loginclass::loginform();
		Loginclass::loginfooter();
	}
	public function __destruct()
	{
		return true;
	}
}
