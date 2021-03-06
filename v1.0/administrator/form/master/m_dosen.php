
<?php
	$formUpdate = false;
	$data = array();
	if(strpos($pageForm, 'update') !== false){
		$formUpdate 	= true;
		$result		= mysqli_query($con,"select * from dosen_biodata where nidn = '".$_GET['p']."'") ;
		$data 		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		//$data		= $data[0];
	}
?>
	
<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
	<ul class="nav nav-tabs">
		  <li class="active"><a href="#pribadi" data-toggle="tab">Pribadi</a></li>
		  <li><a href="#kepegawaian" data-toggle="tab">Kepegawaian</a></li>
		  <li><a href="#pendidikanformal" data-toggle="tab">Pendidikan Formal</a></li>
		  <li><a href="#pendidikannonformal" data-toggle="tab">Pendidikan Non Formal</a></li>
		  <li><a href="#prestasi" data-toggle="tab">Prestasi</a></li>
		  <li><a href="#status" data-toggle="tab">Status</a></li>
		</ul>
		<div id='content' class="tab-content" style="height:auto;">
			<div class="tab-pane active" id="pribadi">
				<br/>
				<div class="box-body ">
					<form id="m_dosen_1">
						<input type="hidden" name="name" value="<?php echo getTableAlias(1,'dosen_biodata'); ?>" />
						<div class="row">
							<div class="col-md-8">
								<div class="form-inline">
									<label>NIDN</label>
									<input name="ctl_nidn" type="text" class="form-control input-sm" style="width:30%" value="<?php if($formUpdate){echo $data['nidn'];} ?>" />
									<label>Nomor Identitas</label>
									<input name="ctl_nomor_identitas" type="text" class="form-control input-sm" style="width:30%" value="<?php if($formUpdate){echo $data['nomor_identitas'];} ?>" />
								</div>
								<div class="form-inline">
									<label>Nama</label>
									<input name="ctl_nama_dosen" type="text" class="form-control input-sm" style="width:80%" value="<?php if($formUpdate){echo $data['nama_dosen'];} ?>" />
								</div>
								<div class="form-inline">
									<label>Gelar Depan</label>
									<input name="ctl_gelar_depan" type="text" class="form-control input-sm" style="width:30%" value="<?php if($formUpdate){echo $data['gelar_depan'];} ?>" />
									<label>Gelar Belakang</label>
									<input name="ctl_gelar_belakang" type="text" class="form-control input-sm" style="width:30%" value="<?php if($formUpdate){echo $data['gelar_belakang'];} ?>" />
								</div>
								<div class="form-inline">
									<label>Alamat</label>
									<input name="ctl_alamat" type="text" class="form-control input-sm" style="width:80%" value="<?php if($formUpdate){echo $data['alamat'];} ?>" />
								</div>
								<div class="form-inline">
									<label>Kab. / Kota</label>
									<input name="ctl_kota" type="text" class="form-control input-sm" style="width:30%" value="<?php if($formUpdate){echo $data['kota'];} ?>" />
									<label>Propinsi</label>
									<input name="ctl_propinsi" type="text" class="form-control input-sm" style="width:30%" value="<?php if($formUpdate){echo $data['propinsi'];} ?>" />
								</div>
								<div class="form-inline">
									<label>Tanggal Lahir</label>
									<div class="input-group datepicker" style="width:30%" >
										<input name="ctl_tanggal_lahir" readonly="readonly" type="text" class="form-control input-sm date" value="<?php if($formUpdate){echo $data['tanggal_lahir'];} ?>" />
										<span class="btn input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
									</div>
								</div>
								<div class="form-inline">
									<label>Kab. / Kota Lahir</label>
									<input name="ctl_kota_lahir" type="text" class="form-control input-sm" style="width:30%" value="<?php if($formUpdate){echo $data['kota_lahir'];} ?>" />
									<label>Propinsi Lahir</label>
									<input name="ctl_propinsi_lahir" type="text" class="form-control input-sm" style="width:30%" value="<?php if($formUpdate){echo $data['propinsi_lahir'];} ?>" />
								</div>
								<div class="form-inline">
									<label>Kewarganegaraan</label>
									<input name="ctl_kewarganegaraan" type="text" class="form-control input-sm" style="width:80%" value="<?php if($formUpdate){echo $data['kewarganegaraan'];} ?>" />
								</div>
								<div class="form-inline">
									<label>Jenis Kelamin</label>
									<select name="ctl_jenis_kelamin" type="text" class="form-control input-sm"  style="width:30%"  >
										<option value="L" <?php if($formUpdate && $data['jenis_kelamin']=='L'){echo 'selected="selected"';} ?> >Laki - Laki</option>
										<option value="P" <?php if($formUpdate && $data['jenis_kelamin']=='P'){echo 'selected="selected"';} ?> >Perempuan</option>
									</select>
									<label>Agama</label>
									<select name="ctl_agama" type="text" class="form-control input-sm"  style="width:30%"  >
										<option value="islam" <?php if($formUpdate && $data['agama']=='islam'){echo 'selected="selected"';} ?> >Islam</option>
										<option value="kristen" <?php if($formUpdate && $data['agama']=='kristen'){echo 'selected="selected"';} ?> >Kristem</option>
										<option value="buddha" <?php if($formUpdate && $data['agama']=='buddha'){echo 'selected="selected"';} ?> >Buddha</option>
										<option value="hindu" <?php if($formUpdate && $data['agama']=='hindu'){echo 'selected="selected"';} ?> >Hindu</option>
									</select>
								</div>
								<div class="form-inline">
									<label>Email</label>
									<input name="ctl_email" type="text" class="form-control input-sm" style="width:30%" value="<?php if($formUpdate){echo $data['email'];} ?>" />
									<label>No. HandPhone 1</label>
									<input name="ctl_no_handphone1" type="text" class="form-control input-sm" style="width:30%" value="<?php if($formUpdate){echo $data['no_handphone1'];} ?>" />
								</div>
								<div class="form-inline">
									<label>No. Telepon</label>
									<input name="ctl_no_telepon" type="text" class="form-control input-sm" style="width:30%" value="<?php if($formUpdate){echo $data['no_telepon'];} ?>" />
									<label>No. HandPhone 2</label>
									<input name="ctl_no_handphone2" type="text" class="form-control input-sm" style="width:30%" value="<?php if($formUpdate){echo $data['no_handphone2'];} ?>" />
								</div>
								<div class="form-inline">
									<label>&nbsp;</label>
									<button type="button" class="btn btn-success"  onclick="datasave('#m_dosen_1')">Simpan Data Pribadi</button>
								</div>
							</div>
							<div class="col-md-4" >
								<button type="button" class="btn btn-info" style="width:100%">Upload Image</button>
								<img src="#" style="width:100%; height:350px; background:#CCCCCC" />
								<input type="file" style="display:none" />
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="tab-pane" id="kepegawaian">
				<br/>
				<div class="box-body ">
				<form>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingAO"><h4 class="panel-title" >Orang Tua</h4></div>
							</div>
							<div class="form-inline">
								<label>Nama Ayah</label>
								<input type="text" class="form-control input-sm" style="width:25%" />
								<label>Nama Ibu</label>
								<input type="text" class="form-control input-sm" style="width:25%" />
							</div>
							<div class="form-inline">
								<label>Pendidikan Ayah</label>
								<input type="text" class="form-control input-sm" style="width:25%" />
								<label>Pendidikan Ibu</label>
								<input type="text" class="form-control input-sm" style="width:25%" />
							</div>
							<div class="form-inline">
								<label>Pekerjaan Ayah</label>
								<input type="text" class="form-control input-sm" style="width:25%" />
								<label>Pekerjaan Ibu</label>
								<input type="text" class="form-control input-sm" style="width:25%" />
							</div>
							<div class="form-inline">
								<label>Alamat</label>
								<input type="text" class="form-control input-sm" style="width:25%" />
								<label>Kab. / Kota</label>
								<input type="text" class="form-control input-sm" style="width:25%" />
							</div>
							<div class="form-inline">
								<label>Penghasilan</label>
								<input type="text" class="form-control input-sm" style="width:25%" />
							</div>
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingAO"><h4 class="panel-title" >Wali</h4></div>
							</div>
							<div class="form-inline">
								<label>Nama Wali</label>
								<input type="text" class="form-control input-sm" style="width:25%" />
								<label>Hubungan</label>
								<input type="text" class="form-control input-sm" style="width:25%" />
							</div>
							<div class="form-inline">
								<label>Alamat</label>
								<input type="text" class="form-control input-sm" style="width:25%" />
								<label>Kab. / Kota</label>
								<input type="text" class="form-control input-sm" style="width:25%" />
							</div>
							<div class="form-inline">
								<label>&nbsp;</label>
								<button type="button" class="btn btn-success">Simpan Data Pribadi</button>
							</div>
						</div>
					</div>
				</form>
				</div>
			</div>
			<div class="tab-pane" id="pendidikanformal">
				Riwayat
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
			<button type="button" class="btn btn-danger" data-rel="back" style="width:155px">Batal</button>
		</div>
		</form>
	</nav>
</div>

<style>
	form label{width:140px; padding:5px; font-weight:normal;}
	
</style>
