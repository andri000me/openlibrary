<div class="md-col-12">
<?php
if((isset($_POST['search'])) or (isset($_GET['search']))) {
    catalogue_list_search();
}else{
    catalogue_list();
}
?>
</div>

<?php
function catalogue_list(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Katalog Koleksi Perpustakaan</h4></td>
                <td width="10%"><div align="right">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Fakultas</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=book-filter&tech">Teknik</a></li>
                            <li><a href="?page=book-filter&eco">Ekonomi</a></li>
                            <li><a href="?page=book-filter&lit">Sastra</a></li>
                            <li><a href="?page=book-filter&com">Fikom</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=book-filter&uc">Umum</a></li>
                        </ul>
                </div>
            </div></td>
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=catalogue&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=catalogue&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=catalogue&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="?page=catalogue">             
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari Judul" required>
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=book-collection&form-buku" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
        <thead>
            <tr>                                
                <th width="10%"><div align="center">No. Katalog</div></th>
                <th width="50%"><div align="center">Katalog</div></th>
                <th width="10%"><div align="center">Subjek</div></th>
                <th width="10%"><div align="center">Sirkulasi</div></th>
                <?php if(isset($_SESSION['user'])){?>
                <th width="10%"><div align="center">Status</div></th>                
                <th width="10%"><div align="center">Aksi</div></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php
        $no 	= 1;
		$sql 	= mysql_query("SELECT * FROM buku ORDER BY kd_buku ASC LIMIT $start,$per_page");
		$jml 	= mysql_num_rows($sql);
		if($jml >=1){
		  while($data=mysql_fetch_array($sql)){
            $kd = $data['kd_buku'];
        ?>
            <tr>
                <td align="center">
                    <div class="item active">                                            
                        <img src="<?php echo $data['image'];?>?nocache=<?php echo time(); ?>" alt="" width="100px" height="100px" />                          
                    </div>
                    <?php echo $data['kd_cat']; ?></td>
                <td><h4><?php echo "<a href=?page=detail-catalogue&id=".$data['kd_buku'].">".$data['judul']."</a>"; ?></h4>
                    <i class="fa fa-user">
                        <?php 
                        $sql2 = mysql_query("SELECT * FROM pengarang WHERE kd_pengarang = '$data[kd_pengarang]'");
                        $data2 = mysql_fetch_array($sql2);
                        echo $data2['nama']; ?></i><br/>                                        
                    <i class="fa fa-bank">
                        <?php 
                        $sql3 = mysql_query("SELECT * FROM penerbit WHERE kd_penerbit = '$data[kd_penerbit]'");
                        $data3 = mysql_fetch_array($sql3);
                        echo $data3['nama_penerbit']; ?></i><br/>
                    <i class="fa fa-tags">
                        <?php 
                        $sql4 = mysql_query("SELECT * FROM klasifikasi_buku WHERE kode = '$data[kd_klasifikasi]'");
                        $data4 = mysql_fetch_array($sql4);
                        echo $data4['nama']; ?></i><br/>
                    <i class="fa fa-download"> <?php
                        $sql5 = mysql_query("SELECT * FROM ebook WHERE kd_buku = '$kd'");
                        $jml_ebook = mysql_num_rows($sql5);
                        echo "Tersedia <a href=?page=detail-catalogue&id=".$data['kd_buku'].">".$jml_ebook."</a> file download"; ?></i><br/>                                         
                </td>
                <td align="center"><?php
                        $sql6 = mysql_query("SELECT * FROM subjek_buku WHERE kd_subjek = '$data[kd_subjek]'");
                        $data6 = mysql_fetch_array($sql6);
                        echo $data6['subjek_utama'];?>
                </td>
                <td align="center"><?php 
                    $sql1 = mysql_query("SELECT * FROM sirkulasi WHERE kd_sirkulasi = '$data[kd_sirkulasi]'");
                    $data1 = mysql_fetch_array($sql1);
                    echo $data1['jenis']; ?></i><br/></td>
                <?php if(isset($_SESSION['user'])){?>
                <td><?php 
                    $sql0 = mysql_query("SELECT * FROM buku WHERE judul = '$data[judul]' and status = 'Tersedia'");
                    $data0 = mysql_num_rows($sql0);
                    $data000 = 0;
                    while($dav=mysql_fetch_array($sql0)){
                    $sql000 = mysql_query("SELECT * FROM detail_pinjam WHERE kd_buku='$dav[kd_buku]' AND status='dipinjam'");
                    $c = mysql_fetch_array($sql000);
                    if($c['status']=='dipinjam'){
                    $data000 = $data000 + 1;}
                    }
                    $av = $data0 - $data000;
                    echo "Tersedia <a href=?page=stock&available-stock=".str_replace(" ", "%20", $data['judul']).">".$av."</a>";
                    $sql00 = mysql_query("SELECT * FROM buku WHERE judul = '$data[judul]'");
                    $data00 = mysql_num_rows($sql00);
                    $nav = $data00 + $data000;
                    echo " dari <a href=?page=stock&all-stock=".str_replace(" ", "%20", $data['judul']).">".$data00."</a> Koleksi"; ?></i><br/>
                </td>                
                <td><?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                    <a href="?page=plus-ebook&id=<?php echo $data['kd_buku']; ?>" class="btn btn-primary" type="button">
                    <i class="fa fa-plus"></i> Ebook</a>
                    <?php 
                        if(isset($_SESSION['members'])){ 
                            if(isset($_SESSION['cart']) && count($_SESSION['cart']) == 2 ) { ?>
                                <a href="?page=cart-update&act=add&kdb=<?php echo $data['kd_buku']; ?>&ref=sirkulasi" class="btn btn-primary" type="button">
                                <i class="fa fa-pencil"></i> Pinjam</a>
                    <?php } else { ?>
                                <a href="?page=cart-update&act=add&kdb=<?php echo $data['kd_buku']; ?>&ref=book-collection" class="btn btn-primary" type="button">
                                <i class="fa fa-pencil"></i> Pinjam</a>
                    <?php } } } ?></td>
                <?php } ?>
            </tr>
    <?php
            }
                            
        }else echo "<tr class=danger><td colspan=6 align=center>Tidak Ada Record</td></td>";

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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=catalogue&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=catalogue&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=catalogue&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
</div>
</div>
</div>
</div>
</div>
</div>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
}

function catalogue_list_search(){
    if(isset($_POST['search'])){$search = $_POST['search'];}
    elseif(isset($_GET['search'])){$search = $_GET['search'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Katalog Koleksi Perpustakaan</h4></td>
                <td width="10%"><div align="right">
                    <div class="btn-group">

                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Fakultas</a></li>
                            <li class="divider"></li>
                            <li><a href="?page=book-filter&tech">Teknik</a></li>
                            <li><a href="?page=book-filter&eco">Ekonomi</a></li>
                            <li><a href="?page=book-filter&lit">Sastra</a></li>
                            <li><a href="?page=book-filter&com">Fikom</a></li>
                        </ul>
                </div>
            </div></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `buku` WHERE judul LIKE '%$search%'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=catalogue&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                            $showPage = $x;
                            if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                if (($showPage != ($pages - 1)) && ($x == $pages))
                                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=catalogue&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=catalogue&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="?apge=catalogue">             
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari Judul" required>
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=book-collection&form-buku" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
        <thead>
            <tr>                                
                <th width="10%"><div align="center">No. Katalog</div></th>
                <th width="50%"><div align="center">Katalog</div></th>
                <th width="10%"><div align="center">Subjek</div></th>
                <th width="10%"><div align="center">Sirkulasi</div></th>
                <?php if(isset($_SESSION['user'])){?>
                <th width="10%"><div align="center">Status</div></th>                
                <th width="10%"><div align="center">Aksi</div></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php
        $no     = 1;
        $sql    = mysql_query("SELECT * FROM buku WHERE judul LIKE '%$search%' ORDER BY judul ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
          while($data=mysql_fetch_array($sql)){
            $kd = $data['kd_buku'];
        ?>
            <tr>
                <td align="center">
                    <div class="item active">                                            
                        <img src="<?php echo $data['image'];?>?nocache=<?php echo time(); ?>" alt="" width="100px" height="100px" />                          
                    </div>
                    <?php echo $data['kd_cat']; ?></td>
                <td><h4><?php echo "<a href=?page=detail-catalogue&id=".$data['kd_buku'].">".$data['judul']."</a>"; ?></h4>
                    <i class="fa fa-user">
                        <?php 
                        $sql2 = mysql_query("SELECT * FROM pengarang WHERE kd_pengarang = '$data[kd_pengarang]'");
                        $data2 = mysql_fetch_array($sql2);
                        echo $data2['nama']; ?></i><br/>                                        
                    <i class="fa fa-bank">
                        <?php 
                        $sql3 = mysql_query("SELECT * FROM penerbit WHERE kd_penerbit = '$data[kd_penerbit]'");
                        $data3 = mysql_fetch_array($sql3);
                        echo $data3['nama_penerbit']; ?></i><br/>
                    <i class="fa fa-tags">
                        <?php 
                        $sql4 = mysql_query("SELECT * FROM klasifikasi_buku WHERE kode = '$data[kd_klasifikasi]'");
                        $data4 = mysql_fetch_array($sql4);
                        echo $data4['nama']; ?></i><br/>
                    <i class="fa fa-download"> <?php
                        $sql5 = mysql_query("SELECT * FROM ebook WHERE kd_ebook LIKE '$kd%'");
                        $jml_ebook = mysql_num_rows($sql5);
                        echo "Tersedia <a href=?page=detail-catalogue&id=".$data['kd_buku'].">".$jml_ebook."</a> file download"; ?></i><br/>                                         
                </td>
                <td align="center"><?php
                        $sql6 = mysql_query("SELECT * FROM subjek_buku WHERE kd_subjek = '$data[kd_subjek]'");
                        $data6 = mysql_fetch_array($sql6);
                        echo $data6['subjek_utama'];?>
                </td>
                <td align="center"><?php 
                    $sql1 = mysql_query("SELECT * FROM sirkulasi WHERE kd_sirkulasi = '$data[kd_sirkulasi]'");
                    $data1 = mysql_fetch_array($sql1);
                    echo $data1['jenis']; ?></i><br/></td>
                <?php if(isset($_SESSION['user'])){?>
                <td><?php 
                    $sql0 = mysql_query("SELECT * FROM buku WHERE judul = '$data[judul]' and status = 'Tersedia'");
                    $data0 = mysql_num_rows($sql0);
                    $sql000 = mysql_query("SELECT * FROM detail_pinjam WHERE kd_buku='$data[kd_buku]' AND status='dipinjam'");
                    $data000 = mysql_num_rows($sql000);
                    $av = $data0 - $data000;
                    echo "Tersedia <a href=?page=stock&available-stock=".str_replace(" ", "%20", $data['judul']).">".$av."</a>";
                    $sql00 = mysql_query("SELECT * FROM buku WHERE judul = '$data[judul]'");
                    $data00 = mysql_num_rows($sql00);
                    $nav = $data00 + $data000;
                    echo " dari <a href=?page=stock&all-stock=".str_replace(" ", "%20", $data['judul']).">".$data00."</a> Koleksi"; ?></i><br/></td>
                <td><?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                    <a href="?page=plus-ebook&id=<?php echo $data['kd_buku']; ?>" class="btn btn-primary" type="button">
                    <i class="fa fa-plus"></i> Ebook</a>
                    <?php 
                        if(isset($_SESSION['members'])){ 
                            if(isset($_SESSION['cart']) && count($_SESSION['cart']) == 2 ) { ?>
                                <a href="?page=cart-update&act=add&kdb=<?php echo $data['kd_buku']; ?>&ref=sirkulasi" class="btn btn-primary" type="button">
                                <i class="fa fa-pencil"></i> Pinjam</a>
                    <?php } else { ?>
                                <a href="?page=cart-update&act=add&kdb=<?php echo $data['kd_buku']; ?>&ref=book-collection" class="btn btn-primary" type="button">
                                <i class="fa fa-pencil"></i> Pinjam</a>
                    <?php } } } ?></td> <?php } ?>
                    </tr>
            </tr>
    <?php
            }
                            
        }else echo "<tr class=danger><td colspan=6 align=center>Tidak Ada Record</td></td>";

    ?>
        </tbody>
    </table>

<div align="left">
<?php  
$jml = mysql_query("SELECT * FROM `buku` WHERE judul LIKE '%$search%'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=catalogue&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=catalogue&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=catalogue&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
</div>
</div>
</div>
</div>
</div>
</div>
<?php
}
?>

