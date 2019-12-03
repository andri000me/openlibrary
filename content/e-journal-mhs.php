<div class="md-col-12">
<?php
if(isset($_GET['search']) or isset($_POST['search'])){
    jurnal_list_cat_search();
}else{
jurnal_list_cat();
}
?>
</div>
<?php
function jurnal_list_cat(){
    if(isset($_GET['cat'])){
        $kat    = $_GET['cat'];
    }
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h9 class="header-line">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><h4><?php
                        if(isset($_GET['cat'])){
                            if($_GET['cat'] == 'm'){
                                echo "Koleksi E-Journal Mahasiswa";
                            }elseif($_GET['cat']=='d'){
                                echo "Koleksi E-Journal Dosen";
                            }elseif($_GET['cat']=='md'){
                                echo "Koleksi E-Journal Mahasiswa & Dosen";
                            }
                        }else{echo "Koleksi Semua E-Journal";} ?> <span class="caret"></span></h4>
                    </button>
                        <ul class="dropdown-menu">                           
                            <li><a href="?page=e-journal-mhs&cat=m">E-journal Mahasiswa</a></li>
                            <li><a href="?page=e-journal-mhs&cat=d">E-journal Dosen</a></li>
                            <li><a href="?page=e-journal-mhs&cat=md">E-journal Mahasiswa&Dosen</a></li>
                            <li><a href="?page=e-journal">Semua</a></li>
                        </ul>
                        </h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">                            
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=e-journal-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=e-journal-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=e-journal-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=e-journal-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=e-journal-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=e-journal-filter&com">Ilmu Komunikasi</a></li>
                            <li class="divider"></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `jurnal` WHERE kategori='$kat'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=e-journal-mhs&cat=".$kat."&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=e-journal-mhs&cat=".$kat."&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=e-journal-mhs&cat=".$kat."&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="?page=e-journal-mhs&cat=<?php echo $kat;?>">             
                    <div class="input-group">
                        <input type="text" name="search" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=e-journal&add-jurnal" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
                            <?php } ?>
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
        <tbody>
        <?php
        $no     = $start+1;
        $sql    = mysql_query("SELECT * FROM jurnal WHERE kategori='$kat' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                $kd = $data['kd_jurnal'];
        ?>
            <tr>                                    
                <td><h4><?php echo "<a href=?page=e-journal&detail-id=".$data['kd_jurnal'].">".$data['judul']."</a>"; ?></h4>
                    <i class="fa fa-user"> <?php 
                        $sql2 = mysql_query("SELECT * FROM pengarang WHERE kd_pengarang = '$data[kd_penulis]'");
                        $data2 = mysql_fetch_array($sql2);
                        $sql3 = mysql_query("SELECT * FROM penerbit WHERE kd_penerbit = '$data[kd_penerbit]'");
                        $data3 = mysql_fetch_array($sql3);
                        echo $data2['nama']."(".$data3['nama_penerbit'].", ".$data['thn_terbit'].")" ?></i><p/>
                        <?php echo word_limiter($data['abstrak'],20)."</p>";?>
                </td>          
            </tr>
        <?php
            }
        }else echo "<tr class=danger><td colspan=6 align=center>Tidak Ada Record</td></td>";
        ?>
        </tbody>
    </table>
<div align="left">
<?php  
$jml = mysql_query("SELECT * FROM `jurnal` WHERE kategori='$kat'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=e-journal-mhs&cat=".$kat."&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=e-journal-mhs&cat=".$kat."&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=e-journal-mhs&cat=".$kat."&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function jurnal_list_cat_search(){
    if(isset($_GET['cat'])){
        if(isset($_GET['search'])){$search=$_GET['search'];}
        elseif(isset($_POST['search'])){$search=$_POST['search'];}
        $kat    = $_GET['cat'];
    }
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h9 class="header-line">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><h4><?php
                        if(isset($_GET['cat'])){
                            if($_GET['cat'] == 'm'){
                                echo "Koleksi E-Journal Mahasiswa Search";
                            }elseif($_GET['cat']=='d'){
                                echo "Koleksi E-Journal Dosen Search";
                            }elseif($_GET['cat']=='md'){
                                echo "Koleksi E-Journal Mahasiswa & Dosen Search";
                            }
                        }else{echo "Koleksi Semua E-Journal Search";} ?> <span class="caret"></span></h4>
                    </button>
                        <ul class="dropdown-menu">                           
                            <li><a href="?page=e-journal-mhs&cat=m">E-journal Mahasiswa</a></li>
                            <li><a href="?page=e-journal-mhs&cat=d">E-journal Dosen</a></li>
                            <li><a href="?page=e-journal-mhs&cat=md">E-journal Mahasiswa&Dosen</a></li>
                            <li><a href="?page=e-journal">Semua</a></li>
                        </ul>
                        </h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">                            
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=e-journal-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=e-journal-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=e-journal-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=e-journal-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=e-journal-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=e-journal-filter&com">Ilmu Komunikasi</a></li>
                            <li class="divider"></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `jurnal` WHERE kategori='$kat' AND judul LIKE '%$search%'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=e-journal-mhs&cat=".$kat."&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=e-journal-mhs&cat=".$kat."&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=e-journal-mhs&cat=".$kat."&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="?page=e-journal-mhs&cat=<?php echo $kat;?>">             
                    <div class="input-group">
                        <input type="text" name="search" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=e-journal&add-jurnal" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
                            <?php } ?>
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
        <tbody>
        <?php
        $no     = $start+1;
        $sql    = mysql_query("SELECT * FROM jurnal WHERE kategori='$kat' AND judul LIKE '%$search%' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                $kd = $data['kd_jurnal'];
        ?>
            <tr>                                    
                <td><h4><?php echo "<a href=?page=e-journal&detail-id=".$data['kd_jurnal'].">".$data['judul']."</a>"; ?></h4>
                    <i class="fa fa-user"> <?php 
                        $sql2 = mysql_query("SELECT * FROM pengarang WHERE kd_pengarang = '$data[kd_penulis]'");
                        $data2 = mysql_fetch_array($sql2);
                        $sql3 = mysql_query("SELECT * FROM penerbit WHERE kd_penerbit = '$data[kd_penerbit]'");
                        $data3 = mysql_fetch_array($sql3);
                        echo $data2['nama']."(".$data3['nama_penerbit'].", ".$data['thn_terbit'].")" ?></i><p/>
                        <?php echo word_limiter($data['abstrak'],20)."</p>";?>
                </td>          
            </tr>
        <?php
            }
        }else echo "<tr class=danger><td colspan=6 align=center>Tidak Ada Record</td></td>";
        ?>
        </tbody>
    </table>
<div align="left">
<?php  
$jml = mysql_query("SELECT * FROM `jurnal` WHERE kategori='$kat' AND judul LIKE '%$search%'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=e-journal-mhs&cat=".$kat."&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=e-journal-mhs&cat=".$kat."&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=e-journal-mhs&cat=".$kat."&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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