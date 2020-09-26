
<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<div class="form-group">
			<div class="col-xs-12">
				<form id="rencana-studi-frm-f">
				<div class="form-inline">
					<div class="form-group cari-tahun-ajaran">
						<label>Tahun Ajaran</label>
						<select class="form-control">
							<option>2015/2016 (GENAP)</option>
						</select>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-success btn-sm" onclick="rencana_studi_load_data()">GO</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</nav>
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
	<form id="f_hari_frm"><input type="hidden" name="f_hari" value="<?php if(isset($_GET['f_hari'])){echo $_GET['f_hari'];}else{echo 'senin';} ?>"/></form>
	<ul id="hari-tabs" class="nav nav-tabs">
	  <li class="senin"><a href="#senin" data-toggle="tab">Senin</a></li>
	  <li class="selasa"><a href="#selasa" data-toggle="tab">Selasa</a></li>
	  <li class="rabu"><a href="#rabu" data-toggle="tab">Rabu</a></li>
	  <li class="kamis"><a href="#kamis" data-toggle="tab">Kamis</a></li>
	  <li class="jumat"><a href="#jumat" data-toggle="tab">Jumat</a></li>
	  <li class="sabtu"><a href="#sabtu" data-toggle="tab">Sabtu</a></li>
	  <li class="minggu"><a href="#minggu" data-toggle="tab">Minggu</a></li>
	  <li class="none"><a href="#none" data-toggle="tab">Belum Terjadwal</a></li>
	</ul>
	<div id='content' class="tab-content" style="height:auto;">
		<div class="tab-pane active" id="senin">
			<div class="box-body">				
				<h4 id="table-title" class="text-center" style="padding-top:10px">Jadwal Kuliah Hari Senin</h4>	
				<a id="tambah-jadwal-kuliah" class="btn btn-primary btn-sm" href="<?php echo $REQUEST_URI; ?>/tambah?hari=senin"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
				<div id="jadwal-kuliah-parent" class="box-body table-responsive  table-responsive-auto">
					<br/>
					<table id="table-jadwal-kuliah" class="table table-bordered table-striped"><thead></thead><tbody></tbody></table>
				</div>
			</div>
		</div>
	</div>
	</nav>
</div>

<script>
	var hari = '<?php if(isset($_GET['f_hari'])){echo $_GET['f_hari'];}else{echo 'senin';} ?>';
	var view_name = '<?php echo getTableAlias(1,'jadwal_kuliah'); ?>'; var table_name = '#table-jadwal-kuliah'; var pagination_name = '#pagination-jadwal-kuliah';
	$(document).ready(function(){
		$('#hari-tabs li').removeClass("active");
		$('#hari-tabs .'+$('input[name="f_hari"]').val()).addClass("active");
		jadwal_kuliah_load_data();
	});
	
	$('.nav-tabs a').click(function(){
		hari = $(this).attr('href').replace('#','');
		jadwal_kuliah_load_data();
	});	
		
	function jadwal_kuliah_load_data(){
		$('input[name="f_hari"]').val(hari);
		window.history.replaceState('', '', '?'+setParamsURL('#f_hari_frm'));
		$('#tambah-jadwal-kuliah').attr('href', '<?php echo $REQUEST_URI; ?>/tambah?hari='+hari);
		if(hari != 'none'){
			$('#table-title').html('Jadwal Kuliah Hari '+ucfirst(hari));
			$('#tambah-jadwal-kuliah').show();
		}
		else{
			$('#table-title').html('Jadwal Kuliah Belum Terjadwal');
			$('#tambah-jadwal-kuliah').hide();
		}
		
		dataview(view_name, 1, jadwal_kuliah_callback, '#f_hari_frm');
	}
	
	function jadwal_kuliah_callback(data){
		var tb = '<br/><table id="table-jadwal-kuliah" class="table table-bordered table-striped"><thead></thead><tbody></tbody></table>';
		
		$('#jadwal-kuliah-parent').html(tb);
		
		/// Columns \\\
		var thead = '';
		$.each(data[0], function(key, arr){
			if(key != 'p_row' && key != 'prime' && key != 'none'){
				thead += '<td>'+key.toUpperCase()+'</td>';
			}
		});		
		
		thead = '<tr>'+thead+'<td>ACTION</td></tr>'; $(table_name+' thead').html(thead);		
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
						if(key != 'prime' && key != 'none'){
							tbody += '<td><label name="'+key+'" value="'+array[key]+'">'+array[key]+'</label></td>';
						}
					}
				}
				else{
					p_row = array[key];
				}
			});
			if($('input[name="f_hari"]').val() != 'none'){
				tbody += '<td style="width:100px"><form id="frm-remove-'+array['prime']+'"><input type="hidden" name="name" value="<?php echo getTableAlias(1,'jadwal_kuliah'); ?>" />';
				tbody += '<input type="hidden" name="ctl_kode_jadwal" value="'+array['prime']+'" /></form>';
				tbody += '<a href="<?php echo $REQUEST_URI; ?>/view" type="button" class="btn btn-info btn-xs" style="width:25px; margin-right:2px;"><span class="glyphicon glyphicon-info-sign"></span> </a>';
				tbody += '<a href="<?php echo $REQUEST_URI; ?>/update?p='+array['prime']+'" type="button" class="btn btn-primary btn-xs" style="width:25px; margin-right:2px;"><span class="glyphicon glyphicon-edit"></span> </a>';
				tbody += '<button onclick="dataremovecallback(\'#frm-remove-'+array['prime']+'\', jadwal_kuliah_load_data)" type="button" class="btn btn-danger btn-xs" style="width:25; margin-right:2px;"><span class="glyphicon glyphicon-remove"></span> </button>';
				tbody += '</td>';
			}
			else{
				tbody += '<td style="width:100px">';
				tbody += '<a href="<?php echo $REQUEST_URI; ?>/tambah?rs='+array['prime']+'" type="button" class="btn btn-primary btn-xs" ><span class="glyphicon glyphicon-plus"></span> Tambah Jadwal</a>';
				tbody += '</td>';
			}
			tbody += '</tr>';
		});
		$(table_name+' tbody').html(tbody);
		
		if($('input[name="f_hari"]').val() == 'none'){
			buildTableGroupHeader(table_name, '', 1, '48%', '100px');
		}
		
		/// Paging \\\
		var li = '';
		for(var i = 1; i <= p_row ;i++){
			if(i == active_page){
				li += '<li><a href="javascript:void(0)" onclick="dataview(view_name, '+i+', rencana_studi_callback, \'#rencana-studi-frm-f\');"  style="background:#d9edf7">'+i+'</a></li>';
			}
			else{
				li += '<li><a href="javascript:void(0)" onclick="dataview(view_name, '+i+', rencana_studi_callback, \'#rencana-studi-frm-f\');">'+i+'</a></li>';
			}
		}
		$(pagination_name).html(li);
	}
	
	
</script>

