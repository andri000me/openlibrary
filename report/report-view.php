<?php
require('../content/function.php');
date_default_timezone_set('Asia/Jakarta');

if(isset($_POST['tampil_sewa'])){ tampil_sewa();}
elseif(isset($_POST['tampil_denda'])){ tampil_denda();}
elseif(isset($_POST['tampil_sewa_ex'])){ tampil_sewa_ex();}
elseif(isset($_POST['tampil_denda_ex'])){ tampil_denda_ex();}
else{ echo '<div align = "center"><h1>ERROR. HALAMAN YANG ANDA CARI TIDAK DITEMUKAN.</h5></div>';}

function tampil_sewa(){
if(!empty($_POST['tanggal']) AND !empty($_POST['tanggal1'])) {
$tgl_awal = tgl_sql($_POST['tanggal']);
$tgl_akhir= tgl_sql($_POST['tanggal1']);
$tgl1     = tgl($_POST['tanggal']);
$tgl2     = tgl($_POST['tanggal1']);
	?>
<div align="center">
	<table width="795" border="0">
      <tr>
        <td width="150" rowspan="3" align="left"><img src="../assets/img/logo2.png" width="150px" height="70" /></td>
        <td width="645" align="center">LAPORAN DATA PEMINJAMAN BUKU PERPUSTAKAAN</td>
      </tr>
      <tr>
        <td align="center"><?php echo "PERIODE TANGGAL $tgl1 SAMPAI DENGAN TANGGAL $tgl2"; ?></td>
      </tr>
      <tr>
        <td align="center"></td>
      </tr>
    </table>
	____________________________________________________________________________________________________<br />
	<br /><br />
    <table width="795" border="1" cellspacing="0" cellpadding="0">
      <tr>
       <th width="30" class="text-center">No.</th>
       <th width="100" class="text-center">Tanggal Pinjam</th>
       <th width="100" class="text-center">Petugas</th>
	     <th width="200" class="text-center">Anggota</th>
       <th width="300" class="text-center">Judul Buku</th>
       <th width="60" class="text-center">Denda</th>
       <th width="100" class="text-center">Status</th>
     </tr>
   <?php
    
   $no=1;
   $sum = 0 ;
   $query = mysql_query("SELECT * FROM detail_pinjam WHERE tgl_pinjam >= '$tgl_awal' AND tgl_pinjam <= '$tgl_akhir'") or die (mysql_error());
   while($data = mysql_fetch_array($query)){
    $sql = mysql_query("SELECT * FROM peminjaman WHERE kd_pinjam = '$data[kd_pinjam]'");
    $detail = mysql_fetch_array($sql);
    $sql_anggota = mysql_query("SELECT nama FROM anggota WHERE kd_mem = '$detail[kd_member]'");
    $detail_anggota = mysql_fetch_array($sql_anggota);
    $sql_petugas = mysql_query("SELECT nama FROM petugas WHERE kd_petugas = '$detail[kd_petugas]'");
    $detail_petugas = mysql_fetch_array($sql_petugas);
    $sql_buku = mysql_query("SELECT judul FROM buku WHERE kd_buku = '$data[kd_buku]'");
    $detail_buku = mysql_fetch_array($sql_buku);
   ?>
     <tr>
       <td align="center"><?php echo $no; ?></td>
       <td align="center"><?php echo tgl_sql($data['tgl_pinjam']); ?></td>
       <td align="center"><?php echo $detail_petugas['nama']; ?></td>
       <td align="center"><?php echo $detail_anggota['nama']; ?></td>
       <td align="left"><?php echo $detail_buku['judul']; ?></td>
       <td align="center"><?php echo $data['denda']; ?></td>
       <td align="center"><?php echo $data['status']; ?></td>
     </tr>
   <?php
   $no++;
   }
   ?>
   </table>
  </form>
  </div>
  <?php } else { echo "<div align=center>Error : Silahkan isi rentang tanggal</div>"; }
}

function tampil_denda(){
if(!empty($_POST['tanggal2']) AND !empty($_POST['tanggal3'])) {
$tgl_awal = tgl_sql($_POST['tanggal2']);
$tgl_akhir= tgl_sql($_POST['tanggal3']);
$tgl1     = tgl($_POST['tanggal2']);
$tgl2     = tgl($_POST['tanggal3']);
  ?>
<div align="center">
  <table width="795" border="0">
      <tr>
        <td width="150" rowspan="3" align="left"><img src="../assets/img/logo2.png" width="150px" height="70" /></td>
        <td width="645" align="center">LAPORAN DATA DENDA BUKU PERPUSTAKAAN</td>
      </tr>
      <tr>
        <td align="center"><?php echo "PERIODE TANGGAL $tgl1 SAMPAI DENGAN TANGGAL $tgl2"; ?></td>
      </tr>
      <tr>
        <td align="center"></td>
      </tr>
    </table>
  ____________________________________________________________________________________________________<br />
  <br /><br />
    <table width="795" border="1" cellspacing="0" cellpadding="0">
      <tr>
       <th width="30" class="text-center">No.</th>
       <th width="100" class="text-center">Tanggal Pinjam</th>
       <th width="100" class="text-center">Petugas</th>
       <th width="200" class="text-center">Anggota</th>
       <th width="300" class="text-center">Judul Buku</th>
       <th width="60" class="text-center">Denda</th>
     </tr>
   <?php
    
   $no=1;
   $sum = 0 ;
   $tot_denda = 0;
   $query = mysql_query("SELECT * FROM detail_pinjam WHERE tgl_pinjam >= '$tgl_awal' AND tgl_pinjam <= '$tgl_akhir' AND denda > 0") or die (mysql_error());
   while($data = mysql_fetch_array($query)){
    $sql = mysql_query("SELECT * FROM peminjaman WHERE kd_pinjam = '$data[kd_pinjam]'");
    $detail = mysql_fetch_array($sql);
    $sql_anggota = mysql_query("SELECT nama FROM anggota WHERE kd_mem = '$detail[kd_member]'");
    $detail_anggota = mysql_fetch_array($sql_anggota);
    $sql_petugas = mysql_query("SELECT nama FROM petugas WHERE kd_petugas = '$detail[kd_petugas]'");
    $detail_petugas = mysql_fetch_array($sql_petugas);
    $sql_buku = mysql_query("SELECT judul FROM buku WHERE kd_buku = '$data[kd_buku]'");
    $detail_buku = mysql_fetch_array($sql_buku);
    $tot_denda += $data['denda'];
   ?>
     <tr>
       <td align="center"><?php echo $no; ?></td>
       <td align="center"><?php echo tgl_sql($data['tgl_pinjam']); ?></td>
       <td align="center"><?php echo $detail_petugas['nama']; ?></td>
       <td align="center"><?php echo $detail_anggota['nama']; ?></td>
       <td align="left"><?php echo $detail_buku['judul']; ?></td>
       <td align="right"><?php echo number_format($data['denda']); ?></td>
     </tr>
   <?php
   $no++;
   }
   ?>
    <tr>
      <td colspan="5" align="center"><strong><h3>Total</h3></strong></td>
      <td align="right"><strong><h3><?php echo number_format($tot_denda);?></h3></strong></td>
    </tr>
   </table>
  </form>
  </div>
  <?php } else { echo "<div align=center>Error : Silahkan isi rentang tanggal</div>"; }
}

function tampil_sewa_ex(){
if(!empty($_POST['tanggal']) AND !empty($_POST['tanggal1'])) {
$tgl_awal = tgl_sql($_POST['tanggal']);
$tgl_akhir= tgl_sql($_POST['tanggal1']);
$tgl1     = tgl($_POST['tanggal']);
$tgl2     = tgl($_POST['tanggal1']);

$filename = "Laporan-Sewa_" . date('dmY') . ".xls";
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
  ?>
<div align="center">
  <table width="795" border="0">
      <tr>
        <td width="150" rowspan="3" align="left"><img src="../assets/img/logo2.png" width="150px" height="70" /></td>
        <td width="645" align="center">LAPORAN DATA PEMINJAMAN BUKU PERPUSTAKAAN</td>
      </tr>
      <tr>
        <td align="center"><?php echo "PERIODE TANGGAL $tgl1 SAMPAI DENGAN TANGGAL $tgl2"; ?></td>
      </tr>
      <tr>
        <td align="center"></td>
      </tr>
    </table>
  ____________________________________________________________________________________________________<br />
  <br /><br />
    <table width="795" border="1" cellspacing="0" cellpadding="0">
      <tr>
       <th width="30" class="text-center">No.</th>
       <th width="100" class="text-center">Tanggal Pinjam</th>
       <th width="100" class="text-center">Petugas</th>
       <th width="200" class="text-center">Anggota</th>
       <th width="300" class="text-center">Judul Buku</th>
       <th width="60" class="text-center">Denda</th>
       <th width="100" class="text-center">Status</th>
     </tr>
   <?php
    
   $no=1;
   $sum = 0 ;
   $query = mysql_query("SELECT * FROM detail_pinjam WHERE tgl_pinjam >= '$tgl_awal' AND tgl_pinjam <= '$tgl_akhir'") or die (mysql_error());
   while($data = mysql_fetch_array($query)){
    $sql = mysql_query("SELECT * FROM peminjaman WHERE kd_pinjam = '$data[kd_pinjam]'");
    $detail = mysql_fetch_array($sql);
    $sql_anggota = mysql_query("SELECT nama FROM anggota WHERE kd_mem = '$detail[kd_member]'");
    $detail_anggota = mysql_fetch_array($sql_anggota);
    $sql_petugas = mysql_query("SELECT nama FROM petugas WHERE kd_petugas = '$detail[kd_petugas]'");
    $detail_petugas = mysql_fetch_array($sql_petugas);
    $sql_buku = mysql_query("SELECT judul FROM buku WHERE kd_buku = '$data[kd_buku]'");
    $detail_buku = mysql_fetch_array($sql_buku);
   ?>
     <tr>
       <td align="center"><?php echo $no; ?></td>
       <td align="center"><?php echo tgl_sql($data['tgl_pinjam']); ?></td>
       <td align="center"><?php echo $detail_petugas['nama']; ?></td>
       <td align="center"><?php echo $detail_anggota['nama']; ?></td>
       <td align="left"><?php echo $detail_buku['judul']; ?></td>
       <td align="center"><?php echo $data['denda']; ?></td>
       <td align="center"><?php echo $data['status']; ?></td>
     </tr>
   <?php
   $no++;
   }
   ?>
   </table>
  </form>
  </div>
  <?php } else { echo "<div align=center>Error : Silahkan isi rentang tanggal</div>"; }
}

function tampil_denda_ex(){
if(!empty($_POST['tanggal2']) AND !empty($_POST['tanggal3'])) {
$tgl_awal = tgl_sql($_POST['tanggal2']);
$tgl_akhir= tgl_sql($_POST['tanggal3']);
$tgl1     = tgl($_POST['tanggal2']);
$tgl2     = tgl($_POST['tanggal3']);

$filename = "Laporan-Denda_" . date('dmY') . ".xls";
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
  ?>
<div align="center">
  <table width="795" border="0">
      <tr>
        <td width="150" rowspan="3" align="left"><img src="../assets/img/logo2.png" width="150px" height="70" /></td>
        <td width="645" align="center">LAPORAN DATA DENDA BUKU PERPUSTAKAAN</td>
      </tr>
      <tr>
        <td align="center"><?php echo "PERIODE TANGGAL $tgl1 SAMPAI DENGAN TANGGAL $tgl2"; ?></td>
      </tr>
      <tr>
        <td align="center"></td>
      </tr>
    </table>
  ____________________________________________________________________________________________________<br />
  <br /><br />
    <table width="795" border="1" cellspacing="0" cellpadding="0">
      <tr>
       <th width="30" class="text-center">No.</th>
       <th width="100" class="text-center">Tanggal Pinjam</th>
       <th width="100" class="text-center">Petugas</th>
       <th width="200" class="text-center">Anggota</th>
       <th width="300" class="text-center">Judul Buku</th>
       <th width="60" class="text-center">Denda</th>
     </tr>
   <?php
    
   $no=1;
   $sum = 0 ;
   $tot_denda = 0;
   $query = mysql_query("SELECT * FROM detail_pinjam WHERE tgl_pinjam >= '$tgl_awal' AND tgl_pinjam <= '$tgl_akhir' AND denda > 0") or die (mysql_error());
   while($data = mysql_fetch_array($query)){
    $sql = mysql_query("SELECT * FROM peminjaman WHERE kd_pinjam = '$data[kd_pinjam]'");
    $detail = mysql_fetch_array($sql);
    $sql_anggota = mysql_query("SELECT nama FROM anggota WHERE kd_mem = '$detail[kd_member]'");
    $detail_anggota = mysql_fetch_array($sql_anggota);
    $sql_petugas = mysql_query("SELECT nama FROM petugas WHERE kd_petugas = '$detail[kd_petugas]'");
    $detail_petugas = mysql_fetch_array($sql_petugas);
    $sql_buku = mysql_query("SELECT judul FROM buku WHERE kd_buku = '$data[kd_buku]'");
    $detail_buku = mysql_fetch_array($sql_buku);
    $tot_denda += $data['denda'];
   ?>
     <tr>
       <td align="center"><?php echo $no; ?></td>
       <td align="center"><?php echo tgl_sql($data['tgl_pinjam']); ?></td>
       <td align="center"><?php echo $detail_petugas['nama']; ?></td>
       <td align="center"><?php echo $detail_anggota['nama']; ?></td>
       <td align="left"><?php echo $detail_buku['judul']; ?></td>
       <td align="right"><?php echo number_format($data['denda']); ?></td>
     </tr>
   <?php
   $no++;
   }
   ?>
    <tr>
      <td colspan="5" align="center"><strong><h3>Total</h3></strong></td>
      <td align="right"><strong><h3><?php echo number_format($tot_denda);?></h3></strong></td>
    </tr>
   </table>
  </form>
  </div>
  <?php } else { echo "<div align=center>Error : Silahkan isi rentang tanggal</div>"; }
}?>
