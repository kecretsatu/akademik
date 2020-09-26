
<?php
	$formUpdate = false;
	$data = array(); 
	$tahun; $prodi; $matkul;
	
	if(isset($_GET['f_kode_ajaran'])){
		$result		= mysqli_query($con, "select * from tahun_ajaran where kode_ajaran = '".$_GET['f_kode_ajaran']."'");
		$tahun		= mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
	if(isset($_GET['f_kode_prodi'])){
		$result		= mysqli_query($con, "select * from prodi_identitas where kode_prodi = '".$_GET['f_kode_prodi']."'");
		$prodi		= mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
	if(isset($_GET['f_kode_mk'])){		
		$result		= mysqli_query($con,"select * from mata_kuliah where kode_mk = '".$_GET['f_kode_mk']."'") ;
		$matkul		= mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
	
	if(strpos($pageForm, 'update') !== false){
		$formUpdate 	= true;
		$result		= mysqli_query($con,"select * from kelas where kode_kelas = '".$_GET['p']."'") ;
		$data 		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result		= mysqli_query($con, "select * from tahun_ajaran where kode_ajaran = '".$data['kode_ajaran']."'");
		$tahun		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result		= mysqli_query($con, "select * from prodi_identitas where kode_prodi = '".$data['kode_prodi']."'");
		$prodi		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result		= mysqli_query($con,"select * from mata_kuliah where kode_mk = '".$data['kode_mk']."'") ;
		$matkul		= mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
?>

<div id="page-kelas-frm" class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<form id="m_kelas_frm">
			<input type="hidden" name="name" value="<?php echo getTableAlias(1,'kelas'); ?>" />
			<input name="ctl_kode_kelas" type="hidden" class="form-control input-sm" style="width:150px" value="<?php if($formUpdate){echo $data['kode_kelas'];}else{echo 'generatecode';} ?>" />
			
			<div class="form-group ">
				<div class="form-group form-inline cari-tahun-ajaran">
					<label>Tahun Ajaran</label>
					<input name="ctl_kode_ajaran" value="<?php if($formUpdate || isset($_GET['f_kode_ajaran'])){echo $tahun["kode_ajaran"];} ?>" type="text" class="form-control input-sm control-return" data-return = "kode" style="width:100px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate || isset($_GET['f_kode_ajaran'])){echo $tahun["tahun"];} ?>" class="form-control input-sm control-return" data-return = "tahun" style="width:180px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate || isset($_GET['f_kode_ajaran'])){echo $tahun["semester"];} ?>" class="form-control input-sm control-return" data-return = "semester" style="width:70px" readonly="readonly"/>
					<button type="button" class="btn btn-warning btn-sm" dialog-mode="remove" onclick="showFormCari('.cari-tahun-ajaran', '<?php echo getTableAlias(1,'tahun_ajaran'); ?>', 'Tahun Ajaran');" >
						<span class="glyphicon glyphicon-search"></span> </button>
				</div>
				<div class="form-group form-inline cari-prodi">
					<label>Program Studi</label>
					<input name="ctl_kode_prodi" value="<?php if($formUpdate || isset($_GET['f_kode_prodi'])){echo $prodi["kode_prodi"];} ?>" type="text" class="form-control input-sm control-return" data-return = "kode_prodi" style="width:100px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate || isset($_GET['f_kode_prodi'])){echo $prodi["jenjang"];} ?>" class="form-control input-sm control-return" data-return = "jenjang" style="width:45px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate || isset($_GET['f_kode_prodi'])){echo $prodi["nama_prodi"];} ?>" class="form-control input-sm control-return" data-return = "nama_prodi" style="width:205px" readonly="readonly"/>
					<button type="button" class="btn btn-warning btn-sm" dialog-mode="remove" onclick="showFormCari('.cari-prodi', 'prodi', 'Program Studi');" >
						<span class="glyphicon glyphicon-search"></span> </button>
				</div>
			</div>
			<div class="form-group ">
				<div class="form-group form-inline cari-mata-kuliah">
					<label>Mata Kuliah</label>
					<input name="ctl_kode_mk" value="<?php if($formUpdate || isset($_GET['f_kode_mk'])){echo $matkul["kode_mk"];} ?>" type="text" class="form-control input-sm control-return" data-return = "kode_mk" style="width:100px" readonly="readonly"/>
					<input type="text" value="<?php if($formUpdate || isset($_GET['f_kode_mk'])){echo $matkul["nama_mk"];} ?>" class="form-control input-sm control-return" data-return = "nama_mk" style="width:255px" readonly="readonly"/>
					<button type="button" class="btn btn-warning btn-sm" dialog-mode="remove" onclick="showFormCari('.cari-mata-kuliah', '<?php echo getTableAlias(1,'mata_kuliah'); ?>', 'Mata Kuliah');" >
						<span class="glyphicon glyphicon-search"></span> </button>
				</div>
				<div class="form-group form-inline">
					<label>Nama Kelas</label>
					<input name="ctl_nama_kelas" type="text" class="form-control input-sm" style="width:70px" value="<?php if($formUpdate){echo $data['nama_kelas'];} ?>" />
					<label style="width:130px">(contoh: A atau B)</label>
					<label style="width:199px">&nbsp;</label>
				</div>
				<div class="form-group form-inline">
					<label>Keterangan</label>
					<textarea name="ctl_keterangan" class="form-control input-sm" style="width:400px; height:100px" > <?php if($formUpdate){echo $data['keterangan'];} ?></textarea>
				</div>
			</div>
			<div class="form-group form-inline">
					<label>&nbsp;</label>
					<button type="button" class="btn btn-success" onclick="datasave('#m_kelas_frm')">Simpan</button>
					<button type="button" class="btn btn-danger" dialog-mode="remove" data-rel="back">Batal</button>
			</div>
		</form>
	</nav>
</div>

<style>
	form label{width:100px;}
</style>