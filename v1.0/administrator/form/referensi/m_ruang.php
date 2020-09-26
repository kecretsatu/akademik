
<?php
	$formUpdate = false;
	$data = array();
	if(strpos($pageForm, 'update') !== false){
		$formUpdate 	= true;
		$result		= mysqli_query($con,"select * from ruang where kode_ruang = '".$_GET['p']."'") ;
		$data 		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		//$data		= $data[0];
	}
?>

<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<form id="m_ruang_frm">
			<input type="hidden" name="name" value="<?php echo getTableAlias(1,'ruang'); ?>" />
			<div class="row">
				<div class="col-md-7">
					<div class="form-inline">
						<label>Ruang</label>
						<input name="ctl_kode_ruang" type="text" class="form-control input-sm" style="width:405px" value="<?php if($formUpdate){echo $data['kode_ruang'];} ?>" />
					</div>
					<div class="form-inline">
						<label>Kapasitas Kuliah</label>
						<input name="ctl_kapasitas_kuliah" type="text" class="form-control input-sm" style="width:135px" value="<?php if($formUpdate){echo $data['kapasitas_kuliah'];} ?>" />
						<label>Kapasitas Ujian</label>
						<input name="ctl_kapasitas_ujian" type="text" class="form-control input-sm" style="width:135px" value="<?php if($formUpdate){echo $data['kapasitas_ujian'];} ?>" />
					</div>
					<div class="form-inline">
						<label>&nbsp;</label>
						<button type="button" class="btn btn-success" onclick="datasave('#m_ruang_frm')">Simpan</button>
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