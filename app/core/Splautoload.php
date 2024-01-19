<?php
/**
	* File ini merupakan bagian fungsi untuk meload file - file / module aplikasi,
	* dan ini merupakan bagian penyederhanaan untuk penggunaan require once
	* yang terlihat agak sedikit kurang epektif, karena kita harus mengulang
	* - ngulang perintah tersebuh saat ingin memanggil suatu module.
	* Sehingga dengan menggunakan spl_auto_load_register, fungsi pemanggilan
	* file akan disederhanakan, namun setiap module perlu dikelompokan kedalam class
	* dimana setiap kelas perlu diberi nama yang sama dengan nama filenya.
	* Ketika class dicetak ke objek, maka secara otomatis file berdasarkan nama class
	* akan dipanggil.
	* Anda bisa bermain dengan banyak file pada direktori yang berbeda, Anda hanya cukup
	* membuat fungsinya, dan mengatur dimana letak/path module yang ingin Anda gunakan
	* 
	* Anda juga bisa membuat auto loader ini bekerja sebagai sebuah kelas, dalam auto loader
	* Anda hanya perlu menuliskannya seperti berikut 
	* spl_autoload_register(array('namaclass','nama_method'))
	* atau Anda membuat daftar path module didalam array dengan looping.
	* Contoh :
**/
	
		spl_autoload_register(function($className)
		{

			$list_direktori = array
			(
				'/',
				'/../../database/',			
				'/../load/',
				'/../auth/',
				'/../load/admin/',
				'/../load/administrasi/',
				'/../load/dokter/',
				'/../auth/',
				

			);
			foreach($list_direktori as $list)
			{
				if(is_readable(__DIR__.$list.$className.'.php'))			{
		
					require_once(__DIR__.$list.$className.'.php');
				}
				
			}

		});

$db = new Database($databases);
$handler = new Auth($databases);
$obj = new Apps($databases);
$obj2 = new Appscostum($databases);
$app = new Property;
$upload = new Uploadclass;
$themes = new Template($app, $obj);
$crud = new Mainmodule($app, $obj, $obj2, $upload);
$login = new Loginclass($app,$obj, $obj2);
$module = new Moduleload($app, $obj, $obj2, $themes,$crud);