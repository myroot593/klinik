<?php 
class Pasiencreate extends Pasienantrian
{
	public $success;
  public $err;
  public function pasien_tambah()
	{
		?>
			 <!-- general form elements -->

            <div class="card card-primary">              
              <div class="card-header">
                <h3 class="card-title">Tambah pasien</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
               

              <form action="<?php htmlentities($_SERVER['REQUEST_URI'])?>" method="post">
                <div class="card-body">
                   <?php 
                      if(count($this->err)>0)
                      {
                        $this->app->getError($this->err);
                      }
                  ?>
                  <?=$this->success?>
                  <div class="form-group">
                    <label>NIK</label>
                    <input type="text" name="nik" class="form-control" value="<?=rand(3000000000000000,4000000000000000)?>" placeholder="Masukan nomor induk kependudukan">
                  </div>
                  <div class="form-group">
                    <label>Nama lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukan nama lengkap">
                  </div>
                  <div class="form-group">
                    <label>Alamat lengkap</label>
                    <textarea class="form-control" name="alamat" rows="5"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Kontak</label>
                    <input type="text" name="kontak" class="form-control" placeholder="Masukan nomor kontak / whatsapp">
                  </div>              
                 

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
              </form>
            </div>
            <!-- /.card -->
		<?php 
	}
	public function pasien_proses()
	{
    $this->err = array();

    if($_SERVER['REQUEST_METHOD']=='POST')
    {
      if(empty($this->app->post('nik')))
      {
        array_push($this->err,"NIK Wajib diisi");
      }
      else
      {
        $nik = $this->app->post('nik');
      }
      if(empty($this->app->post('nama_lengkap')))
      {
        array_push($this->err,"Nama lengkap Wajib diisi");
      }
      else
      {
        $nama = $this->app->post('nama_lengkap');
      }
      if(empty($this->app->post('alamat')))
      {
        array_push($this->err,"Alamat wajib disisi");
      }
      else
      {
        $alamat = $this->app->post('alamat');
      }

      if(empty($this->app->post('kontak')))
      {
        array_push($this->err,"Kontak Wajib diisi");
      }
      else
      {
        $kontak = $this->app->post('kontak');
      }
      if(count($this->err)==0)
      {
        if($this->obj->insertTable('pasien','pasien_nik, pasien_nama, pasien_alamat, pasien_kontak',
          ':pasien_nik,:pasien_nama,:pasien_alamat, :pasien_kontak',
          array(
            ":pasien_nik"=>$nik,
            ":pasien_nama"=>$nama,
            ":pasien_alamat"=>$alamat,
            ":pasien_kontak"=>$kontak
          )

          ))
        {
          $this->success = $this->app->alert('success','Data berhasil disimpan');
          $this->app->reload(3);
        }
        else
        {
          $this->success = $this->app->alert('danger','Data gagal disimpan');
          $this->app->reload(3);
        }
      }
    }
	}
	public function pasien_index()
	{
		?>
			<div class="content-wrapper">
				<?=$this->app->bread('Tambah Pasien','Home','?page=home')?>
				<section class="content">
			      <div class="container-fluid">
			        <div class="row">
			        	<div class="col-md-12">
				        	<?=Pasiencreate::pasien_proses()?>
				        	<?=Pasiencreate::pasien_tambah()?>
				        </div>
			        </div>
			      </div>
			    </section>
			</div>
		<?php 
	}
  public function pasien_table()
  {
      ?>
          <?php
            $this->err = array();

            if(isset($_POST['tambah_antrian']))
            {
              if(empty($_POST['pasien_id']))
              {
                array_push($this->err,'Harap pilih data yang ingin ditambahkan ke dalam antrian');
              }
              else
              {
                 $antrian = $_POST['pasien_id'];
              }
              if(count($this->err)==0):   
                    foreach ($antrian as $data) {
                      if($this->obj->insertTable('pasien_antrian','antrian_nomor, pasien_id',':antrian_nomor, :pasien_id',

                          array(

                            ":antrian_nomor"=>$this->obj2->buatAntrian(),
                            ":pasien_id"=>$data
                          )



                          ))
                      {
                        $this->success = $this->app->alert('alert alert-success','Antrian berhasil ditambahkan');
                      }
                      else
                      {
                        $this->success = $this->app->alert('alert alert-danger','Antrian gagal ditambahkan');
                      }
                    }
              endif;
            }
            
          ?>
     
           <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data semua pasien</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?=$this->app->getError($this->err)?>
                <?=$this->success?>
                <form action="<?php $_SERVER['REQUEST_URI']?>" method="post">
                  <div class="row">
                    <div class="form-group col-md-6">
                      <button class="btn btn-primary btn-xs" name="tambah_antrian">Tambah ke antrian</button>
                      
                    </div>
                  </div>
                  <table id="example2" class="table table-bordered table-sm">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>NIK</th>
                      <th>Nama Lengkap</th>
                      <th>Alamat</th>
                      <th>Kontak</th>
                      <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>

                      <?php 
                          $no = 1;
                          $data = $this->obj->pagination('halaman','pasien',10,NULL,'ORDER by pasien_id DESC');
                          $data->execute();
                          while($row=$data->fetch(PDO::FETCH_BOTH))
                          {
                      ?>
                       
                        <tr>
                         <td><input type="checkbox" name="pasien_id[]" value="<?=$row['pasien_id']?>"></td>
                          <td><?=$row['pasien_nik']?></td>
                          <td><?=$row['pasien_nama']?></td>
                          <td><?=$row['pasien_alamat']?></td>
                          <td><?=$row['pasien_kontak']?></td>
                          <td>
                              <span class="badge bg-danger"><a href="?page=pasien_edit&pasien_id=<?=$row['pasien_id']?>">Edit</a></span>
                              
                              <span class="badge bg-primary"><a href="?page=pasien_delete&pasien_id=<?=$row['pasien_id']?>">Delete</a></span>
                              <span class="badge bg-success"> <a href="?page=pasien_riwayat&pasien_id=<?=$row['pasien_id']?>">Riwayat</i></a></span>                    
                             
                             
                              
                          </td>
                        </tr>
                      <?php $no+=1; } ?>
                      

                   </tbody>
                  </table>
                </form>
              </div>
              <!-- /.card-body -->
               <?php 
                $this->obj->paginationNumberBootstrap('pasien',10,'page=semua_pasien','halaman');
              ?>
            </div>
         
      <?php 
  }
  public function pasien_table_index()
  {
    ?>
       <div class="content-wrapper">
            <?=$this->app->bread('Semua Pasien','Home','?page=home')?>
            <section class="content">
                <div class="container-fluid">
                  <?=Pasiencreate::pasien_table()?>
                </div>
            </section>
      </div>

    <?php 
  }
  public function pasien_edit($data)
  {
    ?>
       <?php 
        $this->err = array();
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
          $nik = $this->app->post('nik');
          $nama = $this->app->post('nama_lengkap');
          $alamat = $this->app->post('alamat');
          $kontak = $this->app->post('kontak');
          if($this->obj->updateTable('pasien',
            'pasien_nik=:pasien_nik,
            pasien_nama=:pasien_nama,
            pasien_alamat=:pasien_alamat,
            pasien_kontak=:pasien_kontak
            ','pasien_id=:pasien_id',
            array(
            ":pasien_nik"=>$nik,
            ":pasien_nama"=>$nama,
            ":pasien_alamat"=>$alamat,
            ":pasien_kontak"=>$kontak,
            ":pasien_id"=>$data['pasien_id']
           )


            ))
          {
            $this->success = $this->app->alert('success','Data berhasil disimpan');
            $this->app->reload(3,'?page=semua_pasien');
          }
          else
          {
            $this->success = $this->app->alert('danger','Data gagal disimpan');
            $this->app->reload(3,'?page=semua_pasien');
          }
        }
       ?>
       <!-- general form elements -->

            <div class="col-md-12">
            <div class="card card-primary">              
              <div class="card-header">
                <h3 class="card-title">Edit pasien</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
               

              <form action="<?php htmlentities($_SERVER['REQUEST_URI'])?>" method="post">
                <div class="card-body">
                   <?php 
                      if(count($this->err)>0)
                      {
                        $this->app->getError($this->err);
                      }
                  ?>
                  <?=$this->success?>
                  <div class="form-group">
                    <label>NIK</label>
                    <input type="text" name="nik" class="form-control" value="<?=$data['pasien_nik']?>" placeholder="Masukan nomor induk kependudukan">
                  </div>
                  <div class="form-group">
                    <label>Nama lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?=$data['pasien_nama']?>" placeholder="Masukan nama lengkap">
                  </div>
                  <div class="form-group">
                    <label>Alamat lengkap</label>
                    <textarea class="form-control" name="alamat" rows="5"><?=$data['pasien_alamat']?></textarea>
                  </div>
                  <div class="form-group">
                    <label>Kontak</label>
                    <input type="text" name="kontak" class="form-control" value="<?=$data['pasien_kontak']?>" placeholder="Masukan nomor kontak / whatsapp">
                  </div>              
                 

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
              </form>
            </div>
          </div>
            <!-- /.card -->
    <?php 
  }
  public function pasien_edit_index($get)
  {
    ?>
        <div class="content-wrapper">
          <?=$this->app->bread('Edit Pasien','Home','?page=home')?>
          <section class="content">
              <div class="container-fluid">
                <div class="row">
                 <?php
                    if(!$this->obj->getTable('pasien','pasien_id=:pasien_id',$get,'pasien_id'))
                    {
                      echo "<div class='col-md-12'>".$this->app->alert('danger','Data tidak ditemukan')."</dic>";
                    }
                    else
                    {
                      Pasiencreate::pasien_edit($this->obj->row);
                    }
                  ?>
                </div>
              </div>
            </section>
      </div>
    <?php 
  }
  public function pasien_delete($get)
  {
    ?>
        <div class="content-wrapper">
          <?=$this->app->bread('Delete Pasien','Home','?page=home')?>
          <section class="content">
              <div class="container-fluid">
                <div class="row">
                 <?php
                    if(!$this->obj->getTable('pasien','pasien_id=:pasien_id',$get,'pasien_id'))
                    {
                      echo "<div class='col-md-12'>".$this->app->alert('danger','Data tidak ditemukan')."</dic>";
                    }
                    else
                    {
                      if($this->obj->delete('pasien','pasien_id=:pasien_id','pasien_id', $this->obj->row['pasien_id']))
                      {
                        echo $this->app->alert('success col-md-12','Data berhasil dihapus');
                        $this->app->reload(3,'?page=semua_pasien');

                      }
                      else
                      {
                         echo $this->app->alert('danger col-md-12','Data gagal dihapus');
                        $this->app->reload(3,'?page=semua_pasien');
                      }
                    }
                  ?>
                </div>
              </div>
            </section>
      </div>
    <?php 
  }
}