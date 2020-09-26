
<div class="container">
	
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<h4 class="text-center">Data Nilai Keuangan</h4>	
		<div>
		<a class="btn btn-primary btn-sm" href="<?php echo $REQUEST_URI; ?>/tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
		</div><br/>
		<div id="table-keuangan-nilai-parent" class="box-body table-responsive">
			<table id="table-keuangan-nilai" class="table table-bordered table-striped">
				<thead></thead>
				<tbody></tbody>
			</table>
			<!--<ul id = "pagination-jurusan" class="pagination"></ul>-->
		</div>
		
	</nav>
	
</div>

<script>
	var view_name = '<?php echo getTableAlias(1,'keuangan_nilai'); ?>'; var table_name = '#table-keuangan-nilai'; var pagination_name = '#pagination-jurusan';
	$(document).ready(function(){
		keuangan_nilai_load();
	});
	
	function keuangan_nilai_load(data){
		dataview(view_name, 1, keuangan_nilai_callback);
	}
	
	function keuangan_nilai_callback(data){		
		var tb = '<table id="table-keuangan-nilai" class="table table-bordered table-striped">';
		tb    +=' <thead></thead><tbody></tbody></table>';
		$('#table-keuangan-nilai-parent').html(tb);
		
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
			tbody += '<form id="remove_keuangan_nilai_frm'+n+'"><input type="hidden" name="name" value="<?php echo getTableAlias(1,'keuangan_nilai'); ?>" />';
			tbody += '<input type="hidden" name="ctl_kode_keuangan" value="'+array['prime']+'" /></form>';
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/view" type="button" class="btn btn-info btn-xs" style="width:25px; margin-right:2px;"><span class="glyphicon glyphicon-info-sign"></span> </a>';
			tbody += '<a href="<?php echo $REQUEST_URI; ?>/update?p='+array['prime']+'" type="button" class="btn btn-primary btn-xs" style="width:25px; margin-right:2px;"><span class="glyphicon glyphicon-edit"></span> </a>';
			tbody += '<a href="javascript:void(0)" onclick="dataremovecallback(\'#remove_keuangan_nilai_frm'+n+'\', keuangan_nilai_load)" type="button" class="btn btn-danger btn-xs" style="width:25; margin-right:2px;"><span class="glyphicon glyphicon-remove"></span> </a>';
			tbody += '</td>';
			tbody += '</tr>';
		});
		$(table_name+' tbody').html(tbody);
		buildTableGroupHeader(table_name,'', 4, '500px', '100px');
		
		/// Paging \\\
		var li = '';
		for(var i = 1; i <= p_row ;i++){
			if(i == active_page){
				li += '<li><a href="javascript:void(0)" onclick="dataview(view_name, '+i+', keuangan_nilai_callback);"  style="background:#d9edf7">'+i+'</a></li>';
			}
			else{
				li += '<li><a href="javascript:void(0)" onclick="dataview(view_name, '+i+', keuangan_nilai_callback);">'+i+'</a></li>';
			}
		}
		$(pagination_name).html(li);
	}
	
	
</script>

