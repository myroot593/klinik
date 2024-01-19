<?php 
class Usermanage extends Profileklinik
{
	public function user_tambah()
	{
		?>
			<div class="col-md-12">
				<?php 
					if(count($this->err)>0)
					{
						$this->app->getError($this->err);
					}
				?>
			</div>
			<div class="card card-primary">              
	              <div class="card-header">
	                <h3 class="card-title">Tambah user</h3>
	              </div>
	            
	            <form action="<?php htmlentities($_SERVER['REQUEST_URI'])?>" method="post" enctype="multipart/form-data">
	                <div class="card-body">
	                   
	                  <?=$this->success?>
	                
	                <div class="row">
		                  <div class="form-group col-md-6">
		                    <label>Email</label>
		                    <input type="text" name="email" class="form-control" placeholder="Masukan email" required="">
		                  </div>
		                  <div class="form-group col-md-6">
		                    <label>Password</label>
		                    <input type="password" name="password" class="form-control" placeholder="Masukan password" required="">
		                  </div>
		            </div>
	                <div class="form-group">
	                  	<label>Pilih hak akases</label>
	                  	<select class="form-control" name="role_id" required="">
	                  		<?php 
	                  			$data = $this->obj->selectTable('users_role ORDER by role_alias DESC');
	                  			while ($row=$data->fetch(PDO::FETCH_BOTH)) {
									echo "<option value='".$row['role_id']."'>".$row['role_alias']."</option>";
	                  			}
	                  			unset($data);
	                  		?>

	                  	</select>
	                </div>
	                <div class="form-group">
		                <label>Nama lengkap</label>
		                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukan nama_lengkap" required="">
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
	                </div>
	                <div class="form-group">
	                  <button type="submit" class="btn btn-md btn-primary">Submit</button>
	                </div>
	              </div>
	            </form>
	        </div>
		<?php 
	}
	public function user_proses($path)
	{
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
				if($this->obj->cekData('email','users', $this->app->post('email')))
				{
					array_push($this->err,"Email tersebut sudah ada");
				}
				else
				{
					$email = $this->app->post('email');
				}
			}
			if(empty($this->app->post('password')))
			{
				array_push($this->err, "Password tidak boleh kosong");
			}
			elseif(strlen($_POST['password'])<6) {
				array_push($this->err, "Password tidak boleh kurang dari 6 karakter");
			}
			else
			{
				$password = $_POST['password'];
			}
			if(empty($this->app->post('role_id')))
			{
				array_push($this->err, "Role harus dipilih");
			}
			else
			{
				$role = $this->app->post('role_id');
			}

			if(empty($this->app->post('nama_lengkap')))
			{
				array_push($this->er, "Nama lengkap tidak boleh kosong");
			}
			else
			{
				$nama_lengkap = $this->app->post('nama_lengkap');
			}
			if(!empty($_FILES['photo']['name']))
			{
				$this->upload->createImage('photo',$path.'content/');
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
						if($this->obj->insertTable('users',

							'email, password, role_id, nama_lengkap, photo',
							':email,:password, :role_id, :nama_lengkap, :photo',
							array(

								":email"=>$email,
								":password"=>password_hash($password,PASSWORD_DEFAULT),
								":role_id"=>$role,
								":nama_lengkap"=>$nama_lengkap,
								":photo"=>$this->upload->file_item
							)

						  ))
						{
							$this->success= $this->app->alert('success','User berhasil ditambahkan');
							//
							$this->app->reload(3,'?page=semua_pengguna');
						}
						else
						{
							$this->success = $this->app->alert('danger','User gagal ditambahkan');
							$this->app->reload(3,'?page=semua_pengguna');
						}
					}
				}
				else
				{
					if($this->obj->insertTable('users',

							'email, password, role_id, nama_lengkap',
							':email,:password, :role_id, :nama_lengkap',
							array(

								":email"=>$email,
								":password"=>password_hash($password,PASSWORD_DEFAULT),
								":role_id"=>$role,
								":nama_lengkap"=>$nama_lengkap
								
							)

						  ))
						{
							$this->success= $this->app->alert('success','User berhasil ditambahkan');
							//
							$this->app->reload(3,'?page=semua_pengguna');
						}
						else
						{
							$this->success = $this->app->alert('danger','User gagal ditambahkan');
							$this->app->reload(3,'?page=semua_pengguna');
						}
				}

			}

		}
	}
	public function user_index($path)
	{
		?>
			<div class="content-wrapper">
				<?=$this->app->bread('Tambah user','Home','?page=home')?>
				<section class="content">
			      <div class="container-fluid">
			        <div class="row">
			        	<div class="col-md-12">
				        	<?=$this->user_proses($path)?>
				        	<?=$this->user_tambah()?>
				        </div>
			        </div>
			      </div>
			    </section>
			</div>
		<?php 
	}
	public function user_table()
  	{
      ?>
      	 <div class="content-wrapper">
            <?=$this->app->bread('Semua pengguna','Home','?page=home')?>
            <section class="content">
                <div class="container-fluid">
		           <div class="card">
		              <div class="card-header">
		                <h3 class="card-title">Data semua pengguna</h3>
		              </div>
		              <!-- /.card-header -->
		              <div class="card-body">
		                <table id="example2" class="table table-bordered table-striped">
		                  <thead>
		                  <tr>
		                    <th>NO</th>
		                    <th>Email</th>
		                    <th>Nama Lengkap</th>
		                    <th>Role</th>
		               
		                    <th>Aksi</th>
		                  </tr>
		                  </thead>
		                  <tbody>
		                    <?php 
		                        $no = 1;
		                        $data = $this->obj->pagination('halaman','users',10,NULL,'ORDER by user_id DESC');
		                        $data->execute();
		                        while($row=$data->fetch(PDO::FETCH_BOTH))
		                        {
		                    ?>
		                      <tr>
		                        <td><?=$no?></td>
		                        <td><?=$row['email']?></td>
		                      	<td><?=$row['nama_lengkap']?></td>
		                      	 <td><?=$this->obj2->readId('role_alias', 'users_role', 'role_id', $row['role_id'])?></td>
		                      	
		                        <td>
		                            <a href="?page=user_edit&user_id=<?=$row['user_id']?>"><i class="fas fa-pen"></i></a>
		                            
		                            <a href="?page=user_delete&user_id=<?=$row['user_id']?>"><i class="fas fa-trash"></i></a>
		                        </td>    

		                      </tr>
		                    <?php $no+=1; } ?>

		                 </tbody>
		                </table>
		              </div>
		              <!-- /.card-body -->
		              <?php 
		                $this->obj->paginationNumberBootstrap('users',10,'page=semua_pengguna','halaman');
		              ?>
		            </div>
		       </div>
		    </section>
		</div>

      <?php 
  	}
  	public function user_edit($data)
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
						if($data['email']!=$this->app->post('email'))
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
					if(empty($this->app->post('password')))
					{
						array_push($this->err, "Password tidak boleh kosong");
					}
					elseif(strlen($_POST['password'])<6) {
						array_push($this->err, "Password tidak boleh kurang dari 6 karakter");
					}
					else
					{
						$password = $_POST['password'];
					}
					if(empty($this->app->post('role_id')))
					{
						array_push($this->err, "Role harus dipilih");
					}
					else
					{
						$role = $this->app->post('role_id');
					}

					if(empty($this->app->post('nama_lengkap')))
					{
						array_push($this->er, "Nama lengkap tidak boleh kosong");
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
								//update table
								if($this->obj->updateTable('users',
						            'email=:email,
						            password=:password,
						            role_id=:role_id,
						            nama_lengkap=:nama_lengkap,
						            photo=:photo
						            ','user_id=:user_id',
						            array(
						            ":email"=>$email,
									":password"=>password_hash($password,PASSWORD_DEFAULT),
									":role_id"=>$role,
									":nama_lengkap"=>$nama_lengkap,
									":photo"=>$this->upload->file_item,
									":user_id"=>$data['user_id']
						           )


						        ))
								{
									$this->success= $this->app->alert('success','User berhasil diupdate');
									//
									$this->app->reload(3,'?page=semua_pengguna');
								}
								else
								{
									$this->success = $this->app->alert('danger','User gagal ditambahkan');
									$this->app->reload(3,'?page=semua_pengguna');
								}
							}
						}
						else
						{
								if($this->obj->updateTable('users',
						            'email=:email,
						            password=:password,
						            role_id=:role_id,
						            nama_lengkap=:nama_lengkap						          
						            ','user_id=:user_id',
						            array(
							           ":email"=>$email,
										":password"=>password_hash($password,PASSWORD_DEFAULT),
										":role_id"=>$role,
										":nama_lengkap"=>$nama_lengkap,								
										":user_id"=>$data['user_id']
						           )


						        ))
								{
									$this->success= $this->app->alert('success','User berhasil diupdate');
									//
									$this->app->reload(3,'?page=semua_pengguna');
								}
								else
								{
									$this->success = $this->app->alert('danger','User gagal ditambahkan');
									$this->app->reload(3,'?page=semua_pengguna');
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
	                <h3 class="card-title">Edit user</h3>
	              </div>
	            
	            <form action="<?php htmlentities($_SERVER['REQUEST_URI'])?>" method="post" enctype="multipart/form-data">
	                <div class="card-body">
	                   
	                  <?=$this->success?>
	                
	                <div class="row">
		                  <div class="form-group col-md-6">
		                    <label>Email</label>
		                    <input type="text" name="email" value="<?=$data['email']?>" class="form-control" placeholder="Masukan email" required="">
		                  </div>
		                  <div class="form-group col-md-6">
		                    <label>Password</label>
		                    <input type="password" name="password" class="form-control" placeholder="Masukan password" required="">
		                  </div>
		            </div>
	                <div class="form-group">
	                  	<label>Pilih hak akases</label>
	                  	<select class="form-control" name="role_id" required="">
	                  		<option value="<?=$data['role_id']?>"><?=$this->obj2->readId('role_alias', 'users_role', 'role_id', $data['role_id'])?></option>
	                  		<?php 
	                  			$d = $this->obj->selectTable('users_role ORDER by role_alias DESC');
	                  			while ($row=$d->fetch(PDO::FETCH_BOTH)) {
									echo "<option value='".$row['role_id']."'>".$row['role_alias']."</option>";
	                  			}
	                  			unset($d);
	                  		?>

	                  	</select>
	                </div>
	                <div class="form-group">
		                <label>Nama lengkap</label>
		                    <input type="text" name="nama_lengkap" value="<?=$data['nama_lengkap']?>" class="form-control" placeholder="Masukan nama_lengkap" required="">
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
	                    <img src="../content/<?=$data['photo']?>" height="80px" width="80px" />
	                </div>
	                <div class="form-group">
	                  <button type="submit" class="btn btn-md btn-primary">Submit</button>
	                </div>
	              </div>
	            </form>
	        </div>
	        </div>

  		<?php
  	}
  	public function user_edit_index($get)
  	{
  		?>
  			<div class="content-wrapper">
	          <?=$this->app->bread('Edit User','Home','?page=home')?>
	          <section class="content">
	              <div class="container-fluid">
	                <div class="row">
	                 <?php
	                    if(!$this->obj->getTable('users','user_id=:user_id',$get,'user_id'))
	                    {
	                      echo "<div class='col-md-12'>".$this->app->alert('danger','Data tidak ditemukan')."</dic>";
	                    }
	                    else
	                    {
	                     $this->user_edit($this->obj->row);
	                    }
	                  ?>
	                </div>
	              </div>
	            </section>
	      </div>
  		<?php 
  	}
  	public function user_delete($get)
 	{
	    ?>
	        <div class="content-wrapper">
	          <?=$this->app->bread('Delete User','Home','?page=home')?>
	          <section class="content">
	              <div class="container-fluid">
	                <div class="row">
	                 <?php
	                    if(!$this->obj->getTable('users','user_id=:user_id',$get,'user_id'))
	                    {
	                      echo "<div class='col-md-12'>".$this->app->alert('danger','Data tidak ditemukan')."</dic>";
	                    }
	                    else
	                    {
	                      if($this->obj->delete('users','user_id=:user_id','user_id', $this->obj->row['user_id']))
	                      {
	                        echo $this->app->alert('success col-md-12','Data berhasil dihapus');
	                        $this->app->reload(3,'?page=semua_pengguna');

	                      }
	                      else
	                      {
	                         echo $this->app->alert('danger col-md-12','Data gagal dihapus');
	                        $this->app->reload(3,'?page=semua_pengguna');
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