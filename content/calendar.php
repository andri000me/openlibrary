<?php 
if(isset($_SESSION['user']) && ($_SESSION['level']=='petugas' OR ($_SESSION['level'])=='admin')){
	if(isset($_GET['add'])){
		form_libur();
	if(isset($_POST['save'])){
		input_libur();}
	}elseif(isset($_GET['update'])){
		edit_libur();
		if(isset($_POST['edit'])){
			update_libur();}
	}elseif(isset($_GET['del-id'])){
		hapus_libur();}
	elseif (isset($_POST['search']) or (isset($_GET['search']))) {
		t_libur_search();
	}else{
	t_libur();
	}
}else{
?>
	<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		Maaf Anda tidak dapat mengakses halaman ini</div>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
}

function t_libur(){ ?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Daftar Hari Libur</h4></td>
                <!--<td width="10%"><div align="right">
                    <div class="btn-group">					
                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>                    
                        <ul class="dropdown-menu">
                            <li><a href="#">Tanggal Ascending</a></li>
                            <li><a href="#">Tanggal Descending</a></li>
                        </ul>
                </div>
            </div></td>-->
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;      
      $page_query = mysql_query("SELECT COUNT(*) FROM `kalender_unpi`");
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
		echo  "<a href='".$_SERVER['PHP_SELF']."?page=calendar&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
			for($x=1; $x<=$pages; $x++){
			$showPage = $x;
				if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
            	
            	if (($showPage != ($pages - 1)) && ($x == $pages))
					echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
            	if ($x == $noPage)
					echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
            	else
					echo " <a href='".$_SERVER['PHP_SELF']."?page=calendar&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
			if ($noPage < $pages)
				echo "<a href='".$_SERVER['PHP_SELF']."?page=calendar&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
			  }
              ?>

		
		</div>
                                </td>
                                <td width="20%"></td>
                                <td width="20%" align="">
                                    <form role="form" action="?page=calendar" method="post">             
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" required>
                                                <span class="form-group input-group-btn">
                                                    <button class="btn btn-default" type="submit">Cari</button>
                                                    <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                                                    <a href="?page=calendar&add" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                        <table class="table table-hover table-bordered" width="100%">
            		<thead>
  						<tr>
    						<th width="5%" class="text-center">No.</th>
    						<th width="20%" class="text-center">Tanggal</th>
							<th width="55%" class="text-center">Keterangan</th>
							<th width="25%" class="text-center"> Aksi </th>
  						</tr>
  					</thead>
  					<tbody>
  					<?php 	$no=$start+1;
							$sql=mysql_query("SELECT * FROM kalender_unpi ORDER BY tgl DESC LIMIT $start,$per_page");
							$jml=mysql_num_rows($sql);
							if($jml >=1){
							while($data=mysql_fetch_array($sql)){
					?>
						<tr>
    						<td class="text-center"><?php echo $no++;?></td>
    						<td class="text-center"><?php echo tgl_sql($data[1]);?></td>
							<td><?php echo $data[2];?></td>
							<td><div class="form-group"><a class="btn btn-primary" href="?page=calendar&update=edit&tgl=<?php echo $data['kd_libur'];?>">
    							<i class="fa fa-pencil"></i> Update</a>
                  <a href="?page=calendar&del-id=<?php echo $data['kd_libur'];?>" 
                    onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" class="btn btn-danger"><i class="fa fa-trash-o"></i> hapus</a></div></td>
  						</tr>
  					<?php 				}
  							}else{echo"<tr class=alert-danger><td colspan=6 class=\"text-center\">Tidak ada record</td></tr>";} ?>
					</tbody>
				</table>
	
	 <div align="left">
            <?php  
            $jml = mysql_query("SELECT * FROM `kalender_unpi`");
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
		echo  "<a href='".$_SERVER['PHP_SELF']."?page=calendar&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
			for($x=1; $x<=$pages; $x++){
			$showPage = $x;
				if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
            	//if (($showPage == 2) && ($x != 1))  echo "...";
            	if (($showPage != ($pages - 1)) && ($x == $pages))
					echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
            	if ($x == $noPage)
					echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
            	else
					echo " <a href='".$_SERVER['PHP_SELF']."?page=calendar&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
			if ($noPage < $pages)
				echo "<a href='".$_SERVER['PHP_SELF']."?page=calendar&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
			  }
              ?>

		
		</div>
	</div>
</div>
</div>
</div>
</div>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php 
}

function t_libur_search(){ 
if(isset($_POST['search'])){$search	= $_POST['search'];}
	elseif(isset($_GET['search'])){$search = $_GET['search'];}
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Daftar Hari Libur</h4></td>
                <!--<td width="10%"><div align="right">
                    <div class="btn-group">					
                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>                    
                        <ul class="dropdown-menu">
                            <li><a href="#">Tanggal Ascending</a></li>
                            <li><a href="#">Tanggal Descending</a></li>
                        </ul>
                </div>
            </div></td>-->
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;      
      $page_query = mysql_query("SELECT COUNT(*) FROM `kalender_unpi` WHERE keterangan LIKE '%$search%'");
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
		echo  "<a href='".$_SERVER['PHP_SELF']."?page=calendar&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
			for($x=1; $x<=$pages; $x++){
			$showPage = $x;
				if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
            	
            	if (($showPage != ($pages - 1)) && ($x == $pages))
					echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
            	if ($x == $noPage)
					echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
            	else
					echo " <a href='".$_SERVER['PHP_SELF']."?page=calendar&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
			if ($noPage < $pages)
				echo "<a href='".$_SERVER['PHP_SELF']."?page=calendar&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
			  }
              ?>

		
		</div>
                                </td>
                                <td width="20%"></td>
                                <td width="20%" align="">
                                    <form role="form" action="?page=calendar" method="post">             
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" required>
                                                <span class="form-group input-group-btn">
                                                    <button class="btn btn-default" type="submit">Cari</button>
                                                    <?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                                                    <a href="?page=calendar&add" class="btn btn-primary" type="button"><i class="fa fa-plus"></i></a>
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
                        <table class="table table-hover table-bordered" width="100%">
            		<thead>
  						<tr>
    						<th width="5%" class="text-center">No.</th>
    						<th width="20%" class="text-center">Tanggal</th>
							<th width="55%" class="text-center">Keterangan</th>
							<th width="25%" class="text-center"> Aksi </th>
  						</tr>
  					</thead>
  					<tbody>
  					<?php 	$no=$start+1;
							$sql=mysql_query("SELECT * FROM kalender_unpi WHERE keterangan LIKE '%$search%'
								ORDER BY tgl DESC LIMIT $start,$per_page");
							$jml=mysql_num_rows($sql);
							if($jml >=1){
							while($data=mysql_fetch_array($sql)){
					?>
						<tr>
    						<td class="text-center"><?php echo $no++;?></td>
    						<td class="text-center"><?php echo tgl_sql($data[1]);?></td>
							<td><?php echo $data[2];?></td>
							<td><div class="form-group"><a class="btn btn-primary" href="?page=calendar&update=edit&tgl=<?php echo $data['kd_libur'];?>">
    							<i class="fa fa-pencil"></i> Update</a>
                  <a href="?page=calendar&del-id=<?php echo $data['kd_libur'];?>" 
                    onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" class="btn btn-danger"><i class="fa fa-trash-o"></i> hapus</a></div></td>

  						</tr>
  					<?php 				}
  							}else{echo"<tr class=alert-danger><td colspan=6 class=\"text-center\">Tidak ada record</td></tr>";} ?>
					</tbody>
				</table>
	
	 <div align="left">
            <?php  
            $jml = mysql_query("SELECT * FROM `kalender_unpi` WHERE keterangan LIKE '%$search%'");
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
		echo  "<a href='".$_SERVER['PHP_SELF']."?page=calendar&pages=".($noPage-1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
			for($x=1; $x<=$pages; $x++){
			$showPage = $x;
				if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
            	//if (($showPage == 2) && ($x != 1))  echo "...";
            	if (($showPage != ($pages - 1)) && ($x == $pages))
					echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
            	if ($x == $noPage)
					echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
            	else
					echo " <a href='".$_SERVER['PHP_SELF']."?page=calendar&pages=".$x."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
			if ($noPage < $pages)
				echo "<a href='".$_SERVER['PHP_SELF']."?page=calendar&pages=".($noPage+1)."&search=".$search."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
			  }
              ?>

		
		</div>
	</div>
</div>
</div>
</div>
</div>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php }

function form_libur(){
?>
<div class="panel panel-info">
    <div class="panel-heading">
        FORM INPUT KALENDER
    </div>        
<div class="panel-body">
    <form role="form" action="" method="post" enctype="multipart/form-data">
        <table width="100%">
    		<tr>
      			<td>Tanggal Libur </td>
      			<td><div class="form-group">
        			<input type="text" name="tgl1" id="tanggal"/> S/D 
        			<input type="text" name="tgl2" id="tanggal1"/>
      				</div></td>
    		</tr>
    		<tr>
      			<td>Keterangan</td>
      			<td><div class="form-group">
        			<textarea name="ket_libur" class="form-control" placeholder="Keterangan Libur" cols="21" rows="3" id="ket_libur"></textarea>
     				 </div></td>
    		</tr>
    		<tr>
      			<td></td>
      			<td><button type="submit" class="btn btn-primary" id="save" name="save">Simpan</button>
      			<a href="?page=calendar" type="submit" class="btn btn-danger">Batal</a></td>
    		</tr>
 		</table>
	</form>
</div>
</div>
<?php	
}

function edit_libur(){
$kd_libur=$_GET['tgl'];
$query	= mysql_query("SELECT * FROM kalender_unpi WHERE kd_libur='$kd_libur'") or die (mysql_error());
$data	= mysql_fetch_array($query);
?>

<div class="panel panel-info">
    <div class="panel-heading">
        FORM EDIT KALENDER
    </div>        
<div class="panel-body">
    <form role="form" action="" method="post" enctype="multipart/form-data">
         <table width="100%">
    		<tr>
      			<td>Tanggal Libur </td>
      			<td><div class="form-group">
        				<input type="text" name="tgl" id="tanggal" value="<?php echo tgl_sql($data[1]);?>"/>
      				</div></td>
    		</tr>
    		<tr>
        		<td>Keterangan</td>
      			<td><div class="form-group">
        			<textarea name="ket_libur" class="form-control" placeholder="Keterangan Libur" cols="21" rows="3" id="ket_libur" required><?php echo $data[2];?></textarea>
      				</div></td>
    		</tr>
    		<tr>
      			<td></td>
      			<td><div class="form-group"><button type="submit" class="btn btn-primary" id="save" name="edit">Simpan</button> 
      				<a href="?page=calendar" class="btn btn-danger" >Batal</a></div></td>
    		</tr>
  		</table>
	</form>
</div>
</div>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php 
}

function input_libur(){
if(empty($_POST['tgl1'])){
	echo "<div class=\"alert alert-danger\">
		  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> Data Gagal Disimpan. Isikan Tanggal Libur! </div>";}
elseif(empty($_POST['ket_libur'])){
	echo "<div class=\"alert alert-danger\">
		  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> Data Gagal Disimpan. Isikan Keterangan Libur! </div>";}
else{
$tgl_awal = $_POST['tgl1'];
$tgl_akhir = $_POST['tgl2'];
$ket = $_POST['ket_libur'];

$no = 1;


$startTime = strtotime($tgl_awal); 
$endTime = strtotime($tgl_akhir); 
$values = array(); 
for($time = $startTime; $time <= $endTime; $time = strtotime('+1 day', $time)) 
{ 
   $thisDate = date('Y-m-d', $time); 
   $values[] = "('$thisDate', '$ket')"; 
} 

// build the actual query: 
$query = sprintf( 
   "INSERT INTO kalender_unpi (tgl, keterangan) VALUES\n%s", 
   implode(",\n", $values) 
); 
mysql_query($query) or die('Error, query failed : Isikan Format Tanggal dengan benar. <a href=?page=calendar&add>Refresh Halaman.</a>');

if($query){
	?>
 <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Data berhasil di input <a href="?page=calendar">Kembali</a>
                </div>
	<?php
}  

}
}

function update_libur(){
  if(!empty($_POST['tgl'])){
    $tgl = tgl_sql($_POST['tgl']);
    $q   = mysql_query("UPDATE kalender_unpi SET
				    tgl='$tgl',
				    keterangan='$_POST[ket_libur]'
				    WHERE kd_libur = '$_GET[tgl]'") or die(mysql_error());

            if($q){ ?>
              <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                  Data berhasil di update <a href="?page=calendar">Kembali</a>
              </div><?php
	         }

  }else{ ?>
   <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Isikan field tanggal.</div><?php 
  }
}

function hapus_libur(){
$del = $_GET['del-id'];
$sql=mysql_query("DELETE FROM kalender_unpi WHERE kd_libur='$del'");
if($sql){
echo'<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di hapus. <a href="?page=calendar" class="alert-link"> Kembali.</a>
                </div>';
}
}
?>
