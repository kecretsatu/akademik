
<?php
	$formUpdate = false;
	$data = array(); $data2 = array();
	
	if(strpos($pageForm, 'update') !== false){
		$formUpdate 	= true;
		$result		= mysqli_query($con,"select * from keuangan_nilai where kode_keuangan = '".$_GET['p']."'") ;
		$data 		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result2	= mysqli_query($con,"select * from keuangan_jenis where kode_jenis = '".$data['kode_jenis']."'") ;
		$data2 		= mysqli_fetch_array($result2, MYSQLI_ASSOC);
	}
?>

<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<form id="m_keuangan_nilai_frm">
			<input type="hidden" name="name" value="<?php echo getTableAlias(1,'keuangan_nilai'); ?>" />
			<input name="ctl_kode_keuangan" type="hidden" value="<?php if($formUpdate){echo $data['kode_keuangan'];} ?>" />
			<div class="row">
				<div class="col-md-7">
					<div class="form-inline cari-jenis">
						<label>Jenis Keuangan</label>
						<input name="ctl_kode_jenis" type="hidden" class="form-control input-sm control-return" data-return="prime" style="width:150px" 
							value="<?php if($formUpdate){echo $data2['kode_jenis'];} ?>"/>
						<input type="text" readonly="readonly" class="form-control input-sm control-return" data-return="nama_jenis" style="width:44%" 
							value="<?php if($formUpdate){echo $data2['nama_jenis'];} ?>"/>
						<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-jenis', '<?php echo getTableAlias(1,'keuangan_jenis'); ?>', 'jenis keuangan');">
							<span class="glyphicon glyphicon-search"></span> </a>
					</div>
					<div class="form-inline">
						<label>Nama</label>
						<input name="ctl_nama" type="text" class="form-control input-sm" style="width:50%" value="<?php if($formUpdate){echo $data['nama'];} ?>" />
					</div>
					<div class="form-inline">
						<label>Nilai</label>
						<input name="ctl_nilai" type="number" class="form-control input-sm" style="width:200px" value="<?php if($formUpdate){echo $data['nilai'];} ?>" />
					</div>
					<div class="form-inline">
						<label>Pembayaran</label>
						<select name="ctl_tipe" class="form-control input-sm" style="width:200px">
						<?php
							$t = array("smt", "sks", "sekali"); $tn = array("Per Semester", "Per SKS", "Satu Kali Bayar");
							for($i = 0; $i < count($t); $i++){
								$r = "";
								if($formUpdate){
									if($t[$i] == $data['tipe']){$r = ' selected = "selected" ';}
								}
								echo '<option '.$r.' value = "'.$t[$i].'">'.$tn[$i].'</option>';
							}
						?>
						</select>
					</div>
					<div class="form-inline">
						<label>&nbsp;</label>
						<button type="button" class="btn btn-success" onclick="datasave('#m_keuangan_nilai_frm')">Simpan</button>
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