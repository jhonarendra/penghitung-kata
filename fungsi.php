<?php
	class NLP{
		public function tokenisasi($input){
			//fungsi ini untuk menghilangkan tanda baca pada kalimat, dan memisahkan kata kata
			$input = preg_replace( "/(,|\"|\.|\?|:|!|;|-| - )/", " ", $input ); // menghilangkan tanda baca
			$input = preg_replace( "/\n/", " ", $input ); // menghilangkan enter
			$input = preg_replace( "/\s\s+/", " ", $input ); // menghilangkan spasi
			$input = explode(" ",$input);

			return $input;
		}
		public function stopwords(){
			$a = explode(" ","yang di dan itu dengan untuk tidak ini dari dalam akan pada juga saya ke karena tersebut bisa ada mereka lebih kata tahun sudah atau saat oleh menjadi orang ia telah adalah seperti sebagai bahwa dapat para harus namun kita dua satu masih hari hanya mengatakan kepada kami setelah melakukan lalu belum lain dia kalau terjadi banyak menurut  anda hingga tak baru beberapa ketika saja jalan sekitar secara dilakukan sementara tapi sangat hal sehingga  seorang bagi besar lagi selama antara waktu sebuah jika sampai jadi terhadap tiga serta pun salah merupakan atas sejak  membuat baik memiliki  kembali selain tetapi pertama kedua memang pernah apa mulai sama tentang bukan agar semua sedang kali kemudian hasil sejumlah juta persen sendiri katanya demikian masalah  mungkin umum setiap bulan bagian bila lainnya terus luar cukup termasuk sebelumnya bahkan wib tempat perlu menggunakan memberikan rabu sedangkan kamis langsung apakah pihak melalui diri mencapai  minggu aku  berada tinggi ingin sebelum tengah kini the tahu bersama depan selasa begitu  merasa  berbagai mengenai  maka jumlah masuk   katanya  mengalami sering ujar kondisi akibat hubungan empat paling mendapatkan selalu lima  meminta melihat sekarang mengaku mau kerja acara menyatakan masa proses tanpa selatan sempat  adanya hidup datang senin rasa maupun seluruh mantan lama jenis segera misalnya  mendapat bawah jangan meski terlihat akhirnya jumat  punya yakni terakhir kecil panjang badan juni of  jelas jauh tentu semakin tinggal kurang  mampu posisi  asal sekali  sesuai sebesar berat  dirinya memberi pagi  sabtu  ternyata mencari sumber ruang menunjukkan biasanya nama  sebanyak utara berlangsung barat kemungkinan yaitu  berdasarkan  sebenarnya cara utama pekan terlalu  membawa kebutuhan suatu menerima  penting  tanggal bagaimana terutama tingkat awal sedikit nanti pasti  muncul dekat lanjut ketiga biasa dulu kesempatan  ribu  akhir  membantu terkait  sebab menyebabkan khusus  bentuk ditemukan  diduga mana ya kegiatan sebagian tampil hampir bertemu usai berarti keluar pula digunakan justru  padahal menyebutkan  gedung  apalagi program  milik teman menjalani keputusan sumber a  upaya mengetahui mempunyai berjalan menjelaskan  b mengambil benar lewat belakang ikut barang meningkatkan kejadian kehidupan keterangan penggunaan masing-masing menghadapi");
			return $a;
		}
		public function katadasar(){
			$katadasar = file_get_contents('katadasar.txt');
			$katadasar = $this->tokenisasi($katadasar);
			return $katadasar;
		}
		public function stopwordlist($input){
			$a = $this->stopwords();
			$i = 0;
			foreach ($input as $term) {
				$term = strtolower($term);
				if(in_array($term, $a)){
					$stopwordlist[$i] = $term;
				}
				$i++;
			}
			return $stopwordlist;
		}
		public function wordlist($input){
			$a = $this->stopwords();
			$i = 0;
			foreach ($input as $term) {
				$term = strtolower($term);
				if(!in_array($term, $a)){
					$wordlist[$i] = $term;
				}
				$i++;
			}
			return $wordlist;
		}
		public function typelist($input){
			$a = $this->stopwords();
			$i = 0;
			foreach ($input as $term) {
				$term = strtolower($term);
				if(!in_array($term, $a)){
					
					if (!isset($typelist[$term])){
						$typelist[$term] = 1;
					} else {
						$typelist[$term]++;
					}
					
				}
				$i++;
			}
			return $typelist;
		}
		public function tf_plain($input){
			$results = array();
			foreach ($input as $key=>$word) {
				$phrase = strtolower($input[$key]);
				if (!isset($results[$phrase])){
					$results[$phrase] = 1;
				} else {
					$results[$phrase]++;
				}
			}
			array_multisort($results, SORT_DESC);
			return $results;
		}
		public function tf_stopword($input){
			$results = array();
			foreach ($input as $key=>$word) {
				$phrase = strtolower($input[$key]);
				$a = $this->stopwords();
				foreach ($a as $banned){
					unset($results[$banned]);
				}
				if (!isset($results[$phrase])){
					$results[$phrase] = 1;
				} else {
					$results[$phrase]++;
				}
			}
			array_multisort($results, SORT_DESC);
			return $results;
		}
		public function tf_stemming($input){
			$results = array();
			foreach ($input as $key=>$word) {
				$phrase = strtolower($input[$key]);
				$a = $this->stopwords();
				foreach ($a as $banned){
					unset($results[$banned]);
				}
				$phrase = $this->porter($phrase);
				if (!isset($results[$phrase])){
					$results[$phrase] = 1;
				} else {
					$results[$phrase]++;
				}
			}
			array_multisort($results, SORT_DESC);
			return $results;
		}
		public function porter($kataa){
			// Porter stemming
			// Langkah-Langkah Algortima pada Porter Stemmer.
			// 1. Menghapus Partikel seperti: kah, lah, tah
			// 2. Menghapus Kata ganti (Possesive Pronoun), seperti ku, mu, nya
			// 3. Menghapus awalan pertama (meng, menge, meny, pem, peny, pen, di, ker).
			//    Jika tidak ditemukan, maka lanjut ke langkah 4a, dan jika ada maka lanjut ke langkah 4b.
			// 4. a. Menghapus Awalan kedua (ber, bel, pel, se), dan dilanjutkan pada langkah 5a
			//    b. Menghapus akhiran, jika tidak ditemukan maka kata tersebut diasumsikan sebagai kata dasar (rootword). Jika ditemukan maka lanjut ke langkah 5b.
			// 5. a. Menghapus akhiran dan kata akhir diasumsikan sebagai kata dasar (root word).
			// b. Menghapus awalan kedua dan kata akhir diasumsikan sebagai kata dasar (root word)


			// bug: kata menyenangkan

			//fungsi substr(kata, mulai huruf ke, jumlah huruf)
			
			$kataa = $this->hapuspartikel($kataa);
			$kataa = $this->hapuspp($kataa);
			$kataa = $this->hapusawalan1($kataa);
			$kataa = $this->hapusakhiran($kataa);
			$kataa = $this->hapusawalan2($kataa);

			return $kataa;
		  
		}
		public function cari($kata){
			// $dbServer = "localhost";
			// $dbUser = "root";
			// $dbPass = "";
			// $dbName = "tesonline";
			// $dbKon = mysqli_connect($dbServer, $dbUser, $dbPass, $dbName);
			// $hasil = mysqli_num_rows(mysqli_query($dbKon, "SELECT * FROM tb_katadasar WHERE katadasar='$kata'")); //membuat variabel $hasil untuk menampilkan hasil mengambil kata dasar dari database
			

			$katadasar = $this->katadasar();
			if(in_array($kata, $katadasar)){
				$hasil = 1;
			} else {
				$hasil = 0;
			}
			return $hasil; //memberikan jawaban kata ada di database atau tidak
		}


		//langkah 1 - hapus partikel
		public function hapuspartikel($kata){
			if($this->cari($kata)!=1){
				if((substr($kata, -3) == 'kah' )||( substr($kata, -3) == 'lah' )||( substr($kata, -3) == 'pun' )){
					$kata = substr($kata, 0, -3);   
				}
			}
			return $kata;
		}

		//langkah 2 - hapus possesive pronoun
		public function hapuspp($kata){
			if($this->cari($kata)!=1){
				if(strlen($kata) > 4){
					if((substr($kata, -2)== 'ku')||(substr($kata, -2)== 'mu')){
						$kata = substr($kata, 0, -2);
					} else if((substr($kata, -3)== 'nya')){
						$kata = substr($kata,0, -3);
					}
				}
			}
			return $kata;
		}

		//langkah 3 hapus first order prefiks (awalan pertama)
		public function hapusawalan1($kata){
			if($this->cari($kata)!=1){
				if(substr($kata,0,4)=="meng"){
					if(substr($kata,4,1)=="e"||substr($kata,4,1)=="u"){
						$kata = substr($kata,4);
					}else{
						$kata = substr($kata,4);
					}
				}else if(substr($kata,0,4)=="meny"){
					$kata = "s".substr($kata,4);
				}else if(substr($kata,0,3)=="men"){
					$kata = "t".substr($kata,3);
				}else if(substr($kata,0,3)=="mem"){
					if(substr($kata,3,1)=="a"){
						$kata = "m".substr($kata,3);
					} else if(substr($kata,3,2)=="in"){
						$kata = "m".substr($kata,3);
					} else if(substr($kata,3,1)=="i"){
						$kata = "p".substr($kata,3);
					} else{
						$kata = substr($kata,3);
					}
				} else if(substr($kata,0,2)=="me"){
					$kata = substr($kata,2);
				} else if(substr($kata,0,4)=="peng"){
					if(substr($kata,4,1)=="e" || substr($kata,4,1)=="a"){
						$kata = "k".substr($kata,4);
					}else{
						$kata = substr($kata,4);
					}
				} else if(substr($kata,0,4)=="peny"){
					$kata = "s".substr($kata,4);
				}else if(substr($kata,0,3)=="pen"){
					if(substr($kata,3,1)=="a" || substr($kata,3,1)=="i" || substr($kata,3,1)=="e" || substr($kata,3,1)=="u" || substr($kata,3,1)=="o"){
						$kata = "t".substr($kata,3);
					}else{
						$kata = substr($kata,3);
					}
				}else if(substr($kata,0,3)=="pem"){
					if(substr($kata,3,1)=="a" || substr($kata,3,1)=="i" || substr($kata,3,1)=="e" || substr($kata,3,1)=="u" || substr($kata,3,1)=="o"){
						$kata = "p".substr($kata,3);
					}else{
						$kata = substr($kata,3);
					}
				}else if(substr($kata,0,2)=="di"){
					$kata = substr($kata,2);
				}else if(substr($kata,0,3)=="ter"){
					$kata = substr($kata,3);
				}else if(substr($kata,0,2)=="ke"){
					$kata = substr($kata,2);
				}
			}

			return $kata;
		}


		//langkah 4 hapus second order prefiks (awalan kedua)
		public function hapusawalan2($kata){
			$kataasli = $kata;
			if($this->cari($kata)!=1){
				if(substr($kata,0,3)=="ber"){
					$kata = substr($kata,3);
					if($this->cari($kata)!=1){
						$kata = $kataasli;
						$kata = substr($kata,2);
					}
				}else if(substr($kata,0,3)=="bel"){
					$kata = substr($kata,3);
				}else if(substr($kata,0,2)=="be"){
					$kata = substr($kata,2);
				}else if(substr($kata,0,3)=="per" && strlen($kata) > 5){
					$kata = substr($kata,3);
				}else if(substr($kata,0,2)=="pe"  && strlen($kata) > 5){
					$kata = substr($kata,2);
				}else if(substr($kata,0,3)=="pel"  && strlen($kata) > 5){
					$kata = substr($kata,3);
				}else if(substr($kata,0,2)=="se"  && strlen($kata) > 5){
					$kata = substr($kata,2);
				}
			}

			return $kata;
		}


		////langkah 5 hapus suffiks
		public function hapusakhiran($kata){
			if($this->cari($kata)!=1){
				if (substr($kata, -3)== "kan" ){
					$kata = substr($kata, 0, -3);
				} else if(substr($kata, -1)== "i" ){
					$kata = substr($kata, 0, -1);
				} else if(substr($kata, -2)== "an"){
					$kata = substr($kata, 0, -2);
				}
			} 
			return $kata;
		}
	}
?>