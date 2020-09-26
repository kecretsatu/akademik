<div id="container" class="header-page">
		<nav class="navbar navbar-default" >
			<div class="row header">
				<div class="col-md-2">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed btn-primary" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="<?php echo $BASE_URL; ?>">SIMAMIK</a>
					</div>
				</div>
				<div class="col-md-7">
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">							
						<ul class="nav navbar-nav navbar-left">
							<li><a href="<?php echo $BASE_URL; ?>/dashboard">Dashboard</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Master <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo $BASE_URL; ?>/master/dosen">Data Dosen</a></li>
									<li class="divider"></li>
									<li><a href="<?php echo $BASE_URL; ?>/master/mahasiswa">Data Mahasiswa</a></li>
									<li class="divider"></li>
									<li><a href="#">Data Staff</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">TA Baru <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo $BASE_URL; ?>/akademik/jadwalkuliah">Buka Tahun Ajaran Baru</a></li>
									<li><a href="#">Penerimaan Mahasiswa Baru</a></li>
									<li class="divider"></li>
									<li><a href="<?php echo $BASE_URL; ?>/akademik/rencanastudi">Rencana Studi</a></li>
									<li><a href="<?php echo $BASE_URL; ?>/akademik/jadwalperwalian">Jadwal Perwalian</a></li>
									<li><a href="<?php echo $BASE_URL; ?>/akademik/perwalian">Perwalian</a></li>
									<li><a href="<?php echo $BASE_URL; ?>/akademik/perwaliankolektif">Perwalian Kolektif</a></li>
									<li class="divider"></li>
									<li><a href="<?php echo $BASE_URL; ?>/akademik/jadwalkelasotomatis">Kelas / Jadwal Otomatis</a></li>
									<li><a href="<?php echo $BASE_URL; ?>/akademik/kelas">Pembagian Kelas</a></li>
									<li><a href="<?php echo $BASE_URL; ?>/akademik/penjadwalankuliah">Penjadwalan Kuliah</a></li>
									<li><a href="<?php echo $BASE_URL; ?>/akademik/jadwalkuliah">Jadwal Kuliah</a></li>
									<li class="divider"></li>
									<li><a href="#">Kalender Akademik</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Akademik <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo $BASE_URL; ?>/akademik/absensi">Pencatatan Absensi</a></li>
									<li><a href="<?php echo $BASE_URL; ?>/akademik/nilai">Pencatatan Nilai</a></li>
									<li><a href="#">Tugas Akhir / Skripsi</a></li>
									<li class="divider"></li>
									<li><a href="#">Aktivitas Mahasiswa</a></li>
									<li><a href="#">Aktivitas Dosen</a></li>
									<li class="divider"></li>
									<li><a href="#">Wisuda</a></li>
									<li class="divider"></li>
									<li><a href="#">Transkrip Nilai</a></li>
									<li><a href="#">Ijazah</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Keuangan <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo $BASE_URL; ?>/keuangan/jenisanggaran">Jenis Keuangan</a></li>
									<li><a href="<?php echo $BASE_URL; ?>/keuangan/nilaikeuangan">Nilai Keuangan</a></li>
									<li class="divider"></li>
									<li><a href="#">Pencatatan Pembayaran</a></li>
									<li><a href="#">Pencatatan Pembayaran Lain - Lain</a></li>
									<li class="divider"></li>
									<li><a href="#">Laporan Pembayaran</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Referensi <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo $BASE_URL; ?>/referensi/profilpt">Profil Perguruan Tinggi</a></li>
									<li class="divider"></li>
									<li><a href="<?php echo $BASE_URL; ?>/referensi/fakultas">Fakultas</a></li>
									<li><a href="<?php echo $BASE_URL; ?>/referensi/jurusan">Jurusan</a></li>
									<li><a href="<?php echo $BASE_URL; ?>/referensi/programstudi">Program Studi</a></li>
									<li class="divider"></li>
									<li><a href="<?php echo $BASE_URL; ?>/referensi/jenismatakuliah">Jenis Mata Kuliah</a></li>
									<li><a href="<?php echo $BASE_URL; ?>/referensi/matakuliah">Mata Kuliah</a></li>
									<li class="divider"></li>
									<li><a href="<?php echo $BASE_URL; ?>/referensi/ruang">Ruang</a></li>
									<li><a href="<?php echo $BASE_URL; ?>/referensi/waktusks">Waktu per SKS</a></li>
									<li class="divider"></li>
									<li><a href="<?php echo $BASE_URL; ?>/referensi/konversinilai">Konversi Nilai</a></li>
									<li><a href="<?php echo $BASE_URL; ?>/referensi/bobotnilai">Bobot Nilai</a></li>
									<li class="divider"></li>
									<li><a href="<?php echo $BASE_URL; ?>/referensi/perpustakaan">Perpustakaan</a></li>
									<li class="divider"></li>
									<li><a href="#">Jabatan</a></li>
									<li><a href="#">Hak Akses</a></li>
									<li class="divider"></li>
									<li><a href="#">Pelaporan EPSBED</a></li>
								</ul>
							</li>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div>
				<div class="col-md-3">
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">							
						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									<span class="glyphicon glyphicon-user"></span> &nbsp;Administrator <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="#">Ubah Password</a></li>
									<li><a href="#">Keluar</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
	</div>	