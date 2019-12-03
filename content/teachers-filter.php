<div class="md-col-12">
<?php
if(isset($_GET['tech'])){
    if((isset($_POST['search-tech'])) or (isset($_GET['search-tech']))) {
        teachers_tech_search();
    }else{
        teachers_tech();
    }
}
elseif(isset($_GET['eco'])){
    if((isset($_POST['search-eco'])) or (isset($_GET['search-eco']))) {
        teachers_eco_search();
    }else{
        teachers_eco();
    }
}
elseif(isset($_GET['lit'])){
    if((isset($_POST['search-lit'])) or (isset($_GET['search-lit']))) {
        teachers_lit_search();
    }else{
        teachers_lit();
    }
}
elseif(isset($_GET['com'])){
    if((isset($_POST['search-com'])) or (isset($_GET['search-com']))) {
        teachers_com_search();
    }else{
        teachers_com();
    }
}
?>
<!-------------------------------------------------------------------------------------------------------------------------------------------------------------->
</div>
<?php
function teachers_tech(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Dosen Fakultas Teknik </h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Fakultas</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=teachers-filter&tech">Teknik</a></li>
                            <li><a href="?page=teachers-filter&eco">Ekonomi</a></li>
                            <li><a href="?page=teachers-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=teachers-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `anggota` WHERE fakultas='Teknik' and jabatan = 'Dosen'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&tech=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                                $showPage = $x;
                                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                    if (($showPage != ($pages - 1)) && ($x == $pages))
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&tech=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&tech=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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
                                <a href="?page=teachers&form-member" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th>Kode Dosen</th>
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
    $no     = $start + 1;
    $sql    = mysql_query("SELECT * FROM `anggota` WHERE fakultas='Teknik' and jabatan = 'Dosen' ORDER BY kd_mem ASC LIMIT $start,$per_page");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
            echo"
            <tr class=warning>                                  
            <td>".$no++."</td>
            <td>".$data['kd_mem']."</td>
            <td><a href=?page=librarians&view-librarian=".$data['kd_petugas'].">".$data['kd_petugas']."</a></td>
            <td><a href=?page=teachers&view-member=".$data['kd_mem'].">".$data['nama']."</a></td>
            <td>".$data['jabatan']."</td>
            <td>".$data['fakultas']."</td>
            <td>".$data['status_mem']."</td>
            <td><a href=?page=history-sirkulasi-mhs&member-id=".$data['kd_mem']." class=\"btn btn-info\" type=\"button\" alt=\"History\">
                <i class=\"fa fa-history\"></i> History</a>
                <a href=?page=teachers&update-member=".$data['kd_mem']." class=\"btn btn-primary\" type=\"button\">
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
$jml = mysql_query("SELECT * FROM `anggota` WHERE fakultas='Teknik' and jabatan='Dosen'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&tech=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&tech=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&tech=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function teachers_tech_search(){
    if(isset($_POST['search-tech'])){$search = $_POST['search-tech'];}
    elseif(isset($_GET['search-tech'])){$search = $_GET['search-tech'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Dosen Fakultas Teknik</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Fakultas</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=teachers-filter&tech">Teknik</a></li>
                            <li><a href="?page=teachers-filter&eco">Ekonomi</a></li>
                            <li><a href="?page=teachers-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=teachers-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `anggota` WHERE fakultas='Teknik' and jabatan='Dosen' AND (kd_mem LIKE '%$search%' or nama LIKE '%$search%')");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&tech=filter&pages=".($noPage-1)."&search-tech=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                                $showPage = $x;
                                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                    if (($showPage != ($pages - 1)) && ($x == $pages))
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&tech=filter&pages=".$x."&search-tech=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&tech=filter&pages=".($noPage+1)."&search-tech=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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
                                <a href="?page=teachers&form-member" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th>Kode Dosen</th>
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
    $sql    = mysql_query("SELECT * FROM anggota WHERE fakultas='Teknik' and jabatan='Dosen' AND (kd_mem LIKE '%$search%' or nama LIKE '%$search%') ORDER BY kd_mem ASC LIMIT $start,$per_page");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
            echo"
            <tr class=warning>                                  
            <td>".$no++."</td>
            <td>".$data['kd_mem']."</td>
            <td><a href=?page=librarians&view-librarian=".$data['kd_petugas'].">".$data['kd_petugas']."</a></td>
            <td><a href=?page=teachers&view-member=".$data['kd_mem'].">".$data['nama']."</a></td>
            <td>".$data['jabatan']."</td>
            <td>".$data['fakultas']."</td>
            <td>".$data['status_mem']."</td>
            <td><a href=?page=history-sirkulasi-mhs&member-id=".$data['kd_mem']." class=\"btn btn-info\" type=\"button\" alt=\"History\">
                <i class=\"fa fa-history\"></i> History</a>
                <a href=?page=teachers&update-member=".$data['kd_mem']." class=\"btn btn-primary\" type=\"button\">
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
$jml = mysql_query("SELECT * FROM `anggota` WHERE fakultas='Teknik' and jabatan='Dosen' AND (kd_mem LIKE '%$search%' or nama LIKE '%$search%')");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&tech=filter&pages=".($noPage-1)."&search-tech=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&tech=filter&pages=".$x."&search-tech=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&tech=filter&pages=".($noPage+1)."&search-tech=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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


function teachers_eco(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Dosen Fakultas Ekonomi</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Fakultas</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=teachers-filter&tech">Teknik</a></li>
                            <li><a href="?page=teachers-filter&eco">Ekonomi</a></li>
                            <li><a href="?page=teachers-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=teachers-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `anggota` WHERE fakultas='Ekonomi' and jabatan='Dosen'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&eco=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                                $showPage = $x;
                                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                    if (($showPage != ($pages - 1)) && ($x == $pages))
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&eco=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&eco=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="">             
                        <div class="input-group">
                            <input type="text" name="search-eco" class="form-control">
                            <span class="form-group input-group-btn">
                                <button class="btn btn-default" type="submit">Cari</button>
                                <a href="?page=teachers&form-member" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th>Kode Dosen</th>
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
    $no     = $start + 1;
    $sql    = mysql_query("SELECT * FROM `anggota` WHERE fakultas='Ekonomi' and jabatan='Dosen' ORDER BY kd_mem ASC LIMIT $start,$per_page");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
            echo"
            <tr class=warning>                                  
            <td>".$no++."</td>
            <td>".$data['kd_mem']."</td>
            <td><a href=?page=librarians&view-librarian=".$data['kd_petugas'].">".$data['kd_petugas']."</a></td>
            <td><a href=?page=teachers&view-member=".$data['kd_mem'].">".$data['nama']."</a></td>            
            <td>".$data['jabatan']."</td>
            <td>".$data['fakultas']."</td>
            <td>".$data['status_mem']."</td>
            <td><a href=?page=history-sirkulasi-mhs&member-id=".$data['kd_mem']." class=\"btn btn-info\" type=\"button\" alt=\"History\">
                <i class=\"fa fa-history\"></i> History</a>
                <a href=?page=teachers&update-member=".$data['kd_mem']." class=\"btn btn-primary\" type=\"button\">
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
$jml = mysql_query("SELECT * FROM `anggota` WHERE fakultas='Ekonomi' and jabatan='Dosen'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&eco=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&eco=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&eco=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function teachers_eco_search(){
    if(isset($_POST['search-eco'])){$search = $_POST['search-eco'];}
    elseif(isset($_GET['search-eco'])){$search = $_GET['search-eco'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Dosen Fakultas Ekonomi</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Fakultas</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=teachers-filter&tech">Teknik</a></li>
                            <li><a href="?page=teachers-filter&eco">Ekonomi</a></li>
                            <li><a href="?page=teachers-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=teachers-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `anggota` WHERE fakultas='Ekonomi' and jabatan='Dosen' AND (kd_mem LIKE '%$search%' or nama LIKE '%$search%')");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&eco=filter&pages=".($noPage-1)."&search-eco=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                                $showPage = $x;
                                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                    if (($showPage != ($pages - 1)) && ($x == $pages))
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&eco=filter&pages=".$x."&search-eco=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&eco=filter&pages=".($noPage+1)."&search-eco=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="">             
                        <div class="input-group">
                            <input type="text" name="search-eco" class="form-control">
                            <span class="form-group input-group-btn">
                                <button class="btn btn-default" type="submit">Cari</button>
                                <a href="?page=teachers&form-member" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th>Kode Dosen</th>
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
    $sql    = mysql_query("SELECT * FROM anggota WHERE fakultas='Ekonomi' and jabatan='Dosen' AND (kd_mem LIKE '%$search%' or nama LIKE '%$search%') ORDER BY kd_mem ASC LIMIT $start,$per_page");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
            echo"
            <tr class=warning>                                  
            <td>".$no++."</td>
            <td>".$data['kd_mem']."</td>
            <td><a href=?page=librarians&view-librarian=".$data['kd_petugas'].">".$data['kd_petugas']."</a></td>
            <td><a href=?page=teachers&view-member=".$data['kd_mem'].">".$data['nama']."</a></td>            
            <td>".$data['jabatan']."</td>
            <td>".$data['fakultas']."</td>
            <td>".$data['status_mem']."</td>
            <td><a href=?page=history-sirkulasi-mhs&member-id=".$data['kd_mem']." class=\"btn btn-info\" type=\"button\" alt=\"History\">
                <i class=\"fa fa-history\"></i> History</a>
                <a href=?page=teachers&update-member=".$data['kd_mem']." class=\"btn btn-primary\" type=\"button\">
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
$jml = mysql_query("SELECT * FROM `anggota` WHERE fakultas='Ekonomi' and jabatan='Dosen' AND (kd_mem LIKE '%$search%' or nama LIKE '%$search%')");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&eco=filter&pages=".($noPage-1)."&search-eco=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&eco=filter&pages=".$x."&search-eco=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&eco=filter&pages=".($noPage+1)."&search-eco=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function teachers_lit(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Dosen Fakultas Sastra Inggris</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Fakultas</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=teachers-filter&tech">Teknik</a></li>
                            <li><a href="?page=teachers-filter&eco">Ekonomi</a></li>
                            <li><a href="?page=teachers-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=teachers-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `anggota` WHERE fakultas='Sastra Inggris' and jabatan='Dosen'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&lit=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                                $showPage = $x;
                                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                    if (($showPage != ($pages - 1)) && ($x == $pages))
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&lit=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&lit=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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
                                <a href="?page=teachers&form-member" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th>Kode Dosen</th>
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
    $no     = $start + 1;
    $sql    = mysql_query("SELECT * FROM `anggota` WHERE fakultas='Sastra Inggris' and jabatan='Dosen' ORDER BY kd_mem ASC LIMIT $start,$per_page");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
            echo"
            <tr class=warning>                                  
            <td>".$no++."</td>
            <td>".$data['kd_mem']."</td>
            <td><a href=?page=librarians&view-librarian=".$data['kd_petugas'].">".$data['kd_petugas']."</a></td>
            <td><a href=?page=teachers&view-member=".$data['kd_mem'].">".$data['nama']."</a></td>
            <td>".$data['jabatan']."</td>
            <td>".$data['fakultas']."</td>
            <td>".$data['status_mem']."</td>
            <td><a href=?page=history-sirkulasi-mhs&member-id=".$data['kd_mem']." class=\"btn btn-info\" type=\"button\" alt=\"History\">
                <i class=\"fa fa-history\"></i> History</a>
                <a href=?page=teachers&update-member=".$data['kd_mem']." class=\"btn btn-primary\" type=\"button\">
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
$jml = mysql_query("SELECT * FROM `anggota` WHERE fakultas='Sastra Inggris' and jabatan='Dosen'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&lit=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&lit=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&lit=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function teachers_lit_search(){
    if(isset($_POST['search-lit'])){$search = $_POST['search-lit'];}
    elseif(isset($_GET['search-lit'])){$search = $_GET['search-lit'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Dosen Fakultas Sastra Inggris</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Fakultas</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=teachers-filter&tech">Teknik</a></li>
                            <li><a href="?page=teachers-filter&eco">Ekonomi</a></li>
                            <li><a href="?page=teachers-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=teachers-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `anggota` WHERE fakultas='Sastra Inggris' and jabatan='Dosen' AND (kd_mem LIKE '%$search%' or nama LIKE '%$search%')");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&lit=filter&pages=".($noPage-1)."&search-lit=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                                $showPage = $x;
                                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                    if (($showPage != ($pages - 1)) && ($x == $pages))
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&lit=filter&pages=".$x."&search-lit=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&lit=filter&pages=".($noPage+1)."&search-lit=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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
                                <a href="?page=teachers&form-member" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th>Kode Dosen</th>
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
    $sql    = mysql_query("SELECT * FROM anggota WHERE fakultas='Sastra Inggris' and jabatan='Dosen' AND (kd_mem LIKE '%$search%' or nama LIKE '%$search%') ORDER BY kd_mem ASC LIMIT $start,$per_page");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
            echo"
            <tr class=warning>                                  
            <td>".$no++."</td>
            <td>".$data['kd_mem']."</td>
            <td><a href=?page=librarians&view-librarian=".$data['kd_petugas'].">".$data['kd_petugas']."</a></td>
            <td><a href=?page=teachers&view-member=".$data['kd_mem'].">".$data['nama']."</a></td>
            <td>".$data['jabatan']."</td>
            <td>".$data['fakultas']."</td>
            <td>".$data['status_mem']."</td>
            <td><a href=?page=history-sirkulasi-mhs&member-id=".$data['kd_mem']." class=\"btn btn-info\" type=\"button\" alt=\"History\">
                <i class=\"fa fa-history\"></i> History</a>
                <a href=?page=teachers&update-member=".$data['kd_mem']." class=\"btn btn-primary\" type=\"button\">
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
$jml = mysql_query("SELECT * FROM `anggota` WHERE fakultas='Sastra Inggris' and jabatan='Dosen' AND (kd_mem LIKE '%$search%' or nama LIKE '%$search%')");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&lit=filter&pages=".($noPage-1)."&search-lit=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&lit=filter&pages=".$x."&search-lit=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&lit=filter&pages=".($noPage+1)."&search-lit=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function teachers_com(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Dosen Fakultas Ilmu Komunikasi</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Fakultas</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=teachers-filter&tech">Teknik</a></li>
                            <li><a href="?page=teachers-filter&eco">Ekonomi </a></li>
                            <li><a href="?page=teachers-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=teachers-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `anggota` WHERE fakultas='Ilmu Komunikasi' and jabatan='Dosen'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&com=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                                $showPage = $x;
                                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                    if (($showPage != ($pages - 1)) && ($x == $pages))
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&com=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&com=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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
                                <a href="?page=teachers&form-member" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th>Kode Dosen</th>
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
    $no     = $start + 1;
    $sql    = mysql_query("SELECT * FROM `anggota` WHERE fakultas='Ilmu Komunikasi' and jabatan='Dosen' ORDER BY kd_mem ASC LIMIT $start,$per_page");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
            echo"
            <tr class=warning>                                  
            <td>".$no++."</td>
            <td>".$data['kd_mem']."</td>
            <td><a href=?page=librarians&view-librarian=".$data['kd_petugas'].">".$data['kd_petugas']."</a></td>
            <td><a href=?page=teachers&view-member=".$data['kd_mem'].">".$data['nama']."</a></td>
            <td>".$data['jabatan']."</td>
            <td>".$data['fakultas']."</td>
            <td>".$data['status_mem']."</td>
            <td><a href=?page=history-sirkulasi-mhs&member-id=".$data['kd_mem']." class=\"btn btn-info\" type=\"button\" alt=\"History\">
                <i class=\"fa fa-history\"></i> History</a>
                <a href=?page=teachers&update-member=".$data['kd_mem']." class=\"btn btn-primary\" type=\"button\">
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
$jml = mysql_query("SELECT * FROM `anggota` WHERE fakultas='Ilmu Komunikasi' and jabatan='Dosen'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&com=filter&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&com=filter&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&com=filter&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function teachers_com_search(){
    if(isset($_POST['search-com'])){$search = $_POST['search-com'];}
    elseif(isset($_GET['search-com'])){$search = $_GET['search-com'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Dosen Fakultas Ilmu Komunikasi</h4></td>
                <td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Fakultas</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=teachers-filter&tech">Teknik</a></li>
                            <li><a href="?page=teachers-filter&eco">Ekonomi</a></li>
                            <li><a href="?page=teachers-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=teachers-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `anggota` WHERE fakultas='Ilmu Komunikasi' and jabatan='Dosen' AND (kd_mem LIKE '%$search%' or nama LIKE '%$search%')");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&com=filter&pages=".($noPage-1)."&search-com=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                                $showPage = $x;
                                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                    if (($showPage != ($pages - 1)) && ($x == $pages))
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&com=filter&pages=".$x."&search-com=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&com=filter&pages=".($noPage+1)."&search-com=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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
                                <a href="?page=teachers&form-member" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th>Kode Dosen</th>
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
    $sql    = mysql_query("SELECT * FROM anggota WHERE fakultas='Ilmu Komunikasi' and jabatan='Dosen' AND (kd_mem LIKE '%$search%' or nama LIKE '%$search%') ORDER BY kd_mem ASC LIMIT $start,$per_page");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
            echo"
            <tr class=warning>                                  
            <td>".$no++."</td>
            <td>".$data['kd_mem']."</td>
            <td><a href=?page=librarians&view-librarian=".$data['kd_petugas'].">".$data['kd_petugas']."</a></td>
            <td><a href=?page=teachers&view-member=".$data['kd_mem'].">".$data['nama']."</a></td>
            <td>".$data['jabatan']."</td>
            <td>".$data['fakultas']."</td>
            <td>".$data['status']."</td>
            <td><a href=?page=history-sirkulasi-mhs&member-id=".$data['kd_mem']." class=\"btn btn-info\" type=\"button\" alt=\"History\">
                <i class=\"fa fa-history\"></i> History</a>
                <a href=?page=teachers&update-member=".$data['kd_mem']." class=\"btn btn-primary\" type=\"button\">
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
$jml = mysql_query("SELECT * FROM `anggota` WHERE fakultas='Ilmu Komunikasi' and jabatan='Dosen' AND (kd_mem LIKE '%$search%' or nama LIKE '%$search%')");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&com=filter&pages=".($noPage-1)."&search-com=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&com=filter&pages=".$x."&search-com=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=teachers-filter&com=filter&pages=".($noPage+1)."&search-com=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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