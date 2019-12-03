<div class="col-md-12">
<?php
if(isset($_GET['form-worker'])){
    form_worker();
    if(isset($_POST['reg'])){
    input_worker();
    }
}
elseif(isset($_GET['update-worker'])){
    form_update_worker();
    if(isset($_POST['update'])){
    update_worker();
    }
}
elseif(isset($_GET['view-worker'])){
	form_view_worker();
}
elseif (isset($_GET['change-pass'])) {
    form_change_pass_worker();
}
elseif (isset($_GET['change-pic'])) {
    form_change_pic_worker();
}
elseif (isset($_POST['search']) or isset($_GET['search'])) {
    workers_list_search();
}
else{
    workers_list();
}

?>
</div>

<?php
function workers_list(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">DOSEN&LEMBAGA</h4></td>
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
      $page_query = mysql_query("SELECT COUNT(*) FROM `worker`");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=workers&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                                $showPage = $x;
                                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                    if (($showPage != ($pages - 1)) && ($x == $pages))
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=workers&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=workers&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="?page=workers">             
                    <div class="input-group">
                        <input type="text" name="search" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <a href="?page=workers&form-worker" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th>Kode</th>
                <th>Kode DOSEN&LEMBAGA</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Fakultas</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no     = $start+1;
        $sql    = mysql_query("SELECT * FROM worker ORDER BY kd_worker ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                echo"
                <tr class=warning>                                  
                <td>".$no++."</td>
                <td>".$data['kd_worker']."</td>
                <td>".$data['kd_petugas']."</td>
                <td><a href=?page=workers&view-worker=".$data['kd_worker'].">".$data['nama']."</a></td>
                <td>".$data['jabatan']."</td>
                <td>".$data['fakultas']."</td>
                <td>".$data['status']."</td>
                <td><a href=?page=workers&update-worker=".$data['kd_worker']." class=\"btn btn-primary\" type=\"button\">
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
    $jml = mysql_query("SELECT * FROM `worker`");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=workers&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=workers&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=workers&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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

function workers_list_search(){
    if(isset($_POST['search'])){$search = $_POST['search'];}
    elseif(isset($_GET['search'])){$search = $_GET['search'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">DOSEN&LEMBAGA</h4></td>
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
      $page_query = mysql_query("SELECT COUNT(*) FROM `worker` WHERE kd_worker LIKE '%$search%' or nama LIKE '%$search%'");
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
                            echo  "<a href='".$_SERVER['PHP_SELF']."?page=workers&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                            for($x=1; $x<=$pages; $x++){
                                $showPage = $x;
                                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                    if (($showPage != ($pages - 1)) && ($x == $pages))
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                    if ($x == $noPage)
                                        echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                    else
                                        echo " <a href='".$_SERVER['PHP_SELF']."?page=workers&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                            }
                            if ($noPage < $pages)
                                echo "<a href='".$_SERVER['PHP_SELF']."?page=workers&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                    }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%" align="">
                    <form role="form" method="post" action="?page=workers">             
                    <div class="input-group">
                        <input type="text" name="search" class="form-control">
                        <span class="form-group input-group-btn">
                            <button class="btn btn-default" type="submit">Cari</button>
                            <a href="?page=workers&form-worker" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                <th>Kode DOSEN&LEMBAGA</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no     = $start+1;
        $sql    = mysql_query("SELECT * FROM worker WHERE kd_worker LIKE '%$search%' or nama LIKE '%$search%' ORDER BY kd_worker ASC LIMIT $start,$per_page");
        $jml    = mysql_num_rows($sql);
        if($jml >=1){
            while($data=mysql_fetch_array($sql)){
                echo"
                <tr class=warning>                                  
                <td>".$no++."</td>
                <td>".$data['kd_worker']."</td>
                <td><a href=?page=workers&view-worker=".$data['kd_worker'].">".$data['nama']."</a></td>
                <td>".$data['jabatan']."</td>
                <td>".$data['status']."</td>
                <td><a href=?page=workers&update-worker=".$data['kd_worker']." class=\"btn btn-primary\" type=\"button\">
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
    $jml = mysql_query("SELECT * FROM `worker` WHERE kd_worker LIKE '%$search%' or nama LIKE '%$search%'");
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
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=workers&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=workers&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=workers&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
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
<!---------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
function form_worker(){
    if(isset($_SESSION['user']) and (($_SESSION['level'])=='admin')) {
?>
<div class="alert alert-warning">
    Gambar yang bisa di Upload hanya file dengan ekstensi <b>.jpg</b> dan besar file (file size) maksimal hanya 1 MB.
 </div>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM INPUT DOSEN&LEMBAGA
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data" onsubmit="return formValidatorLib()">
               <table width="100%">
               <tr>
                        <td width="20%"><div class="form-group"><label>Kode</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="kd_worker" id="kd_worker" autofocus/></div></td>
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
                                                <option>DOSEN&LEMBAGA</option>
                                                <option>Dosen</option>
                                                <option>TU</option>
                                            </select>
                                        </div>
                        </td>
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
                        <td width="20%"><div class="form-group"><label>Gambar Profil</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input type="file" name="img" id="img" required /></div></td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><div class="form-group"><button type="submit" class="btn btn-info" name="reg">Register </button>
                        <a href="?page=workers" class="btn btn-danger"> Batal </a></div></td>
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
?>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------ -->
<?php
function form_update_worker(){
    if(isset($_SESSION['user']) and (($_SESSION['level'])=='admin')) {
    $kd_worker     = $_GET['update-worker'];
    $query          = mysql_query("SELECT * FROM worker WHERE kd_worker='$kd_worker'") or die (mysql_error());
    $data           = mysql_fetch_array($query);
    ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            FORM UPDATE DOSEN&LEMBAGA
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
                <table width="100%">
                    <tr>
                        <td width="20%"><div class="form-group"><label>Gambar</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><img src="<?php echo $data['image']; ?>" width="100px" height="100px">
                                        <div class="form-group"><input type="file" name="img" /></div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Kode DOSEN&LEMBAGA</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><div class="form-group"><input class="form-control" type="text" name="kd_worker" readonly value="<?php echo $data['kd_worker'];?>" /></div></td>
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
                                            <?php if($data['jabatan']=='Kepala Pustaka') {
                                                    echo "<option>DOSEN&LEMBAGA</option>";
                                                    echo "<option>Dosen</option>";
                                                    echo "<option>TU</option>";}
                                                  elseif($data['jabatan']=='DOSEN&LEMBAGA') {
                                                    echo "<option>Kepala Pustaka</option>";
                                                    echo "<option>Dosen</option>";
                                                    echo "<option>TU</option>";}
                                                elseif($data['jabatan']=='Dosen') {
                                                    echo "<option>DOSEN&LEMBAGA</option>";
                                                    echo "<option>Kepala Pustaka</option>";
                                                    echo "<option>TU</option>";}
                                                elseif($data['jabatan']=='TU') {
                                                    echo "<option>DOSEN&LEMBAGA</option>";
                                                    echo "<option>Kepala Pustaka</option>";
                                                    echo "<option>Dosen</option>";}?>
                                            </select>
                                        </div>
                        </td>
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
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><div class="form-group"><button type="submit" class="btn btn-info" name="update">Simpan </button>
                                        <a href="?page=workers" class="btn btn-danger"> Batal </a></div></td>
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
?>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------ -->
<?php
function form_view_worker(){
    $kd_worker     = $_GET['view-worker'];
    $query          = mysql_query("SELECT * FROM worker WHERE kd_worker='$kd_worker'") or die (mysql_error());
    $data           = mysql_fetch_array($query);
    ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            DETAIL INFORMASI
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post">
                <table width="100%">
                    <tr>
                        <td width="25%" rowspan="11"><img src="<?php echo $data['image']; ?>" width="250px" height="300px"></td>
                    </tr>
                    <tr>
                        <td width="15%"><div class="form-group"><label>Kode DOSEN&LEMBAGA</label></div></td>
                        <td><?php echo $data['kd_worker'];?></td>
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
                        <td><br/><a href="?page=workers&update-worker=<?php echo $data['kd_worker'];?>" class="btn btn-info">Edit </a>
                        <a href="?page=workers" class="btn btn-danger"> Kembali </a></td>
                    </tr>
                    <?php } ?>
                </table>
            </form>
        </div>
    </div>
<?php
}
?>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
function form_change_pass_worker(){
    $kd_worker = $_GET['change-pass'];
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
                        <td width="70%"><br/><button type="submit" class="btn btn-info" name="edit_pass_worker">Ubah</button>
                                            <a href="?page=workers&view-worker=<?php echo $kd_worker; ?>" class="btn btn-danger">Batal</a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <?php
    if(isset($_POST['edit_pass_worker'])){
        $pass = $_POST['password'];
        if(empty($pass)){
            echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>ERROR: Isikan Password Baru Anda</div>';
        }else{
            $q = mysql_query("UPDATE worker SET password = '$pass' WHERE kd_worker = '$kd_worker'") or die(mysql_error());
            if($q){?>
                        <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            Data berhasil di update <a href="?page=workers&view-worker=<?php echo $kd_worker; ?>" class="alert-link">Kembali</a></div>
                        <?php
            }
        }
    }
}

function form_change_pic_worker(){
    $date   = date("Y-m-d");
    $kd_worker = $_GET['change-pic'];
    $query  = mysql_query("SELECT * FROM worker WHERE kd_worker='$kd_worker'") or die (mysql_error());
    $data   = mysql_fetch_array($query);
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
                        <td width="70%"><img src="<?php echo $data['image']; ?>" width="100px" height="100px">
                                        <div class="form-group"><input type="file" name="img" /></div>
                        </td>
                    </tr>  
                    <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><br/><button type="submit" class="btn btn-info" name="edit_pic_worker">Ubah </button>
                                            <a href="?page=workers&view-worker=<?php echo $kd_worker; ?>" class="btn btn-danger">Batal</a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <?php
    if(isset($_POST['edit_pic_worker'])){
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
                $lokasi = 'assets/pl/'.$kd_worker.'.'.$file_ext;
                    move_uploaded_file($file_tmp, $lokasi);
                    $q  = mysql_query("UPDATE worker SET                       
                        date_update ='$date',
                        image       ='$lokasi'
                        WHERE kd_worker='$kd_worker'") or die(mysql_error());

                    if($q){?>
                        <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            Data berhasil di update <a href="?page=workers&view-worker=<?php echo $kd_worker; ?>" class="alert-link">Kembali</a></div>
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
?>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------ -->
<?php
function input_worker(){
if(empty($_POST['kd_worker'])){
    echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan ID DOSEN&LEMBAGA! </div>';}
        elseif(empty($_POST['nama'])) {
            echo '<div class="alert alert-danger"> Data Gagal Disimpan. Isikan Nama DOSEN&LEMBAGA! </div>';}
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

        $kd_worker     = $_POST['kd_worker'];
        $query          = mysql_query("SELECT kd_worker FROM worker WHERE kd_worker ='$kd_worker'");
        $sum            = mysql_num_rows($query);
        
        if($sum > 0){
            echo '<div class="alert alert-danger"> Data Gagal Disimpan. Kode DOSEN&LEMBAGA Sudah ada! </div>';
        }else{

            $allowed_ext    = array('jpg');
            $file_name      = $_FILES['img']['name'];
            $file_ext       = strtolower(end(explode('.', $file_name)));
            $file_size      = $_FILES['img']['size'];
            $file_tmp       = $_FILES['img']['tmp_name'];

            $date_reg   = date("Y-m-d");
            $nama       = mysql_real_escape_string($_POST['nama']);
            $alamat     = mysql_real_escape_string($_POST['alamat']);
            $ttl        = tgl_sql($_POST['ttl']);
            $kd_petugas = $_SESSION['user'];

            if(in_array($file_ext, $allowed_ext) === true){
                 if($file_size < 1044070){
                    $lokasi = 'assets/wp/'.$kd_worker.'.'.$file_ext;
                    move_uploaded_file($file_tmp, $lokasi);

            $q          = mysql_query("INSERT INTO worker VALUES(
                        '$kd_worker',
                        '$kd_petugas',
                        '$nama',
                        '$_POST[nik]',                      
                        '$_POST[jk]',
                        '$ttl',
                        '$alamat',
                        '$_POST[tlp]',
                        '$_POST[jabatan]',
                        '$_POST[fakultas]',
                        '$_POST[email]',
                        '$_POST[password]',
                        '$date_reg',
                        '',
                        '$lokasi',
                        'Aktif',
                        '')") or die (mysql_error());
        if($q){
            ?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di input AA
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
?>
<!-------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
function update_worker(){
$date   = date("Y-m-d");
$kd_worker = $_GET['update-worker'];
$nama   = mysql_real_escape_string($_POST['nama']);
$alamat = mysql_real_escape_string($_POST['alamat']);
$status = mysql_real_escape_string($_POST['status']);
$ttl    = tgl_sql($_POST['ttl']);

$allowed_ext    = array('jpg');
$file_name      = $_FILES['img']['name'];
$file_ext       = strtolower(end(explode('.', $file_name)));
$file_size      = $_FILES['img']['size'];
$file_tmp       = $_FILES['img']['tmp_name'];

if(empty($file_name)){   //jika gambar kosong atau tidak di ganti
    
$q      = mysql_query("UPDATE worker SET
                        nama        ='$nama',
                        nik         ='$_POST[nik]',
                        jk          ='$_POST[jk]',
                        ttl         ='$ttl',
                        alamat      ='$alamat',
                        jabatan     ='$_POST[jabatan]',                        
                        fakultas    ='$_POST[fakultas]',
                        tlp         ='$_POST[tlp]',
                        date_update ='$date',
                        status      ='$status'
                        WHERE kd_worker='$kd_worker'") or die(mysql_error());

                        if($q){
                        ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                Data berhasil di input update. <a href="?page=workers" class="alert-link">Kembali</a>
                            </div>
                        <?php 
                        }

}elseif(!empty($file_name)){ // jika gambar di ganti

if(in_array($file_ext, $allowed_ext) == true){
    if($file_size < 1044070){
         $lokasi = 'assets/pl/'.$kd_worker.'.'.$file_ext;
                    move_uploaded_file($file_tmp, $lokasi);
                    $q      = mysql_query("UPDATE worker SET
                        nama        ='$nama',
                        nik         ='$_POST[nik]',
                        jk          ='$_POST[jk]',
                        ttl         ='$ttl',
                        alamat      ='$alamat',
                        fakultas    ='$_POST[fakultas]',
                        jabatan     ='$_POST[jabatan]',
                        tlp         ='$_POST[tlp]',
                        date_update ='$date',
                        status      ='$status',
                        image       ='$lokasi'
                        WHERE kd_worker='$kd_worker'") or die(mysql_error());

                    if($q){
            ?>
            <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di update. <a href="?page=workers" class="alert-link">Kembali</a>
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
?>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------->
