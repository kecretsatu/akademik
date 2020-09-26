
<?php
	$isLoad = false; $tahun; $prodi;
	if(!$paramsURL){}else{
		$isLoad = true;
		$result	= mysqli_query($con, "select * from tahun_ajaran where kode_ajaran = '".$_GET['f_kode_ajaran']."'");
		$tahun	= mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$result	= mysqli_query($con, "select * from prodi_identitas where kode_prodi = '".$_GET['f_kode_prodi']."'");
		$prodi	= mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
?>

<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<form id="kelas-frm-f">
		<div class="form-inline row" style="border:0px solid black">
			<div class="form-group cari-tahun-ajaran col-xs-5">
				<label>Tahun Ajaran</label>
				<input name="f_kode_ajaran" value="<?php if($isLoad){echo $tahun["kode_ajaran"];} ?>" type="hidden" class="form-control input-sm control-return" data-return = "kode" style="width:70px" readonly="readonly"/>
				<input type="text" value="<?php if($isLoad){echo $tahun["tahun"];} ?>" class="form-control input-sm control-return" data-return = "tahun" style="width:195px" readonly="readonly"/>
				<input type="text" value="<?php if($isLoad){echo $tahun["semester"];} ?>" class="form-control input-sm control-return" data-return = "semester" style="width:70px" readonly="readonly"/>
				<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-tahun-ajaran', '<?php echo getTableAlias(1,'tahun_ajaran'); ?>', 'Tahun Ajaran');" >
					<span class="glyphicon glyphicon-search"></span> </button>
			</div>
			<div class="form-group cari-prodi col-xs-6">
				<label>Program Studi</label>
				<input name="f_kode_prodi" value="<?php if($isLoad){echo $prodi["kode_prodi"];} ?>" type="hidden" class="form-control input-sm control-return" data-return = "kode_prodi" style="width:70px" readonly="readonly"/>
				<input type="text" value="<?php if($isLoad){echo $prodi["jenjang"];} ?>" class="form-control input-sm control-return" data-return = "jenjang" style="width:45px" readonly="readonly"/>
				<input type="text" value="<?php if($isLoad){echo $prodi["nama_prodi"];} ?>" class="form-control input-sm control-return" data-return = "nama_prodi" style="width:250px" readonly="readonly"/>
				<button type="button" class="btn btn-warning btn-sm" onclick="showFormCari('.cari-prodi', 'prodi', 'Program Studi');" >
					<span class="glyphicon glyphicon-search"></span> </button>
									
				<button type="button" class="btn btn-success btn-sm" onclick="kelas_load_data()" style="margin-left:20px">GO</button>					
			</div>
		</div>
		</form>
	</nav>
	
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<h4 class="text-center">Data Kelas</h4>	
		<a id="tambah-kelas" class="btn btn-primary btn-sm" href="<?php echo $REQUEST_URI; ?>/tambah" style="display:none"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
		<br/><br/>
		<div id="table-kelas-parent" class="box-body table-responsive">
			<table id="table-kelas" class="table table-bordered table-striped">
				<thead></thead>
				<tbody></tbody>
			</table>
			<ul id = "pagination-kelas" class="pagination"></ul>
		</div>
		
	</nav>
	
</div>

<script>
	var view_name = '<?php echo getTableAlias(1,'kelas'); ?>'; var table_name = '#table-kelas'; var pagination_name = '#pagination-kelas';
	$(document).ready(function(){
		<?php if($isLoad){echo 'kelas_load_data()';} ?>
	});
	
	function kelas_load_data(){
		window.history.replaceState('', '', '?'+setParamsURL('#kelas-frm-f'));
		$('#tambah-kelas').attr('href','<?php echo $REQUEST_URI; ?>/tambah?'+setParamsURL('#kelas-frm-f'));
		$('#tambah-kelas').show();
		dataview(view_name, 1, kelas_callback, '#kelas-frm-f');
	}
	
	function kelas_callback(data){
		var tb = '<table id="table-kelas" class="table table-bordered table-striped">';
		tb    +=' <thead></thead><tbody></tbody></table>';
		$('#table-kelas-parent').html(tb);
		
		/// Columns \\\
		var thead = '';
		$.each(data[0], function(key, arr){
			if(key != 'p_row' && key != 'prime'){
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
						if(key != 'prime'){
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
		//buildTableGroupHeader(table_name, '', 1, '500px', '100px');
		
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

