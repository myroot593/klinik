<?php 
class Moduleparsing extends Runadmin
{
	private $user;
	protected function getuser_data($user)
	{
		$this->user = $this->obj2->leftjoin_rolecek($user);
		return $this->user;
	}
	public function Runuser($path=null, $user)
	{
		if(!empty($this->getuser_data($user)))
		{
			switch ($this->user['role_module']){
				case 'admin':
					Moduleparsing::Moduleadmin($path, $this->user);
					break;
				case 'dokter':
					Moduleparsing::ModuleDokter($path, $this->user);
					break;
				case 'administrasi':
					Moduleparsing::ModuleAdministrasi($path, $this->user);
					break;
				default:
					echo "ROLE NOT SELECTED !";
					break;
			}
		}
	}

}