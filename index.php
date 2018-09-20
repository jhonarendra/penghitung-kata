<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<table>
		<tr>
			<td>TERM</td>
			<td>FREKUENSI</td>
		</tr>
	<?php
		$kalimat = file_get_contents('teks.txt');
		$kalimat_array = explode(" ",$kalimat);
		foreach($kalimat_array as $value){
		    if(isset($str_count[$value]))
				$str_count[$value]++;
			else
				$str_count[$value]=1;
		}
		foreach($str_count as $key => $value){
	?>
		<tr>
			<td>
			<?php 
				$teks = explode(",",$key);
				foreach($teks as $tekss){
					echo strtolower($tekss);
				}
				
			?>
			</td>
			<td><?php echo $value ?></td>
		</tr>
	<?php   
		}
	?>
	</table>
</body>
</html>