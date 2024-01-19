<?php 
class Navadmin extends Navadministrasi
{
	public function admin_nav_header($path='')
	{
		?>
			 <!-- Navbar -->
			<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			    <!-- Left navbar links -->
			    <ul class="navbar-nav">
			      <li class="nav-item">
			        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
			      </li>
			      <li class="nav-item d-none d-sm-inline-block">
			        <a href="?page=home" class="nav-link">Home</a>
			      </li>
			      <li class="nav-item d-none d-sm-inline-block">
			        <a class="nav-link"><?=$this->app->tampilTanggal()?></a>
			      </li>
			    </ul>

			    <!-- Right navbar links -->
			    <ul class="navbar-nav ml-auto">
			     
			      <li class="nav-item">
			        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal" title="logout">
			        	<i class="fas fa-sign-out-alt"></i>
			        </a>
			      </li>
			    </ul>
				</nav>
			  <!-- /.navbar -->
		<?php 
	}
	public function admin_sidebar($path='', $user='')
	{
		?>
			<!-- Main Sidebar Container -->
			<aside class="main-sidebar sidebar-dark-primary elevation-4">
			    <!-- Brand Logo -->
			    <a href="?page=home" class="brand-link">
			      <img src="<?=$path?>content/web/<?=$this->info['klinik_logo']?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
			      <span class="brand-text font-weight-light"><?=$this->info['klinik_name']?></span>
			    </a>

			    <!-- Sidebar -->
			    <div class="sidebar">
			      <!-- Sidebar user panel (optional) -->
			      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
			        <div class="image">
			          <img src="<?=$path?>content/<?=$user['photo']?>" class="img-circle elevation-2" alt="User Image">
			        </div>
			        <div class="info">
			          <a href="#" class="d-block"><?=$user['nama_lengkap']?></a>
			          <a href="?page=profile" class="d-block">Edit</a>
			        </div>
			      </div>

			      <!-- SidebarSearch Form -->
			      <div class="form-inline">
			        <div class="input-group" data-widget="sidebar-search">
			          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
			          <div class="input-group-append">
			            <button class="btn btn-sidebar">
			              <i class="fas fa-search fa-fw"></i>
			            </button>
			          </div>
			        </div>
			      </div>

			      <!-- Sidebar Menu -->
			      <nav class="mt-2">
			        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			          <!-- Add icons to the links using the .nav-icon class
			               with font-awesome or any other icon font library -->
			          <li class="nav-item">
			            <a href="?page=home" class="nav-link active">
			              <i class="nav-icon fas fa-tachometer-alt"></i>
			              <p>
			                Dashboard
			               
			              </p>
			            </a>
			           
			          </li>
			        
			         
			            
			        <li class="nav-item">
			            <a href="#" class="nav-link">
			              <i class="nav-icon fas fa-chart-pie"></i>
			              <p>
			                Pasien
			                <i class="right fas fa-angle-left"></i>
			              </p>
			            </a>
			            <ul class="nav nav-treeview">
			              <li class="nav-item">
			                <a href="?page=semua_pasien" class="nav-link">
			                  <i class="far fa-circle nav-icon"></i>
			                  <p>Semua pasien</p>
			                </a>
			              </li>
			              <li class="nav-item">
			                <a href="?page=pasien_tambah" class="nav-link">
			                  <i class="far fa-circle nav-icon"></i>
			                  <p>Tambah pasien</p>
			                </a>
			              </li>
			             
			            </ul>
			        </li>
			        <li class="nav-item">
			            <a href="?page=antrian" class="nav-link">
			              <i class="nav-icon fas fa-copy"></i>
			              <p>
			                Antrian
			               
			              </p>
			            </a>
			        </li>
			        <li class="nav-item">
			            <a href="#" class="nav-link">
			              <i class="nav-icon fas fa-unlock-alt"></i>
			              <p>
			                Role
			                <i class="right fas fa-angle-left"></i>
			              </p>
			            </a>
			            <ul class="nav nav-treeview">
			              <li class="nav-item">
			                <a href="?page=semua_role" class="nav-link">
			                  <i class="far fa-circle nav-icon"></i>
			                  <p>Semua role</p>
			                </a>
			              </li>
			              <li class="nav-item">
			                <a href="?page=role_tambah" class="nav-link">
			                  <i class="far fa-circle nav-icon"></i>
			                  <p>Tambah role</p>
			                </a>
			              </li>
			             
			            </ul>
			        </li>
			     
			          <li class="nav-item">
			            <a href="#" class="nav-link">
			              <i class="nav-icon fas fa-users"></i>
			              <p>
			                Users
			                <i class="right fas fa-angle-left"></i>
			              </p>
			            </a>
			            <ul class="nav nav-treeview">
			              <li class="nav-item">
			                <a href="?page=semua_pengguna" class="nav-link">
			                  <i class="far fa-circle nav-icon"></i>
			                  <p>Semua pengguna</p>
			                </a>
			              </li>
			              <li class="nav-item">
			                <a href="?page=user_tambah" class="nav-link">
			                  <i class="far fa-circle nav-icon"></i>
			                  <p>Tambah pengguna</p>
			                </a>
			              </li>
			             
			            </ul>
			        </li>
			          
			        <li class="nav-header">PENGATURAN</li>
			          <li class="nav-item">
			            <a href="?page=profile_klinik" class="nav-link">
			              <i class="nav-icon fas fa-cogs"></i>
			              <p>
			                Profile Klinik
			               
			              </p>
			            </a>
			          </li>
			          
			         
			        </ul>
			      </nav>
			      <!-- /.sidebar-menu -->
			    </div>
			    <!-- /.sidebar -->
			  </aside>

					<?php 
				}
}