
<?php
$hari = array("senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu");
?>

<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<form id="m_jadwal_c_frm">
		<div class="form-group form-inline " style="border:0px solid black">
				<div class="form-group cari-tahun-ajaran ">
					<label>Tahun Ajaran</label>
					<input name="f_kode_ajaran" value="" type="hidden" class="form-control input-sm control-return" data-return = "kode" style="width:70px" readonly="readonly"/>
					<input type="text" value="" class="form-control input-sm control-return" data-return = "tahun" style="width:195px" readonly="readonly"/>
					<input type="text" value="" class="form-control input-sm control-return" data-return = "semester" style="width:70px" readonly="readonly"/>
					<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-tahun-ajaran', '<?php echo getTableAlias(1,'tahun_ajaran'); ?>', 'Tahun Ajaran');" >
						<span class="glyphicon glyphicon-search"></span> </button>
				</div>
		</div><hr/>
		<div class="form-group form-inline">
				<div class="form-group cari-prodi ">
					<label>Hari Aktif</label>
					<select name="ctl_hari_1" class="form-control input-sm"  style="width:80px; padding-left:2px">
						<?php
							foreach($hari as $h){
								echo '<option value="'.$h.'" >'.ucfirst($h).'</option>';
							}
						?>
					</select>
					<label style="width:40px; text-align:center">s/d</label>
					<select name="ctl_hari_2" class="form-control input-sm"  style="width:80px; padding-left:2px">
						<?php
							foreach($hari as $h){
								echo '<option value="'.$h.'" >'.ucfirst($h).'</option>';
							}
						?>
					</select>
				</div>
		</div><hr/>
		<div class="form-group form-inline">
				<div class="form-group">
					<label style="width:100px">Waktu Aktif</label>						
					<div class="input-group bootstrap-timepicker timepicker waktu-mulai"  style="width:100px">
						<input name="ctl_mulai" class="form-control input-small timepicker" value="" type="text"/>
							<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
					</div>
					<label style="width:40px; text-align:center">s/d</label>
					<div class="input-group bootstrap-timepicker waktu-selesai"  style="width:100px">
						<input name="ctl_selesai" class="form-control input-small timepicker" value="" type="text"/>
							<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
					</div>
				</div>
		</div><hr/>
		<div class="form-group form-inline">
				<label style="width:100px">&nbsp;</label>		
				<button id="btn-simpan" type="button" class="btn btn-primary btn-sm" onclick="penjadwalan_kolektif_save()()"  >
					<span class="glyphicon glyphicon-pushpin"></span> Bentuk Jadwal & Kelas</button>
		</div>
		</form>
	</nav>
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<span id="status-saving" style="font-size:12px; display:none">Silahkan tunggu. Sistem sedang membentuk data penjadwalan. Anda akan diarahkan menuju jadwal yang terlah terbentuk setelah proses selesai.</span>
	</nav>
</div>

<script src="<?php echo $BASE_URL ;?>/js/penjadwalankolektif.js"></script>
<script>
	function navigate_to_penjadwalan(){
		window.location.href="<?php echo $BASE_URL; ?>/akademik/penjadwalankuliah";
	}
</script>
<style>
	form label{width:100px;}
</style>

