
<?php
	$formUpdate = false;
	$data = array();
	$tahun; $prodi; $matkul1; $matkul2;
	
	if(isset($_GET['f_kode_ajaran'])){
		$result		= mysqli_query($con, "select * from tahun_ajaran where kode_ajaran = '".$_GET['f_kode_ajaran']."'");
		$tahun		= mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
	if(isset($_GET['f_kode_prodi'])){
		$result		= mysqli_query($con, "select * from prodi_identitas where kode_prodi = '".$_GET['f_kode_prodi']."'");
		$prodi		= mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
	
	if(strpos($pageForm, 'update') !== false || strpos($pageForm, 'dosen') !== false){
		$formUpdate = true;
		
		$result		= mysqli_query($con, "select * from rencana_studi where kode_rencana_studi = '".$_GET['p']."'");
		$data		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result		= mysqli_query($con, "select * from tahun_ajaran where kode_ajaran = '".$data['kode_ajaran']."'");
		$tahun		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result		= mysqli_query($con, "select * from prodi_identitas where kode_prodi = '".$data['kode_prodi']."'");
		$prodi		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result		= mysqli_query($con,"select * from mata_kuliah where kode_mk = '".$data['kode_mk']."'") ;
		$matkul1	= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result		= mysqli_query($con,"select * from mata_kuliah where kode_mk = '".$data['kode_mk_syarat']."'") ;
		$matkul2	= mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
?>


<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<form id="m_rencana_studi_frm">
			<input type="hidden" name="name" value="<?php echo getTableAlias(1,'rencana_studi'); ?>" />
			<input type="hidden" name="ctl_kode_rencana_studi"  value="<?php if($formUpdate){echo $data["kode_rencana_studi"];}else{echo "generatecode";} ?>" />
			<div class="form-group">
				<div class="form-inline cari-tahun-ajaran" style="margin-bottom:5px">
					<label>Tahun Ajaran</label>
					<input name="ctl_kode_ajaran" value="<?php if($formUpdate || isset($_GET['f_kode_ajaran'])){echo $tahun["kode_ajaran"];} ?>" type="text" class="form-control input-sm control-return" data-return = "kode" style="width:100px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate || isset($_GET['f_kode_ajaran'])){echo $tahun["tahun"];} ?>" class="form-control input-sm control-return" data-return = "tahun" style="width:195px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate || isset($_GET['f_kode_ajaran'])){echo $tahun["semester"];} ?>" class="form-control input-sm control-return" data-return = "semester" style="width:100px" readonly="readonly"/>
					<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-tahun-ajaran', '<?php echo getTableAlias(1,'tahun_ajaran'); ?>', 'Tahun Ajaran');" >
						<span class="glyphicon glyphicon-search"></span> </button>
				</div>
				<div class="form-inline cari-prodi" style="margin-bottom:5px">
					<label>Program Studi</label>
					<input name="ctl_kode_prodi" value="<?php if($formUpdate || isset($_GET['f_kode_prodi'])){echo $prodi["kode_prodi"];} ?>" type="text" class="form-control input-sm control-return" data-return = "kode_prodi" style="width:100px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate || isset($_GET['f_kode_prodi'])){echo $prodi["jenjang"];} ?>" class="form-control input-sm control-return" data-return = "jenjang" style="width:45px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate || isset($_GET['f_kode_prodi'])){echo $prodi["nama_prodi"];} ?>" class="form-control input-sm control-return" data-return = "nama_prodi" style="width:250px" readonly="readonly"/>
					<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-prodi', 'prodi', 'Program Studi');" >
						<span class="glyphicon glyphicon-search"></span> </button>
				</div>
				<div class="form-inline cari-prodi" style="margin-bottom:5px">
					<label>Semester</label>
					<input name="ctl_semester" value="<?php if($formUpdate){echo $data["semester"];} ?>" type="number" class="form-control input-sm" style="width:70px" />
				</div>
				<div class="form-inline cari-matkul-1" style="margin-bottom:5px">
					<label>Mata Kuliah</label>
					<input name="ctl_kode_mk" value="<?php if($formUpdate){echo $matkul1["kode_mk"];} ?>" type="text" class="form-control input-sm control-return" data-return = "kode_mk" style="width:100px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate){echo $matkul1["sks"];} ?>" class="form-control input-sm control-return" data-return = "sks" style="width:45px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate){echo $matkul1["nama_mk"];} ?>" class="form-control input-sm control-return" data-return = "nama_mk" style="width:350px" readonly="readonly"/>
					<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-matkul-1', '<?php echo getTableAlias(1,'mata_kuliah'); ?>', 'mata kuliah');" >
						<span class="glyphicon glyphicon-search"></span> </button>
				</div>
				<div class="form-inline cari-matkul-2" style="margin-bottom:5px">
					<label>Mata Kuliah Syarat</label>
					<input name="ctl_kode_mk_syarat" value="<?php if($formUpdate){echo $matkul2["kode_mk"];} ?>" type="text" class="form-control input-sm control-return" data-return = "kode_mk" style="width:100px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate){echo $matkul2["sks"];} ?>" class="form-control input-sm control-return" data-return = "sks" style="width:45px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate){echo $matkul2["nama_mk"];} ?>" class="form-control input-sm control-return" data-return = "nama_mk" style="width:350px" readonly="readonly"/>
					<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-matkul-2', '<?php echo getTableAlias(1,'mata_kuliah'); ?>', 'mata kuliah');" >
						<span class="glyphicon glyphicon-search"></span> </button>
				</div>
				<div class="form-inline cari-matkul-2" style="margin-bottom:5px">
					<label>&nbsp;</label>
					<button type="button" class="btn btn-success btn-sm" onclick="datasave('#m_rencana_studi_frm')" style="width:100px"  >Simpan</button>
					<button type="button" class="btn btn-danger btn-sm" data-rel="back"  style="width:100px" >Batal</button>
				</div>
			</div>
		</form>
	</nav>
</div>

<style>
	form label{width:150px;)
</style>