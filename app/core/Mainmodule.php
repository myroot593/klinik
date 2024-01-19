<?php 
class Mainmodule extends Dashboardadmin
{
	protected $obj;
	protected $obj2;
	protected $app;
	protected $upload;
	public function __construct($app, $obj, $obj2, $upload)
	{
		$this->obj=$obj;
		$this->obj2=$obj2;
		$this->app=$app;
		$this->upload = $upload;
		$this->info = self::getinfoklinik();
	}
	public function getinfoklinik()
	{
		$d = $this->obj->selectTable('profile_klinik',"klinik_id=1");
		$d->execute();
		$this->info = $d->fetch(PDO::FETCH_BOTH);
		return $this->info;
	}
}