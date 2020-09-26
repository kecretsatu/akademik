
<div class="container">
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<div class="form-group">
			<div class="col-xs-10">
				<div class="form-inline">
					<div class="form-group">
						<label>Jenjang</label>
						<select class="form-control">
							<option>S1</option>
							<option>D3</option>
						</select>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-success btn-sm">GO</button>
					</div>
				</div>
			</div>
		</div>
	</nav>
	
	<nav class="navbar navbar-default" style="padding:10px; background:white;">
		<h4 class="text-center">Data Kelas</h4>	
		<a class="btn btn-primary btn-sm" href="<?php echo $REQUEST_URI; ?>/tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
		<br/><br/>
		<div class="box-body table-responsive">
			<table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>MULAI</th>
						<th>SELESAI</th>
						<th>ACTION</th>
					</tr>
				</thead>
				<tbody>
					<?php for($i = 1; $i <= 10; $i++){ ?>
					<tr>
						<td><?php echo $i; ?></td>
						<td>A</td>
						<td>AKTIF</td>
						<td style="width:150px">
							<button type="button" class="btn btn-info btn-xs">View</button>
							<button type="button" class="btn btn-primary btn-xs">Edit</button>
							<button type="button" class="btn btn-danger btn-xs">Delete</button>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		
	</nav>
	
</div>