
<?php
	$formUpdate = false;
	$data = array();
	if(strpos($pageForm, 'update') !== false){
		$formUpdate 	= true;
		$result		= mysqli_query($con,"select * from fakultas where kode_fakultas = '".$_GET['p']."'") ;
		$data 		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		//$data		= $data[0];
	}
?>

<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<form id="m_fakultas_frm">
			<input type="hidden" name="name" value="<?php echo getTableAlias(1,'fakultas'); ?>" />
			<div class="row">
				<div class="col-md-7">
					<div class="form-inline">
						<label>Kode Fakultas</label>
						<input name="ctl_kode_fakultas" type="text" <?php if($formUpdate){echo 'readonly="readonly"';} ?> value="<?php if($formUpdate){echo $data['kode_fakultas'];} ?>" class="form-control input-sm" style="width:150px" />
					</div>
					<div class="form-inline">
						<label>Nama Fakultas</label>
						<input name="ctl_nama_fakultas" type="text" value="<?php if($formUpdate){echo $data['nama_fakultas'];} ?>" class="form-control input-sm" style="width:79%" />
					</div>
					<div class="form-inline">
						<label>&nbsp;</label>
						<button type="button" class="btn btn-success" onclick="datasave('#m_fakultas_frm')">Simpan</button>
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