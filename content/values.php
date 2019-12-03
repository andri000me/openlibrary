<?php
 
$con = mysql_connect("localhost","root","administrator");
 
if (!$con) {
die('Could not connect: ' . mysql_error());
}
 
mysql_select_db("library_unpi", $con);
 
$result = mysql_query("SELECT * FROM `peminjaman` ") or die ("Error");
 
while($row = mysql_fetch_array($result)) {
echo $row['tgl_pinjam'] . "/" . $row['jml_buku']. "/" ;
}
 
mysql_close($con);
?>