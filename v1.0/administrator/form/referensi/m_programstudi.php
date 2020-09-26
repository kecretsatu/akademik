
<?php
	$jenjang	= ["S3", "S2", "S1", "D4", "D3", "D2", "D1"];
	$formUpdate = false;
	$data = array(); $data2 = array();
	
	if(strpos($pageForm, 'update') !== false){
		$formUpdate 	= true;
		$result		= mysqli_query($con,"select * from prodi_identitas where kode_prodi = '".$_GET['p']."'") ;
		$data 		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result2	= mysqli_query($con,"select * from jurusan where kode_jurusan = '".$data['kode_jurusan']."'") ;
		$data2 		= mysqli_fetch_array($result2, MYSQLI_ASSOC);
	}
?>

	
<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
	<ul class="nav nav-tabs">
		  <li class="active"><a href="#identitas" data-toggle="tab">Identitas Prodi</a></li>
		  <li><a href="#ijin" data-toggle="tab">Ijin Operasional</a></li>
		  <li><a href="#akreditasi" data-toggle="tab">Akreditasi</a></li>
		  <li><a href="#dosen" data-toggle="tab">Dosen Prodi</a></li>
		</ul>
		<div id='content' class="tab-content" style="height:auto;">
			<div class="tab-pane active" id="identitas">
				<br/>
				<div class="box-body ">
				<form id="m_prodi_frm_1">
					<input type="hidden" name="name" value="<?php echo getTableAlias(1,'prodi_identitas'); ?>" />
						<div class="row">
							<div class="col-md-8">
								<div class="form-inline">
									<label>Kode</label>
									<input name="ctl_kode_prodi" type="text" class="form-control input-sm" style="width:30%" value="<?php if($formUpdate){echo $data['kode_prodi'];} ?>" />
								</div>
								<div class="form-inline">
									<label>Nama</label>
									<input name="ctl_nama_prodi" type="text" class="form-control input-sm" style="width:80%" value="<?php if($formUpdate){echo $data['nama_prodi'];} ?>" />
								</div>
								<div class="form-inline">
									<label>Jenjang</label>
									<select name="ctl_jenjang" class="form-control input-sm" style="width:10%; margin-right:20%">
										<?php
											foreach($jenjang as $j){
												if($formUpdate && $j == $data['jenjang'] ){echo '<option value="'.$j.'" selected="selected">'.$j.'</option>';}
												else{
													if(!$formUpdate && $j == 'S1'){echo '<option value="'.$j.'" selected="selected">'.$j.'</option>';}
													else{echo '<option value="'.$j.'">'.$j.'</option>';}
												}
											}
										?>
									</select>
									<label>SKS Lulus</label>
									<input name="ctl_sks_lulus" type="number" class="form-control input-sm" style="width:10%" value="<?php if($formUpdate){echo $data['sks_lulus'];} ?>" />
								</div>
								<div class="form-inline">
									<label>Gelar</label>
									<input name="ctl_gelar" type="text" class="form-control input-sm" style="width:30%" value="<?php if($formUpdate){echo $data['gelar'];} ?>" />
									<label>Singkatan Gelar</label>
									<input name="ctl_singkatan_gelar" type="text" class="form-control input-sm" style="width:30%" value="<?php if($formUpdate){echo $data['singkatan_gelar'];} ?>" />
								</div>
								<div class="form-inline cari-jurusan">
									<label>Jurusan</label>
									<input name="ctl_kode_jurusan" type="text" readonly="readonly" class="form-control input-sm control-return" data-return="kode_jurusan" style="width:20%"
										 value="<?php if($formUpdate){echo $data['kode_jurusan'];} ?>"/>
									<input type="text" readonly="readonly" class="form-control input-sm control-return" data-return="nama_jurusan" style="width:54%; " 
										value="<?php if($formUpdate){echo $data2['nama_jurusan'];} ?>"/>
									<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-jurusan', '<?php echo getTableAlias(1,'jurusan'); ?>', 'fakultas');">
										<span class="glyphicon glyphicon-search"></span> </a>
								</div>
								<div class="form-inline">
									<label>Tgl. Berdiri</label>
									<input name="ctl_tanggal_berdiri" type="date" class="form-control input-sm" value="<?php if($formUpdate){echo $data['tanggal_berdiri'];} ?>" />
									<label>Status</label>
									<select name="ctl_status" class="form-control input-sm" style="width:30%" >
										<option <?php if($formUpdate && $data['status'] == 'aktif'){echo 'selected="selected"';} ?> value="aktif">AKTIF</option>
									</select>
								</div>
								<div class="form-inline">
									<br/>
									<label>&nbsp;</label>
									<button type="button" class="btn btn-success" onclick="datasave('#m_prodi_frm_1')">Simpan Identitas Prodi</button>
								</div>
							</div>
						</div>							
					</form>
				</div>
			</div>
			<div class="tab-pane" id="ijin">
				<br/>
				<div class="box-body ">
				<form>
					<div class="row">
						<div class="col-md-8">
							<div class="form-inline">
								<label>Nomor SK</label>
								<input type="text" class="form-control input-sm" style="width:40%" />
							</div>
							<div class="form-inline">
								<label>Tanggal SK</label>
								<input type="text" class="form-control input-sm" style="width:40%" />
							</div>
							<div class="form-inline">
								<label>Berlaku s/d</label>
								<input type="text" class="form-control input-sm" style="width:40%" />
							</div>
							<div class="form-inline">
								<br/>
								<label>&nbsp;</label>
								<button type="button" class="btn btn-success">Simpan Ijin Operasional</button>
							</div>
						</div>
					</div>
				</form>
				</div>
			</div>
			<div class="tab-pane" id="akreditasi">
				<br/>
				<div class="box-body ">
				<form>
					<div class="row">
						<div class="col-md-8">
							<div class="form-inline">
								<label>Nomor SK</label>
								<input type="text" class="form-control input-sm" style="width:40%" />
							</div>
							<div class="form-inline">
								<label>Tanggal SK</label>
								<input type="text" class="form-control input-sm" style="width:40%" />
							</div>
							<div class="form-inline">
								<label>Berlaku s/d</label>
								<input type="text" class="form-control input-sm" style="width:40%" />
							</div>
							<div class="form-inline">
								<label>Status Akreditasi</label>
								<input type="text" class="form-control input-sm" style="width:40%" />
							</div>
							<div class="form-inline">
								<br/>
								<label>&nbsp;</label>
								<button type="button" class="btn btn-success">Simpan Akreditasi</button>
							</div>
						</div>
					</div>
				</form>
				</div>
			</div>
			<div class="tab-pane" id="pendidikannonformal">
				Organisasi
			</div>
			<div class="tab-pane" id="prestasi">
				STATUS
			</div>
			<div class="tab-pane" id="status">
				STATUS
			</div>
		</div>
		<form>
		<div class="form-inline">
			<label>&nbsp;</label>
			<button type="button" class="btn btn-danger" data-rel="back" style="width:170px">Batal</button>
		</div>
		</form>
	</nav>
</div>

<style>
	form label{width:140px; padding:5px; font-weight:normal;}
	
</style>
