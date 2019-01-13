<?php
	$starttime = microtime(true);
	include 'fungsi.php';
	set_time_limit(0);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Natural Language Processing</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<div id="header">
		<h1><a href="">Natural Language Processing</a></h1>
		<p style="margin-top:10px"><a target="_blank" href="porter_stemming.php" style="color:rgba(255,255,255,0.8);text-decoration: none">Uji Stemming</a> - <a target="_blank" href="peringkas.php" style="color:rgba(255,255,255,0.8);text-decoration: none">Perhitungan TF-IDF</a> - <a target="_blank" href="demo.html" style="color:rgba(255,255,255,0.8);text-decoration: none">Demo</a></p>
	</div>
	<div id="content">
		<?php
			if(!isset($_POST["submit"])) {
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
		<?php

			} else {
				$plain_text = $_FILES["file"]["tmp_name"];
				$plain_text = file_get_contents($plain_text); // Diambil file text

				$contents = new NLP;

				$content = $contents->tokenisasi($plain_text); // $content = kata yg sudah ditokenisasi, misahkan kata2

				$wordcount = count($content);
				$stopwordlist = $contents->stopwordlist($content);
				$wordlist = $contents->wordlist($content);
				$typelist = $contents->typelist($content);
				$statsplain = $contents->tf_plain($content); //TF
				$statsstop = $contents->tf_stopword($content); //TF
				$statsstem = $contents->tf_stemming($content); //TF


				/*
				 * RINGKASAN
				 */
				$ringkasan = explode(PHP_EOL, $plain_text);

				$jml_paragraf = count($ringkasan);

				$paragraf = array();
				$kalimat = array();
				$plain_kalimat = array();

				// untuk mendapatkan array tf per kalimat
				foreach ($ringkasan as $key => $value) {
					$paragraf[$key] = $value;
					$paragraf[$key] = explode(".", $paragraf[$key]);
					$paragraf[$key] = array_slice($paragraf[$key], 0, sizeof($paragraf[$key])-1);
					$jml_kalimat[$key] = count($paragraf[$key]);
					foreach ($paragraf[$key] as $key2 => $value2) {
						$kalimat[$key][$key2] = $value2;
						$plain_kalimat[$key][$key2] = $value2;
						// $kalimat[$key][$key2] = $textproc->stem($kalimat[$key][$key2]);
						$kalimat[$key][$key2] = $contents->listStemming($kalimat[$key][$key2]);
						$kalimat[$key][$key2] = array_count_values($kalimat[$key][$key2]);	
					}
				}

				// tf perkalimat itu digabung jadi per paragraf
				for ($i=0; $i < $jml_paragraf; $i++) { 
					$j = 0;
					if(!empty($kalimat[$i])){
						foreach ($kalimat[$i] as $key => $value) {
							foreach ($value as $key2 => $value2) {
								$term_paragraf[$i][$j] = $key2;
								$j++;
							}
						}
						$term_paragraf[$i] = array_count_values($term_paragraf[$i]);
					}
					
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


				
				for ($h=0; $h < $jml_paragraf; $h++) {
					for ($i=0; $i < $jml_kalimat[$h]; $i++) {
						$j = 0;
						foreach ($tf[$h][$i] as $key) {
							$tf[$h][$i][$j] = $key;
							// echo $tf[$h][$i][$j]." ";
							$j++;
						}
						// echo "<br />";
					}
					// echo "<br /><br />";
				}

				// hitung jumlah kalimat yg mengandung term
				for ($h=0; $h < $jml_paragraf; $h++) {
					$j = 0;
					if(!empty($tf[$h][$j])){
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
				}

				// nampilin jumlah kalimat yg mengandung term
				

				// $tes = 1*log(1/2);
				// echo "Hasil TF IDF<br />".$tes;
				for ($h=0; $h < $jml_paragraf; $h++) {
					// echo "Paragraf ".$h."<br />";
					for ($i=0; $i < $jml_kalimat[$h]; $i++) { 
						for ($j=0; $j < count($cek[$h]) ; $j++) { 
							$tfidf[$h][$i][$j] = $tf[$h][$i][$j]*log10($jml_kalimat[$h]/$cek[$h][$i]);
							// echo $tfidf[$h][$i][$j]." | ";
						}
						// echo "<br />";
					}
					// echo "<br /><br />";
				}

				// echo "Menghitung Bobot Kalimat<br />";
				for ($h=0; $h < $jml_paragraf; $h++) {
					for ($i=0; $i < $jml_kalimat[$h]; $i++) { 
						$tfidfkalimat[$h][$i] = 0;
						for ($j=0; $j < count($cek[$h]) ; $j++) {
							$tfidfkalimat[$h][$i] = $tfidfkalimat[$h][$i]+$tfidf[$h][$i][$j];
						}
					}
				}

				
				// echo "<br />Hasil ringkasan:<br />";
				$hasil_ringkasan = null;
				for ($h=0; $h < $jml_paragraf; $h++) {
					for ($i=0; $i < $jml_kalimat[$h]; $i++) {
						if (max($tfidfkalimat[$h])==$tfidfkalimat[$h][$i]) {
							// echo $plain_kalimat[$h][$i].". ";
							$hasil_ringkasan = $hasil_ringkasan." ".$plain_kalimat[$h][$i].". ";
						}
					}
				}
				

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

		<div class="scrollable">
			<div class="nowrap-content">
				<div class="col-3">
					<div id="isi">
						<h2>Isi Konten</h2>
						<div class="scroll">
							<p style="padding:20px;line-height: 1.5em">
								<?php
									foreach ($ringkasan as $key) {
										echo $key."<br />";
									}
								?>
							</p>
						</div>
					</div>
					<div id="word-count">
						<h2 style="float: left">Jumlah Kata</h2>
						<p style="text-align: right;padding: 20px;font-size: 40px"><?php echo $wordcount;?></p>
					</div>
					<div id="stopwordlist">
						<h2>Stopword List</h2>
						<div class="scroll">
							<p style="padding: 20px;line-height: 1.5em">
								<?php
									if(count($stopwordlist)==0){
										echo "Tidak ada stopword";
									}
									foreach ($stopwordlist as $stopwordlists) {
										echo $stopwordlists." ";
									};
								?>
							</p>
						</div>
					</div>
				</div>

				<div class="col-3">
					<div id="table">

						<div class="header">
							<h2>Term Frequency</h2>
							<div class="tab-button">
								<div id="tab1" class="col-4 active" onclick="showpage1()"><a href="javascript:void(0)">Plain</a></div>
								<div id="tab2" class="col-4" onclick="showpage2()"><a href="javascript:void(0)">Stopwords</a></div>
								<div id="tab3" class="col-4" onclick="showpage3()"><a href="javascript:void(0)">Stemming</a></div>
								<div style="clear:both"></div>
							</div>
						</div>
						<div class="tab-content">
							<div id="page1" style="display: block;">
								<div class="scroll">
									<table>
										<tr>
											<th>Peringkat</th>
											<th>Kata</th>
											<th>Frekuensi</th>
										</tr>
										<?php

											$i=1;
											foreach ($statsplain as $term => $count) {
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
							<div id="page2" style="display: none;">
								<div class="scroll">
									<table>
										<tr>
											<th>Peringkat</th>
											<th>Kata</th>
											<th>Frekuensi</th>
										</tr>
										<?php

											$i=1;
											foreach ($statsstop as $term => $count) {
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
							<div id="page3" style="display: none;">
								<div class="scroll">
									<table>
										<tr>
											<th>Peringkat</th>
											<th>Kata</th>
											<th>Frekuensi</th>
										</tr>
										<?php

											$i=1;
											foreach ($statsstem as $term => $count) {
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
					</div>
				</div>

				<div class="col-3">
					<div id="typelist">
						<h2>Type List</h2>
						<div class="scroll">
							<p style="padding: 20px;line-height: 1.5em">
								<?php
									$jumlah_jenis = 0;
									foreach ($typelist as $term=>$count) {
										echo $term." ";
										$jumlah_jenis++;
									}
								?>
							</p>
						</div>
					</div>
					<div id="jenis">
						<h2 style="float: left">Jumlah Jenis</h2>
						<p style="text-align: right;padding: 20px;font-size: 40px"><?php echo $jumlah_jenis;?></p>
					</div>
					<div id="wordlist">
						<h2>Word List</h2>
						<div class="scroll">
							<p style="padding: 20px;line-height: 1.5em">
								<?php
									if(count($wordlist)==0){
										echo "Tidak ada wordlist";
									} else {
										foreach ($wordlist as $wordlists) {
											echo $wordlists." ";
										}
									}
								?>
							</p>
						</div>
					</div>
					<div id="jenis-kata">
						<h2 style="float: left">Jumlah Token</h2>
						<p style="text-align: right;padding: 20px;font-size: 40px">
							<?php
								if(count($wordlist)==0){
									echo "0";
								} else {
									echo count($wordlist);
								}
							?>
						</p>
					</div>
				</div>

				<div class="col-3">
					<div id="bobot-kalimat">
						<h2>Bobot Perkalimat</h2>
						<div class="scroll">
								<?php
									$paraCounter = 1;
									for ($h=0; $h < $jml_paragraf; $h++) {
										if (!empty($ringkasan[$h])) {
											echo "<br /><p style='padding:10px'><b>Paragraf ".$paraCounter."</b></p>";
											$kalimatCounter = 1;
											echo "<table>
											<tr>
											<th>No.</th>
											<th>Kalimat</th>
											<th>Bobot</th>
											</tr>";
											for ($i=0; $i < $jml_kalimat[$h]; $i++) { 
												echo "<tr>
												<td>".$kalimatCounter."</td>";
												echo "<td style='text-align: left'>".$plain_kalimat[$h][$i]."</td>
												<td>".substr($tfidfkalimat[$h][$i], 0, 5)."</td>
												</tr>";
												$kalimatCounter++;
											}
											$paraCounter++;
											echo "</table>";
											echo "<br /><br />";
										}
									}
								?>
						</div>
					</div>
					<div id="ringkasan">
						<h2>Ringkasan</h2>
						<div class="scroll">
							<p style="padding:20px;line-height: 1.5em">
								<?php
									echo $hasil_ringkasan;
								?>
							</p>
						</div>
					</div>
				</div>
				<div style="clear: both;"></div>
			</div><!-- END NOWRAP-CONTENT -->
		</div>
		<?php } ?>
	</div><!-- END CONTENT -->
	<footer>
		I Putu Iduar Perdana - I Wayan Gunaya - Putu Jhonarendra<br /><br />

	<?php
		$endtime = microtime(true);
		echo "Load time: ";
		echo $endtime-$starttime."s";
	?>
	</footer>
	<script type="text/javascript">
		var page1 = document.getElementById('page1');
		var page2 = document.getElementById('page2');
		var page3 = document.getElementById('page3');

		var tab1 = document.getElementById('tab1');
		var tab2 = document.getElementById('tab2');
		var tab3 = document.getElementById('tab3');
		
		function showpage1(){
			tab1.classList.add("active");
			tab2.classList.remove("active");
			tab3.classList.remove("active");

			page3.style.display = "none";
			page2.style.display = "none";
			page1.style.display = "block";
		}
		function showpage2(){
			tab1.classList.remove("active");
			tab2.classList.add("active");
			tab3.classList.remove("active");

			page3.style.display = "none";
			page1.style.display = "none";
			page2.style.display = "block";
		}
		function showpage3(){
			tab1.classList.remove("active");
			tab2.classList.remove("active");
			tab3.classList.add("active");

			page1.style.display = "none";
			page2.style.display = "none";
			page3.style.display = "block";
		}
	</script>
</body>
</html>