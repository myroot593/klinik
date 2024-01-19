<?php 
class Runadmin extends Runadministrasi
{
	public function Moduleadmin($path='', $user=null)
	{
		$this->app->getEmpty('page');
		$this->themes->head($path, $this->app->get('page'));
		$this->themes->css($path);
		$this->themes->admin_nav_header($path);
		$this->themes->admin_sidebar($path, $user);
		
		switch ($this->app->get('page')) 
		{
			case 'home':
				$this->crud->dashboard_test();
				break;
			case 'semua_pasien':
				$this->crud->pasien_table_index();
				break;
			case 'pasien_tambah':
				$this->crud->pasien_index();
				break;
			case 'pasien_edit':
				$this->crud->pasien_edit_index($this->app->get('pasien_id'));
				break;
			case 'pasien_delete':
				$this->crud->pasien_delete($this->app->get('pasien_id'));
				break;
			case 'pasien_riwayat':
				$this->crud->pasien_riwayat_table_index($this->app->get('pasien_id'));
				$this->crud->pasien_riwayat_modal();
				break;
			case 'pasien_riwayat_tambah':
				$this->crud->pasien_riwayat_index($this->app->get('pasien_id'));
				break;
			case 'pasien_riwayat_delete':
				$this->crud->pasien_riwayat_delete($this->app->get('riwayat_id'));
				break;
			//antrian
			case 'antrian':
				$this->crud->pasien_antrian_index();
				break;
			case 'antrian_menunggu':
				$this->crud->pasien_table_antrian_menunggu();
				break;
			case 'antrian_selesai':
				$this->crud->pasien_table_antrian_selesai();
				break;
			case 'antrian_delete':
				$this->crud->pasien_antrian_delete($this->app->get('antrian_id'));
				break;
			//role
			case 'role_tambah':
				$this->crud->role_index();
				break;
			case 'semua_role':
				$this->crud->role_table();
				break;
			case 'role_edit':
				$this->crud->role_edit_index($this->app->get('role_id'));
				break;
			case 'role_delete':
				$this->crud->role_delete($this->app->get('role_id'));
				break;
			//user
			case 'user_tambah':
				$this->crud->user_index($path);
				break;
			case 'semua_pengguna':
				$this->crud->user_table();
				break;
			case 'user_edit':
				$this->crud->user_edit_index($this->app->get('user_id'));
				break;
			case 'user_delete':
				$this->crud->user_delete($this->app->get('user_id'));
				break;
			//Profile
			case 'profile_klinik':
				$this->crud->profile_index();
				break;
			case 'profile':
				$this->crud->myprofile($path, $user);
				break;	
			
			default:
				$this->crud->dashboard_test();
				break;
		}
		$this->crud->modal_logout();
		$this->themes->footer($path);
		$this->crud->pasien_riwayat_ajax('../app/load/ajax/Detailriwayat.php');
	}
}