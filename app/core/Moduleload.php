<?php
/**

 * Bagian ini digunakan untuk meregister atau meload modul - modul 
 * pada setiap parameter url yang diakses, Anda bisa memiliah dan memilih
 * modul mana saja yang akan digunakan untuk diakses pada suatu halaman,
 * setiap modul akan diakses pada setiap request seperti $this->app->get('page')
 * lalu kemudian Anda bisa memanggil nama module atau fungsi yang dibutuhkan
 * yang sudah anda tambahkan midal pada folder core, load atau public.
 * 
 


**/
class Moduleload extends Moduleparsing
{
	
	protected $app;
	protected $obj;
	protected $obj2;
	protected $themes;
	protected $crud;

	public function __construct($app, $obj, $obj2, $themes, $crud)
	{
		$this->app = $app;
		$this->obj = $obj;
		$this->obj2 = $obj2;
		$this->themes = $themes;
		$this->crud = $crud;		
	}
	
}