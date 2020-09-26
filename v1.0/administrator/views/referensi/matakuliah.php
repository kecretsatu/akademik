
<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<div class="form-group">
			<div class="col-xs-10">
				<div class="form-inline">
					<div class="form-group">
						<label>Jenjang</label>
						<select class="form-control">
							<option>S1</option>
							<option>D3</option>
						</select>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-success btn-sm">GO</button>
					</div>
				</div>
			</div>
		</div>
	</nav>
	
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<h4 class="text-center">Data Mata Kuliah</h4>	
		<a class="btn btn-primary btn-sm" href="<?php echo $REQUEST_URI; ?>/tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
		
		<div align="right" ><ul id = "pagination-matkul" class="pagination" ></ul></div>
		<div class="box-body table-responsive">			
			<table id="table-matkul" class="table table-bordered table-striped table-header-fixed">
				<thead></thead>
				<tbody></tbody>
			</table>
		</div>
		
	</nav>
	
</div>

<script>
	var view_name = '<?php echo getTableAlias(1, 'mata_kuliah'); ?>'; var table_name = '#table-matkul'; var pagination_name = '#pagination-matkul';
	var pg = 1;
	$(document).ready(function(){
		<?php
			if(isset($_GET['page'])){echo 'pg = '.$_GET['page'].';';}
		?>
		matkul_load();
	});
	
	function matkul_load(data){
		window.history.replaceState('', '', '?page='+pg);
		dataview(view_name, pg, matkul_callback);
	}
	
	function matkul_callback(data){
		/// Columns \\\
		var thead = '';
		$.each(data[0], function(key, arr){
			if(key != 'p_row' && key != 'active' && key!='dosen'){
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
						if(n==0){n = array['no']; }else{n++;}
						tbody += '<tr row-number="'+n+'">';
						tbody += '<td><label>'+n+'</label></td>';
					}
					else if(key == 'active'){
						active_page = array[key];
					}
					else{
						if(key!='dosen'){
							tbody += '<td><label name="'+key+'" value="'+array[key]+'">'+array[key]+'</label></td>';
						}
					}
				}
				else{
					p_row = array[key];
				}
			});
			tbody += '<td style="width:100px">';
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/dosen?p='+array['kode mk']+'" type="button" class="btn btn-warning btn-xs" style="width:78px; margin-right:2px; margin-bottom:2px"><span class="glyphicon glyphicon-user"></span> '+array['dosen']+' Dosen</a>';
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/view" type="button" class="btn btn-info btn-xs" style="width:25px; margin-right:2px;"><span class="glyphicon glyphicon-info-sign"></span> </a>';
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/update?p='+array['kode mk']+'" type="button" class="btn btn-primary btn-xs" style="width:25px; margin-right:2px;"><span class="glyphicon glyphicon-edit"></span> </a>';
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
				li += '<li class="active"><a href="javascript:void(0)" onclick="pg = '+i+'; matkul_load();">'+i+'</a></li>';
			}
			else{
				li += '<li><a href="javascript:void(0)" onclick="pg = '+i+'; matkul_load();">'+i+'</a></li>';
			}
		}
		$(pagination_name).html(li);
	}
	
	
</script>

