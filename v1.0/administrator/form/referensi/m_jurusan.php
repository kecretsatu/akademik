
<?php
	$formUpdate = false;
	$data = array(); $data2 = array();
	
	if(strpos($pageForm, 'update') !== false){
		$formUpdate 	= true;
		$result		= mysqli_query($con,"select * from jurusan where kode_jurusan = '".$_GET['p']."'") ;
		$data 		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result2	= mysqli_query($con,"select * from fakultas where kode_fakultas = '".$data['kode_fakultas']."'") ;
		$data2 		= mysqli_fetch_array($result2, MYSQLI_ASSOC);
	}
?>

<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<form id="m_jurusan_frm">
			<input type="hidden" name="name" value="<?php echo getTableAlias(1,'jurusan'); ?>" />
			<div class="row">
				<div class="col-md-7">
					<div class="form-inline">
						<label>Kode Jurusan</label>
						<input name="ctl_kode_jurusan" <?php if($formUpdate){echo 'readonly="readonly"';} ?> type="text" class="form-control input-sm" style="width:150px" value="<?php if($formUpdate){echo $data['kode_jurusan'];} ?>" />
					</div>
					<div class="form-inline">
						<label>Nama Jurusan</label>
						<input name="ctl_nama_jurusan" type="text" class="form-control input-sm" style="width:79%" value="<?php if($formUpdate){echo $data['nama_jurusan'];} ?>" />
					</div>
					<div class="form-inline cari-fakultas">
						<label>Fakultas</label>
						<input name="ctl_kode_fakultas" type="text" readonly="readonly" class="form-control input-sm control-return" data-return="kode_fakultas" style="width:150px" 
							value="<?php if($formUpdate){echo $data2['kode_fakultas'];} ?>"/>
						<input type="text" readonly="readonly" class="form-control input-sm control-return" data-return="nama_fakultas" style="width:49%" 
							value="<?php if($formUpdate){echo $data2['nama_fakultas'];} ?>"/>
						<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-fakultas', '<?php echo getTableAlias(1,'fakultas'); ?>', 'fakultas');">
							<span class="glyphicon glyphicon-search"></span> </a>
					</div>
					<div class="form-inline">
						<label>&nbsp;</label>
						<button type="button" class="btn btn-success" onclick="datasave('#m_jurusan_frm')">Simpan</button>
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