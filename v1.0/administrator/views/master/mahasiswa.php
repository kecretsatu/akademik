
<?php
	$result		= mysqli_query($con, "select * from tahun_ajaran");
	$ajaran		= mysqli_fetch_array($result, MYSQLI_ASSOC);
	$result		= mysqli_query($con, "select * from tahun_ajaran");
	$prodi		= mysqli_fetch_array($result, MYSQLI_ASSOC);
?>

<div id="mahasiswa" class="container" style="font-size:12px;" >
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<form id="mahasiswa-frm-f">
		<div class="form-inline row" style="border:0px solid black">
			<div class="form-group cari-tahun-ajaran col-xs-5">
				<label>Tahun Ajaran</label>
				<input name="f_kode_ajaran" value="" type="hidden" class="form-control input-sm control-return" data-return = "kode" style="width:70px" readonly="readonly"/>
				<input type="text" value="" class="form-control input-sm control-return" data-return = "tahun" style="width:195px" readonly="readonly"/>
				<input type="text" value="" class="form-control input-sm control-return" data-return = "semester" style="width:70px" readonly="readonly"/>
				<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-tahun-ajaran', '<?php echo getTableAlias(1,'tahun_ajaran'); ?>', 'Tahun Ajaran');" >
					<span class="glyphicon glyphicon-search"></span> </button>
			</div>
			<div class="form-group cari-prodi col-xs-6">
				<label>Program Studi</label>
				<input name="f_kode_prodi" value="" type="hidden" class="form-control input-sm control-return" data-return = "kode_prodi" style="width:70px" readonly="readonly"/>
				<input type="text" value="" class="form-control input-sm control-return" data-return = "jenjang" style="width:45px" readonly="readonly"/>
				<input type="text" value="" class="form-control input-sm control-return" data-return = "nama_prodi" style="width:250px" readonly="readonly"/>
				<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-prodi', 'prodi', 'Program Studi');" >
					<span class="glyphicon glyphicon-search"></span> </button>
									
				<button type="button" class="btn btn-success btn-sm" onclick="mahasiswa_load()" style="margin-left:20px">GO</button>					
			</div>
		</div>
		</form>
	</nav>
	
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<h4 class="text-center">Data Mahasiswa</h4>	
		<a class="btn btn-primary btn-sm" href="<?php echo $REQUEST_URI; ?>/tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
		<a class="btn btn-info btn-sm" href="<?php echo $REQUEST_URI; ?>/import"><span class="glyphicon glyphicon-upload"></span> Import Data</a>
		
		<div align="right" ><ul id = "pagination-mahasiswa" class="pagination" ></ul></div>
		<div class="box-body table-responsive">
			<table id="table-mahasiswa" class="table table-bordered table-striped table-header-fixed">
				<thead></thead>
				<tbody></tbody>
			</table>
		</div>
		
	</nav>

	
</div>

<script>
	var view_name = 'mahasiswa'; var table_name = '#table-mahasiswa'; var pagination_name = '#pagination-mahasiswa';
	$(document).ready(function(){
		
	});
	
	function mahasiswa_load(){
		dataview(view_name, 1, mahasiswa_callback, "#mahasiswa-frm-f");
	}
	
	function mahasiswa_callback(data){
		$(table_name+' thead').html('');
		$(table_name+' tbody').html('');
		$(pagination_name).html('');
		
		/// Columns \\\
		var thead = '';
		$.each(data[0], function(key, arr){
			if(key != 'p_row' && key != 'active'){
				thead += '<td>'+key.toUpperCase()+'</td>';
			}
		});		
		
		thead = '<tr>'+thead+'<td>Action</td></tr>'; $(table_name+' thead').html(thead);		
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
			tbody += '<td style="width:100px">';
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/view" type="button" class="btn btn-info btn-xs" style="width:25px; margin-right:2px;"><span class="glyphicon glyphicon-info-sign"></span> </a>';
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/update?p='+array['nim']+'" type="button" class="btn btn-primary btn-xs" style="width:25px; margin-right:2px;"><span class="glyphicon glyphicon-edit"></span> </a>';
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/delete" type="button" class="btn btn-danger btn-xs" style="width:25; margin-right:2px;"><span class="glyphicon glyphicon-remove"></span> </a>';
			tbody += '</td>';
			tbody += '</tr>';
		});
		$(table_name+' tbody').html(tbody);
		build_table_header_fix(table_name);
		
		/// Paging \\\
		var li = '';
		for(var i = 1; i <= p_row ;i++){
			if(i == active_page){
				li += '<li class="active"><a href="javascript:void(0)" onclick="dataview(view_name, '+i+', mahasiswa_callback, \'#mahasiswa-frm-f\');"  >'+i+'</a></li>';
			}
			else{
				li += '<li><a href="javascript:void(0)" onclick="dataview(view_name, '+i+', mahasiswa_callback, \'#mahasiswa-frm-f\');">'+i+'</a></li>';
			}
		}
		$(pagination_name).html(li);
	}
	
	
</script>




