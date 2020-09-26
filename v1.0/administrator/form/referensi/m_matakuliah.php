
<?php

	$kurikulum		= mysqli_query($con,"select * from lookup_item where kode_group = '01' order by kode_item") ;
	$pilihan		= mysqli_query($con,"select * from lookup_item where kode_group = '02' order by kode_item") ;
	$kelompok		= mysqli_query($con,"select * from lookup_item where kode_group = '03' order by kode_item") ;
	
	$formUpdate = false;
	$data = array(); $data2 = array();
	
	if(strpos($pageForm, 'update') !== false || strpos($pageForm, 'dosen') !== false){
		$formUpdate 	= true;
		$result		= mysqli_query($con,"select * from mata_kuliah where kode_mk = '".$_GET['p']."'") ;
		$data 		= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result2	= mysqli_query($con,"select * from mata_kuliah_jenis where kode_jenis = '".$data['kode_jenis']."'") ;
		$data2 		= mysqli_fetch_array($result2, MYSQLI_ASSOC);
	}
?>

<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
	<ul class="nav nav-tabs">
		  <li <?php if($pageForm != 'dosen'){echo 'class="active"';} ?>><a href="#matakuliah" data-toggle="tab">Mata Kuliah</a></li>
		  <li <?php if($pageForm == 'dosen'){echo 'class="active"';} ?>><a href="#ijin" data-toggle="tab">Dosen Pengampu</a></li>
		</ul>
		<div id='content' class="tab-content" style="height:auto;">
		<div class="tab-pane  <?php if($pageForm != 'dosen'){echo 'active';} ?>" id="matakuliah">
				<br/>
				<div class="box-body ">
					<form id="m_matkul_frm_1">
					<input type="hidden" name="name" value="<?php echo getTableAlias(1,'mata_kuliah'); ?>" />
						<div class="row">
							<div class="col-md-12">
								<div class="form-inline navbar navbar-default cari-jenis-mk">
									<label>Kode MK</label>
									<input name="ctl_kode_mk" type="text" class="form-control input-sm" style="width:100px" <?php if($formUpdate){echo 'readonly="readonly"';} ?> value="<?php if($formUpdate){echo $data['kode_mk'];} ?>" />
									<label>Nama MK</label>
									<input name="ctl_nama_mk" type="text" class="form-control input-sm" style="width:400px" value="<?php if($formUpdate){echo $data['nama_mk'];} ?>" />
									<label>Jenis MK</label>
									<input name="ctl_kode_jenis" type="text" readonly="readonly" class="form-control input-sm control-return" data-return="kode_jenis" style="width:60px"
										 value="<?php if($formUpdate){echo $data2['kode_jenis'];} ?>"/>
									<input type="text" readonly="readonly" class="form-control input-sm control-return" data-return="nama_jenis" style="width:225px"
										 value="<?php if($formUpdate){echo $data2['nama_jenis'];} ?>"/>
									<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-jenis-mk', '<?php echo getTableAlias(1,'mata_kuliah_jenis'); ?>', 'fakultas');">
										<span class="glyphicon glyphicon-search"></span> </a>
								</div>
								<div class="form-inline navbar navbar-default">
									<label >SKS</label>
									<input name="ctl_sks" type="number" class="form-control input-sm" style="width:60px" value="<?php if($formUpdate){echo $data['sks'];}else{echo "0";} ?>" />
									<label style="width:35px">&nbsp;</label>
									<label >SKS Teori</label>
									<input name="ctl_sks_teori" type="number" class="form-control input-sm" style="width:60px" value="<?php if($formUpdate){echo $data['sks_teori'];}else{echo "0";} ?>" />
									<label style="width:100px; margin-left:25px">SKS Praktikum</label>
									<input name="ctl_sks_praktikum" type="number" class="form-control input-sm" style="width:60px" value="<?php if($formUpdate){echo $data['sks_praktikum'];}else{echo "0";} ?>" />
									<label style="width:145px;">SKS Praktek Lapangan</label>
									<input name="ctl_sks_praktek_lapangan" type="number" class="form-control input-sm" style="width:60px" value="<?php if($formUpdate){echo $data['sks_praktek_lapangan'];}else{echo "0";} ?>" />
								</div>
								<div class="form-inline navbar navbar-default">
									<label>Kurikulum</label>
									<select name="ctl_kode_jenis_kurikulum" class="form-control input-sm" style="width:100px;">
										<?php
										while($row = mysqli_fetch_array($kurikulum, MYSQLI_ASSOC)){
											if($formUpdate && $data['kode_jenis_kurikulum']==$row["kode_item"]){
												echo '<option value="'.$row["kode_item"].'" selected="selected">'.$row["nama_item"].'</option>';
											}else{												
												echo '<option value="'.$row["kode_item"].'" >'.$row["nama_item"].'</option>';
											}
										}
										?>
									</select>
									<label>Pilihan</label>
									<select name="ctl_kode_pilihan" class="form-control input-sm" style="width:210px;">
										<?php
										while($row = mysqli_fetch_array($pilihan, MYSQLI_ASSOC)){
											if($formUpdate && $data['kode_pilihan']==$row["kode_item"]){
												echo '<option value="'.$row["kode_item"].'" selected="selected">'.$row["nama_item"].'</option>';
											}else{												
												echo '<option value="'.$row["kode_item"].'" >'.$row["nama_item"].'</option>';
											}
										}
										?>
									</select>
									<label style="margin-left:25px">Kelompok</label>
									<select name="ctl_kode_kelompok" class="form-control input-sm" style="width:300px;">
										<?php
										while($row = mysqli_fetch_array($kelompok, MYSQLI_ASSOC)){
											if($formUpdate && $data['kode_kelompok']==$row["kode_item"]){
												echo '<option value="'.$row["kode_item"].'" selected="selected">'.$row["nama_item"].'</option>';
											}else{												
												echo '<option value="'.$row["kode_item"].'" >'.$row["nama_item"].'</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="form-inline navbar navbar-default">
									<label>SAP</label>
									<select name="ctl_sap" class="form-control input-sm" style="width:100px;">
										<option value="Y" <?php if($formUpdate && $data['sap']=='Y'){echo 'selected="selected"';} ?>>YA</option>
										<option value="T" <?php if($formUpdate && $data['sap']=='T'){echo 'selected="selected"';} ?>>TIDAK</option>
									</select>
									<label>SILABUS</label>									
									<select name="ctl_silabus" class="form-control input-sm" style="width:100px;">
										<option value="Y" <?php if($formUpdate && $data['silabus']=='Y'){echo 'selected="selected"';} ?>>YA</option>
										<option value="T" <?php if($formUpdate && $data['silabus']=='T'){echo 'selected="selected"';} ?>>TIDAK</option>
									</select>
									<label style="width:130px">&nbsp;</label>
									<label>DIKTAT</label>		
									<select name="ctl_diktat" class="form-control input-sm" style="width:100px;">
										<option value="Y" <?php if($formUpdate && $data['diktat']=='Y'){echo 'selected="selected"';} ?>>YA</option>
										<option value="T" <?php if($formUpdate && $data['diktat']=='T'){echo 'selected="selected"';} ?>>TIDAK</option>
									</select>
									<label style="margin-left:15px">Bahan Ajar</label>									
									<select name="ctl_bahan_ajar" class="form-control input-sm" style="width:100px;">
										<option value="Y" <?php if($formUpdate && $data['bahan_ajar']=='Y'){echo 'selected="selected"';} ?>>YA</option>
										<option value="T" <?php if($formUpdate && $data['bahan_ajar']=='T'){echo 'selected="selected"';} ?>>TIDAK</option>
									</select>
								</div>
								<div class="form-inline navbar navbar-default" style="padding-bottom:10px">
									<label>Kompetensi</label>
									<textarea name="ctl_kompetensi" class="form-control" style="width:290px; height:100px"><?php if($formUpdate){echo $data['kompetensi'];} ?></textarea>
									<label style="margin-left:135px">Pokok Bahasan</label>
									<textarea name="ctl_pokok_bahasan" class="form-control" style="width:300px; height:100px"><?php if($formUpdate){echo $data['pokok_bahasan'];} ?></textarea>
								</div>
								<div class="form-inline navbar navbar-default" style="padding-bottom:10px">
									<label>Status</label>																
									<select name="ctl_status" class="form-control input-sm" style="width:100px;">
										<option value="aktif" <?php if($formUpdate && $data['status']=='aktif'){echo 'selected="selected"';} ?>>Aktif</option>
									</select>
									<label>&nbsp;</label><label>&nbsp;</label><label>&nbsp;</label><label>&nbsp;</label><label>&nbsp;</label><label>&nbsp;</label>
									<label style="width:20px">&nbsp;</label>
									<button type="button" class="btn btn-success" onclick="datasave('#m_matkul_frm_1')" style="width:100px;">Simpan</button>
									<button type="button" class="btn btn-danger" data-rel="back" style="width:100px;">Batal</button>
								</div>
							</div>
						</div>
					</form>
				</div>
		</div>
		<div class="tab-pane  <?php if($pageForm == 'dosen'){echo 'active';} ?>" id="ijin">
				<br/>
				<div class="box-body ">
				<form id="f_matkul_dosen_frm"><input name="f_kode_mk" type="hidden" class="form-control input-sm" value="<?php if($formUpdate){echo $data['kode_mk'];} ?>" /></form>
				<form id="m_matkul_frm_2">
					<input type="hidden" name="name" value="<?php echo getTableAlias(1,'mata_kuliah_dosen'); ?>" />
					<input type="hidden" name="ctl_kode_mk_dosen" />
					<input type="hidden" name="ctl_kode_mk" value="<?php if($formUpdate){echo $data['kode_mk'];} ?>" />
					<div class="form-inline cari-dosen">						
						<label>Dosen</label>
						<input name="ctl_nidn" type="text" readonly="readonly" class="form-control input-sm control-return" data-return="nidn" style="width:100px" />
						<input type="text" readonly="readonly" class="form-control input-sm control-return" data-return="nama" style="width:310px" />
						<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-dosen', 'dosen', 'dosen');">
							<span class="glyphicon glyphicon-search"></span> </a>
					</div>
					<div class="form-inline">
						<label>&nbsp;</label>
						<button type="button" class="btn btn-primary btn-sm" onclick="set_matkul_dosen_prime(); datasavecallback('#m_matkul_frm_2', matkul_datasave_callback)" ><span class="glyphicon glyphicon-plus"></span> Tambah</button>
					</div>
				</form>				
				<br/>
				<table id="table-matkul-dosen" class="table table-bordered table-striped" style="width:600px">
					<thead></thead>
					<tbody></tbody>
				</table>
				<ul id = "pagination-matkul-dosen" class="pagination"></ul>
			</div>
				<button type="button" class="btn btn-danger" data-rel="back" style="width:100px;">Batal</button>
		</div>
		</div>
		
	</nav>
</div>

<style>
	hr{margin:15px;}
	form label{width:80px; margin-bottom:10px; padding-left:10px; font-size:12px;}
	form select{padding-left:2px !important; }
	form .navbar{padding-top:10px; margin-bottom:5px}
</style>

<script>
	function set_matkul_dosen_prime(){
		var a = $('input[name="ctl_kode_mk"]').val(); var b = $('input[name="ctl_nidn"]').val();
		$('input[name="ctl_kode_mk_dosen"]').val(a+b);
	}
	
	var view_name = '<?php echo getTableAlias(1, 'mata_kuliah_dosen'); ?>'; var table_name = '#table-matkul-dosen'; var pagination_name = '#pagination-matkul-dosen';
	$(document).ready(function(){
		dataview(view_name, 1, matkul_dosen_callback, '#f_matkul_dosen_frm');
	});
	
	function matkul_datasave_callback(data){
		dataview(view_name, 1, matkul_dosen_callback, '#f_matkul_dosen_frm');
	}
	
	function matkul_dosen_callback(data){
		/// Columns \\\
		var thead = '';
		$.each(data[0], function(key, arr){
			if(key != 'p_row' && key != 'none' && key != 'prime'){
				thead += '<td>'+key.toUpperCase()+'</td>';
			}
		});		
		
		thead = '<tr>'+thead+'<td></td></tr>'; $(table_name+' thead').html(thead);		
		/// Rows \\\
		var tbody = ''; var n = 0; var p_row = 0; var active_page = 0;
		$.each(data, function(index, array){
			$.each(data[0], function(key, arr){
				if(key != 'p_row'){
					if(key == 'no'){		
						if(n==0){n = array['no']; active_page = n; }else{n++;}
						tbody += '<tr row-number="'+n+'">';
						tbody += '<td><label>'+n+'</label></td>';
					}
					else{
						if(key != 'none' && key != 'prime'){
							tbody += '<td><label name="'+key+'" value="'+array[key]+'">'+array[key]+'</label></td>';
						}
					}
				}
				else{
					p_row = array[key];
				}
			});
			tbody += '<td style="width:40px">';
			tbody += '<form id="frm-remove-'+array['prime']+'"><input type="hidden" name="name" value="<?php echo getTableAlias(1, 'mata_kuliah_dosen'); ?>" />';
			tbody += '<input type="hidden" name="ctl_kode_mk_dosen" value="'+array['prime']+'" /></form>';
			tbody += '<button onclick="dataremovecallback(\'#frm-remove-'+array['prime']+'\',matkul_datasave_callback)" class="btn btn-danger btn-xs" style="width:25; margin-right:2px;"><span class="glyphicon glyphicon-remove"></span> </button>';
			tbody += '</td>';
			tbody += '</tr>';
		});
		$(table_name+' tbody').html(tbody);
		
		/// Paging \\\
		var li = '';
		for(var i = 1; i <= p_row ;i++){
			if(i == active_page){
				li += '<li><a href="javascript:void(0)" onclick="dataview(view_name, '+i+', dosen_callback);"  style="background:#d9edf7">'+i+'</a></li>';
			}
			else{
				li += '<li><a href="javascript:void(0)" onclick="dataview(view_name, '+i+', dosen_callback);">'+i+'</a></li>';
			}
		}
		$(pagination_name).html(li);
	}
	
	
</script>



