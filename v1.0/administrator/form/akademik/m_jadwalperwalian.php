
<?php
	$formUpdate = false;
	$data = array();
	$tahun; $prodi; 
	
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
		
		$result		= mysqli_query($con, "select * from perwalian_jadwal where kode_perwalian_jadwal = '".$_GET['p']."'");
		$data		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result		= mysqli_query($con, "select * from tahun_ajaran where kode_ajaran = '".$data['kode_ajaran']."'");
		$tahun		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result		= mysqli_query($con, "select * from prodi_identitas where kode_prodi = '".$data['kode_prodi']."'");
		$prodi		= mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
?>


<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<form id="m_jadwal_perwalian_frm">
			<input type="hidden" name="name" value="<?php echo getTableAlias(1,'perwalian_jadwal'); ?>" />
			<input type="hidden" name="ctl_kode_perwalian_jadwal"  value="<?php if($formUpdate){echo $data["kode_perwalian_jadwal"];}else{echo "generatecode";} ?>" />
			<div class="form-group">
				<div class="form-inline cari-tahun-ajaran" style="margin-bottom:5px">
					<label>Tahun Ajaran</label>
					<input name="ctl_kode_ajaran" value="<?php if($formUpdate || isset($_GET['f_kode_ajaran'])){echo $tahun["kode_ajaran"];} ?>" type="text" class="form-control input-sm control-return" data-return = "kode" style="width:70px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate || isset($_GET['f_kode_ajaran'])){echo $tahun["tahun"];} ?>" class="form-control input-sm control-return" data-return = "tahun" style="width:195px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate || isset($_GET['f_kode_ajaran'])){echo $tahun["semester"];} ?>" class="form-control input-sm control-return" data-return = "semester" style="width:100px" readonly="readonly"/>
					<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-tahun-ajaran', '<?php echo getTableAlias(1,'tahun_ajaran'); ?>', 'Tahun Ajaran');" >
						<span class="glyphicon glyphicon-search"></span> </button>
				</div>
				<div class="form-inline cari-prodi" style="margin-bottom:5px">
					<label>Program Studi</label>
					<input name="ctl_kode_prodi" value="<?php if($formUpdate || isset($_GET['f_kode_prodi'])){echo $prodi["kode_prodi"];} ?>" type="text" class="form-control input-sm control-return" data-return = "kode_prodi" style="width:70px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate || isset($_GET['f_kode_prodi'])){echo $prodi["jenjang"];} ?>" class="form-control input-sm control-return" data-return = "jenjang" style="width:45px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate || isset($_GET['f_kode_prodi'])){echo $prodi["nama_prodi"];} ?>" class="form-control input-sm control-return" data-return = "nama_prodi" style="width:250px" readonly="readonly"/>
					<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-prodi', 'prodi', 'Program Studi');" >
						<span class="glyphicon glyphicon-search"></span> </button>
				</div>
				<div class="form-inline" style="margin-bottom:5px">
					<label>Tanggal Mulai</label>
					<input name="ctl_tanggal_mulai" value="<?php if($formUpdate){echo $data["tanggal_mulai"];} ?>" type="date" class="form-control input-sm" />
				</div>
				<div class="form-inline" style="margin-bottom:5px">
					<label>Tanggal Selesai</label>
					<input name="ctl_tanggal_selesai" value="<?php if($formUpdate){echo $data["tanggal_selesai"];} ?>" type="date" class="form-control input-sm" />
				</div>
				<div class="form-inline" style="margin-bottom:5px">
					<label>Keterangan</label>
					<textarea name="ctl_keterangan" class="form-control input-sm" style="width:415px; height:100px" ><?php if($formUpdate){echo $data["keterangan"];} ?></textarea>
				</div>
				<div class="form-inline cari-matkul-2" style="margin-bottom:5px">
					<label>&nbsp;</label>
					<button type="button" class="btn btn-success btn-sm" onclick="datasave('#m_jadwal_perwalian_frm')" style="width:70px"  >Simpan</button>
					<button type="button" class="btn btn-danger btn-sm" data-rel="back"  style="width:70px" >Batal</button>
				</div>
			</div>
		</form>
	</nav>
</div>

<style>
	form label{width:150px;)
</style>