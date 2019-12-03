<div class="col-md-12">
<?php
if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')){
if(isset($_SESSION['members'])){
    foreach($_SESSION['members'] as $key => $val){
            $sql    = mysql_query("SELECT * FROM worker WHERE kd_worker='$key'");
            $result = mysql_fetch_array($sql);            
            }
            form_pinjam_worker();            
}
elseif(!isset($_SESSION['members'])){
    if(isset($_GET['member'])){
        if(isset($_POST['search']) or isset($_GET['search'])) {
            sirkulasi_orderbyid_search();
        }
        else{
            sirkulasi_orderbyid();
        }
    }else{
    if(isset($_POST['search']) or isset($_GET['search'])){
        historyWorker_list_search();
    }else{
        historyWorker_list();
        if(isset($_POST['pinjam'])){
            if(isset($_POST['kdw'])){
                $kdw = $_POST['kdw'];
                if (isset($_SESSION['members'][$kdw])) {
                    $_SESSION['members'][$kdw] += 1;                
                } else {
                    $_SESSION['members'][$kdw] = 0; 
                }
            }
            echo"<script>window.location=\"?page=sirkulasi-worker\"</script>";
        }
    }
    } 
}
}else{echo ' <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Anda tidak memiliki hak untuk melihat halaman ini.
                </div>';} ?>
</div>
<?php
function form_pinjam_worker(){
//Menentukan no Transaksi Sewa otomatis
$today = date("Ymd");
$q = mysql_query("SELECT max(kd_pinjam) AS last FROM peminjaman WHERE kd_pinjam LIKE '$today%'");
$d  = mysql_fetch_array($q);
$lastNoTransaksi = $d['last'];
 
// baca nomor urut transaksi dari id transaksi terakhir
$lastNoUrut = substr($lastNoTransaksi, 8, 4);
 
// nomor urut ditambah 1
$nextNoUrut = $lastNoUrut + 1;
 
// membuat format nomor transaksi berikutnya
$nextNoTransaksi = $today.sprintf('%04s', $nextNoUrut);

foreach ($_SESSION['members'] as $key => $value) {
    $sql    = mysql_query("SELECT `peminjaman`.`kd_member` as memberid, `peminjaman`.kd_pinjam as kd1, 
                            `detail_pinjam`.kd_pinjam as kd2, COUNT(*) as counter,`peminjaman`.kd_petugas as kd_petugas
                            FROM `peminjaman` CROSS JOIN `detail_pinjam` CROSS JOIN `worker` on
                            `peminjaman`.kd_member = '$key' AND
                            `peminjaman`.kd_member = `worker`.kd_worker AND
                            `peminjaman`.`kd_pinjam`=`detail_pinjam`.`kd_pinjam` AND 
                            `detail_pinjam`.status='dipinjam'");        
    $exist  = mysql_num_rows($sql); 
    $result = mysql_fetch_array($sql);
    if($exist > 0){
        $all    = $result['counter'];
    }else{
        $all    = 0;
    }   
}
 //Mengambil nilai limit max pinjam
 $sql_opt = mysql_query("SELECT option_value FROM options WHERE kd_option = '4'");
 $val     = mysql_fetch_array($sql_opt);
 $limit   = $val['option_value'];
 //Jika sudah mencapai Limit maka...
 if(isset($_SESSION['cart'])){
 if(($all + count($_SESSION['cart'])) >= $limit){?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        Sudah Mencapai Limit Maksimal Peminjaman.
    </div><?php 
}
}?>

    <!--    Bordered Table  -->
    <div class="panel panel-warning">
        <div class="panel-heading">
            Peminjaman
        </div>
        <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                <form method="post" action="" name="formaja">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td width="15%">Kode Pinjam</td>
                                <td width="1%">:</td>
                                <td width="25%"><input class="form-control" type="text" name="kdp" readonly value="<?php echo $nextNoTransaksi; ?>" /></td>
                                <td width="15%"></td>
                                <td width="20%">Tanggal Pinjam</td>
                                <td width="1%">:</td>
                                <td width="25%"><input class="form-control" type="text" name="tgl_p" readonly value="<?php echo date("Y-m-d"); ?>" /></td>
                            </tr>
                            <tr>
                                <td>Nama Anggota</td>
                                <td>:</td>
                                <td><?php
                                    $sql_mem = mysql_query("SELECT nama,kd_worker FROM worker WHERE kd_worker = '$key'");
                                    $result_mem = mysql_fetch_array($sql_mem);
                                    ?><input class="form-control" type="text" name="nama_mem" value="<?php echo $result_mem['nama']; ?>" readonly/>
                                    <input type="hidden" name="kd_member" id="kd_member" value="<?php echo $key; ?>"></td>
                                <td></td>
                                <td>Nama Petugas</td>
                                <td>:</td>
                                <td><?php 
                                    
                                    //foreach ($_SESSION['user'] as $key => $v) {
                                        //echo $key;
                                    $sqli    = mysql_query("SELECT kd_petugas,nama FROM petugas WHERE kd_petugas = '$_SESSION[user]' and status='Aktif'");
                                    $resuli = mysql_fetch_array($sqli);
                                    //}
                                    ?>

                                    <input class="form-control" type="text" name="nama_p" value="<?php echo $resuli['nama']; ?>" readonly />
                                    <input type="hidden" name="kd_petugas" id="kd_petugas" value="<?php echo $_SESSION['user']; ?>"></td>
                            </tr>                                                                
                        </tbody>
                    </table>
                </div>
                <?php
                $i = 0;
                $no = 1;
                if(isset($_SESSION['cart'])){
                    $count = count($_SESSION['cart']);}
                if (isset($_SESSION['cart']) && $count > 0) {?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>                            
                                <tr>
                                    <th width="5%"><div align="center">#</div></th>
                                    <th width="30%"><div align="center">Judul</div></th>
                                    <th width="25%"><div align="center">Pengarang</div></th>
                                    <th width="15%"><div align="center">Tanggal Pinjam</div></th>
                                    <th width="15%"><div align="center">Tanggal Harus Kembali</div></th>
                                    <th width="15%"><div align="center">Aksi</div></th>
                                </tr>
                            </thead>
                            <?php
                            foreach ($_SESSION['cart'] as $key => $val) {
                            $query = mysql_query("SELECT * FROM `buku` WHERE `kd_buku` = '$key' ");
                            $data  = mysql_fetch_array($query);
            
                            $add   = $data['lama_pinjam'];
    
                            date_default_timezone_get('Asia/Jakarta');
                            $tgl_mulai = date('d-m-Y');

                            $tambah_tanggal = mktime(0,0,0,date('m'),date('d')+$add,date('Y'));
                            $tgl_selesai = date('d-m-Y',$tambah_tanggal);

                            $day = hitungcuti($tgl_mulai,$tgl_selesai,"-");

                            $kembali = tgl_sql($tgl_selesai);

                            /*$q = mysql_query("SELECT * FROM `kalender_unpi` ");
                            while($d  = mysql_fetch_array($q)){
                                if($tgl_selesai == $d['tgl']){
                                    $tambah = mktime(0,0,0,date('m'),date('d')+1,date('Y'));
                                    $tgl_kembali = date('d-m-Y',$tambah);}

                            }*/

                            ?>
                            <tbody>
                                <tr>
                                    <td align="center"><?php echo $no++; ?></td>
                                    <td><?php echo $data['judul']; ?></td>
                                    <td><?php $qs = mysql_query("SELECT nama FROM pengarang WHERE kd_pengarang = '$data[kd_pengarang]'");
                                              $ds = mysql_fetch_array($qs);
                                              echo $ds['nama']; ?></td>
                                    <td align="center"><?php echo $tgl_mulai; ?></td>
                                    <td align="center"><?php echo tgl_sql(cek($kembali));  ?></td>
                                    <td align="center"><?php
                                        if($count < $limit and ($all + $count) < $limit ){ ?>            
                                            <a href="?page=book-collection" class="btn btn-info" type="button">
                                            <i class="fa fa-plus"></i></a><?php }  ?>
                                            <a href="?page=cart-update&act=del&kdb=<?php echo $data['kd_buku']; ?>&ref=sirkulasi" class="btn btn-info" type="button">
                                            <i class="fa fa-minus"></i></a>
                                            <input type="hidden" name="idb[<?php $i ?>]" id="idb" value="<?php echo $data['kd_buku']; ?>" />
                                            <input type="hidden" name="back[<?php $i ?>]" id="back" value="<?php echo  cek($kembali); ?>" />
                                            <input type="hidden" name="rows[<?php $i ?>]" id="rows"  value="<?php echo $i; ?>"/> </td>
                                </tr>
                                                                
                            </tbody>
                            <?php
                            $i++;
                            mysql_free_result($query);
                            }
                            ?>

                        </table>
                        <table class="table">
                            <tr>
                                <td width="80%"></td>
                                <td width="10%" align="right">
                                    <a href="?page=cart-update&act=del&kdw=<?php echo $result_mem['kd_worker']; ?>&ref=sirkulasi" class="btn btn-danger" type="button">
                                    <i class="fa fa-pencil"></i> Batal</a>
                                </td>
                                <td width="10%" align="right">
                                    <a href="" class="btn btn-warning" type="button" 
                                    onclick="document.formaja.action = '?page=sirkulasi-view'; document.formaja.method='post'; document.formaja.submit(); return false;">
                                        <i class="fa fa-pencil"></i> Proses</a>
                                </td>
                            </tr>
                        </table>
                        </form>
                </div></div></div>
                <?php 
            }else{
                foreach ($_SESSION['members'] as $key => $value) {                    
                    $sql    = mysql_query("SELECT `peminjaman`.`kd_member` as memberid, `peminjaman`.kd_pinjam as kd1, 
                            `detail_pinjam`.kd_pinjam as kd2, COUNT(*) as counter,`peminjaman`.kd_petugas as kd_petugas
                            FROM `peminjaman` CROSS JOIN `detail_pinjam` CROSS JOIN `worker` on
                            `peminjaman`.`kd_pinjam`=`detail_pinjam`.`kd_pinjam` AND
                            `peminjaman`.kd_member = `worker`.kd_worker AND 
                            `detail_pinjam`.status='dipinjam' AND
                            `peminjaman`.kd_member = '$key'");
                    $jml    = mysql_num_rows($sql);
                    if($jml >=1){
                        $data = mysql_fetch_array($sql);
                        if($data['counter'] >= $limit){?>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                    Member sudah mencapai batas LIMIT.<a href="?page=cart-update&act=del&kdw=<?php echo $data['memberid']; ?>&ref=sirkulasi-worker&byid" class="btn btn-danger" type="button">
                                    <i class="fa fa-trash-o"></i> Batalkan</a>
                            </div><?php 
                        }else{?>
                            <div class="alert alert-warning alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                    Belum ada buku yang dipinjam <a href="?page=book-collection" class="alert-link">Pinjam</a>
                            </div><?php
                        }
                    }
                }
            }
                ?>
                
            </div>
            <!--  End  Bordered Table  -->
            </div>
<?php }
?>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
function sirkulasi_orderbyid(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Sirkulasi Mahasiswa</h4></td>
                <td><button class="btn btn-warning" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Pinjam Buku</button></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page     = 10;
      $page_query   = mysql_query("SELECT count(*) FROM `peminjaman` CROSS JOIN `detail_pinjam` on
                      `peminjaman`.`kd_pinjam`=`detail_pinjam`.`kd_pinjam` AND 
                      `detail_pinjam`.status='dipinjam' GROUP BY `peminjaman`.`kd_worker`");
      $nums         = mysql_num_rows($page_query);
      $page         = (isset($_GET['pages'])) ? (int)$_GET['pages'] : 1;
      $start        = ($page-1) * $per_page;
      $pages        = ceil($nums / $per_page);
      ?>

<div class="row">
<div class="col-md-12">            
<!--    Context Classes  -->
<div class="panel panel-default">
<div class="panel-heading">
    <table width="100%">
        <tbody>
            <tr>
                <td width="30%">
                    <div class="form-group">
                    <?php
                    if(isset($_GET['pages'])){
                        $noPage = $_GET['pages'];}
                    else $noPage = 1;              
                        if($pages >= 2 && $page <= $pages){
                            if ($noPage > 1 OR $noPage == $pages) 
                                echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&byid&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                                for($x=1; $x<=$pages; $x++){
                                    $showPage = $x;
                                    if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                        if (($showPage != ($pages - 1)) && ($x == $pages))
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                        if ($x == $noPage)
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                        else
                                            echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&byid&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                                }
                                if ($noPage < $pages)
                                    echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&byid&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                            }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%">
                    <form role="form" method="post" action="?page=sirkulasi-worker&byid">             
                        <div class="input-group">
                             <input type="text" name="search" class="form-control" placeholder="Cari Kode Mahasiswa">
                                 <span class="form-group input-group-btn">
                                     <button class="btn btn-default" type="submit">Cari</button>
                                     <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                            <li><a href="?page=sirkulasi-worker">Kode Sirkulasi</a></li>
                                            <li><a href="?page=sirkulasi-worker&byid">Kode Mahasiswa</a></li>
                                            </ul>
                                    </div>                                     
                                 </span>
                        </div>
                     </form>
                </td>                                
            </tr>
        </tbody>
    </table>

</div>
<div class="panel-body">
<div class="table-responsive">
    <table class="table table-hover table-bordered">
         <thead>
            <tr>                                
            <th class="text-center">#</th>
            <th class="text-center">Kode Anggota</th>
            <th class="text-center">Kode Petugas</th>
            <th class="text-center">Jumlah Buku Sedang Dipinjam</th>
            <th class="text-center">Aksi</th>
            </tr>
        </thead>
     <tbody>
    <?php
    $no     = $start+1;
    $sql    = mysql_query("SELECT `peminjaman`.`kd_worker` as memberid, `peminjaman`.kd_pinjam as kd1, 
                            `detail_pinjam`.kd_pinjam as kd2, COUNT(*) as counter,`peminjaman`.kd_petugas as kd_petugas
                            FROM `peminjaman` CROSS JOIN `detail_pinjam` on
                            `peminjaman`.`kd_pinjam`=`detail_pinjam`.`kd_pinjam` AND 
                            `detail_pinjam`.status='dipinjam'  GROUP BY `peminjaman`.`kd_worker`
                            LIMIT $start,$per_page");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
            /*$kdp = $data['kd_pinjam'];
            $sql2 = mysql_query("SELECT * FROM detail_pinjam WHERE kd_pinjam = '$kdp' AND status = 'dipinjam'");
            $data2 = mysql_fetch_array($sql2);
            $jml2 = mysql_num_rows($sql2);*/
    ?>
        <tr class=warning>                                  
            <td class="text-center"><?php echo $no++; ?></td>
            <td class="text-center"><a href="?page=workers&view-worker=<?php echo $data['memberid'];?>"><?php echo $data['memberid']; ?></a></td>
            <td class="text-center"><a href="?page=librarians&view-librarian=<?php echo $data['kd_petugas']?>"><?php echo $data['kd_petugas']; ?></a></td>        
            <td class="text-center"><?php echo $data['counter']; ?></td>                                  
            <td class="text-center"><a href="?page=circulation-histori&memberid=<?php echo $data['memberid'];?>" class="btn btn-primary" type="button">
                <i class="fa fa-pencil"></i> Lihat</a></td>
        </tr>
    <?php }                                
    }else echo "<tr class=danger><td colspan=8 align=center>Tidak Ada Record</td></td>";

    ?>
    </tbody>
</table>
<div align="left">
<?php  
$jml = mysql_query("SELECT * FROM `peminjaman` CROSS JOIN `detail_pinjam` on
                            `peminjaman`.`kd_pinjam`=`detail_pinjam`.`kd_pinjam` AND 
                            `detail_pinjam`.status='dipinjam'  GROUP BY `peminjaman`.`kd_worker`");
$total = mysql_num_rows($jml);
?>
    <strong>Jumlah Record : <?php echo $total; ?></strong>
</div>

<div class="form-group" align="right">          
<?php
if(isset($_GET['pages'])){
    $noPage = $_GET['pages'];}
else $noPage = 1;
              
              
    if($pages >= 2 && $page <= $pages){
        if ($noPage > 1 OR $noPage == $pages) 
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&byid&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&byid&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&byid&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
        </div>
    </div>
</div>
</div>
 <!-- ============================================================= MODAL =================================================================================== -->
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="?page=sirkulasi-worker" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h3>Pinjam Buku</h3>
                </div>
                <div class="modal-body">
                <?php 
                    $sql_opt = mysql_query("SELECT option_value FROM options WHERE kd_option = '4'");
                    $val     = mysql_fetch_array($sql_opt);
                    $limit   = $val['option_value'];

                    $result = mysql_query("SELECT * FROM worker WHERE status='Aktif'");
                    $sum    = mysql_num_rows($result);
                    if($sum == 0){
                        echo "Belum ada data member"; }
                    else{ 
                        ?>
                        <label for="recipient-name" class="control-label">Kode Member </label>
                        <span class="form-group">                       
                        <select id="kdw" class="form-control" name="kdw">
                            <?php                           
                            while($row = mysql_fetch_array($result)){ 
                                ?><option  class="form-control" value="<?php echo $row[0]; ?>">
                                <?php echo $row[0]; ?></option><?php                            
                            }
                        }
                            ?>
                            </select>
                        </span>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-warning" name="pinjam">Process</button>
                </div>
            </div>  
        </form> 
    </div>
</div>
<!-- ================================================================END OF MODAL======================================================================== -->
</div>
</div>
<?php }?>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
function sirkulasi_orderbyid_search(){
    if(isset($_POST['search'])){$search = $_POST['search'];}
    elseif(isset($_GET['search'])){$search = $_GET['search'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Sirkulasi Filter Anggota Mahasiswa</h4></td>
                <td><button class="btn btn-warning" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Pinjam Buku</button></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query   = mysql_query("SELECT * FROM `peminjaman` CROSS JOIN `detail_pinjam` on
                            `peminjaman`.`kd_pinjam`=`detail_pinjam`.`kd_pinjam` AND 
                            `detail_pinjam`.status='dipinjam' AND `peminjaman`.kd_worker LIKE '%$search%'");
      $nums         = mysql_num_rows($page_query);
      $page         = (isset($_GET['pages'])) ? (int)$_GET['pages'] : 1;
      $start        = ($page-1) * $per_page; 
      $pages        = ceil($nums / $per_page);
      ?>

<div class="row">
<div class="col-md-12">            
<!--    Context Classes  -->
<div class="panel panel-default">
<div class="panel-heading">
    <table width="100%">
        <tbody>
            <tr>
                <td width="30%">
                    <div class="form-group">
                    <?php
                    if(isset($_GET['pages'])){
                        $noPage = $_GET['pages'];}
                    else $noPage = 1;              
                        if($pages >= 2 && $page <= $pages){
                            if ($noPage > 1 OR $noPage == $pages) 
                                echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&byid&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                                for($x=1; $x<=$pages; $x++){
                                    $showPage = $x;
                                    if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                        if (($showPage != ($pages - 1)) && ($x == $pages))
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                        if ($x == $noPage)
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                        else
                                            echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&byid&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                                }
                                if ($noPage < $pages)
                                    echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&byid&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                            }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%">
                    <form role="form" method="post" action="?page=sirkulasi-worker&byid">             
                        <div class="input-group">
                             <input type="text" name="search" class="form-control" placeholder="Cari Kode Mahasiswa">
                                 <span class="form-group input-group-btn">
                                     <button class="btn btn-default" type="submit">Cari</button>
                                     <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                            <li><a href="?page=sirkulasi-worker">Kode Sirkulasi</a></li>
                                            <li><a href="?page=sirkulasi-worker&byid">Kode Mahasiswa</a></li>
                                            </ul>
                                    </div>                                     
                                 </span>
                        </div>
                     </form>
                </td>                                
            </tr>
        </tbody>
    </table>

</div>
<div class="panel-body">
<div class="table-responsive">
    <table class="table table-hover table-bordered">
         <thead>
            <tr>                                
            <th class="text-center">#</th>
            <th class="text-center">Kode Anggota</th>
            <th class="text-center">Kode Petugas</th>
            <th class="text-center">Jumlah Buku Sedang Dipinjam</th>
            <th class="text-center">Aksi</th>
            </tr>
        </thead>
     <tbody>
    <?php
    $no     = $start+1;
    $sql    = mysql_query("SELECT `peminjaman`.`kd_worker` as memberid, `peminjaman`.kd_pinjam as kd1, 
                            `detail_pinjam`.kd_pinjam as kd2, COUNT(*) as counter,`peminjaman`.kd_petugas as kd_petugas
                            FROM `peminjaman` CROSS JOIN `detail_pinjam` on
                            `peminjaman`.`kd_pinjam`=`detail_pinjam`.`kd_pinjam` AND 
                            `detail_pinjam`.status='dipinjam' AND `peminjaman`.kd_worker LIKE '%$search%' 
                            GROUP BY `peminjaman`.`kd_worker`
                            LIMIT $start,$per_page");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
            /*$kdp = $data['kd_pinjam'];
            $sql2 = mysql_query("SELECT * FROM detail_pinjam WHERE kd_pinjam = '$kdp' AND status = 'dipinjam'");
            $data2 = mysql_fetch_array($sql2);
            $jml2 = mysql_num_rows($sql2);*/
    ?>
        <tr class=warning>                                  
            <td class="text-center"><?php echo $no++; ?></td>
            <td class="text-center"><a href="?page=workers&view-worker=<?php echo $data['memberid'];?>"><?php echo $data['memberid']; ?></a></td>
            <td class="text-center"><a href="?page=librarians&view-librarian=<?php echo $data['kd_petugas']?>"><?php echo $data['kd_petugas']; ?></a></td>        
            <td class="text-center"><?php echo $data['counter']; ?></td>                                  
            <td class="text-center"><a href="?page=circulation-histori&memberid=<?php echo $data['memberid'];?>" class="btn btn-primary" type="button">
                <i class="fa fa-pencil"></i> Lihat</a></td>
        </tr>
    <?php }                                
    }else echo "<tr class=danger><td colspan=8 align=center>Tidak Ada Record</td></td>";

    ?>
    </tbody>
</table>
<div align="left">
<?php  
$jml = mysql_query("SELECT * FROM `peminjaman` CROSS JOIN `detail_pinjam` on
                            `peminjaman`.`kd_pinjam`=`detail_pinjam`.`kd_pinjam` AND 
                            `detail_pinjam`.status='dipinjam' AND `peminjaman`.kd_worker LIKE '%$search%' 
                            GROUP BY `peminjaman`.`kd_worker`");
$total = mysql_num_rows($jml);
?>
    <strong>Jumlah Record : <?php echo $total; ?></strong>
</div>

<div class="form-group" align="right">          
<?php
if(isset($_GET['pages'])){
    $noPage = $_GET['pages'];}
else $noPage = 1;
              
              
    if($pages >= 2 && $page <= $pages){
        if ($noPage > 1 OR $noPage == $pages) 
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&byid&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&byid&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&byid&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
        </div>
    </div>
</div>
</div>
 <!-- ============================================================= MODAL =================================================================================== --><div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="?page=sirkulasi-worker" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h3>Pinjam Buku</h3>
                </div>
                <div class="modal-body">
                <?php 
                    $sql_opt = mysql_query("SELECT option_value FROM options WHERE kd_option = '4'");
                    $val     = mysql_fetch_array($sql_opt);
                    $limit   = $val['option_value'];

                    $result = mysql_query("SELECT * FROM worker WHERE status='Aktif'");
                    $sum    = mysql_num_rows($result);
                    if($sum == 0){
                        echo "Belum ada data member"; }
                    else{ 
                        ?>
                        <label for="recipient-name" class="control-label">Kode Member </label>
                        <span class="form-group">                       
                        <select id="kdw" class="form-control" name="kdw">
                            <?php                           
                            while($row = mysql_fetch_array($result)){ 
                                ?><option  class="form-control" value="<?php echo $row[0]; ?>">
                                <?php echo $row[0]; ?></option><?php                            
                            }
                        }
                            ?>
                            </select>
                        </span>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-warning" name="pinjam">Process</button>
                </div>
            </div>  
        </form> 
    </div>
</div>
<!-- ================================================================END OF MODAL======================================================================== -->

</div>
</div>
<?php }
?>
<!------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
function historyWorker_list(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Sirkulasi</h4></td>
                <td><button class="btn btn-warning" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Pinjam Buku</button></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `peminjaman`");
      $page = (isset($_GET['pages'])) ? (int)$_GET['pages'] : 1;
      $start = ($page-1) * $per_page; 
      $pages = ceil(mysql_result($page_query, 0) / $per_page);
      ?>

<div class="row">
<div class="col-md-12">            
<!--    Context Classes  -->
<div class="panel panel-default">
<div class="panel-heading">
    <table width="100%">
        <tbody>
            <tr>
                <td width="30%">
                    <div class="form-group">
                    <?php
                    if(isset($_GET['pages'])){
                        $noPage = $_GET['pages'];}
                    else $noPage = 1;              
                        if($pages >= 2 && $page <= $pages){
                            if ($noPage > 1 OR $noPage == $pages) 
                                echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                                for($x=1; $x<=$pages; $x++){
                                    $showPage = $x;
                                    if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                        if (($showPage != ($pages - 1)) && ($x == $pages))
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                        if ($x == $noPage)
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                        else
                                            echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                                }
                                if ($noPage < $pages)
                                    echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                            }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%">
                    <form role="form" method="post" action="?page=sirkulasi-worker">             
                        <div class="input-group">
                             <input type="text" name="search" class="form-control">
                                 <span class="form-group input-group-btn">
                                     <button class="btn btn-default" type="submit">Cari</button>
                                     <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                            <li><a href="?page=sirkulasi-worker">Kode Sirkulasi</a></li>
                                            <li><a href="?page=sirkulasi-worker&byid">Kode Mahasiswa</a></li>
                                            </ul>
                                    </div>                                     
                                 </span>
                        </div>
                     </form>
                </td>                                
            </tr>
        </tbody>
    </table>

</div>
<div class="panel-body">
<div class="table-responsive">
    <table class="table table-hover table-bordered">
         <thead>
            <tr>                                
            <th>#</th>
            <th>Kode Pinjam</th>
            <th>Kode Petugas</th>
            <th>Kode Anggota</th>
            <th>Jumlah Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Aksi</th>
            </tr>
        </thead>
     <tbody>
    <?php
    $no     = $start+1;
    $sql    = mysql_query("SELECT * FROM peminjaman, worker WHERE `peminjaman`.kd_member = `worker`.kd_worker ORDER BY kd_pinjam ASC LIMIT $start,$per_page");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
            $kdp = $data['kd_pinjam'];
    ?>
        <tr class=warning>                                  
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['kd_pinjam']; ?></td>
            <td><a href="?page=librarians&view-librarian=<?php echo $data['kd_petugas']?>"><?php echo $data['kd_petugas']; ?></a></td>
            <td><a href="?page=workers&view-worker=<?php echo $data['kd_member'];?>"><?php echo $data['kd_member']; ?></a></td>
            <td><?php echo $data['jml_buku']; ?></td>
            <td><?php echo $data['tgl_pinjam']; ?></td>                                    
            <td><a href="?page=circulation-histori&id=<?php echo $kdp;?>" class="btn btn-primary" type="button">
                <i class="fa fa-pencil"></i> Lihat</a></td>
        </tr>
    <?php }                                
    }else echo "<tr class=danger><td colspan=8 align=center>Tidak Ada Record</td></td>";

    ?>
    </tbody>
</table>
<div align="left">
<?php  
$jml = mysql_query("SELECT * FROM `peminjaman`");
$total = mysql_num_rows($jml);
?>
    <strong>Jumlah Record : <?php echo $total; ?></strong>
</div>

<div class="form-group" align="right">          
<?php
if(isset($_GET['pages'])){
    $noPage = $_GET['pages'];}
else $noPage = 1;
              
              
    if($pages >= 2 && $page <= $pages){
        if ($noPage > 1 OR $noPage == $pages) 
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
        </div>
    </div>
</div>
</div>
            
 <!-- ============================================================= MODAL =================================================================================== -->                            
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h3>Pinjam Buku</h3>
                </div>
                <div class="modal-body">
                <?php 
                    
                    $result = mysql_query("SELECT * FROM worker WHERE status='Aktif'");
                    $sum    = mysql_num_rows($result);
                    if($sum == 0){
                        echo "Belum ada data member"; }
                    else{ 
                        ?>
                        <label for="recipient-name" class="control-label">Kode Member </label>
                        <span class="form-group">                       
                            <select id="kdw" class="form-control" name="kdw">
                            <?php                           
                            while($row = mysql_fetch_array($result)){ ?>
                                <option  class="form-control" value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                            <?php
                            }
                        }
                            ?>
                            </select>
                        </span>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-warning" name="pinjam">Process</button>
                </div>
            </div>  
        </form> 
    </div>
</div>
<!-- ================================================================END OF MODAL======================================================================== -->
</div>
</div>
<!--------------------------------------------------------------------------------------------------------------------------------------------------------- -->                         
<?php
}

function historyWorker_list_search(){
if(isset($_POST['search'])){$search = $_POST['search'];}
    elseif(isset($_GET['search'])){$search = $_GET['search'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Sirkulasi</h4></td>
                <td><button class="btn btn-warning" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Pinjam Buku</button></td>
                <!--<td width="10%"><div align="left">
                    <div class="btn-group">
                    
                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Fakultas</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Teknik</a></li>
                            <li><a href="#">Ekonomi</a></li>
                            <li><a href="#">Sastra</a></li>
                            <li><a href="#">Fikom</a></li>
                        </ul>
            </div></td>-->
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `peminjaman` WHERE kd_pinjam LIKE '%$search%' or kd_worker LIKE '%$search%'");
      $page = (isset($_GET['pages'])) ? (int)$_GET['pages'] : 1;
      $start = ($page-1) * $per_page; 
      $pages = ceil(mysql_result($page_query, 0) / $per_page);
      ?>

<div class="row">
<div class="col-md-12">            
<!--    Context Classes  -->
<div class="panel panel-default">
<div class="panel-heading">
    <table width="100%">
        <tbody>
            <tr>
                <td width="30%">
                    <div class="form-group">
                    <?php
                    if(isset($_GET['pages'])){
                        $noPage = $_GET['pages'];}
                    else $noPage = 1;              
                        if($pages >= 2 && $page <= $pages){
                            if ($noPage > 1 OR $noPage == $pages) 
                                echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                                for($x=1; $x<=$pages; $x++){
                                    $showPage = $x;
                                    if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                        if (($showPage != ($pages - 1)) && ($x == $pages))
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                        if ($x == $noPage)
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                        else
                                            echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                                }
                                if ($noPage < $pages)
                                    echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                            }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%">
                    <form role="form" method="post" action="?page=sirkulasi-worker">             
                        <div class="input-group">
                             <input type="text" name="search" class="form-control">
                                 <span class="form-group input-group-btn">
                                     <button class="btn btn-default" type="submit">Cari</button>
                                     <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                            <li><a href="?page=sirkulasi-worker">Kode Sirkulasi</a></li>
                                            <li><a href="?page=sirkulasi-worker&byid">Kode Mahasiswa</a></li>
                                            </ul>
                                    </div>                                     
                                 </span>
                        </div>
                     </form>
                </td>                                
            </tr>
        </tbody>
    </table>

</div>
<div class="panel-body">
<div class="table-responsive">
    <table class="table table-hover table-bordered">
         <thead>
            <tr>                                
            <th>#</th>
            <th>Kode Pinjam</th>
            <th>Kode Petugas</th>
            <th>Kode Anggota</th>
            <th>Jumlah Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Aksi</th>
            </tr>
        </thead>
     <tbody>
    <?php
    $no     = $start+1;
    $sql    = mysql_query("SELECT * FROM peminjaman WHERE kd_pinjam LIKE '%$search%' or kd_worker LIKE '%$search%'
                           ORDER BY kd_pinjam ASC LIMIT $start,$per_page");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
            $kdp = $data['kd_pinjam'];
    ?>
        <tr class=warning>                                  
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['kd_pinjam']; ?></td>
            <td><a href="?page=librarians&view-librarian=<?php echo $data['kd_petugas']?>"><?php echo $data['kd_petugas']; ?></a></td>
            <td><a href="?page=workers&view-worker=<?php echo $data['kd_worker'];?>"><?php echo $data['kd_worker']; ?></a></td>
            <td><?php echo $data['jml_buku']; ?></td>
            <td><?php echo $data['tgl_pinjam']; ?></td>                                    
            <td><a href="?page=circulation-histori&id=<?php echo $kdp;?>" class="btn btn-primary" type="button">
                <i class="fa fa-pencil"></i> Lihat</a></td>
        </tr>
    <?php }                                
    }else echo "<tr class=danger><td colspan=8 align=center>Tidak Ada Record</td></td>";

    ?>
    </tbody>
</table>
<div align="left">
<?php  
$jml = mysql_query("SELECT * FROM `peminjaman` WHERE kd_pinjam LIKE '%$search%' or kd_worker LIKE '%$search%'");
$total = mysql_num_rows($jml);
?>
    <strong>Jumlah Record : <?php echo $total; ?></strong>
</div>

<div class="form-group" align="right">          
<?php
if(isset($_GET['pages'])){
    $noPage = $_GET['pages'];}
else $noPage = 1;
              
              
    if($pages >= 2 && $page <= $pages){
        if ($noPage > 1 OR $noPage == $pages) 
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi-worker&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
        </div>
    </div>
</div>
</div>
            
 <!-- ============================================================= MODAL =================================================================================== -->                            
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h3>Pinjam Buku</h3>
                </div>
                <div class="modal-body">
                <?php 
                    
                    $result = mysql_query("SELECT * FROM worker WHERE status='Aktif'");
                    $sum    = mysql_num_rows($result);
                    if($sum == 0){
                        echo "Belum ada data member"; }
                    else{ 
                        ?>
                        <label for="recipient-name" class="control-label">Kode Member </label>
                        <span class="form-group">                       
                                <select id="kdw" class="form-control" name="kdw">
                            <?php                           
                                while($row = mysql_fetch_array($result)){?>                                    
                                    <option  class="form-control" value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option><?php
                                }
                         }
                            ?>
                            </select>
                        </span>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-warning" name="pinjam">Process</button>
                </div>
            </div>  
        </form> 
    </div>
</div>
<!-- ================================================================END OF MODAL======================================================================== -->
</div>
</div>
<!--------------------------------------------------------------------------------------------------------------------------------------------------------- --> 
                            
<?php
}?>