<?php
	/**
	 * 
	 */
	class Stemming {
		public function stem($input){
			$input = $this->tokenisasi($input);
			$i=0;
			$results[] = null;
			$stop = null;
			foreach ($input as $key=>$word) {
				$phrase = strtolower($input[$key]);
				$a = $this->stopwords();
				foreach ($a as $banned){
					if($banned == $phrase){
						$stop = $banned;
					}
				}
				if ($stop == $phrase){

				} else {
					// $phrase = $this->porterkamus($phrase);
					$phrase = $this->porter($phrase);
					$results[$i] = $phrase;
					$i++;
				}
			}
			return $results;
		}
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

		public function porter($kata){
			$kata = $this->hapuspartikel($kata);
			$kata = $this->hapuspp($kata);
			$kata1 = $kata;
			$kata = $this->hapusawalan1($kata);
			$kata = $this->hapusawalan2($kata);
			$kata = $this->hapusakhiran($kata);
			$kata2 = $kata;
			$kata = $this->hapusakhiran($kata);
			$kata = $this->hapusawalan2($kata);
			return $kata;			
		}

		public function porterkamus($kata){
			if($this->cari($kata)!=1){
				$kata = $this->hapuspartikel($kata);
			}
			if($this->cari($kata)!=1){
				$kata = $this->hapuspp($kata);
			}

			$kata1 = $kata;

			if($this->cari($kata)!=1){
				$kata = $this->hapusawalan1($kata);
			}

			if($kata1==$kata){
				if($this->cari($kata)!=1){
					$kata = $this->hapusawalan2($kata);
				}
				if($this->cari($kata)!=1){
					$kata = $this->hapusakhiran($kata);
				}
			} else {
				$kata2 = $kata;
				if($this->cari($kata)!=1){
					$kata = $this->hapusakhiran($kata);
				}
				if($this->cari($kata)!=1){
					if($kata2 = $kata){
						$kata = $this->hapusawalan2($kata);
					}
				}
			}
			return $kata;			
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
			if((substr($kata, -3) == 'kah' )||( substr($kata, -3) == 'lah' )||( substr($kata, -3) == 'pun' )){
				$kata = substr($kata, 0, -3);   
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
				if(substr($kata,4,1)=="e"){
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
			return $kata;
		}


		//langkah 4 hapus second order prefiks (awalan kedua)
		public function hapusawalan2($kata){
			$kataasli = $kata;
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
			return $kata;
		}


		////langkah 5 hapus suffiks
		public function hapusakhiran($kata){
			if (substr($kata, -3)== "kan" ){
				$kata = substr($kata, 0, -3);
			} else if(substr($kata, -1)== "i" ){
				$kata = substr($kata, 0, -1);
			} else if(substr($kata, -2)== "an"){
				$kata = substr($kata, 0, -2);
			}
			return $kata;
		}
	}
?>