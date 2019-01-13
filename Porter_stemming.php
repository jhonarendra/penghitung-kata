<?php
	$starttime = microtime(true);
	include 'fungsi.php';
	set_time_limit(0);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Aplikasi Porter Stemming Bahasa Indonesia</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<div id="header">
		<h1><a href="">Aplikasi Porter Stemming Bahasa Indonesia</a></h1>
	</div>
	<div id="content">
		<?php
			if(!isset($_POST["submit"])) {
		?>
		<div class="col-6 form">
			<div id="form">
				<h2>Masukkan Kata</h2>
				<form action="" method="POST">
					<input type="text" name="kata" placeholder="Kata">
					<input type="submit" name="submit" value="kirim">
				</form>
			</div>
		</div>
		<?php

			} else {
				$contents = new NLP;

				$plain_text = $_POST['kata'];

				$content = $contents->tokenisasi($plain_text); // $content = kata yg sudah ditokenisasi, misahkan kata2

				$wordcount = count($content);
				$statsplain = $contents->tf_plain($content); //TF
				$statsstop = $contents->tf_stopword($content); //TF
				$statsstem = $contents->tf_stemming($content); //TF
				

		?>

		<div class="col-6 form">
			<div id="form">
				<h2>Masukkan Kata</h2>
				<form action="" method="POST">
					<input type="text" name="kata" placeholder="Kata">
					<input type="submit" name="submit" value="kirim">
				</form>
			</div>
		</div>

		<div class="col-6 form">
			<div id="table">

				<div class="header">
					<h2>Term Frequency</h2>
					<div class="tab-button">
						<div id="tab3" class="col-4" style="width: 100%" onclick="showpage3()"><a href="javascript:void(0)">Stemming</a></div>
						<div style="clear:both"></div>
					</div>
				</div>
				<div class="tab-content">
					<div id="page3" style="display: block;">
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
</body>
</html>