
<div class="container">
	<form id="m_perpustakaan_c_frm"  enctype="multipart/form-data">
	<nav class="navbar navbar-default" style="padding:10px; background:white; ">
		<input type="hidden" name="name" value="perpustakaan" />
		<input type="hidden" name="import" value="1" />
		<div class="form-group form-inline">
			<span class="cari-grup">
				<label>Nama Grup</label>
				<input name="ctl_kode_group" column-name="kode grup" value="" type="hidden" class="form-control input-sm control-return" data-return="kode_grup" style="width:10%" />
				<input name="ctl_nama_group" column-name="nama grup" value="" type="text" class="form-control input-sm control-return" data-return="nama_grup" readonly="readonly" style="width:20%" />
				<a href="javascript:void(0)" class="btn btn-warning btn-sm" 
					onclick="showFormCari('#m_perpustakaan_c_frm .cari-grup', '<?php echo getTableAlias(1,'perpustakaan_group'); ?>', 'grup', function(){$('#m_perpustakaan_c_frm .cari-kategori input').val('');});">
					<span class="glyphicon glyphicon-search"></span> </a>
			</span>
			<label style="width:20px">&nbsp;</label>
			<span class="cari-kategori">
				<label>Nama Kategori</label>
				<input name="ctl_kode_kategori" column-name="kode kategori" type="hidden" class="form-control input-sm control-return" data-return="kode_kategori" style="width:10%" />
				<input name="ctl_nama_kategori" column-name="nama kategori" type="text" class="form-control input-sm control-return" data-return="nama_kategori" readonly="readonly" style="width:20%" />
				<a href="javascript:void(0)" class="btn btn-warning btn-sm" 
						onclick="showFormCari('#m_perpustakaan_c_frm .cari-kategori', '<?php echo getTableAlias(1,'perpustakaan_kategori'); ?>', 'kategori', null, '#m_perpustakaan_c_frm .cari-grup');">
					<span class="glyphicon glyphicon-search"></span> </a>
			</span>
		</div>
	</nav>
	<nav class="navbar navbar-default" style="padding:10px; background:white">
		<div class="form-inline">
		<div class="form-group form-inline cari-tahun-ajaran">
			<label>File ( *.csv )</label>
			<input id="file" name="file" type="file" class="form-control input-sm" style="width:195px" />
			<label id="isreading" style=" font-size:11px; width:235px"></label>
			<button id="btn-import" type="button" disabled="disabled" class="btn btn-success btn-sm" onclick="$('#m_perpustakaan_c_frm').submit();">Import Data</button>
		</div>
		</div>
	</nav>
	
	<nav class="navbar navbar-default" style="padding:10px; background:white">
		<div id="view" class="box-body table-responsive">
		
		</div>
	</nav>
	
	</form>
</div>

<script>
	$(document).ready(function(){
		$('#file').change( function(event) {
			var tmppath = URL.createObjectURL(event.target.files[0]);
			load_csv(tmppath);
		});
		
		$("#m_perpustakaan_c_frm").submit(function(){
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: JS_URL+"modul/import.php",
				type: 'POST',
				data: formData,
				async: false,
				success: function (data) {
					alert(JSON.stringify(data));
				},
				cache: false,
				contentType: false,
				processData: false
			});

			return false;
		});
		
	});
	
	
	var total_import = 0;
	function load_csv(path){
		try{
			var column_show = [0, 1, 2, 3];
			var column_name = [];
			
			$('#isreading').html('Reading csv file');
			
			$.get(path, function(data) {
				var html = '<table id="table-view" class="table table-bordered table-striped  table-header-fixed">';			
				var rows = data.split("\n");
				
				var n 	 = 0;
				rows.forEach( function getvalues(ourrow) {					
					if(ourrow != ''){
						var frm = ''; 
						var columns = ourrow.split(";");
						if(n == 0){html += "<thead><tr><td>NO</td>";}
						else if(n == 1){html += '<tbody>';}
						
						if(n > 0){html += '<tr><td><span>'+n+'</span></td>';}
						
						for(var y = 0; y < columns.length; y++){
							if(column_show.indexOf(y) >= 0){	
								html += '<td><span>' + columns[y].toUpperCase().replace('_',' ') + '</span></td>';
							}
							if(n == 0){
								//column_name.push(columns[y]);
							}
							else{
								//frm+='<input type="hidden" name="ctl_'+column_name[y]+'" value="'+columns[y]+'" />';
								
							}
						}
						
						if(n == 0){html += "<td>STATUS</td></tr></thead>";}
						else{
							html += '<td>';
							//html += ''+frm+'</form>';
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