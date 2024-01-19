<?php 
class Runadministrasi extends Rundokter
{
	public function ModuleAdministrasi($path, $user)
	{
		$this->app->getEmpty('page');
		$this->themes->head($path, $this->app->get('page'));
		$this->themes->css($path);
		$this->themes->admin_nav_header($path);
		$this->themes->administrasi_sidebar($path, $user);
		switch ($this->app->get('page')) 
		{
			case 'home':
				$this->crud->pasien_table_index();
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
			case 'profile':
				$this->crud->myprofile($path, $user);
				break;	
			default:
				$this->crud->pasien_table_index();
				break;
		}
		$this->crud->modal_logout();
		$this->themes->footer($path);
		$this->crud->pasien_riwayat_ajax('../app/load/ajax/Detailriwayat.php');
	}
}