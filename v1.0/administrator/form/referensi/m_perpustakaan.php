
<?php
	if(strpos($pageForm, 'import') !== false){
		include 'm_perpustakaan_import.php';
		
	}
	else{
	$formUpdate = false;
	$data = array(); $group = array(); $kategori = array();
	
	if(strpos($pageForm, 'update') !== false){
		$formUpdate = true;
		$result		= mysqli_query($con,"select * from perpustakaan_katalog where kode_katalog = '".$_GET['p']."'") ;
		$data 		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result2	= mysqli_query($con,"select * from perpustakaan_group where kode_group = '".$data['kode_group']."'") ;
		$group 		= mysqli_fetch_array($result2, MYSQLI_ASSOC);
		
		$result3	= mysqli_query($con,"select * from perpustakaan_kategori where kode_kategori = '".$data['kode_kategori']."'") ;
		$kategori 		= mysqli_fetch_array($result3, MYSQLI_ASSOC);
	}
?>

<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<form id="m-daftarbuku-frm-1">
			<input type="hidden" name="name" value="<?php echo getTableAlias(1,'perpustakaan_katalog'); ?>" />
			<input type="hidden" name="ctl_kode_katalog" value="<?php if($formUpdate){echo $data["kode_katalog"];}else{echo "generatecode";} ?>" />
			<div class="form-group form-inline col-md-12 ">
				<span class="cari-grup">
					<label>Nama Grup</label>
					<input name="ctl_kode_group" column-name="kode grup" value="<?php if($formUpdate){echo $group["kode_group"];} ?>"
						type="hidden" class="form-control input-sm control-return" data-return="kode_grup" style="width:10%" />
					<input name="ctl_nama_group" column-name="nama grup" value="<?php if($formUpdate){echo $group["nama_group"];} ?>"
						type="text" class="form-control input-sm control-return" data-return="nama_grup" readonly="readonly" style="width:20%" />
					<a href="javascript:void(0)" class="btn btn-warning btn-sm" 
						onclick="showFormCari('#m-daftarbuku-frm-1 .cari-grup', '<?php echo getTableAlias(1,'perpustakaan_group'); ?>', 'grup', function(){$('#m-daftarbuku-frm-1 .cari-kategori input').val('');});">
						<span class="glyphicon glyphicon-search"></span> </a>
				</span>
				<label style="width:20px">&nbsp;</label>
				<span class="cari-kategori">
					<label>Nama Kategori</label>
					<input name="ctl_kode_kategori" column-name="kode kategori" value="<?php if($formUpdate){echo $kategori["kode_kategori"];} ?>"
						type="hidden" class="form-control input-sm control-return" data-return="kode_kategori" style="width:10%" />
					<input name="ctl_nama_kategori" column-name="nama kategori" value="<?php if($formUpdate){echo $kategori["nama_kategori"];} ?>"
						type="text" class="form-control input-sm control-return" data-return="nama_kategori" readonly="readonly" style="width:20%" />
					<a href="javascript:void(0)" class="btn btn-warning btn-sm" 
							onclick="showFormCari('#m-daftarbuku-frm-1 .cari-kategori', '<?php echo getTableAlias(1,'perpustakaan_kategori'); ?>', 'kategori', null, '#m-daftarbuku-frm-1 .cari-grup');">
						<span class="glyphicon glyphicon-search"></span> </a>
				</span>
			</div>
			<div class="form-group form-inline col-md-12 ">
				<label>Judul</label>
				<input name="ctl_judul" type="text" value="<?php if($formUpdate){echo $data["judul"];} ?>" class="form-control input-sm" style="width:60%" />
			</div>
			<div class="form-group form-inline col-md-12 ">
				<label>Pengarang</label>
				<input name="ctl_pengarang" type="text" value="<?php if($formUpdate){echo $data["pengarang"];} ?>" class="form-control input-sm" style="width:23%" />
				<label style="width:26px">&nbsp;</label>
				<label>Tahun Terbit</label>
				<input name="ctl_tahun_terbit" type="number" value="<?php if($formUpdate){echo $data["tahun_terbit"];} ?>" class="form-control input-sm" style="width:7%" />
				<label style="text-align:right">Jumlah</label>
				<input name="ctl_jumlah" type="number" value="<?php if($formUpdate){echo $data["jumlah"];} ?>" class="form-control input-sm" style="width:6%" />
			</div>
			<div class="form-group form-inline col-md-12 ">
				<label style="vertical-align:top; padding-top:10px">Deskripsi</label>
				<textarea name="ctl_deskripsi" class="form-control input-sm" style="width:60%; height:150px"><?php if($formUpdate){echo $data["deskripsi"];} ?></textarea>
			</div>
			<div class="form-group form-inline col-md-6 ">
				<label>&nbsp;</label>
				<button type="button" class="btn btn-danger btn-sm" data-rel="back" style="width:15%" >Batal</button>
				<button type="button" class="btn btn-success btn-sm" onclick="datasave('#m-daftarbuku-frm-1')" style="width:15%" >Simpan</button>
			</div>
		</form>
	</nav>

</div>

<style>
	form label{width:100px}
</style>


	<?php } ?>
