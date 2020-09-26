
<div class="container">	
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<h4 class="text-center">Data Anggaran</h4>	
		<a class="btn btn-primary btn-sm" href="<?php echo $REQUEST_URI; ?>/tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
		<br/><br/>
		<div class="box-body table-responsive">
			<table id="table-jenis-anggaran" class="table table-bordered table-striped" style="width:50%">
				<thead></thead>
				<tbody></tbody>
			</table>
			<ul id = "pagination-jenis-anggaran" class="pagination"></ul>
		</div>
		
	</nav>
	
</div>

<script>
	var view_name = '<?php echo getTableAlias(1,'keuangan_jenis'); ?>'; var table_name = '#table-jenis-anggaran'; var pagination_name = '#pagination-jenis-anggaran';
	$(document).ready(function(){
		keuangan_jenis_load();
	});
	
	function keuangan_jenis_load(data){
		dataview(view_name, 1, keuangan_jenis_callback);
	}
	
	function keuangan_jenis_callback(data){
		$(table_name+' thead').html('');
		$(table_name+' tbody').html('');
		
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
			tbody += '<form id="remove_anggaran_frm'+n+'"><input type="hidden" name="name" value="<?php echo getTableAlias(1,'keuangan_jenis_anggaran'); ?>" />';
			tbody += '<input type="hidden" name="ctl_kode_anggaran" value="'+array['prime']+'" /></form>';
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/view" type="button" class="btn btn-info btn-xs" style="width:25px; margin-right:2px;"><span class="glyphicon glyphicon-info-sign"></span> </a>';
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/update?p='+array['prime']+'" type="button" class="btn btn-primary btn-xs" style="width:25px; margin-right:2px;"><span class="glyphicon glyphicon-edit"></span> </a>';
			tbody += '<a href="javascript:void(0)" onclick="dataremovecallback(\'#remove_anggaran_frm'+n+'\', fakultas_load)" type="button" class="btn btn-danger btn-xs" style="width:25; margin-right:2px;"><span class="glyphicon glyphicon-remove"></span> </a>';
			tbody += '</td>';
			tbody += '</tr>';
		});
		$(table_name+' tbody').html(tbody);
		
		/// Paging \\\
		var li = '';
		for(var i = 1; i <= p_row ;i++){
			if(i == active_page){
				li += '<li><a href="javascript:void(0)" onclick="dataview(view_name, '+i+', keuangan_jenis_callback);"  style="background:#d9edf7">'+i+'</a></li>';
			}
			else{
				li += '<li><a href="javascript:void(0)" onclick="dataview(view_name, '+i+', keuangan_jenis_callback);">'+i+'</a></li>';
			}
		}
		$(pagination_name).html(li);
	}
	
	
</script>

