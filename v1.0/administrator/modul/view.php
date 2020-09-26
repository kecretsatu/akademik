<?php
	header('Content-type: application/json');

	include ('koneksi.php');
	$con=koneksi();
	$result;
	$query = '';
	if(isset($_POST['name'])){
		$name = $_POST['name'];
		if ($name=="dosen"){
			$name = "dosen_biodata";
			$endrow		= 10;
			$startrow	= ($_POST["startrow"] - 1) * $endrow;
			
			$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
			$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
				upper(nidn) as 'nidn', 
				upper(concat(gelar_depan, ' ', nama_dosen, ', ', gelar_belakang)) as 'nama',
				upper(jenis_kelamin) as 'l/p', upper('S3 Manajemen') as 'jenjang terakhir', upper('Aktif') as 'status'
				from ".$name." limit ".$startrow.", ".$endrow."";
		}
		elseif ($name=="mahasiswa"){
			$name = "mahasiswa_biodata";
			$endrow		= 10;
			$startrow	= ($_POST["startrow"] - 1) * $endrow;
			$indexrow	= $startrow+1;
			
			$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name."  where nim in ( select nim from civitas_mahasiswa ".addFilterCondition("civitas_mahasiswa", "", true).") ") / $endrow);
			$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $indexrow)."' as 'no', 
				'".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'active', 
				upper(nim) as 'nim', 
				upper(nama_mahasiswa) as 'nama',
				upper(jenis_kelamin) as 'l/p', upper('2014') as 'thn masuk', upper('S1 Sistem Informasi') as 'program studi',
				upper('aktif') as 'status'
				from ".$name." where nim in ( select nim from civitas_mahasiswa ".addFilterCondition("civitas_mahasiswa", "", true).") limit ".$startrow.", ".$endrow."";
		}
		elseif ($name=="prodi"){
			$name = "prodi_identitas";
			$endrow		= 10;
			$startrow	= ($_POST["startrow"] - 1) * $endrow;
			
			$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
			$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
				(select upper(nama_jurusan) from jurusan where kode_jurusan =  p.kode_jurusan) as 'jurusan',
				upper(p.kode_prodi) as 'kode prodi', 
				upper(p.nama_prodi) as 'nama prodi',
				upper(p.jenjang) as 'jenjang', upper(concat(p.gelar,' (',p.singkatan_gelar,')')) as 'gelar',
				upper(p.sks_lulus) as 'sks',
				upper(p.tanggal_berdiri) as 'tgl berdiri',
				upper(p.status) as 'status'
				from ".$name." p limit ".$startrow.", ".$endrow."";
		}
		elseif ($name=="perwalian"){
				$nim		= $_POST['ctl_nim'];
				$endrow		= 10;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				
				$ajaran		= execqueryreturn("tahun_ajaran", "select kode_ajaran from tahun_ajaran where status = 1 ");
				$smt_aktif	= execqueryreturn("civitas_mahasiswa", "select semester_aktif from civitas_mahasiswa where nim = '".$nim."' ");
				$jml		= execqueryreturn("civitas_perwalian", "select count(*) from civitas_perwalian where nim = '".$nim."' 
								and kode_ajaran = '".$ajaran."' and semester = ".$smt_aktif." ");
				
				if($jml > 0){					
					$query		= "SELECT cp.kode_perwalian as 'prime', m.nim, m.nama_mahasiswa as 'nama', p.kode_prodi as 'kode_p', concat(p.jenjang,' ', p.nama_prodi) as 'prodi', 
									c.semester_aktif as 'smt', c.status_mahasiswa as 'status', 
									t.kode_ajaran as 'ajaran', concat(t.tahun,' ', t.semester) as 'tahun ajaran', '18' as 'maks sks', '0.00' as 'ipk',
									  cp.kode_rencana_studi, mk.nama_mk as 'list nama mata kuliah', mk.sks as 'list sks',
									'1' as 'tipe' 
									FROM  mahasiswa_biodata m, civitas_mahasiswa c, prodi_identitas p, tahun_ajaran t
									, civitas_perwalian cp, mata_kuliah mk
									where m.nim = c.nim and m.nim = '".$nim."' and c.kode_prodi = p.kode_prodi and t.status = 1
									and cp.nim = m.nim and cp.kode_prodi = p.kode_prodi and cp.kode_ajaran = t.kode_ajaran  and cp.semester = c.semester_aktif 
									and mk.kode_mk = (select kode_mk from rencana_studi where kode_rencana_studi = cp.kode_rencana_studi)";
				}
				else{
					$query		= "SELECT m.nim, m.nama_mahasiswa as 'nama', p.kode_prodi as 'kode_p', concat(p.jenjang,' ', p.nama_prodi) as 'prodi', 
									c.semester_aktif as 'smt', c.status_mahasiswa as 'status', 
									t.kode_ajaran as 'ajaran', concat(t.tahun,' ', t.semester) as 'tahun ajaran', '18' as 'maks sks', '0.00' as 'ipk',
									'0' as 'tipe' 
									FROM  mahasiswa_biodata m, civitas_mahasiswa c, prodi_identitas p, tahun_ajaran t
									where m.nim = c.nim and m.nim = '".$nim."' and c.kode_prodi = p.kode_prodi and t.status = 1";
				}
			}
		elseif($name == 'penjadwalan_matkul'){
			$name 		= 'mata_kuliah';
			$endrow		= 10;
			$startrow	= ($_POST["startrow"] - 1) * $endrow;
			$indexrow	= $startrow+1;
						
			$ajaran_aktif = execqueryreturn("tahun_ajaran", "select kode_ajaran from tahun_ajaran where status = 1");
			if(isset($_POST["f_tahun_ajaran"])){$ajaran_aktif = $_POST["f_tahun_ajaran"];}
			
			$kode_prodi	= "";
			if(isset($_POST["ctl_kode_prodi"])){$kode_prodi = $_POST["ctl_kode_prodi"];}
			if(isset($_POST["f_kode_prodi"])){$kode_prodi = $_POST["f_kode_prodi"];}
			
			$datapaging = ceil(execqueryreturn($name,"select count(*) from ".$name." where kode_mk in (select kode_mk from rencana_studi where kode_rencana_studi in ( select kode_rencana_studi 
						from civitas_perwalian where kode_ajaran = '".$ajaran_aktif."' 
						and kode_prodi = '".$kode_prodi."' ) ) ") / $endrow);
				
			$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $indexrow)."' as 'no', 
				'".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'active', 
				upper(m.kode_mk) as 'kode mk', 
				upper(m.nama_mk) as 'nama mk', 
				upper(m.sks) as 'sks', 
				(select upper(nama_item) from lookup_item where kode_item = m.kode_pilihan ) as 'wajib / pilihan', 
				upper(m.status) as 'status',
				(select count(*) from mata_kuliah_dosen where kode_mk = m.kode_mk ) as 'dosen'
				from ".$name." m where m.kode_mk in (select kode_mk from rencana_studi where kode_rencana_studi in ( select kode_rencana_studi 
						from civitas_perwalian where kode_ajaran = '".$ajaran_aktif."' 
						and kode_prodi = '".$kode_prodi."' )) limit ".$startrow.", ".$endrow."";
			
		}
		elseif($name == 'penjadwalan_dosen'){
			$name = "dosen_biodata";
			$endrow		= 10;
			$startrow	= ($_POST["startrow"] - 1) * $endrow;
			
			$datapaging = ceil(execqueryreturn($name,"select count(*) from ".$name." where nidn in (select nidn from mata_kuliah_dosen where kode_mk = '".$_POST["ctl_kode_mk"]."')") / $endrow);
			
			$mulai		= $_POST["ctl_mulai"]; $selesai = $_POST["ctl_selesai"]; $hari = $_POST["ctl_hari"];
			$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
				upper(d.nidn) as 'nidn', 
				upper(concat(d.gelar_depan, ' ', d.nama_dosen, ', ', d.gelar_belakang)) as 'nama',
				upper(d.jenis_kelamin) as 'l/p', upper('S3 Manajemen') as 'jenjang terakhir',
				ifnull((select concat(DATE_FORMAT(mulai, '%H:%i'), ' - ', DATE_FORMAT(selesai, '%H:%i')) from jadwal_kuliah 
							where nidn = d.nidn and hari = '".$hari."' and 
							(('".$mulai."' >= mulai and '".$mulai."' <= selesai) or ('".$selesai."' >= mulai and '".$selesai."' <= selesai)) ),'Tersedia') as 'status',
				ifnull((select 0 from jadwal_kuliah 
							where nidn = d.nidn and hari = '".$hari."' and 
							(('".$mulai."' >= mulai and '".$mulai."' <= selesai) or ('".$selesai."' >= mulai and '".$selesai."' <= selesai))), 1 ) as 'selected'
				from ".$name."  d where d.nidn in (select nidn from mata_kuliah_dosen where kode_mk = '".$_POST["ctl_kode_mk"]."') limit ".$startrow.", ".$endrow."";
				writeFile('test.txt',$query);
		}
		elseif($name == 'penjadwalan_ruang'){
			$name		= 'ruang';
			$endrow		= 100;
			$startrow	= ($_POST["startrow"] - 1) * $endrow;
			
			$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
			
			$mulai		= $_POST["ctl_mulai"]; $selesai = $_POST["ctl_selesai"]; $hari = $_POST["ctl_hari"];
			$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
				upper(r.kode_ruang) as 'ruang', 
				upper(r.kapasitas_kuliah) as 'kapasitas',
				upper(r.kapasitas_UJIAN) as 'kapasitas ujian',
				ifnull((select concat(DATE_FORMAT(min(mulai), '%H:%i'), ' - ', DATE_FORMAT(max(selesai), '%H:%i')) from jadwal_kuliah 
							where kode_ruang = r.kode_ruang and hari = '".$hari."' and 
							(('".$mulai."' >= mulai and '".$mulai."' <= selesai) or ('".$selesai."' >= mulai and '".$selesai."' <= selesai)) ),'Tersedia') as 'status',
				ifnull((select min(mulai)*0 from jadwal_kuliah 
							where kode_ruang = r.kode_ruang and hari = '".$hari."' and 
							(('".$mulai."' >= mulai and '".$mulai."' <= selesai) or ('".$selesai."' >= mulai and '".$selesai."' <= selesai))), 1 ) as 'selected'
				from ".$name." r  limit ".$startrow.", ".$endrow."";
				writeFile("test.txt", $query);
		}
		elseif($name == 'penjadwalan_kelas'){
			$name		= 'kelas';
			$endrow		= 10;
			$startrow	= ($_POST["startrow"] - 1) * $endrow;
			$indexrow	= $startrow+1;
			
			$ajaran_aktif = execqueryreturn("tahun_ajaran", "select kode_ajaran from tahun_ajaran where status = 1");
			
			$datapaging = ceil(execqueryreturn($name,"select count(*) from ".$name." where kode_ajaran = '".$ajaran_aktif."' and kode_prodi = '".$_POST["ctl_kode_prodi"]."' 
				and kode_mk = '".$_POST["ctl_kode_mk"]."'") / $endrow);
			
			$kode_rs	=  execqueryreturn("rencana_studi", "select kode_rencana_studi from rencana_studi where kode_ajaran = '".$ajaran_aktif."' 
							and kode_prodi = '".$_POST["ctl_kode_prodi"]."' and kode_mk = '".$_POST["ctl_kode_mk"]."' ");
			
			$mulai		= $_POST["ctl_mulai"]; $selesai = $_POST["ctl_selesai"]; $hari = $_POST["ctl_hari"];
			$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $indexrow)."' as 'no', 
				upper(k.kode_kelas) as 'kode kelas', 
				(select upper(nama_mk) from mata_kuliah where kode_mk = k.kode_mk) as 'mata kuliah',
				upper(k.nama_kelas) as 'kelas', 
				(select count(*) from civitas_perwalian where kode_kelas = k.kode_kelas) as 'peserta',
				ifnull((select concat(DATE_FORMAT(mulai, '%H:%i'), ' - ', DATE_FORMAT(selesai, '%H:%i')) from jadwal_kuliah 
							where kode_kelas = k.kode_kelas and hari = '".$hari."' and 
							(('".$mulai."' >= mulai and '".$mulai."' <= selesai) or ('".$selesai."' >= mulai and '".$selesai."' <= selesai)) ),'Belum Terjadwal') as 'status',
				ifnull((select 0 from jadwal_kuliah 
							where kode_kelas = k.kode_kelas and hari = '".$hari."' and 
							(('".$mulai."' >= mulai and '".$mulai."' <= selesai) or ('".$selesai."' >= mulai and '".$selesai."' <= selesai))), 1 ) as 'selected'
				from ".$name." k where k.kode_ajaran = '".$ajaran_aktif."' and k.kode_prodi = '".$_POST["ctl_kode_prodi"]."' 
				and k.kode_mk = '".$_POST["ctl_kode_mk"]."' limit ".$startrow.", ".$endrow."";
		}
		elseif($name == 'mahasiswa_absensi'){
			$ajaran_aktif	= $_POST["f_kode_ajaran"];
			$kode_prodi		= $_POST["f_kode_prodi"];
			$kode_matkul	= $_POST["f_mata_kuliah"];
			$tanggal		= $_POST["tanggal"];
			
			$query			= "SELECT '1' as 'no',  c.nim, (select upper(nama_mahasiswa) from mahasiswa_biodata where nim = c.nim) as 'nama', 
								( select kehadiran from civitas_absensi where kode_ajaran = c.kode_ajaran and kode_prodi = c.kode_prodi
								and nim = c.nim and kode_mk = r.kode_mk and tanggal_absensi = '".$tanggal."' ) as 'absensi'
								FROM civitas_perwalian c, rencana_studi r
								WHERE c.kode_ajaran = '".$ajaran_aktif."' and c.kode_prodi = '".$kode_prodi."' 
								and c.kode_ajaran = r.kode_ajaran and c.kode_prodi = r.kode_prodi and c.kode_rencana_studi = r.kode_rencana_studi
								and r.kode_mk = '".$kode_matkul."' ";
		}
		elseif($name == 'mahasiswa_nilai'){
			$ajaran_aktif	= $_POST["f_kode_ajaran"];
			$kode_prodi		= $_POST["f_kode_prodi"];
			$kode_matkul	= $_POST["f_mata_kuliah"];
			$query			= "SELECT '1' as 'no',  c.nim, (select upper(nama_mahasiswa) from mahasiswa_biodata where nim = c.nim) as 'nama', 
								ifnull(( select nilai from civitas_nilai where kode_ajaran = c.kode_ajaran and kode_prodi = c.kode_prodi
								and nim = c.nim and kode_mk = r.kode_mk and jenis_nilai = '".$_POST["f_jenis_nilai"]."' and ke = '".$_POST["f_nilai_ke"]."' ),0) as 'nilai'
								FROM civitas_perwalian c, rencana_studi r
								WHERE c.kode_ajaran = '".$ajaran_aktif."' and c.kode_prodi = '".$kode_prodi."' 
								and c.kode_ajaran = r.kode_ajaran and c.kode_prodi = r.kode_prodi and c.kode_rencana_studi = r.kode_rencana_studi
								and r.kode_mk = '".$kode_matkul."' ";
								writeFile("test.txt", $query);
		}
		else{
			$name = getTableAlias(0, $_POST['name']);
			if ($name=="ruang"){
				$endrow		= 10;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				
				$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
				$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
					upper(kode_ruang) as 'ruang', 
					upper(kapasitas_kuliah) as 'kapasitas',
					upper(kapasitas_UJIAN) as 'kapasitas ujian'
					from ".$name." limit ".$startrow.", ".$endrow."";
			}
			if ($name=="fakultas"){
				$endrow		= 100;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				
				$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
				$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
					upper(kode_fakultas) as 'kode fakultas', 
					upper(nama_fakultas) as 'nama fakultas'
					from ".$name." limit ".$startrow.", ".$endrow."";
			}
			if ($name=="jurusan"){
				$endrow		= 100;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				
				$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
				$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
					upper(j.kode_jurusan) as 'kode jurusan', 
					upper(j.nama_jurusan) as 'nama jurusan',
					(select nama_fakultas from fakultas where kode_fakultas = j.kode_fakultas ) as 'fakultas'
					from ".$name." j limit ".$startrow.", ".$endrow."";
			}
			if ($name=="mata_kuliah_jenis"){
				$endrow		= 10;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				
				$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
				$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
					upper(kode_jenis) as 'kode jenis', 
					upper(nama_jenis) as 'nama jenis'
					from ".$name." limit ".$startrow.", ".$endrow."";
			}
			if ($name=="kelas"){
				$endrow		= 10;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				
				$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
				$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
					upper(k.kode_kelas) as 'prime', 
					(select upper(nama_mk) from mata_kuliah where kode_mk = k.kode_mk) as 'mata kuliah',
					upper(k.nama_kelas) as 'kelas', 
					upper(k.keterangan) as 'keterangan'
					from ".$name." k ".addFilterCondition($name, "k", true)." limit ".$startrow.", ".$endrow."";
			}
			if ($name=="mata_kuliah"){
				$endrow		= 10;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				$indexrow	= $startrow+1;
				
				$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
				$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $indexrow)."' as 'no', 
					'".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'active', 
					upper(m.kode_mk) as 'kode mk', 
					upper(m.nama_mk) as 'nama mk', 
					(select upper(nama_jenis) from mata_kuliah_jenis where kode_jenis = m.kode_jenis ) as 'jns mk', 
					upper(m.sks) as 'sks', 
					(select upper(nama_item) from lookup_item where kode_item = m.kode_jenis_kurikulum ) as 'jns kurikulum', 
					(select upper(nama_item) from lookup_item where kode_item = m.kode_pilihan )		 as 'wajib / pilihan', 
					(select upper(nama_item) from lookup_item where kode_item = m.kode_kelompok)		 as 'kelompok', 
					upper(m.sap) as 'sap',
					upper(m.silabus) as 'sila bus',
					upper(m.diktat) as 'dik tat',
					upper(m.bahan_ajar) as 'bahan ajar',
					upper(m.status) as 'status',
					(select count(*) from mata_kuliah_dosen where kode_mk = m.kode_mk ) as 'dosen'
					from ".$name." m limit ".$startrow.", ".$endrow."";
			}
			if ($name=="mata_kuliah_dosen"){
				$endrow		= 10;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				
				$datapaging = ceil(execqueryreturn($name,"select count(*) from ".$name." ".addFilterCondition($name, "", true)) / $endrow);
				$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
					upper(m.kode_mk_dosen) as 'prime', 
					upper(m.kode_mk) as 'none', 
					upper(m.nidn) as 'nidn', 
					(select upper(concat(nama_dosen,', ',gelar_belakang)) from dosen_biodata where nidn = m.nidn ) as 'nama'
					from ".$name." m ".addFilterCondition($name, "m", true)." limit ".$startrow.", ".$endrow."";
					writeFile("test.txt", $query);
			}
			if ($name=="tahun_ajaran"){
				$endrow		= 10;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				
				$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
				$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
					upper(kode_ajaran) as 'kode', 
					upper(tahun) as 'tahun', 
					upper(semester) as 'semester'
					from ".$name." where status = 1 limit ".$startrow.", ".$endrow."";
			}
			if ($name=="rencana_studi"){
				$endrow		= 100;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				
				$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
				$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
					upper(r.kode_rencana_studi) as 'prime', 
					upper(r.kode_ajaran) as 'none', 
					(select upper(concat(tahun,' ( ',semester,' ) ')) from tahun_ajaran where kode_ajaran = r.kode_ajaran ) as 'none',
					(select upper(concat(jenjang,' ',nama_prodi)) from prodi_identitas where kode_prodi = r.kode_prodi ) as 'none',
					upper(r.semester) as 'smt', 
					(select upper(concat(nama_mk,'')) from mata_kuliah where kode_mk = r.kode_mk ) as 'mata kuliah',
					(select upper(concat(sks,'')) from mata_kuliah where kode_mk = r.kode_mk ) as 'sks',
					(select upper(concat(nama_mk,' (',sks,' sks)')) from mata_kuliah where kode_mk = r.kode_mk_syarat ) as 'none' 
					from ".$name." r ".addFilterCondition($name, "r", true)." order by r.semester limit ".$startrow.", ".$endrow."";
			writeFile("test.txt", $query);
			}
			if ($name=="jadwal_kuliah"){
				$endrow		= 100;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
				
				$ajaran		= execqueryreturn("tahun_ajaran", "select kode_ajaran from tahun_ajaran where status = 1");
				if(isset($_POST['mhs_nim'])){
					$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
						upper(r.kode_jadwal) as 'prime', 
						upper(concat(DATE_FORMAT(r.mulai, '%H:%i'),' - ',DATE_FORMAT(r.selesai, '%H:%i'))) as 'waktu', 
						(select upper(concat(nama_mk,' (',sks,' sks)')) from mata_kuliah where kode_mk = r.kode_mk ) as 'mata kuliah',
						(select upper(nama_kelas) from kelas where kode_kelas = r.kode_kelas ) as 'kelas',
						upper(r.kode_ruang) as 'ruang',
						(select upper(concat(gelar_depan,' ', nama_dosen, ', ',gelar_belakang)) from dosen_biodata where nidn = r.nidn ) as 'dosen' 
						from ".$name." r ".addFilterCondition($name, "r", true)." and r.kode_kelas in 
						(select kode_kelas from civitas_perwalian where nim = '".$_POST['mhs_nim']."' and kode_ajaran = '".$ajaran."' ) 
						order by r.mulai limit ".$startrow.", ".$endrow."";
				}
				else{
					if($_POST["f_hari"] == 'none'){
						$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no',
										r.kode_rencana_studi as 'prime',
										p.nama_prodi as 'nama prodi', m.nama_mk as 'mata kuliah', k.nama_kelas as 'nama kelas', m.sks as 'sks'
										FROM civitas_perwalian c, rencana_studi r, kelas k, prodi_identitas p, mata_kuliah m 
										where r.kode_mk not in 
										(select kode_mk from jadwal_kuliah where kode_ajaran = c.kode_ajaran and kode_prodi = c.kode_prodi )
										and c.kode_ajaran = '".$ajaran."' and c.kode_rencana_studi = r.kode_rencana_studi 
										and c.kode_kelas = k.kode_kelas and c.kode_prodi = p.kode_prodi and  r.kode_mk = m.kode_mk 
										group by p.nama_prodi, m.nama_mk, k.nama_kelas ";
						
					}
					else{
						$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
							upper(r.kode_jadwal) as 'prime', 
							upper(concat(DATE_FORMAT(r.mulai, '%H:%i'),' - ',DATE_FORMAT(r.selesai, '%H:%i'))) as 'waktu', 
							(select upper(concat(nama_mk,' (',sks,' sks)')) from mata_kuliah where kode_mk = r.kode_mk ) as 'mata kuliah',
							(select upper(concat(jenjang,' ',nama_prodi)) from prodi_identitas where kode_prodi = r.kode_prodi ) as 'program studi',
							(select upper(nama_kelas) from kelas where kode_kelas = r.kode_kelas ) as 'kelas',
							upper(r.kode_ruang) as 'ruang',
							(select upper(concat(gelar_depan,' ', nama_dosen, ', ',gelar_belakang)) from dosen_biodata where nidn = r.nidn ) as 'dosen' 
							from ".$name." r ".addFilterCondition($name, "r", true)."  and kode_ajaran = '".$ajaran."' order by r.mulai limit ".$startrow.", ".$endrow."";
					}
				}
			}
			if ($name=="perwalian_jadwal"){
				$endrow		= 10;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				
				$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
				$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
					upper(r.kode_perwalian_jadwal) as 'prime', 
					upper(r.kode_ajaran) as 'none', 
					(select upper(concat(jenjang,' ',nama_prodi)) from prodi_identitas where kode_prodi = r.kode_prodi ) as 'program studi',
					upper(r.tanggal_mulai) as 'tanggal mulai', 
					upper(r.tanggal_selesai) as 'tanggal selesai', 
					upper(r.keterangan) as 'keterangan'
					from ".$name." r ".addFilterCondition($name, "r", true)." limit ".$startrow.", ".$endrow."";
			}
			if ($name=="perpustakaan_group"){
				$endrow		= 10;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				
				$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
				$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
					upper(kode_group) as 'kode grup', 
					upper(nama_group) as 'nama grup'
					from ".$name." order by date_saved desc limit ".$startrow.", ".$endrow."";
			}	
			if ($name=="perpustakaan_kategori"){
				$endrow		= 10;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				
				$filter		= "";
				if(isset($_POST["ctl_kode_group"])){$filter = " where p.kode_group = '". $_POST["ctl_kode_group"]."'";}
				
				$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
				
				$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
					upper(p.kode_kategori) as 'kode kategori', 					
					(select kode_group from perpustakaan_group where kode_group = p.kode_group) as 'kode grup', 
					(select nama_group from perpustakaan_group where kode_group = p.kode_group) as 'nama grup', 
					upper(p.nama_kategori) as 'nama kategori'
					from ".$name." p ".$filter." order by p.date_saved desc limit ".$startrow.", ".$endrow."";
			}	
			if ($name=="perpustakaan_katalog"){
				$endrow		= 20;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				$indexrow	= $startrow+1;
				
				$filter = "";
				$f1 = false;
				if(isset($_POST["ctl_kode_group"])){
					$filter = " where p.kode_group = '". $_POST["ctl_kode_group"]."'"; $f1 = true;
				}
				
				if(isset($_POST["ctl_kode_kategori"])){
					if($f1){ $filter .= " and p.kode_kategori = '". $_POST["ctl_kode_kategori"]."'"; }
					else{ $filter = " where p.kode_kategori = '". $_POST["ctl_kode_kategori"]."'"; }
				}
								
				$datapaging = ceil(execqueryreturn($name,"select count(p.kode_katalog) from ".$name." p " . $filter) / $endrow);				
				$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $indexrow)."' as 'no', 
					'".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'active', 
					upper(p.kode_katalog) as 'kode katalog', 					
					upper(p.kode_group) as 'kode group', 						
					upper(p.kode_kategori) as 'kode kategori', 					
					upper(p.judul) as 'judul', 					
					upper(p.pengarang) as 'pengarang', 					
					upper(p.tahun_terbit) as 'tahun_terbit'
					from ".$name." p  ".$filter."
					order by p.date_saved desc limit ".$startrow.", ".$endrow."";
					
			}
			if ($name=="keuangan_jenis"){
				$endrow		= 100;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				
				$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
				$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
					upper(kode_jenis) as 'prime', 
					upper(nama_jenis) as 'nama jenis'
					from ".$name." limit ".$startrow.", ".$endrow."";
			}
			if ($name=="keuangan_nilai"){
				$endrow		= 100;
				$startrow	= ($_POST["startrow"] - 1) * $endrow;
				
				$datapaging = ceil(execqueryreturn($name,'select count(*) from '.$name) / $endrow);
				$query		= "SELECT '".$datapaging."' as 'p_row', '".mysqli_real_escape_string($con, $_POST["startrow"])."' as 'no', 
					upper(j.kode_keuangan) as 'prime',  
					upper(j.nama) as 'nama',
					upper(case j.tipe when 'sekali' then 'satu kali bayar' when 'smt' then 'per semester' when 'sks' then 'per sks' end) as 'pembayaran',
					upper(concat(format(j.nilai, 0))) as 'nilai',
					upper((select nama_jenis from keuangan_jenis where kode_jenis = j.kode_jenis )) as 'jenis'
					from ".$name." j order by jenis limit ".$startrow.", ".$endrow."";
					
			}
		}
	}	
	
	$result = mysqli_query($con, $query);
	$rows = array();
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$rows[] = $row;
	}
	$data = json_encode($rows);

	echo $data;

	function addFilterCondition($tabel, $alias, $withWhere){
		$filter = '';
		if($alias != ""){$alias = $alias.".";}
		if(isset($_POST['filter'])){
			$columns = getColumns($tabel);
			foreach ($columns as $col) {
				$columnName = $col[0];
				if(isset($_POST['f_'.$columnName])){
					$filter .= $alias.$columnName."='".$_POST['f_'.$columnName]."' and ";
				}
			}
			$filter = substr($filter,0,strlen($filter)-strlen('and '));
			if($withWhere){
				$filter = " where ".$filter;
			}
		}
		
		return $filter;
	}  
	
?>


