
<?php
	$hari = array("senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu");
	$thisHari = '';
	
	if(isset($_GET['hari'])){$thisHari = $_GET['hari'];}
	
	$formUpdate = false;
	$data = array();
	$matkul; $dosen;  $prodi; 
	$kode_ajaran = execqueryreturn("tahun_ajaran","select kode_ajaran from tahun_ajaran where status = 1");
	
	$rs = null;
	if(strpos($pageForm, 'tambah') !== false ){
		if(isset($_GET['rs'])){
			$rs			= $_GET['rs'];
			$result		= mysqli_query($con, "select * from prodi_identitas where kode_prodi = (select kode_prodi from rencana_studi where kode_rencana_studi = '".$rs."')");
			$prodi		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
			$result		= mysqli_query($con,"select * from mata_kuliah where kode_mk = (select kode_mk from rencana_studi where kode_rencana_studi = '".$rs."')");
			$matkul		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		}
	}
	if(strpos($pageForm, 'update') !== false ){
		$formUpdate = true;
		
		$result		= mysqli_query($con, "select * from jadwal_kuliah where kode_jadwal = '".$_GET['p']."'");
		$data		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		$thisHari	= $data['hari'];
		
		$result		= mysqli_query($con, "select * from tahun_ajaran where kode_ajaran = '".$data['kode_ajaran']."'");
		$tahun		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result		= mysqli_query($con, "select * from prodi_identitas where kode_prodi = '".$data['kode_prodi']."'");
		$prodi		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result		= mysqli_query($con,"select * from mata_kuliah where kode_mk = '".$data['kode_mk']."'") ;
		$matkul		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result		= mysqli_query($con,"select nidn, nama_dosen from dosen_biodata where nidn = '".$data['nidn']."'") ;
		$dosen		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result		= mysqli_query($con,"select * from ruang where kode_ruang = '".$data['kode_ruang']."'") ;
		$ruang		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result		= mysqli_query($con,"select k.*, (select count(*) from civitas_perwalian where kode_kelas = k.kode_kelas) as 'peserta' 
						from kelas k where k.kode_kelas = '".$data['kode_kelas']."'") ;
		$kelas		= mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
?>

<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<form id="m_jadwal_kuliah_frm">
			<input type="hidden" name="name" value="<?php echo getTableAlias(1,'jadwal_kuliah'); ?>" />
			<input type="hidden" name="ctl_kode_jadwal"  value="<?php if($formUpdate){echo $data["kode_jadwal"];}else{echo "generatecode";} ?>" />
			<input type="hidden" name="ctl_kode_ajaran"  value="<?php echo $kode_ajaran; ?>" />
			<input type="hidden" name="ctl_kode_rencana_studi"  value="<?php if(isset($_GET['rs'])){echo $_GET["rs"];} ?>" />
			<div class="row">
				<div class="col-md-8">		
					<div class="cari-jadwal">
						<div class="form-inline cari-prodi" style="margin-bottom:5px">
							<label>Program Studi</label>
							<input name="ctl_kode_prodi" value="<?php if($formUpdate || isset($_GET['f_kode_prodi']) || $rs){echo $prodi["kode_prodi"];}?>" type="text" class="form-control input-sm control-return" data-return = "kode_prodi" style="width:80px" readonly="readonly"/>
							<input type="text" value="<?php if($formUpdate || isset($_GET['f_kode_prodi']) || $rs){echo $prodi["jenjang"];} ?>" class="form-control input-sm control-return" data-return = "jenjang" style="width:55px" readonly="readonly"/>
							<input type="text" value="<?php if($formUpdate || isset($_GET['f_kode_prodi']) || $rs){echo $prodi["nama_prodi"];} ?>" class="form-control input-sm control-return" data-return = "nama_prodi" style="width:250px" readonly="readonly"/>
							<button type="button" class="btn btn-warning btn-sm" <?php if($rs){echo 'disabled="disabled"' ;} ?> onclick="showFormCari('.cari-prodi', 'prodi', 'Program Studi');" >
								<span class="glyphicon glyphicon-search"></span> </button>
						</div>					
						<div class="form-inline cari-matkul">
							<label>Mata Kuliah</label>
							<input name="ctl_kode_mk" type="text" value="<?php if($formUpdate || $rs){echo $matkul["kode_mk"];} ?>" class="form-control input-sm control-return" readonly="readonly" data-return="kode_mk" style="width:80px" />
							<input type="text" value="<?php if($formUpdate || $rs){echo $matkul["nama_mk"];} ?>" class="form-control input-sm control-return" readonly="readonly" data-return="nama_mk" style="width:275px" />
							<input type="text" value="<?php if($formUpdate || $rs){echo $matkul["sks"];} ?>" class="form-control input-sm control-return" readonly="readonly" data-return="sks" style="width:30px" />
							<a href="javascript:void(0)" class="btn btn-warning btn-sm" <?php if($rs){echo 'disabled="disabled"' ;} ?> onclick="showFormCari('.cari-matkul', 'penjadwalan_matkul','mata kuliah', setWaktuSelesai, '.cari-jadwal'); ">
								<span class="glyphicon glyphicon-search"></span> </a>
						</div>
						<hr/>
						<div class="form-inline">
							<label>Hari</label>
							<?php if(!$formUpdate){ ?>
							<select name="ctl_hari" class="form-control input-sm"  style="width:80px; padding-left:2px">
								<?php
									foreach($hari as $h){
										if($h == $thisHari){
											echo '<option value="'.$h.'" selected="selected" >'.ucfirst($h).'</option>';
										}
										else{
											echo '<option value="'.$h.'" >'.ucfirst($h).'</option>';
										}
									}
								?>
							<?php }else{ ?>
							<input type="text" name="ctl_hari" class="form-control input-sm" readonly="readonly" value="<?php echo $thisHari; ?>" style="width:80px;" />
							<?php } ?>
							</select>
							<label style="width:100px">Waktu</label>						
							<div class="input-group bootstrap-timepicker timepicker waktu-mulai"  style="width:100px">
								<input name="ctl_mulai" class="form-control input-small timepicker" value="<?php if($formUpdate){echo $data["mulai"];} ?>" onchange="setWaktuSelesai()" type="text"/>
									<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							</div>
							<label style="width:35px">s/d</label>
							<div class="input-group bootstrap-timepicker timepicker-disabled waktu-selesai"  style="width:100px">
								<input name="ctl_selesai" class="form-control input-small timepicker-disabled" value="<?php if($formUpdate){echo $data["selesai"];} ?>" readonly="readonly" type="text"/>
									<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							</div>
						</div>
						<hr/>
						
						<div class="form-inline cari-dosen">
							<label>Dosen</label>
							<input name="ctl_nidn" type="text" value="<?php if($formUpdate){echo $dosen["nidn"];} ?>" class="form-control input-sm control-return" readonly="readonly" data-return="nidn" style="width:80px" />
							<input type="text" value="<?php if($formUpdate){echo $dosen["nama_dosen"];} ?>" class="form-control input-sm control-return" readonly="readonly" data-return="nama" style="width:310px" />
							<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-dosen', 'penjadwalan_dosen', 'dosen', check_kapasitas, '.cari-jadwal');">
								<span class="glyphicon glyphicon-search"></span> </a>
						</div>
					</div><hr/>
					<div class="form-inline">
						<span class="cari-ruang">
						<label>Ruang</label>
							<input name="ctl_kode_ruang" type="text" class="form-control input-sm control-return" value="<?php if($formUpdate){echo $data["kode_ruang"];} ?>" readonly="readonly" data-return="ruang" style="width:80px" />
							<input type="text" class="form-control input-sm control-return" value="<?php if($formUpdate){echo $ruang["kapasitas_kuliah"];} ?>" readonly="readonly" data-return="kapasitas" style="width:45px" />
							<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-ruang', 'penjadwalan_ruang', 'ruang', check_kapasitas, '.cari-jadwal');">
								<span class="glyphicon glyphicon-search"></span> </a>
						</span>
						<span class="cari-kelas">
							<label style="padding-right:10px; text-align:right; width:90px">Kelas</label>
							<input type="hidden" name="ctl_kode_kelas" class="control-return" value="<?php if($formUpdate){echo $data["kode_kelas"];} ?>" data-return="kode_kelas" />
							<input type="text" class="form-control input-sm control-return" value="<?php if($formUpdate){echo $kelas["nama_kelas"];} ?>" readonly="readonly" data-return="kelas" style="width:80px" />
							<input type="text" class="form-control input-sm control-return" value="<?php if($formUpdate){echo $kelas["peserta"];} ?>" readonly="readonly" data-return="peserta" style="width:45px" />
							<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-kelas', 'penjadwalan_kelas', 'kelas', check_kapasitas, '.cari-jadwal');">
								<span class="glyphicon glyphicon-search"></span> </a>
						</span>
					</div><br/>
					<div id="status-kelas" class="form-inline" style="display:none">
						<label style="width:330px; font-size:12px; color:red">* Jumlah peserta lebih besar dari kapasitas ruang!</label>
						<a href="javascript:void(0)" onclick="tambah_kelas()" class="btn btn-info btn-sm" >
								<span class="glyphicon glyphicon-plus"></span> Tambah Kelas</a>
					</div>
					<hr/>
					<div class="form-inline">
						<label>&nbsp;</label>
						<button id="btn-save" type="button" class="btn btn-success" disabled="disabled" onclick="datasave('#m_jadwal_kuliah_frm')" style="width:100px">Simpan</button>
						<button type="button" class="btn btn-danger" data-rel="back" style="width:100px">Batal</button>
					</div>
				</div>
			</div>
		</form>
	</nav>
</div>

<style>
	form label{width:120px; margin-bottom:10px; padding-left:10px}
</style>

<script>

	$(document).ready(function(){
		check_kapasitas();
	});
	
	function tambah_kelas(){
		var fProdi = $('input[name="ctl_kode_prodi"]').val();
		var fAjaran = $('input[name="ctl_kode_ajaran"]').val();
		var fMk = $('input[name="ctl_kode_mk"]').val();
		
		$('.cari-kelas input').val('');
		
		show_form_page('<?php echo $BASE_URL; ?>/akademik/kelas/tambah?f_kode_ajaran='+fAjaran+'&f_kode_prodi='+fProdi+'&f_kode_mk='+fMk, ' #page-kelas-frm');
	}
	
	function check_kapasitas(){
		if($('input[data-return="kapasitas"]').val() == '' || $('input[data-return="peserta"]').val() == '' ){
			return false;
		}
		
		var kapasitas	= parseInt($('input[data-return="kapasitas"]').val());
		var peserta		= parseInt($('input[data-return="peserta"]').val());
		
		if(peserta > kapasitas){
			$('#status-kelas').show();
			$('#btn-save').attr("disabled", "disabled")
		}
		else{
			$('#status-kelas').hide();
			$('#btn-save').removeAttr("disabled")
		}
		
	}
	
	function setWaktuSelesai(){		
		var a = $('input[name="ctl_mulai"]').val(); 
		var b = $('input[data-return="sks"]').val();
		var c = $('.waktu-mulai').data("timepicker").getTime();
		var	d = b * 45; 
		
		a				= a.split(':'); 
		var newHour		= parseInt(d/60);
		var newMinute	= d - (newHour * 60);
		
		a				= (parseInt(a[0])+newHour) + ':' + (parseInt(a[1])+newMinute); 
		
		a				= a.split(':'); 
		newHour			= parseInt(a[1] / 60);
		newMinute		= a[1] - (newHour * 60);
		
		newHour			= parseInt(a[0])+parseInt(newHour);		
		var newTime		= (newHour + ":" + newMinute);		
		
		$('input[name="ctl_selesai"]').timepicker('setTime',newTime);
		
		$('.cari-dosen input').val('');
		$('.cari-ruang input').val('');
		$('.cari-kelas input').val('');
	}
</script>




