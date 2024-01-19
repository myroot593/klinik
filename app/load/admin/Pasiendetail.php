<?php 
class Pasiendetail extends Role 
{
	public function pasien_riwayat($row)
	{
		?>
			  <div class="card card-primary">              
              <div class="card-header">
                <h3 class="card-title">Tambah riwayat pasien</h3>
              </div>
              <form action="<?php htmlentities($_SERVER['REQUEST_URI'])?>" method="post">
                <div class="card-body">
                   <?php 
                      if(count($this->err)>0)
                      {
                        $this->app->getError($this->err);
                      }
                  ?>
                  <?=$this->success?>
                  <div class="row">
	                  <div class="form-group col-md-6">
	                    <label>NIK</label>
	                    <fieldset disabled="">
	                    	<input type="text" name="nik" class="form-control" value="<?=$row['pasien_nik']?>" placeholder="Masukan nomor induk kependudukan">
	                    </fieldset>
	                  </div>
	                  <div class="form-group col-md-6">
	                    <label>Nama lengkap</label>
	                   	 <fieldset disabled="">
	                    	<input type="text" name="nama_lengkap" class="form-control" value="<?=$row['pasien_nama']?>" placeholder="Masukan nama lengkap">
	                    </fieldset>
	                  </div>
	              </div>
                 	<div class="form-group">
	                    <label>Keterangan Keluhan</label>	                   
	                    	<textarea class="textarea" name="keterangan_keluhan"></textarea>
	                </div>
	                <div class="form-group">
	                	<label>Catatan dokter</label>
	                	<textarea class="form-control" name="catatan_dokter"></textarea>
	                </div>
	                <div class="form-group">
	                	<label>Catatan resep</label>
	                	<textarea class="form-control" name="catatan_resep"></textarea>
	                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a class="btn btn-primary btn-md" href="?page=pasien_riwayat&pasien_id=<?=$row['pasien_id']?>">Kembali</a>
                </div>
              </div>
              </form>
            </div>
		<?php 
	}
	public function pasien_riwayat_proses($row)
	{
		$this->err =array();
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			if(empty($this->app->post('keterangan_keluhan')))
			{
				array_push($this->err,'Keterangankeluhan wajib diisi !');
			}
			else
			{
				$ket = $this->app->post('keterangan_keluhan');
				$cd = $this->app->post('catatan_dokter');
				$cr = $this->app->post('catatan_resep');
			}
			if(count($this->err)==0)
			{
				if($this->obj->insertTable('pasien_riwayat',

					'pasien_id, keterangan_keluhan, catatan_dokter, catatan_resep, tanggal_berobat',
					':pasien_id, :keterangan_keluhan, :catatan_dokter, :catatan_resep, :tanggal_berobat',
					array 
					(
						":pasien_id"=>$row['pasien_id'],
						":keterangan_keluhan"=>$ket,
						":catatan_dokter"=>$cd,
						":catatan_resep"=>$cr,
						":tanggal_berobat"=>date('Y-m-d')
					)
				))
				{
					$this->success = $this->app->alert('success','Data berhasil disimpan');
					$this->app->reload(3);
				}
				else
				{
					$this->success = $this->app->alert('danger','Data gagal disimpan');
				}
			}
		}
	}
	public function pasien_riwayat_index($get)
	{
		?>
			<div class="content-wrapper">
	          <?=$this->app->bread('Riwayat Pasien','Home','?page=home')?>
	          <section class="content">
	              <div class="container-fluid">
	                <div class="row">
	                	<div class="col-md-12">
		                 <?php
		                    if(!$this->obj->getTable('pasien','pasien_id=:pasien_id',$get,'pasien_id'))
		                    {
		                      echo "<div class='col-md-12'>".$this->app->alert('danger','Data tidak ditemukan')."</dic>";
		                    }
		                    else
		                    {
		                      
		                      Pasiendetail::pasien_riwayat_proses($this->obj->row);
		                      Pasiendetail::pasien_riwayat($this->obj->row);

		                    }
		                  ?>
		              </div>
	                </div>
	              </div>
	            </section>
	      	</div>
		<?php 
	}
	public function pasien_riwayat_table($data)
	{
		?>
           <div class="form-group">
           	<a class="btn btn-primary btn-md" href="?page=pasien_riwayat_tambah&pasien_id=<?=$data['pasien_id']?>">Tambah riwayat</a>
           	<a class="btn btn-warning btn-md" href="?page=semua_pasien">Kembali</a>
           </div>
           <div class="card">
              <div class="card-header">
                <h3 class="card-title">Riwayat pasien <?=$data['pasien_nama']?></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>NO</th>
                    <th>Tgl. Berobat</th>
                  
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                        $no = 1;
                        $main = $this->obj->pagination('halaman','pasien_riwayat',10,"pasien_id='".$data['pasien_id']."'",'ORDER by pasien_id DESC');
                        $main->execute();
                        while($row=$main->fetch(PDO::FETCH_BOTH))
                        {
                    ?>
                      <tr>
                        <td><?=$no?></td>
                        <td><?=$row['tanggal_berobat']?></td>
                      
                        <td>
                            
                            <a href="?page=pasien_riwayat_delete&pasien_id=<?=$row['pasien_id']?>&riwayat_id=<?=$row['riwayat_id']?>"><i class="fas fa-trash"></i></a>
                            <a href="#"  riwayat_id="<?=$row['riwayat_id']?>" class="text-white btn btn-warning btn-xs lihat_riwayat">Lihat detail</a>
                           
                      </tr>
                    <?php $no+=1; } ?>

                 </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <?php 
                $this->obj->paginationNumberBootstrap('pasien_riwayat',10,'page=semua_pasien','halaman',"pasien_id='".$data['pasien_id']."'");
              ?>
            </div>
      <?php
	}
	public function pasien_riwayat_table_index($get)
	{
		?>
			<div class="content-wrapper">
	          <?=$this->app->bread('Riwayat Pasien','Home','?page=home')?>
	          <section class="content">
	              <div class="container-fluid">
	                <div class="row">
	                	<div class="col-md-12">
		                 <?php
		                    if(!$this->obj->getTable('pasien','pasien_id=:pasien_id',$get,'pasien_id'))
		                    {
		                      echo "<div class='col-md-12'>".$this->app->alert('danger','Data tidak ditemukan')."</dic>";
		                    }
		                    else
		                    {
		                      
		                      Pasiendetail::pasien_riwayat_table($this->obj->row);

		                    }
		                  ?>
		              </div>
	                </div>
	              </div>
	            </section>
	      	</div>
		<?php 
	}
	public function pasien_riwayat_delete($get)
  	{
       ?>
	        <div class="content-wrapper">
	          <?=$this->app->bread('Delete Riwayat','Home','?page=home')?>
	          <section class="content">
	              <div class="container-fluid">
	                <div class="row">
	                 <?php
	                    if(!$this->obj->getTable('pasien_riwayat','riwayat_id=:riwayat_id',$get,'riwayat_id'))
	                    {
	                      echo "<div class='col-md-12'>".$this->app->alert('danger','Data tidak ditemukan')."</dic>";
	                    }
	                    else
	                    {
	                      if($this->obj->delete('pasien_riwayat','riwayat_id=:riwayat_id','riwayat_id', $this->obj->row['riwayat_id']))
	                      {
	                        echo $this->app->alert('success col-md-12','Data berhasil dihapus');
	                        $this->app->reload(3,"?page=pasien_riwayat&pasien_id=".$_GET['pasien_id']."");

	                      }
	                      else
	                      {
	                         echo $this->app->alert('danger col-md-12','Data gagal dihapus');
	                        $this->app->reload(3,"?page=pasien_riwayat&pasien_id=".$_GET['pasien_id']."");
	                      }
	                    }
	                  ?>
	                </div>
	              </div>
	            </section>
	        </div>
       <?php 
    }
    public function pasien_riwayat_modal()
    {
    	?>
    		
    		 <div class="modal fade" id="confirm-keluhan">
		        <div class="modal-dialog">
		          <div class="modal-content">
		            <div class="modal-header">
		              <h4 class="modal-title">Detail Riwayat</h4>
		              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                <span aria-hidden="true">&times;</span>
		              </button>
		            </div>
		            <div class="modal-body" id="detail_keluhan">
		             
		            </div>
		            <div class="modal-footer justify-content-between">
		              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		              
		            </div>
		          </div>
		          <!-- /.modal-content -->
		        </div>
		        <!-- /.modal-dialog -->
		    </div>
		      <!-- /.modal -->

    	<?php 
    }
    public function pasien_riwayat_ajax($path)
    {
    	?>
    		<script type="text/javascript">
    			$(document).on('click','.lihat_riwayat', function()
    			{
    				var detail_keluhan = $(this).attr("riwayat_id");
    				$.ajax({

    					url:"<?=$path;?>",
    					method:"post",
    					data:{detail_keluhan:detail_keluhan},
    					success:function(data){
    						$('#detail_keluhan').html(data);
    						$('#confirm-keluhan').modal("show")
    					}

    				});
    			});
    		</script>
    	<?php
    }

}