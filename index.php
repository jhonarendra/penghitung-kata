<!DOCTYPE html>
<html>
<head>
	<title>Aplikasi Term Frequency</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<div id="header">
		<h1><a href="">Aplikasi Term Frequency</a></h1>
	</div>
	<div id="content">


<?php
	if(isset($_POST["submit"])) {
		$korpus = $_FILES["file"]["tmp_name"];
		$content = file_get_contents($korpus); // Diambil file text
		$content = preg_replace( "/(,|\"|\.|\?|:|!|;|-| - )/", " ", $content ); // menghilangkan tanda baca
		$content = preg_replace( "/\n/", " ", $content ); // menghilangkan enter
		$content = preg_replace( "/\s\s+/", " ", $content ); // menghilangkan spasi
		$content = explode(" ",$content); // memisahkan kata per spasi

		// variabel input $input nanti diisi $content (file text nya)

		function tokenisasi($input){
			$results = array();

			foreach ($input as $key=>$word) {
				$phrase = '';
				
				// FOR $i = 1 => diambil 1 kata
				// $input[$key] => ngambil 1 kata dimasukin ke $phrase

				for ($i=0;$i<1;$i++) {
					$phrase = strtolower($input[$key]);
				}

				// $results[$phrase] => menaruk kata ke array untuk dihitung perulangannya
				// $phrase adalah kata yg didapat, $result[$phrase] jumlahnya
				
				$a = explode(" ","yang di dan itu dengan untuk tidak ini dari dalam akan pada juga saya ke karena tersebut bisa ada mereka lebih kata tahun sudah atau saat oleh menjadi orang ia telah adalah seperti sebagai bahwa dapat para harus namun kita dua satu masih hari hanya mengatakan kepada kami setelah melakukan lalu belum lain dia kalau terjadi banyak menurut  anda hingga tak baru beberapa ketika saja jalan sekitar secara dilakukan sementara tapi sangat hal sehingga  seorang bagi besar lagi selama antara waktu sebuah jika sampai jadi terhadap tiga serta pun salah merupakan atas sejak  membuat baik memiliki  kembali selain tetapi pertama kedua memang pernah apa mulai sama tentang bukan agar semua sedang kali kemudian hasil sejumlah juta persen sendiri katanya demikian masalah  mungkin umum setiap bulan bagian bila lainnya terus luar cukup termasuk sebelumnya bahkan wib tempat perlu menggunakan memberikan rabu sedangkan kamis langsung apakah pihak melalui diri mencapai  minggu aku  berada tinggi ingin sebelum tengah kini the tahu bersama depan selasa begitu  merasa  berbagai mengenai  maka jumlah masuk   katanya  mengalami sering ujar kondisi akibat hubungan empat paling mendapatkan selalu lima  meminta melihat sekarang mengaku mau kerja acara menyatakan masa proses tanpa selatan sempat  adanya hidup datang senin rasa maupun seluruh mantan lama jenis segera misalnya  mendapat bawah jangan meski terlihat akhirnya jumat  punya yakni terakhir kecil panjang badan juni of  jelas jauh tentu semakin tinggal kurang  mampu posisi  asal sekali  sesuai sebesar berat  dirinya memberi pagi  sabtu  ternyata mencari sumber ruang menunjukkan biasanya nama  sebanyak utara berlangsung barat kemungkinan yaitu  berdasarkan  sebenarnya cara utama pekan terlalu  membawa kebutuhan suatu menerima  penting  tanggal bagaimana terutama tingkat awal sedikit nanti pasti  muncul dekat lanjut ketiga biasa dulu kesempatan  ribu  akhir  membantu terkait  sebab menyebabkan khusus  bentuk ditemukan  diduga mana ya kegiatan sebagian tampil hampir bertemu usai berarti keluar pula digunakan justru  padahal menyebutkan  gedung  apalagi program  milik teman menjalani keputusan sumber a  upaya mengetahui mempunyai berjalan menjelaskan  b mengambil benar lewat belakang ikut barang meningkatkan kejadian kehidupan keterangan penggunaan masing-masing menghadapi");
				foreach ($a as $banned) unset($results[$banned]);

				if (!isset($results[$phrase])){
					$results[$phrase] = 1;
				} else {
					$results[$phrase]++;
				}
			}

			array_multisort($results, SORT_DESC); //mengurutkan dari frekuensi besar ke kecil
			return $results;
		} // end fungsi tokenisasi
?>

		<div class="col-6 form">
			<div id="form">
				<h2>Input File</h2>
				<form action="" method="POST" enctype="multipart/form-data">
					<label for="inputfile">Upload</label>
					<input id="inputfile" type="file" name="file" required="">
					<input type="submit" name="submit" value="kirim">
				</form>
			</div>
		</div>

		<div class="col-6">
			<div id="isi">
				<h2>Isi Konten</h2>
				<div class="scroll">
					<p style="padding:20px;line-height: 1.5em">
						<?php
							$data = file_get_contents($korpus);
							echo $data;
						?>
					</p>
				</div>
			</div>
			<div id="word-count">
				<h2 style="float: left">Jumlah Kata</h2>
				<p style="text-align: right;padding: 20px;font-size: 40px"><?php echo count($content)-1;?></p>
			</div>
		</div>
		<div class="col-6">
			
			<div id="table">
				<h2>Term Frequency</h2>
				<div class="scroll">
					<table>
						<tr>
							<th>Peringkat</th>
							<th>Kata</th>
							<th>Frekuensi</th>
						</tr>
						<?php
							// Dipanggil fungsi tokenisasi
							$stats = tokenisasi($content);

							$i=1;
							foreach ($stats as $term => $count) {

								// if term != "", supaya gak diindex term yg kosong
								if($term != ""){
						?>
						<tr>
							<td><?php echo $i ?></td>
							<td><?php echo $term ?></td>
							<td><?php echo $count ?></td>
						</tr>
						<?php
									$i++;
								}
							}
						?>
					</table>
				</div>
			</div>
		</div>
<?php
	} else {
?>


		<div id="form">
			<h2>Input File</h2>
			<form action="" method="POST" enctype="multipart/form-data">
				<label for="inputfile">Upload</label>
				<input id="inputfile" type="file" name="file" required="">
				<input type="submit" name="submit" value="kirim">
			</form>
		</div>



<?php
	}
?>



		<div style="clear: both;"></div>
	</div>
	<footer>
		I Putu Iduar Perdana - I Wayan Gunaya - Putu Jhonarendra
	</footer>
</body>
</html>