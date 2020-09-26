
$(document).ready(function(){
	//perwalian_kolektif_load();
});

function penjadwalan_kolektif_save(){
	var v = confirm("Jadwal lama akan terhapus untuk dibentuk jadwal baru. Apakah anda yakin ingin membentuk jadwal otomatis ?");
	
	if(v == false){
		return false;
	}
	try{
		var data		= [];
		var filterFrm	= '#m_jadwal_c_frm';
		
		$('#btn-simpan').attr("disabled", "disabled");
		$('#status-saving').show();
		if(filterFrm){
			data = $(filterFrm).find("select,textarea, input").serializeArray();
		}
		data.push({ name: "name", value: "post" });
		
		$.ajax({
		  method: "POST",
		  url: "../modul/jadwal_kolektif.php",
		  dataType: "json",
		  data: data,
		  success: penjadwalan_kolektif_callback
		});
	}
	catch(e){
		alert(e);
	}
}

function penjadwalan_kolektif_callback(result){
	var data = result[0];
	if(data['state'] == 1){
		alert("Sukses, Penjadwalan berhasil dibentuk.");
		navigate_to_penjadwalan();
	}
	else{
		alert("Gagal, "+data['msg']);
	}
}





