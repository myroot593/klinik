<?php



class Apps extends database
{
	
	
	
	public function selectTable($table, $where=null, $order=null)
	{
		try
		{	
			if(!empty($where)):
				$sql="SELECT * FROM $table WHERE $where $order";
				$stmt=$this->link->prepare($sql);
				return $stmt;
			else:
				$sql="SELECT * FROM $table $order";
				$stmt=$this->link->prepare($sql);
				$stmt->execute();
				return $stmt;
			endif;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function selectTable2($table, $where=null, $getData=null, $order=null)
	{
		try
		{	
			if(!empty($where)):
				$sql="SELECT * FROM $table WHERE $where=:$where $order";
				$stmt=$this->link->prepare($sql);
				$stmt->bindParam(":$where",$getData);
				return $stmt;
			else:
				$sql="SELECT * FROM $table $order";
				$stmt=$this->link->prepare($sql);
				$stmt->execute();
				return $stmt;
			endif;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function insertmyId()
	{
		$this->last = $this->link->lastInsertId();
		return $this->last;
	}
	
	public function insertTable($table, $kolom, $value, $array)
	{
		
		try
		{
			$sql="INSERT INTO $table($kolom) VALUES($value)";
			$stmt=$this->link->prepare($sql);
			$stmt->execute($array);

			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}
	}
	public function replaceTable($table, $kolom, $value, $array)
	{
		
		try
		{
			$sql="REPLACE INTO $table($kolom) VALUES($value)";
			$stmt=$this->link->prepare($sql);
			$stmt->execute($array);

			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}
	}
	public function getTable($table, $where, $data, $kolom)
	{
		try
		{
			$stmt=$this->selectTable($table, $where);
			$stmt->bindParam(":$kolom",$data);
			$stmt->execute();
			$this->row=$stmt->fetch(PDO::FETCH_ASSOC);
			return $this->row;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			
		}
	}
	public function updateTable($table, $kolom, $where, $array)
	{
		try
		{
			$sql="UPDATE $table SET $kolom WHERE $where";
			$stmt=$this->link->prepare($sql);
			$stmt->execute($array);
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}
	}
	public function delete($table, $where, $kolom, $data)
	{
		try
		{
			$sql="DELETE FROM $table WHERE $where";
			$stmt=$this->link->prepare($sql);
			$stmt->bindParam(":$kolom",$data);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function cekData($kolom, $table, $getdata)
	{
		try
		{
			$sql = "SELECT $kolom FROM $table WHERE $kolom=:$kolom";
			$stmt = $this->link->prepare($sql);
			$stmt->bindParam(":$kolom",$getdata);
			if($stmt->execute()):
				
				if($stmt->rowCount()==1):
					return true;
				else:
					return false;
				endif;
			endif;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function selectTable_limit($table, $start, $finish, $where=NULL, $order=null)
	{
		try
		{
			if(!empty($where)):
				$sql="SELECT * FROM $table WHERE $where $order LIMIT $start, $finish";
				$stmt=$this->link->prepare($sql);
				return $stmt;
			else:
				$sql="SELECT * FROM $table $order LIMIT $start, $finish";
				$stmt=$this->link->prepare($sql);
				return $stmt;
			endif;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}

	}
	public function selectTable_limit2($table, $start, $finish, $where=null, $getData=NULL, $order=null)
	{
		try
		{
			if(!empty($where)):
				$sql="SELECT * FROM $table WHERE $where=:$where $order LIMIT $start, $finish";
				$stmt=$this->link->prepare($sql);
				$stmt->bindParam(":$where",$getData);
				
				return $stmt;
			else:
				$sql="SELECT * FROM $table $order LIMIT $start, $finish";
				$stmt=$this->link->prepare($sql);
				return $stmt;
			endif;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}

	}
	public function pagination($name, $table, $number, $where=null, $order=null)
	{
		
		$finish=$number;
		$page=isset($_GET[$name])? (int)$_GET[$name]:1;
		$start=($page>1) ? ($page * $finish) - $finish:0;
		$stmt=(!empty($where))?$this->selectTable_limit($table,$start, $finish, $where, $order):$this->selectTable_limit($table,$start,$finish,NULL,$order);		
		$stmt->execute();
		return $stmt;
	}
	
	public function paginationNumber($table, $number, $url=null, $name=null, $where=null)
	{
		$nopage = isset($_GET[$name])? (int)$_GET[$name]:1;	
		$stmt=$this->selectTable($table, $where);
		(!empty($where))?$stmt->execute():'';
		$total=$stmt->rowCount();
		$jumpage=ceil($total/$number);
		
		echo'<nav aria-label="Page navigation"><ul class="pagination">';
		echo ($nopage>1)?'<li><a href="?'.$url.'&halaman='.($nopage-1).'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>':NULL;
			
		
		for($page=1; $page<=$jumpage; $page++)
		{
			
			

			if(($page>=$nopage-2)&&($page<=$nopage+2)||($page==1)||($page==$jumpage))
			{
				$tampilpage = $page;
				$r=($tampilpage==1) && ($tampilpage!=2)? '..':NULL;
				$x=($nopage==($jumpage-1)) || ($nopage==$jumpage)?'.':NULL;
				/**
				if(($nopage==($jumpage-1)) || ($nopage==$jumpage)){
					echo '.';
				}else{
					NULL;
				}	

				**/		
				
				$class=($page==$nopage)?'active':NULL;
				echo '<li class="'.$class.'"><a class="page-link" href="?'.$url.'&halaman='.$page.'">'.$page.'</a></li>';

				
			}
		}

		echo($nopage>=$jumpage)?NULL:'<li><a href="?'.$url.'&halaman='.($nopage+1).'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
		echo '</ul></nav>';

	
	}
	public function pagination2($name, $table, $number, $where=NULL, $getData=NULL, $order=null)
	{
		
		$finish=$number;
		$page=isset($_GET[$name])? (int)$_GET[$name]:1;
		$start=($page>1) ? ($page * $finish) - $finish:0;
		$stmt=(!empty($where))?$this->selectTable_limit2($table,$start, $finish, $where, $getData, $order):$this->selectTable_limit2($table, $start,$finish, NULL, $getData, $order);		
		$stmt->execute();
		return $stmt;
	}
	public function paginationNumber2($table, $number, $url=null, $name=null, $where=null, $getData=NULL, $order=null)
	{
		$nopage = isset($_GET[$name])? (int)$_GET[$name]:1;	
		$stmt=$this->selectTable2($table, $where, $getData);
		(!empty($where))?$stmt->execute():'';
		$name_order=(!empty($_GET['name']))?'&name='.$_GET['name'].'':NULL;
		$order=(!empty($_GET['order']))?'&order='.$_GET['order'].'':NULL;
		$total=$stmt->rowCount();
		$jumpage=ceil($total/$number);
		
		echo'<nav aria-label="Page navigation"><ul class="pagination">';
		echo ($nopage>1)?'<li><a href="?'.$url.'&halaman='.($nopage-1).'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>':NULL;
			
		
		for($page=1; $page<=$jumpage; $page++)
		{
			
			

			if(($page>=$nopage-2)&&($page<=$nopage+2)||($page==1)||($page==$jumpage))
			{
				//$tampilpage = $page;
				//$r=($tampilpage==1) && ($tampilpage!=2)? '..':NULL;
				//$x=($nopage==($jumpage-1)) || ($nopage==$jumpage)?'.':NULL;
				/**
				if(($nopage==($jumpage-1)) || ($nopage==$jumpage)){
					echo '.';
				}else{
					NULL;
				}	

				**/		
				
				$class=($page==$nopage)?'active':NULL;
				echo '<li class="'.$class.'"><a href="?'.$url.$name_order.'&halaman='.$page.'">'.$page.'</a></li>';

				
			}
		}

		echo($nopage>=$jumpage)?NULL:'<li><a href="?'.$url.$name_order.$order.'&halaman='.($nopage+1).'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
		echo '</ul></nav>';

	
	}
	public function paginationNumberBootstrap($table, $number, $url=null, $name=null, $where=null)
	{
		$nopage = isset($_GET[$name])? (int)$_GET[$name]:1;	
		$stmt=$this->selectTable($table, $where);
		(!empty($where))?$stmt->execute():'';
		$total=$stmt->rowCount();
		$jumpage=ceil($total/$number);
		
		echo'<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';
		echo ($nopage>1)?'<li class="page-item"><a class="page-link" href="?'.$url.'&halaman='.($nopage-1).'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>':NULL;
			
		
		for($page=1; $page<=$jumpage; $page++)
		{
			
			

			if(($page>=$nopage-2)&&($page<=$nopage+2)||($page==1)||($page==$jumpage))
			{
				$tampilpage = $page;
				$r=($tampilpage==1) && ($tampilpage!=2)? '..':NULL;
				$x=($nopage==($jumpage-1)) || ($nopage==$jumpage)?'.':NULL;
				/**
				if(($nopage==($jumpage-1)) || ($nopage==$jumpage)){
					echo '.';
				}else{
					NULL;
				}	

				**/		
				
				$class=($page==$nopage)?'active':'page-item';
				echo '<li class="'.$class.'"><a class="page-link" href="?'.$url.'&halaman='.$page.'">'.$page.'</a></li>';

			
			}
		}

		echo($nopage>=$jumpage)?NULL:'<li class="page-item"><a class="page-link" href="?'.$url.'&halaman='.($nopage+1).'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
		echo '</ul></nav>';

	
	}
	
	public function searchData($tabel, $kolom1, $data, $kolom2=null, $limit=null)
	{
		try
		{
			

			$keyword="$data%";
			if(!empty($kolom2)):
				$sql="SELECT * FROM $tabel WHERE $kolom1 LIKE '$data%' OR $kolom2 LIKE '$data%' $limit";
				$stmt=$this->link->prepare($sql);				
				//$stmt->bindParam(":$data",$keyword, PDO::PARAM_STR);
				$stmt->execute();				
				return $stmt;
			else:
				$sql="SELECT * FROM $tabel WHERE $kolom1 LIKE '$data%' $limit";
				$stmt=$this->link->prepare($sql);
				return $stmt;
			endif;
			
		}
		catch(PDOEXception $e)
		{
			echo $e->getMessage();
		}

	}

	
	public function __destruct()
	{
		return true;
	}

	
	
}


?>
