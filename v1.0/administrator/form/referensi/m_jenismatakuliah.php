
<?php
	$formUpdate = false;
	$data = array(); 
	
	if(strpos($pageForm, 'update') !== false){
		$formUpdate 	= true;
		$result		= mysqli_query($con,"select * from mata_kuliah_jenis where kode_jenis = '".$_GET['p']."'") ;
		$data 		= mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
?>

<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<form id="m_matkul_jns_frm">
			<input type="hidden" name="name" value="<?php echo getTableAlias(1,'mata_kuliah_jenis'); ?>" />
			<div class="row">
				<div class="col-md-7">
					<div class="form-inline">
						<label>Kode Jenis</label>
						<input name="ctl_kode_jenis" type="text" class="form-control input-sm" style="width:150px" value="<?php if($formUpdate){echo $data['kode_jenis'];} ?>" />
					</div>
					<div class="form-inline">
						<label>Nama Jenis</label>
						<input name="ctl_nama_jenis" type="text" class="form-control input-sm" style="width:79%" value="<?php if($formUpdate){echo $data['nama_jenis'];} ?>" />
					</div>
					<div class="form-inline">
						<label>&nbsp;</label>
						<button type="button" class="btn btn-success" onclick="datasave('#m_matkul_jns_frm')">Simpan</button>
						<button type="button" class="btn btn-danger" data-rel="back">Batal</button>
					</div>
				</div>
			</div>
		</form>
	</nav>
</div>

<style>
	form label{width:20%; margin-bottom:10px}
</style>