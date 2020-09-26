

$(document).ready(function(){
	$('.affix').width($('.affix').parent('div').width()*0.9);
	$('button[data-rel=back]').click(function(){
		history_back_referrer();
	});
	
	$('.timepicker-disabled').timepicker({
		showMeridian:false,
		template:false
	});	
	
	$('.timepicker').timepicker({
		showMeridian:false,
		minuteStep:5
	});	
	
	$('.datepicker .btn').click(function(){
		$(this).prev().focus();
		$(this).prev().focus();
		
	});
	$('.datepicker input').datepicker({format: "dd/mm/yyyy"})
	.on('changeDate', function(ev){
		$(this).datepicker('hide');
	});
	$('form').on('submit',function(e){
		e.preventDefault();
	});
	
	
});

function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function requestFullScreen() {
	
	var element=document.documentElement;
	if(element.requestFullScreen) {
	element.requestFullScreen();
	} else if(element.mozRequestFullScreen) {
	element.mozRequestFullScreen();
	} else if(element.webkitRequestFullScreen) {
	element.webkitRequestFullScreen();
	}
}

function buildTableGroupHeader(el, header_text, groupIndex, table_width, action_column_width){
	var parent		= $(el).closest('.table-responsive');
	
	var columnCount = 0;
	var groupHeader	= [];
	var tables		= [];
	var headerTable	= '';
			
	$(el).find('> thead > tr').each(function () {
		var index = 0;
		$(el).find('> thead > tr > td').each(function () {
			if(index != groupIndex){
				headerTable += '<td>'+$(this).html()+'</td>';
			}
			columnCount++;
			index++;
		});
	});
	
	var lastGroup = '';  var isFirst = true; var newRow = '';
	
	$(el).find('> tbody > tr ').each(function () {
		var group = $(this).find("td:eq("+groupIndex+")").find('> label').html();
		if(group != groupHeader[groupHeader.length-1]){
			groupHeader.push(group);
		}
	});
	
	for(var i = 0; i < groupHeader.length; i++){
		var rows = ''; var rowIndex = 0;
		$(el).find('> tbody > tr ').each(function () {
			var group = $(this).find("td:eq("+groupIndex+")").find('> label').html();
			
			if(group == groupHeader[i]){
				var index = 0; var column = '';
				$(this).find('> td').each(function () {
					if(index != groupIndex){
						var val = $(this).html();
						if(index == 0){rowIndex++; val = rowIndex;column+='<td style="width:40px"><label>'+val+'</label></td>';}
						else if(index == columnCount-1){column+='<td style="width:'+action_column_width+'"><label>'+val+'</label></td>';}
						else{column+='<td><label>'+val+'</label></td>';}
					}
					index++;
				});
				rows += '<tr>'+column+'</tr>';
			}
		});
		if(rows != ''){
			tables.push(rows);
		}
	}
	var abc = '';
	
	for(var i = 0; i < groupHeader.length; i++){
		abc += '<label style="width:'+table_width+'; margin-right:20px; vertical-align:top"><table class="table table-bordered table-striped">';
		abc += '<thead><tr><td style="border-bottom:1px solid #EEEEEE !important" colspan="'+columnCount+'"><strong style="font-size:14px"> '+header_text+groupHeader[i]+'</strong></td></tr></thead>';
		abc += '<thead><tr>'+headerTable+'</tr></thead><tbody>'+tables[i]+'</tbody>';
		abc += '</table></label>';
	}
	abc = '<div class="form-inline">'+abc+'</div>';
	
	$(parent).html('<br/>'+abc);
	
}

function build_table_header_fix(el){
	try{
		$(el).find('> tbody ').prepend($(el).find('> thead ').html());
		
	//return false;
	for(var i = 1; i <= 3; i++){
		
		$(el).find('> tbody > tr:first-child ').each(function () {
			var index = 0;
			$(this).find('> td').each(function () {
				if(i==0){
					$(el).find("> thead > tr > td:eq("+index+")").width($(this).width());
					//alert($(el).find("> thead > tr > td:eq("+index+")").width()+''+$(this).width());
				}
				else{
					var tHeadWidth	= $(el).find("> thead > tr:first-child > td:eq("+index+")").width();
					var tBodyWidth	= $(this).width();
					//alert(parseInt(tHeadWidth.replace('px','')) +' : '+ parseInt(tBodyWidth.replace('px',''))); 
					//alert(tHeadWidth + ' : '+tBodyWidth);
					if(tHeadWidth > tBodyWidth){
						//$(this).width(tHeadWidth);
						
					}
					else{
						//$(el).find("> thead > tr > td:eq("+index+")").width(tBodyWidth);
					}
					$(el).find("> thead > tr > td:eq("+index+")").width(tBodyWidth);
				}
				
				//alert($(this).outerWidth() + ' : ' + $(el).find("> thead > tr > td:eq("+index+")").css('width'));
				
				index++;
				//alert($(this).width());
			});
		});
		$(el).find('> thead ').width($(el).find('> tbody ').width());
		
	}
	}
	catch(e){
		alert(e);
	}
}







