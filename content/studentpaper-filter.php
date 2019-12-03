<div class="md-col-12">
<?php
if(isset($_GET['tech'])){
    if((isset($_POST['search-tech'])) or (isset($_GET['search-tech']))) {
        makalah_tech_search();
    }else{
        makalah_tech();
    }
}
elseif(isset($_GET['tech-man'])){
    if((isset($_POST['search-tech-man'])) or (isset($_GET['search-tech-man']))) {
        makalah_techman_search();
    }else{
        makalah_techman();
    }
}
elseif(isset($_GET['aocc'])){
    if((isset($_POST['search-acc'])) or (isset($_GET['search-acc']))) {
        makalah_acc_search();
    }else{
        makalah_acc();
    }
}
elseif(isset($_GET['manj'])){
    if((isset($_POST['search-manj'])) or (isset($_GET['search-manj']))) {
        makalah_manj_search();
    }else{
        makalah_manj();
    }
}
elseif(isset($_GET['lit'])){
    if((isset($_POST['search-lit'])) or (isset($_GET['search-lit']))) {
        makalah_lit_search();
    }else{
        makalah_lit();
    }
}
elseif(isset($_GET['com'])){
    if((isset($_POST['search-com'])) or (isset($_GET['search-com']))) {
        makalah_com_search();
    }else{
        makalah_com();
    }
}
?>
<!-------------------------------------------------------------------------------------------------------------------------------------------------------------->
</div>

<?php
function makalah_tech(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Koleksi Makalah Jurusan Teknik Informatika</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=studentpaper-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=studentpaper-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=studentpaper-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=studentpaper-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `makalah` WHERE jurusan='Teknik Informatika'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="">             
                    <div class="input-group">
                        <input type="text" name="search-tech" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=student-paper&add-paper" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
        $sql    = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Teknik Informatika' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                $kd = $data['kd_makalah'];
        ?>
            <tr>                                    
                <td><h4><?php echo "<a href=?page=skripsi&detail-id=".$data['kd_makalah'].">".$data['judul']."</a>"; ?></h4>
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
$jml = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Teknik Informatika'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function makalah_tech_search(){
    if(isset($_POST['search-tech'])){$search = $_POST['search-tech'];}
    elseif(isset($_GET['search-tech'])){$search = $_GET['search-tech'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Koleksi Makalah Jurusan Teknik Informatika</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=studentpaper-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=studentpaper-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=studentpaper-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=studentpaper-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `makalah` WHERE jurusan='Teknik Informatika' AND judul LIKE '%$search%'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech=filter&pages=".($noPage-1)."&search-tech=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech=filter&pages=".$x."&search-tech=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech=filter&pages=".($noPage+1)."&search-tech=".$search,"' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="">             
                    <div class="input-group">
                        <input type="text" name="search-tech" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=student-paper&add-paper" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
        $sql    = mysql_query("SELECT * FROM skripsi WHERE jurusan='Teknik Informatika' AND judul LIKE '%$search%' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                $kd = $data['kd_makalah'];
        ?>
            <tr>                                    
                <td><h4><?php echo "<a href=?page=skripsi&detail-id=".$data['kd_makalah'].">".$data['judul']."</a>"; ?></h4>
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
$jml = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Teknik Informatika' AND judul LIKE '%$search%'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech=filter&pages=".($noPage-1)."&search-tech=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech=filter&pages=".$x."&search-tech=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech=filter&pages=".($noPage+1)."&search-tech=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function makalah_techman(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Koleksi Makalah Jurusan Manajemen Informatika</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=studentpaper-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=studentpaper-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=studentpaper-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=studentpaper-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `makalah` WHERE jurusan='Manajemen Informatika'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech-man=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech-man=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech-man=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="">             
                    <div class="input-group">
                        <input type="text" name="search-tech-man" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=student-paper&add-paper" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
        $sql    = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Manajemen Informatika' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                $kd = $data['kd_makalah'];
        ?>
            <tr>                                    
                <td><h4><?php echo "<a href=?page=skripsi&detail-id=".$data['kd_makalah'].">".$data['judul']."</a>"; ?></h4>
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
$jml = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Manajemen Informatika'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech-man=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech-man=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech-man=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function makalah_techman_search(){
    if(isset($_POST['search-tech-man'])){$search = $_POST['search-tech-man'];}
    elseif(isset($_GET['search-tech-man'])){$search = $_GET['search-tech-man'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Koleksi Makalah Jurusan Manajemen Informatika</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=studentpaper-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=studentpaper-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=studentpaper-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=studentpaper-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `makalah` WHERE jurusan='Manajemen Informatika' AND judul LIKE '%$search%'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech-man=filter&pages=".($noPage-1)."&search-tech-man=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech-man=filter&pages=".$x."&search-tech-man=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech-man=filter&pages=".($noPage+1)."&search-tech-man=".$search,"' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="">             
                    <div class="input-group">
                        <input type="text" name="search-tech-man" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=student-paper&add-paper" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
        $sql    = mysql_query("SELECT * FROM skripsi WHERE jurusan='Manajemen Informatika' AND judul LIKE '%$search%' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                $kd = $data['kd_makalah'];
        ?>
            <tr>                                    
                <td><h4><?php echo "<a href=?page=skripsi&detail-id=".$data['kd_makalah'].">".$data['judul']."</a>"; ?></h4>
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
$jml = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Manajemen Informatika' AND judul LIKE '%$search%'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech-man=filter&pages=".($noPage-1)."&search-tech-man=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech-man=filter&pages=".$x."&search-tech-man=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&tech-man=filter&pages=".($noPage+1)."&search-tech-man=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function makalah_acc(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Koleksi Makalah Jurusan Akuntansi</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=studentpaper-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=studentpaper-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=studentpaper-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=studentpaper-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `makalah` WHERE jurusan='Akuntansi'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&acc=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&acc=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&acc=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="">             
                    <div class="input-group">
                        <input type="text" name="search-acc" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=student-paper&add-paper" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
        $sql    = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Akuntansi' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                $kd = $data['kd_makalah'];
        ?>
            <tr>                                    
                <td><h4><?php echo "<a href=?page=skripsi&detail-id=".$data['kd_makalah'].">".$data['judul']."</a>"; ?></h4>
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
$jml = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Akuntansi'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&acc=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&acc=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&acc=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function makalah_acc_search(){
    if(isset($_POST['search-acc'])){$search = $_POST['search-acc'];}
    elseif(isset($_GET['search-acc'])){$search = $_GET['search-acc'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Koleksi Makalah Jurusan Akuntansi</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=studentpaper-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=studentpaper-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=studentpaper-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=studentpaper-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `makalah` WHERE jurusan='Akuntansi' AND judul LIKE '%$search%'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&acc=filter&pages=".($noPage-1)."&search-acc=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&acc=filter&pages=".$x."&search-acc=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&acc=filter&pages=".($noPage+1)."&search-acc=".$search,"' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="">             
                    <div class="input-group">
                        <input type="text" name="search-acc" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=student-paper&add-paper" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
        $sql    = mysql_query("SELECT * FROM skripsi WHERE jurusan='Akuntansi' AND judul LIKE '%$search%' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                $kd = $data['kd_makalah'];
        ?>
            <tr>                                    
                <td><h4><?php echo "<a href=?page=skripsi&detail-id=".$data['kd_makalah'].">".$data['judul']."</a>"; ?></h4>
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
$jml = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Akuntansi' AND judul LIKE '%$search%'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&acc=filter&pages=".($noPage-1)."&search-acc=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&acc=filter&pages=".$x."&search-acc=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&acc=filter&pages=".($noPage+1)."&search-acc=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function makalah_manj(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Koleksi Makalah Jurusan Manajemen</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=studentpaper-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=studentpaper-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=studentpaper-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=studentpaper-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `makalah` WHERE jurusan='Manajemen'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&manj=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&manj=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&manj=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="">             
                    <div class="input-group">
                        <input type="text" name="search-manj" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=student-paper&add-paper" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
        $sql    = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Manajemen' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                $kd = $data['kd_makalah'];
        ?>
            <tr>                                    
                <td><h4><?php echo "<a href=?page=skripsi&detail-id=".$data['kd_makalah'].">".$data['judul']."</a>"; ?></h4>
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
$jml = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Manajemen'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&manj=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&manj=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&manj=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function makalah_manj_search(){
    if(isset($_POST['search-manj'])){$search = $_POST['search-manj'];}
    elseif(isset($_GET['search-manj'])){$search = $_GET['search-manj'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Koleksi Makalah Jurusan Manajemen</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=studentpaper-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=studentpaper-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=studentpaper-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=studentpaper-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `makalah` WHERE jurusan='Manajemen' AND judul LIKE '%$search%'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&manj=filter&pages=".($noPage-1)."&search-manj=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&manj=filter&pages=".$x."&search-manj=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&manj=filter&pages=".($noPage+1)."&search-manj=".$search,"' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="">             
                    <div class="input-group">
                        <input type="text" name="search-manj" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=student-paper&add-paper" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
        $sql    = mysql_query("SELECT * FROM skripsi WHERE jurusan='Manajemen' AND judul LIKE '%$search%' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                $kd = $data['kd_makalah'];
        ?>
            <tr>                                    
                <td><h4><?php echo "<a href=?page=skripsi&detail-id=".$data['kd_makalah'].">".$data['judul']."</a>"; ?></h4>
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
$jml = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Manajemen' AND judul LIKE '%$search%'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&manj=filter&pages=".($noPage-1)."&search-manj=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&manj=filter&pages=".$x."&search-manj=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&manj=filter&pages=".($noPage+1)."&search-manj=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function makalah_lit(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Koleksi Makalah Jurusan Sastra Inggris</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=studentpaper-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=studentpaper-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=studentpaper-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=studentpaper-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `makalah` WHERE jurusan='Sastra Inggris'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&lit=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&lit=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&lit=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="">             
                    <div class="input-group">
                        <input type="text" name="search-lit" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=student-paper&add-paper" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
        $sql    = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Sastra Inggris' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                $kd = $data['kd_makalah'];
        ?>
            <tr>                                    
                <td><h4><?php echo "<a href=?page=skripsi&detail-id=".$data['kd_makalah'].">".$data['judul']."</a>"; ?></h4>
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
$jml = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Sastra Inggris'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&lit=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&lit=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&lit=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function makalah_lit_search(){
    if(isset($_POST['search-lit'])){$search = $_POST['search-lit'];}
    elseif(isset($_GET['search-lit'])){$search = $_GET['search-lit'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Koleksi Makalah Jurusan Sastra Inggris</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=studentpaper-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=studentpaper-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=studentpaper-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=studentpaper-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `makalah` WHERE jurusan='Sastra Inggris' AND judul LIKE '%$search%'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&lit=filter&pages=".($noPage-1)."&search-lit=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&lit=filter&pages=".$x."&search-lit=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&lit=filter&pages=".($noPage+1)."&search-lit=".$search,"' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="">             
                    <div class="input-group">
                        <input type="text" name="search-lit" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=student-paper&add-paper" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
        $sql    = mysql_query("SELECT * FROM skripsi WHERE jurusan='Sastra Inggris' AND judul LIKE '%$search%' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                $kd = $data['kd_makalah'];
        ?>
            <tr>                                    
                <td><h4><?php echo "<a href=?page=skripsi&detail-id=".$data['kd_makalah'].">".$data['judul']."</a>"; ?></h4>
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
$jml = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Sastra Inggris' AND judul LIKE '%$search%'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&lit=filter&pages=".($noPage-1)."&search-lit=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&lit=filter&pages=".$x."&search-lit=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&lit=filter&pages=".($noPage+1)."&search-lit=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function makalah_com(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Koleksi Makalah Jurusan Ilmu Komunikasi</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=studentpaper-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=studentpaper-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=studentpaper-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=studentpaper-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `makalah` WHERE jurusan='Ilmu Komunikasi'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&com=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&com=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&com=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="">             
                    <div class="input-group">
                        <input type="text" name="search-com" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=student-paper&add-paper" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
        $sql    = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Ilmu Komunikasi' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                $kd = $data['kd_makalah'];
        ?>
            <tr>                                    
                <td><h4><?php echo "<a href=?page=skripsi&detail-id=".$data['kd_makalah'].">".$data['judul']."</a>"; ?></h4>
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
$jml = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Ilmu Komunikasi'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&com=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&com=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&com=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function makalah_com_search(){
    if(isset($_POST['search-com'])){$search = $_POST['search-com'];}
    elseif(isset($_GET['search-com'])){$search = $_GET['search-com'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Koleksi Makalah Jurusan Ilmu Komunikasi</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=studentpaper-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=studentpaper-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=studentpaper-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=studentpaper-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=studentpaper-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `makalah` WHERE jurusan='Ilmu Komunikasi' AND judul LIKE '%$search%'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&com=filter&pages=".($noPage-1)."&search-com=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&com=filter&pages=".$x."&search-com=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&com=filter&pages=".($noPage+1)."&search-com=".$search,"' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="">             
                    <div class="input-group">
                        <input type="text" name="search-com" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=student-paper&add-paper" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
        $sql    = mysql_query("SELECT * FROM skripsi WHERE jurusan='Ilmu Komunikasi' AND judul LIKE '%$search%' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                $kd = $data['kd_makalah'];
        ?>
            <tr>                                    
                <td><h4><?php echo "<a href=?page=skripsi&detail-id=".$data['kd_makalah'].">".$data['judul']."</a>"; ?></h4>
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
$jml = mysql_query("SELECT * FROM `makalah` WHERE jurusan='Ilmu Komunikasi' AND judul LIKE '%$search%'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&com=filter&pages=".($noPage-1)."&search-com=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&com=filter&pages=".$x."&search-com=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=studentpaper-filter&com=filter&pages=".($noPage+1)."&search-com=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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