<?php 
class Role extends Usermanage
{
	public function role_tambah()
	{
		?>
			<div class="card card-primary">              
	              <div class="card-header">
	                <h3 class="card-title">Tambah role</h3>
	              </div>
	            
	            <form action="<?php htmlentities($_SERVER['REQUEST_URI'])?>" method="post">
	                <div class="card-body">
	                   
	                  <?=$this->success?>
	                
	                  <div class="form-group">
	                    <label>Role name</label>
	                    <input type="text" name="role_name" class="form-control" placeholder="Masukan role name" required="">
	                  </div>
	                  <div class="form-group">
	                    <label>Role alias</label>
	                    <input type="text" name="role_alias" class="form-control" placeholder="Masukan role alias" required="">
	                  </div>
	                  <div class="form-group">
	                  	<label>Role Module</label>
	                  	<select class="form-control" name="role_module" required="">
	                  		<option value="admin">admin</option>
	                  		<option valu="dokter">dokter</option>
	                  		<option value="administrasi">administrasi</option>
	                  	</select>
	                  </div>

	                <div class="form-group">
	                  <button type="submit" class="btn btn-md btn-primary">Submit</button>
	                </div>
	              </div>
	            </form>
	        </div>
		<?php 
	}
	public function role_proses()
	{
		
	    if($_SERVER['REQUEST_METHOD']=='POST')
	    {
	      	$role_name = $this->app->post('role_name');
	      	$role_alias = $this->app->post('role_alias');
	      	$role_module = $this->app->post('role_module');
	      
	        if($this->obj->insertTable('users_role','role_name, role_alias, role_module',
	          ':role_name, :role_alias, :role_module',
	          array(
	           ":role_name"=>$role_name,
	           ":role_alias"=>$role_alias,
	           ":role_module"=>$role_module
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
	public function role_index()
	{
		?>
			<div class="content-wrapper">
				<?=$this->app->bread('Tambah role','Home','?page=home')?>
				<section class="content">
			      <div class="container-fluid">
			        <div class="row">
			        	<div class="col-md-12">
				        	<?=$this->role_proses()?>
				        	<?=$this->role_tambah()?>
				        </div>
			        </div>
			      </div>
			    </section>
			</div>
		<?php 
	}
	public function role_table()
  	{
      ?>
      	 <div class="content-wrapper">
            <?=$this->app->bread('Semua Role','Home','?page=home')?>
            <section class="content">
                <div class="container-fluid">
		           <div class="card">
		              <div class="card-header">
		                <h3 class="card-title">Data semua role</h3>
		              </div>
		              <!-- /.card-header -->
		              <div class="card-body">
		                <table id="example2" class="table table-bordered table-striped">
		                  <thead>
		                  <tr>
		                    <th>NO</th>
		                    <th>Role name</th>
		                    <th>Role Alias</th>
		                    <th>Role Module</th>
		               
		                    <th>Aksi</th>
		                  </tr>
		                  </thead>
		                  <tbody>
		                    <?php 
		                        $no = 1;
		                        $data = $this->obj->pagination('halaman','users_role',10,NULL,'ORDER by role_id DESC');
		                        $data->execute();
		                        while($row=$data->fetch(PDO::FETCH_BOTH))
		                        {
		                    ?>
		                      <tr>
		                        <td><?=$no?></td>
		                        <td><?=$row['role_name']?></td>
		                      	<td><?=$row['role_alias']?></td>
		                      	<td><?=$row['role_module']?></td>
		                        <td>
		                            <a href="?page=role_edit&role_id=<?=$row['role_id']?>"><i class="fas fa-pen"></i></a>
		                            
		                            <a href="?page=role_delete&role_id=<?=$row['role_id']?>"><i class="fas fa-trash"></i></a>
		                        </td>    

		                      </tr>
		                    <?php $no+=1; } ?>

		                 </tbody>
		                </table>
		              </div>
		              <!-- /.card-body -->
		              <?php 
		                $this->obj->paginationNumberBootstrap('users_role',10,'page=semua_role','halaman');
		              ?>
		            </div>
		       </div>
		    </section>
		</div>

      <?php 
  	}
  	public function role_edit($data)
  	{
  		?>
  			<?php 
		       
		        if($_SERVER['REQUEST_METHOD']=='POST')
		        {
		         	$role_name = $this->app->post('role_name');
	      			$role_alias = $this->app->post('role_alias');
	      			$role_module = $this->app->post('role_module');

		          if($this->obj->updateTable('users_role',
		            'role_name=:role_name,
		           role_alias=:role_alias,
		           role_module=:role_module
		            ','role_id=:role_id',
		            array(
		           ":role_name"=>$role_name,
		           ":role_alias"=>$role_alias,
		           ":role_module"=>$role_module,
		           ":role_id"=>$data['role_id']
		           )


		            ))
		          {
		            $this->success = $this->app->alert('success','Data berhasil disimpan');
		            $this->app->reload(3,'?page=semua_role');
		          }
		          else
		          {
		            $this->success = $this->app->alert('danger','Data gagal disimpan');
		            $this->app->reload(3,'?page=semua_role');
		          }
		        }
		    ?>
		    <div class="col-md-12">
		    <div class="card card-primary">              
	              <div class="card-header">
	                <h3 class="card-title">Tambah role</h3>
	              </div>
	            
		            <form action="<?php htmlentities($_SERVER['REQUEST_URI'])?>" method="post">
		                <div class="card-body">
		                   
		                  <?=$this->success?>
		                
		                  <div class="form-group">
		                    <label>Role name</label>
		                    <input type="text" name="role_name" value="<?=$data['role_name']?>" class="form-control" placeholder="Masukan role name" required="">
		                  </div>
		                  <div class="form-group">
		                    <label>Role alias</label>
		                    <input type="text" name="role_alias" value="<?=$data['role_alias']?>" class="form-control" placeholder="Masukan role alias" required="">
		                  </div>
		                  <div class="form-group">
		                  	<label>Role Module</label>
		                  	<select class="form-control" name="role_module" required="">

		                  		<option value="<?=$data['role_module']?>"><?=$data['role_module']?></option>
		                  		<option value="admin">admin</option>
		                  		<option value="dokter">dokter</option>
		                  		<option value="administrasi">administrasi</option>
		                  	</select>
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
  	public function role_edit_index($get)
  	{
  		?>
	        <div class="content-wrapper">
	          <?=$this->app->bread('Edit Role','Home','?page=home')?>
	          <section class="content">
	              <div class="container-fluid">
	                <div class="row">
	                 <?php
	                    if(!$this->obj->getTable('users_role','role_id=:role_id',$get,'role_id'))
	                    {
	                      echo "<div class='col-md-12'>".$this->app->alert('danger','Data tidak ditemukan')."</dic>";
	                    }
	                    else
	                    {
	                      Role::role_edit($this->obj->row);
	                    }
	                  ?>
	                </div>
	              </div>
	            </section>
	      </div>
    	<?php 
  	}
  	public function role_delete($get)
 	{
	    ?>
	        <div class="content-wrapper">
	          <?=$this->app->bread('Delete Role','Home','?page=home')?>
	          <section class="content">
	              <div class="container-fluid">
	                <div class="row">
	                 <?php
	                    if(!$this->obj->getTable('users_role','role_id=:role_id',$get,'role_id'))
	                    {
	                      echo "<div class='col-md-12'>".$this->app->alert('danger','Data tidak ditemukan')."</dic>";
	                    }
	                    else
	                    {
	                      if($this->obj->delete('users_role','role_id=:role_id','role_id', $this->obj->row['role_id']))
	                      {
	                        echo $this->app->alert('success col-md-12','Data berhasil dihapus');
	                        $this->app->reload(3,'?page=semua_role');

	                      }
	                      else
	                      {
	                         echo $this->app->alert('danger col-md-12','Data gagal dihapus');
	                        $this->app->reload(3,'?page=semua_role');
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