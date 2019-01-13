<?php
	include 'Stemming.php';
	include 'fungsi.php';
	// $plain_text = "Sebanyak 1000 sopir angkutan kota di Kota Medan dan Kabupaten Deli Serdang mendukung Joko Widodo untuk kembali maju dalam pertarungan memperebutkan kursi Presiden Republik Indonesia. Aksi dukungan tersebut disampaikan dengan menggelar konvoi dengan mengendarai  armada mereka dimulai dari titik nol Kota Medan di Lapangan Merdeka Medan menuju Lapangan Garuda Tanjung Morawa, Deliserdang, Sumatera Utara, Selasa 18 September 2018. Dengan rute konvoi sejauh 20 kilometer.
	// Dukungan tersebut dideklarasikan Ketua Kesatuan Pemilik dan Sopir Angkutan (Kesper) Sumut, Israel Situmeang; Ketua Organisasi Angkutan Darat (Organda) Sumut, Haposan Sialagan, serta tokoh masyarakat Sumut lainnya seperti Gelmok Samosir.Selain itu, dukung disampaikan juga oleh tiga mantan pemain tim sepakbola PSMS Medan, Jampi Hutauruk, Parlin Siagian, dan Amrus Sibadarida. Aksi deklarasi dukungan kepada Jokowi mengusung Konvoi Kerakyatan yang melibatkan serta keluarga para sopir dan pengusaha angkutan itu, dilakukan sebagai bentuk dukungan masyarakat transportasi di Sumatera Utara terhadap Jokowi.
	// \"Hari ini kami semua, sopir, pengusaha angkot dan keluarga kami, serta para penumpang kami, menyatakan dukungan kami kepada bapak Joko Widodo untuk kembali maju sebagai Presiden. Ini bentuk kecintaan kami kepada Pak Jokowi. Kami untuk Jokowi 2 Periode,\" kata Israel Situmeang dalam orasi deklarasinya disambut dengan tepukan tangan. Israel menilai Jokowi layak didukung kembali dengan melihat kinerjanya dalam pembangunan infrastruktur untuk rakyat, seperti dibangunnya jalan tol Binjai-Tebingtinggi di Sumatera Utara, yang telah memangkas jarak tempuh dan efisiensi transportasi yang begitu besar di Sumut.";
	$plain_text = "Sebanyak 1000 sopir angkutan kota di Kota Medan dan Kabupaten Deli Serdang mendukung Joko Widodo untuk kembali maju dalam pertarungan memperebutkan kursi Presiden Republik Indonesia. Aksi dukungan tersebut disampaikan dengan menggelar konvoi dengan mengendarai  armada mereka dimulai dari titik nol Kota Medan di Lapangan Merdeka Medan menuju Lapangan Garuda Tanjung Morawa, Deliserdang, Sumatera Utara, Selasa 18 September 2018. Dengan rute konvoi sejauh 20 kilometer. Dukungan tersebut dideklarasikan Ketua Kesatuan Pemilik dan Sopir Angkutan (Kesper) Sumut, Israel Situmeang; Ketua Organisasi Angkutan Darat (Organda) Sumut, Haposan Sialagan, serta tokoh masyarakat Sumut lainnya seperti Gelmok Samosir.
Selain itu, dukung disampaikan juga oleh tiga mantan pemain tim sepakbola PSMS Medan, Jampi Hutauruk, Parlin Siagian, dan Amrus Sibadarida. Aksi deklarasi dukungan kepada Jokowi mengusung Konvoi Kerakyatan yang melibatkan serta keluarga para sopir dan pengusaha angkutan itu, dilakukan sebagai bentuk dukungan masyarakat transportasi di Sumatera Utara terhadap Jokowi. \"Hari ini kami semua, sopir, pengusaha angkot dan keluarga kami, serta para penumpang kami, menyatakan dukungan kami kepada bapak Joko Widodo untuk kembali maju sebagai Presiden. Ini bentuk kecintaan kami kepada Pak Jokowi. Kami untuk Jokowi 2 Periode,\" kata Israel Situmeang dalam orasi deklarasinya disambut dengan tepukan tangan. Israel menilai Jokowi layak didukung kembali dengan melihat kinerjanya dalam pembangunan infrastruktur untuk rakyat, seperti dibangunnya jalan tol Binjai-Tebingtinggi di Sumatera Utara, yang telah memangkas jarak tempuh dan efisiensi transportasi yang begitu besar di Sumut.
\"Kami tidak paham soal gonjang-ganjing politik. Yang terpenting buat kami bagaimana kami lebih mudah cari makan. Selama ini kami sangat terbantu dengan program-program Pak Jokowi. Dan hari ini kami menunjukkan kecintaan kami kepada beliau dan juga kepada Negara Kesatuan Republik Indonesia ini. Kami ingin dia (Jokowi) dua periode,\" tutur Israel. Meski mereka mendukung, para sopir tersebut juga mengkritik soal pelayanan publik. Namun, Israel mengatakan sebagai catatan untuk diperbaiki lagi ke depannya. Agar pelayanan publik dapat dirasakan oleh masyarakat sendiri.
\"Tapi memang masih ada yang menjadi catatan kami dalam pemerintahan Pak Jokowi. Yakni soal perizinan yang masih sulit dan belum sesuai janji Pak Jokowi. Ini yang kita dorong agar bisa diselesaikan Pak Jokowi di periode selanjutnya,\" kata Israel. Israel menyebutkan pihaknya juga punya catatan selama masa periode Jokowi untuk regulasi tranportasi online dan jterminal liar. Mereka melihat ini sudah diupayakan dan hanya tinggal menunggu koordinasi dari Pemerintah Daerah dan Kepolisian.
\"Secara prinsip, kebijakan pemerintahan Jokowi sudah memihak pada kita pada sopir dan pengusaha angkuran,\" kata Israel. ";

	// $textproc = new Stemming();
	$textproc = new NLP();

	$plain_text = explode(PHP_EOL, $plain_text);

	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Perhitungan TF IDF</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<style type="text/css">
			table td{
				padding:5px 8px;
			}
		</style>
	</head>
	<body>
		<div id="header">
			<h1><a href="">Perhitungan TF IDF</a></h1>
		</div>
		<div id="content" style="margin:0 20px 0 20px">
				<div style="border:1px solid #444;padding:10px">
				<?php
				foreach ($plain_text as $key) {
					echo $key."<br /><br />";
				}
				?>
				</div><br /><br />
				<?php

				$jml_paragraf = count($plain_text);

				$paragraf = array();
				$kalimat = array();
				$plain_kalimat = array();

				// untuk mendapatkan array tf per kalimat
				foreach ($plain_text as $key => $value) {
					$paragraf[$key] = $value;
					$paragraf[$key] = explode(".", $paragraf[$key]);
					$paragraf[$key] = array_slice($paragraf[$key], 0, sizeof($paragraf[$key])-1);
					$jml_kalimat[$key] = count($paragraf[$key]);
					foreach ($paragraf[$key] as $key2 => $value2) {
						$kalimat[$key][$key2] = $value2;
						$plain_kalimat[$key][$key2] = $value2;
						// $kalimat[$key][$key2] = $textproc->stem($kalimat[$key][$key2]);
						$kalimat[$key][$key2] = $textproc->listStemming($kalimat[$key][$key2]);
						$kalimat[$key][$key2] = array_count_values($kalimat[$key][$key2]);	
					}
				}

				// tf perkalimat itu digabung jadi per paragraf
				for ($i=0; $i < $jml_paragraf; $i++) { 
					$j = 0;
					foreach ($kalimat[$i] as $key => $value) {
						foreach ($value as $key2 => $value2) {
							$term_paragraf[$i][$j] = $key2;
							$j++;
						}
					}
					$term_paragraf[$i] = array_count_values($term_paragraf[$i]);
				}

				// ini untuk menyocokkan term pada tiap kalimat
				for ($h=0; $h < $jml_paragraf; $h++) {
					for ($i=0; $i < $jml_kalimat[$h]; $i++) { 
						$j = 0;
						foreach ($term_paragraf[$h] as $key => $value) {
							$tf[$h][$i][$j] = 0;

							foreach ($kalimat[$h][$i] as $key2 => $value2) {
								if($key == $key2){
									$tf[$h][$i][$j] = $value2;
									break;
								}
							}
							$j++;
						}
					}
				}

				// menampilkan token tiap kalimat per paragraf
				$nop=1;
				for ($h=0; $h < $jml_paragraf; $h++) {
					$no=1;
					echo "Paragraf ".$nop."<br />";
					for ($i=0; $i < $jml_kalimat[$h]; $i++) {
						echo "Token Kalimat ".$no.": ";
						foreach ($kalimat[$h][$i] as $key=>$value) {
							echo $key." ";
						}
						echo "<br />";
						$no++;
					}
					echo "<br />";
					$nop++;
				}

				// token perkalimat digabung per paragraf
				$no = 1;
				for ($h=0; $h < $jml_paragraf; $h++) {
					echo "<br />Token pada paragraf ".$no.": <br />";
					foreach ($term_paragraf[$h] as $key=>$value) {
						echo $key." ";
					}
					echo "<br />";
					$no++;
				}
				echo "<br /><br />";

				// menampilkan matriks
				$nop = 1;
				for ($h=0; $h < $jml_paragraf; $h++) {
				?>
				<p>TF Paragraf <?php echo $nop ?></p>
				<table border="1">
					<tr>
						<td>X</td>
				<?php
					foreach ($term_paragraf[$h] as $key=>$value) {
						echo "<td>".$key."</td>";
					}
					?>
					</tr>
					<?php
					$no = 1;
					for ($i=0; $i < $jml_kalimat[$h]; $i++) {
						$j = 0;
					?>
					<tr><td><?php echo "Kalimat ".$no ?></td>
					<?php
						foreach ($tf[$h][$i] as $key) {
							$tf[$h][$i][$j] = $key;
							echo "<td>".$tf[$h][$i][$j]."</td>";
							$j++;
						}
						echo "</tr>";
						$no++;
					}
					echo "</table><br /><br />";
					$nop++;
				}

				// hitung jumlah kalimat yg mengandung term
				for ($h=0; $h < $jml_paragraf; $h++) {
					$j = 0;
					foreach ($tf[$h][$j] as $key) {
						$cek[$h][$j]=0;
						for ($i=0; $i < $jml_kalimat[$h]; $i++) { 
							if($tf[$h][$i][$j]!=0){
								$cek[$h][$j]=$cek[$h][$j]+1;
							}
						}
						$j++;
					}
				}

				// nampilin jumlah kalimat yg mengandung term
				$h = 0;
				foreach ($cek as $key) {
					echo "Paragraf ".$h.": <br />";
					echo "<table border='1'><tr><td>X</td>";
					foreach ($term_paragraf[$h] as $keys=>$value) {
						echo "<td>".$keys."</td>";
					}
					echo "</tr><tr><td>#</td>";
					foreach ($key as $key2) {
						echo "<td>".$key2."</td>";
					}
					echo "</tr>";
					echo "</table><br />";
					$h++;
				}

				// frekuensi kata dikali log jumlah kalimat pada paragraf bagi jumlah kalimat yg mengandung kata itu
				// echo json_encode($cek);
				echo "Hasil TF IDF<br />";
				for ($h=0; $h < $jml_paragraf; $h++) {
					echo "Paragraf ".$h."<table border='1'><tr><td></td>";
					foreach ($term_paragraf[$h] as $keys=>$value) {
						echo "<td>".$keys."</td>";
					}
					echo "</tr>";
					$no = 1;
					for ($i=0; $i < $jml_kalimat[$h]; $i++) {
						echo "<tr><td>Kalimat ".$no."</td>";
						for ($j=0; $j < count($cek[$h]) ; $j++) { 
							$tfidf[$h][$i][$j] = $tf[$h][$i][$j]*log10($jml_kalimat[$h]/$cek[$h][$i]);
							echo "<td>".$tfidf[$h][$i][$j]."</td>";
						}
						echo "</tr>";
						$no++;
					}
					echo "</table><br />";
				}

				echo "Menghitung Bobot Kalimat<br />";
				for ($h=0; $h < $jml_paragraf; $h++) {
					for ($i=0; $i < $jml_kalimat[$h]; $i++) { 
						$tfidfkalimat[$h][$i] = 0;
						for ($j=0; $j < count($cek[$h]) ; $j++) {
							$tfidfkalimat[$h][$i] = $tfidfkalimat[$h][$i]+$tfidf[$h][$i][$j];
						}
					}
				}

				for ($h=0; $h < $jml_paragraf; $h++) {
					echo "Paragraf ".$h.": <br />";
					$i = 1;
					foreach ($tfidfkalimat[$h] as $key) {
						echo "Bobot kalimat ".$i.": ".$key."<br />";
						$i++;
					}
					echo "<br /><br />";
				}
				
				echo "<br />Hasil ringkasan:<br /><br />";
				for ($h=0; $h < $jml_paragraf; $h++) {
					for ($i=0; $i < $jml_kalimat[$h]; $i++) {
						if (max($tfidfkalimat[$h])==$tfidfkalimat[$h][$i]) {
							echo $plain_kalimat[$h][$i].". ";
						}
					}
				}
				echo "<br /><br />";
			?>
		</div>
	</body>
	</html>