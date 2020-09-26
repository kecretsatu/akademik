
<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white; ">
	<form id="m_mahasiswa_c_frm">
		<input type="hidden" name="name" value="<?php echo getTableAlias(1,'civitas_mahasiswa'); ?>" />
		<div class="form-group form-inline">
			<div class="form-group form-inline cari-tahun-ajaran">
				<label>Tahun Ajaran</label>
				<input name="ctl_ajaran_aktif" value="" type="hidden" class="form-control input-sm control-return" data-return = "kode" style="width:70px" readonly="readonly"/>
				<input type="text" value="" class="form-control input-sm control-return" data-return = "tahun" style="width:195px" readonly="readonly"/>
				<input type="text" value="" class="form-control input-sm control-return" data-return = "semester" style="width:70px" readonly="readonly"/>
				<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-tahun-ajaran', '<?php echo getTableAlias(1,'tahun_ajaran'); ?>', 'Tahun Ajaran');" >
					<span class="glyphicon glyphicon-search"></span> </button>
			</div>
			<div class="form-group form-inline cari-prodi">
				<label>Program Studi</label>
				<input name="ctl_kode_prodi" value="" type="hidden" class="form-control input-sm control-return" data-return = "kode_prodi" style="width:70px" readonly="readonly"/>
				<input type="text" value="" class="form-control input-sm control-return" data-return = "jenjang" style="width:45px" readonly="readonly"/>
				<input type="text" value="" class="form-control input-sm control-return" data-return = "nama_prodi" style="width:250px" readonly="readonly"/>
				<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-prodi', 'prodi', 'Program Studi');" >
					<span class="glyphicon glyphicon-search"></span> </button>
			</div>
		</div>
		<div class="form-group form-inline">
			<div class="form-group form-inline cari-prodi">
				<label>Semester Aktif</label>
				<input type="number" name="ctl_semester_aktif" class="form-control input-sm" value="1" style="width:60px" />
				<button id="btn-import" type="button" class="btn btn-success btn-sm" onclick="perwalian_kolektif_load()">GO</button>
			</div>
		</div>
	</form>
	</nav>
	
	<nav class="navbar navbar-default" style="padding:10px; background:white; ">
		<div class="box-body table-responsive">
			<table id="table-mahasiswa" class="table table-bordered table-striped">
				<thead></thead>
				<tbody></tbody>
			</table>
			<ul id = "pagination-mahasiswa" class="pagination"></ul>
		</div>
	</nav>
	<nav class="navbar navbar-default" style="padding:10px; background:white; ">
		<button id="btn-simpan" disabled="disabled" type="button" class="btn btn-success btn-sm" onclick="perwalian_kolektif_save()">Simpan</button>
	</nav>
	
</div>
<script src="<?php echo $BASE_URL ;?>/js/perwaliankolektif.js"></script>

<style>
	form label{width:100px;}
</style>