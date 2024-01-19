<?php 
class Profile
{
	public function myprofile($path,$user)
  	{
  		?>
  			<?php 
  				$this->err = array();
				if($_SERVER['REQUEST_METHOD']=='POST')
				{
					if(empty($this->app->post('email')))
					{
						array_push($this->err, "email wajib diisi !");
					}
					elseif($this->app->vldEmail($this->app->post('email')))
					{
						array_push($this->err, "Format email tidak benar");
					}
					else
					{
						if($user['email']!=$this->app->post('email'))
						{
							if($this->obj->cekData('email','users', $this->app->post('email')))
							{
								array_push($this->err,"Email tersebut sudah ada");
							}
							else
							{
								$email = $this->app->post('email');
							}
						}
						else
						{
							$email = $this->app->post('email');
						}
					}
					
					if(!empty($_POST['password']))
					{
						if(strlen($_POST['password'])<6) {
							array_push($this->err, "Password tidak boleh kurang dari 6 karakter");
						}
						else
						{
							$password = $_POST['password'];
						}
					}

					if(empty($this->app->post('nama_lengkap')))
					{
						array_push($this->err, "Nama lengkap tidak boleh kosong");
					}
					else
					{
						$nama_lengkap = $this->app->post('nama_lengkap');
					}
					if(!empty($_FILES['photo']['name']))
					{
						$this->upload->createImage('photo','../content/');
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
					if(count($this->err)==0)
					{
						if(!empty($_FILES['photo']['name']))
						{
							if(move_uploaded_file($this->upload->file_tmp, $this->upload->file_dir.$this->upload->file_item))
							{
								if(empty($_POST['password']))
								{
									if($this->obj->updateTable('users',
							            'email=:email,							            				       
							            nama_lengkap=:nama_lengkap,
							            photo=:photo
							            ','user_id=:user_id',
							            array(
							            ":email"=>$email,										
										":nama_lengkap"=>$nama_lengkap,
										":photo"=>$this->upload->file_item,
										":user_id"=>$user['user_id']
							           )


							        ))
									{
										$this->success= $this->app->alert('success','Data berhasil disimpane');
										//
										$this->app->reload(3,'?page=profile');
									}
									else
									{
										$this->success = $this->app->alert('danger','User gagal diperbaharui');
										$this->app->reload(3,'?page=profile');
									}
								}
								else
								{
									if($this->obj->updateTable('users',
							            'email=:email,
							            password=:password,							           
							            nama_lengkap=:nama_lengkap,
							            photo=:photo
							            ','user_id=:user_id',
							            array(
							            ":email"=>$email,
										":password"=>password_hash($password,PASSWORD_DEFAULT),					
										":nama_lengkap"=>$nama_lengkap,
										":photo"=>$this->upload->file_item,
										":user_id"=>$user['user_id']
							           )


							        ))
									{
										$this->success= $this->app->alert('success','Data berhasil disimpan');
										$this->app->reload(3,'?page=profile');
									}
									else
									{
										$this->success = $this->app->alert('danger','Data gagal diperbaharui');
										$this->app->reload(3,'?page=profile');
									}
								}
							}
							else
							{
								$this->success = $this->app->alert('danger', 'Foto gagal diperbaharui');
								$this->app->reload(3);
							}
						}
						else
						{
							if(empty($_POST['password']))
								{
									if($this->obj->updateTable('users',
							            'email=:email,							            				       
							            nama_lengkap=:nama_lengkap
							           
							            ','user_id=:user_id',
							            array(
							            ":email"=>$email,										
										":nama_lengkap"=>$nama_lengkap,
										
										":user_id"=>$user['user_id']
							           )


							        ))
									{
										$this->success= $this->app->alert('success','Data berhasil disimpane');
										//
										$this->app->reload(3,'?page=profile');
									}
									else
									{
										$this->success = $this->app->alert('danger','User gagal diperbaharui');
										$this->app->reload(3,'?page=profile');
									}
								}
								else
								{
									if($this->obj->updateTable('users',
							            'email=:email,
							            password=:password,							           
							            nama_lengkap=:nama_lengkap
							            
							            ','user_id=:user_id',
							            array(
							            ":email"=>$email,
										":password"=>password_hash($password,PASSWORD_DEFAULT),					
										":nama_lengkap"=>$nama_lengkap,
										
										":user_id"=>$user['user_id']
							           )


							        ))
									{
										$this->success= $this->app->alert('success','Data berhasil disimpan');
										$this->app->reload(3,'?page=profile');
									}
									else
									{
										$this->success = $this->app->alert('danger','Data gagal diperbaharui');
										$this->app->reload(3,'?page=profile');
									}
								}
						}

					}
					else
					{
						$this->app->noresubmit();
					}

				}

  			?>
  			<div class="content-wrapper">
	          <?=$this->app->bread('Edit Profile','Home','?page=home')?>
	          	<section class="content">
	              <div class="container-fluid">
	                <div class="row">
			  			<div class="col-md-12">
							<?php 
								if(count($this->err)>0)
								{
									$this->app->getError($this->err);
								}
							?>
						
							<div class="card card-primary">              
					              <div class="card-header">
					                <h3 class="card-title">Edit user</h3>
					              </div>
					            
					            <form action="<?php htmlentities($_SERVER['REQUEST_URI'])?>" method="post" enctype="multipart/form-data">
					                <div class="card-body">
					                   
					                  <?=$this->success?>
					                
					                <div class="row">
						                  <div class="form-group col-md-6">
						                    <label>Email</label>
						                    <input type="text" name="email" value="<?=$user['email']?>" class="form-control" placeholder="Masukan email" required="">
						                  </div>
						                  <div class="form-group col-md-6">
						                    <label>Password</label>
						                    <input type="password" name="password" class="form-control" placeholder="Masukan password">
						                  </div>
						            </div>
					                
					                <div class="form-group">
						                <label>Nama lengkap</label>
						                    <input type="text" name="nama_lengkap" value="<?=$user['nama_lengkap']?>" class="form-control" placeholder="Masukan nama_lengkap" required="">
						            </div>
						            <div class="form-group">
					                    <label for="exampleInputFile">Photo</label>
					                    <div class="input-group">
					                      <div class="custom-file">
					                        <input type="file" name="photo" class="custom-file-input" id="exampleInputFile">
					                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
					                      </div>
					                      <div class="input-group-append">
					                        <span class="input-group-text">Upload</span>
					                      </div>
					                    </div>
					                    <img src="../content/<?=$user['photo']?>" height="80px" width="80px" />
					                </div>
					                <div class="form-group">
					                  <button type="submit" class="btn btn-md btn-primary">Submit</button>
					                </div>
					              </div>
					            </form>
					        </div>
				        </div>
				    </div>
				</div>
				</section>
			</div>


  		<?php
  	}
}