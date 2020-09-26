
var view_name = ''; var table_name = ''; var pagination_name = ''; var this_data = []; var frm = '';

function get_grup(p_view_name, p_table_name, p_pagination_name, p_frm){
	view_name = p_view_name; table_name = p_table_name; pagination_name = p_pagination_name; frm = p_frm;
	grup_load();
}

function grup_load(){
	grup_clear();
	dataview(view_name, 1, grup_callback);
}

function grup_callback(data){
	this_data = data;
	$(table_name+' thead').html('');
	$(table_name+' tbody').html('');
	
	var thead = '';
	$.each(data[0], function(key, arr){
		if(key != 'p_row' && key != 'active' && key.indexOf("kode") < 0){
			thead += '<td>'+key.replace("_"," ").toUpperCase()+'</td>';
		}
	});		
	
	thead = '<tr>'+thead+'<td>ACTION</td></tr>'; $(table_name+' thead').html(thead);		
		
	var tbody = ''; var n = 0; var p_row = 0; var active_page = 0;
	$.each(data, function(index, array){
		$.each(data[0], function(key, arr){
			if(key != 'p_row'){
				if(key == 'no'){		
					if(n==0){n = array['no']; active_page = n; }else{n++;}
					tbody += '<tr row-number="'+n+'">';
					tbody += '<td><label>'+n+'</label></td>';
				}
				else if(key == 'active'){
					active_page = array[key];
				}
				else{
					if(key.indexOf("kode") < 0){
						tbody += '<td><label name="'+key+'" value="'+array[key]+'">'+array[key]+'</label></td>';
					}
				}
			}
			else{
				p_row = array[key];
			}
		});
		tbody += '<td style="width:80px">';
		if(frm.indexOf("daftarbuku") >= 0){
			tbody += '<a href="'+get_uri()+'?p='+array["kode katalog"]+'" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span> </a>';
			tbody += '<button type="button" onclick="grup_set('+(n-1)+'); dataremovecallback(frm, grup_load);" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> </button>';
		}
		else{
			tbody += '<button type="button" onclick="grup_set('+(n-1)+')" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span> </button>';
			tbody += '<button type="button" onclick="grup_set('+(n-1)+'); dataremovecallback(frm, grup_load);" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> </button>';
		}
		tbody += '</td>';
		tbody += '</tr>';
	});
	$(table_name+' tbody').html(tbody);
		
	var li = '';
	for(var i = 1; i <= p_row ;i++){
		if(i == active_page){
			li += '<li class="active"><a href="javascript:void(0)" onclick="dataview(view_name, '+i+', grup_callback);"  >'+i+'</a></li>';
		}
		else{
			li += '<li><a href="javascript:void(0)" onclick="dataview(view_name, '+i+', grup_callback);">'+i+'</a></li>';
		}
	}
	$(pagination_name).html(li);
}

function grup_set(n){	
	var data = this_data[n]; 
	
	$.each(data, function(index, array){
		$(frm+' input[column-name="'+index+'"]').val(data[index]);
	});
	$(frm+' .btn-success').html('Ubah');
}

function grup_save(){
	datasavecallback(frm, grup_load);
}

function grup_clear(){
	$(frm+' input[column-name]').val('');
	$(frm+' input[column-primary]').val('generatecode');
	$(frm+' .btn-success').html('Simpan');
}




