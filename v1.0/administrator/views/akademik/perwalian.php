

<div class="container">
	<form id="rencana-studi-frm-f">
		<input name="f_kode_ajaran" value="" type="hidden"/>
		<input name="f_kode_prodi" value="" type="hidden"/>
	</form>
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<div class="row col-md-12">
			<div class="col-md-2" ><label>Masukkan NIM</label></div>
			<div class="col-md-4" ><form id="perwalian-frm-f"><input name="ctl_nim" type="text" value="<?php if(isset($_GET['nim'])){echo $_GET['nim'];} ?>" class="form-control input-sm" /></form></div>
			<div class="col-md-2" ><button type="button" class="btn btn-success btn-sm" onclick="perwalian_load();" >GO</button></div>
		</div>
	</nav>
	<nav id="nav-data-mahasiswa" class="navbar navbar-default" style="padding:10px; background:white;">
		<div class="row col-md-12">
			<div class="col-md-2" ><img src="<?php echo $BASE_URL; ?>/images/people.png" style="width:100%; height:200px; " /></div>
			<div class="col-md-4" >
				<div class="navbar navbar-default" style="min-height:0px; "><h5 class="text-center" style="font-weight:bold">DATA MAHASISWA</h5></div>
				<div class="data-mahasiswa" style="padding:5px; line-height:30px">
					<div class="row"><label class="col-md-5">NIM</label><label name="p_nim"></label></div>
					<div class="row"><span class="col-md-5">Nama</span><span name="p_nama"></span></div>
					<div class="row"><span class="col-md-5">Program Studi</span><span name="p_prodi"></span></div>
					<div class="row"><span class="col-md-5">Status</span><span name="p_status"></span></div>
				</div>
			</div>
			<div class="col-md-4" >
				<div class="navbar navbar-default" style="min-height:0px; "><h5 class="text-center" style="font-weight:bold">DATA PERWALIAN</h5></div>
				<div class="data-mahasiswa" style="padding:5px; line-height:30px">
					<div class="row"><label class="col-md-5">Semester</label><label name="p_smt"></label></div>
					<div class="row"><span class="col-md-5">Tahun Ajaran</span><span name="p_ajaran"></span></div>
					<div class="row"><span class="col-md-5">IPK</span><span name="p_ipk"></span></div>
					<div class="row"><span class="col-md-5">Maks. SKS</span><span name="p_totalsks"></span>&nbsp;SKS</div>
				</div>
			</div>
		</div>
	</nav>
	<nav id="nav-rencana-studi" class="navbar navbar-default" style="padding:10px; background:white;">
		<div class="box-body">				
			<h4 class="text-center">Rencana Studi</h4>	
			<div id="table-rencana-studi-parent" class="box-body table-responsive table-responsive-auto">
				<br/>
				<table id="table-rencana-studi" class="table table-bordered table-striped">
					<thead></thead>
					<tbody></tbody>
				</table>
				<!--<ul id = "pagination-rencana-studi" class="pagination"></ul>-->
			</div>
		</div>
	</nav>
	<nav id="nav-control" class="navbar navbar-default " style="padding:10px; background:white; text-align:right">
		<button type="button" class="btn btn-danger " style="width:100px">Batal</button>
		<button type="button" class="btn btn-success" onclick = "datasavecallback('#m_perwalian_frm', perwalian_callback)" style="width:100px">Simpan</button>
	</nav>
</div>

<script>
	var view_name = '<?php echo getTableAlias(1,'rencana_studi'); ?>'; var table_name = '#table-rencana-studi'; var pagination_name = '#pagination-rencana-studi';
	var semester_aktif = 0;
	$(document).ready(function(){
		reset_data();
		<?php
			if(isset($_GET['nim'])){
				echo 'perwalian_load();';
			}
		?>
	});
	
	function rencana_studi_load_data(){
		dataview(view_name, 1, rencana_studi_callback, '#rencana-studi-frm-f');
	}
	
	function rencana_studi_callback(data){
		var tb = '<table id="table-rencana-studi" class="table table-bordered table-striped">';
		tb    +=' <thead></thead><tbody></tbody></table>';
		$('#table-rencana-studi-parent').html(tb);
		
		/// Columns \\\
		var thead = '';
		$.each(data[0], function(key, arr){
			if(key != 'p_row' && key != 'prime' && key != 'none'){
				thead += '<td>'+key.toUpperCase()+'</td>';
			}
		});		
		
		thead = '<tr>'+thead+'<td></td></tr>'; $(table_name+' thead').html(thead);		
		
		/// Rows \\\
		var tbody = ''; var n = 0; var p_row = 0; var active_page = 0; var xxx = 0;
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
			xxx++;
			tbody += '<td>';
			if(array['smt'] == semester_aktif){tbody += '<input name="ctl_mk_'+xxx+'"type="checkbox"  value="'+array['prime']+'" checked="checked" />'; }
			else{tbody += '<input name="ctl_mk_'+xxx+'" value="'+array['prime']+'"  type="checkbox" />'; }
			tbody += '</td>';
			tbody += '</tr>';
		});
		
		$(table_name+' tbody').html(tbody);
		buildTableGroupHeader(table_name, 'Semester ', 1, '500px', '30px');
		
		tb = $('#table-rencana-studi-parent').html();
		var newTB  = '<form id="m_perwalian_frm" >';
			newTB += '<input type="hidden" name="name" value="<?php echo getTableAlias(1,'civitas_perwalian'); ?>" />';
			newTB += '<input type="hidden" name="ctl_total_mk" value="'+xxx+'" />';
			newTB += '<input type="hidden" name="ctl_nim" value="'+$('label[name="p_nim"]').html()+'" />';
			newTB += '<input type="hidden" name="ctl_semester" value="'+$('label[name="p_smt"]').html()+'" />';
			newTB += '<input type="hidden" name="ctl_kode_prodi" value="'+$('input[name="f_kode_prodi"]').val()+'" />';
			newTB += '<input type="hidden" name="ctl_kode_ajaran" value="'+$('input[name="f_kode_ajaran"]').val()+'" />';
			newTB += tb;
			newTB += '</form>';
		$('#table-rencana-studi-parent').html(newTB);
		//alert($('#table-rencana-studi-parent').html());
		
		$('#nav-control').show();
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
	
	function perwalian_load(){
		if($('input[name="ctl_nim"]').val() == ''){
			alert('Maaf, Silahkan isi NIM Anda');
			return false;
		}
		window.history.replaceState('', '', '?nim='+$('input[name="ctl_nim"]').val());
		dataview('perwalian', 1, perwalian_load_callback, '#perwalian-frm-f');
	}
	
	function perwalian_load_callback(data){
		var n = 0;
		$.each(data, function(index, array){			
			n++;
			$('input[name="f_kode_prodi"]').val(array['kode_p']);
			$('input[name="f_kode_ajaran"]').val(array['ajaran']);
			
			$('label[name="p_nim"]').html(array['nim']);
			$('span[name="p_nama"]').html(array['nama']);
			$('span[name="p_prodi"]').html(array['prodi']);
			$('span[name="p_status"]').html(array['status'].toUpperCase());
			
			$('label[name="p_smt"]').html(array['smt']);
			$('span[name="p_ajaran"]').html(array['tahun ajaran']);
			$('span[name="p_ipk"]').html(array['ipk']);
			$('span[name="p_totalsks"]').html(array['maks sks']);
			
			semester_aktif = array['smt'];
			
			if(array['tipe'] == 0){
				rencana_studi_load_data();
			}
			else{
				perwalian_list_data(data);
			}
			$('#nav-data-mahasiswa').show(); $('#nav-rencana-studi').show(); 
		});
		if(n <= 0){
			alert("Maaf, Data dengan NIM "+$('input[name="ctl_nim"]').val()+' tidak ditemukan.');
			reset_data();
		}
	}
	
	function perwalian_list_data(data){
		var tb = '<div align="center"><table id="table-rencana-studi" class="table table-bordered table-striped " style="width:600px">';
		tb    +=' <thead></thead><tbody></tbody></table></div>';
		$('#table-rencana-studi-parent').html(tb);
		
		/// Columns \\\
		var thead = '';
		$.each(data[0], function(key, arr){
			if(key.indexOf('list') >= 0){
				thead += '<td>'+key.replace('list ','').toUpperCase()+'</td>';
			}
		});		
		
		thead = '<tr><td style="width:30px">NO</td>'+thead+'<td></td></tr>'; $(table_name+' thead').html(thead);		
		
		/// Rows \\\
		var tbody = ''; var n = 0; var p_sks = 0;  var xxx = 0;
		$.each(data, function(index, array){
			n++; p_sks += parseInt(array['list sks']);
			tbody += '<tr><td>'+n+'</td>';
			$.each(data[0], function(key, arr){
				if(key.indexOf('list') >= 0){
					tbody += '<td><label name="'+key+'" value="'+array[key]+'">'+array[key]+'</label></td>';
				}
			});
			xxx++;
			tbody += '<td style="width:40px">';
			tbody += '<a href="javascript:void(0)" onclick="dataremovecallback(\'#remove_perwalian_'+n+'\', perwalian_load)" type="button" class="btn btn-danger btn-xs" style="width:25; margin-right:2px;"><span class="glyphicon glyphicon-remove"></span> Batal</a>';
			tbody += '<form id="remove_perwalian_'+n+'"><input type="hidden" name="name" value="<?php echo getTableAlias(1,'civitas_perwalian'); ?>"/>';
			tbody += '<input type="hidden" name="ctl_kode_perwalian" value="'+array['prime']+'" /></form>';
			tbody += '</td>';
			tbody += '</tr>';
		});
		tbody += '<tr><td colspan="2" align="right">Total</td><td>'+p_sks+'</td></tr>';
		$(table_name+' tbody').html(tbody);
		
	}
	
	function perwalian_callback(data){
		window.location.reload();
	}
	
	function reset_data(){
		$('input[name="f_kode_prodi"]').val('');
		$('input[name="f_kode_ajaran"]').val('');
		
		$('label[name="p_nim"]').html('');
		$('span[name="p_nama"]').html('');
		$('span[name="p_prodi"]').html('');
		$('span[name="p_status"]').html('');
		
		$('label[name="p_smt"]').html('');
		$('span[name="p_ajaran"]').html('');
		$('span[name="p_ipk"]').html('');
		$('span[name="p_totalsks"]').html('');
		
		var tb = '<table id="table-rencana-studi" class="table table-bordered table-striped">';
		tb    +=' <thead></thead><tbody></tbody></table>';
		$('#table-rencana-studi-parent').html(tb);
		$('#nav-data-mahasiswa').hide(); $('#nav-rencana-studi').hide(); $('#nav-control').hide();
	}
	
</script>





