
<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<ul class="nav nav-tabs">
		  <li class="active"><a href="#daftarbuku" data-toggle="tab">Daftar Buku</a></li>
		  <li><a href="#peminjaman" data-toggle="tab">Peminjaman</a></li>
		  <li><a href="#kategori" data-toggle="tab">Kategori</a></li>
		  <li><a href="#grup" data-toggle="tab">Grup</a></li>
		  <li><a href="#referensi" data-toggle="tab">Referensi</a></li>
		</ul>
		<div id='content' class="tab-content" style="height:auto;">
			<div class="tab-pane active" id="daftarbuku">
				<div class="box-body">
					<div>
						<div class="box-body ">
						<br/>
						<div class="row form-group" >	
							<form id="m-daftarbuku-frm">
								<input type="hidden" name="name" value="<?php echo getTableAlias(1,'perpustakaan_katalog'); ?>" />
								<div class="form-group form-inline col-md-12 ">
								<input type="hidden" name="ctl_kode_katalog" column-name="kode katalog" value="" />
									<span class="cari-grup">
										<label>Nama Grup</label>
										<input name="ctl_kode_group" column-name="kode grup" type="hidden" class="form-control input-sm control-return" data-return="kode_grup" style="width:10%" />
										<input name="ctl_nama_group" column-name="nama grup" type="text" class="form-control input-sm control-return" data-return="nama_grup" readonly="readonly" style="width:20%" />
										<a href="javascript:void(0)" class="btn btn-warning btn-sm" 
											onclick="showFormCari('#m-daftarbuku-frm .cari-grup', '<?php echo getTableAlias(1,'perpustakaan_group'); ?>', 'grup', function(){$('#m-daftarbuku-frm .cari-kategori input').val('');});">
											<span class="glyphicon glyphicon-search"></span> </a>
									</span>
									<label>&nbsp;</label>
									<span class="cari-kategori">
										<label>Nama Kategori</label>
										<input name="ctl_kode_kategori" column-name="kode kategori" type="hidden" class="form-control input-sm control-return" data-return="kode_kategori" style="width:10%" />
										<input name="ctl_nama_kategori" column-name="nama kategori" type="text" class="form-control input-sm control-return" data-return="nama_kategori" readonly="readonly" style="width:20%" />
										<a href="javascript:void(0)" class="btn btn-warning btn-sm" 
												onclick="showFormCari('#m-daftarbuku-frm .cari-kategori', '<?php echo getTableAlias(1,'perpustakaan_kategori'); ?>', 'kategori', null, '#m-daftarbuku-frm .cari-grup');">
											<span class="glyphicon glyphicon-search"></span> </a>
									</span>
								</div>
								<div class="form-group form-inline col-md-12 ">
									<label>Kata Kunci</label>
									<input name="ctl_kata_kunci" class="form-control input-sm" style="width:34%" />
									<button type="button" class="btn btn-warning btn-sm" onclick="dataview(view_name, 1, grup_callback, '#m-daftarbuku-frm');"><span class="glyphicon glyphicon-search"></span> Cari</button>
									<label>atau</label>
									<a href="<?php echo $REQUEST_URI; ?>/tambah" class="btn btn-primary btn-sm" ><span class="glyphicon glyphicon-plus"></span> Tambah Data</a>
									<label>atau</label>
									<a href="<?php echo $REQUEST_URI; ?>/import" class="btn btn-primary btn-sm" ><span class="glyphicon glyphicon-upload"></span> Import Data</a>
								</div>
							</form>
						</div>
						<div class="box-body table-responsive table-responsive-auto">		
							<ul id = "pagination-daftarbuku" class="pagination"></ul>
							<table id="table-daftarbuku" class="table table-bordered table-striped" >
								<thead></thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
					</div>
				</div>
			</div>
			<div class="tab-pane " id="peminjaman">
				<div class="box-body">				
					<div class="box-body table-responsive">
						<br/>
						<table id="table-jadwal-kuliah" class="table table-bordered table-striped">
							<thead></thead>
							<tbody></tbody>
						</table>
						<ul id = "pagination-jadwal-kuliah" class="pagination"></ul>
					</div>
				</div>
			</div>
			<div class="tab-pane " id="kategori">
				<div class="box-body">				
					<div class="box-body table-responsive">
						<br/>
						<div class="row form-group" >	
							<form id="m-kategori-frm">
								<input type="hidden" name="name" value="<?php echo getTableAlias(1,'perpustakaan_kategori'); ?>" />
								<div class="form-group form-inline col-md-12 ">
									<span class="cari-grup">
										<label>Nama Grup</label>
										<input name="ctl_kode_group" column-name="kode grup" type="hidden" class="form-control input-sm control-return" data-return="kode_grup" style="width:10%" />
										<input name="ctl_nama_group" column-name="nama grup" type="text" class="form-control input-sm control-return" data-return="nama_grup" readonly="readonly" style="width:20%" />
										<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="showFormCari('#m-kategori-frm .cari-grup', '<?php echo getTableAlias(1,'perpustakaan_group'); ?>', 'grup');">
											<span class="glyphicon glyphicon-search"></span> </a>
									</span>
									<label>&nbsp;</label>
									<label>Nama Kategori</label>
									<input name="ctl_kode_kategori" column-name="kode kategori" column-primary = "1" value="generatecode" type="hidden" class="form-control input-sm" style="width:10%" />
									<input name="ctl_nama_kategori" column-name="nama kategori" type="text" class="form-control input-sm" style="width:25%" />
									<button type="button" class="btn btn-danger btn-sm" onclick="grup_clear()"  >Batal</button>
									<button type="button" class="btn btn-success btn-sm" onclick="grup_save()"  >Simpan</button>
								</div>
							</form>
						</div>
						<div class="box-body table-responsive">		
							<ul id = "pagination-kategori" class="pagination"></ul>
							<table id="table-kategori" class="table table-bordered table-striped" style="width:50%">
								<thead></thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="grup">
				<div class="box-body">
					<br/>
					<div class="row form-group" >	
						<form id="m-grup-frm">
							<input type="hidden" name="name" value="<?php echo getTableAlias(1,'perpustakaan_group'); ?>" />
							<div class="form-group form-inline col-md-6">
								<label>Nama Grup</label>
								<input name="ctl_kode_group" column-name="kode grup" column-primary = "1" value="generatecode" type="hidden" class="form-control input-sm" style="width:10%" />
								<input name="ctl_nama_group" column-name="nama grup" type="text" class="form-control input-sm" style="width:40%" />
								<button type="button" class="btn btn-danger btn-sm" onclick="grup_clear()" style="width:15%" >Batal</button>
								<button type="button" class="btn btn-success btn-sm" onclick="grup_save()" style="width:15%" >Simpan</button>
							</div>
						</form>
					</div>
					<div class="box-body table-responsive">		
						<ul id = "pagination-grup" class="pagination"></ul>
						<table id="table-grup" class="table table-bordered table-striped" style="width:50%">
							<thead></thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="referensi">
				<div class="box-body">
					<div class="box-body table-responsive">
						<br/>
						<table id="table-referensi" class="table table-bordered table-striped">
							<thead></thead>
							<tbody></tbody>
						</table>
						<ul id = "pagination-referensi" class="pagination"></ul>
					</div>
				</div>
			</div>
		</div>
	</nav>
</div>

<style>
	.btn-xs{margin-right:5px;}
</style>

<script>
	var tipe		= ["daftarbuku", "peminjaman", "kategori", "grup", "referensi"]
	var name_source = ["<?php echo getTableAlias(1, "perpustakaan_katalog"); ?>", "", "<?php echo getTableAlias(1, "perpustakaan_kategori"); ?>", "<?php echo getTableAlias(1, "perpustakaan_group"); ?>", ""];
	
	$(document).ready(function(){
		$('.nav-tabs .active a').click();
	});
	
	$('.nav-tabs a').click(function(){		
		var source = $(this).attr('href').replace('#','');
		get_grup(name_source[tipe.indexOf(source)], "#table-"+source, "#pagination-"+source, "#m-"+source+"-frm");
	});
	
	function get_uri(){
		return '<?php echo $REQUEST_URI; ?>/update';
	}
	
</script>
<script src="<?php echo $BASE_URL ;?>/js/perpustakaan.js"></script>




