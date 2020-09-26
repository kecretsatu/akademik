
<?php
	$isLoad = false; $tahun; $prodi;
	if(!$paramsURL){}else{
		$isLoad = true;
		$result	= mysqli_query($con, "select * from tahun_ajaran where kode_ajaran = '".$_GET['f_kode_ajaran']."'");
		$tahun	= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
	}
?>

<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<div class="form-group">
			<div class="col-xs-12">
				<form id="jadwal-perwalian-frm-f">
				<div class="form-inline">
					<div class="form-group cari-tahun-ajaran">
						<label>Tahun Ajaran</label>
						<input name="f_kode_ajaran" value="<?php if($isLoad){echo $tahun["kode_ajaran"];} ?>" type="hidden" class="form-control input-sm control-return" data-return = "kode" style="width:70px" readonly="readonly"/>
						<input type="text" value="<?php if($isLoad){echo $tahun["tahun"];} ?>" class="form-control input-sm control-return" data-return = "tahun" style="width:195px" readonly="readonly"/>
						<input type="text" value="<?php if($isLoad){echo $tahun["semester"];} ?>" class="form-control input-sm control-return" data-return = "semester" style="width:70px" readonly="readonly"/>
						<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-tahun-ajaran', '<?php echo getTableAlias(1,'tahun_ajaran'); ?>', 'Tahun Ajaran');" >
							<span class="glyphicon glyphicon-search"></span> </button>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-success btn-sm" onclick="jadwal_perwalian_load_data()">GO</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</nav>
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<div class="box-body">				
			<h4 class="text-center">Jadwal Perwalian</h4>	
			<a id="tambah-jadwal-perwalian" class="btn btn-primary btn-sm" href="<?php echo $REQUEST_URI; ?>/tambah" style="display:none"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
			<div class="box-body table-responsive">
				<br/>
				<table id="table-jadwal-perwalian" class="table table-bordered table-striped">
					<thead></thead>
					<tbody></tbody>
				</table>
				<ul id = "pagination-jadwal-perwalian" class="pagination"></ul>
			</div>
		</div>
	</nav>
</div>

<script>
	var view_name = '<?php echo getTableAlias(1,'perwalian_jadwal'); ?>'; var table_name = '#table-jadwal-perwalian'; var pagination_name = '#pagination-jadwal-perwalian';
	$(document).ready(function(){
		<?php if($isLoad){echo 'jadwal_perwalian_load_data()';} ?>
	});
	
	function jadwal_perwalian_load_data(){
		window.history.replaceState('', '', '?'+setParamsURL('#jadwal-perwalian-frm-f'));
		$('#tambah-jadwal-perwalian').attr('href','<?php echo $REQUEST_URI; ?>/tambah?'+setParamsURL('#jadwal-perwalian-frm-f'));
		$('#tambah-jadwal-perwalian').show();
		dataview(view_name, 1, rencana_studi_callback, '#jadwal-perwalian-frm-f');
	}
	
	function rencana_studi_callback(data){
		$(table_name+' thead').html('');
		$(table_name+' tbody').html('');
		
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
			tbody += '<td style="width:100px">';
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/view" type="button" class="btn btn-info btn-xs" style="width:25px; margin-right:2px;"><span class="glyphicon glyphicon-info-sign"></span> </a>';
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/update?p='+array['prime']+'" type="button" class="btn btn-primary btn-xs" style="width:25px; margin-right:2px;"><span class="glyphicon glyphicon-edit"></span> </a>';
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/delete" type="button" class="btn btn-danger btn-xs" style="width:25; margin-right:2px;"><span class="glyphicon glyphicon-remove"></span> </a>';
			tbody += '</td>';
			tbody += '</tr>';
		});
		$(table_name+' tbody').html(tbody);
		
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

