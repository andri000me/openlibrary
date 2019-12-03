<div class="md-col-12">
<?php
if(isset($_GET['add-paper'])){
    form_kp();
if(isset($_POST['save']))
        input_kp();
    }
elseif(isset($_POST['search']) or isset($_GET['search'])){
    kp_list_search();
}
elseif(isset($_GET['detail-id'])){
    detail_kp();
}
elseif(isset($_GET['update-kp'])){
    //update_kp();
     if($_GET['update-kp']=='info'){
        update_kp_info();
    }
    elseif($_GET['update-kp']=='abstrak'){
        form_update_kp_abstrak();
    }
    elseif($_GET['update-kp']=='pengarang'){
        form_update_kp_pengarang();
    }
    elseif($_GET['update-kp']=='penerbit'){
        form_update_kp_penerbit();
    }
    elseif($_GET['update-kp']=='sirkulasi'){
        form_update_kp_sirkulasi();
    }
}
else{
    kp_list();
}
?>
</div>

<?php
function kp_list(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Koleksi Laporan Kerja Praktek (KP) Mahasiswa</h4></td>
                <!--<td width="10%"><div align="left">
                    <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=intern-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=intern-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=intern-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=intern-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=intern-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=intern-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>-->
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `kp`");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=intern&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=intern&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=intern&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="?page=intern">             
                    <div class="input-group">
                        <input type="text" name="search" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=intern&add-paper" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
        $sql    = mysql_query("SELECT * FROM kp ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                $kd = $data['kd_kp'];
        ?>
            <tr>                                    
                <td><h4><?php echo "<a href=?page=intern&detail-id=".$data['kd_kp'].">".$data['judul']."</a>"; ?></h4>
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
$jml = mysql_query("SELECT * FROM `kp`");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=intern&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=intern&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=intern&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function kp_list_search(){
    if(isset($_POST['search'])){$search = $_POST['search'];}
    elseif(isset($_GET['search'])){$search = $_GET['search'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Koleksi Laporan Kerja Praktek (KP) Mahasiswa</h4></td>
                <!--<td width="10%"><div align="left">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Jurusan</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=intern-filter&tech">Teknik Informatika</a></li>
                            <li><a href="?page=intern-filter&tech-man">Manajemen Informatika</a></li>
                            <li><a href="?page=intern-filter&acc">Ekonomi Akuntansi</a></li>
                            <li><a href="?page=intern-filter&manj">Ekonomi Manajemen</a></li>
                            <li><a href="?page=intern-filter&lit">Sastra Inggris</a></li>
                            <li><a href="?page=intern-filter&com">Ilmu Komunikasi</a></li>
                        </ul>
                </div>
            </div></td>-->
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `kp` WHERE (judul LIKE '%$search%' OR thn_terbit LIKE '%$search%')");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=intern&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                if ($x == $noPage)
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                else
                                    echo " <a href='".$_SERVER['PHP_SELF']."?page=intern&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                        if ($noPage < $pages)
                            echo "<a href='".$_SERVER['PHP_SELF']."?page=intern&pages=".($noPage+1)."&search=".$search,"' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="?page=intern">             
                    <div class="input-group">
                        <input type="text" name="search" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=kp&add-kp" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
        $sql    = mysql_query("SELECT * FROM kp WHERE judul LIKE '%$search%' OR thn_terbit LIKE '%$search%' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                $kd = $data['kd_kp'];
        ?>
            <tr>                                    
                <td><h4><?php echo "<a href=?page=intern&detail-id=".$data['kd_kp'].">".$data['judul']."</a>"; ?></h4>
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
$jml = mysql_query("SELECT * FROM `kp` WHERE (judul LIKE '%$search%' OR thn_terbit LIKE '%$search%')");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=intern&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=intern&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=intern&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function detail_kp(){
    $id     = $_GET['detail-id'];
    $no     = 1;
    $sql    = mysql_query("SELECT * FROM kp WHERE kd_kp='$id'");
    $data   = mysql_fetch_array($sql);

?>

<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td><h4 class="header-line"><?php echo $data['judul']; ?></h4></td>
                
            </tr>
        </table>           
    </div>
</div>

<div class="row">
    <div class="col-md-12">           
        <!--    Context Classes  -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Informasi Umum</a></li>
                        <li class=""><a href="#abstrak" data-toggle="tab">Abstraksi</a></li>
                        <li class=""><a href="#pengarang" data-toggle="tab">Pengarang</a></li>
                        <li class=""><a href="#penerbit" data-toggle="tab">Penerbit</a></li>
                        <li class=""><a href="#link-download" data-toggle="tab">Download Link</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="home">
                            <p>        
                                <table class="table table-striped">                                   
                                    <tbody>                             
                                        <tr>
                                            <td align="center" rowspan="6" width="15%">
                                                <div class="item active">                                            
                                                    <img src="assets/img/kp.png" alt="" />                          
                                                </div>
                                                <?php //echo $no++; ?></td>                                                
                                            <td width="10%">Kode</td>
                                            <td>
                                                <?php echo $data['kd_kp']; ?></td>
                                        </tr>  
                                        <tr>
                                            <td>ISSN ISBN</td>
                                            <td><?php if(empty($data['issn_isbn'])) echo "-"; else echo $data['issn_isbn']; ?></td>
                                        </tr>                                      
                                        <tr>
                                            <td>Klasifikasi</td>
                                            <td><?php 
                                                    $query = mysql_query("SELECT * FROM klasifikasi_buku WHERE kode = '$data[kd_klasifikasi]' ");
                                                    $datak = mysql_fetch_array($query);
                                                    echo $datak['kd_klasifikasi']." - ".$datak['nama']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Jurusan</td>
                                            <td><?php echo $data['jurusan']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Subjek</td>
                                            <td><?php 
                                                    $query2 = mysql_query("SELECT * FROM subjek_buku WHERE kd_subjek = '$data[kd_subjek]' ");
                                                    $datas = mysql_fetch_array($query2);
                                                    echo $datas['subjek_utama']; ?></td>                                            
                                        </tr>
                                        <?php if(isset($_SESSION['user'])) {?>
                                        <tr>
                                            <td>Status</td>
                                            <td><?php echo $data['status']; ?></td>                                            
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><?php if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                                                        <a href="?page=intern&update-kp=info&id=<?php echo $data['kd_kp'];?>" name="edit">
                                                        <i class="fa fa-pencil"></i> Edit</a><?php } ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade" id="abstrak">
                            <p>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td width="10%">Abstraksi</td>
                                        <td width="5%"></td>
                                        <td><?php echo $data['abstrak']; ?></td>
                                    </tr>                                   
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><?php if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                                                    <a href="?page=intern&update-kp=abstrak&id=<?php echo $data['kd_kp'];?>" name="edit">
                                                    <i class="fa fa-pencil"></i> Edit</a><?php } ?></td>
                                        </tr> 
                                </tbody>
                            </table>       
                            </div>
                            <div class="tab-pane fade" id="pengarang">
                            <p>
                            <table class="table">
                                <tbody>
                                <?php 
                                        $sql1 = mysql_query("SELECT * FROM pengarang WHERE kd_pengarang = '$data[kd_penulis]'");
                                        $data1 = mysql_fetch_array($sql1);
                                ?>
                                    <tr>
                                        <td width="15%">Nama</td>
                                        <td width="5%">:</td>
                                        <td><?php echo $data1['nama']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis</td>
                                        <td>:</td>
                                        <td><?php echo $data1['jenis']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Penyunting</td>
                                        <td>:</td>
                                        <td><?php echo $data1['penyunting']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Penterjemah</td>
                                        <td>:</td>
                                        <td><?php echo $data1['penterjemah']; ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><?php if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                                                    <a href="?page=intern&update-kp=pengarang&id=<?php echo $data['kd_kp'];?>" name="edit">
                                                    <i class="fa fa-pencil"></i> Edit</a><?php } ?></td>
                                    </tr>
                                </tbody>
                            </table>              
                            </div>
                            <div class="tab-pane fade" id="penerbit">
                            <p>
                            <table class="table ">
                                <tbody>
                                <?php 
                                        $sql2 = mysql_query("SELECT * FROM penerbit WHERE kd_penerbit = '$data[kd_penerbit]'");
                                        $data2 = mysql_fetch_array($sql2);
                                ?>
                                    <tr>
                                        <td width="15%">Nama</td>
                                        <td width="5%">:</td>
                                        <td><?php echo $data2['nama_penerbit'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Kota</td>
                                        <td>:</td>
                                        <td><?php echo $data2['kota'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Tahun</td>
                                        <td>:</td>
                                        <td><?php echo $data['thn_terbit'];?></td>
                                    </tr>                                    
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><?php if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                                                    <a href="?page=intern&update-kp=penerbit&id=<?php echo $data['kd_kp'];?>" name="edit">
                                                    <i class="fa fa-pencil"></i> Edit</a><?php } ?></td>
                                    </tr>
                                </tbody>
                            </table>                 
                            </div>
                            
                            <div class="tab-pane fade" id="link-download">
                            <p>
                            <?php if(isset($_SESSION['user'])) {?>
                            <div id="file-manager">
                            <?php                            
                                            
                                            $result = mysql_query("SELECT * FROM download_ebook WHERE kd_ebook='$data[kd_kp]'");

                                            if(mysql_num_rows($result)){
                                                $row=mysql_fetch_assoc($result);

                                                /*  The key of the $file_downloads array will be the name of the file,
                                                    and will contain the number of downloads: */
        
                                                $file_downloads=$row['hits'];
                                            }else{
                                                $file_downloads=0;}
                                ?>                                            
                                                
                                    <ul class="manager">
                                        <li><a href="?page=download&id=<?php echo $data['kd_kp'];?>&file=<?php echo $data['file'] ?>" target="_blank" >
                                            <?php echo $data['judul']; ?>
                                                <span class="download-count" title="Times Downloaded">
                                            <?php echo (int)$file_downloads; ?> times downloaded</span> 
                                                <span class="download-label">download</span>
                                            </a>
                                        </li>
                                    </ul>
                             </div>
                             <?php }else{echo "Anda harus login untuk mendownload.";} ?>         
                            </div>
                        </div>

                     </div>
                </div>
                <a href="?page=intern"> <i class="fa fa-reorder"></i> Kembali </a>
        </div>
    </div>
</div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
}

function form_kp(){
?>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM INPUT LAPORAN KERJA PRAKTEK BARU
        </div>
        <div class="alert alert-warning">
            Upload file Anda dengan melengkapi form di bawah ini. File yang bisa di Upload hanya file dengan ekstensi <b>.doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .rar, .zip</b> dan besar file (file size) maksimal hanya 1 MB.
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
                <table width="100%">
                    <tr>
                        <td width="20%"><div class="form-group"><label>Judul</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="judul" required/></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Penulis</label></div></td>
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
                        <td width="20%"><div class="form-group"><label>ISSN ISBN</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="isbn" /></div></td>
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
                        <td width="20%"><div class="form-group"><label>Jurusan</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="jurusan" readonly="" value="Teknik Informatika" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Abstrak</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><textarea class="form-control" rows="3" name="abstrak"></textarea></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Pilih File</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input type="file" name="img" required /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><br/><button type="submit" class="btn btn-info" name="save">Simpan </button>
                                            <a href="?page=kp" class="btn btn-danger"> Batal </a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}

function update_kp_info(){
$kd_kp  = $_GET['id'];
$query       = mysql_query("SELECT * FROM kp WHERE kd_kp='$kd_kp'") or die (mysql_error());
$data        = mysql_fetch_array($query);

if(isset($_POST['update'])){
$date       = date("Y-m-d");

$judul      = mysql_real_escape_string($_POST['judul']);

$allowed_ext    = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'rar', 'zip');
$file_name      = $_FILES['file']['name'];
$file_ext       = strtolower(end(explode('.', $file_name)));
$file_size      = $_FILES['file']['size'];
$file_tmp       = $_FILES['file']['tmp_name'];
$kd_petugas     = $_SESSION['user'];
  
if(empty($file_name)){   //jika gambar kosong atau tidak di ganti
    $q  = mysql_query("UPDATE kp SET
            kd_kp  = '$_POST[kd_kp]',
            kd_petugas  = '$kd_petugas',
            judul       = '$judul',
            issn_isbn   = '$_POST[isbn]',
            date_update = '$date',
            status      = '$_POST[status]',
            ket         = '$_POST[ket]'
            WHERE kd_kp='$kd_kp'") or die (mysql_error());

                if($q){
            ?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di update <a href="?page=intern&detail-id=<?php echo $data['kd_kp'];?>" class="alert-link">Kembali</a>
                </div>
            <?php 
            }

}elseif(!empty($file_name)){ // jika gambar di ganti
if(in_array($file_ext, $allowed_ext) === true){
    if($file_size < 1044070){
        $lokasi = 'assets/bp/'.$kd_kp.'.'.$file_ext;
        move_uploaded_file($file_tmp, $lokasi);

        $q  = mysql_query("UPDATE kp SET
            kd_kp  = '$_POST[kd_kp]',
            kd_petugas  = '$kd_petugas',
            judul       = '$judul',
            issn_isbn   = '$_POST[isbn]',
            date_update = '$date',
            status      = '$_POST[status]',
            ket         = '$_POST[ket]',
            file        = '$lokasi'
            WHERE kd_kp='$kd_kp'") or die (mysql_error());
                
                if($q){
?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        Data berhasil di input <a href="?page=intern&detail-id=<?php echo $data['kd_kp'];?>" class="alert-link">Kembali</a>
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
            FORM UPDATE LAPORAN KERJA PRAKTEK
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
                <table width="100%">
                    <tr>
                        <td width="20%"><div class="form-group"><label>Kode Laporan Kerja Praktek (KP)</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                            <input class="form-control" type="text" name="kd_kp" readonly value="<?php echo $data['kd_kp'];?>" /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Judul Laporan Kerja Praktek (KP)</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                            <input class="form-control" type="text" name="judul" value="<?php echo $data['judul'];?>" autofocus required /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>ISSN ISBN</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                            <input class="form-control" type="text" name="isbn" value="<?php echo $data['issn_isbn'];?>" /></div></td>
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
                                                    echo "<option>Manajemen</option>";}
                                                  elseif($data['jurusan']=='Manajemen Informatika') {
                                                    echo "<option>Teknik Informatika</option>";
                                                    echo "<option>Sastra Inggris</option>";
                                                    echo "<option>Ilmu Komunikasi</option>";
                                                    echo "<option>Akuntansi</option>";
                                                    echo "<option>Manajemen</option>";}
                                                  elseif($data['jurusan']=='Sastra Inggris') {
                                                    echo "<option>Teknik Informatika</option>";
                                                    echo "<option>Manajemen Informatika</option>";
                                                    echo "<option>Ilmu Komunikasi</option>";
                                                    echo "<option>Akuntansi</option>";
                                                    echo "<option>Manajemen</option>";}
                                                  elseif($data['jurusan']=='Ilmu Komunikasi') {
                                                    echo "<option>Teknik Informatika</option>";
                                                    echo "<option>Manajemen Informatika</option>";
                                                    echo "<option>Sastra Inggris</option>";
                                                    echo "<option>Akuntansi</option>";
                                                    echo "<option>Manajemen</option>";}
                                                  elseif($data['jurusan']=='Manajemen') {
                                                    echo "<option>Akuntansi</option>";
                                                    echo "<option>Teknik Informatika</option>";
                                                    echo "<option>Manajemen Informatika</option>";
                                                    echo "<option>Sastra Inggris</option>";
                                                    echo "<option>Ilmu Komunikasi</option>";}
                                                  elseif($data['jurusan']=='Akuntansi') {
                                                    echo "<option>Manajemen</option>";
                                                    echo "<option>Teknik Informatika</option>";
                                                    echo "<option>Manajemen Informatika</option>";
                                                    echo "<option>Sastra Inggris</option>";
                                                    echo "<option>Ilmu Komunikasi</option>";}?>                                           
                                            </select>
                                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Status</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group">
                                            <select class="form-control" name="status" >
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
                        <td width="70%"><textarea class="form-control" rows="3" name="ket"><?php echo $data['ket'];?></textarea></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Ganti File</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input type="file" name="file" /></div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><br/><div class="form-group"><button type="submit" class="btn btn-info" name="update">Simpan </button>
                                        <a href="?page=intern&detail-id=<?php echo $kd_kp;?>" class="btn btn-danger"> Batal </a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}


function form_update_kp_abstrak(){
    $kd_kp=$_GET['id'];
    $query  = mysql_query("SELECT * FROM kp WHERE kd_kp='$kd_kp'") or die (mysql_error());
    $data   = mysql_fetch_array($query);
    ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM UPDATE LAPORAN KERJA PRAKTEK
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
                                        <a href="?page=intern&detail-id=<?php echo $kd_kp;?>" class="btn btn-danger"> Batal </a></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php

if(isset($_POST['update'])){
$date       = date("Y-m-d");
$kd_kp    = $_GET['id'];

$abstrak       = mysql_real_escape_string($_POST['abstrak']);

    $q  = mysql_query("UPDATE kp SET
            abstrak      = '$_POST[abstrak]'            
            WHERE kd_kp='$kd_kp'") or die (mysql_error());

                if($q){
            ?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di update <a href="?page=intern&detail-id=<?php echo $kd_kp ;?>" class="alert-link">Kembali</a>
                </div>
            <?php 
            }
}
}

function form_update_kp_pengarang(){
    $kd_kp=$_GET['id'];
    $query  = mysql_query("SELECT * FROM kp WHERE kd_kp='$kd_kp'") or die (mysql_error());
    $data   = mysql_fetch_array($query);
    $query2  = mysql_query("SELECT * FROM pengarang WHERE kd_pengarang='$data[kd_penulis]'") or die (mysql_error());
    $data2   = mysql_fetch_array($query2);
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
                        <td width="20%"><div class="form-group"><label>Jenis</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="jenis" value="<?php echo $data2['jenis'];?>" required /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Penyunting</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="penyunting" value="<?php echo $data2['penyunting'];?>" autofocus /></td>
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
                                        <a href="?page=intern&detail-id=<?php echo $kd_kp;?>" class="btn btn-danger"> Batal </a></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
if(isset($_POST['update'])){
$date       = date("Y-m-d");

    $q  = mysql_query("UPDATE pengarang SET
            nama        = '$_POST[nama]',
            jenis       = '$_POST[jenis]',
            penyunting  = '$_POST[penyunting]',
            penterjemah = '$_POST[penerjemah]'           
            WHERE kd_pengarang='$data[kd_penulis]'") or die (mysql_error());

                if($q){
            ?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di update <a href="?page=intern&detail-id=<?php echo $kd_kp ;?>" class="alert-link">Kembali</a>
                </div>
            <?php 
            }
}
}

function form_update_kp_penerbit(){
    $kd_kp=$_GET['id'];
    $query  = mysql_query("SELECT * FROM kp WHERE kd_kp='$kd_kp'") or die (mysql_error());
    $data   = mysql_fetch_array($query);
    $query2  = mysql_query("SELECT * FROM penerbit WHERE kd_penerbit='$data[kd_penerbit]'") or die (mysql_error());
    $data2   = mysql_fetch_array($query2);
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
                                        <a href="?page=intern&detail-id=<?php echo $jurnal;?>" class="btn btn-danger"> Batal </a></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php

if(isset($_POST['update'])){
$date       = date("Y-m-d");

    $q  = mysql_query("UPDATE penerbit SET
            nama_penerbit      = '$_POST[nama]',
            kota               = '$_POST[kota]'           
            WHERE kd_penerbit='$data[kd_penerbit]'") or die (mysql_error());

    $q2  = mysql_query("UPDATE kp SET
            thn_terbit     = '$_POST[tahun]'          
            WHERE kd_kp='$kd_kp'") or die (mysql_error());

                if($q and $q2){
            ?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di update <a href="?page=intern&detail-id=<?php echo $kd_kp ;?>" class="alert-link">Kembali</a>
                </div>
            <?php 
            }
}
}

function form_update_kp_sirkulasi(){
    $kd_kp=$_GET['id'];
    $query  = mysql_query("SELECT * FROM kp WHERE kd_kp='$kd_kp'") or die (mysql_error());
    $data   = mysql_fetch_array($query);
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
                                        <a href="?page=intern&detail-id=<?php echo $kd_kp;?>" class="btn btn-danger"> Batal </a></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
if(isset($_POST['update'])){
$date       = date("Y-m-d");
$kd_kp    = $_GET['id'];

if($_POST['sirkulasi']=='Ya'){
    $sirkulasi = "SI01";
}elseif($_POST['sirkulasi']=='Tidak'){
    $sirkulasi = "SI02";
}
   

    $q  = mysql_query("UPDATE kp SET
            kd_sirkulasi      = '$sirkulasi'            
            WHERE kd_kp='$kd_kp'") or die (mysql_error());

                if($q){
            ?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di update <a href="?page=intern&detail-id=<?php echo $kd_kp ;?>" class="alert-link">Kembali</a>
                </div>
            <?php 
            }
}
}

function input_kp(){
if(empty($_POST['judul'])) {
            echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Judul Laporan Kerja Praktek (KP)! </div>';}
        elseif(empty($_POST['pengarang'])) {
            echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Nama Pengarang! </div>';}
        elseif(empty($_POST['penerbit'])) { 
            echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Nama Penerbit! </div>';}
        elseif(empty($_POST['th_terbit'])){ 
            echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Tahun Terbit! </div>';}
        elseif(empty($_POST['kd_klasifikasi'])){ 
            echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Kode Klasifikasi! </div>';}
        elseif(empty($_POST['abstrak'])){ 
            echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Abstrak! </div>';}
else{
                
            $pengarang  = mysql_real_escape_string($_POST['pengarang']);
            $jenis      = $_POST['jenis_pengarang'];
            $penyunting = $_POST['penyunting'];
            $penerjemah = $_POST['penerjemah'];
            $penerbit   = mysql_real_escape_string($_POST['penerbit']);
            $kota       = $_POST['kota'];
            $kd_klasifikasi = $_POST['kd_klasifikasi'];
            $nama_klasifikasi = $_POST['nama_klasifikasi'];
            $subjek_utama = $_POST['subjek_utama'];
            $subjek_tambahan = $_POST['subjek_tambahan'];       

            $q1         = mysql_query("SELECT * FROM pengarang WHERE nama='$pengarang' and jenis='$jenis' and penyunting='$penyunting' and penterjemah='$penerjemah'");
            $d1         = mysql_num_rows($q1);
            $data1      = mysql_fetch_array($q1);

            if($d1 > 0){
                $kd_pengarang = $data1['kd_pengarang'];
            }else{

                $no1        = "PG";
                $qqq1       = mysql_query("SELECT max(kd_pengarang) AS last FROM pengarang WHERE kd_pengarang LIKE '$no1%'");
                $dd1        = mysql_fetch_array($qqq1);
                $lastkd1    = $dd1['last'];
                $lastNo1    = substr($lastkd1, 2, 4); 
                $nextNo1    = $lastNo1 + 1; 
                $kd_pengarang = $no1.sprintf('%04s', $nextNo1);

                $qq1 = mysql_query("INSERT INTO pengarang VALUES(
                      '$kd_pengarang',
                      '$pengarang',
                      '$jenis',
                      '$penyunting',
                      '$penerjemah')") or die (mysql_error());
            }

            $q2         = mysql_query("SELECT * FROM penerbit WHERE nama_penerbit='$penerbit' and kota='$kota'");
            $d2         = mysql_num_rows($q2);
            $data2      = mysql_fetch_array($q2);

            if($d2 > 0){
                $kd_penerbit = $data2['kd_penerbit'];
            }else{
                $no2        = "PT";
                $qqq2       = mysql_query("SELECT max(kd_penerbit) AS last FROM penerbit WHERE kd_penerbit LIKE '$no2%'");
                $dd2        = mysql_fetch_array($qqq2);
                $lastkd2    = $dd2['last'];
                $lastNo2    = substr($lastkd2, 2, 4); 
                $nextNo2    = $lastNo2 + 1; 
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

            $q4         = mysql_query("SELECT * FROM subjek_buku WHERE subjek_utama='$subjek_utama' and subjek_tambahan='$subjek_tambahan'");
            $d4         = mysql_num_rows($q4);
            $data4      = mysql_fetch_array($q4);

            if($d4 > 0){
                $kd_subjek = $data4['kd_subjek'];
            }else{
                $no4        = "SJ";
                $qqq4       = mysql_query("SELECT max(kd_subjek) AS last FROM subjek_buku WHERE kd_subjek LIKE '$no4%'");
                $dd4        = mysql_fetch_array($qqq4);
                $lastkd4    = $dd4['last'];
                $lastNo4    = substr($lastkd4, 2, 4); 
                $nextNo4    = $lastNo4 + 1; 
                $kd_subjek  = $no4.sprintf('%04s', $nextNo4);
                $qq4 = mysql_query("INSERT INTO subjek_buku VALUES(
                      '$kd_subjek',
                      '$subjek_utama',
                      '$subjek_tambahan',
                      '')") or die (mysql_error());
            }

            $date_input = date("Y-m-d");
            $judul      = mysql_real_escape_string($_POST['judul']);
            $abstrak    = mysql_real_escape_string($_POST['abstrak']);

            $allowed_ext    = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'rar', 'zip');
            $file_name      = $_FILES['img']['name'];
            $file_ext       = strtolower(end(explode('.', $file_name)));
            $file_size      = $_FILES['img']['size'];
            $file_tmp       = $_FILES['img']['tmp_name'];

            $no5        = "kp";
            $qqq5       = mysql_query("SELECT max(kd_kp) AS last FROM kp WHERE kd_kp LIKE '$no5%'");
            $dd5        = mysql_fetch_array($qqq5);
            $lastkd5    = $dd5['last'];
            $lastNo5    = substr($lastkd5, 2, 4); 
            $nextNo5    = $lastNo5 + 1; 
            $kd_kp  = $no5.sprintf('%04s', $nextNo5);

            $kd_petugas = $_SESSION['user'];

                if(in_array($file_ext, $allowed_ext) === true){
                 if($file_size < 1044070){
                    $lokasi = 'upload_file/'.$kd_kp.'.'.$file_ext;
                    move_uploaded_file($file_tmp, $lokasi);

            $q          = mysql_query("INSERT INTO kp VALUES(
                        '$kd_kp',
                        '$kd_petugas',
                        '$judul',
                        '$kd_pengarang',                        
                        '$kd_penerbit',
                        '$klasifikasi',
                        '$kd_subjek',
                        '$_POST[th_terbit]',
                        '$_POST[isbn]',
                        '$_POST[jurusan]',
                        '$abstrak',
                        'Tersedia',
                        '$date_input',
                        '',
                        '$lokasi',
                        '')") or die (mysql_error());
        if($q){
            ?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di input <a href="?page=intern" class="alert-link">Kembali</a>
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