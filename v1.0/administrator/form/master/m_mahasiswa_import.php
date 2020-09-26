
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
				<input type="number" name="ctl_semester_aktif" class="form-control input-sm" value="" style="width:60px" />
				<label style="text-align:right; width:125px">Status</label>
				<select name="ctl_status_mahasiswa" class="form-control input-sm"><option value="aktif">AKTIF</option></select>
			</div>
			<input type="hidden" name="ctl_nim" value="" />
			<input type="hidden" name="ctl_kode_kelas" value="" />
		</div>
	</form>
	</nav>
	<nav class="navbar navbar-default" style="padding:10px; background:white">
		<div class="form-inline">
		<div class="form-group form-inline cari-tahun-ajaran">
			<label>File ( *.csv )</label>
			<input id="file" name="file" type="file" class="form-control input-sm" style="width:195px" />
			<label id="isreading" style=" font-size:11px; width:235px"></label>
			<button id="btn-import" type="button" disabled="disabled" class="btn btn-success btn-sm" onclick="import_data()">Import Data</button>
		</div>
		</div>
	</nav>
	
	<nav class="navbar navbar-default" style="padding:10px; background:white">
		<div id="view" class="box-body table-responsive">
		
		</div>
	</nav>
	
</div>

<script>
	$(document).ready(function(){
		$('#file').change( function(event) {
			var tmppath = URL.createObjectURL(event.target.files[0]);
			load_csv(tmppath);
		});
	});
	
	var total_import = 0;
	function load_csv(path){
		try{
			var column_show = [0, 2];
			var column_name = [];
			
			$('#isreading').html('Reading csv file');
			
			$.get(path, function(data) {
				var html = '<table id="table-view" class="table table-bordered table-striped  table-header-fixed">';			
				var rows = data.split("\n");
				
				var n 	 = 0;
				rows.forEach( function getvalues(ourrow) {					
					if(ourrow != ''){
						var frm = ''; 
						var columns = ourrow.split(",");
						if(n == 0){html += "<thead><tr><td>NO</td>";}
						else if(n == 1){html += '<tbody>';}
						
						if(n > 0){html += '<tr><td><span>'+n+'</span></td>';}
						
						for(var y = 0; y < columns.length; y++){
							if(column_show.indexOf(y) >= 0){	
								html += '<td><span>' + columns[y].toUpperCase().replace('_',' ') + '</span></td>';
							}
							if(n == 0){
								column_name.push(columns[y]);
							}
							else{
								frm+='<input type="hidden" name="ctl_'+column_name[y]+'" value="'+columns[y]+'" />';
								
							}
						}
						
						if(n == 0){html += "<td>STATUS</td></tr></thead>";}
						else{
							html += '<td><form id="import_mahasiswa_frm_'+n+'"><input type="hidden" name="name" value="<?php echo getTableAlias(1,'mahasiswa_biodata'); ?>" />';
							html += ''+frm+'</form>';
							html += '<span id="status_import_'+n+'">READY</span></td></tr></thead>';
						}
						
						n++;
					}
				});
				html += "</tbody>";
				html += "</table>";
				
				$('#view').html(html);	
				build_table_header_fix('#table-view');
				
				total_import = n - 1;
				$('#isreading').html('Finish reading csv file. Total '+total_import+' rows.');
				$('#btn-import').removeAttr('disabled');
			});
		}
		catch(e){
			$('#isreading').html('Failed reading csv file! err : '+e);
		}
	}
	
	var current_import = 0;
	function import_data(){
		$('#btn-import').attr('disabled','disabled');
		current_import++;
		
		if(current_import > total_import){
			$('#btn-import').removeAttr('disabled');
			return false;
		}
		
		datasavecallback('#import_mahasiswa_frm_'+current_import, import_data_callback);
		
	}
	
	function import_data_callback(result){
		var data = result[0];
		
		var msg = ''; 
		if(data['state'] == 1){
			msg = 'Data berhasil disimpan. '+data['msg']+' (waiting)';
			//$('#status_import_'+current_import).html(msg);	
			import_civitas();
		}
		else{
			msg = 'Gagal, err : '+data['msg'];
			$('#status_import_'+current_import).html(msg);	
			import_data();
		}
	}
	
	function import_civitas(){
		$('#m_mahasiswa_c_frm input[name="ctl_nim"]').val($('#import_mahasiswa_frm_'+current_import+' input[name="ctl_nim"]').val());
		datasavecallback('#m_mahasiswa_c_frm', import_civitas_callback);
	}
	function import_civitas_callback(result){
		var data = result[0];
		
		var msg = ''; 
		if(data['state'] == 1){
			msg = 'Tersimpan. ';
		}
		else{
			msg = 'Gagal, err : '+data['msg'];	
		}
		$('#status_import_'+current_import).html(msg);	
		import_data();
	}
	
	
</script>

<style>
	form label{width:100px;}
</style>