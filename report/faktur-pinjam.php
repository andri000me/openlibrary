<?php 
require('../content/conn.php');
date_default_timezone_set('Asia/Jakarta');
function tgl($date){
    $exp = explode('-', $date);
    if (count($exp) == 3){
      $date = $exp[2].'/'.$exp[1].'/'.$exp[0];
   }   
   return $date;
 }

function tampil_faktur(){
$today  = date("Ymd");
$q      = mysql_query("SELECT max(kd_pinjam) AS last FROM peminjaman WHERE kd_pinjam LIKE '$today%'") or die(mysql_error());
$d      = mysql_fetch_array($q);
$last   = $d[0];

$q2     = mysql_query("SELECT * FROM peminjaman WHERE kd_pinjam = '$last'") or die(mysql_error());
$d2     = mysql_fetch_array($q2);
            ?>
    
  </p>
  <div align="center">
        <h2>Bukti Peminjaman Buku </h2>
    <table border="1" cellpadding="0" cellspacing="0" width="50%">
        <tr>
          <th width="30%" align="left">Kode Pinjam</th>
          <th width="17%" align="center"><?php echo $d2['kd_pinjam'];?></th>
          <th width="10%" >&nbsp;</th>
          <th width="18%" >Nama Anggota</th>
          <th width="16%" ><?php $qm = mysql_query("SELECT nama FROM anggota WHERE kd_mem = '$d2[kd_member]'");
                                          $dm = mysql_fetch_array($qm);
                                         echo $dm['nama'];?></th>
        </tr>
        <tr>
          <th align="left">Tanggal Pinjam</th>
          <th align="center"><?php echo tgl($d2['tgl_pinjam']); ?></th>
          <th>&nbsp;</th>
          <th>Nama Petugas</th>
          <th><?php  $ql = mysql_query("SELECT nama FROM petugas WHERE kd_petugas = '$d2[kd_petugas]'");
                                          $dl = mysql_fetch_array($ql);
                                         echo $dl['nama'];?></th>
        </tr>
        <tr>          
          <th colspan="5">-----------------------------------------------------------------------------------------------------------------------------</th>
        </tr>
        </table>
        <table border="1" cellpadding="0" cellspacing="0" width="50%">
        <tr>
            <th>#</th>
            <th>Judul Buku</th>
            <th>Pengarang</th>
            <th>Tgl Kembali</th>
        </tr>
    </thead>
    <?php
       $kds = $d[0];
	   $i = 1;
	   $dat = mysql_query("SELECT * FROM detail_pinjam WHERE kd_pinjam = '$kds'") or (mysql_error());
	   while($data = mysql_fetch_array($dat)){
	   $id_buku=$data['kd_buku'];
    ?>
    <tbody>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php $bk = mysql_query("SELECT * FROM buku WHERE kd_buku = '$id_buku'") or (mysql_error());
					  $buku=mysql_fetch_array($bk);
					  echo $buku['judul']; ?></td>
            <td align="center"><?php  $ql = mysql_query("SELECT nama FROM pengarang WHERE kd_pengarang = '$buku[kd_pengarang]'");
                                          $dl = mysql_fetch_array($ql);
                                         echo $dl['nama']; ?></td>
            <td align="center"> <?php echo tgl($data['tgl_hrs_kem']);?></td>
        </tr>
    </tbody>
    <?php
        }
    
    ?>
</table>
</div>
<?php
}

if (isset($_POST['tampil_faktur'])){ tampil_faktur();}
?>