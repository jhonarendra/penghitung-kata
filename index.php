<?php

	$content = file_get_contents('korpus1.txt'); // Diambil file text
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
			// tes echo $phrase." = ".$results[$phrase]."<br />";

			if (!isset($results[$phrase])){
				$results[$phrase] = 1;
			} else {
				$results[$phrase]++;
			}
		}

		array_multisort($results, SORT_DESC); //mengurutkan dari frekuensi besar ke kecil
		return $results;
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<table border=1>
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
					echo "
					<tr>
						<td>$i</td>
						<td>$term</td>
						<td>$count</td>
					</tr>";
					$i++;
				}
			}
		?>
	</table>
</body>
</html>





