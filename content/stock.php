<div class="md-col-12">
<?php
book_stock();
?>
</div>

<?php
function book_stock(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">STOK</h4></td>
                
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
                    <td width="30%">Daftar Buku Tersedia</td>
                    <td width="30%"></td>
                    <td width="20%"></td>
                    <td width="20%" align=""></td>                                
                </tr>
            </tbody>
        </table>
    </div>
    <div class="panel-body">
    <div class="table-responsive">
        <form name="form1" method="post" action="">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>                                
                    <th><div align="center">#</div></th>
                    <th><div align="center">Kode Buku</th>
                    <th><div align="center"><div align="center">Judul Buku</div></th>
                    <th><div align="center">Pengarang</div></th>
                    <th><div align="center"><div align="center">Penerbit</div></th>
                    <th><div align="center">Penerimaan</div></th>
                    <th><div align="center">Harga</div></th>
                    <th><div align="center">Status</div></th>
                    <th><div align="center">Aksi</div></th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no 	= 1;
            $limit  = 0;	
                            	
            if(isset($_GET['available-stock'])){
                $avstock 	= str_replace("%20"," ", $_GET['available-stock']);
				$sql 	= mysql_query("SELECT * FROM buku WHERE judul = '$avstock' and status = 'Tersedia' ORDER BY `buku`.kd_buku ASC");
                $jml    = mysql_num_rows($sql);
                    if($jml > 0){
                        while($data=mysql_fetch_array($sql)){                               
                            $sql2 = mysql_query("SELECT * FROM detail_pinjam WHERE kd_buku = '$data[kd_buku]' and status='dipinjam'");
                            $data2 = mysql_num_rows($sql2);
                                if($data2 == 0){         
                                    ?>
                                    <tr>
                                    <td width="3%"><div align="center"><?php echo $no++; ?></div></td>
                                    <td width="10%"><div align="center"><?php echo $data['kd_buku']; ?></div></td>
                                    <td width="20%"><a href="?page=detail-catalogue&id=<?php echo $data['kd_buku'];?>"><?php echo $data['judul']; ?></a></td>
                                    <td width="10%"><div align="center"><?php echo $data['kd_pengarang']; ?></div></td>
                                    <td width="10%"><div align="center"><?php echo $data['kd_penerbit']; ?></div></td>
                                    <td width="10%"><div align="center"><?php echo $data['penerimaan']; ?></div></td>
                                    <td width="10%"><div align="right"><?php echo number_format($data['harga']); ?></div></td>
                                    <td width="10%"><div align="right"><span class="label label-success"><?php echo $data['status']; ?></span></div></td>
                                    <td width="20%"><?php 
                                        if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                                            <!--<a href="?page=book-collection&update-buku=<?php //echo $data['kd_buku']; ?>" class="btn btn-primary" type="button">
                                            <i class="fa fa-pencil"></i> Ubah</a>-->
                                            <a href="?page=plus-ebook&id=<?php echo $data['kd_buku']; ?>" class="btn btn-primary" type="button">
                                            <i class="fa fa-plus"></i> Ebook</a>
                                            <?php 
                                            if(isset($_SESSION['members'])){ 
                                                if(isset($_SESSION['cart']) && count($_SESSION['cart']) == 2 ) { ?>
                                                    <a href="?page=cart-update&act=add&kdb=<?php echo $data['kd_buku']; ?>&ref=sirkulasi" 
                                                        class="btn btn-primary" type="button">
                                                    <i class="fa fa-pencil"></i> Pinjam</a><?php 
                                                } else { ?>
                                                <a href="?page=cart-update&act=add&kdb=<?php echo $data['kd_buku']; ?>&ref=book-collection" 
                                                    class="btn btn-primary" type="button">
                                                <i class="fa fa-pencil"></i> Pinjam</a><?php 
                                                }
                                            }
                                        } ?>
                                    </td>
                                    </tr><?php
                                    
                                }elseif($data2!=0){echo " ";}
                                else{?>
                                    <tr>
                                    <td width="3%"><div align="center"><?php echo $no++; ?></div></td>
                                    <td width="10%"><div align="center"><?php echo $data['kd_buku']; ?></div></td>
                                    <td width="20%"><a href="?page=detail-catalogue&id=<?php echo $data['kd_buku'];?>"><?php echo $data['judul']; ?></a></td>
                                    <td width="10%"><div align="center"><?php echo $data['kd_pengarang']; ?></div></td>
                                    <td width="10%"><div align="center"><?php echo $data['kd_penerbit']; ?></div></td>
                                    <td width="10%"><div align="center"><?php echo $data['penerimaan']; ?></div></td>
                                    <td width="10%"><div align="right"><?php echo number_format($data['harga']); ?></div></td>
                                    <td width="10%"><div align="right"><span class="label label-success"><?php echo $data['status']; ?></span></div></td>
                                    <td width="20%"><?php 
                                        if(isset($_SESSION['user']) AND (($_SESSION['level'])=='pustakawan' OR ($_SESSION['level'])=='admin')) {?>
                                            <!--<a href="?page=book-collection&update-buku=<?php //echo $data['kd_buku']; ?>" class="btn btn-primary" type="button">
                                            <i class="fa fa-pencil"></i> Ubah</a>-->
                                            <a href="?page=plus-ebook&id=<?php echo $data['kd_buku']; ?>" class="btn btn-primary" type="button">
                                            <i class="fa fa-plus"></i> Ebook</a>
                                            <?php 
                                            if(isset($_SESSION['members'])){ 
                                                if(isset($_SESSION['cart']) && count($_SESSION['cart']) == 2 ) { ?>
                                                    <a href="?page=cart-update&act=add&kdb=<?php echo $data['kd_buku']; ?>&ref=sirkulasi" 
                                                        class="btn btn-primary" type="button">
                                                    <i class="fa fa-pencil"></i> Pinjam</a><?php 
                                                } else { ?>
                                                <a href="?page=cart-update&act=add&kdb=<?php echo $data['kd_buku']; ?>&ref=book-collection" 
                                                    class="btn btn-primary" type="button">
                                                <i class="fa fa-pencil"></i> Pinjam</a><?php 
                                                }
                                            }
                                        } ?>
                                    </td>
                                    </tr><?php
                                }
                        }
                    }else{echo "<tr class=danger><td colspan=9 align=center>Tidak Ada Record.</td></td>";}

			}elseif(isset($_GET['all-stock'])){
				$alstock = str_replace("%20", " ", $_GET['all-stock']);
                $sql 	= mysql_query("SELECT * FROM buku WHERE judul = '$alstock' ORDER BY kd_buku ASC");
                $jml 	= mysql_num_rows($sql);
				
                    if($jml >=1){
					   while($data=mysql_fetch_array($sql)){ ?>
                                <tr>
                                    <td width="3%"><div align="center"><?php echo $no++; ?></div></td>
                                    <td width="10%"><div align="center"><?php echo $data['kd_buku']; ?></div></td>
                                    <td width="20%"><a href="?page=detail-catalogue&id=<?php echo $data['kd_buku'];?>"><?php echo $data['judul']; ?></a></td>
                                    <td width="10%"><div align="center"><?php echo $data['kd_pengarang']; ?></div></td>
                                    <td width="10%"><div align="center"><?php echo $data['kd_penerbit']; ?></div></td>
                                    <td width="10%"><div align="center"><?php echo $data['penerimaan']; ?></div></td>
                                    <td width="10%"><div align="right"><?php echo number_format($data['harga']); ?></div></td>
                                    <td width="10%"><?php if($data['status']=='Tersedia'){
                                                    $qs = mysql_query("SELECT kd_pinjam, status FROM detail_pinjam WHERE kd_buku = '$data[kd_buku]' and status = 'dipinjam'");
                                                    $ds = mysql_fetch_array($qs);
                                                    $stat = $ds ['status'];                                                       
                                                    $kdp = $ds['kd_pinjam'];
                                                    if($stat =='dipinjam'){
                                                        $qm = mysql_query("SELECT kd_member FROM peminjaman WHERE kd_pinjam = '$kdp'");
                                                        $dm  = mysql_fetch_array($qm);
                                                        $kd_mem  = $dm['kd_member'];                                                        
                                                        if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')){?>
                                                            <a  href="?page=circulation-histori&id=<?php echo $kdp;?>">
                                                            <i class=""> </i>
                                                            <?php echo "Dipinjam ".$kd_mem;?></a><?php
                                                        }elseif(isset($_SESSION['user']) and (($_SESSION['level'])=='member')) {                                                         
                                                            echo "<span class=\"label label-warning\">Dipinjam ".$kd_mem."</span>";
                                                        }
                                                    } else {echo "<span class=\"label label-success\">".$data['status']."</span>";}
                                                }else{echo "<span class=\"label label-danger\">".$data['status']."</span>";}?></td>
                                    <td width="20%"><?php 
                                        if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                                    	<!--<a href="?page=book-collection&update-buku=<?php //echo $data['kd_buku']; ?>" class="btn btn-primary" type="button">
                                    	<i class="fa fa-pencil"></i> Ubah</a>-->
                                    	<a href="?page=plus-ebook&id=<?php echo $data['kd_buku']; ?>" class="btn btn-primary" type="button">
                                    	<i class="fa fa-plus"></i> Ebook</a>
                                    	<?php 
                                    	   if(isset($_SESSION['members'])){ 
                                    	       if(isset($_SESSION['cart']) && count($_SESSION['cart']) == 2 ) { ?>
                                    		      <a href="?page=cart-update&act=add&kdb=<?php echo $data['kd_buku']; ?>&ref=sirkulasi" class="btn btn-primary" type="button">
                                    		      <i class="fa fa-pencil"></i> Pinjam</a><?php
                                    	       } else { ?>
                                    		  <a href="?page=cart-update&act=add&kdb=<?php echo $data['kd_buku']; ?>&ref=book-collection" class="btn btn-primary" type="button">
                                    		  <i class="fa fa-pencil"></i> Pinjam</a><?php
                                    	       } 
                                            }
                                        } ?>
                                    </td>
                                </tr>
                                <?php
                        }
                    }else echo "<tr class=danger><td colspan=9 align=center>Tidak Ada Record</td></td>";
                } ?>
                            </tbody>
                        </table>
                    </form>
                    </div>
                    <a href="?page=catalogue"> <i class="fa fa-reorder"></i> Kembali </a>
                </div>
            </div>
    </div>
</div>
<?php
}
?>