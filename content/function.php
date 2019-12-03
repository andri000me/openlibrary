<?php
include('conn.php');
function modal(){?>
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
                    
                    $result = mysql_query("SELECT * FROM anggota WHERE status_mem='Aktif'");
                    $sum    = mysql_num_rows($result);
                    if($sum == 0){
                        echo "Belum ada data member"; }
                    else{ 
                        ?>
                        <label for="recipient-name" class="control-label">Kode Member </label>
                        <span class="form-group">                       
                            <select id="kdm" class="form-control" name="kdm">
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
<?php
}
?>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------>
<?php
function show_graf_sir(){?>
<div class="col-md-4 col-sm-4 col-xs-12">
    <div class="panel panel-info">
        <div class="panel-body" align="center">
            <div id="container"></div>
        </div>
    </div>
</div>
<?php
}
function book_late(){?>
<div class="col-md-8 col-sm-8 col-xs-12">
    <div class="panel panel-danger">
        <div class="panel-heading">
            Daftar Buku Terlambat
        </div>
        <div class="panel-body chat-widget-main text-left recent-users-sec">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>                                
                            <th>#</th>
                            <th>Kode Anggota</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Harus Kembali</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no     = 1;
                    $sql    = mysql_query("SELECT * FROM `peminjaman`, `detail_pinjam`,`anggota` WHERE 
                                 `peminjaman`.kd_pinjam = `detail_pinjam`.kd_pinjam AND
                                 `peminjaman`.kd_member = `anggota`.kd_mem AND 
                                 (TO_DAYS(now()) - TO_DAYS(`detail_pinjam`.tgl_hrs_kem)) > 0 
                                 AND `detail_pinjam`.status ='dipinjam' ORDER BY `detail_pinjam`.tgl_pinjam ASC Limit 10");
                    $jml    = mysql_num_rows($sql);
                    if($jml >=1){
                        while($data=mysql_fetch_array($sql)){
                            $cat = $data['jabatan'];
                            $query_buku = mysql_query("SELECT judul,kd_sirkulasi FROM buku WHERE kd_buku = '$data[kd_buku]'");
                            $data_buku = mysql_fetch_array($query_buku);
                    ?>
                        <tr class = "warning">
                            <td><?php echo $no++; ?></td>
                            <td><a href="?page=members&cat=<?php echo $cat;?>&view-member=<?php echo $data['kd_member']; ?>">
                                <?php echo $data['kd_member']; ?></a></td>
                            <td><a href="?page=circulation-histori&id=<?php echo $data['kd_pinjam']; ?>"> <?php echo $data_buku['judul']; ?></a></td>
                            <td><?php echo tgl_sql($data['tgl_hrs_kem']); ?></td>
                            <td><?php $querys = mysql_query("SELECT * FROM sirkulasi WHERE kd_sirkulasi = '$data_buku[kd_sirkulasi]'");
                                      $datas = mysql_fetch_array($querys);
                                      if($data['status'] == 'dipinjam'){                                        
                                        //Alur
                                        if(isset($_POST['ok'])){
                                            $denda=$_POST['denda'][$i];
                                        }else{
                                        //tentukan waktu tujuan
                                            $waktu_tujuan = $data['tgl_hrs_kem'];
                                        //Untuk menghitung jumlah dalam satuan hari:
                                            $daydiff=floor((strtotime(date("Y-m-d")) - strtotime($waktu_tujuan))/(60*60*24));
                                            if($daydiff <= 0){
                                                $denda = 0;
                                            }
                                            elseif($daydiff >=1){
                                                $denda = $daydiff * $datas['denda'];
                                            }
                                        }?>
                                        <input type="text" name="denda[<?php echo $i; ?>]" value="<?php echo $denda; ?>" size="3" readonly />
                                        <!--<button name="ok" class="btn-primary" type="submit">
                                        <i class="fa fa-refresh"></i></button>--><?php 
                                      }else echo number_format($data['denda']);?></td>
                        </tr>                               
                        <?php
                        }
                        if($jml >= 10){
                            echo '<div align="right"><a href="?page=book-late" > Lihat lebih banyak <i class="glyphicon glyphicon-chevron-right"></i></a></div>';
                        }
                    }else echo "<tr class=danger><td colspan=11 align=center>Tidak Ada Record</td></td>";?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------>
<?php
function book_borrowed(){?>
<div class="col-md-12">
    <div class="panel panel-info">
        <div class="panel-heading">
            Daftar Buku Dipinjam
        </div>
        <div class="panel-body chat-widget-main text-left recent-users-sec">
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
    $no     = 1;
    $sql    = mysql_query("SELECT * FROM peminjaman ORDER BY kd_pinjam ASC LIMIT 10");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
            $mv  = mysql_query("SELECT jabatan FROM anggota WHERE kd_mem = '$data[kd_member]'");
            $var = mysql_fetch_array($mv);
            $cat = $var['jabatan'];
            $kdp = $data['kd_pinjam'];
    ?>
        <tr class=warning>                                  
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['kd_pinjam']; ?></td>
            <td><a href="?page=librarians&view-librarian=<?php echo $data['kd_petugas']?>"><?php echo $data['kd_petugas']; ?></a></td>
            <td><a href="?page=members&cat=<?php echo $cat; ?>&view-member=<?php echo $data['kd_member'];?>"><?php echo $data['kd_member']; ?></a></td>
            <td><?php echo $data['jml_buku']; ?></td>
            <td><?php echo $data['tgl_pinjam']; ?></td>                                    
            <td><a href="?page=circulation-histori&id=<?php echo $kdp;?>" class="btn btn-primary" type="button">
                <i class="fa fa-pencil"></i> Lihat</a></td>
        </tr>
    <?php }
    if($jml >= 10){
        echo '<div align="right"><a href="?page=sirkulasi&list=show" > Lihat lebih banyak <i class="glyphicon glyphicon-chevron-right"></i></a></div>';
    }                                
    }else echo "<tr class=danger><td colspan=8 align=center>Tidak Ada Record</td></td>";

    ?>
    </tbody>
</table>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------>
<?php
//---------------------------------------------------------function panggil list--------------------------------------------------------------
function history_list(){?>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `peminjaman`");
      $page = (isset($_GET['pages'])) ? (int)$_GET['pages'] : 1;
      $start = ($page-1) * $per_page; 
      $pages = ceil(mysql_result($page_query, 0) / $per_page);
      ?>
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
                                echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&list=show&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                                for($x=1; $x<=$pages; $x++){
                                    $showPage = $x;
                                    if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                        if (($showPage != ($pages - 1)) && ($x == $pages))
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                        if ($x == $noPage)
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                        else
                                            echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&list=show&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                                }
                                if ($noPage < $pages)
                                    echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&list=show&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                            }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%">
                    <form role="form" method="post" action="?page=sirkulasi&list=show">             
                        <div class="input-group">
                             <input type="text" name="search" class="form-control" required placeholder="Cari Kode Pinjam/Anggota">
                                 <span class="form-group input-group-btn">
                                     <button class="btn btn-default" type="submit">Cari</button>
                                     <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                            <li><a href="?page=sirkulasi&list=show">Kode Sirkulasi</a></li>
                                            <li><a href="?page=sirkulasi&member">Kode Anggota</a></li>
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
    $no 	= $start+1;
	$sql 	= mysql_query("SELECT * FROM peminjaman ORDER BY kd_pinjam ASC LIMIT $start,$per_page");
	$jml 	= mysql_num_rows($sql);
	if($jml >=1){
		while($data=mysql_fetch_array($sql)){
            $mv  = mysql_query("SELECT jabatan FROM anggota WHERE kd_mem = '$data[kd_member]'");
            $var = mysql_fetch_array($mv);
            $cat = $var['jabatan'];
			$kdp = $data['kd_pinjam'];
	?>
        <tr class=warning>                                	
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['kd_pinjam']; ?></td>
            <td><a href="?page=librarians&view-librarian=<?php echo $data['kd_petugas']?>"><?php echo $data['kd_petugas']; ?></a></td>
            <td><a href="?page=members&cat=<?php echo $cat; ?>&view-member=<?php echo $data['kd_member'];?>"><?php echo $data['kd_member']; ?></a></td>
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&list=show&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&list=show&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&list=show&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
        </div>
    </div>
</div>
<?php modal();?>
</div>
            
 </div>
<!--------------------------------------------------------------------------------------------------------------------------------------------------------- -->							
<?php
}

function history_list_search(){
if(isset($_POST['search'])){$search = $_POST['search'];}
    elseif(isset($_GET['search'])){$search = $_GET['search'];}

      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `peminjaman` WHERE kd_pinjam LIKE '%$search%' or kd_member LIKE '%$search%'");
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
                                echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&list=show&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                                for($x=1; $x<=$pages; $x++){
                                    $showPage = $x;
                                    if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                        if (($showPage != ($pages - 1)) && ($x == $pages))
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                        if ($x == $noPage)
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                        else
                                            echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&list=show&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                                }
                                if ($noPage < $pages)
                                    echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&list=show&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                            }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%">
                    <form role="form" method="post" action="?page=sirkulasi&list=show">             
                        <div class="input-group">
                             <input type="text" name="search" class="form-control" placeholder="Cari Kode Pinjam/Anggota" required>
                                 <span class="form-group input-group-btn">
                                     <button class="btn btn-default" type="submit">Cari</button>
                                     <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                            <li><a href="?page=sirkulasi&list=show">Kode Sirkulasi</a></li>
                                            <li><a href="?page=sirkulasi&member">Kode Anggota</a></li>
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
    $sql    = mysql_query("SELECT * FROM peminjaman WHERE kd_pinjam LIKE '%$search%' or kd_member LIKE '%$search%'
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
            <td><a href="?page=members&cat=<?php echo $cat; ?>view-member=<?php echo $data['kd_member'];?>"><?php echo $data['kd_member']; ?></a></td>
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
$jml = mysql_query("SELECT * FROM `peminjaman` WHERE kd_pinjam LIKE '%$search%' or kd_member LIKE '%$search%'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&list=show&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&list=show&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&list=show&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
        </div>
    </div>
</div>
</div>
</div>
</div>
<!--------------------------------------------------------------------------------------------------------------------------------------------------------- --> 
                            
<?php
}

function book_list(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Buku Koleksi</h4></td>
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
                </div>
            </div></td>-->
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `buku`");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=book-collection&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                                $showPage = $x;
                                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                    if (($showPage != ($pages - 1)) && ($x == $pages))
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=book-collection&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=book-collection&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                <form role="form" method="post" action="?page=book-collection">             
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" required>
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <a href="?page=book-collection&form-buku" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th><div align="center">#</div></th>
                <th><div align="center">Kode Buku</th>
                <th><div align="center">Kode Petugas</th>
                <th><div align="center"><div align="center">Judul Buku</div></th>
                <th><div align="center">Penerimaan</div></th>
                <th><div align="center">Harga</div></th>
                <th><div align="center">Sirkulasi</div></th>
                <th><div align="center">Status</div></th>
                <th><div align="center">Aksi</div></th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no 	= $start+1;
		$sql 	= mysql_query("SELECT * FROM buku WHERE status = 'Tersedia' ORDER BY judul ASC LIMIT $start,$per_page");
		$jml 	= mysql_num_rows($sql);
		if($jml >=1){
			while($data=mysql_fetch_array($sql)){                                
        ?>
            <tr>
                <td width="3%"><div align="center"><?php echo $no++; ?></div></td>
                <td width="10%"><div align="center"><?php echo $data['kd_buku']; ?></div></td>
                <td width="10%"><div align="center"><a href="?page=librarians&view-librarian=<?php  echo $data['kd_petugas']; ?>">
                                <?php echo $data['kd_petugas']; ?></div></td>
                <td width="20%"><a href="?page=detail-catalogue&id=<?php echo $data['kd_buku']; ?>">
                                <?php echo $data['judul']; ?></a></td>
                <td width="10%"><div align="center"><?php echo $data['penerimaan']; ?></div></td>
                <td width="10%"><div align="left"><?php echo number_format($data['harga']); ?></div></td>
                <td width="10%"><div align="left"><?php if($data['kd_sirkulasi']=='SI01'){echo "Ya";} else { echo "Tidak"; } ?></div></td>
                <td width="10%"><div align="center">
                                <?php 
                                $qs     = mysql_query("SELECT kd_pinjam, status FROM detail_pinjam WHERE kd_buku = '$data[kd_buku]' and status = 'dipinjam'");
                                $ds     = mysql_fetch_array($qs);
                                $tot    = mysql_num_rows($qs);
                                $stat   = $ds ['status'];                                    					  
                                $kdp    = $ds['kd_pinjam'];

                                $sql_opt = mysql_query("SELECT option_value FROM options WHERE kd_option = '3'");
                                $val     = mysql_fetch_array($sql_opt);
                                $limit   = $val['option_value'];

                                if($stat =='dipinjam'){
					 				$qm   = mysql_query("SELECT kd_member FROM peminjaman WHERE kd_pinjam = '$kdp'");
					 				$dm   = mysql_fetch_array($qm);
					 				$kd_mem  = $dm['kd_member'];
								?>
								<a  href="?page=circulation-histori&id=<?php echo $kdp;?>">
            					<i class=""> </i>
					 			<?php echo "Dipinjam ".$kd_mem;?></a><?php
					 			} else {echo "<span class=\"label label-success\">".$data['status']."</span>";}  ?></div></td>
                <td width="20%" class="text-center"><?php 
                                if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>                                    	
                                <?php 
                                    if(isset($_SESSION['members'])){
                                        $sirkulasi = $data['kd_sirkulasi'];
                                    	if(($stat == 'dipinjam') or ($sirkulasi == 'SI02')) {
                                    		echo "<a title=\"Buku tidak dapat disewa\"left\".\" data-toggle=\"tooltip\" class=\"btn btn-warning\" href=\"#\">
                                            <i class=\"glyphicon glyphicon-ban-circle glyphicon-white\"></i> Pinjam</a>";
                                    	}elseif(isset($_SESSION['cart']) && count($_SESSION['cart']) == $limit-1) {?>
                                    		      <a href="?page=cart-update&act=add&kdb=<?php echo $data['kd_buku']; ?>&ref=sirkulasi" class="btn btn-primary" type="button">
                                    		      <i class="fa fa-pencil"></i> Pinjam</a><?php }
                                               else {?>
                                    		      <a href="?page=cart-update&act=add&kdb=<?php echo $data['kd_buku']; ?>&ref=book-collection" class="btn btn-primary" type="button">
                                    		      <i class="fa fa-pencil"></i> Pinjam</a><?php 
                                              

                                            } 
                                    }
                                    else{
                                    ?>
                                    	<a href="?page=plus-ebook&id=<?php echo $data['kd_buku']; ?>" class="btn btn-primary" type="button">
                                    	<i class="fa fa-plus"></i> Ebook</a>
                                    		<?php
                                    }
                                } ?></td>
            </tr>
            <?php
            }
            }else echo "<tr class=danger><td colspan=9 align=center>Tidak Ada Record</td></td>";

            ?>
        </tbody>
    </table>

<div align="left">
<?php  
$jml = mysql_query("SELECT * FROM `buku`");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=book-collection&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=book-collection&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=book-collection&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
        </div>

    </div>
</div>
</div>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
}

function book_list_search(){
    if(isset($_POST['search'])){$search = $_POST['search'];}
    elseif(isset($_GET['search'])){$search = $_GET['search'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Buku Koleksi</h4></td>
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
                </div>
            </div></td>-->
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `buku` WHERE kd_buku LIKE '%$search%' or judul LIKE '%$search%'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=book-collection&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                                $showPage = $x;
                                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                    if (($showPage != ($pages - 1)) && ($x == $pages))
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=book-collection&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=book-collection&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                <form role="form" method="post" action="?page=book-collection">             
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" required>
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <a href="?page=book-collection&form-buku" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th><div align="center">#</div></th>
                <th><div align="center">Kode Buku</th>
                <th><div align="center">Kode Petugas</th>
                <th><div align="center"><div align="center">Judul Buku</div></th>
                <th><div align="center">Penerimaan</div></th>
                <th><div align="center">Harga</div></th>
                <th><div align="center">Sirkulasi</div></th>
                <th><div align="center">Status</div></th>
                <th><div align="center">Aksi</div></th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no     = $start+1;
        $sql    = mysql_query("SELECT * FROM buku WHERE kd_buku LIKE '%$search%' or judul LIKE '%$search%' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){                                
        ?>
            <tr>
                <td width="3%"><div align="center"><?php echo $no++; ?></div></td>
                <td width="10%"><div align="center"><?php echo $data['kd_buku']; ?></div></td>
                <td width="10%"><div align="center"><a href="?page=librarians&view-librarian=<?php  echo $data['kd_petugas']; ?>">
                                <?php echo $data['kd_petugas']; ?></div></td>
                <td width="20%"><a href="?page=detail-catalogue&id=<?php echo $data['kd_buku']; ?>">
                                <?php echo $data['judul']; ?></a></td>
                <td width="10%"><div align="center"><?php echo $data['penerimaan']; ?></div></td>
                <td width="10%"><div align="left"><?php echo number_format($data['harga']); ?></div></td>
                <td width="10%"><div align="left"><?php if($data['kd_sirkulasi']=='SI01'){echo "Ya";} else { echo "Tidak"; } ?></div></td>
                <td width="10%"><div align="center">
                                <?php $qs = mysql_query("SELECT kd_pinjam, status FROM detail_pinjam WHERE kd_buku = '$data[kd_buku]' and status = 'dipinjam'");
                                $ds = mysql_fetch_array($qs);
                                $stat = $ds ['status'];                                                       
                                $kdp = $ds['kd_pinjam'];
                                if($stat =='dipinjam'){
                                    $qm = mysql_query("SELECT kd_member FROM peminjaman WHERE kd_pinjam = '$kdp'");
                                    $dm  = mysql_fetch_array($qm);
                                    $kd_mem  = $dm['kd_member'];
                                ?>
                                <a  href="?page=circulation-histori&id=<?php echo $kdp;?>">
                                <i class=""> </i>
                                <?php echo "Dipinjam ".$kd_mem;?></a><?php
                                } else {echo "<span class=\"label label-success\">tersedia";}  ?></div></td>
                <td width="20%"><?php 
                                if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>                                     
                                <?php 
                                    if(isset($_SESSION['members'])){ 
                                        $sirkulasi = $data['kd_sirkulasi'];
                                            if(($stat == 'dipinjam') or ($sirkulasi == 'SI02')) {
                                                echo "<a title=\"Buku tidak dapat disewa\"left\".\" data-toggle=\"tooltip\" class=\"btn btn-warning\" href=\"#\"><i class=\"glyphicon glyphicon-ban-circle glyphicon-white\"></i> Pinjam</a>";
                                            }else
                                        if(isset($_SESSION['cart']) && count($_SESSION['cart']) == 2 ) { ?>
                                            <a href="?page=cart-update&act=add&kdb=<?php echo $data['kd_buku']; ?>&ref=sirkulasi" class="btn btn-primary" type="button">
                                            <i class="fa fa-pencil"></i> Pinjam</a>
                                        <?php } else { ?>
                                            <a href="?page=cart-update&act=add&kdb=<?php echo $data['kd_buku']; ?>&ref=book-collection" class="btn btn-primary" type="button">
                                            <i class="fa fa-pencil"></i> Pinjam</a>
                                        <?php } 
                                    }
                                    else{
                                    ?>
                                        <a href="?page=book-collection&update-buku=<?php echo $data['kd_buku']; ?>" class="btn btn-primary" type="button">
                                        <i class="fa fa-pencil"></i> Ubah</a>
                                        <a href="?page=plus-ebook&id=<?php echo $data['kd_buku']; ?>" class="btn btn-primary" type="button">
                                        <i class="fa fa-plus"></i> Ebook</a>
                                            <?php
                                    }
                                } ?></td>
            </tr>
            <?php
            }
            }else echo "<tr class=danger><td colspan=9 align=center>Tidak Ada Record</td></td>";

            ?>
        </tbody>
    </table>

<div align="left">
<?php  
$jml = mysql_query("SELECT * FROM `buku` WHERE kd_buku LIKE '%$search%' or judul LIKE '%$search%'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=book-collection&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=book-collection&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=book-collection&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
        </div>

    </div>
</div>
</div>
</div>
</div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
}

function members_list(){
    if(isset($_GET['cat'])){ $cat = $_GET['cat'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line"><?php echo $cat;?></h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <?php if($cat=='Mahasiswa'){?>
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=members-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=members-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=members-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=members-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=members-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=members-filter&com">Ilmu Komunikasi</a></li>
                            <?php }elseif($cat=='Dosen'){?>
                            <li><a href="#">Fakultas</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=teachers-filter&tech">Teknik</a></li>
                            <li><a href="?page=teachers-filter&eco">Ekonomi</a></li>
                            <li><a href="?page=teachers-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=teachers-filter&com">Ilmu Komunikasi</a></li>
                            <?php } ?>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $page_query = mysql_query("SELECT COUNT(*) FROM `anggota` WHERE jabatan = '$cat'");
      $per_page = 10;      
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=members&cat=".$cat."&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                                $showPage = $x;
                                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                    if (($showPage != ($pages - 1)) && ($x == $pages))
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=members&cat=".$cat."&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=members&cat=".$cat."&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="?page=members&cat=<?php echo $cat;?>">             
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" required>
                            <span class="form-group input-group-btn">
                                <button class="btn btn-default" type="submit">Cari</button>
                                <a href="?page=members&form-member" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th>Kode Anggota</th>
                <th>Kode Petugas</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Fakultas</th>
                <th>Keanggotaan</th>
                <th>Aksi</th>
            </tr>
        </thead>
    <tbody>
    <?php
    $no 	= $start + 1;
    $sql    = mysql_query("SELECT * FROM anggota WHERE jabatan = '$cat' ORDER BY kd_mem ASC LIMIT $start,$per_page");
	$jml 	= mysql_num_rows($sql);
	if($jml >=1){
		while($data=mysql_fetch_array($sql)){
            echo"
            <tr class=warning>                                	
            <td>".$no++."</td>
            <td>".$data['kd_mem']."</td>
            <td><a href=?page=librarians&view-librarian=".$data['kd_petugas'].">".$data['kd_petugas']."</a></td>
            <td><a href=?page=members&cat=".$cat."&view-member=".$data['kd_mem'].">".$data['nama']."</a></td>
            <td>".$data['jabatan']."</td>
            <td>".$data['fakultas']."</td>
            <td>".$data['status_mem']."</td>
            <td><a href=?page=history-sirkulasi-mhs&member-id=".$data['kd_mem']." class=\"btn btn-info\" type=\"button\" alt=\"History\">
                <i class=\"fa fa-history\"></i> History</a>
                <a href=?page=members&cat=".$cat."&update-member=".$data['kd_mem']." class=\"btn btn-primary\" type=\"button\">
                <i class=\"fa fa-pencil\"></i> Update</a>
                </td>
         </tr>";
        }
    }
    else echo "<tr class=danger><td colspan=9 align=center>Tidak Ada Record</td></td>";
    ?>
    </tbody>
</table>

<div align="left">
<?php  
$jml = mysql_query("SELECT * FROM `anggota` WHERE jabatan = '$cat'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=members&cat=".$cat."&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=members&cat=".$cat."&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=members&cat=".$cat."&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
        </div>
</div>
</div>
</div>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
}

function members_list_search(){
    if(isset($_GET['cat'])){ $cat = $_GET['cat'];
    if(isset($_POST['search'])){$search = $_POST['search'];}
    elseif(isset($_GET['search'])){$search = $_GET['search'];}
    }
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line"><?php echo $cat;?></h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <?php if($cat=='Mahasiswa'){?>
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=members-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=members-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=members-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=members-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=members-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=members-filter&com">Ilmu Komunikasi</a></li>
                            <?php }elseif($cat=='Dosen'){?>
                            <li><a href="#">Fakultas</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=teachers-filter&tech">Teknik</a></li>
                            <li><a href="?page=teachers-filter&eco">Ekonomi</a></li>
                            <li><a href="?page=teachers-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=teachers-filter&com">Ilmu Komunikasi</a></li>
                            <?php } ?>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `anggota` WHERE (kd_mem LIKE '%$search%' or nama LIKE '%$search%') and jabatan= '$cat'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=members&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                                $showPage = $x;
                                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                    if (($showPage != ($pages - 1)) && ($x == $pages))
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=members&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=members&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="?page=members&cat=<?php echo $cat; ?>">             
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" required>
                            <span class="form-group input-group-btn">
                                <button class="btn btn-default" type="submit">Cari</button>
                                <a href="?page=members&form-member" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th>Kode Anggota</th>
                <th>Kode Petugas</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Fakultas</th>
                <th>Keanggotaan</th>
                <th>Aksi</th>
            </tr>
        </thead>
    <tbody>
    <?php
    $no     = $start+1;
    $sql    = mysql_query("SELECT * FROM anggota WHERE (kd_mem LIKE '%$search%' or nama LIKE '%$search%') and jabatan = '$cat'
                            ORDER BY kd_mem ASC LIMIT $start,$per_page");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
            echo"
            <tr class=warning>                                  
            <td>".$no++."</td>
            <td>".$data['kd_mem']."</td>
            <td><a href=?page=librarians&view-librarian=".$data['kd_petugas'].">".$data['kd_petugas']."</a></td>
            <td><a href=?page=members&cat=".$cat."&view-member=".$data['kd_mem'].">".$data['nama']."</a></td>
            <td>".$data['jabatan']."</td>
            <td>".$data['fakultas']."</td>
            <td>".$data['status_mem']."</td>
            <td><a href=?page=history-sirkulasi-mhs&member-id=".$data['kd_mem']." class=\"btn btn-info\" type=\"button\" alt=\"History\">
                <i class=\"fa fa-history\"></i> History</a>
                <a href=?page=members&cat=".$cat."&update-member=".$data['kd_mem']." class=\"btn btn-primary\" type=\"button\">
                <i class=\"fa fa-pencil\"></i> Update</a></td>
         </tr>";
        }
    }
    else echo "<tr class=danger><td colspan=9 align=center>Tidak Ada Record</td></td>";
    ?>
    </tbody>
</table>

<div align="left">
<?php  
$jml = mysql_query("SELECT * FROM `anggota` WHERE (kd_mem LIKE '%$search%' or nama LIKE '%$search%') and jabatan = '$cat'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=members&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=members&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=members&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
        </div>
</div>
</div>
</div>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
}

function librarians_list(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Petugas</h4></td>
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
                </div>
            </div></td>-->
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `petugas`");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=librarians&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                                $showPage = $x;
                                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                    if (($showPage != ($pages - 1)) && ($x == $pages))
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=librarians&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=librarians&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="?page=librarians">             
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" required>
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <a href="?page=librarians&form-librarian" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th>Kode Petugas</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no 	= $start+1;
	    $sql 	= mysql_query("SELECT * FROM petugas ORDER BY kd_petugas ASC LIMIT $start,$per_page");
		$jml 	= mysql_num_rows($sql);
		if($jml >=1){
			while($data=mysql_fetch_array($sql)){
                echo"
                <tr class=warning>                                	
                <td>".$no++."</td>
                <td>".$data['kd_petugas']."</td>
                <td><a href=?page=librarians&view-librarian=".$data['kd_petugas'].">".$data['nama']."</a></td>
                <td>".$data['jabatan']."</td>
                <td>".$data['status']."</td>
                <td><a href=?page=librarians&update-librarian=".$data['kd_petugas']." class=\"btn btn-primary\" type=\"button\">
                    <i class=\"fa fa-pencil\"></i> Update</a></td>
                </tr>";
            }
        }
        else echo "<tr class=danger><td colspan=8 align=center>Tidak Ada Record</td></td>";

        ?>
        </tbody>
    </table>

    <div align="left">
    <?php  
    $jml = mysql_query("SELECT * FROM `petugas`");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=librarians&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=librarians&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=librarians&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
        </div>

</div>
</div>
</div>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
}

function librarians_list_search(){
    if(isset($_POST['search'])){$search = $_POST['search'];}
    elseif(isset($_GET['search'])){$search = $_GET['search'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Petugas</h4></td>
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
                </div>
            </div></td>-->
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `petugas` WHERE kd_petugas LIKE '%$search%' or nama LIKE '%$search%'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=librarians&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                                $showPage = $x;
                                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                    if (($showPage != ($pages - 1)) && ($x == $pages))
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=librarians&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=librarians&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="?page=librarians">             
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" required>
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <a href="?page=librarians&form-librarian" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th>Kode Petugas</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no     = $start+1;
        $sql    = mysql_query("SELECT * FROM petugas WHERE kd_petugas LIKE '%$search%' or nama LIKE '%$search%' ORDER BY kd_petugas ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                echo"
                <tr class=warning>                                  
                <td>".$no++."</td>
                <td>".$data['kd_petugas']."</td>
                <td><a href=?page=librarians&view-librarian=".$data['kd_petugas'].">".$data['nama']."</a></td>
                <td>".$data['jabatan']."</td>
                <td>".$data['status']."</td>
                <td><a href=?page=librarians&update-librarian=".$data['kd_petugas']." class=\"btn btn-primary\" type=\"button\">
                    <i class=\"fa fa-pencil\"></i> Update</a></td>
                </tr>";
            }
        }
        else echo "<tr class=danger><td colspan=8 align=center>Tidak Ada Record</td></td>";

        ?>
        </tbody>
    </table>

    <div align="left">
    <?php  
    $jml = mysql_query("SELECT * FROM `petugas` WHERE kd_petugas LIKE '%$search%' or nama LIKE '%$search%'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=librarians&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=librarians&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=librarians&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
</div>

</div>
</div>
</div>
</div>
</div>
<!-------------------------------------------------------------------------------------------------------------------------------------------------------  -->
<?php
}
function admin_list(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Admin</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <!--<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Fakultas</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Teknik</a></li>
                            <li><a href="#">Ekonomi</a></li>
                            <li><a href="#">Sastra</a></li>
                            <li><a href="#">Fikom</a></li>
                        </ul>-->
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>

<div class="row">
    <div class="col-md-12">         
            
        <!--    Context Classes  -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <table width="100%">
                       <tbody>
                            <tr>
                                <td width="30%">Daftar Admin</td>
                                <td width="30%"></td>
                                <td width="20%"></td>
                                <td width="20%" align="">
                                    <form role="form" method="post" action="?page=request">             
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" required>
                                                <span class="form-group input-group-btn">
                                                    <button class="btn btn-default" type="submit">Cari</button>
                                                    <a href="?page=admin&form-admin" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                                    <th>Kode Admin</th>
                                    <th>Nama</th>
                                	<th>Jabatan</th>
                                	<th>Status</th>
                                	<th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	$no 	= 1;
								$sql 	= mysql_query("SELECT * FROM admin ORDER BY kd_admin ASC");
								$jml 	= mysql_num_rows($sql);
								if($jml >=1){
								while($data=mysql_fetch_array($sql)){
                                	echo"
                                	<tr class=warning>                                	
                                    <td>".$no++."</td>
                                    <td>".$data['kd_admin']."</td>
                                    <td><a href=?page=admin&view-admin=".$data['kd_admin'].">".$data['nama']."</a></td>
                                    <td>".$data['jabatan']."</td>
                                    <td>".$data['status']."</td>
                                    <td><a href=?page=admin&update-admin=".$data['kd_admin']." class=\"btn btn-primary\" type=\"button\">
                                    	<i class=\"fa fa-pencil\"></i> Update</a></td>
                                </tr>";
                                }
                            }
                        else echo "<tr class=danger><td colspan=8 align=center>Tidak Ada Record</td></td>";

                               ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</div>
<!------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
}

function view_request(){
	$kd_req = $_GET['view-req'];
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Request</h4></td>
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
                </div>
            </div></td>-->
            </tr>
        </table>           
    </div>
</div>

<div class="row">
    <div class="col-md-12">         
            
        <!--    Context Classes  -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <table width="100%">
                       <tbody>
                            <tr>
                                <td width="30%">Daftar Request Buku</td>
                                <td width="30%"></td>
                                <td width="20%"></td>
                                <td width="20%" align="">
                                    <form role="form">             
                                        <div class="input-group">
                                           
                                                
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
                                    <th>Kode Request</th>
                                    <th>Kode Pengaju</th>
                                    <th>Judul Buku</th>
                                	<th>Pengarang</th>
                                	<th>Penerbit</th>
                                	<th>Tahun Terbit</th>
                                	<th>Edisi</th>
                                	<th>Tanggal Request</th>
                                	<th>Realisasi</th>
                                	<th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	$no 	= 1;
								$sql 	= mysql_query("SELECT * FROM request WHERE kd_req = '$kd_req'");
								$jml 	= mysql_num_rows($sql);
								if($jml >=1){
									while ($data = mysql_fetch_array($sql)) {
									echo"
                                	<tr class=warning>
                                    <td>".$no."</td>
                                    <td>".$data['kd_req']."</td>
                                    <td>".$data['kd_pengaju']."</td>
                                    <td>".$data['judul']."</td>
                                    <td>".$data['pengarang']."</td>
                                    <td>".$data['penerbit']."</td>
                                    <td>".$data['th_terbit']."</td>
                                    <td>".$data['edisi']."</td>
                                    <td>".tgl_sql($data['tgl_req'])."</td>
                                    <td>Pending</td>
                                    <td><a href=\"?page=request&id=".$data['kd_req']."\" class=\"btn btn-primary\" type=\"button\"><i class=\"fa fa-plus\"></i> Acc</a></td>
                                	</tr>";                                
                        			}
                        		}else echo "<tr class=danger><td colspan=11 align=center>Tidak Ada Record</td></td>";

                               ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</div>
<?php
}?>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
function sirkulasi_orderby_member(){
      $per_page     = 10;
      $page_query   = mysql_query("SELECT count(*) FROM `peminjaman` CROSS JOIN `detail_pinjam` on
                      `peminjaman`.`kd_pinjam`=`detail_pinjam`.`kd_pinjam` AND 
                      `detail_pinjam`.status='dipinjam' GROUP BY `peminjaman`.`kd_member`");
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
                                echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&member&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                                for($x=1; $x<=$pages; $x++){
                                    $showPage = $x;
                                    if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                        if (($showPage != ($pages - 1)) && ($x == $pages))
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                        if ($x == $noPage)
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                        else
                                            echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&member&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                                }
                                if ($noPage < $pages)
                                    echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&member&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                            }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%">
                    <form role="form" method="post" action="?page=sirkulasi&member">             
                        <div class="input-group">
                             <input type="text" name="search" class="form-control" placeholder="Cari Kode Anggota" required>
                                 <span class="form-group input-group-btn">
                                     <button class="btn btn-default" type="submit">Cari</button>
                                     <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                            <li><a href="?page=sirkulasi&list=show">Kode Sirkulasi</a></li>
                                            <li><a href="?page=sirkulasi&member">Kode Anggota</a></li>
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
    $sql    = mysql_query("SELECT `peminjaman`.`kd_member` as memberid, `peminjaman`.kd_pinjam as kd1, 
                            `detail_pinjam`.kd_pinjam as kd2, COUNT(*) as counter,`peminjaman`.kd_petugas as kd_petugas
                            FROM `peminjaman` CROSS JOIN `detail_pinjam` on
                            `peminjaman`.`kd_pinjam`=`detail_pinjam`.`kd_pinjam` AND 
                            `detail_pinjam`.status='dipinjam'  GROUP BY `peminjaman`.`kd_member`
                            LIMIT $start,$per_page");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
        $mv  = mysql_query("SELECT jabatan FROM anggota WHERE kd_mem = '$data[memberid]'");
        $var = mysql_fetch_array($mv);
        $cat = $var['jabatan'];
            /*$kdp = $data['kd_pinjam'];
            $sql2 = mysql_query("SELECT * FROM detail_pinjam WHERE kd_pinjam = '$kdp' AND status = 'dipinjam'");
            $data2 = mysql_fetch_array($sql2);
            $jml2 = mysql_num_rows($sql2);*/
    ?>
        <tr class=warning>                                  
            <td class="text-center"><?php echo $no++; ?></td>
            <td class="text-center"><a href="?page=members&cat=<?php echo $cat; ?>&view-member=<?php echo $data['memberid'];?>"><?php echo $data['memberid']; ?></a></td>
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
                            `detail_pinjam`.status='dipinjam'  GROUP BY `peminjaman`.`kd_member`");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&member&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&member&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&member&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
        </div>
    </div>
</div>
</div>
</div>
</div>
<?php }?>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
function sirkulasi_orderby_member_search(){
    if(isset($_POST['search'])){$search = $_POST['search'];}
    elseif(isset($_GET['search'])){$search = $_GET['search'];}
      $per_page = 10;
      $page_query   = mysql_query("SELECT * FROM `peminjaman` CROSS JOIN `detail_pinjam` on
                            `peminjaman`.`kd_pinjam`=`detail_pinjam`.`kd_pinjam` AND 
                            `detail_pinjam`.status='dipinjam' AND `peminjaman`.kd_member LIKE '%$search%'");
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
                                echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&member&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                                for($x=1; $x<=$pages; $x++){
                                    $showPage = $x;
                                    if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                        if (($showPage != ($pages - 1)) && ($x == $pages))
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                        if ($x == $noPage)
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                        else
                                            echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&member&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                                }
                                if ($noPage < $pages)
                                    echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&member&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                            }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%">
                    <form role="form" method="post" action="?page=sirkulasi&member">             
                        <div class="input-group">
                             <input type="text" name="search" class="form-control" placeholder="Cari Kode Anggota" required>
                                 <span class="form-group input-group-btn">
                                     <button class="btn btn-default" type="submit">Cari</button>
                                     <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                            <li><a href="?page=sirkulasi&list=show">Kode Sirkulasi</a></li>
                                            <li><a href="?page=sirkulasi&member">Kode Anggota</a></li>
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
    $sql    = mysql_query("SELECT `peminjaman`.`kd_member` as memberid, `peminjaman`.kd_pinjam as kd1, 
                            `detail_pinjam`.kd_pinjam as kd2, COUNT(*) as counter,`peminjaman`.kd_petugas as kd_petugas
                            FROM `peminjaman` CROSS JOIN `detail_pinjam` on
                            `peminjaman`.`kd_pinjam`=`detail_pinjam`.`kd_pinjam` AND 
                            `detail_pinjam`.status='dipinjam' AND `peminjaman`.kd_member LIKE '%$search%' 
                            GROUP BY `peminjaman`.`kd_member`
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
            <td class="text-center"><a href="?page=members&cat=<?php echo $cat; ?>&view-member=<?php echo $data['memberid'];?>"><?php echo $data['memberid']; ?></a></td>
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
                            `detail_pinjam`.status='dipinjam' AND `peminjaman`.kd_member LIKE '%$search%' 
                            GROUP BY `peminjaman`.`kd_member`");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&member&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&member&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&member&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
        </div>
    </div>
</div>
</div>
</div>
</div>
<?php }
//---------------------------------------------------------function panggil form--------------------------------------------------------------
function form_buku(){
        if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {
?>
<div class="alert alert-warning">
    Gambar yang bisa di Upload hanya file dengan ekstensi <b>.jpg</b> dan besar file (file size) maksimal hanya 1 MB.
 </div>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM INPUT BUKU BARU
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
                <table width="100%">
                    <tr>
                        <td width="20%"><div class="form-group"><label>Kode Katalog</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="kd_cat" required autofocus/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Judul Buku</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="judul" required/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Pengarang</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="pengarang" required/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Jenis</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="jenis_pengarang" required/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Penyunting</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="penyunting" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Penerjemah</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="penerjemah" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Penerbit</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="penerbit" required/></div></td>
                    </tr>
                     <tr>
                        <td width="20%"><div class="form-group"><label>Kota Terbit</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="kota" required/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Tahun Terbit</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="th_terbit" required/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Edisi</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="edisi" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>ISSN ISBN</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="isbn" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Seri</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="seri" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Kode Klasifikasi</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="kd_klasifikasi" required/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Nama Klasifikasi</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="nama_klasifikasi" required/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Subjek Utama</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="subjek_utama" required/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Subjek Tambahan</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="subjek_tambahan" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Sirkulasi</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                                            <select class="form-control" name="sirkulasi" required>
                                            <?php $query = mysql_query("SELECT * FROM sirkulasi");
                                            	  while($data = mysql_fetch_array($query)){
                                            	  	echo "<option value=".$data['kd_sirkulasi'].">".$data['jenis']."</option>";
                                            	  }
                                           	?>                                                
                                            </select>
                                        </div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Lama Pinjam (hari)</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input maxlength="2" class="form-control" type="text" name="lama_pinjam" value="3" required/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Denda</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input maxlength="4" class="form-control" type="text" name="denda" value="1000" required/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Penerimaan</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                                            <select class="form-control" name="penerimaan" required>
                                                <option>Beli</option>
                                                <option>Donasi</option>
                                            </select>
                                        </div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Harga</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="harga" /></div></td>
                    </tr>  
                    <tr>
                        <td width="20%"><div class="form-group"><label>Abstrak</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><textarea class="form-control" rows="3" name="abstrak"></textarea></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Kategori</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="unit" id="unit">
                                                <option>Teknik</option>
                                                <option>Ekonomi</option>
                                                <option>Sastra</option>
                                                <option>Ilmu Komunikasi</option>
                                                <option>Umum</option>
                                            </select>
                                        </div>
                        </td>
                        </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Keterangan</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><textarea class="form-control" rows="3" name="ket"></textarea></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Gambar</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input type="file" name="img" required /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><br/><button type="submit" class="btn btn-info" name="simpan">Simpan </button>
                                            <a href="?page=catalogue" class="btn btn-danger"> Batal </a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}else{
    echo ' <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            Anda tidak memiliki hak untuk melihat halaman ini.
            </div>';}
}

function form_member(){
    if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {
?>
<div class="alert alert-warning">
    Gambar yang bisa di Upload hanya file dengan ekstensi <b>.jpg</b> dan besar file (file size) maksimal hanya 1 MB.
 </div>
            

    <div class="panel panel-info">
        <div class="panel-heading">
            FORM INPUT ANGGOTA
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data" onsubmit="return formValidatorMember()">
               <table width="100%">

               <tr>
                        <td width="20%"><div class="form-group"><label>Kode Anggota</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="kd_member" id="kd_mem" autofocus/></div></td>
                    </tr>               
                    <tr>
                        <td width="20%"><div class="form-group"><label>Nama</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="nama" id="nama" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>No Identitas (NIM/NIK/NIP)</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="nim" id="nim" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Jenis Kelamin</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                                            <select class="form-control" name="jk" id="jk">
                                            	<option>Please Choose</option>
                                                <option>Pria</option>
                                                <option>Wanita</option>
                                            </select>
                                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Tanggal Lahir</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input type="text" name="ttl" id="tanggal" id="tanggal" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Fakultas</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                                            <select class="form-control" name="fakultas" id="fakultas">
                                            	<option>Please Choose</option>
                                                <option>Teknik</option>
                                                <option>Sastra</option>
                                                <option>Ekonomi</option>
                                                <option>Ilmu Komunikasi</option>
                                            </select>
                                        </div>

                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Jurusan</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="jurusan" id="jurusan">
                                            	<option>Please Choose</option>
                                                <option>Teknik Informatika</option>
                                                <option>Manajemen Informatika</option>
                                                <option>Sastra Inggris</option>
                                                <option>Akuntansi</option>
                                                <option>Manajemen</option>
                                                <option>Ilmu Komunikasi</option>
                                                <option>Lainnya</option>
                                            </select>
                                        </div>
                        </td>
                        </tr>
                        <tr>
                        <td width="20%"><div class="form-group"><label>Semester</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="semester" id="semester">
                                            <option>Please Choose</option>
                                                <option>-</option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <option>6</option>
                                                <option>7</option>
                                                <option>8</option>
                                            </select>
                                        </div>
                        </td>
                    </tr>
                     <tr>
                        <td width="20%"><div class="form-group"><label>Jabatan</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="jabatan" id="jabatan">
                                            	<option>Please Choose</option>
                                                <option>Mahasiswa</option>
                                                <option>Dosen</option>
                                            </select>
                                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>No. Telp./HP</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="tlp" id="tlp" /></div></td>
                    </tr>                    
                    <tr>
                        <td width="20%"><div class="form-group"><label>Alamat</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><textarea class="form-control" rows="3" name="alamat" id="alamat"></textarea></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Alamat Email</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="email" id="email" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Password</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="password" name="password" id="password" />
                            <span class="label label-primary">Isikan 5-15 karakter</span></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Gambar Profil</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input type="file" name="img" id="img" /></div></td>
                    </tr> 
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><div class="form-group"><button type="submit" class="btn btn-info" name="reg">Register </button>
                        <a href="?page=members" class="btn btn-danger"> Batal </a></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}else{
    echo ' <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            Anda tidak memiliki hak untuk melihat halaman ini.
            </div>';}
}

/*function form_member_reg(){
?>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM INPUT ANGGOTA
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post">
               <table width="100%">
                    <tr>
                        <td width="20%"><div class="form-group"><label>Nama</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="nama" autofocus/></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>No Identitas (NIM/NIK/NIP)</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="nim" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Jenis Kelamin</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="radio">
                                                <label>
                                                    <input type="radio" name="jk" id="optionsRadios1" value="Pria" checked="">Pria
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="jk" id="optionsRadios2" value="Wanita">Wanita
                                                </label>
                                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Tanggal Lahir</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="tanggal" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Fakultas</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                                            <select class="form-control" name="fakultas">
                                                <option>Teknik</option>
                                                <option>Sastra</option>
                                                <option>Ekonomi</option>
                                                <option>Fikom</option>
                                            </select>
                                        </div>

                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Jurusan</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="jurusan">
                                                <option>Teknik Informatika</option>
                                                <option>Manajemen Informatika</option>
                                                <option>Sastra Inggris</option>
                                                <option>Akuntansi</option>
                                                <option>Manajemen</option>
                                                <option>Fikom</option>
                                            </select>
                                        </div>
                        </td>
                        </tr>
                        <tr>
                        <td width="20%"><div class="form-group"><label>Semester</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="semester">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <option>6</option>
                                                <option>7</option>
                                                <option>8</option>
                                            </select>
                                        </div>
                        </td>
                    </tr>
                     <tr>
                        <td width="20%"><div class="form-group"><label>Kelas</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="kelas">
                                                <option>Reguler</option>
                                                <option>Karyawan</option>
                                            </select>
                                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>No. Telp./HP</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="tlp" /></td>
                    </tr>                    
                    <tr>
                        <td width="20%"><div class="form-group"><label>Alamat</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><textarea class="form-control" rows="3" name="alamat"></textarea></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Alamat Email</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="email" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Password</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="password" name="password" /></td>
                    </tr> 
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><br/><button type="submit" class="btn btn-info" name="reg">Register </button></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}*/

function form_librarian(){
    if(isset($_SESSION['user']) and (($_SESSION['level'])=='admin')) {
?>
<div class="alert alert-warning">
    Gambar yang bisa di Upload hanya file dengan ekstensi <b>.jpg</b> dan besar file (file size) maksimal hanya 1 MB.
 </div>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM INPUT PETUGAS
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data" onsubmit="return formValidatorLib()">
               <table width="100%">
               <tr>
                        <td width="20%"><div class="form-group"><label>Kode Petugas</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="kd_petugas" id="kd_petugas" autofocus/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Nama</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="nama" id="nama" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>NIK</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="nik" id="nik" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Jenis Kelamin</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                                            <select class="form-control" name="jk" id="jk">
                                                <option>Please Choose</option>
                                                <option>Pria</option>
                                                <option>Wanita</option>
                                            </select>
                                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Tanggal Lahir</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input type="text" name="ttl" id="tanggal" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Jabatan</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="jabatan" id="jabatan">
                                            	<option>Please Choose</option>
                                                <option>Kepala Pustaka</option>
                                                <option>Petugas</option>
                                            </select>
                                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>No. Telp./HP</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="tlp" id="tlp" /></div></td>
                    </tr>                    
                    <tr>
                        <td width="20%"><div class="form-group"><label>Alamat</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><textarea class="form-control" rows="3" name="alamat" id="alamat" /></textarea></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Alamat Email</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="email" id="email" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Password</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="password" name="password" id="password" /></div></td>
                    </tr> 
                    <tr>
                        <td width="20%"><div class="form-group"><label>Level<label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="level" id="level">
                                            	<option>Please Choose</option>
                                                <option>petugas</option>
                                                <option>admin</option>
                                            </select>
                                        </div>
                        </td>
                    </tr>
                     <tr>
                        <td width="20%"><div class="form-group"><label>Gambar Profil</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input type="file" name="img" id="img" required /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><div class="form-group"><button type="submit" class="btn btn-info" name="reg">Register </button>
                        <a href="?page=librarians" class="btn btn-danger"> Batal </a></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}else{
    echo ' <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            Anda tidak memiliki hak untuk melihat halaman ini.
            </div>';}
}

/*function form_admin(){
?>
<div class="alert alert-warning">
    Gambar yang bisa di Upload hanya file dengan ekstensi <b>.jpg</b> dan besar file (file size) maksimal hanya 1 MB.
 </div>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM INPUT ADMIN
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data" onsubmit="return formValidatorAdm()">
               <table width="100%">
               <tr>
                        <td width="20%"><div class="form-group"><label>Kode Admin</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="kd_admin" id="kd_admin" autofocus/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Nama</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="nama" id="nama" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>NIK</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="nik" id="nik" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Jenis Kelamin</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                                            <select class="form-control" name="jk" id="jk">
                                            	<option>Please Choose</option>
                                                <option>Pria</option>
                                                <option>Wanita</option>
                                            </select>
                                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Tanggal Lahir</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input type="text" name="ttl" id="tanggal" /></td>
                    </tr>
                     <tr>
                        <td width="20%"><div class="form-group"><label>Jabatan</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="jabatan" id="jabatan">
                                            	<option>Please Choose</option>
                                                <option>Admin</option>
                                                <option>Administrator</option>
                                            </select>
                                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>No. Telp./HP</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="tlp" id="tlp" /></div></td>
                    </tr>                    
                    <tr>
                        <td width="20%"><div class="form-group"><label>Alamat</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><textarea class="form-control" rows="3" name="alamat" id="alamat"></textarea></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Alamat Email</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="email" id="email" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Password</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="password" name="password" id="password" /></div></td>
                    </tr>
                     <tr>
                        <td width="20%"><div class="form-group"><label>Gambar Profil</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input type="file" name="img" id="img" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><br/><button type="submit" class="btn btn-info" name="reg">Register </button></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}*/

function form_request(){
?>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM REQUEST BUKU
        </div>
        <div class="panel-body">
            <form role="form" method="post" action="">
                <table width="100%">
                    <tr>
                        <td width="20%"><div class="form-group"><label>Judul Buku</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="judul" required /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Nama Pengarang</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="pengarang" required/></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Nama Penerbit</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="penerbit" required/></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Tahun Terbit</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="th_terbit" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Edisi</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="edisi" /></td>
                    </tr>
                     <tr>
                        <td width="20%"></td>
                        <td width="5%"><input type="hidden" name="kd_mem" id="kd_mem" value="<?php echo $_SESSION['user'];?>"></td>
                        <td width="70%"><div class="form-group"><button type="submit" class="btn btn-info" name="request">Request </button>
                        <a href="?page=request" class="btn btn-danger"> Batal </a></div>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}

//---------------------------------------------------------function panggil form uodate-------------------------------------------------------
function form_update_buku_info(){
	$kd_buku=$_GET['id'];
	$query	= mysql_query("SELECT * FROM buku WHERE kd_buku='$kd_buku'") or die (mysql_error());
	$data	= mysql_fetch_array($query);

if(isset($_POST['update'])){
$date       = date("Y-m-d");
$kd_buku    = $_GET['id'];

$judul      = mysql_real_escape_string($_POST['judul']);
$edisi      = mysql_real_escape_string($_POST['edisi']);
$seri       = mysql_real_escape_string($_POST['seri']);

$allowed_ext    = array('jpg');
$file_name      = $_FILES['img']['name'];
$file_ext       = strtolower(end(explode('.', $file_name)));
$file_size      = $_FILES['img']['size'];
$file_tmp       = $_FILES['img']['tmp_name'];
$kd_petugas = $_SESSION['user'];
     
if(empty($file_name)){   //jika gambar kosong atau tidak di ganti
    $q  = mysql_query("UPDATE buku SET
            kd_cat      = '$_POST[kd_cat]',
            kd_petugas  = '$kd_petugas',
            judul       = '$judul',
            edisi       = '$edisi',
            issn_isbn   = '$_POST[isbn]',
            seri        = '$seri',            
            unit        = '$_POST[unit]',
            harga       = '$_POST[harga]',
            penerimaan  = '$_POST[penerimaan]',
            lama_pinjam = '$_POST[lama_pinjam]',
            date_update = '$date',
            status      = '$_POST[status]',
            ket_buku    = '$_POST[ket]'
            WHERE kd_buku='$kd_buku'") or die (mysql_error());

                if($q){
            ?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di update <a href="?page=detail-catalogue&id=<?php echo $kd_buku ;?>" class="alert-link">Kembali</a>
                </div>
            <?php 
            }

}elseif(!empty($file_name)) { // jika gambar di ganti
if(in_array($file_ext, $allowed_ext) === true){
    if($file_size < 1044070){
        $lokasi = 'assets/bp/'.$kd_buku.'.'.$file_ext;
        move_uploaded_file($file_tmp, $lokasi);

        $q  = mysql_query("UPDATE buku SET
            kd_petugas  = '$kd_petugas',
            judul       = '$judul',
            edisi       = '$edisi',
            issn_isbn   = '$_POST[isbn]',
            seri        = '$seri',
            unit        = '$_POST[unit]',
            harga       = '$_POST[harga]',
            penerimaan  = '$_POST[penerimaan]',
            lama_pinjam = '$_POST[lama_pinjam]',
            date_update = '$date',
            status      = '$_POST[status]',
            image       = '$lokasi',
            ket_buku    = '$_POST[ket]'
            WHERE kd_buku='$kd_buku'") or die (mysql_error());
                
                if($q){
?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        Data berhasil di input <a href="?page=detail-catalogue&id=<?php echo $kd_buku ;?>" class="alert-link">Kembali</a>
                    </div>
<?php 
                }else{
                    echo '<div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Gagal upload file!</div>';
                }
            }else{
                echo '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Besar ukuran file (file size) maksimal 1 Mb!</div>';
            }
        }else{
                    echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Ekstensi file tidak di izinkan!</div>';
        }
    }   
}
	?>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM UPDATE BUKU
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
                <table width="100%">
                	<tr>
                        <td width="20%"><div class="form-group"><label>Gambar</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><img src="<?php echo $data['image']; ?>?nocache=<?php echo time(); ?>" width="100px" height="100px">
                        				<div class="form-group"><input type="file" name="img" /></div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Kode Buku</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="kd_buku" readonly value="<?php echo $data['kd_buku'];?>" /></td>
                    </tr>                    
                    <tr>
                        <td width="20%"><div class="form-group"><label>Kode Katalog</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="kd_cat" readonly value="<?php echo $data['kd_cat'];?>" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Judul Buku</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="judul" value="<?php echo $data['judul'];?>" autofocus required/></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Edisi</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="edisi" value="<?php echo $data['edisi'];?>"  /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>ISSN ISBN</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="isbn" value="<?php echo $data['issn_isbn'];?>" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Seri</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="seri" value="<?php echo $data['seri'];?>" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Kategori</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                                            <select class="form-control" name="unit">
                                                <option><?php echo $data['unit'];?></option>
                                                <?php
                                                if($data['unit']=='Umum'){
                                                echo "<option>Teknik</option>";
                                                echo "<option>Sastra</option>";
                                                echo "<option>Ekonomi</option>";
                                                echo "<option>Ilmu Komunikasi</option>";
                                                }
                                                elseif($data['unit']=='Teknik'){
                                                echo "<option>Umum</option>";
                                                echo "<option>Sastra</option>";
                                                echo "<option>Ekonomi</option>";
                                                echo "<option>Ilmu Komunikasi</option>";
                                                }
                                                elseif($data['unit']=='Sastra'){
                                                echo "<option>Teknik</option>";
                                                echo "<option>Umum</option>";
                                                echo "<option>Ekonomi</option>";
                                                echo "<option>Ilmu Komunikasi</option>";
                                                }
                                                elseif($data['unit']=='Ekonomi'){
                                                echo "<option>Teknik</option>";
                                                echo "<option>Sastra</option>";
                                                echo "<option>Umum</option>";
                                                echo "<option>Ilmu Komunikasi</option>";
                                                }
                                                 elseif($data['unit']=='Ilmu Komunikasi'){
                                                echo "<option>Teknik</option>";
                                                echo "<option>Sastra</option>";
                                                echo "<option>Ekonomi</option>";
                                                echo "<option>Umum</option>";
                                                }

                                                ?>
                                            </select>
                                        </div></td>
                    </tr> 
                    <tr>
                        <td width="20%"><div class="form-group"><label>Penerimaan</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="penerimaan" value="<?php echo $data['penerimaan'];?>" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Harga</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="harga" value="<?php echo $data['harga'];?>" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Lama Pinjam</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="lama_pinjam" value="<?php echo $data['lama_pinjam'];?>" required/></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Denda</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="denda" value="<?php echo $data['denda'];?>" required/></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Status</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                                            <select class="form-control" name="status">
                                                <option><?php echo $data['status'];?></option>
                                                <?php
                                                if($data['status']=='Tersedia'){
                                                echo "<option>Tidak Tersedia</option>";
                                                echo "<option>Hilang</option>";
                                                echo "<option>Digudang</option>";
                                                }
                                                elseif($data['status']=='Tidak Tersedia'){
                                                echo "<option>Tersedia</option>";
                                                echo "<option>Hilang</option>";
                                                echo "<option>Digudang</option>";
                                                }
                                                elseif($data['status']=='Hilang'){
                                                echo "<option>Tersedia</option>";
                                                echo "<option>Tidak Tersedia</option>";
                                                echo "<option>Digudang</option>";
                                                }
                                                elseif($data['status']=='Digudang'){
                                                echo "<option>Tersedia</option>";
                                                echo "<option>Tidak Tersedia</option>";
                                                echo "<option>Hilang</option>";
                                                }

                                                ?>
                                            </select>
                                        </div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Keterangan</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><textarea class="form-control" rows="3" name="ket"><?php echo $data['ket_buku'];?></textarea></div></td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><div class="form-group"><button type="submit" class="btn btn-info" name="update">Simpan </button>
                                        <a href="?page=detail-catalogue&id=<?php echo $kd_buku;?>" class="btn btn-danger"> Batal </a></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

<?php
}

function form_update_buku_abstrak(){
    $kd_buku=$_GET['id'];
    $query  = mysql_query("SELECT * FROM buku WHERE kd_buku='$kd_buku'") or die (mysql_error());
    $data   = mysql_fetch_array($query);

if(isset($_POST['update'])){
$date       = date("Y-m-d");
$kd_buku    = $_GET['id'];

$abstrak       = mysql_real_escape_string($_POST['abstrak']);

    $q  = mysql_query("UPDATE buku SET
            abstrak      = '$_POST[abstrak]'            
            WHERE kd_buku='$kd_buku'") or die (mysql_error());

                if($q){
            ?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di update <a href="?page=detail-catalogue&id=<?php echo $kd_buku ;?>" class="alert-link">Kembali</a>
                </div>
            <?php 
            }
}
    ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM UPDATE ABSTRAK
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
                <table width="100%">
                    <tr>
                        <td width="20%"><div class="form-group"><label>Abstrak</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><textarea class="form-control" rows="10" name="abstrak"><?php echo $data['abstrak'];?></textarea></div></td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><div class="form-group"><button type="submit" class="btn btn-info" name="update">Simpan </button>
                                        <a href="?page=detail-catalogue&id=<?php echo $kd_buku;?>" class="btn btn-danger"> Batal </a></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}

function form_update_buku_pengarang(){
    $kd_buku=$_GET['id'];
    $query  = mysql_query("SELECT * FROM buku WHERE kd_buku='$kd_buku'") or die (mysql_error());
    $data   = mysql_fetch_array($query);
    $query2  = mysql_query("SELECT * FROM pengarang WHERE kd_pengarang='$data[kd_pengarang]'") or die (mysql_error());
    $data2   = mysql_fetch_array($query2);

    if(isset($_POST['update'])){
    $date       = date("Y-m-d");

    $q  = mysql_query("UPDATE pengarang SET
            nama        = '$_POST[nama]',
            jenis       = '$_POST[jenis]',
            penyunting  = '$_POST[penyunting]',
            penterjemah = '$_POST[penerjemah]'           
            WHERE kd_pengarang='$data[kd_pengarang]'") or die (mysql_error());

                if($q){
            ?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di update <a href="?page=detail-catalogue&id=<?php echo $kd_buku ;?>" class="alert-link">Kembali</a>
                </div>
            <?php 
            }
}
    ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM UPDATE PENGARANG
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
                <table width="100%">
                    <tr>
                        <td width="20%"><div class="form-group"><label>Nama</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="nama" value="<?php echo $data2['nama'];?>" autofocus required/></td>
                    </tr>                    
                    <tr>
                        <td width="20%"><div class="form-group"><label>Kategori</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="jenis" value="<?php echo $data2['jenis'];?>" required/></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Penyunting</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="penyunting" value="<?php echo $data2['penyunting'];?>" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Penerjemah</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="penerjemah" value="<?php echo $data2['penterjemah'];?>"  /></td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><div class="form-group"><button type="submit" class="btn btn-info" name="update">Simpan </button>
                                        <a href="?page=detail-catalogue&id=<?php echo $kd_buku;?>" class="btn btn-danger"> Batal </a></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}

function form_update_buku_penerbit(){
    $kd_buku=$_GET['id'];
    $query  = mysql_query("SELECT * FROM buku WHERE kd_buku='$kd_buku'") or die (mysql_error());
    $data   = mysql_fetch_array($query);
    $query2  = mysql_query("SELECT * FROM penerbit WHERE kd_penerbit='$data[kd_penerbit]'") or die (mysql_error());
    $data2   = mysql_fetch_array($query2);

    if(isset($_POST['update'])){
$date       = date("Y-m-d");

    $q  = mysql_query("UPDATE penerbit SET
            nama_penerbit      = '$_POST[nama]',
            kota               = '$_POST[kota]'           
            WHERE kd_penerbit='$data[kd_penerbit]'") or die (mysql_error());

    $q2  = mysql_query("UPDATE buku SET
            thn_terbit     = '$_POST[tahun]'          
            WHERE kd_buku='$kd_buku'") or die (mysql_error());

                if($q and $q2){
            ?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di update <a href="?page=detail-catalogue&id=<?php echo $kd_buku ;?>" class="alert-link">Kembali</a>
                </div>
            <?php 
            }
}
    ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM UPDATE PENERBIT
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
                <table width="100%">
                    <tr>
                        <td width="20%"><div class="form-group"><label>Nama</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="nama" value="<?php echo $data2['nama_penerbit'];?>" autofocus required/></td>
                    </tr>                    
                    <tr>
                        <td width="20%"><div class="form-group"><label>Kota</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="kota" value="<?php echo $data2['kota'];?>" required/></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Tahun</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="tahun" value="<?php echo $data['thn_terbit'];?>" required/></td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><div class="form-group"><button type="submit" class="btn btn-info" name="update">Simpan </button>
                                        <a href="?page=detail-catalogue&id=<?php echo $kd_buku;?>" class="btn btn-danger"> Batal </a></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}

function form_update_buku_sirkulasi(){
    $kd_buku=$_GET['id'];
    $query  = mysql_query("SELECT * FROM buku WHERE kd_buku='$kd_buku'") or die (mysql_error());
    $data   = mysql_fetch_array($query);

if(isset($_POST['update'])){
$date       = date("Y-m-d");
$kd_buku    = $_GET['id'];

if($_POST['sirkulasi']=='Ya'){
    $sirkulasi = "SI01";
}elseif($_POST['sirkulasi']=='Tidak'){
    $sirkulasi = "SI02";
}
   

    $q  = mysql_query("UPDATE buku SET
            kd_sirkulasi      = '$sirkulasi'            
            WHERE kd_buku='$kd_buku'") or die (mysql_error());

                if($q){
            ?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di update <a href="?page=detail-catalogue&id=<?php echo $kd_buku ;?>" class="alert-link">Kembali</a>
                </div>
            <?php 
            }
}
    ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM UPDATE SIRKULASI
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
                <table width="100%">
                    <tr>
                        <td width="20%"><div class="form-group"><label>Sirkulasi</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                                            <select class="form-control" name="sirkulasi">
                                                <option><?php if($data['kd_sirkulasi']=='SI01'){echo "Ya";}else{echo "Tidak";}?></option>
                                                <option><?php if($data['kd_sirkulasi']=='SI01'){echo "Tidak";}else{echo "Ya";}?></option>
                                            </select>
                                        </div></td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><div class="form-group"><button type="submit" class="btn btn-info" name="update">Simpan </button>
                                        <a href="?page=detail-catalogue&id=<?php echo $kd_buku;?>" class="btn btn-danger"> Batal </a></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}

function form_update_member(){
	$kd_mem=$_GET['update-member'];
	$query	= mysql_query("SELECT * FROM anggota WHERE kd_mem='$kd_mem'") or die (mysql_error());
	$data	= mysql_fetch_array($query);
	?>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM UPDATE ANGGOTA
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
                <table width="100%">
                	<tr>
                        <td width="20%"><div class="form-group"><label>Gambar</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><img src="<?php echo $data['image']; ?>?nocache=<?php echo time(); ?>" width="100px" height="100px">
                        				<div class="form-group"><input type="file" name="img" /></div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Kode Anggota</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="kd_member" value="<?php echo $data['kd_mem'];?>" readonly/></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Nama</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="nama" value="<?php echo $data['nama'];?>" autofocus required/></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>No Identitas (NIM/NIK/NIP)</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="nim" value="<?php echo $data['nim'];?>" required/></td>
                    </tr>
                    <tr>
                        <tr>
                        <td width="20%"><div class="form-group"><label>Jenis Kelamin</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="jk">
                                                <option><?php echo $data['jk'];?></option>
                                                <option><?php if($data['jk']=='Pria'){echo "Wanita";}else{echo "Pria";}?></option>
                                            </select>
                                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Tanggal Lahir</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input type="text" name="ttl" id="tanggal" value="<?php echo tgl_sql($data['ttl']);?>" required/></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Fakultas</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                                            <select class="form-control" name="fakultas">
                                            	<option><?php echo $data['fakultas'];?></option>
                                                <?php if($data['fakultas']=='Teknik') {
                                                		echo "<option>Sastra</option>
                                                		  	  <option>Ekonomi</option>
                                                		  	  <option>Ilmu Komunikasi</option>";}
                                                	  elseif ($data['fakultas']=='Sastra') {
                                                		echo "<option>Teknik</option>
                                                			  <option>Ekonomi</option>
                                                			  <option>Ilmu Komunikasi</option>";}
                                                	  elseif ($data['fakultas']=='Ekonomi') {
                                                		echo "<option>Sastra</option>
                                                			  <option>Teknik</option>
                                                			  <option>Ilmu Komunikasi</option>";}
                                                	  elseif ($data['fakultas']=='Ilmu Komunikasi') {
                                                		echo "<option>Sastra</option>
                                                			  <option>Teknik</option>
                                                			  <option>Ekonomi</option>";} ?>
                                                
                                            </select>
                                        </div>

                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Jurusan</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="jurusan">
                                            <option><?php echo $data['jurusan'];?></option>
                                            <?php if($data['jurusan']=='Teknik Informatika') {
                                                	echo "<option>Manajemen Informatika</option>";
                                                	echo "<option>Sastra Inggris</option>";
                                            		echo "<option>Ilmu Komunikasi</option>";
                                        			echo "<option>Akuntansi</option>";
                                        			echo "<option>Manajemen</option>";
                                                    echo "<option>Lainnya</option>";}
                                        		  elseif($data['jurusan']=='Manajemen Informatika') {
                                                	echo "<option>Teknik Informatika</option>";
                                                	echo "<option>Sastra Inggris</option>";
                                            		echo "<option>Ilmu Komunikasi</option>";
                                        			echo "<option>Akuntansi</option>";
                                        			echo "<option>Manajemen</option>";
                                                    echo "<option>Lainnya</option>";}
                                        		  elseif($data['jurusan']=='Sastra Inggris') {
                                                	echo "<option>Teknik Informatika</option>";
                                                	echo "<option>Manajemen Informatika</option>";
                                            		echo "<option>Ilmu Komunikasi</option>";
                                        			echo "<option>Akuntansi</option>";
                                        			echo "<option>Manajemen</option>";
                                                    echo "<option>Lainnya</option>";}
                                        		  elseif($data['jurusan']=='Ilmu Komunikasi') {
                                                	echo "<option>Teknik Informatika</option>";
                                            		echo "<option>Manajemen Informatika</option>";
                                                	echo "<option>Sastra Inggris</option>";
                                        			echo "<option>Akuntansi</option>";
                                        			echo "<option>Manajemen</option>";
                                                    echo "<option>Lainnya</option>";}
                                        		  elseif($data['jurusan']=='Manajemen') {
                                        			echo "<option>Akuntansi</option>";
                                                	echo "<option>Teknik Informatika</option>";
                                        			echo "<option>Manajemen Informatika</option>";
                                                	echo "<option>Sastra Inggris</option>";
                                            		echo "<option>Ilmu Komunikasi</option>";
                                                    echo "<option>Lainnya</option>";}
                                        		  elseif($data['jurusan']=='Akuntansi') {
                                        			echo "<option>Manajemen</option>";
                                                	echo "<option>Teknik Informatika</option>";
                                        			echo "<option>Manajemen Informatika</option>";
                                                	echo "<option>Sastra Inggris</option>";
                                            		echo "<option>Ilmu Komunikasi</option>";
                                                    echo "<option>Lainnya</option>";}
                                                  elseif($data['jurusan']=='Lainnya') {
                                                    echo "<option>Manajemen</option>";
                                                    echo "<option>Teknik Informatika</option>";
                                                    echo "<option>Manajemen Informatika</option>";
                                                    echo "<option>Sastra Inggris</option>";
                                                    echo "<option>Ilmu Komunikasi</option>";
                                                    echo "<option>Akuntansi</option>";}
                                            ?>
                                            <!--Fakultas Teknik -->
                                            	<?php /*if($data['fakultas']=='Teknik'){ 
                                            			echo "<option>".$data['jurusan']."</option>";
													 		if($data['jurusan']=='Teknik Informatika') {
                                                				echo "<option>Manajemen Informatika</option>";}
                                                	  		elseif ($data['jurusan']=='Manajemen Informatika') {
                                                	  			echo "<option>Manajemen Informatika</option>";}
                                                	  }
                                            //Fakultas Sastra -->
                                                	  elseif($data['fakultas']=='Sastra'){ 
                                            			echo "<option>".$data['jurusan']."</option>";
											 		  }
											//Fakulatas Ekonomi
													elseif($data['fakultas']=='Ekonomi'){ 
                                            			echo "<option>".$data['jurusan']."</option>";
															if($data['jurusan']=='Akuntansi') {
                                                				echo "<option>Manajemen</option>";}
                                                	  		elseif ($data['jurusan']=='Manajemen') {
                                                	  			echo "<option>Akuntansi</option>";}
                                                	  }
                                                //Fakultas Fikom -->
                                            		  elseif($data['fakultas']=='Fikom'){ 
                                            			echo "<option>".$data['jurusan']."</option>";
												 	  }*/ ?>
                                            </select>
                                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Semester</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="semester">
                                            <option><?php echo $data['semester'];?></option>
                                            <?php if($data['semester']=='1') {
                                                	echo "<option>2</option>";
                                                	echo "<option>3</option>";
                                            		echo "<option>4</option>";
                                        			echo "<option>5</option>";
                                        			echo "<option>6</option>";
                                        			echo "<option>7</option>";
                                        			echo "<option>8</option>";
                                                    echo "<option>-</option>";}
                                        		  elseif($data['semester']=='2') {
                                                	echo "<option>3</option>";
                                            		echo "<option>4</option>";
                                        			echo "<option>5</option>";
                                        			echo "<option>6</option>";
                                        			echo "<option>7</option>";
                                        			echo "<option>8</option>";}
                                        		  elseif($data['semester']=='3') {
                                            		echo "<option>4</option>";
                                        			echo "<option>5</option>";
                                        			echo "<option>6</option>";
                                        			echo "<option>7</option>";
                                        			echo "<option>8</option>";
                                                    echo "<option>-</option>";}
                                        		  elseif($data['semester']=='4') {
                                        			echo "<option>5</option>";
                                        			echo "<option>6</option>";
                                        			echo "<option>7</option>";
                                        			echo "<option>8</option>";
                                                    echo "<option>-</option>";}
                                        		  elseif($data['semester']=='5') {
                                        			echo "<option>6</option>";
                                        			echo "<option>7</option>";
                                        			echo "<option>8</option>";
                                                    echo "<option>-</option>";}
                                        		  elseif($data['semester']=='6') {
                                        			echo "<option>7</option>";
                                        			echo "<option>8</option>";
                                                    echo "<option>-</option>";}
                                        		  elseif($data['semester']=='7') {
                                        			echo "<option>8</option>";}
                                        		  elseif($data['semester']=='8') {
                                        			echo "<option>-</option>";}
                                                  elseif($data['semester']=='-') {
                                                    echo "";}
                                            ?>
                                            </select>
                                        </div>
                        </td>
                    </tr>
                     <tr>
                        <td width="20%"><div class="form-group"><label>Jabatan</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="jabatan">
                                            	<option><?php echo $data['jabatan'];?></option>
                                            	<?php if($data['jabatan']=='Mahasiswa') {
                                                		echo "<option>Dosen</option>";}
                                                	  elseif ($data['Jabatan']=='Dosen') {
                                                	  	echo "<option>Mahasiswa</option>";}?>
                                            </select>
                                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>No. Telp./HP</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="tlp" value="<?php echo $data['tlp'];?>" required/></td>
                    </tr>                    
                    <tr>
                        <td width="20%"><div class="form-group"><label>Alamat</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><textarea class="form-control" rows="3" name="alamat" required><?php echo $data['alamat'];?></textarea></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Email</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="email" value="<?php echo $data['email'];?>" required/></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Status</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                                            <select class="form-control" name="status">
                                            <option><?php echo $data['status_mem'];?></option>
                                            <?php if($data['status_mem']=='Aktif') {
                                                	echo "<option>Tidak Aktif</option>";
                                                	echo "<option>Black List</option>";}
                                                  elseif($data['status_mem']=='Tidak Aktif') {
                                                	echo "<option>Aktif</option>";
                                                	echo "<option>Black List</option>";}
                                                  elseif($data['status_mem']=='Black List') {
                                                	echo "<option>Tidak Aktif</option>";
                                                	echo "<option>Aktif</option>";}?>
                        					</select>
                        				</div>
                        </td>
                    </tr>
                     <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><div class="form-group"><button type="submit" class="btn btn-info" name="update">Simpan </button> 
                                    <a href="?page=members&<?php echo $cat; ?>&view-member=<?php echo $kd_mem;?>" class="btn btn-danger"> Batal </a></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}

function form_update_librarian(){
    if(isset($_SESSION['user']) and (($_SESSION['level'])=='admin')) {
	$kd_petugas 	= $_GET['update-librarian'];
	$query			= mysql_query("SELECT * FROM petugas WHERE kd_petugas='$kd_petugas'") or die (mysql_error());
	$data			= mysql_fetch_array($query);
	?>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM UPDATE PETUGAS
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
                <table width="100%">
                	<tr>
                        <td width="20%"><div class="form-group"><label>Gambar</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><img src="<?php echo $data['image']; ?>?nocache=<?php echo time(); ?>" width="100px" height="100px">
                        				<div class="form-group"><input type="file" name="img" /></div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Kode Petugas</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="kd_petugas" readonly value="<?php echo $data['kd_petugas'];?>" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Nama</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="nama" value="<?php echo $data['nama'];?>" autofocus required/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>NIK</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="nik" value="<?php echo $data['nik'];?>" required/></div></td>
                    </tr>
                    <tr>
                        <tr>
                        <td width="20%"><div class="form-group"><label>Jenis Kelamin</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="jk">
                                                <option><?php echo $data['jk'];?></option>
                                                <option><?php if($data['jk']=='Pria'){echo"Wanita";} else {echo "Pria";}?></option>
                                            </select>
                                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Tanggal Lahir</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input type="text" name="ttl" id="tanggal" value="<?php echo tgl_sql($data['ttl']);?>" required/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Jabatan</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="jabatan">
                                            <option><?php echo $data['jabatan'];?></option>
                                            <?php if($data['jabatan']=='Administrator') {
                                                	echo "<option>Kepala Petugas</option>";
                                                	echo "<option>Petugas</option>";}
                                                  elseif($data['jabatan']=='Petugas') {
                                                	echo "<option>Kepala Petugas</option>";
                                                	echo "<option>Administrator</option>";}
                                                elseif($data['jabatan']=='Kepala Petugas') {
                                                	echo "<option>Petugas</option>";
                                                	echo "<option>Administrator</option>";}?>
                        					</select>
                        				</div>
                        </td>
                    </tr>                        
                    <tr>
                        <td width="20%"><div class="form-group"><label>No. Telp./HP</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="tlp" value="<?php echo $data['tlp'];?>" required/></div></td>
                    </tr>                    
                    <tr>
                        <td width="20%"><div class="form-group"><label>Alamat</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><textarea class="form-control" rows="3" name="alamat" required><?php echo $data['alamat'];?></textarea></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Status</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                                            <select class="form-control" name="status">
                                            <option><?php echo $data['status'];?></option>
                                            <?php if($data['status']=='Aktif') {
                                                	echo "<option>Tidak Aktif</option>";}
                                                  elseif($data['status']=='Tidak Aktif') {
                                                	echo "<option>Aktif</option>";}?>
                        					</select>
                        				</div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Level</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                                            <select class="form-control" name="level">
                                            <option><?php echo $data['level'];?></option>
                                            <?php if($data['level']=='petugas') {
                                                	echo "<option>admin</option>";}
                                                  elseif($data['level']=='admin') {
                                                	echo "<option>petugas</option>";}?>
                        					</select>
                        				</div>
                        </td>
                    </tr>
                     <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><div class="form-group"><button type="submit" class="btn btn-info" name="update">Simpan </button>
                        				<a href="?page=librarians" class="btn btn-danger"> Batal </a></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}else{
    echo ' <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            Anda tidak memiliki hak untuk melihat halaman ini.
            </div>';}
}

function form_update_admin(){
	$kd_admin 	= $_GET['update-admin'];
	$query			= mysql_query("SELECT * FROM admin WHERE kd_admin='$kd_admin'") or die (mysql_error());
	$data			= mysql_fetch_array($query);
	?>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM UPDATE PETUGAS
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
                <table width="100%">
                	<tr>
                        <td width="20%"><div class="form-group"><label>Gambar</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><img src="<?php echo $data['image']; ?>?nocache=<?php echo time(); ?>" width="100px" height="100px">
                        				<div class="form-group"><input type="file" name="img" /></div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Kode Admin</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="kd_admin" readonly value="<?php echo $data['kd_admin'];?>" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Nama</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="nama" value="<?php echo $data['nama'];?>" autofocus/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>NIK</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="nik" value="<?php echo $data['nik'];?>" autofocus/></div></td>
                    </tr>
                    <tr>
                        <tr>
                        <td width="20%"><div class="form-group"><label>Jenis Kelamin</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="jk">
                                                <option><?php echo $data['jk'];?></option>
                                                <option><?php if($data['jk']=='Pria'){echo"Wanita";} else {echo "Pria";}?></option>
                                            </select>
                                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Tanggal Lahir</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input type="text" name="ttl" id="tanggal" value="<?php echo tgl_sql($data['ttl']);?>" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Jabatan</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%">
                        <div class="form-group"><div class="form-group">
                                            <select class="form-control" name="jabatan">
                                            <option><?php echo $data['jabatan'];?></option>
                                            <?php if($data['jabatan']=='Admin') {
                                                	echo "<option>Administrator</option>";}
                                                  elseif($data['jabatan']=='Administrator') {
                                                	echo "<option>Admin</option>";}?>
                        					</select>
                        				</div>
                        </td>
                    </tr>                        
                    <tr>
                        <td width="20%"><div class="form-group"><label>No. Telp./HP</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="tlp" value="<?php echo $data['tlp'];?>" /></div></td>
                    </tr>                    
                    <tr>
                        <td width="20%"><div class="form-group"><label>Alamat</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><textarea class="form-control" rows="3" name="alamat"><?php echo $data['alamat'];?></textarea></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Status</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                                            <select class="form-control" name="status">
                                            <option><?php echo $data['status'];?></option>
                                            <?php if($data['status']=='Aktif') {
                                                	echo "<option>Tidak Aktif</option>";}
                                                  elseif($data['status']=='Tidak Aktif') {
                                                	echo "<option>Aktif</option>";}?>
                        					</select>
                        				</div>
                        </td>
                    </tr>
                     <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><div class="form-group"><button type="submit" class="btn btn-info" name="update">Simpan </button>
                        				<a href="?page=admin" class="btn btn-danger"> Batal </a></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}

//------------------------------------------------------------------ fungsi view --------------------------------------------------------------------
function form_view_member(){
	$kd_mem = $_GET['view-member'];
	$query	= mysql_query("SELECT * FROM anggota WHERE kd_mem='$kd_mem'") or die (mysql_error());
	$data	= mysql_fetch_array($query);
    $cat    = $data['jabatan'];
	?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <table width="100%">
                <tr>
                    <td width="50%">PROFIL ANGGOTA</td>
                    <td width="50%" class="text-right"><a href="?page=history-sirkulasi-mhs&member-id=<?php echo $kd_mem;?>" class="btn btn-info">
                        <i class="fa fa-history"></i> Lihat Histori Pinjam</a></td>
                </tr>
            </table>
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
                <table class="table" width="100%">
                	<tr>
                        <td width="20%" rowspan="15"><img src="<?php echo $data['image']; ?>?nocache=<?php echo time(); ?>" width="300px" height="300px"></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Kode Anggota</label></div></td>
                        <td><?php echo $data['kd_mem'];?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Nama</label></div></td>
                        <td><?php echo $data['nama'];?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>No Identitas (NIM/NIK/NIP)</label></div></td>
                        <td><?php echo $data['nim'];?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Jenis Kelamin</label></div></td>
                        <td><?php echo $data['jk'];?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Tanggal Lahir</label></div></td>
                        <td><?php echo tgl_sql($data['ttl']);?></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Fakultas</label></div></td>
                        <td><?php echo $data['fakultas'];?></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Jurusan</label></div></td>
                        <td><?php echo $data['jurusan'];?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Semester</label></div></td>
                        <td><?php echo $data['semester'];?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>No. Telp./HP</label></div></td>
                        <td><?php echo $data['tlp'];?></td>
                    </tr>                    
                    <tr>
                        <td width="15%"><div class="form-group"><label>Alamat</label></div></td>
                        <td><?php echo $data['alamat'];?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Email</label></div></td>
                        <td><?php echo $data['email'];?></td>
                    </tr>                    
                    <tr>
                        <td width="15%"><div class="form-group"><label>Status</label></div></td>
                        <td><?php echo $data['status_mem'];?></td>
                    </tr>
                    <?php if(isset($_SESSION['user']) and (($_SESSION['level']=='petugas') or ($_SESSION['level']=='admin'))){?>
                     <tr>
                        <td width="15%"></td>
                        <td><br/><div class="form-group"><a href="?page=members&cat=<?php echo $cat;?>&update-member=<?php echo $data['kd_mem'];?>" class="btn btn-info" name="edit">Edit</a> 
                        <a href="?page=members" class="btn btn-danger"> Kembali </a></div></td>
                     </tr>
                     <?php } ?>
                </table>
            </form>
        </div>
    </div>
<?php
}

function form_view_librarian(){
	$kd_petugas 	= $_GET['view-librarian'];
	$query			= mysql_query("SELECT * FROM petugas WHERE kd_petugas='$kd_petugas'") or die (mysql_error());
	$data			= mysql_fetch_array($query);
	?>
    <div class="panel panel-info">
        <div class="panel-heading">
            DETAIL INFORMASI
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post">
                <table width="100%">
                	<tr>
                        <td width="25%" rowspan="11"><img src="<?php echo $data['image']; ?>?nocache=<?php echo time(); ?>" width="250px" height="300px"></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Kode Petugas</label></div></td>
                        <td><?php echo $data['kd_petugas'];?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Nama</label></div></td>
                        <td><?php echo $data['nama'];?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>NIK</label></div></td>
                        <td><?php echo $data['nik'];?></td>
                    </tr>
                    <tr>
                        <tr>
                        <td width="15%"><div class="form-group"><label>Jenis Kelamin</label></div></td>
                        <td><?php echo $data['jk'];?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Tanggal Lahir</label></div></td>
                        <td><?php echo tgl_sql($data['ttl']);?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Jabatan</label></div></td>
                        <td><?php echo $data['jabatan'];?></td>
                    </tr>                        
                    <tr>
                        <td width="15%"><div class="form-group"><label>No. Telp./HP</label></div></td>
                        <td><?php echo $data['tlp'];?></td>
                    </tr>                    
                    <tr>
                        <td width="15%"><div class="form-group"><label>Alamat</label></div></td>
                        <td><?php echo $data['alamat'];?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Status</label></div></td>
                        <td><?php echo $data['status'];?></td>
                    </tr>
                    <?php if(isset($_SESSION['user']) and  ($_SESSION['level']=='admin')){?>
                     <tr>
                        <td width="15%"></td>
                        <td><br/><a href="?page=librarians&update-librarian=<?php echo $data['kd_petugas'];?>" class="btn btn-info">Edit </a>
                        <a href="?page=librarians" class="btn btn-danger"> Kembali </a></td>
                    </tr>
                    <?php } ?>
                </table>
            </form>
        </div>
    </div>
<?php
}
function form_view_admin(){
	$kd_admin 	= $_GET['view-admin'];
	$query			= mysql_query("SELECT * FROM admin WHERE kd_admin='$kd_admin'") or die (mysql_error());
	$data			= mysql_fetch_array($query);
	?>
    <div class="panel panel-info">
        <div class="panel-heading">
            DETAIL INFORMASI
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post">
                <table width="100%">
                	<tr>
                        <td width="25%" rowspan="11"><img src="<?php echo $data['image']; ?>?nocache=<?php echo time(); ?>" width="250px" height="300px"></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Kode Admin</label></div></td>
                        <td><?php echo $data['kd_admin'];?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Nama</label></div></td>
                        <td><?php echo $data['nama'];?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>NIK</label></div></td>
                        <td><?php echo $data['nik'];?></td>
                    </tr>
                    <tr>
                        <tr>
                        <td width="15%"><div class="form-group"><label>Jenis Kelamin</label></div></td>
                        <td><?php echo $data['jk'];?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Tanggal Lahir</label></div></td>
                        <td><?php echo tgl_sql($data['ttl']);?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Jabatan</label></div></td>
                        <td><?php echo $data['jabatan'];?></td>
                    </tr>                        
                    <tr>
                        <td width="15%"><div class="form-group"><label>No. Telp./HP</label></div></td>
                        <td><?php echo $data['tlp'];?></td>
                    </tr>                    
                    <tr>
                        <td width="15%"><div class="form-group"><label>Alamat</label></div></td>
                        <td><?php echo $data['alamat'];?></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Status</label></div></td>
                        <td><?php echo $data['status'];?></td>
                    </tr>
                    <?php if(isset($_SESSION['user']) and  ($_SESSION['level']=='admin')){?>
                     <tr>
                        <td width="15%"></td>
                        <td><br/><a href="?page=admin&update-admin=<?php echo $data['kd_admin'];?>" class="btn btn-info">Edit </a>
                        <a href="?page=admin" class="btn btn-danger"> Kembali </a></td>
                    </tr>
                    <?php } ?>
                </table>
            </form>
        </div>
    </div>
<?php
}

function form_change_pass_mem(){
	$kd_mem=$_GET['change-pass'];
	?>
	<div class="panel panel-info">
        <div class="panel-heading">
            UBAH PASSWORD
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post"  enctype="multipart/form-data" onsubmit="return formValidatorPassMem()">
               <table width="100%">               		
                    <tr>
                        <td width="20%"><div class="form-group"><label>Password Baru</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="password" name="password" id="password" />
                                        <span class="label label-primary">Isikan dengan 6 - 15 karakter</span><div class="form-group"></div></td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><div class="form-group"><button type="submit" class="btn btn-info" name="edit_pass_mem">Ubah</button>
                        					<a href="?page=members&cat=<?php echo $cat; ?>&view-member=<?php echo $kd_mem; ?>" class="btn btn-danger">Batal</a></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <?php
    if(isset($_POST['edit_pass_mem'])){
    	$pass = $_POST['password'];
    	if(empty($pass)){
    		echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Isikan Password Baru Anda</div>';
    	}
    	else{
		$q = mysql_query("UPDATE anggota SET password = '$pass' WHERE kd_mem = '$kd_mem'") or die(mysql_error());
		if($q){?>
						<div class="alert alert-success alert-dismissable">
                    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    		Data berhasil di update <a href="?page=members&<?php echo $cat; ?>&view-member=<?php echo $kd_mem; ?>" class="alert-link">Kembali</a></div>
						<?php
					}
		}
	}
}

function form_change_pic_mem(){
	$kd_mem = $_GET['change-pic'];
	$query	= mysql_query("SELECT * FROM anggota WHERE kd_mem='$kd_mem'") or die (mysql_error());
	$data	= mysql_fetch_array($query);
	$date 	= date("Y-m-d");
	?>
    <div class="alert alert-warning">
    Gambar yang bisa di Upload hanya file dengan ekstensi <b>.jpg</b> dan besar file (file size) maksimal hanya 1 MB.
 </div>
	<div class="panel panel-info">
        <div class="panel-heading">
            UBAH GAMBAR
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
               <table width="100%">  
               		<tr>
                        <td width="20%"><div class="form-group"><label>Pilih Gambar</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><img src="<?php echo $data['image']; ?>?nocache=<?php echo time(); ?>" width="100px" height="100px">
                        				<div class="form-group"><input type="file" name="img" /></div>
                        </td>
                    </tr> 
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><br/><button type="submit" class="btn btn-info" name="edit_pic_mem">Ubah </button>
                        					 <a href="?page=members&cat=<?php echo $cat; ?>&view-member=<?php echo $kd_mem; ?>" class="btn btn-danger">Batal</a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <?php
    if(isset($_POST['edit_pic_mem'])){
    $allowed_ext    = array('jpg');
	$file_name      = $_FILES['img']['name'];
	$file_ext       = strtolower(end(explode('.', $file_name)));
	$file_size      = $_FILES['img']['size'];
	$file_tmp       = $_FILES['img']['tmp_name'];

	if(empty($file_name)){ ?>
		<div class="alert alert-danger alert-dismissable">
        	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            Error : Tidak ada gambar dipilih. 
        </div>
<?php
	}elseif(!empty($file_name)){ // jika gambar di ganti

		if(in_array($file_ext, $allowed_ext) == true){
    		if($file_size < 1044070){
         		$lokasi = 'assets/pm/'.$kd_mem.'.'.$file_ext;
                    move_uploaded_file($file_tmp, $lokasi);
                    $q 	= mysql_query("UPDATE anggota SET						
						date_update	='$date',
						image 		='$lokasi'
						WHERE kd_mem='$kd_mem'") or die(mysql_error());

                    if($q){?>
						<div class="alert alert-success alert-dismissable">
                    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    		Data berhasil di update <a href="?page=members&cat=<?php echo $cat; ?>&view-member=<?php echo $kd_mem; ?>" class="alert-link">Kembali</a></div>
						<?php
					}else{
                		echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Gagal upload file!</div>';
            		} 
        
        }else{
            echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Besar ukuran file (file size) maksimal 1 Mb!</div>';
        }
    }else{
        echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Ekstensi file tidak di izinkan!</div>';
    
	}
}
}
}

function form_change_pass_lib(){
	$kd_lib = $_GET['change-pass'];
	?>
	<div class="panel panel-info">
        <div class="panel-heading">
            UBAH PASSWORD
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post"  enctype="multipart/form-data" onsubmit="return formValidatorPassLib()">
               <table width="100%">               		
                    <tr>
                        <td width="20%"><div class="form-group"><label>Password Baru</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="password" name="password" id="password" />
                                        <span class="label label-primary">Isikan dengan 6 - 15 karakter</span></td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><br/><button type="submit" class="btn btn-info" name="edit_pass_lib">Ubah</button>
                        					<a href="?page=librarians&view-librarian=<?php echo $kd_lib; ?>" class="btn btn-danger">Batal</a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <?php
    if(isset($_POST['edit_pass_lib'])){
    	$pass = $_POST['password'];
    	if(empty($pass)){
    		echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Isikan Password Baru Anda</div>';
    	}else{
			$q = mysql_query("UPDATE petugas SET password = '$pass' WHERE kd_petugas = '$kd_lib'") or die(mysql_error());
			if($q){?>
						<div class="alert alert-success alert-dismissable">
                    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    		Data berhasil di update <a href="?page=librarians&view-librarian=<?php echo $kd_petugas; ?>" class="alert-link">Kembali</a></div>
						<?php
			}
		}
	}
}

function form_change_pic_lib(){
	$date 	= date("Y-m-d");
	$kd_petugas = $_GET['change-pic'];
	$query	= mysql_query("SELECT * FROM petugas WHERE kd_petugas='$kd_petugas'") or die (mysql_error());
	$data	= mysql_fetch_array($query);
	?>
    <div class="alert alert-warning">
    Gambar yang bisa di Upload hanya file dengan ekstensi <b>.jpg</b> dan besar file (file size) maksimal hanya 1 MB.
 </div>
	<div class="panel panel-info">
        <div class="panel-heading">
            UBAH GAMBAR
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
               <table width="100%">               		
                    <tr>
                        <td width="20%"><div class="form-group"><label>Pilih Gambar</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><img src="<?php echo $data['image']; ?>?nocache=<?php echo time(); ?>" width="100px" height="100px">
                        				<div class="form-group"><input type="file" name="img" /></div>
                        </td>
                    </tr>  
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><br/><button type="submit" class="btn btn-info" name="edit_pic_lib">Ubah </button>
                        					<a href="?page=librarians&view-librarian=<?php echo $kd_petugas; ?>" class="btn btn-danger">Batal</a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <?php
    if(isset($_POST['edit_pic_lib'])){
	$allowed_ext    = array('jpg');
	$file_name      = $_FILES['img']['name'];
	$file_ext       = strtolower(end(explode('.', $file_name)));
	$file_size      = $_FILES['img']['size'];
	$file_tmp       = $_FILES['img']['tmp_name'];

	if(empty($file_name)){
		?>
		<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                Error : Tidak ada gambar dipilih.</div>
		<?php

	}elseif(!empty($file_name)){ // jika gambar di ganti

		if(in_array($file_ext, $allowed_ext) == true){
    		if($file_size < 1044070){
         		$lokasi = 'assets/pl/'.$kd_petugas.'.'.$file_ext;
                    move_uploaded_file($file_tmp, $lokasi);
                    $q 	= mysql_query("UPDATE petugas SET						
						date_update	='$date',
						image 		='$lokasi'
						WHERE kd_petugas='$kd_petugas'") or die(mysql_error());

                    if($q){?>
						<div class="alert alert-success alert-dismissable">
                    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    		Data berhasil di update <a href="?page=librarians&view-librarian=<?php echo $kd_petugas; ?>" class="alert-link">Kembali</a></div>
						<?php
					}else{
                		echo '<div class="alert alert-danger alert-dismissable">
                    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    		Gagal Update.';
            		} 
        
        }else{
            echo '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    ERROR: Besar ukuran file (file size) maksimal 1 Mb!.</div>';
        }
    }else{
        echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Ekstensi file tidak di izinkan!</div>';
    
	}
}
}
}

function form_change_pass_adm(){
	$kd_adm = $_GET['change-pass'];
	?>
	<div class="panel panel-info">
        <div class="panel-heading">
            UBAH PASSWORD
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post">
               <table width="100%">               		
                    <tr>
                        <td width="20%"><div class="form-group"><label>Password Baru</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="password" name="password" /></td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><br/><button type="submit" class="btn btn-info" name="edit_pass_adm">Ubah</button>
                        					<a href="?page=admin&view-admin=<?php echo $kd_adm; ?>" class="btn btn-danger">Batal</a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <?php
    if(isset($_POST['edit_pass_adm'])){
    	$pass = $_POST['password'];
    	if(empty($pass)){
    		echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Isikan Password Baru Anda</div>';
    	}else{
			$q = mysql_query("UPDATE admin SET password = '$pass' WHERE kd_admin = '$kd_adm'") or die(mysql_error());
			if($q){?>
						<div class="alert alert-success alert-dismissable">
                    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    		Data berhasil di update <a href="?page=admin&view-admin=<?php echo $kd_adm; ?>" class="alert-link">Kembali</a></div>
						<?php
			}
		}
	}
}

function form_change_pic_adm(){
	$date 	= date("Y-m-d");
	$kd_admin = $_GET['change-pic'];
	$query	= mysql_query("SELECT * FROM admin WHERE kd_admin='$kd_admin'") or die (mysql_error());
	$data	= mysql_fetch_array($query);
	?>
	<div class="panel panel-info">
        <div class="panel-heading">
            UBAH GAMBAR
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
               <table width="100%">               		
                    <tr>
                        <td width="20%"><div class="form-group"><label>Pilih Gambar</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><img src="<?php echo $data['image']; ?>?nocache=<?php echo time(); ?>" width="100px" height="100px">
                        				<div class="form-group"><input type="file" name="img" /></div>
                        </td>
                    </tr>  
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><br/><button type="submit" class="btn btn-info" name="edit_pic_adm">Ubah </button>
                        					<a href="?page=admin&view-admin=<?php echo $kd_admin; ?>" class="btn btn-danger">Batal</a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <?php
    if(isset($_POST['edit_pic_adm'])){
	$allowed_ext    = array('jpg');
	$file_name      = $_FILES['img']['name'];
	$file_ext       = strtolower(end(explode('.', $file_name)));
	$file_size      = $_FILES['img']['size'];
	$file_tmp       = $_FILES['img']['tmp_name'];

	if(empty($file_name)){
		?>
		<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                Error : Tidak ada gambar dipilih.</div>
		<?php

	}elseif(!empty($file_name)){ // jika gambar di ganti

		if(in_array($file_ext, $allowed_ext) == true){
    		if($file_size < 1044070){
         		$lokasi = 'assets/pa/'.$kd_admin.'.'.$file_ext;
                    move_uploaded_file($file_tmp, $lokasi);
                    $q 	= mysql_query("UPDATE admin SET						
						date_update	='$date',
						image 		='$lokasi'
						WHERE kd_admin='$kd_admin'") or die(mysql_error());

                    if($q){?>
						<div class="alert alert-success alert-dismissable">
                    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    		Data berhasil di update <a href="?page=admin&view-admin=<?php echo $kd_admin; ?>" class="alert-link">Kembali</a></div>
						<?php
					}else{
                		echo '<div class="alert alert-danger alert-dismissable">
                    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    		Gagal Update.';
            		} 
        
        }else{
            echo '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    ERROR: Besar ukuran file (file size) maksimal 1 Mb!.</div>';
        }
    }else{
        echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Ekstensi file tidak di izinkan!</div>';
    
	}
}
}
}
//---------------------------------------------------------function panggil form pinjam-------------------------------------------------------

function cek($kembali){
$qry = mysql_query("SELECT date_add(tgl, INTERVAL 1 DAY) FROM kalender_unpi WHERE tgl='$kembali'") or die (mysql_error());
$ada = mysql_num_rows($qry);
	
	if($ada>0){
		$res = mysql_fetch_row($qry);
		return cek($res[0]); 
	}
	else
		return $kembali;
}
//--------------------------------------------------------------------------------------------------------------------------------------------
function form_pinjam(){
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
                            FROM `peminjaman` CROSS JOIN `detail_pinjam` on
                            `peminjaman`.kd_member = '$key' AND
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
 $q       = mysql_query("SELECT jabatan FROM anggota WHERE kd_mem = '$result[memberid]'");
 $j       = mysql_fetch_array($q);
 if($j['jabatan']=='Mahasiswa'){
 $sql_opt = mysql_query("SELECT option_value FROM options WHERE kd_option = '3'");
 }else{
 $sql_opt = mysql_query("SELECT option_value FROM options WHERE kd_option = '4'");
 }
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
}elseif(isset($_GET['limit'])){?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        Sudah Mencapai Limit Maksimal Peminjaman.
    </div>
<?php } ?>

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
                                    $sql_mem = mysql_query("SELECT nama,kd_mem FROM anggota WHERE kd_mem = '$key'");
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
                        			<a href="?page=cart-update&act=del&kdm=<?php echo $result_mem['kd_mem']; ?>&ref=sirkulasi" class="btn btn-danger" type="button">
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
                            FROM `peminjaman` CROSS JOIN `detail_pinjam` on
                            `peminjaman`.`kd_pinjam`=`detail_pinjam`.`kd_pinjam` AND 
                            `detail_pinjam`.status='dipinjam' AND
                            `peminjaman`.kd_member = '$key'");
                    $jml    = mysql_num_rows($sql);
                    if($jml >=1){
                        $data = mysql_fetch_array($sql);
                        if($data['counter'] >= $limit || isset($_GET['limit'])){?>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                    Member sudah mencapai batas LIMIT.<a href="?page=cart-update&act=del&kdm=<?php echo $data['memberid']; ?>&ref=sirkulasi&member" class="btn btn-danger" type="button">
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

//---------------------------------------------------------function panggil proses------------------------------------------------------------
function input_buku(){
if(empty($_POST['kd_cat'])){
	echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Kode Katalog! </div>';}
		elseif(empty($_POST['judul'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Judul Buku! </div>';}
		elseif(empty($_POST['pengarang'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Nama Pengarang! </div>';}
		elseif(empty($_POST['penerbit'])) { 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Nama Penerbit! </div>';}
		elseif(empty($_POST['th_terbit'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Tahun Terbit! </div>';}
		elseif(empty($_POST['isbn'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan No ISBN! </div>';}
		elseif(empty($_POST['kd_klasifikasi'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Kode Klasifikasi! </div>';}		
		elseif(empty($_POST['abstrak'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Abstrak! </div>';}
		elseif(empty($_POST['lama_pinjam'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Lama Pinjam! </div>';}
            elseif(empty($_POST['denda'])){ 
            echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Denda! </div>';}
else{
			
			$pengarang 	= mysql_real_escape_string($_POST['pengarang']);
			$jenis 		= $_POST['jenis_pengarang'];
			$penyunting = $_POST['penyunting'];
			$penerjemah = $_POST['penerjemah'];
			$penerbit 	= mysql_real_escape_string($_POST['penerbit']);
			$kota 		= $_POST['kota'];
			$kd_klasifikasi = $_POST['kd_klasifikasi'];
			$nama_klasifikasi =	$_POST['nama_klasifikasi'];
			$subjek_utama = $_POST['subjek_utama'];
			$subjek_tambahan = $_POST['subjek_tambahan'];		

			$q1			= mysql_query("SELECT * FROM pengarang WHERE nama='$pengarang' and jenis='$jenis' and penyunting='$penyunting' and penterjemah='$penerjemah'");
			$d1 		= mysql_num_rows($q1);
			$data1		= mysql_fetch_array($q1);

			if($d1 > 0){
				$kd_pengarang = $data1['kd_pengarang'];
			}else{

				$no1 		= "PG";
				$qqq1 		= mysql_query("SELECT max(kd_pengarang) AS last FROM pengarang WHERE kd_pengarang LIKE '$no1%'");
				$dd1  		= mysql_fetch_array($qqq1);
				$lastkd1 	= $dd1['last'];
		 		$lastNo1 	= substr($lastkd1, 2, 4); 
				$nextNo1 	= $lastNo1 + 1; 
				$kd_pengarang = $no1.sprintf('%04s', $nextNo1);

				$qq1 = mysql_query("INSERT INTO pengarang VALUES(
					  '$kd_pengarang',
					  '$pengarang',
					  '$jenis',
					  '$penyunting',
					  '$penerjemah')") or die (mysql_error());
			}

			$q2			= mysql_query("SELECT * FROM penerbit WHERE nama_penerbit='$penerbit' and kota='$kota'");
			$d2 		= mysql_num_rows($q2);
			$data2		= mysql_fetch_array($q2);

			if($d2 > 0){
				$kd_penerbit = $data2['kd_penerbit'];
			}else{
				$no2 		= "PT";
				$qqq2 		= mysql_query("SELECT max(kd_penerbit) AS last FROM penerbit WHERE kd_penerbit LIKE '$no2%'");
				$dd2  		= mysql_fetch_array($qqq2);
				$lastkd2 	= $dd2['last'];
		 		$lastNo2 	= substr($lastkd2, 2, 4); 
				$nextNo2 	= $lastNo2 + 1; 
				$kd_penerbit = $no2.sprintf('%04s', $nextNo2);

				$qq2 = mysql_query("INSERT INTO penerbit VALUES(
					  '$kd_penerbit',
					  '$penerbit',
					  '$kota')") or die (mysql_error());
			}

			$q3         = mysql_query("SELECT * FROM klasifikasi_buku WHERE kd_klasifikasi='$kd_klasifikasi' and nama='$nama_klasifikasi'");
            $d3         = mysql_num_rows($q3);
            $data3      = mysql_fetch_array($q3);

            if($d3 > 0){
                $klasifikasi = $data3['kode'];
            }else{
                $no3        = "ksi";
                $qqq3       = mysql_query("SELECT max(kode) AS last FROM klasifikasi_buku WHERE kode LIKE '$no3%'");
                $dd3        = mysql_fetch_array($qqq3);
                $lastkd3    = $dd3['last'];
                $lastNo3    = substr($lastkd3, 3, 4); 
                $nextNo3    = $lastNo3 + 1; 
                $klasifikasi  = $no3.sprintf('%04s', $nextNo3);
                $qq3 = mysql_query("INSERT INTO klasifikasi_buku VALUES(
                      '$klasifikasi',
                      '$kd_klasifikasi',
                      '$nama_klasifikasi',
                      '')") or die (mysql_error());
            }

			$q4			= mysql_query("SELECT * FROM subjek_buku WHERE subjek_utama='$subjek_utama' and subjek_tambahan='$subjek_tambahan'");
			$d4 		= mysql_num_rows($q4);
			$data4		= mysql_fetch_array($q4);

			if($d4 > 0){
				$kd_subjek = $data4['kd_subjek'];
			}else{
				$no4 		= "SJ";
				$qqq4 		= mysql_query("SELECT max(kd_subjek) AS last FROM subjek_buku WHERE kd_subjek LIKE '$no4%'");
				$dd4  		= mysql_fetch_array($qqq4);
				$lastkd4 	= $dd4['last'];
		 		$lastNo4 	= substr($lastkd4, 2, 4); 
				$nextNo4 	= $lastNo4 + 1; 
				$kd_subjek  = $no4.sprintf('%04s', $nextNo4);
				$qq3 = mysql_query("INSERT INTO subjek_buku VALUES(
					  '$kd_subjek',
					  '$subjek_utama',
					  '$subjek_tambahan',
					  '')") or die (mysql_error());
			}

			$date_input	= date("Y-m-d");
			$judul 		= mysql_real_escape_string($_POST['judul']);
			$abstrak 	= mysql_real_escape_string($_POST['abstrak']);
			$edisi 		= mysql_real_escape_string($_POST['edisi']);
			$seri 		= mysql_real_escape_string($_POST['seri']);

			$allowed_ext    = array('jpg');
        	$file_name      = $_FILES['img']['name'];
        	$file_ext       = strtolower(end(explode('.', $file_name)));
        	$file_size      = $_FILES['img']['size'];
        	$file_tmp       = $_FILES['img']['tmp_name'];

			$qqq 		= mysql_query("SELECT kd_buku FROM buku");
			$dd	 		= mysql_fetch_array($qqq);
			
            $no5        = "bk";
            $qqq5       = mysql_query("SELECT max(kd_buku) AS last FROM buku WHERE kd_buku LIKE '$no5%'");
            $dd5        = mysql_fetch_array($qqq5);
            $lastkd5    = $dd5['last'];
            $lastNo5    = substr($lastkd5, 2, 4); 
            $nextNo5    = $lastNo5 + 1; 
            $kode_buku  = $no5.sprintf('%04s', $nextNo5);


			$kd_petugas = $_SESSION['user'];
		
			if($kode_buku == $dd[0]){
				echo '<div class="alert alert-danger"> Data Gagal Disimpan. Kode Buku Sudah ada! </div>';
			}else{

				if(in_array($file_ext, $allowed_ext) === true){
                 if($file_size < 1044070){
                    $lokasi = 'assets/bp/'.$kode_buku.'.'.$file_ext;
                    move_uploaded_file($file_tmp, $lokasi);

			$q 			= mysql_query("INSERT INTO buku VALUES(
						'$kode_buku',
                        '',
                        '',
                        '$_POST[kd_cat]',
						'$kd_petugas',
						'$judul',
						'$kd_pengarang',						
						'$kd_penerbit',
						'$_POST[th_terbit]',
						'$edisi',
						'$_POST[isbn]',
						'$seri',
						'$abstrak',
						'$kd_subjek',
						'$klasifikasi',
						'$_POST[sirkulasi]',
						'$_POST[penerimaan]',
                        '$_POST[unit]',
						'$_POST[harga]',
                        '$_POST[denda]',
						'$_POST[lama_pinjam]',
						'$date_input',
						'',
						'Tersedia',
						'$lokasi',
						'$_POST[ket]')") or die (mysql_error());
		if($q){
			?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di input <a href="?page=catalogue" class="alert-link">Kembali</a>
                </div>
			<?php 
			}else{
            echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Gagal upload file!</div>';
        }
        }else{
        echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Besar ukuran file (file size) maksimal 1 Mb!</div>';
        }
        }else{
                    echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Ekstensi file tidak di izinkan!</div>';
                }
            }	
		}
	}

	
function input_member(){
if(empty($_POST['kd_member'])){
	echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan ID Member! </div>';}
		elseif(empty($_POST['nama'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Nama Anggota! </div>';}
		elseif(empty($_POST['nim'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan No Identitas (NIM/NIK/NIP) Anggota! </div>';}
		elseif(empty($_POST['jk'])) { 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Jenis Kelamin! </div>';}
		elseif(empty($_POST['ttl'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Tanggal Lahir! </div>';}
		elseif(empty($_POST['fakultas'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Fakultas! </div>';}
		elseif(empty($_POST['jurusan'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Jurusan! </div>';}
			elseif(empty($_POST['semester'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Semester! </div>';}
		elseif(empty($_POST['jabatan'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Jabatan! </div>';}
		elseif(empty($_POST['tlp'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan No. Tlp/Hp! </div>';}
		elseif(empty($_POST['alamat'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Alamat! </div>';}
		elseif(empty($_POST['email'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Alamat Email! </div>';}
		elseif(empty($_POST['password'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Password! </div>';}
        
            

else{
		$kode_member = $_POST['kd_member'];
		$query 		 = mysql_query("SELECT kd_mem FROM anggota WHERE kd_mem = '$kode_member'");
		$sum 		 = mysql_num_rows($query);
		
		
		if($sum > 0){
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Kode Member Sudah ada! </div>';
		}else{

			$allowed_ext    = array('jpg');
        	$file_name      = $_FILES['img']['name'];
        	$file_ext       = strtolower(end(explode('.', $file_name)));
        	$file_size      = $_FILES['img']['size'];
        	$file_tmp       = $_FILES['img']['tmp_name'];
        	$date_reg		= date("Y-m-d");
			$nama 			= mysql_real_escape_string($_POST['nama']);
			$alamat 		= mysql_real_escape_string($_POST['alamat']);
			$ttl 			= tgl_sql($_POST['ttl']);
			$kd_petugas		= $_SESSION['user'];

			if(in_array($file_ext, $allowed_ext) === true){
                 if($file_size < 1044070){
                    $lokasi = 'assets/pm/'.$kode_member.'.'.$file_ext;
                    move_uploaded_file($file_tmp, $lokasi);                    
                        
			
			$q 			= mysql_query("INSERT INTO anggota VALUES(
						'$kode_member',
						'$kd_petugas',
						'$nama',
						'$_POST[nim]',						
						'$_POST[jk]',
						'$ttl',
						'$alamat',
						'$_POST[fakultas]',
						'$_POST[jurusan]',
						'$_POST[semester]',
						'$_POST[jabatan]',
						'$_POST[tlp]',
						'$_POST[email]',
						'$_POST[password]',
						'$date_reg',
						'',
						'Aktif',
						'$lokasi',
                        '')") or die (mysql_error());
		if($q){
			?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di input.
                </div>
			<?php 
        }else{
            echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Gagal upload file!</div>';
        }
        }else{
        echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Besar ukuran file (file size) maksimal 1 Mb!</div>';
        }
        }else{
                    echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Ekstensi file tidak di izinkan!</div>';
                }
            }	
		}
	}


function input_member_reg(){
if(empty($_POST['nama'])) {
		echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Nama Anggota! </div>';}
		elseif(empty($_POST['nim'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan No Identitas (NIM/NIK/NIP) Anggota! </div>';}
		elseif(empty($_POST['jk'])) { 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Jenis Kelamin! </div>';}
		elseif(empty($_POST['ttl'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Tanggal Lahir! </div>';}
		elseif(empty($_POST['fakultas'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Fakultas! </div>';}
		elseif(empty($_POST['jurusan'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Jurusan! </div>';}
			elseif(empty($_POST['semester'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Semester! </div>';}
		elseif(empty($_POST['kelas'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Kelas! </div>';}
		elseif(empty($_POST['tlp'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan No. Tlp/Hp! </div>';}
		elseif(empty($_POST['alamat'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Alamat! </div>';}
		elseif(empty($_POST['email'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Alamat Email! </div>';}
		elseif(empty($_POST['password'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Password! </div>';}

else{
		$today = "pend";
		$q = mysql_query("SELECT max(kd_mem) AS last FROM register WHERE kd_mem LIKE '$today%'");
		$d  = mysql_fetch_array($q);
		$lastKdMem = $d['last'];
 
		// baca nomor urut transaksi dari id transaksi terakhir
		$lastNoUrut = substr($lastKdMem, 4, 4);
 
		// nomor urut ditambah 1
		$nextNoUrut = $lastNoUrut + 1;
 
		// membuat format nomor transaksi berikutnya
		$nextKdMem = $today.sprintf('%04s', $nextNoUrut);

			$date_reg	= date("Y-m-d");
			$nama 		= mysql_real_escape_string($_POST['nama']);
			$alamat 	= mysql_real_escape_string($_POST['alamat']);
			$q 			= mysql_query("INSERT INTO register VALUES(
						'$nextKdMem',
						'$nama',
						'$_POST[nim]',						
						'$_POST[jk]',
						'$_POST[ttl]',
						'$alamat',
						'$_POST[fakultas]',
						'$_POST[jurusan]',
						'$_POST[semester]',
						'$_POST[kelas]',
						'$_POST[tlp]',
						'$_POST[email]',
						'$_POST[password]',
						'$date_reg',
						'',
						'Pending')") or die (mysql_error());
		if($q){
			?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di input <a href="?page=" class="alert-link">Kembali</a>
                </div>
			<?php 
			}
		
	}
}

function input_librarian(){
if(empty($_POST['kd_petugas'])){
	echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan ID Petugas! </div>';}
		elseif(empty($_POST['nama'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Nama Petugas! </div>';}
		elseif(empty($_POST['nik'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan NIK! </div>';}
		elseif(empty($_POST['jk'])) { 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Jenis Kelamin! </div>';}
		elseif(empty($_POST['ttl'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Tanggal Lahir! </div>';}
		elseif(empty($_POST['jabatan'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Jabatan! </div>';}
		elseif(empty($_POST['tlp'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan No. Tlp/Hp! </div>';}
		elseif(empty($_POST['alamat'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Alamat! </div>';}
		elseif(empty($_POST['email'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Alamat Email! </div>';}
		elseif(empty($_POST['password'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Password! </div>';}

else{

		$kd_petugas 	= $_POST['kd_petugas'];
		$query 		 	= mysql_query("SELECT kd_petugas FROM petugas WHERE kd_petugas ='$kd_petugas'");
		$sum 		 	= mysql_num_rows($query);
		
		if($sum > 0){
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Kode Petugas Sudah ada! </div>';
		}else{

			$allowed_ext    = array('jpg');
        	$file_name      = $_FILES['img']['name'];
        	$file_ext       = strtolower(end(explode('.', $file_name)));
        	$file_size      = $_FILES['img']['size'];
        	$file_tmp       = $_FILES['img']['tmp_name'];

			$date_reg	= date("Y-m-d");
			$nama 		= mysql_real_escape_string($_POST['nama']);
			$alamat 	= mysql_real_escape_string($_POST['alamat']);
			$ttl 		= tgl_sql($_POST['ttl']);

			if(in_array($file_ext, $allowed_ext) === true){
                 if($file_size < 1044070){
                    $lokasi = 'assets/pl/'.$kd_petugas.'.'.$file_ext;
                    move_uploaded_file($file_tmp, $lokasi);

			$q 			= mysql_query("INSERT INTO petugas VALUES(
						'$kd_petugas',
						'$nama',
						'$_POST[nik]',						
						'$_POST[jk]',
						'$ttl',
						'$alamat',
						'$_POST[tlp]',
						'$_POST[jabatan]',
						'$_POST[email]',
						'$_POST[password]',
						'$date_reg',
						'',
						'$lokasi',
						'Aktif',
                        '',
						'$_POST[level]')") or die (mysql_error());
		if($q){
			?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di input.
                </div>
			<?php 
			}else{
            echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Gagal upload file!</div>';
        }
        }else{
        echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Besar ukuran file (file size) maksimal 1 Mb!</div>';
        }
        }else{
                    echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Ekstensi file tidak di izinkan!</div>';
                }
            }	
		}
	}

function input_admin(){
$kd_admin 	= $_POST['kd_admin'];
$query 		= mysql_query("SELECT kd_admin FROM admin WHERE kd_admin = '$kd_admin'");
$data 		= mysql_fetch_array($query);
if(empty($_POST['kd_admin'])){
	echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan ID! </div>';}
		elseif(empty($_POST['nama'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Nama! </div>';}
		elseif(empty($_POST['nik'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan NIK! </div>';}
		elseif(empty($_POST['jk'])) { 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Jenis Kelamin! </div>';}
		elseif(empty($_POST['ttl'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Tanggal Lahir! </div>';}
		elseif(empty($_POST['jabatan'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Jabatan! </div>';}
		elseif(empty($_POST['tlp'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan No. Tlp/Hp! </div>';}
		elseif(empty($_POST['alamat'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Alamat! </div>';}
		elseif(empty($_POST['email'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Alamat Email! </div>';}
		elseif(empty($_POST['password'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Password! </div>';}

elseif($kd_admin == $data['kd_admin']){
				echo '<div class="alert alert-danger"> Data Gagal Disimpan. Kode Admin Sudah ada! </div>';
			}else{

			$allowed_ext    = array('jpg');
        	$file_name      = $_FILES['img']['name'];
        	$file_ext       = strtolower(end(explode('.', $file_name)));
        	$file_size      = $_FILES['img']['size'];
        	$file_tmp       = $_FILES['img']['tmp_name'];

			$date_reg	= date("Y-m-d");
			$nama 		= mysql_real_escape_string($_POST['nama']);
			$alamat 	= mysql_real_escape_string($_POST['alamat']);
			$ttl 		= tgl_sql($_POST['ttl']);

			if(in_array($file_ext, $allowed_ext) === true){
                 if($file_size < 1044070){
                    $lokasi = 'assets/pa/'.$kd_admin.'.'.$file_ext;
                    move_uploaded_file($file_tmp, $lokasi);

			$q 			= mysql_query("INSERT INTO admin VALUES(
						'$kd_admin',
						'$nama',
						'$_POST[nik]',						
						'$_POST[jk]',
						'$ttl',
						'$_POST[tlp]',
						'$alamat',
						'$_POST[jabatan]',
						'$_POST[email]',
						'$_POST[password]',						
						'Aktif',
						'$lokasi',
						'$date_reg',
						'')") or die (mysql_error());
		if($q){
			?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di input <a href="?page=admin" class="alert-link">Kembali</a>
                </div>
			<?php 
			}else{
            echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Gagal upload file!</div>';
        }
        }else{
        echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Besar ukuran file (file size) maksimal 1 Mb!</div>';
        }
        }else{
                    echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Ekstensi file tidak di izinkan!</div>';
                }
            }	
		}
	

function input_request(){
if(empty($_POST['judul'])) {
	echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Judul Buku! </div>';}
		elseif(empty($_POST['pengarang'])) {
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Nama Pengarang! </div>';}
		elseif(empty($_POST['penerbit'])) { 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Nama Penerbit! </div>';}
		elseif(empty($_POST['th_terbit'])){ 
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Tahun Terbit! </div>';}
else{
		$req = "Req";
		$q = mysql_query("SELECT max(kd_req) AS last FROM request WHERE kd_req LIKE '$req%'");
		$d  = mysql_fetch_array($q);
		$lastKdReq = $d['last'];
 
		// baca nomor urut transaksi dari id transaksi terakhir
		$lastNoUrut = substr($lastKdReq, 3, 4);
 
		// nomor urut ditambah 1
		$nextNoUrut = $lastNoUrut + 1;
 
		// membuat format nomor transaksi berikutnya
		$nextKdReq = $req.sprintf('%04s', $nextNoUrut);
        $judul      = $_POST['judul'];
		$query 		= mysql_query("SELECT judul FROM request WHERE judul='$judul'");
		$sum 		= mysql_num_rows($query);
		
		if($sum > 0){
			echo '<div class="alert alert-danger"> Data Gagal Disimpan. Judul Sudah ada!<a href="?page=request" class="alert-link"> Kembali</a></div>';
		}else{
			$date_req	= date("Y-m-d");
			
			$kdm 	= $_POST['kd_mem'];
			$judul 		= mysql_real_escape_string($_POST['judul']);
			$pengarang 	= mysql_real_escape_string($_POST['pengarang']);
			$penerbit 	= mysql_real_escape_string($_POST['penerbit']);
			$edisi 		= mysql_real_escape_string($_POST['edisi']);
			$q 			= mysql_query("INSERT INTO request VALUES(
						'$nextKdReq',
						'$kdm',
						'$judul',
						'$pengarang',						
						'$penerbit',
						'$_POST[th_terbit]',
						'$edisi',
						'$date_req',
						'0')") or die (mysql_error());
		if($q){
			?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di input <a href="?page=request" class="alert-link">Kembali</a>
                </div>
			<?php 
			}
		}
	}
}

function update_request(){
	$id = $_GET['id'];
	$q = mysql_query("UPDATE request SET realisasi = '1' WHERE kd_req = '$id'") or die(mysql_error());
	if($q){
			?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di ACC. <a href="?page=request" class="alert-link">Kembali</a>
                </div>
			<?php 
			}
}

function update_member(){
$date 	= date("Y-m-d");
$kd_mem = $_GET['update-member'];
$nama 	= mysql_real_escape_string($_POST['nama']);
$alamat = mysql_real_escape_string($_POST['alamat']);
$status = mysql_real_escape_string($_POST['status']);
$ttl 	= tgl_sql($_POST['ttl']);

$allowed_ext    = array('jpg');
$file_name      = $_FILES['img']['name'];
$file_ext       = strtolower(end(explode('.', $file_name)));
$file_size      = $_FILES['img']['size'];
$file_tmp       = $_FILES['img']['tmp_name'];

if(empty($file_name)){   //jika gambar kosong atau tidak di ganti
				$q 	= mysql_query("UPDATE anggota SET
						nama 		='$nama',
						nim 		='$_POST[nim]',
						jk 			='$_POST[jk]',
						ttl 		='$ttl',
						alamat 		='$alamat',
						fakultas 	='$_POST[fakultas]',
						jurusan 	='$_POST[jurusan]',
						semester 	='$_POST[semester]',
						jabatan 	='$_POST[jabatan]',
						tlp 		='$_POST[tlp]',
						email 		='$_POST[email]',
						date_update	='$date',
						status_mem	='$status'
						WHERE kd_mem='$kd_mem'") or die(mysql_error());
				if($q){
			?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di update <a href="?page=members&cat=<?php echo $_POST['jabatan']?>" class="alert-link">Kembali</a>
                </div>
			<?php 
			}

}elseif(!empty($file_name)){ // jika gambar di ganti

if(in_array($file_ext, $allowed_ext) == true){
    if($file_size < 1044070){
         $lokasi = 'assets/pm/'.$kd_mem.'.'.$file_ext;
                    move_uploaded_file($file_tmp, $lokasi);

				$q 	= mysql_query("UPDATE anggota SET
						nama 		='$nama',
						nim 		='$_POST[nim]',
						jk 			='$_POST[jk]',
						ttl 		='$ttl',
						alamat 		='$alamat',
						fakultas 	='$_POST[fakultas]',
						jurusan 	='$_POST[jurusan]',
						semester 	='$_POST[semester]',
						jabatan 	='$_POST[jabatan]',
						tlp 		='$_POST[tlp]',
						email 		='$_POST[email]',
						date_update	='$date',
						status_mem	='$status',
						image 		='$lokasi'
						WHERE kd_mem='$kd_mem'") or die(mysql_error());

				if($q){
			?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di input update. <a href="?page=members&cat=<?php echo $_POST['jabatan']; ?>" class="alert-link">Kembali</a>
                </div>
			<?php 
			}else{
                echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Gagal upload file!</div>';
            } 
        
        }else{
            echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Besar ukuran file (file size) maksimal 1 Mb!</div>';
        }
    }else{
        echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Ekstensi file tidak di izinkan!</div>';
    
	}
}
}

function update_librarian(){
$date 	= date("Y-m-d");
$kd_petugas = $_GET['update-librarian'];
$nama 	= mysql_real_escape_string($_POST['nama']);
$alamat = mysql_real_escape_string($_POST['alamat']);
$status = mysql_real_escape_string($_POST['status']);
$ttl 	= tgl_sql($_POST['ttl']);

$allowed_ext    = array('jpg');
$file_name      = $_FILES['img']['name'];
$file_ext       = strtolower(end(explode('.', $file_name)));
$file_size      = $_FILES['img']['size'];
$file_tmp       = $_FILES['img']['tmp_name'];

if(empty($file_name)){   //jika gambar kosong atau tidak di ganti
	
$q 		= mysql_query("UPDATE petugas SET
						nama 		='$nama',
						nik 		='$_POST[nik]',
						jk 			='$_POST[jk]',
						ttl 		='$ttl',
						alamat 		='$alamat',
						jabatan		='$_POST[jabatan]',
						tlp 		='$_POST[tlp]',
						date_update	='$date',
						status 		='$status',
						level 		='$_POST[level]'
						WHERE kd_petugas='$kd_petugas'") or die(mysql_error());

						if($q){
						?>
            				<div class="alert alert-success alert-dismissable">
                    			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    			Data berhasil di-update. <a href="?page=librarians" class="alert-link">Kembali</a>
                			</div>
						<?php 
						}

}elseif(!empty($file_name)){ // jika gambar di ganti

if(in_array($file_ext, $allowed_ext) == true){
    if($file_size < 1044070){
         $lokasi = 'assets/pl/'.$kd_petugas.'.'.$file_ext;
                    move_uploaded_file($file_tmp, $lokasi);
                    $q 		= mysql_query("UPDATE petugas SET
						nama 		='$nama',
						nik 		='$_POST[nik]',
						jk 			='$_POST[jk]',
						ttl 		='$ttl',
						alamat 		='$alamat',
						jabatan		='$_POST[jabatan]',
						tlp 		='$_POST[tlp]',
						date_update	='$date',
						status 		='$status',
						image 		='$lokasi'
						WHERE kd_petugas='$kd_petugas'") or die(mysql_error());

                    if($q){
			?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di-update. <a href="?page=librarians" class="alert-link">Kembali</a>
                </div>
			<?php 
			}
else{
                echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Gagal upload file!</div>';
            } 
        
        }else{
            echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Besar ukuran file (file size) maksimal 1 Mb!</div>';
        }
    }else{
        echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Ekstensi file tidak di izinkan!</div>';
    
	}
}
}

function update_admin(){
$date 	= date("Y-m-d");
$kd_admin = $_GET['update-admin'];
$nama 	= mysql_real_escape_string($_POST['nama']);
$alamat = mysql_real_escape_string($_POST['alamat']);
$status = mysql_real_escape_string($_POST['status']);
$ttl 	= tgl_sql($_POST['ttl']);

$allowed_ext    = array('jpg');
$file_name      = $_FILES['img']['name'];
$file_ext       = strtolower(end(explode('.', $file_name)));
$file_size      = $_FILES['img']['size'];
$file_tmp       = $_FILES['img']['tmp_name'];

if(empty($file_name)){   //jika gambar kosong atau tidak di ganti
	
$q 		= mysql_query("UPDATE admin SET
						nama 		='$nama',
						nik 		='$_POST[nik]',
						jk 			='$_POST[jk]',
						ttl 		='$ttl',
						alamat 		='$alamat',
						jabatan		='$_POST[jabatan]',
						tlp 		='$_POST[tlp]',
						date_update	='$date',
						status 		='$status'
						WHERE kd_admin='$kd_admin'") or die(mysql_error());

						if($q){
						?>
            				<div class="alert alert-success alert-dismissable">
                    			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    			Data berhasil di input update. <a href="?page=admin&view-admin=<?php echo $kd_admin?>" class="alert-link">Kembali</a>
                			</div>
						<?php 
						}

}elseif(!empty($file_name)){ // jika gambar di ganti

if(in_array($file_ext, $allowed_ext) == true){
    if($file_size < 1044070){
         $lokasi = 'assets/pa/'.$kd_admin.'.'.$file_ext;
                    move_uploaded_file($file_tmp, $lokasi);
                    $q 		= mysql_query("UPDATE admin SET
						nama 		='$nama',
						nik 		='$_POST[nik]',
						jk 			='$_POST[jk]',
						ttl 		='$ttl',
						alamat 		='$alamat',
						jabatan		='$_POST[jabatan]',
						tlp 		='$_POST[tlp]',
						date_update	='$date',
						status 		='$status',
						image 		='$lokasi'
						WHERE kd_admin='$kd_admin'") or die(mysql_error());

                    if($q){
			?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di update. <a href="?page=admin" class="alert-link">Kembali</a>
                </div>
			<?php 
			}
else{
                echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Gagal upload file!</div>';
            } 
        
        }else{
            echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Besar ukuran file (file size) maksimal 1 Mb!</div>';
        }
    }else{
        echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Ekstensi file tidak di izinkan!</div>';
    
	}
}
}


function logout(){
    session_destroy();
    echo"<script>window.location=\"index.php\"</script>"; 
    exit;
}

function hitungcuti($tglawal,$tglakhir,$delimiter) {
//    menetapkan parameter awal dan libur nasional
//    pada prakteknya data libur nasional bisa diambil dari database
    $tgl_awal = $tgl_akhir = $minggu = $sabtu = $koreksi = $libur = 0;
	
	
    
//    memecah tanggal untuk mendapatkan hari, bulan dan tahun
    $pecah_tglawal = explode($delimiter, $tglawal);
    $pecah_tglakhir = explode($delimiter, $tglakhir);
    
//    mengubah Gregorian date menjadi Julian Day Count
    $tgl_awal = gregoriantojd($pecah_tglawal[1], $pecah_tglawal[0], $pecah_tglawal[2]);
    $tgl_akhir = gregoriantojd($pecah_tglakhir[1], $pecah_tglakhir[0], $pecah_tglakhir[2]);

//    mengubah ke unix timestamp
    $jmldetik = 24*3600;
    $a = strtotime($tglawal);
    $b = strtotime($tglakhir);
    
//    menghitung jumlah libur nasional 
    for($i=$a; $i<$b; $i+=$jmldetik){
        $query = mysql_query("SELECT tgl FROM kalender_unpi");
		while($data=mysql_fetch_array($query)){
    		$liburnasional = $data[0]; 
            if($liburnasional==date("Y-m-d",$i)){
                $libur++;
            }
        }
    }
   
//    menghitung jumlah hari minggu
    for($i=$a; $i<$b; $i+=$jmldetik){
        if(date("w",$i)=="0"){
            $minggu++;
        }
    }
    
/*    menghitung jumlah hari sabtu
    for($i=$a; $i<$b; $i+=$jmldetik){
        if(date("w",$i)=="6"){
            $sabtu++;
        }
    }*/

//    dijalankan jika $tglakhir adalah hari sabtu atau minggu
    if(date("w",$b)=="0"){
        $koreksi = 1;
    }
    
//    mengitung selisih dengan pengurangan kemudian ditambahkan 1 agar tanggal awal cuti juga dihitung
    $jumlahcuti =  $tgl_akhir - $tgl_awal - $libur - $minggu - $koreksi;
    return $jumlahcuti;
}

function tgl_sql($date){
    $exp = explode('-', $date);
    if (count($exp) == 3){
      $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
   }
   return $date;
 }
 
function tgl($date){
    $exp = explode('-', $date);
    if (count($exp) == 3){
      $date = $exp[0].'-'.$exp[1].'-'.$exp[2];
   }   
   return $date;
 }

 function word_limiter($str,$limit=100){
    $str_s = " ";
    $str = strip_tags($str);
    if(stripos($str, " ")){
        $ex_str=explode(" ", $str);
        if(count($ex_str)>$limit){
            for($i=0;$i<$limit;$i++){
                $str_s.=$ex_str[$i]." ";
            }
            return $str_s."&hellip;";
        }
        else{
            return $str;
        }
    }
    else{
        return $str;
    }
 }

?>