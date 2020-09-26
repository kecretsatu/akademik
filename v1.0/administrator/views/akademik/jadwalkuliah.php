
<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<div class="row col-md-12">
			<div class="col-md-2" ><label>Masukkan NIM</label></div>
			<div class="col-md-4" ><form id="perwalian-frm-f"><input name="ctl_nim" type="text" value="<?php if(isset($_GET['nim'])){echo $_GET['nim'];} ?>" class="form-control input-sm" /></form></div>
			<div class="col-md-2" ><button type="button" class="btn btn-success btn-sm" onclick="jadwal_kuliah_load_data();" >GO</button></div>
		</div>
	</nav>
	<nav id="nav-jadwal-kuliah" class="navbar navbar-default" style="padding:10px; background:white;">
	<form id="f_hari_frm"><input type="hidden" name="f_hari" value="senin"/><input type="hidden" name="mhs_nim" value="<?php if(isset($_GET['nim'])){echo $_GET['nim'];} ?>"/></form>
	<ul class="nav nav-tabs">
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
				<h4 id="table-title" class="text-center">Jadwal Kuliah Hari Senin</h4>	
				<div class="box-body table-responsive">
					<br/>
					<table id="table-jadwal-kuliah" class="table table-bordered table-striped">
						<thead></thead>
						<tbody></tbody>
					</table>
					<ul id = "pagination-jadwal-kuliah" class="pagination"></ul>
				</div>
			</div>
		</div>
	</div>
	</nav>
</div>

<script>
	var hari = '';
	var view_name = '<?php echo getTableAlias(1,'jadwal_kuliah'); ?>'; var table_name = '#table-jadwal-kuliah'; var pagination_name = '#pagination-jadwal-kuliah';
	$(document).ready(function(){
		
		<?php if(isset($_GET['nim'])){echo 'jadwal_kuliah_load_data();';} ?>
	});
	
	$('.nav-tabs a').click(function(){
		hari = $(this).attr('href').replace('#','');
		$('input[name="f_hari"]').val(hari);
		$('#table-title').html('Jadwal Kuliah Hari '+ucfirst(hari));
		jadwal_kuliah_load_data();
	});
		
	function jadwal_kuliah_load_data(){
		if($('input[name="ctl_nim"]').val() == ''){
			alert('Maaf, Silahkan isi NIM Anda');
			return false;
		}
		$('input[name="mhs_nim"]').val($('input[name="ctl_nim"]').val());
		window.history.replaceState('', '', '?nim='+$('input[name="ctl_nim"]').val());
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

