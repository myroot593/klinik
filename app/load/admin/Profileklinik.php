<?php 
class Profileklinik extends Profile
{

	public function profileform()
	{
		
		?>
			<?php 
				$this->err = array();
				if(isset($_POST['klinik_info']))
				{
					if(empty($this->app->post('klinik_name')) || empty($this->app->post('klinik_description')) || empty($this->app->post('klinik_contact')))
					{
						array_push($this->err, "Semua data wajib diisi");
					}
					else
					{
						$klinik_name = $this->app->post('klinik_name');
						$klinik_description = $this->app->post('klinik_description');
						$klinik_contact = $this->app->post('klinik_contact');
					}
					if(count($this->err)==0)
					{
						if($this->obj->updateTable('profile_klinik',
							'klinik_name=:klinik_name, klinik_description=:klinik_description, klinik_contact=:klinik_contact',':klinik_id',
							array(
									":klinik_name"=>$klinik_name,
									":klinik_description"=>$klinik_description,
									":klinik_contact"=>$klinik_contact,
									":klinik_id"=>$this->info['klinik_id']
								)
							)
						  )
						{
							$this->success = $this->app->alert('success','Data berhasil disimpan');

						}
						else
						{
							$this->success = $this->app->alert('danger','Data gagal disimpan');
						}
					}
				}
			?>
			<div class="col-md-12">
				<?php 
					if(count($this->err)>0)
					{
						$this->app->getError($this->err);
					}
				?>
				
				<div class="card card-primary">              
		            <div class="card-header">
		                <h3 class="card-title">Edit Profile Klinik</h3>
		            </div>
		            
		            <form action="<?php htmlentities($_SERVER['REQUEST_URI'])?>" method="post">
		                <div class="card-body">		                   
		                  <?=$this->success?>                
		            
			                  <div class="form-group">
			                    <label>Nama Klinik</label>
			                    <input type="text" name="klinik_name" value="<?=$this->info['klinik_name']?>" class="form-control" placeholder="Masukan nama klinik">
			                  </div>
			                   <div class="form-group">
			                    <label>Deskripsi</label>
			                    <textarea class="form-control" name="klinik_description"><?=$this->info['klinik_description']?></textarea>
			                  </div>

			                  <div class="form-group">
			                    <label>Kontak Klinik</label>
			                    <input type="text" name="klinik_contact" value="<?=$this->info['klinik_contact']?>" class="form-control" placeholder="Masukan nama klinik">
			                  </div>
			                  <div class="form-group">
			                  	<button type="submit" name="klinik_info" class="btn btn-md btn-primary" >Submit</button>
			                  </div>
			           
		            </form>
		        </div>
	        </div>

		<?php 
	}
	public function uploadlogo()
	{
		?>
			<?php
				$this->err = array();
				if(isset($_POST['upload_logo']))
				{
					if(!empty($_FILES['logo']['name']))
					{
						$this->upload->createImage('logo','content/web/','logo');
						if(!in_array($this->upload->file_extension, $this->upload->file_valid))
						{
							array_push($this->err, "Format gambar tidak sesuai, harap masukan format jpeg, jpg atau png");
						}
						else
						{
							if($this->upload->file_size>300000)
							{
								array_push($this->err, "File tidak boleh lebih dari 300 kb");
							}
						}
					}
					else
					{
						array_push($this->err,"Gambar tidak boleh kosong" );
					}
					if(count($this->err)==0)
					{
						if(move_uploaded_file($this->upload->file_tmp, $this->upload->file_dir.$this->upload->file_item))
						{
							if($this->obj->updateTable('profile_klinik',

								'klinik_logo=:klinik_logo','klinik_id=:klinik_id',
								array(":klinik_logo"=>$this->upload->file_item,"klinik_id"=>$this->info['klinik_id'])
							))
							{
								$this->success = $this->app->alert('success','Data berhasil disimpan');
								$this->app->reload(1);
							}
							else
							{
								$this->success = $this->app->alert('danger','Logo gagal disimpan');
							}
						}
					}
				}
			?>
			<div class="col-md-12">
				<?php 
					if(count($this->err)>0)
					{
						$this->app->getError($this->err);
					}
				?>
			
				<div class="card card-primary">              
		              <div class="card-header">
		                <h3 class="card-title">Upload logo</h3>
		              </div>
		            
		            <form action="<?php htmlentities($_SERVER['REQUEST_URI'])?>" method="post" enctype="multipart/form-data">
		                <div class="card-body">
		                   
		                  <?=$this->success?>
							<div class="form-group">
					            <label for="exampleInputFile">Logo</label>
					               	<div class="input-group">
					                    <div class="custom-file">
					                        <input type="file" name="logo" class="custom-file-input" id="exampleInputFile">
					                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
					                    </div>
					                     
					                </div>
					                <img src="content/web/<?=$this->info['klinik_logo']?>"  alt="klinik_logo" height="80px" width="80px" />
					        </div>
					        <div class="form-group">
					           <button type="submit" name="upload_logo" class="btn btn-md btn-primary">Submit</button>
					        </div>
				    	</div>
				    </form>
				</div>
			</div>
		<?php 
	}
	public function uploadicon()
	{
		?>
			<?php
				$this->err = array();
				if(isset($_POST['upload_icon']))
				{
					if(!empty($_FILES['icon']['name']))
					{
						$this->upload->createImage('icon','content/web/','favicon');
						if(!in_array($this->upload->file_extension, $this->upload->file_valid))
						{
							array_push($this->err, "Format gambar tidak sesuai, harap masukan format jpeg, jpg atau png");
						}
						else
						{
							if($this->upload->file_size>300000)
							{
								array_push($this->err, "File tidak boleh lebih dari 300 kb");
							}
						}
					}
					else
					{
						array_push($this->err,"Gambar tidak boleh kosong" );
					}
					if(count($this->err)==0)
					{
						if(move_uploaded_file($this->upload->file_tmp, $this->upload->file_dir.$this->upload->file_item))
						{
							if($this->obj->updateTable('profile_klinik',

								'klinik_icon=:klinik_icon','klinik_id=:klinik_id',
								array(":klinik_icon"=>$this->upload->file_item,"klinik_id"=>$this->info['klinik_id'])
							))
							{
								$this->success = $this->app->alert('success','Data berhasil disimpan');
								$this->app->reload(1);
							}
							else
							{
								$this->success = $this->app->alert('danger','icon gagal disimpan');
							}
						}
					}
				}
			?>
			<div class="col-md-12">
				<?php 
					if(count($this->err)>0)
					{
						$this->app->getError($this->err);
					}
				?>
			
				<div class="card card-primary">              
		              <div class="card-header">
		                <h3 class="card-title">Upload icon</h3>
		              </div>
		            
		            <form action="<?php htmlentities($_SERVER['REQUEST_URI'])?>" method="post" enctype="multipart/form-data">
		                <div class="card-body">
		                   
		                  <?=$this->success?>
							<div class="form-group">
					            <label for="exampleInputFile">icon</label>
					               	<div class="input-group">
					                    <div class="custom-file">
					                        <input type="file" name="icon" class="custom-file-input" id="exampleInputFile">
					                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
					                    </div>
					                     
					                </div>
					                <img src="content/web/<?=$this->info['klinik_icon']?>"  alt="klinik_icon" height="80px" width="80px" />
					        </div>
					        <div class="form-group">
					           <button type="submit" name="upload_icon" class="btn btn-md btn-primary">Submit</button>
					        </div>
				    	</div>
				    </form>
				</div>
			</div>
		<?php 
	}
	public function profile_index()
	{
		?>
			<div class="content-wrapper">
				<?=$this->app->bread('Profile Klinik','Home','?page=home')?>
				<section class="content">
			      <div class="container-fluid">
			        <div class="row">
			        	<div class="col-md-12">
				        	
				        	<?=$this->profileform()?>
				        	<?=$this->uploadlogo()?>
				        	<?=$this->uploadicon()?>
				        </div>
			        </div>
			      </div>
			    </section>
			</div>
		<?php 
	}
}