<!-- Porter stemming
Langkah-Langkah Algortima pada Porter Stemmer.
1. Menghapus Partikel seperti: kah, lah, tah
2. Menghapus Kata ganti (Possesive Pronoun), seperti ku, mu, nya
3. Menghapus awalan pertama. Jika tidak ditemukan, maka lanjut ke langkah 4a, dan jika ada maka lanjut ke langkah 4b.
4. a. Menghapus Awalan kedua, dan dilanjutkan pada langkah 5a
b. Menghapus akhiran, jika tidak ditemukan maka kata tersebut diasumsikan sebagai kata dasar (rootword). Jika ditemukan maka lanjut ke langkah 5b.
5. a. Menghapus akhiran dan kata akhir diasumsikan sebagai kata dasar (root word).
b. Menghapus awalan kedua dan kata akhir diasumsikan sebagai kata dasar (root word)
 -->


<?php



$kataa = $_GET['q'];




echo porter($kataa);

function porter($kataa){
// Porter stemming
// Langkah-Langkah Algortima pada Porter Stemmer.
// 1. Menghapus Partikel seperti: kah, lah, tah
// 2. Menghapus Kata ganti (Possesive Pronoun), seperti ku, mu, nya
// 3. Menghapus awalan pertama. Jika tidak ditemukan, maka lanjut ke langkah 4a, dan jika ada maka lanjut ke langkah 4b.
// 4. a. Menghapus Awalan kedua, dan dilanjutkan pada langkah 5a
// b. Menghapus akhiran, jika tidak ditemukan maka kata tersebut diasumsikan sebagai kata dasar (rootword). Jika ditemukan maka lanjut ke langkah 5b.
// 5. a. Menghapus akhiran dan kata akhir diasumsikan sebagai kata dasar (root word).
// b. Menghapus awalan kedua dan kata akhir diasumsikan sebagai kata dasar (root word)



$kataa = hapuspartikel($kataa);
$kataa = hapuspp($kataa);
$kataa = hapusawalan1($kataa);
$kataa = hapusawalan2($kataa);
$kataa = hapusakhiran($kataa);

return $kataa;




  // if (hapuspartikel($kataa)!==null) {
  //   return hapuspartikel($kataa);
  // } else if(hapuspp($kataa)!==null){
  //   return hapuspp($kataa);
  // } else if(hapusawalan1($kataa)!==null){
  //   return hapusawalan1($kataa);
  // } else if (hapusawalan2($kataa)!==null) {
  //   return hapusawalan2($kataa);
  // } else if(hapusakhiran($kataa)!==null){
  //   return hapusakhiran($kataa);
  // } else {
  //   return $kataa;
  // }
  
}

function cari($kata){
  $dbServer = "localhost";
  $dbUser = "root";
  $dbPass = "";
  $dbName = "tesonline";
  $dbKon = mysqli_connect($dbServer, $dbUser, $dbPass, $dbName); 
 $hasil = mysqli_num_rows(mysqli_query($dbKon, "SELECT * FROM tb_katadasar WHERE katadasar='$kata'")); //membuat variabel $hasil untuk menampilkan hasil mengambil kata dasar dari database
 return $hasil; //mengeksekusi variabel $hasil
}
//langkah 1 - hapus partikel
function hapuspartikel($kata){
if(cari($kata)!=1){
 if((substr($kata, -3) == 'kah' )||( substr($kata, -3) == 'lah' )||( substr($kata, -3) == 'pun' )){
  $kata = substr($kata, 0, -3);   
  }
 }
 return $kata;

}

//langkah 2 - hapus possesive pronoun
function hapuspp($kata){
if(cari($kata)!=1){
 if(strlen($kata) > 4){
 if((substr($kata, -2)== 'ku')||(substr($kata, -2)== 'mu')){
  $kata = substr($kata, 0, -2);
 }else if((substr($kata, -3)== 'nya')){
  $kata = substr($kata,0, -3);
 }
  }
}

  return $kata;
}

//langkah 3 hapus first order prefiks (awalan pertama)
function hapusawalan1($kata){
if(cari($kata)!=1){

 if(substr($kata,0,4)=="meng"){
  if(substr($kata,4,1)=="e"||substr($kata,4,1)=="u"){
  $kata = "k".substr($kata,4);
  }else{
  $kata = substr($kata,4);
  }
 }else if(substr($kata,0,4)=="meny"){
  $kata = "s".substr($kata,4);
 }else if(substr($kata,0,3)=="men"){
  $kata = "t".substr($kata,3);
 }
 /*else if(substr($kata,0,3)=="mem"){
  if(substr($kata,3,1)=="a" || substr($kata,3,1)=="i" || substr($kata,3,1)=="e" || substr($kata,3,1)=="u" || substr($kata,3,1)=="o"){
   if(substr($kata,3,1)=="a" || substr($kata,3,1)=="i" || substr($kata,3,1)=="e" || substr($kata,3,1)=="u" || substr($kata,3,1)=="o"){
   $kata = "m".substr($kata,3);
   }
  }else{
   $kata = substr($kata,3);
  }
 }*/
 else if(substr($kata,0,3)=="mem"){
  if(substr($kata,3,1)=="a"){
  $kata = "m".substr($kata,3);
  }
  else if(substr($kata,3,2)=="in"){
  $kata = "m".substr($kata,3);
  }
  else if(substr($kata,3,1)=="i"){
  $kata = "p".substr($kata,3);
  }
  else{
   $kata = substr($kata,3);
  }
 }
 else if(substr($kata,0,2)=="me"){
  $kata = substr($kata,2);
 }else if(substr($kata,0,4)=="peng"){
  if(substr($kata,4,1)=="e" || substr($kata,4,1)=="a"){
  $kata = "k".substr($kata,4);
  }else{
  $kata = substr($kata,4);
  }
 }else if(substr($kata,0,4)=="peny"){
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
function hapusawalan2($kata){
if(cari($kata)!=1){
  
 if(substr($kata,0,3)=="ber"){
  $kata = substr($kata,3);
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
function hapusakhiran($kata){
if(cari($kata)!=1){

 if (substr($kata, -3)== "kan" ){
  $kata = substr($kata, 0, -3);
 }
 else if(substr($kata, -1)== "i" ){
     $kata = substr($kata, 0, -1);
 }else if(substr($kata, -2)== "an"){
  $kata = substr($kata, 0, -2);
 }
} 

  return $kata;
}

?> 