
<!-- Modal -->
<div id="formCari" class="modal fade" role="dialog" style="z-index:99999;">
  <div class="modal-dialog" style="width:1000px;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
	  <ul id = "pagination-cari" class="pagination"></ul>
	  <div id="table-cari-parent" class="box-body table-responsive" style="max-height:400px">
        <table id="table-cari" class="table table-bordered table-striped">
			<thead></thead>
			<tbody></tbody>
		</table>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="returnValue()">OK</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>

<script>
	var elReturn = '';
	var valReturn = ['abc'];
	var this_callback;
	var this_filterFrm;
	
	var cari_view;
	function showFormCari( el, view, title, callback, filterFrm){
		//alert(JSON.stringify($(filterFrm).find("select,textarea, input").serializeArray()));
		this_callback = callback; this_filterFrm = filterFrm;
		$('.modal-title').html("DATA "+title.toUpperCase());
		elReturn = el;
		$('#formCari').modal('show');
		
		cari_view = view;
		
		dataview(cari_view, 1, cari_callback, this_filterFrm);
	}
	
	function cari_callback(data){		
		$('#table-cari thead').html('');
		$('#table-cari tbody').html('');
		$('#pagination-cari').html('');
		
		/// Columns \\\
		var thead = '';
		$.each(data[0], function(key, arr){
			if(key != 'p_row' && key != 'active' && key != 'selected'){
				thead += '<td>'+key.toUpperCase()+'</td>';
			}
		});		
		
		thead = '<tr><td></td>'+thead+'</tr>'; $('#table-cari thead').html(thead);		
		
		/// Rows \\\
		var tbody = ''; var n = 0; var p_row = 0; var active_page = 0;
		$.each(data, function(index, array){
			var trow = ''; var isSelected = true;
			$.each(data[0], function(key, arr){
				if(key != 'p_row' && key != 'selected'){
					if(key == 'no'){		
						if(n==0){n = array['no'];  }else{n++;}
						trow += '<tr row-number="'+n+'">actioncolumn';
						trow += '<td><label>'+n+'</label></td>';
					}
					else if(key == 'active'){
						active_page = array[key];
					}
					else{
						trow += '<td><label name="'+key.replace(/ /g,'_')+'" value="'+array[key]+'">'+array[key].toUpperCase()+'</label></td>';
					}
				}
				else if(key == 'selected'){
					if(array["selected"] == 0){
						isSelected = false;
					}
				}
				else{
					p_row = array[key];
				}
			});
			var tdAction = '';
			tdAction += '<td style="width:60px">';
			if(isSelected){
				tdAction += '<button type="button" class="btn btn-info btn-xs"  onclick="returnValue('+n+')">Select</button>';
			}
			tdAction += '</td>';
			
			trow  = trow.replace('actioncolumn',tdAction);
			
			tbody += trow+'</tr>';
		});
		
		$('#table-cari tbody').html(tbody);
		
		/// Paging \\\
		var li = '';
		for(var i = 1; i <= p_row ;i++){
			if(i == active_page){
				li += '<li class="active"><a href="javascript:void(0)" onclick="dataview(cari_view, '+i+', cari_callback);" >'+i+'</a></li>';
			}
			else{
				li += '<li><a href="javascript:void(0)" onclick="dataview(cari_view, '+i+', cari_callback, this_filterFrm);">'+i+'</a></li>';
			}
		}
		$('#pagination-cari').html(li);
	}
	
	function returnValue(index){
		$(elReturn+' .control-return').each(function(i, v) {
			try{
				$name = $(this).attr("data-return").toLowerCase();
				$(this).val($("#table-cari tr[row-number="+index+"] label[name="+$name+"]").attr("value"));
			}
			catch(e){
				alert(e.message);
			}
		});
		hideFormCari();
	}
	
	function hideFormCari(){
		$('#formCari').modal('hide');
		this_callback();
	}
	
</script>

<style>
	table label{font-weight:normal;}
</style>