<?php 
 //Include Koneksi

 //Membuat Query
 $k = mysql_query("SELECT * FROM peminjaman");
 $q = mysql_query("SELECT date_format(tgl_pinjam,'%b') as bulan from peminjaman");
?>

<!-- File yang diperlukan dalam membuat chart -->

<div id="view" style="min-width: 310px; height: 400px; margin: 0 auto"></div>