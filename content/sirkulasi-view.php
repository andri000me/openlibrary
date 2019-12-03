<?php
if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {
if(isset($_SESSION['members'])){
if (isset($_SESSION['cart'])){
		
		$kd_pinjam 	= $_POST['kdp'];
		$tgl 		= $_POST['tgl_p'];
				
		$qq 		= mysql_query("INSERT INTO peminjaman VALUES ('$kd_pinjam','$_POST[kd_petugas]','$_POST[kd_member]','','$tgl')") or die (mysql_error());
	foreach($_POST['rows'] as $key => $i){
				
		$idb    = $_POST['idb'][$i];	
		$back   = $_POST['back'][$i];
		$stat   = 'dipinjam';
		$kem    = '';
		
		$query_values = mysql_query("INSERT INTO detail_pinjam VALUES 
						('$kd_pinjam','$idb','$tgl','$back','$kem','','$stat','')")
						or die(mysql_error());

	
		if($query_values){
			unset($_SESSION['cart']);
			unset($_SESSION['members']); 
		}
	}
}
}

$today 	= date("Ymd");
$q 		= mysql_query("SELECT max(kd_pinjam) AS last FROM `peminjaman` WHERE kd_pinjam LIKE '$today%'");
$d  	= mysql_fetch_array($q);
$last 	= $d[0];
$q2 	= mysql_query("SELECT * FROM peminjaman WHERE kd_pinjam = '$last'");
$d2  	= mysql_fetch_array($q2);
$i=1;
?>
<!--    Bordered Table  -->
    <div class="panel panel-success">
        <div class="panel-heading">
            Proses Peminjaman Buku Berhasil
        </div>
        <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                <form method="post" action="report/faktur-pinjam.php" target="_blank" name="form1">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td width="15%">Kode Pinjam</td>
                                <td width="1%">:</td>
                                <td width="25%"><?php echo $d2['kd_pinjam'];?></td>
                                <td width="15%"></td>
                                <td width="20%">Tanggal Pinjam</td>
                                <td width="1%">:</td>
                                <td width="25%"><?php echo tgl_sql($d2['tgl_pinjam']); ?></td>
                            </tr>
                            <tr>
                                <td>Nama Anggota</td>
                                <td>:</td>
                                <td><?php $qm = mysql_query("SELECT nama FROM anggota WHERE kd_mem = '$d2[kd_member]'");
                                          $dm = mysql_fetch_array($qm);
                                         echo $dm['nama'];?></td>
                                <td></td>
                                <td>Nama Petugas</td>
                                <td>:</td>
                                <td><?php $ql = mysql_query("SELECT nama FROM petugas WHERE kd_petugas = '$d2[kd_petugas]'");
                                          $dl = mysql_fetch_array($ql);
                                         echo $dl['nama'];?></td>
                            </tr>                                                                
                        </tbody>
                    </table>
                </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            	<tr>
                                    <th width="5%"><div align="center">#</div></th>
                                    <th width="30%"><div align="center">Judul</div></th>
                                    <th width="25%"><div align="center">Pengarang</div></th>
                                    <th width="15%"><div align="center">Tanggal Harus Kembali</div></th>
                                </tr>
                            </thead>
                            <?php
       						$kds = $d[0];
	   						$dat = mysql_query("SELECT * FROM detail_pinjam WHERE kd_pinjam = '$kds'") or (mysql_error());
	   						while($data = mysql_fetch_array($dat)){
	   						$id_buku=$data['kd_buku'];
							?>
                            <tbody>
                                <tr>
                                    <td align="center"><?php echo $i++; ?></td>
                                    <td><?php 
					 						$bk = mysql_query("SELECT * FROM buku WHERE kd_buku = '$id_buku'") or (mysql_error());
					 						$buku=mysql_fetch_array($bk);
					 						echo $buku['judul']; ?></td>
                                    <td><?php $qs = mysql_query("SELECT nama FROM pengarang WHERE kd_pengarang = '$buku[kd_pengarang]'");
                                              $ds = mysql_fetch_array($qs);
                                              echo $ds['nama']; ?></td>
                                    <td align="center"><?php echo tgl_sql($data['tgl_hrs_kem']);  ?></td>
                                </tr>
                                                                
                            </tbody>
                            <?php
                            }
                            ?>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td align="center"><div class="form-group"><button type="submit" class="btn btn-info" id="tampil_faktur" name="tampil_faktur" >
                                        <i class="fa fa-pencil"></i> Cetak</button>
                                        <a href="?page=sirkulasi" class="btn btn-danger"> Kembali</a></button></div></td>
                                </tr>
                            </tfoot>
                        </table>
                        </form>
                </div>
            </div>
            <!--  End  Bordered Table  -->
            </div>
	<?php }else{echo ' <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Anda tidak memiliki hak untuk melihat halaman ini.
                </div>';} ?>
