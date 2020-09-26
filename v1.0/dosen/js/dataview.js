

function dataview(name, startrow, callback, filterFrm){
	var data = [];
	
	if(filterFrm){
		data = $(filterFrm).find("select,textarea, input").serializeArray();
		data.push({ name: "filter", value: 1 });
	}
	data.push({ name: "name", value: name });
	data.push({ name: "startrow", value: startrow });
	
	$.ajax({
	  method: "POST",
	  url: JS_URL+"modul/view.php",
	  dataType: "json",
	  data: data,
	  success: callback
	});
}

function dataviewfilter(name, startrow, callback, frm){
	var data = $(frm).serializeArray();
	data.push({ name: "name", value: name });
	data.push({ name: "startrow", value: startrow });
	$.ajax({
	  method: "POST",
	  url: JS_URL+"modul/view.php",
	  dataType: "json",
	  data: data,
	  success: callback
	});
}

function setParamsURL(frm){
	var str		= '';
	var data 	= $(frm).serializeArray();
	
	$.each(data, function(index, array){
		str += array["name"] + '=' + array["value"]+'&';
	});
	str = str.substring(0, str.length-1)
	return str;
}

