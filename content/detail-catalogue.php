<div class="md-col-12">
<?php

    if(isset($_GET['available-stock'])){
        book_stock();
    }else{
    detail_catalogue();
        if(isset($_GET['del-id'])){
            delete_ebook();
        }
    }


?>
</div>

<?php
function detail_catalogue(){
    $id     = $_GET['id'];
    $no     = 1;
    $sql    = mysql_query("SELECT * FROM buku WHERE kd_buku='$id'");
    $data   = mysql_fetch_array($sql);

?>

<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td><h4 class="header-line"><?php echo $data['judul']; ?> 
                    <?php /*if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <a href="?page=book-collection&update-buku=<?php echo $data['kd_buku']; ?>">
                                <i class="fa fa-pencil"></i> Edit</a><?php }*/ ?></h4></td>
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
                        <li class=""><a href="#sirkulasi" data-toggle="tab">Sirkulasi</a></li>
                        <li class=""><a href="#link-download" data-toggle="tab">Download Link</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="home">
                            <p>        
                                <table class="table table-striped">                                   
                                    <tbody>                           
                                        <tr>
                                            <td align="center" rowspan="8" width="15%">
                                                <div class="item active">                                            
                                                    <img src="<?php echo $data['image']; ?>" alt="" />                          
                                                </div>
                                                <?php echo $data['kd_cat']; ?></td>                                                
                                            <td width="10%">Kode</td>
                                            <td>
                                                <?php echo $data['kd_buku']; ?></td>
                                        </tr>                                        
                                        <tr>
                                            <td>Klasifikasi</td>
                                            <td><?php 
                                                    $query = mysql_query("SELECT * FROM klasifikasi_buku WHERE kode = '$data[kd_klasifikasi]' ");
                                                    $datak = mysql_fetch_array($query);
                                                    echo $datak['kd_klasifikasi']." - ".$datak['nama']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Subjek</td>
                                            <td><?php 
                                                    $query2 = mysql_query("SELECT * FROM subjek_buku WHERE kd_subjek = '$data[kd_subjek]' ");
                                                    $datas = mysql_fetch_array($query2);
                                                    echo $datas['subjek_utama']; ?></td>                                            
                                        </tr>
                                        <tr>
                                            <td>Kategori</td>
                                            <td><?php echo $data['unit']; ?></td>                                            
                                        </tr>
                                        <tr>
                                            <td>ISSN_ISBN</td>
                                            <td><?php echo $data['issn_isbn']; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Penerimaan</td>
                                            <td><?php echo $data['penerimaan']; ?></td>
                                        </tr>
                                        <?php if(isset($_SESSION['user'])) {?>
                                        <tr>
                                            <td>Status</td>
                                            <td><?php                                                 
                                                    if($data['status']=='Tersedia'){
                                                    $qs = mysql_query("SELECT kd_pinjam, status FROM detail_pinjam WHERE kd_buku = '$data[kd_buku]' and status = 'dipinjam'");
                                                    $ds = mysql_fetch_array($qs);
                                                    $stat = $ds ['status'];                                                       
                                                    $kdp = $ds['kd_pinjam'];
                                                    if($stat =='dipinjam'){
                                                        $qm = mysql_query("SELECT kd_member FROM peminjaman WHERE kd_pinjam = '$kdp'");
                                                        $dm  = mysql_fetch_array($qm);
                                                        $kd_mem  = $dm['kd_member'];
                                                        if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')){
                                                        ?>
                                                            <a  href="?page=circulation-histori&id=<?php echo $kdp;?>">
                                                            <i class=""> </i>
                                                            <?php echo "Dipinjam ".$kd_mem;?></a><?php
                                                        }elseif(isset($_SESSION['user']) and (($_SESSION['level'])=='member')) {                                                         
                                                            echo "Dipinjam ".$kd_mem;
                                                        }
                                                    } else {echo "<span class=\"label label-success\">tersedia";}
                                                }else{echo $data['status'];}?></td>
                                        </tr>
                                        <tr>
                                        <td></td>
                                        <td align="left"><?php if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                                          <a href="?page=book-collection&update-buku=info&id=<?php echo $data['kd_buku']; ?>" >
                                            <i class="fa fa-pencil"></i> Edit</a><?php } ?></td>
                                    </tr>

                                    <?php } ?>
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
                                        <td align="left"><?php if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                                          <a href="?page=book-collection&update-buku=abstrak&id=<?php echo $data['kd_buku']; ?>" >
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
                                        $sql1 = mysql_query("SELECT * FROM pengarang WHERE kd_pengarang = '$data[kd_pengarang]'");
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
                                        <td align="left"><?php if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                                          <a href="?page=book-collection&update-buku=pengarang&id=<?php echo $data['kd_buku']; ?>" >
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
                                        <td align="left"><?php if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                                          <a href="?page=book-collection&update-buku=penerbit&id=<?php echo $data['kd_buku']; ?>" >
                                            <i class="fa fa-pencil"></i> Edit</a><?php } ?></td>
                                    </tr>
                                </tbody>
                            </table>                 
                            </div>
                            <div class="tab-pane fade" id="sirkulasi">
                            <p>
                            <table class="table">
                                <tbody>
                                    <tr>
                                    <?php 
                                        $sql3 = mysql_query("SELECT * FROM sirkulasi WHERE kd_sirkulasi = '$data[kd_sirkulasi]'");
                                        $data3 = mysql_fetch_array($sql3);
                                    ?>
                                        <td width="15%">Harga Sewa</td>
                                        <td width="5%">:</td>
                                        <td><?php echo "Rp. ".number_format($data3['harga_sewa']);?></td>
                                    </tr>
                                    <tr>
                                        <td>Denda (perhari)</td>
                                        <td>:</td>
                                        <td><?php echo "Rp. ".number_format($data['denda']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis</td>
                                        <td>:</td>
                                        <td><?php echo $data3['jenis']; ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td align="left"><?php if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                                          <a href="?page=book-collection&update-buku=sirkulasi&id=<?php echo $data['kd_buku']; ?>" >
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
                                $kd     = $data['kd_buku'];
                                $i      = 1;
                                $sql4   = mysql_query("SELECT * FROM ebook WHERE kd_buku ='$kd' ");
                                $sum = mysql_num_rows($sql4);
                                if($sum > 0){
                                while($d4 = mysql_fetch_array($sql4)){                            
                                            
                                            $result = mysql_query("SELECT * FROM download_ebook WHERE kd_ebook='$d4[kd_ebook]'");

                                            if(mysql_num_rows($result)){
                                                $row=mysql_fetch_assoc($result);

                                                /*  The key of the $file_downloads array will be the name of the file,
                                                    and will contain the number of downloads: */
        
                                                $file_downloads=$row['hits'];
                                            }else{
                                                $file_downloads=0;}
                                                                          
                                ?>            
                                    <ul class="manager">
                                    <?php if((($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                                    <a href="?page=detail-catalogue&id=<?php echo $kd; ?>&del-id=<?php echo $d4['kd_ebook'];?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><i class="fa fa-trash-o"></i> hapus</a><?php } ?>
                                        <li><a href="?page=download&id=<?php echo $d4['kd_ebook'];?>&file=<?php echo $d4['lokasi'] ?>" target="_blank" >
                                            <?php echo $d4['judul']; ?>
                                                <span class="download-count" title="Times Downloaded">
                                            <?php echo (int)$file_downloads; ?> times downloaded</span> 
                                                <span class="download-label">download</span>
                                            </a>
                                        </li>
                                    </ul>
                                               
                            <?php
                                }                            
                            }
                            else{
                                echo"Belum ada link download.";
                            }
                            ?>
                             </div>
                            <?php
                                if((($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <div align="center"><a href="?page=plus-ebook&id=<?php echo $data['kd_buku']; ?>" class="btn btn-primary" type="button">                            
                            <i class="fa fa-plus"></i> Ebook</a></div>
                            <?php }

                            }else{echo"Anda harus login untuk dapat mendownload.";}
                            ?>         
                            </div>
                        </div>

                     </div>
                </div>
                <a href="?page=catalogue"> <i class="fa fa-reorder"></i> Kembali </a>
        </div>
    </div>
</div>
<?php
}

function delete_ebook(){
$code = $_GET['id'];
$del = $_GET['del-id'];
$sql=mysql_query("DELETE FROM ebook WHERE kd_ebook='$del'");
if($sql){
echo'<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Data berhasil di hapus <a href="?page=catalogue" class="alert-link">Kembali</a>
                </div>';
//echo"<script>>document.location.href=\"?page=detail-catalogue&id=\'".$code."'</script>"; }
}
}
?>

                
          