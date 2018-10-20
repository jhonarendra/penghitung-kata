<?php
	$starttime = microtime(true);
	include 'fungsi.php';
	set_time_limit(0);
?>

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
									echo $plain_text;
								?>
							</p>
						</div>
					</div>
					<div id="word-count">
						<h2 style="float: left">Jumlah Kata</h2>
						<p style="text-align: right;padding: 20px;font-size: 40px"><?php echo $wordcount;?></p>
					</div>
				</div>

				<div class="col-3">
					<div id="stopwordlist">
						<h2>Stopword List</h2>
						<div class="scroll">
							<p style="padding: 20px;line-height: 1.5em">
								<?php
									foreach ($stopwordlist as $stopwordlists) {
										echo $stopwordlists." ";
									};
								?>
							</p>
						</div>
					</div>
					<div id="wordlist">
						<h2>Word List</h2>
						<div class="scroll">
							<p style="padding: 20px;line-height: 1.5em">
								<?php
									foreach ($wordlist as $wordlists) {
										echo $wordlists." ";
									};
								?>
							</p>
						</div>
					</div>
					<div id="jenis-kata">
						<h2 style="float: left">Jumlah Token</h2>
						<p style="text-align: right;padding: 20px;font-size: 40px">
							<?php
								echo count($wordlist);
							?>
						</p>
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