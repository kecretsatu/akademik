

$(document).ready(function(){
	//perwalian_kolektif_load();
});

function perwalian_kolektif_load(){
	$('#btn-simpan').attr("disabled", "disabled");
	try{
		var data		= [];
		var filterFrm	= '#m_mahasiswa_c_frm';
		
		if(filterFrm){
			data = $(filterFrm).find("select,textarea, input").serializeArray();
		}
		data.push({ name: "name", value: "get" });
		
		$.ajax({
		  method: "POST",
		  url: "../modul/p_kolektif.php",
		  dataType: "json",
		  data: data,
		  success: perwalian_kolektif_callback
		});
	}
	catch(e){
		alert(e);
	}
}

function perwalian_kolektif_callback(data){
	var table_name = '#table-mahasiswa';
	
	$(table_name+' thead').html('');
	$(table_name+' tbody').html('');
	
	var thead = '';
	$.each(data[0], function(key, arr){
		if(key != 'p_row'){
			thead += '<td>'+key.toUpperCase()+'</td>';
		}
	});		
	
	thead = '<tr><td style="width:40px"><input id="pilih_all" onchange="perwalian_kolektif_check_all()" type="checkbox" /></td>'+thead+'<td>ACTION</td></tr>'; $(table_name+' thead').html(thead);		
	
	var tbody = ''; var n = 0; var p_row = 0; var active_page = 0;
	$.each(data, function(index, array){
		$.each(data[0], function(key, arr){
			if(key != 'p_row'){
				if(key == 'no'){		
					if(n==0){n = array['no']; active_page = n; }else{n++;}
					tbody += '<tr row-number="'+n+'"><td><input id="pilih_'+n+'" type="checkbox" value="1" /></td>';
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
		tbody += '<td>';
		tbody += '<input type="hidden" name="ctl_nim_'+n+'" value="'+array["nim"]+'" />';
		tbody += '<label id="status_'+n+'"></label></td>';
		tbody += '</tr>';
		
		$('#btn-simpan').removeAttr("disabled");
	});
	total_row = n;
	$(table_name+' tbody').html(tbody);
	
}

var total_row = 0; var current_row = 0;

function perwalian_kolektif_save(){
	try{
		current_row++;
		$('#btn-simpan').attr("disabled", "disabled");
		if(current_row <= total_row){
			if( $('#pilih_'+current_row).length <= 0 ){
				perwalian_kolektif_save();
				return false;
			}
			if (!$('#pilih_'+current_row).is(':checked')) {
				$('#status_'+current_row).html('Tidak Tersimpan');
				perwalian_kolektif_save();
				return false;
			}
			
			var data		= [];
			var filterFrm	= '#m_mahasiswa_c_frm';
			
			if(filterFrm){
				data = $(filterFrm).find("select,textarea, input").serializeArray();
			}
			data.push({ name: "ctl_nim", value: $('input[name="ctl_nim_'+current_row+'"').val() });
			data.push({ name: "name", value: "post" });
			
			$.ajax({
			  method: "POST",
			  url: "../modul/p_kolektif.php",
			  dataType: "json",
			  data: data,
			  success: perwalian_kolektif_save_callback
			});
		}
		else{
			current_row = 0;
			$('#btn-simpan').removeAttr("disabled");
		}
	}
	catch(e){
		alert(e);
	}
}

function perwalian_kolektif_save_callback(result){
	var data = result[0];
	if(data['state'] == 1){
		$('#pilih_'+current_row).remove();
		$('#status_'+current_row).html('Tersimpan');
	}
	else{
		$('#status_'+current_row).html('Gagal, err: '+data['msg']);
	}
	perwalian_kolektif_save();
}

function perwalian_kolektif_check_all(){
	$('input[type="checkbox"]').prop('checked', $('#pilih_all').is(':checked'));
}








