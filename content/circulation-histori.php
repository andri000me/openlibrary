<div class="col-md-12">
<?php
if(isset($_GET['id'])){
    history_pinjam();
}
elseif(isset($_GET['id_cart'])) {
    kembali_buku();
}
elseif(isset($_GET['memberid'])){
    history_pinjam_by_memberid();
    if (isset($_GET['id_pinjam'])) {
        kembali_buku_byID();
    }
}

?>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php 
function history_pinjam(){
    $id = $_GET['id'];
    $query_pinjam = mysql_query("SELECT * FROM peminjaman WHERE kd_pinjam = '$id'");
    $data_pinjam = mysql_fetch_array($query_pinjam);
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Daftar Buku Peminjaman (Kode pinjam: <?php echo $id;?> )</h4></td>                
            </tr>
        </table>           
    </div>
</div>

<div class="row">
    <div class="col-md-12">    
        <!--    Context Classes  -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <table width="100%">
                       <tbody>
                            <tr>
                                <td width="30%">Daftar Buku</td>
                                <td width="30%"></td>
                                <td width="20%"></td>
                                <td width="20%" align=""></td>                                
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
                                	<th>Judul</th>
                                	<th>Tanggal Pinjam</th>
                                    <th>Tanggal Harus Kembali</th>
                                    <th>Denda</th>
                                	<th>Aksi</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	$no 	= 1;
                                
								$sql 	= mysql_query("SELECT * FROM detail_pinjam WHERE kd_pinjam = '$id'");
								$jml 	= mysql_num_rows($sql);
								if($jml >=1){
								while($data=mysql_fetch_array($sql)){
                                    $i      = $data['kd_buku'];
									?>
                                	<tr class = "warning">                                	
                                    <td><?php echo $no++; ?></td>
                                    <td><?php $query_buku = mysql_query("SELECT judul,kd_sirkulasi FROM buku WHERE kd_buku = '$data[kd_buku]'");
                                              $data_buku = mysql_fetch_array($query_buku);
                                              echo $data_buku['judul'];?></td>
                                    <td><?php echo tgl_sql($data_pinjam['tgl_pinjam']); ?></td>
                                    <td><?php echo tgl_sql($data['tgl_hrs_kem']); ?></td>
                                    <td><form method="post" action="?page=circulation-histori&id=<?php echo $id; ?>" name="form1">
                                        <?php $querys = mysql_query("SELECT * FROM sirkulasi WHERE kd_sirkulasi = '$data_buku[kd_sirkulasi]'");
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
                                                                $denda = $daydiff * $datas['denda'];
                                                            }
                                                    }
                                        ?><input type="text" name="denda[<?php echo $i; ?>]" value="<?php echo $denda; ?>" size="3" readonly />
                                        <!--<button name="ok" class="btn-primary" type="submit">
                                        <i class="fa fa-refresh"></i></button>-->
    
                                        <?php }else echo number_format($data['denda']);
                                     ?></form></td>                                    
                                    <td><?php 
                                        if($data['status']=='dipinjam'){?>
                                            <a class="btn btn-success" href="?page=circulation-histori&id_cart=<?php echo $data['kd_pinjam']?>&kdb=<?php echo $data['kd_buku']?>&denda=<?php if(isset($_POST['ok'])){echo $_POST['denda'][$i];}else{echo $denda;} ?>">
                                            <i class="glyphicon glyphicon-download-alt icon-white"></i>
                                            Kembalikan</a><?php 
                                        } else { ?>
                                            <span class="label label-success">Dikembalikan.</span><?php 
                                        }?></td>
                                    <td class="text-center"><?php
                                            if(!empty($data['ket'])){ 
                                                echo $data['ket'].'<a href="" class="open-AddBookDialog" data-toggle="modal" data-target="#addKet"
                                                data-kode   ="'.$data['kd_pinjam'].'"
                                                data-kdbk   ="'.$data['kd_buku'].'"
                                                data-judul  ="'.$data_buku['judul'].'"
                                                data-ket    ="'.$data['ket'].'">
                                                <i class="glyphicon glyphicon-pencil icon-white"></i></a>'; }
                                            else{?>
                                                <button class="open-AddBookDialog btn btn-primary btn-sm" data-toggle="modal" data-target="#addKet"
                                                data-kode   ="<?php echo $data['kd_pinjam']; ?>"
                                                data-kdbk   ="<?php echo $data['kd_buku']; ?>"
                                                data-judul  ="<?php echo $data_buku['judul']; ?>"
                                                data-ket    ="<?php echo $data['ket']; ?>">
                                                <i class="glyphicon glyphicon-plus icon-white"></i></button><?php } ?>
                                    </td>
                                </tr>
                                <?php }                                
                        }else echo "<tr class=danger><td colspan=8 align=center>Tidak Ada Record</td></td>";

                               ?>
                            </tbody>
                        </table>
                    
                </div>
            </div>
        </div>
        <?php 
        if(isset($_POST['update'])){
            $borrowId = $_POST['borrowId'];
            $bookId   = $_POST['bookId'];
            $ket      = $_POST['ket'];

            $q_ket    = mysql_query("UPDATE detail_pinjam SET ket = '$ket' WHERE 
                        kd_pinjam='$borrowId' AND kd_buku='$bookId'")or die (mysql_error());
            if($q_ket){
                echo"<script>window.alert(\"Data keterangan berhasil disimpan.\")</script>";
                echo"<script>window.location=\"?page=circulation-histori&id=".$borrowId."\"</script>";
            }
        }?>
        <a href="?page=sirkulasi"><< SIRKULASI</a>

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
<!---------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php 
} 

function history_pinjam_by_memberid(){
$id = $_GET['memberid'];
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Sirkulasi Peminjaman <?php echo $id;?></h4></td>
                <td><a href="?page=history-sirkulasi-mhs&member-id=<?php echo $id;?>" class="btn btn-info"><i class="fa fa-history"></i> Lihat Histori Pinjam</a></td>                
            </tr>
        </table>           
    </div>
</div>
<div class="alert alert-info alert-dismissable">
    Jika kolom keterangan perlu diisi, pastikan isikan kolom keterangan sebelum Anda menekan tombol "Kembalikan"!
</div>
<div class="row">
    <div class="col-md-12">
        <!--    Context Classes  -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <table width="100%">
                       <tbody>
                            <tr>
                                <td width="30%">Daftar Buku Dipinjam</td>
                                <td width="30%"></td>
                                <td width="20%"></td>
                                <td width="20%" align=""></td>                                
                            </tr>
                        </tbody>
                    </table>

                    
                </div>
                        
                <div class="panel-body">
                
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>                                
                                    <th class="text-center">#</th>
                                    <th class="text-center">Kode Pinjam</th>
                                    <th class="text-center">Kode Petugas</th>
                                    <th class="text-center" class="text-center">Judul</th>
                                    <th class="text-center">Tanggal Pinjam</th>
                                    <th class="text-center">Tanggal Harus Kembali</th>
                                    <th class="text-center">Denda</th>
                                    <th class="text-center">Aksi</th>
                                    <th class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no     = 1;
                                
                                $sql    = mysql_query("SELECT * FROM peminjaman, detail_pinjam WHERE `peminjaman`.kd_member = '$id' AND 
                                            `peminjaman`.kd_pinjam = `detail_pinjam`.kd_pinjam AND `detail_pinjam`.status='dipinjam'");
                                $jml    = mysql_num_rows($sql);
                                if($jml >=1){
                                while($data=mysql_fetch_array($sql)){
                                    $i      = $data['kd_buku'];
                                    ?>
                                    <tr class = "warning">                                  
                                    <td><?php echo $no++; ?></td>
                                    <td><a href="?page=circulation-histori&id=<?php echo $data['kd_pinjam'];?>"> <?php echo $data['kd_pinjam']; ?></a></td>
                                    <td><?php echo $data['kd_petugas']; ?></td>
                                    <td><?php $query_buku = mysql_query("SELECT judul,kd_sirkulasi FROM buku WHERE kd_buku = '$data[kd_buku]'");
                                              $data_buku = mysql_fetch_array($query_buku);
                                              echo $data_buku['judul'];?></td>
                                    <td><?php echo tgl_sql($data['tgl_pinjam']); ?></td>
                                    <td><?php echo tgl_sql($data['tgl_hrs_kem']); ?></td>
                                    <td><form method="post" action="?page=circulation-histori&memberid=<?php echo $id; ?>" name="form1"> 
                                        <?php $querys = mysql_query("SELECT * FROM sirkulasi WHERE kd_sirkulasi = '$data_buku[kd_sirkulasi]'");
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
                                                                $denda = $daydiff * $datas['denda'];
                                                            }
                                                    }
                                        ?><input type="text" name="denda[<?php echo $i; ?>]" value="<?php echo $denda; ?>" size="3" readonly />
                                        <!--<button name="ok" class="btn-primary" type="submit">
                                        <i class="fa fa-refresh"></i></button>-->
    
                                        <?php }else echo number_format($data['denda']);
                                     ?></form></td>                                    
                                    <td class="text-center"><?php
                                        if($data['status']=='dipinjam'){?>
                                            <a class="btn btn-success" href="?page=circulation-histori&memberid=<?php echo $id; ?>&id_pinjam=<?php echo $data['kd_pinjam']?>&kdb=<?php echo $data['kd_buku']?>&denda=<?php if(isset($_POST['ok'])){echo $_POST['denda'][$i];}else{echo $denda;} ?>">
                                            <i class="glyphicon glyphicon-download-alt icon-white"></i>
                                            Kembalikan</a><?php 
                                        }else{ ?>
                                            <span class="label label-success">Done</span><?php 
                                        }?>
                                    </td>
                                    <td class="text-center"><?php
                                            if(!empty($data['ket'])){ 
                                                echo $data['ket'].'<a href="" class="open-AddBookDialog" data-toggle="modal" data-target="#addKet"
                                                data-kode   ="'.$data['kd_pinjam'].'"
                                                data-kdbk   ="'.$data['kd_buku'].'"
                                                data-judul  ="'.$data_buku['judul'].'"
                                                data-ket    ="'.$data['ket'].'">
                                                <i class="glyphicon glyphicon-pencil icon-white"></i></a>'; }
                                            else{?>
                                                <button class="open-AddBookDialog btn btn-primary btn-sm" data-toggle="modal" data-target="#addKet"
                                                data-kode   ="<?php echo $data['kd_pinjam']; ?>"
                                                data-kdbk   ="<?php echo $data['kd_buku']; ?>"
                                                data-judul  ="<?php echo $data_buku['judul']; ?>"
                                                data-ket    ="<?php echo $data['ket']; ?>">
                                                <i class="glyphicon glyphicon-plus icon-white"></i></button><?php } ?>
                                    </td>
                                </tr>
                                <?php }                                
                        }else echo "<tr class=danger><td colspan=8 align=center>Tidak Ada Record</td></td>";

                               ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php 
        if(isset($_POST['update'])){
            $borrowId = $_POST['borrowId'];
            $bookId   = $_POST['bookId'];
            $ket      = $_POST['ket'];

            $q_ket    = mysql_query("UPDATE detail_pinjam SET ket = '$ket' WHERE 
                        kd_pinjam='$borrowId' AND kd_buku='$bookId'")or die (mysql_error());
            if($q_ket){
                echo"<script>window.alert(\"Data keterangan berhasil disimpan.\")</script>";
                echo"<script>window.location=\"?page=circulation-histori&memberid=".$id."&id-pinjam=".$borrowId."\"</script>";
            }
        }?>
            <a href="?page=sirkulasi-member"><< SIRKULASI</a>

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
</div><?php 
}

function kembali_buku(){
if(isset($_GET['id_cart'])){
    $id_pinjam  = $_GET['id_cart'];
    $kdb        = $_GET['kdb'];
    $denda      = $_GET['denda'];
    $tgl        = date("Y-m-d");
    $query1     = mysql_query("UPDATE detail_pinjam SET tgl_kem = '$tgl', denda = '$denda', status = 'dikembalikan' WHERE 
                kd_pinjam='$id_pinjam' && kd_buku='$kdb'")or die (mysql_error());
    
    if($query1){
        echo"<script>window.alert(\"Buku Berhasil Dikembalikan\")</script>";
        echo"<script>window.location=\"?page=circulation-histori&id=".$id_pinjam."\"</script>"; 
        }
    }
}

function kembali_buku_byID(){
if(isset($_GET['memberid'])){
    $memberid   = $_GET['memberid'];
    if(isset($_GET['id_pinjam'])){
        $id_pinjam  = $_GET['id_pinjam'];
        $kdb        = $_GET['kdb'];
        $denda      = $_GET['denda'];
        $tgl        = date("Y-m-d");
        $query1     = mysql_query("UPDATE detail_pinjam SET tgl_kem = '$tgl', denda = '$denda', status = 'dikembalikan' WHERE 
                    kd_pinjam='$id_pinjam' && kd_buku='$kdb'")or die (mysql_error());
    
        if($query1){
            echo"<script>window.alert(\"Buku Berhasil Dikembalikan\")</script>";
            echo"<script>window.location=\"?page=circulation-histori&memberid=".$memberid."\"</script>"; 
        }
    }
}
}
?>