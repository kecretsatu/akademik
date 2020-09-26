
<div class="container">
		
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<h4 class="text-center">Data Ruang</h4>	
		<a class="btn btn-primary btn-sm" href="<?php echo $REQUEST_URI; ?>/tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
		<br/><br/>
		<div class="box-body table-responsive">
			<table id="table-ruang" class="table table-bordered table-striped">
				<thead></thead>
				<tbody></tbody>
			</table>
			<ul id = "pagination-ruang" class="pagination"></ul>
		</div>
		
	</nav>
	
</div>

<script>
	var view_name = '<?php echo getTableAlias(1,'ruang'); ?>'; var table_name = '#table-ruang'; var pagination_name = '#pagination-ruang';
	$(document).ready(function(){
		ruang_load();
	});
	
	function ruang_load(){
		dataview(view_name, 1, ruang_callback);
	}
	
	function ruang_callback(data){
		
		/// Columns \\\
		var thead = '';
		$.each(data[0], function(key, arr){
			if(key != 'p_row'){
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
						tbody += '<td><label name="'+key+'" value="'+array[key]+'">'+array[key]+'</label></td>';
					}
				}
				else{
					p_row = array[key];
				}
			});
			tbody += '<td style="width:100px">';
			tbody += '<form id="ruang_remove_f_'+n+'"><input type="hidden" name="name" value="<?php echo getTableAlias(1,'ruang'); ?>" />';
			tbody += '<input type="hidden" name="ctl_kode_ruang" value="'+array['ruang']+'" /></form>';
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/view" type="button" class="btn btn-info btn-xs" style="width:25px; margin-right:2px;"><span class="glyphicon glyphicon-info-sign"></span> </a>';
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/update?p='+array['ruang']+'" type="button" class="btn btn-primary btn-xs" style="width:25px; margin-right:2px;"><span class="glyphicon glyphicon-edit"></span> </a>';
			tbody += '<a href="javascript:void(0)" type="button" onclick="dataremovecallback(\'#ruang_remove_f_'+n+'\', ruang_load)" class="btn btn-danger btn-xs" style="width:25; margin-right:2px;"><span class="glyphicon glyphicon-remove"></span> </a>';
			tbody += '</td>';
			tbody += '</tr>';
		});
		$(table_name+' tbody').html(tbody);
		
		/// Paging \\\
		var li = '';
		for(var i = 1; i <= p_row ;i++){
			if(i == active_page){
				li += '<li><a href="javascript:void(0)" onclick="dataview(view_name, '+i+', ruang_callback);"  style="background:#d9edf7">'+i+'</a></li>';
			}
			else{
				li += '<li><a href="javascript:void(0)" onclick="dataview(view_name, '+i+', ruang_callback);">'+i+'</a></li>';
			}
		}
		$(pagination_name).html(li);
	}
	
	
</script>

