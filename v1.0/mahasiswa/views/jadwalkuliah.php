
<div class="panel panel-primary menu " >
  <div class="panel-heading">Jadwal Kuliah</div>
  <div class="panel-body" >

	<form id="f_hari_frm"><input type="hidden" name="f_hari" value="senin"/>
		<input type="hidden" name="mhs_nim" value="<?php if(isset($_SESSION['userlogin'])){echo $_SESSION['userlogin'];} ?>"/></form>
	<ul id="hari-tabs" class="nav nav-tabs">
	  <li class="active"><a href="#senin" data-toggle="tab">Senin</a></li>
	  <li><a href="#selasa" data-toggle="tab">Selasa</a></li>
	  <li><a href="#rabu" data-toggle="tab">Rabu</a></li>
	  <li><a href="#kamis" data-toggle="tab">Kamis</a></li>
	  <li><a href="#jumat" data-toggle="tab">Jumat</a></li>
	  <li><a href="#sabtu" data-toggle="tab">Sabtu</a></li>
	  <li><a href="#minggu" data-toggle="tab">Minggu</a></li>
	</ul>
	<div id='content' class="tab-content" style="height:auto;">
		<div class="tab-pane active" id="senin">
			<div class="box-body">				
				<div class="box-body table-responsive">
					<br/>
					<table id="table-jadwal-kuliah" class="table table-bordered table-striped">
						<thead></thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>
</div>
<?php $hari = array("senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu"); ?>
<script>
	var hari = '<?php echo $hari[date('w') - 1]; ?>';
	var view_name = '<?php echo getTableAlias(1,'jadwal_kuliah'); ?>'; var table_name = '#table-jadwal-kuliah'; var pagination_name = '#pagination-jadwal-kuliah';
	$(document).ready(function(){
		$('a[href="#<?php echo $hari[date('w') - 1]; ?>"]').click();
		//jadwal_kuliah_load_data();
	});
	
	$('#hari-tabs a').click(function(){
		hari = $(this).attr('href').replace('#','');
		jadwal_kuliah_load_data();
	});
		
	function jadwal_kuliah_load_data(){
		$('input[name="f_hari"]').val(hari);
		dataview(view_name, 1, jadwal_kuliah_callback, '#f_hari_frm');
	}
	
	function jadwal_kuliah_callback(data){
		$(table_name+' thead').html('');
		$(table_name+' tbody').html('');
		
				
		/// Columns \\\
		var thead = '';
		$.each(data[0], function(key, arr){
			if(key != 'p_row' && key != 'prime' && key != 'none'){
				thead += '<td>'+key.toUpperCase()+'</td>';
			}
		});		
		
		
		thead = '<tr>'+thead+'</tr>'; $(table_name+' thead').html(thead);		
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
			tbody += '</tr>';
		});
		$(table_name+' tbody').html(tbody);
		
	}
	
		
</script>

