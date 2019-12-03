<div class="col-md-12">
<?php
if (isset($_POST['search']) or isset($_GET['search'])){
    book_late_search();}
else{
book_late_list();}
?>
</div>
<?php

function book_late_list(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Buku Terlambat</h4></td>
                <!--<td width="10%"><div align="right">
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
      $page_query = mysql_query("SELECT COUNT(*) FROM `peminjaman`, `detail_pinjam`,`anggota` WHERE 
                                                        `peminjaman`.kd_pinjam = `detail_pinjam`.kd_pinjam AND
                                                        `peminjaman`.kd_member = `anggota`.kd_mem AND  
                                                        (TO_DAYS(now()) - TO_DAYS(`detail_pinjam`.tgl_hrs_kem)) > 0 
                                                        AND `detail_pinjam`.status ='dipinjam'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=book-late&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=book-late&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=book-late&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align=""><!--
                    <form role="form" method="post" action="?page=book-late">             
                    <div class="input-group">
                        <input type="text" name="search" class="form-control">
                            <span class="form-group input-group-btn">
                                <button class="btn btn-default" type="submit">Cari</button>
                            </span>
                    </div>
                    </form>-->
                </td>                                
            </tr>
        </tbody>
    </table>
</div>
                        
<div class="panel-body">
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
                                   <thead>
                                <tr>                                
                                    <th>#</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Kode Anggota</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Harus Kembali</th>
                                    <th>Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no     = $start+1;
                                $sql    = mysql_query("SELECT * FROM `peminjaman`, `detail_pinjam`,`anggota` WHERE 
                                                        `peminjaman`.kd_pinjam = `detail_pinjam`.kd_pinjam AND
                                                        `peminjaman`.kd_member = `anggota`.kd_mem AND 
                                                        (TO_DAYS(now()) - TO_DAYS(`detail_pinjam`.tgl_hrs_kem)) > 0 
                                                        AND `detail_pinjam`.status ='dipinjam' ORDER BY `detail_pinjam`.tgl_pinjam ASC LIMIT $start,$per_page");
                                $jml    = mysql_num_rows($sql);
                                if($jml >=1){
                                while($data=mysql_fetch_array($sql)){
                                    $cat = $data['jabatan'];
                                    $query_buku = mysql_query("SELECT judul,kd_sirkulasi,denda FROM buku WHERE kd_buku = '$data[kd_buku]'");
                                    $data_buku = mysql_fetch_array($query_buku);
                                    ?>
                                    <tr class = "warning">
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo tgl_sql($data['tgl_pinjam']); ?></td>
                                    <td><a href="?page=members&cat=<?php echo $cat;?>&view-member=<?php echo $data['kd_member']; ?>"><?php echo $data['kd_member']; ?></a></td>
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
                                                                $denda = $daydiff * $data_buku['denda'];
                                                            }
                                                    }
                                        ?><input type="text" name="denda[<?php echo $i; ?>]" value="<?php echo $denda; ?>" size="3" readonly />
                                        <!--<button name="ok" class="btn-primary" type="submit">
                                        <i class="fa fa-refresh"></i></button>-->
    
                                        <?php }else echo number_format($data['denda']);
                                     ?></td>
                                </tr>                               
                            <?php
                            }
                        }else echo "<tr class=danger><td colspan=11 align=center>Tidak Ada Record</td></td>";

                               ?>
                            </tbody>
                                </table>

<div align="left">
<?php  
$jml = mysql_query("SELECT * FROM `peminjaman`, `detail_pinjam`,`anggota` WHERE 
                    `peminjaman`.kd_pinjam = `detail_pinjam`.kd_pinjam AND
                    `peminjaman`.kd_member = `anggota`.kd_mem AND 
                     (TO_DAYS(now()) - TO_DAYS(`detail_pinjam`.tgl_hrs_kem)) > 0 
                     AND `detail_pinjam`.status ='dipinjam'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=book-late&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=book-late&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=book-late&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
        </div>
</div>
</div>
</div>
</div>
</div></div></div></div>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------ >
<?php
}
function book_late_search(){
if(isset($_POST['search'])){$search = $_POST['search'];}
    elseif(isset($_GET['search'])){$search = $_GET['search'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Buku Terlambat</h4></td>
                <!--<td width="10%"><div align="right">
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
      $page_query = mysql_query("SELECT COUNT(*) FROM `peminjaman`, `detail_pinjam`,`anggota` WHERE 
                                 `peminjaman`.kd_pinjam = `detail_pinjam`.kd_pinjam AND
                                 `peminjaman`.kd_member = `anggota`.kd_mem AND 
                                (TO_DAYS(now()) - TO_DAYS(`detail_pinjam`.tgl_hrs_kem)) > 0 
                                AND `detail_pinjam`.status ='dipinjam'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=book-late&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=book-late&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=book-late&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align=""><!--
                    <form role="form" method="post" action="?page=book-late">             
                    <div class="input-group">
                        <input type="text" name="search" class="form-control">
                            <span class="form-group input-group-btn">
                                <button class="btn btn-default" type="submit">Cari</button>
                            </span>
                    </div>
                    </form>-->
                </td>                                
            </tr>
        </tbody>
    </table>
</div>
                        
<div class="panel-body">
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
                                   <thead>
                                <tr>                                
                                    <th>#</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Kode Anggota</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Harus Kembali</th>
                                    <th>Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no     = $start+1;
                                $sql    = mysql_query("SELECT * FROM `peminjaman`, `detail_pinjam`,`anggota` WHERE 
                                                        `peminjaman`.kd_pinjam = `detail_pinjam`.kd_pinjam AND
                                                        `peminjaman`.kd_member = `anggota`.kd_mem AND  
                                                        (TO_DAYS(now()) - TO_DAYS(`detail_pinjam`.tgl_hrs_kem)) > 0 
                                                        AND `detail_pinjam`.status ='dipinjam' ORDER BY `detail_pinjam`.tgl_pinjam ASC LIMIT $start,$per_page");
                                $jml    = mysql_num_rows($sql);
                                if($jml >=1){
                                while($data=mysql_fetch_array($sql)){
                                    $cat = $data['jabatan'];
                                    $query_buku = mysql_query("SELECT judul,kd_sirkulasi,denda FROM buku WHERE kd_buku = '$data[kd_buku]'");
                                    $data_buku = mysql_fetch_array($query_buku);
                                    ?>
                                    <tr class = "warning">
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo tgl_sql($data['tgl_pinjam']); ?></td>
                                    <td><a href="?page=members&cat=<?php echo $cat;?>&view-member=<?php echo $data['kd_member']; ?>"><?php echo $data['kd_member']; ?></a></td>
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
                                                                $denda = $daydiff * $data_buku['denda'];
                                                            }
                                                    }
                                        ?><input type="text" name="denda[<?php echo $i; ?>]" value="<?php echo $denda; ?>" size="3" readonly />
                                        <!--<button name="ok" class="btn-primary" type="submit">
                                        <i class="fa fa-refresh"></i></button>-->
    
                                        <?php }else echo number_format($data['denda']);
                                     ?></td>
                                </tr>                               
                            <?php
                            }
                        }else echo "<tr class=danger><td colspan=11 align=center>Tidak Ada Record</td></td>";

                               ?>
                            </tbody>
                                </table>

<div align="left">
<?php  
$jml = mysql_query("SELECT * FROM `peminjaman`, `detail_pinjam`,`anggota` WHERE 
                    `peminjaman`.kd_pinjam = `detail_pinjam`.kd_pinjam AND
                    `peminjaman`.kd_member = `anggota`.kd_mem AND  
                     (TO_DAYS(now()) - TO_DAYS(`detail_pinjam`.tgl_hrs_kem)) > 0 
                     AND `detail_pinjam`.status ='dipinjam'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=book-late&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=book-late&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=book-late&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
        </div>
</div>
</div>
</div>
</div>
</div></div></div></div>
?>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
}
?>