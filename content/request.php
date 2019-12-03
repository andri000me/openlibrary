<div class="col-md-12"><?php
if(isset($_GET['form-request'])){
    form_request();
    if(isset($_POST['request'])){
    input_request();
    }
}
elseif(isset($_GET['view-req'])){
	view_request();
}
elseif(isset($_GET['id'])){
    update_request();
}
elseif (isset($_POST['search']) or isset($_GET['search'])) {
	request_list_search();
}

else{
    request_list();
}
?>
</div>
<?php

function request_list(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Request</h4></td>
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
      $page_query = mysql_query("SELECT COUNT(*) FROM `request`");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=request&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=request&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=request&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="?page=request">             
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="cari judul/kode pengaju" required>
                            <span class="form-group input-group-btn">
                                <button class="btn btn-default" type="submit">Cari</button>
                                <a href="?page=request&form-request" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th>Kode Request</th>
                <?php if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) { ?>
                <th>Nama Pengaju</th>
                <?php } ?>
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
    $no     = $start+1;
    $sql    = mysql_query("SELECT * FROM request  ORDER BY realisasi ASC LIMIT $start,$per_page");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
            echo"<tr class=warning>";
            echo"<td>".$no++."</td>";
            echo"<td>".$data['kd_req']."</td>";
            
            /*$q = mysql_query("SELECT `A`.kd_dosen,`B`.kd_mem,`C`.kd_petugas, `B`.nim,
                             `A`.nama As nama_dosen,`B`.nama as nama_mem,  `C`.nama as nama_lib
                             FROM anggota B, anggota_dosen A, petugas C WHERE `B`.nim = '$data[kd_pengaju]' 
                             or `A`.nik = '$data[kd_pengaju]' or `C`.kd_petugas = '$data[kd_pengaju]'");
            $r = mysql_fetch_array($q);*/
            if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {
                ?>
            <td>
            <?php
                //echo "nama : ".$r['nama_mem']."-"." = ".$data['kd_pengaju']."<br>";
                $q1 = mysql_query("SELECT nama,kd_mem FROM anggota WHERE nim = '$data[kd_pengaju]'");
                $d1 = mysql_fetch_array($q1);
                if($q1){
                    echo"<a href=?page=members&view-member=".$d1['kd_mem'].">".$d1['nama']."</a>";
                }
                $q3 = mysql_query("SELECT nama FROM petugas WHERE kd_petugas = '$data[kd_pengaju]'");
                $d3 = mysql_fetch_array($q3);
                if($q3){
                    echo"<a href=?page=librarians&view-librarian=".$data['kd_pengaju'].">".$d3['nama']."</a>";
                }
            ?>
            </td>
            <?php
                    
                }
            
            
            echo"<td>".$data['judul']."</td>";
            echo"<td>".$data['pengarang']."</td>";
            echo"<td>".$data['penerbit']."</td>";
            echo"<td>".$data['th_terbit']."</td>";
            echo"<td>".$data['edisi']."</td>";
            echo"<td>".tgl_sql($data['tgl_req'])."</td>";
            if($data['realisasi']=='0'){
                echo"<td>Pending</td>";
                if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {
                echo"<td><a href=\"?page=request&id=".$data['kd_req']."\" class=\"btn btn-primary\" type=\"button\"><i class=\"fa fa-plus\"></i> Acc</a></td>";}
                else{echo "<td></td>";}
            }elseif($data['realisasi']=='1'){
                echo"<td>Approved</td>";
                if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {
                echo"<td>-</td>";}else{echo "<td></td>";}
            }
            echo"</tr>";
        }
    }else echo "<tr class=danger><td colspan=11 align=center>Tidak Ada Record</td></tr>";

    ?>
    </tbody>
    </table>

<div align="left">
<?php  
$jml = mysql_query("SELECT * FROM `request` ORDER BY realisasi ASC");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=request&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=request&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=request&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function request_list_search(){
    if(isset($_POST['search'])){$search = $_POST['search'];}
    elseif(isset($_GET['search'])){$search = $_GET['search'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Request</h4></td>
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
      $page_query = mysql_query("SELECT COUNT(*) FROM `request` WHERE kd_pengaju LIKE '%$search%' or judul LIKE '%$search%'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=request&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=request&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=request&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="?page=request">             
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="cari judul/kode pengaju" required>
                            <span class="form-group input-group-btn">
                                <button class="btn btn-default" type="submit">Cari</button>
                                <a href="?page=request&form-request" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th>Kode Request</th>
                <?php if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) { ?>
                <th>Nama Pengaju</th>
                <?php } ?>
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
    $no 	= $start+1;
	$sql 	= mysql_query("SELECT * FROM request WHERE kd_pengaju LIKE '%$search%' or judul LIKE '%$search%' ORDER BY tgl_req DESC LIMIT $start,$per_page");
	$jml 	= mysql_num_rows($sql);
	if($jml >=1){
		while($data=mysql_fetch_array($sql)){
            echo"<tr class=warning>";
            echo"<td>".$no++."</td>";
            echo"<td>".$data['kd_req']."</td>";
            $q = mysql_query("SELECT * FROM anggota WHERE kd_mem='$data[kd_pengaju]'");
            $r = mysql_num_rows($q);
            if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {
                ?>
            <td>
            <?php
            $q1 = mysql_query("SELECT nama,kd_mem FROM anggota WHERE nim = '$data[kd_pengaju]'");
                $d1 = mysql_fetch_array($q1);
                if($q1){
                    echo"<a href=?page=members&view-member=".$d1['kd_mem'].">".$d1['nama']."</a>";
                }
                $q3 = mysql_query("SELECT nama FROM petugas WHERE kd_petugas = '$data[kd_pengaju]'");
                $d3 = mysql_fetch_array($q3);
                if($q3){
                    echo"<a href=?page=librarians&view-librarian=".$data['kd_pengaju'].">".$d3['nama']."</a>";
                }            
            ?>
            </td>
            <?php
            }
            echo"<td>".$data['judul']."</td>";
            echo"<td>".$data['pengarang']."</td>";
            echo"<td>".$data['penerbit']."</td>";
            echo"<td>".$data['th_terbit']."</td>";
            echo"<td>".$data['edisi']."</td>";
            echo"<td>".tgl_sql($data['tgl_req'])."</td>";
            if($data['realisasi']=='0'){
                echo"<td>Pending</td>";
                if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {
                echo"<td><a href=\"?page=request&id=".$data['kd_req']."\" class=\"btn btn-primary\" type=\"button\"><i class=\"fa fa-plus\"></i> Acc</a></td>";}
                else{echo "<td></td>";}
            }elseif($data['realisasi']=='1'){
                echo"<td>Approved</td>";
                if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {
                echo"<td>-</td>";}else{echo "<td></td>";}
            }
            echo"</tr>";
        }
    }else echo "<tr class=danger><td colspan=11 align=center>Tidak Ada Record</td></tr>";

    ?>
    </tbody>
    </table>

<div align="left">
<?php  
$jml = mysql_query("SELECT * FROM `request` WHERE kd_pengaju LIKE '%$search%' or judul LIKE '%$search%'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=request&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=request&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=request&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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
?>