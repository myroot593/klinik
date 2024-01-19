<?php 
class Pasienantrian extends Pasiendetail
{
  public function pasien_table_antrian()
  {
      ?>
         
     	<?php 
     		$this->err = array();

     		if(isset($_POST['selesaikan_antrian']))
     		{
     			if(empty($_POST['antrian_id']))
     			{
     				array_push($this->err, "Harapa pilih antrian yang akan diselesaikan !");
     			}
     			else
     			{
     				$data = $_POST['antrian_id'];
     			}
     			if(count($this->err)==0)
     			{
     				foreach($data as $antrian)
     				{
     					if($this->obj->updateTable('pasien_antrian','antrian_status=:antrian_status','antrian_id=:antrian_id',

     						array(

     							":antrian_status"=>'Selesai',
     							":antrian_id"=>$antrian
     						)

     					))
     					{
     						$this->success = $this->app->alert('alert alert-success','Antrian berhasil diselesaikan');
     						$this->app->reload(3);
     					}
     					else
     					{
     						$this->success = $this->app->alert('alert alert-danger','Antrian gagal diselesaikan');
     					}
     				}
     			}
     		}
     		if(isset($_POST['reset_antrian']))
     		{
     			($this->obj2->truncateTable('pasien_antrian'))

     			?
     			$this->success = $this->app->alert('alert alert-success','Antrian berhasil direset')
     			:
     			$this->success = $this->app->alert('alert alert-danger','Antrian gagal direset');   			
     		}

     	?>
           <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data semua antrian</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              	<form action="<?php $_SERVER['REQUEST_URI']?>" method="post">
                  <div class="row">
                    <div class="form-group col-md-6">
                      <button class="btn btn-primary btn-xs" name="selesaikan_antrian">Selesaikan antrian</button>
                      <button class="btn btn-danger btn-xs" name="reset_antrian">Reset antrian</button>
                      <a class="btn btn-primary btn-xs" href="?page=antrian_menunggu">Antrian menunggu</a>
                       <a class="btn btn-primary btn-xs" href="?page=antrian_selesai">Antrian selesai</a>   

                    </div>
                  </div>
                  	<?=$this->app->getError($this->err)?>
	                <?=$this->success?> 
	                <table id="example2" class="table table-bordered table-striped">
	                    <thead>
	                    <tr>
	                     <th>#</th>
	                      <th>No. Antrian</th>
	                      <th>Nama Pasien</th>
	                      <th>Aksi</th>
	                    
	                    </tr>
	                    </thead>
	                    <tbody>

	                      <?php 
	                          $no = 1;
	                          $data = $this->obj->pagination('halaman','pasien_antrian',20,NULL,'ORDER by antrian_id DESC');
	                          $data->execute();
	                          while($row=$data->fetch(PDO::FETCH_BOTH))
	                          {
	                      ?>
	                       
	                        <tr>
	                        	<td><input type="checkbox" name="antrian_id[]" value="<?=$row['antrian_id']?>"></td>
	                         	<td><?=$row['antrian_nomor']?></td>
	                         	<td><?=$this->obj2->readId('pasien_nama', 'pasien', 'pasien_id', $row['pasien_id'])?></td>
	                         	<td>
	                         		 <span class="badge bg-primary"><a href="?page=antrian_delete&antrian_id=<?=$row['antrian_id']?>">Delete</a></span>
	                         		   <span class="badge bg-warning"> <a href="?page=pasien_riwayat&pasien_id=<?=$row['pasien_id']?>" target="_blank">Riwayat</i></a></span>  
	                         		 	<?php 
		                         		  	if($row['antrian_status']=='Menunggu')
		                         		  	{
		                         		  		echo '<span class="badge bg-danger">Menunggu</span>';
		                         		  	}
		                         		  	else{
		                         		  		echo '<span class="badge bg-success">Selesai</span>';
		                         		  	}  
	                         		  	?> 
	                         	</td>
	                        </tr>
	                      <?php $no+=1; } ?>
	                      

	                   </tbody>
	                </table>
	            </form>
             
              </div>
              <!-- /.card-body -->
               <?php 
                $this->obj->paginationNumberBootstrap('pasien_antrian',20,'page=antrian','halaman');
              ?>
            </div>
         
      <?php 
  }
  public function pasien_antrian_index()
  {
    ?>
       <div class="content-wrapper">
            <?=$this->app->bread('Semua Antrian','Home','?page=home')?>
            <section class="content">
                <div class="container-fluid">
                  <?=Pasienantrian::pasien_table_antrian()?>
                </div>
            </section>
      </div>
    <?php 
  }
  public function pasien_antrian_delete($get)
  {
    ?>
        <div class="content-wrapper">
          <?=$this->app->bread('Delete Antrian','Home','?page=home')?>
          <section class="content">
              <div class="container-fluid">
                <div class="row">
                 <?php
                    if(!$this->obj->getTable('pasien_antrian','antrian_id=:antrian_id',$get,'antrian_id'))
                    {
                      echo "<div class='col-md-12'>".$this->app->alert('danger','Data tidak ditemukan')."</dic>";
                    }
                    else
                    {
                      if($this->obj->delete('pasien_antrian','antrian_id=:antrian_id','antrian_id', $this->obj->row['antrian_id']))
                      {
                        echo $this->app->alert('success col-md-12','Data berhasil dihapus');
                        $this->app->reload(3,'?page=antrian');

                      }
                      else
                      {
                         echo $this->app->alert('danger col-md-12','Data gagal dihapus');
                        $this->app->reload(3,'?page=antrian');
                      }
                    }
                  ?>
                </div>
              </div>
            </section>
      </div>
    <?php 
  }
  public function pasien_table_antrian_menunggu()
  {
      ?>
         
     	<?php 
     		$this->err = array();

     		if(isset($_POST['selesaikan_antrian']))
     		{
     			if(empty($_POST['antrian_id']))
     			{
     				array_push($this->err, "Harapa pilih antrian yang akan diselesaikan !");
     			}
     			else
     			{
     				$data = $_POST['antrian_id'];
     			}
     			if(count($this->err)==0)
     			{
     				foreach($data as $antrian)
     				{
     					if($this->obj->updateTable('pasien_antrian','antrian_status=:antrian_status','antrian_id=:antrian_id',

     						array(

     							":antrian_status"=>'Selesai',
     							":antrian_id"=>$antrian
     						)

     					))
     					{
     						$this->success = $this->app->alert('alert alert-success','Antrian berhasil diselesaikan');
     						$this->app->reload(3);
     					}
     					else
     					{
     						$this->success = $this->app->alert('alert alert-danger','Antrian gagal diselesaikan');
     					}
     				}
     			}
     		}
     		if(isset($_POST['reset_antrian']))
     		{
     			($this->obj2->truncateTable('pasien_antrian'))

     			?
     			$this->success = $this->app->alert('alert alert-success','Antrian berhasil direset')
     			:
     			$this->success = $this->app->alert('alert alert-danger','Antrian gagal direset');   			
     		}

     	?>
     	 <div class="content-wrapper">
            <?=$this->app->bread('Antrian Menunggu','Home','?page=home')?>
            <section class="content">
                <div class="container-fluid">
		           <div class="card">
		              <div class="card-header">
		                <h3 class="card-title">Data semua antrian menunggu</h3>
		              </div>
		              <!-- /.card-header -->
		              <div class="card-body">
		              	<form action="<?php $_SERVER['REQUEST_URI']?>" method="post">
		                  <div class="row">
		                    <div class="form-group col-md-6">
		                      <button class="btn btn-primary btn-xs" name="selesaikan_antrian">Selesaikan antrian</button>
		                      <button class="btn btn-danger btn-xs" name="reset_antrian">Reset antrian</button>
		                      <a class="btn btn-primary btn-xs" href="?page=antrian_selesai">Antrian selesai</a> 
		                       <a class="btn btn-primary btn-xs" href="?page=antrian">Semua antrian</a>   

		                    </div>
		                  </div>
		                  	<?=$this->app->getError($this->err)?>
			                <?=$this->success?> 
			                <table id="example2" class="table table-bordered table-striped">
			                    <thead>
			                    <tr>
			                     <th>#</th>
			                      <th>No. Antrian</th>
			                      <th>Nama Pasien</th>
			                      <th>Aksi</th>
			                    
			                    </tr>
			                    </thead>
			                    <tbody>

			                      <?php 
			                          $no = 1;
			                          $data = $this->obj->pagination('halaman','pasien_antrian',20,"antrian_status='Menunggu'",'ORDER by antrian_id DESC');
			                          $data->execute();
			                          while($row=$data->fetch(PDO::FETCH_BOTH))
			                          {
			                      ?>
			                       
			                        <tr>
			                        	<td><input type="checkbox" name="antrian_id[]" value="<?=$row['antrian_id']?>"></td>
			                         	<td><?=$row['antrian_nomor']?></td>
			                         	<td><?=$this->obj2->readId('pasien_nama', 'pasien', 'pasien_id', $row['pasien_id'])?></td>
			                         	<td>
			                         		 <span class="badge bg-primary"><a href="?page=antrian_delete&antrian_id=<?=$row['antrian_id']?>">Delete</a></span>
			                         		   <span class="badge bg-warning"> <a href="?page=pasien_riwayat&pasien_id=<?=$row['pasien_id']?>" target="_blank">Riwayat</i></a></span>  
			                         		 	<?php 
				                         		  	if($row['antrian_status']=='Menunggu')
				                         		  	{
				                         		  		echo '<span class="badge bg-danger">Menunggu</span>';
				                         		  	}
				                         		  	else{
				                         		  		echo '<span class="badge bg-success">Selesai</span>';
				                         		  	}  
			                         		  	?> 
			                         	</td>
			                        </tr>
			                      <?php $no+=1; } ?>
			                      

			                   </tbody>
			                </table>
			            </form>
		             
		              </div>
		              <!-- /.card-body -->
		               <?php 
		                $this->obj->paginationNumberBootstrap('pasien_antrian',20,'page=antrian','halaman',"antrian_status='Menunggu'");
		              ?>
		            </div>
		        </div>
		    </section>
		</div>
         
      <?php 
  }
   public function pasien_table_antrian_selesai()
  {
      ?>
         
     	<?php 
     		$this->err = array();

     		if(isset($_POST['selesaikan_antrian']))
     		{
     			if(empty($_POST['antrian_id']))
     			{
     				array_push($this->err, "Harapa pilih antrian yang akan diselesaikan !");
     			}
     			else
     			{
     				$data = $_POST['antrian_id'];
     			}
     			if(count($this->err)==0)
     			{
     				foreach($data as $antrian)
     				{
     					if($this->obj->updateTable('pasien_antrian','antrian_status=:antrian_status','antrian_id=:antrian_id',

     						array(

     							":antrian_status"=>'Selesai',
     							":antrian_id"=>$antrian
     						)

     					))
     					{
     						$this->success = $this->app->alert('alert alert-success','Antrian berhasil diselesaikan');
     						$this->app->reload(3);
     					}
     					else
     					{
     						$this->success = $this->app->alert('alert alert-danger','Antrian gagal diselesaikan');
     					}
     				}
     			}
     		}
     		if(isset($_POST['reset_antrian']))
     		{
     			($this->obj2->truncateTable('pasien_antrian'))

     			?
     			$this->success = $this->app->alert('alert alert-success','Antrian berhasil direset')
     			:
     			$this->success = $this->app->alert('alert alert-danger','Antrian gagal direset');   			
     		}

     	?>
     	 <div class="content-wrapper">
            <?=$this->app->bread('Antrian Selesai','Home','?page=home')?>
            <section class="content">
                <div class="container-fluid">
		           <div class="card">
		              <div class="card-header">
		                <h3 class="card-title">Data semua antrian menunggu</h3>
		              </div>
		              <!-- /.card-header -->
		              <div class="card-body">
		              	<form action="<?php $_SERVER['REQUEST_URI']?>" method="post">
		                  <div class="row">
		                    <div class="form-group col-md-6">
		                      <button class="btn btn-primary btn-xs" name="selesaikan_antrian">Selesaikan antrian</button>
		                      <button class="btn btn-danger btn-xs" name="reset_antrian">Reset antrian</button>
		                      <a class="btn btn-primary btn-xs" href="?page=antrian_menunggu">Antrian menunggu</a> 
		                      <a class="btn btn-primary btn-xs" href="?page=antrian">Semua antrian</a>   

		                    </div>
		                  </div>
		                  	<?=$this->app->getError($this->err)?>
			                <?=$this->success?> 
			                <table id="example2" class="table table-bordered table-striped">
			                    <thead>
			                    <tr>
			                     <th>#</th>
			                      <th>No. Antrian</th>
			                      <th>Nama Pasien</th>
			                      <th>Aksi</th>
			                    
			                    </tr>
			                    </thead>
			                    <tbody>

			                      <?php 
			                          $no = 1;
			                          $data = $this->obj->pagination('halaman','pasien_antrian',20,"antrian_status='Selesai'",'ORDER by antrian_id DESC');
			                          $data->execute();
			                          while($row=$data->fetch(PDO::FETCH_BOTH))
			                          {
			                      ?>
			                       
			                        <tr>
			                        	<td><input type="checkbox" name="antrian_id[]" value="<?=$row['antrian_id']?>"></td>
			                         	<td><?=$row['antrian_nomor']?></td>
			                         	<td><?=$this->obj2->readId('pasien_nama', 'pasien', 'pasien_id', $row['pasien_id'])?></td>
			                         	<td>
			                         		 <span class="badge bg-primary"><a href="?page=antrian_delete&antrian_id=<?=$row['antrian_id']?>">Delete</a></span>
			                         		   <span class="badge bg-warning"> <a href="?page=pasien_riwayat&pasien_id=<?=$row['pasien_id']?>" target="_blank">Riwayat</i></a></span>  
			                         		 	<?php 
				                         		  	if($row['antrian_status']=='Menunggu')
				                         		  	{
				                         		  		echo '<span class="badge bg-danger">Menunggu</span>';
				                         		  	}
				                         		  	else{
				                         		  		echo '<span class="badge bg-success">Selesai</span>';
				                         		  	}  
			                         		  	?> 
			                         	</td>
			                        </tr>
			                      <?php $no+=1; } ?>
			                      

			                   </tbody>
			                </table>
			            </form>
		             
		              </div>
		              <!-- /.card-body -->
		               <?php 
		                $this->obj->paginationNumberBootstrap('pasien_antrian',20,'page=antrian','halaman',"antrian_status='Selesai'");
		              ?>
		            </div>
		        </div>
		    </section>
		</div>
         
      <?php 
  }
}