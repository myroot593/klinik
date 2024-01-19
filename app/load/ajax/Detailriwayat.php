<?php
require_once('../../../app/core/Ajaxloader.php');
if(isset($_POST['detail_keluhan']))
{
	if(!$obj->getTable('pasien_riwayat','riwayat_id=:riwayat_id', $_POST['detail_keluhan'],'riwayat_id'))
	{
		die("Error : Data tidak ditemukan");
	}
	else
	{

	?>
	<div class="row">
		<table class="table table-bordered">
			<tr>
				<td>Rincian Keluhan</td>
				<td><?=htmlspecialchars_decode($obj->row['keterangan_keluhan'])?></td>
			</tr>
			<tr>
				<td>Catatan Dokter</td>
				<td><?=$obj->row['catatan_dokter']?></td>
			</tr>
			<tr>
				<td>Catatan Resep</td>
				<td><?=$obj->row['catatan_resep']?></td>
			</tr>
		</table>
	</div>
<?php 
}
}
?>
