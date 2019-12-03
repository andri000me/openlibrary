
<div class="col-md-12">
<?php
if(isset($_GET['member-id'])){
    if(isset($_POST['update'])){
        add_ket();
    }elseif(isset($_POST['search']) or isset($_GET['search'])) {
        history_member_search();
    }
    else{
    history_member();
    }
}else{
    ?>
    <div class="alert alert-danger">
        Tidak ada kode member.<a href="?page=sirkulasi" class="alert-link">Kembali</a>
    </div>
    <?php
}
?>
</div>
<?php
function history_member(){
$id = $_GET['member-id'];
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">History Peminjaman <?php echo $id;?></h4></td>                
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT count(*) FROM peminjaman, detail_pinjam WHERE `peminjaman`.kd_member = '$id' AND 
                                `peminjaman`.kd_pinjam = `detail_pinjam`.kd_pinjam AND `detail_pinjam`.status='dikembalikan'");
      $page = (isset($_GET['pages'])) ? (int)$_GET['pages'] : 1;
      $start = ($page-1) * $per_page; 
      $pages = ceil(mysql_result($page_query, 0) / $per_page);
?>
<div class="row">
<div class="col-md-12">         
    <form method="post" action="" name="form1">    
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
                                echo  "<a href='".$_SERVER['PHP_SELF']."?page=history-sirkulasi-mhs&member-id=".$id."&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                                for($x=1; $x<=$pages; $x++){
                                    $showPage = $x;
                                    if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                        if (($showPage != ($pages - 1)) && ($x == $pages))
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                        if ($x == $noPage)
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                        else
                                            echo " <a href='".$_SERVER['PHP_SELF']."?page=history-sirkulasi-mhs&member-id=".$id."&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                                }
                                if ($noPage < $pages)
                                    echo "<a href='".$_SERVER['PHP_SELF']."?page=history-sirkulasi-mhs&member-id=".$id."&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                            }?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%">
                    <form role="form" method="post" action="?page=history-sirkulasi-mhs&member-id=<?php echo $id; ?>">             
                        <div class="input-group">
                             <input type="text" name="search" required  class="form-control" placeholder="Cari Judul">
                                 <span class="form-group input-group-btn">
                                     <button class="btn btn-default" type="submit">Cari</button>
                                     <!--<div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                            <li><a href="?page=sirkulasi">Kode Sirkulasi</a></li>
                                            <li><a href="?page=sirkulasi-member">Kode Mahasiswa</a></li>
                                            </ul>
                                    </div>-->                                    
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
                    <th>Judul</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Harus Kembali</th>
                    <th>Denda</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $no     = $start+1;
                $sql    = mysql_query("SELECT * FROM peminjaman, detail_pinjam WHERE `peminjaman`.kd_member = '$id' AND 
                          `peminjaman`.kd_pinjam = `detail_pinjam`.kd_pinjam AND `detail_pinjam`.status='dikembalikan'
                          LIMIT $start,$per_page");
                $jml    = mysql_num_rows($sql);
                if($jml >=1){
                    while($data=mysql_fetch_array($sql)){
                        $i      = $data['kd_buku'];?>
                        <tr class = "warning">                                  
                            <td><?php echo $no++; ?></td>
                            <td><?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) { ?>
                                <a href="?page=circulation-histori&id=<?php echo $data['kd_pinjam'];?>"> <?php echo $data['kd_pinjam']; ?></a>
                                <?php }else echo $data['kd_pinjam']; ?>
                            </td>
                            <td><?php echo $data['kd_petugas']; ?></td>
                            <td><?php $query_buku = mysql_query("SELECT judul,kd_sirkulasi FROM buku WHERE kd_buku = '$data[kd_buku]'");
                                  $data_buku = mysql_fetch_array($query_buku);
                                  echo $data_buku['judul'];?></td>
                            <td><?php echo tgl_sql($data['tgl_pinjam']); ?></td>
                            <td><?php echo tgl_sql($data['tgl_hrs_kem']); ?></td>
                            <td><?php echo number_format($data['denda']);?></td>                                    
                            <td class="text-center"><?php
                                if(!empty($data['ket'])){ 
                                    echo $data['ket'];
                                    if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {
                                        echo'<a href="" class="open-AddBookDialog" data-toggle="modal" data-target="#addKet"
                                    data-kode   ="'.$data['kd_pinjam'].'"
                                    data-kdbk   ="'.$data['kd_buku'].'"
                                    data-judul  ="'.$data_buku['judul'].'"
                                    data-ket    ="'.$data['ket'].'">
                                    <i class="glyphicon glyphicon-pencil icon-white"></i></a>'; }
                                }else{?>
                                    <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                                    <a href="" class="open-AddBookDialog btn btn-primary btn-sm" data-toggle="modal" data-target="#addKet"
                                    data-kode   ="<?php echo $data['kd_pinjam']; ?>"
                                    data-kdbk   ="<?php echo $data['kd_buku']; ?>"
                                    data-judul  ="<?php echo $data_buku['judul']; ?>"
                                     data-ket    ="<?php echo $data['ket']; ?>">
                                     <i class="glyphicon glyphicon-plus icon-white"></i></a><?php }else{echo"-";}
                                } ?>
                            </td>
                        </tr><?php 
                    }                                
                }else echo "<tr class=danger><td colspan=8 align=center>Tidak Ada Record</td></td>";?>
            </tbody>
        </table>
        <div align="left"><?php  
            $jml    = mysql_query("SELECT * FROM peminjaman, detail_pinjam WHERE `peminjaman`.kd_member = '$id' AND 
                      `peminjaman`.kd_pinjam = `detail_pinjam`.kd_pinjam AND `detail_pinjam`.status='dikembalikan'");
            $total  = mysql_num_rows($jml);?>
            <strong>Jumlah Record : <?php echo $total; ?></strong>
        </div>

        <div class="form-group" align="right">          
        <?php
            if(isset($_GET['pages'])){
                $noPage = $_GET['pages'];}
            else $noPage = 1;
              
              
    if($pages >= 2 && $page <= $pages){
        if ($noPage > 1 OR $noPage == $pages) 
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=history-sirkulasi-mhs&member-id=".$id."&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=history-sirkulasi-mhs&member-id=".$id."&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=history-sirkulasi-mhs&member-id=".$id."&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>
        </div>
    </div>
<!-- ============================================================= MODAL =================================================================================== -->
<div class="modal fade" id="addKet" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <form action="" method="post">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="mySmallModalLabel">Keterangan</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="borrowId" id="borrowId" value=""/>
                <input type="hidden" name="bookId" id="bookId" value=""/>
                <input type="hidden" name="judul" id="judul" value=""/>
                <textarea class="form-control" name="ket" id="ket" rows="5"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                <button id="update" class="btn btn-primary btn-sm" name="update">
                <i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
  </form>
</div>
<!-- ================================================================END OF MODAL======================================================================== -->
</div>
</div>
<a href="?page=admin-dashboard"><< Home</a></div></div><?php 
}
?>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
function history_member_search(){
$id = $_GET['member-id'];
if(isset($_POST['search'])){$search = $_POST['search'];}
    elseif(isset($_GET['search'])){$search = $_GET['search'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Search History Peminjaman <?php echo $id;?></h4></td>                
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT count(*) FROM peminjaman, detail_pinjam, buku WHERE `peminjaman`.kd_member = '$id' AND
                                `buku`.kd_buku = `detail_pinjam`.kd_buku AND `peminjaman`.kd_pinjam = `detail_pinjam`.kd_pinjam AND 
                                `detail_pinjam`.status='dikembalikan' AND `buku`.judul LIKE '%$search%'");
      $page = (isset($_GET['pages'])) ? (int)$_GET['pages'] : 1;
      $start = ($page-1) * $per_page; 
      $pages = ceil(mysql_result($page_query, 0) / $per_page);
?>
<div class="row">
<div class="col-md-12">         
    <form method="post" action="" name="form1">    
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
                                echo  "<a href='".$_SERVER['PHP_SELF']."?page=history-sirkulasi-mhs&member-id=".$id."&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                                for($x=1; $x<=$pages; $x++){
                                    $showPage = $x;
                                    if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                        if (($showPage != ($pages - 1)) && ($x == $pages))
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                        if ($x == $noPage)
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                        else
                                            echo " <a href='".$_SERVER['PHP_SELF']."?page=history-sirkulasi-mhs&member-id=".$id."&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                                }
                                if ($noPage < $pages)
                                    echo "<a href='".$_SERVER['PHP_SELF']."?page=history-sirkulasi-mhs&member-id=".$id."&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                            }?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%">
                    <form role="form" method="post" action="?page=sirkulasi">             
                        <div class="input-group">
                             <input type="text" name="search" required  class="form-control" placeholder="Cari Judul">
                                 <span class="form-group input-group-btn">
                                     <button class="btn btn-default" type="submit">Cari</button>
                                     <!--<div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                            <li><a href="?page=sirkulasi">Kode Sirkulasi</a></li>
                                            <li><a href="?page=sirkulasi-member">Kode Mahasiswa</a></li>
                                            </ul>
                                    </div>-->                                    
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
                    <th>Judul</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Harus Kembali</th>
                    <th>Denda</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $no     = $start+1;
                $sql    = mysql_query("SELECT * FROM peminjaman, detail_pinjam, buku WHERE `peminjaman`.kd_member = '$id' AND
                                `buku`.kd_buku = `detail_pinjam`.kd_buku AND `peminjaman`.kd_pinjam = `detail_pinjam`.kd_pinjam AND 
                                `detail_pinjam`.status='dikembalikan' AND `buku`.judul LIKE '%$search%'
                                LIMIT $start,$per_page");
                $jml    = mysql_num_rows($sql);
                if($jml >=1){
                    while($data=mysql_fetch_array($sql)){
                        $judul  = $data['judul'];
                        $i      = $data['kd_buku'];?>
                        <tr class = "warning">                                  
                            <td><?php echo $no++; ?></td>
                            <td><?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) { ?>
                                <a href="?page=circulation-histori&id=<?php echo $data['kd_pinjam'];?>"> <?php echo $data['kd_pinjam']; ?></a>
                                <?php }else echo $data['kd_pinjam']; ?>
                            </td>
                            <td><?php echo $data['kd_petugas']; ?></td>
                            <td><?php echo $judul;?></td>
                            <td><?php echo tgl_sql($data['tgl_pinjam']); ?></td>
                            <td><?php echo tgl_sql($data['tgl_hrs_kem']); ?></td>
                            <td><?php echo number_format($data['denda']);?></td>                                    
                            <td class="text-center"><?php
                                if(!empty($data['ket'])){ 
                                    echo $data['ket'];
                                    if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {
                                        echo'<a href="" class="open-AddBookDialog" data-toggle="modal" data-target="#addKet"
                                    data-kode   ="'.$data['kd_pinjam'].'"
                                    data-kdbk   ="'.$data['kd_buku'].'"
                                    data-judul  ="'.$data_buku['judul'].'"
                                    data-ket    ="'.$data['ket'].'">
                                    <i class="glyphicon glyphicon-pencil icon-white"></i></a>'; }
                                }else{?>
                                    <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                                    <a href="" class="open-AddBookDialog btn btn-primary btn-sm" data-toggle="modal" data-target="#addKet"
                                    data-kode   ="<?php echo $data['kd_pinjam']; ?>"
                                    data-kdbk   ="<?php echo $data['kd_buku']; ?>"
                                    data-judul  ="<?php echo $data_buku['judul']; ?>"
                                     data-ket    ="<?php echo $data['ket']; ?>">
                                     <i class="glyphicon glyphicon-plus icon-white"></i></a><?php }else{echo"-";}
                                } ?>
                            </td>
                        </tr><?php 
                    }                                
                }else echo "<tr class=danger><td colspan=8 align=center>Tidak Ada Record</td></td>";?>
            </tbody>
        </table>
        <div align="left"><?php  
            $jml    = mysql_query("SELECT * FROM peminjaman, detail_pinjam, buku WHERE `peminjaman`.kd_member = '$id' AND
                      `buku`.kd_buku = `detail_pinjam`.kd_buku AND `peminjaman`.kd_pinjam = `detail_pinjam`.kd_pinjam AND 
                      `detail_pinjam`.status='dikembalikan' AND `buku`.judul LIKE '%$search%'");
            $total  = mysql_num_rows($jml);?>
            <strong>Jumlah Record : <?php echo $total; ?></strong>
        </div>

        <div class="form-group" align="right">          
        <?php
            if(isset($_GET['pages'])){
                $noPage = $_GET['pages'];}
            else $noPage = 1;
              
              
    if($pages >= 2 && $page <= $pages){
        if ($noPage > 1 OR $noPage == $pages) 
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=history-sirkulasi-mhs&member-id=".$id."&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=history-sirkulasi-mhs&member-id=".$id."&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=history-sirkulasi-mhs&member-id=".$id."&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>
        </div>
    </div>
<!-- ============================================================= MODAL =================================================================================== -->
<div class="modal fade" id="addKet" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <form action="" method="post">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="mySmallModalLabel">Keterangan</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="borrowId" id="borrowId" value=""/>
                <input type="hidden" name="bookId" id="bookId" value=""/>
                <input type="hidden" name="judul" id="judul" value=""/>
                <textarea class="form-control" name="ket" id="ket" rows="5"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                <button id="update" class="btn btn-primary btn-sm" name="update">
                <i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
  </form>
</div>
<!-- ================================================================END OF MODAL======================================================================== -->
</div>
</div>
<a href="?page=admin-dashboard"><< Home</a></div></div><?php 

}

function add_ket(){
 if(isset($_POST['update'])){
    $id       = $_GET['member-id'];
    $borrowId = $_POST['borrowId'];
    $bookId   = $_POST['bookId'];
    $ket      = $_POST['ket'];

    $q_ket    = mysql_query("UPDATE detail_pinjam SET ket = '$ket' WHERE 
                        kd_pinjam='$borrowId' AND kd_buku='$bookId'")or die (mysql_error());
    if($q_ket){
        echo"<script>window.alert(\"Data keterangan berhasil disimpan.\")</script>";
        echo"<script>window.location=\"?page=history-sirkulasi-mhs&member-id=".$id."\"</script>";
    }
}   
}?>