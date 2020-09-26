
<?php
	$waktu = execqueryreturn("waktu_per_sks","select waktu from waktu_per_sks where id = 1");
	if(!$waktu){
		$waktu = 0;
	}
?>

<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<div class="form-inline">
			<form id="m_waktusks">
				<input type="hidden" name="name" value="<?php echo getTableAlias(1,'waktu_per_sks'); ?>" />
				<input type="hidden" name="ctl_id" value="1" />
				<label style="width:150px">Waktu Per SKS</label>
				<input type="number" name="ctl_waktu" class="form-control input-sm" value="<?php echo $waktu; ?>" style="width:80px" />
				<label/>Menit</label>
			</form>
		</div>
		<div class="form-inline" style="margin-top:10px">
			<label style="width:150px">&nbsp;</label>
			<button type="button" class="btn btn-success btn-sm" onclick="datasavecallback('#m_waktusks', waktuskscallback)" style="width:80px;">Simpan</button>
		</div>
	</nav>
</div>

<script>
	function waktuskscallback(data){
		data = data[0];
		if(data['state'] == 1){
		  alert('Data berhasil disimpan. '+data['msg']);
		}
		else{
		  alert('Data gagal disimpan, err : '+data['msg']);
		}
	}
</script>