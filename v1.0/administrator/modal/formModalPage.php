
<!-- Modal -->
<div id="formPage" class="modal fade" role="dialog" style="z-index:99999;">
  <div class="modal-dialog" style="width:1000px;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
      </div>
    </div>

  </div>
</div>

<script>
	function show_form_page(url, page){
		$('#formPage .modal-body').load(url+' '+page, function(){
			$('#formPage .modal-body '+page).css("width", "100%");
			$('#formPage .modal-body button[dialog-mode="remove"]').remove();
		});
		$('#formPage').modal('show');
	}
	
	function dialog_page_callback(){
		$('#formPage').modal('hide');
	}
	
</script>
