<?php 
	$result = mysqli_query($con, "select * from bobot_nilai");
	
?>

<div class="panel panel-primary " >
  <div class="panel-heading">Input Nilai</div>
  <div class="panel-body" >
<div id="mahasiswa" class="" style="font-size:12px;" >
	<form id="mahasiswa-frm-f">
	<nav class="navbar navbar-default parameter" style="padding:10px; background:white;">
		<input type="hidden" name="total" value="" />
		<input type="hidden" name="name" value="<?php echo getTableAlias(1, 'civitas_nilai'); ?>" />
		<div class="row" style="border:0px solid black">
			<div class="form-inline form-group col-md-5 cari-tahun-ajaran">
				<label>Tahun Ajaran</label>
				<input name="f_kode_ajaran" value="" type="hidden" class="form-control input-sm control-return" data-return = "kode" style="width:70px" readonly="readonly"/>
				<input type="text" value="" class="form-control input-sm control-return" data-return = "tahun" style="width:200px" readonly="readonly"/>
				<input type="text" value="" class="form-control input-sm control-return" data-return = "semester" style="width:70px" readonly="readonly"/>
				<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-tahun-ajaran', '<?php echo getTableAlias(1,'tahun_ajaran'); ?>', 'Tahun Ajaran');" >
					<span class="glyphicon glyphicon-search"></span> </button>
			</div>
			<div class="form-inline form-group col-md-6 cari-prodi">
				<label>Program Studi</label>
				<input name="f_kode_prodi" value="" type="hidden" class="form-control input-sm control-return" data-return = "kode_prodi" style="width:70px" readonly="readonly"/>
				<input type="text" value="" class="form-control input-sm control-return" data-return = "jenjang" style="width:45px" readonly="readonly"/>
				<input type="text" value="" class="form-control input-sm control-return" data-return = "nama_prodi" style="width:250px" readonly="readonly"/>
				<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-prodi', 'prodi', 'Program Studi');" >
					<span class="glyphicon glyphicon-search"></span> </button>
			</div>
			<div class="form-inline form-group col-md-5 cari-matkul">
				<label>Mata Kuliah</label>
				<input name="f_mata_kuliah" value="" type="hidden" class="form-control input-sm control-return" data-return = "kode_mk" style="width:70px" readonly="readonly"/>
				<input type="text" value="" class="form-control input-sm control-return" data-return = "nama_mk" style="width:225px" readonly="readonly"/>
				<input type="text" value="" class="form-control input-sm control-return" data-return = "sks" style="width:45px" readonly="readonly"/>
				<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-matkul', 'penjadwalan_matkul', 'Mata Kuliah',null, '#mahasiswa-frm-f');" >
					<span class="glyphicon glyphicon-search"></span> </button>
			</div>
			<div class="form-inline form-group col-md-5 cari-matkul">
				<label>Jenis Nilai</label>
				<select name="f_jenis_nilai" class="form-control input-sm">
					<?php
						while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
							echo '<option value = "'.$row["nama_jenis"].'">'.strtoupper($row["nama_jenis"]).'</option>';
						}
					?>
				</select>
				<label style="width:50px; padding-left:20px">Ke</label>
				<input name="f_nilai_ke" type="number" class="form-control input-sm" value="1" style="width:60px" />
				<button type="button" class="btn btn-success btn-sm" onclick="mahasiswa_load()" >GO</button>
			</div>
		</div>
	</nav>
	<nav class="navbar navbar-default" style="padding:10px; background:white; padding-top:5px">		
		<div class="form-inline" style="margin-bottom:5px">		
			<button id="btn-absensi-save" type="button" disabled="disabled" class="btn btn-success btn-sm" onclick="nilai_save()" >
				<span class="glyphicon glyphicon-save"></span> Simpan</button>
		</div>
		<div class="box-body table-responsive">
			<table id="table-mahasiswa" class="table table-bordered table-striped table-header-fixed">
				<thead></thead>
				<tbody></tbody>
			</table>
		</div>
	</nav>
	</form>
</div>

</div>
</div>
<style>
	.parameter label:not(.btn){width:90px;}
	label.btn{margin:0px; width:35px; padding:5px;font-size:12px;}
	.form-group{margin-bottom:5px !important}
</style>

<script>
	var check_status = 0; var total_index = 0; var current_index = 0;
	var view_name = 'mahasiswa_nilai'; var table_name = '#table-mahasiswa'; var pagination_name = '#pagination-mahasiswa';
	$(document).ready(function(){
		
	});
	
	$('input[name="kehadiran"]').on('change', function(){
		try{
			$('input:radio[class="ctl_kehadiran"]').parents('label').removeClass('active');
			$('input:radio[class="ctl_kehadiran"][value="'+$(this).val()+'"]').parents('label').addClass('active');
			$('input:radio[class="ctl_kehadiran"]').val([$(this).val()]);
		}
		catch(e){
			alert(e);
		}
	});
	
	function mahasiswa_load(){
		$('#btn-absensi-save').attr("disabled", "disabled");
		dataview(view_name, 1, mahasiswa_callback, "#mahasiswa-frm-f");
	}
	
	function mahasiswa_callback(data){
		$(table_name+' thead').html('');
		$(table_name+' tbody').html('');
		
		/// Columns \\\
		var thead = '';
		$.each(data[0], function(key, arr){
			if(key != 'p_row' && key != 'active'){
				thead += '<td>'+key.toUpperCase()+'</td>';
			}
		});		
		
		thead = '<tr>'+thead+'</tr>'; $(table_name+' thead').html(thead);		
		/// Rows \\\
		var tbody = ''; var n = 0; var p_row = 0; var active_page = 0;
		$.each(data, function(index, array){
			$.each(data[0], function(key, arr){
				if(key != 'p_row'){
					if(key == 'no'){		
						if(n==0){n = array['no'];  }else{n++;}
						tbody += '<tr row-number="'+n+'">';
						tbody += '<td><label>'+n+'</label></td>';
					}
					else if(key == 'active'){
						active_page = array[key];
					}
					else{
						tbody += '<td><label name="'+key+'" value="'+array[key]+'">'+array[key]+'</label></td>';
					}
				}
				else{
					p_row = array[key];
				}
			});
			var st = array["absensi"];
			
			tbody += '<td style="width:100px">';
			tbody += '<input type="hidden" name="ctl_nim_'+n+'" value="'+array["nim"]+'" />';
			tbody += '<input type="number" class="form-control input-sm" min="0" max="100" name="ctl_nilai_'+n+'" value="'+array["nilai"]+'" />';
			tbody += '</td>';
			tbody += '</tr>';
		});
		total_index = n;
		$('input[name="total"]').val(n);
		current_index = 0;
		$(table_name+' tbody').html(tbody);
		$(table_name+' tbody').find("tr").find("td:eq(3)").remove();
		build_table_header_fix(table_name);
		
		if(data){
			$('#btn-absensi-save').removeAttr("disabled");
		}
		
	}
	
	function get_absensi_control(n, v, val){
		var st	= ''; var ck = '';		
		if(v == val){st = 'active'; ck = 'checked="checked"';}		
		var ctl = '<label class="btn btn-default btn-sm '+st+'"><input '+ck+' type="radio" class="ctl_kehadiran" name="ctl_kehadiran_'+n+'" value="'+v+'" /> '+v+'</label>';
		return ctl;
	}
	
	function nilai_save(){	
		$('#btn-absensi-save').attr("disabled", "disabled");
		datasavecallback('#mahasiswa-frm-f', nilai_save_callback);
	}
	
	function nilai_save_callback(result){
		var data = result[0];
		var msg = ''; 
		if(data['state'] == 1){
			msg = 'Data berhasil disimpan. ';
		}
		else{
			msg = 'Data gagal disimpan, err : '+data['msg'];	
		}
		alert(msg)
		$('#btn-absensi-save').removeAttr("disabled");
	}
	
</script>




