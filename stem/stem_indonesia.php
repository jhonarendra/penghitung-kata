<?php

$dbServer = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "db_word";
$dbKon = mysqli_connect($dbServer, $dbUser, $dbPass, $dbName);


$word = $_POST['word'];

//STEP 1 (Cek Kamus partikel & partikel berprefiks)
$partikel = mysqli_query($dbKon, "SELECT * FROM dsr_partikel WHERE name ='$word'");
    if(mysqli_num_rows($partikel)==1){
	//langsung tulis
		$dasar = $word; 
		echo $dasar;
		exit;
	}else {
	    $partikel_berprefiks=mysqli_query($dbKon, "SELECT * FROM dsr_partikel_prefiks WHERE name='$word'");
	    if(mysqli_num_rows($partikel_berprefiks)==1 && strlen($word) > 4){
	     //hapus prefiks
			if(substr($word,0,4)=="meng" or substr($word,0,4)=="peng"){
				echo substr($word,4);
			}else if(substr($word,0,4)=="meny" or substr($word,0,4)=="peny"){
				$dasar =substr($word,4);
				echo "s".$dasar;
			}else if(substr($word,0,3)=="mel" or substr($word,0,3)=="mer" or substr($word,0,3)=="mew" or substr($word,0,3)=="mey"){
			    echo substr($word,2);
			}else if(substr($word,0,2)=="di"){
			    echo substr($word,2);	
			}else if(substr($word,0,3)=="mem" or substr($word,0,3)=="pem"){
				  if(substr($word,3,1)=="a" or substr($word,3,1)=="i" or substr($word,3,1)=="u" or substr($word,3,1)=="e" or substr($word,3,1)=="o"){
				      $dasar =substr($word,3);
				      echo "p".$dasar;
				  }else{
				      $dasar =substr($word,3);
					  echo $dasar;}
			}else if(substr($word,0,3 == "pel")){
				$dasar =substr($word,4);
				echo $dasar;
				}
		    else if(substr($word,0,3)=="men" or substr($word,0,3)=="pen" ){
				$dasar =substr($word,3);
				echo "t".$dasar;
			}
			exit;
	    } else{
		//hapus partikel
		   if((substr($word, -3) == 'kah' )||( substr($word, -3) == 'lah' )||( substr($word, -3) == 'pun' )||( substr($word, -3) == 'tah' )){
	            $word2 = substr($word, 0, -3);}
		   else{
		        $word2 = $word;
				
		   }
         // echo "Penghapusan partikel = ".$word2."<br>";		   
		}
    }
//STEP 2 (Cek Kamus milik & milik berprefiks)		
$milik = mysqli_query($dbKon, "SELECT * FROM dsr_milik WHERE name='$word2'");
	if(mysqli_num_rows($milik)==1){
	//langsung tulis
		$dasar =$word2; 
		echo $dasar;
		exit;
	}else {
	  $milik_berprefiks = mysqli_query($dbKon, "SELECT * FROM dsr_milik_prefiks WHERE name='$word2'");
	  if(mysqli_num_rows($milik_berprefiks)==1 && strlen($word2) > 4){
	     //hapus prefiks
		 if(substr($word2,0,4)=="meng" or substr($word2,0,4)=="peng"){
				echo substr($word2,4);
			}else if(substr($word2,0,4)=="meny" or substr($word2,0,4)=="peny"){
				$dasar =substr($word2,4);
				echo "s".$dasar;
			}else if(substr($word2,0,3)=="mel" or substr($word2,0,3)=="mew" or substr($word2,0,3)=="mer" or substr($word2,0,3)=="mey"){
			    echo substr($word2,2);
			}else if(substr($word2,0,2)=="di"){
			    echo substr($word2,2);	
			}else if(substr($word2,0,3)=="mem" or substr($word2,0,3)=="pem" ){
				  if(substr($word2,3,1)=="a" or substr($word2,3,1)=="i" or substr($word2,3,1)=="u" or substr($word2,3,1)=="e" or substr($word2,3,1)=="o"){
				      $dasar =substr($word2,3);
				      echo "p".$dasar;
				  }else{
				      $dasar =substr($word2,3);
					  echo $dasar;}
			}else if(substr($word2,0,3 == "pel")){
				$dasar =substr($word2,4);
				echo $dasar;
				
		    }else if(substr($word2,0,3)=="men" or substr($word2,0,3)=="pen" ){
				$dasar =substr($word2,3);
				echo "t".$dasar;
			}
			exit;
	  } else{
		//hapus milik
		   if((substr($word2, -2)== 'ku')||(substr($word2, -2)== 'mu')){
				$word3 = substr($word2, 0, -2);
		  }else if((substr($word2, -3)== 'nya')){
				$word3 = substr($word2,0, -3);
				}
		   else{
		        $word3 = $word2;
		   }
		   // echo "Penghapusan milik = ".$word3."<br>";
	  }
    }
//STEP 3 (Cek Kamus prefiks1 & perfiks1 bersufiks)		
$prefiks1 = mysqli_query($dbKon, "SELECT * FROM dsr_prefiks1 WHERE name='$word3'");

    if(mysqli_num_rows($prefiks1)==1){
	//langsung tulis
		$dasar =$word3; 
		echo $dasar;
		exit;
	}else {
	   $prefiks1_sufiks = mysqli_query($dbKon, "SELECT * FROM dsr_prefiks1_sufiks WHERE name='$word3'");
	   if(mysqli_num_rows($prefiks1_sufiks)==1 && strlen($word3) > 4){
	     //hapus sufiks
			if (substr($word4, -3)== 'kan'){
				$dasar = substr($word4, 0, -3);
				echo $dasar;}
		    elseif (substr($word4, -1)== 'i'){
			    $dasar = substr($word4, 0, -1);
				echo $dasar;}	
			elseif (substr($word4, -2)== 'an'){
				$dasar = substr($word4, 0, -2);
				echo $dasar;}
            exit;				
	} else{
		//hapus prefiks1
		   if(substr($word3,0,4)=="meng" or substr($word3,0,4)=="peng"){
				$word4 = substr($word3,4);
			}else if(substr($word3,0,4)=="meny" or substr($word3,0,4)=="peny"){
				$dasar = substr($word3,4);
				$word4 = "s".$dasar;
			}else if(substr($word3,0,3)=="mel" or substr($word3,0,3)=="mew" or substr($word3,0,3)=="mer" or substr($word3,0,3)=="mey"){
			     $word4 =  substr($word3,2);
		    }else if(substr($word3,0,2)=="di"){
			     $word4 = substr($word3,2);	
			}else if(substr($word3,0,3)=="mem" or substr($word2,0,3)=="pem"){
				  if(substr($word3,3,1)=="a" or substr($word3,3,1)=="i" or substr($word3,3,1)=="u" or substr($word3,3,1)=="e" or substr($word3,3,1)=="o"){
				      $dasar =substr($word3,3);
				      $word4 = "p".$dasar;
				  }else{
				      $dasar =substr($word3,3);
					  $word4 = $dasar;}
		    }else if(substr($word3,0,3 == "pel")){
				$dasar =substr($word3,4);
				echo $dasar;
				
		    }else if(substr($word3,0,3)=="men" or substr($word3,0,3)=="pen"){
				$dasar =substr($word3,3);
				$word4 = "t".$dasar;
			}else{
		        $word4 = $word3;
				
		   }
		   // echo "Penghapusan prefiks1= ".$word4."<br>";
		   
		}
	}
//STEP 4 (Cek Kamus prefiks2 & perfiks2 bersufiks)
$prefiks2 = mysqli_query($dbKon, "SELECT * FROM dsr_prefiks2 WHERE name='$word4'");

    if(mysqli_num_rows($prefiks2)==1){
	//langsung tulis
		$dasar =$word4; 
		echo $dasar;
		exit;
	}else {
	$prefiks2_sufiks = mysqli_query($dbKon, "SELECT * FROM dsr_prefiks2_sufiks WHERE name='$word4'");
	if(mysqli_num_rows($prefiks2_sufiks)==1 && strlen($word4) > 4){
	     //hapus sufiks
			if (substr($word4, -3)== 'kan'){
				$dasar = substr($word4, 0, -3);
				echo $dasar;}
		    elseif (substr($word4, -1)== 'i'){
			    $dasar = substr($word4, 0, -1);
				echo $dasar;}	
			elseif (substr($word4, -2)== 'an'){
				$dasar = substr($word4, 0, -2);
				echo $dasar;}
            exit;				
	} else{
		//hapus prefiks2
		   if(substr($word4,0,3)=="ber" or substr($word4,0,3)=="per"){
				$word5 = substr($word4,3);
			}else if(substr($word4,0,2)=="be"){
				if(substr($word4,3)=="ajar"){
				      $dasar =substr($word4,3);
				      $word5 = $dasar;
				}else{
				      $dasar =substr($word4,2);
					  $word5 = $dasar;}
			}else if(substr($word4,0,2)=="se" or substr($word4,0,2)=="ke"){
			         $word5 = substr($word4,2);
			}else if(substr($word4,0,3) == "pel" or substr($word4,0,3) == "ter"){
				      $word5 =substr($word4,3);
				}	
			else{
		               $word5 = $word4;
		   }
		   // echo "Penghapusan prefiks2= ".$word5."<br>";
		   
		}
	}
//STEP 5 (Cek Kamus prefiks2 & perfiks2 bersufiks)
$sufiks = mysqli_query($dbKon, "SELECT * FROM dsr_sufiks WHERE name='$word5'");
$prefiks2_sufiks = mysqli_query($dbKon, "SELECT * FROM dsr_prefiks2_sufiks WHERE name='$word5'");
	if(mysqli_num_rows($sufiks)==1){
	//langsung tulis
		$dasar =$word5; 
		echo $dasar;
		exit;
	}else{
	  //hapus sufiks
			if (substr($word5, -3)== 'kan' && strlen($word5) > 4){
				$dasar1 = substr($word5, 0, -3);
				}
		    elseif (substr($word5, -1)== 'i'){
			    $dasar1 = substr($word5, 0, -1);
				}	
			elseif (substr($word5, -2)== 'an'){
				$dasar1 = substr($word5, 0, -2);
				}
			echo $dasar1;	
			exit;
	}
	
?>