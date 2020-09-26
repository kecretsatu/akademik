
<div id="dosen" class="container" style="font-size:12px;" >
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<div class="form-group">
			<div class="col-xs-10">
				<div class="form-inline">
					<div class="form-group">
						<label>Status</label>
						<select class="form-control">
							<option>Aktif</option>
							<option>Cuti</option>
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
		<h4 class="text-center">Data Dosen</h4>	
		<a class="btn btn-primary btn-sm" href="<?php echo $REQUEST_URI; ?>/tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
		<br/><br/>
		<div class="box-body table-responsive">
			<table id="table-dosen" class="table table-bordered table-striped">
				<thead></thead>
				<tbody></tbody>
			</table>
			<ul id = "pagination-dosen" class="pagination"></ul>
		</div>
		
	</nav>	
</div>

<script>
	var view_name = 'dosen'; var table_name = '#table-dosen'; var pagination_name = '#pagination-dosen';
	$(document).ready(function(){
		dataview(view_name, 1, dosen_callback);
	});
	
	function dosen_callback(data){
		
		/// Columns \\\
		var thead = '';
		$.each(data[0], function(key, arr){
			if(key != 'p_row'){
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
						if(n==0){n = array['no']; active_page = n; }else{n++;}
						tbody += '<tr row-number="'+n+'">';
						tbody += '<td><label>'+n+'</label></td>';
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
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/update?p='+array['nidn']+'" type="button" class="btn btn-primary btn-xs" style="width:25px; margin-right:2px;"><span class="glyphicon glyphicon-edit"></span> </a>';
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/delete" type="button" class="btn btn-danger btn-xs" style="width:25; margin-right:2px;"><span class="glyphicon glyphicon-remove"></span> </a>';
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


