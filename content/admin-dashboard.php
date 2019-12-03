<?php if(isset($_SESSION['user']) AND (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
<div class="row pad-botm">
    <div class="col-md-12">
        <h4 class="header-line">ADMIN DASHBOARD</h4>
    </div>
</div>
            
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-6">
                <a href="?page=book-collection">
                    <div class="alert alert-info back-widget-set text-center">
                            <i class="fa fa-book fa-5x"></i>
                            <?php
                                $query  = mysql_query("SELECT * FROM buku");
                                $data   = mysql_num_rows($query);
                                echo "<h3>".number_format($data)."</h3>"; ?>
                            Jumlah Koleksi Buku
                    </div>
                </a>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                <a href="?page=request">
                    <div class="alert alert-success back-widget-set text-center">
                        <i class="fa fa-file fa-5x"></i>
                        <?php
                                $query  = mysql_query("SELECT * FROM request");
                                $data   = mysql_num_rows($query);
                                echo "<h3>".number_format($data)."</h3>"; ?>
                        Jumlah Request
                        </div>
                </a>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                <a href="?page=members&cat=Mahasiswa">
                    <div class="alert alert-warning back-widget-set text-center">
                        <i class="fa fa-user fa-5x"></i>
                        <?php
                                $query  = mysql_query("SELECT * FROM anggota");
                                $data   = mysql_num_rows($query);
                                echo "<h3>".number_format($data)."</h3>"; ?>
                             Jumlah Anggota
                    </div>
                </a>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                <a href="?page=sirkulasi">
                    <div class="alert alert-danger back-widget-set text-center">
                        <i class="fa fa-briefcase fa-5x"></i>
                        <?php
                                $query  = mysql_query("SELECT * FROM detail_pinjam WHERE status = 'dipinjam'");
                                $data   = mysql_num_rows($query);
                                echo "<h3>".number_format($data)."</h3>"; ?>
                            Jumlah Buku Dipinjam
                    </div>
                    </a>
                </div>
            </div>
            
            <div class="row">

              <div class="col-md-12">
                    <div id="carousel-example" class="carousel slide slide-bdr" data-ride="carousel" >                   
                    <div class="carousel-inner">

                        <div class="item active" align="center">                        
                             <img src="assets/bp/bk0001.jpg" alt="" />                                                      
                        </div>
                        <?php
                            $qb = mysql_query("SELECT * FROM buku ORDER BY date_input desc Limit 2");
                            while ($db = mysql_fetch_array($qb)) {
                                ?>
                        <div class="item" align="center">
                            <img title="<?php echo $db['judul'];?>" src="<?php echo $db['image'];?>" alt="" />                                                 
                        </div>
                        <?php } ?>
                    </div>
                    <!--INDICATORS-->
                     <ol class="carousel-indicators">
                        <li data-target="#carousel-example" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example" data-slide-to="1"></li>
                        <li data-target="#carousel-example" data-slide-to="2"></li>
                    </ol>
                    <!--PREVIUS-NEXT BUTTONS-->
                    <a class="left carousel-control" href="#carousel-example" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example" data-slide="next">
                      <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
              </div>  
            </div>
                 <br>

             <div class="row">

             <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                           Daftar Buku Terlambat
                        </div>
                        <div class="panel-body chat-widget-main text-left recent-users-sec">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                   <thead>
                                <tr>                                
                                    <th>#</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Kode Anggota</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Harus Kembali</th>
                                    <th>Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no     = 1;
                                $sql    = mysql_query("SELECT * FROM `peminjaman`, `detail_pinjam`,`anggota` WHERE 
                                                        `peminjaman`.kd_pinjam = `detail_pinjam`.kd_pinjam AND
                                                        `peminjaman`.kd_member = `anggota`.kd_mem AND 
                                                        (TO_DAYS(now()) - TO_DAYS(`detail_pinjam`.tgl_hrs_kem)) > 0 
                                                        AND `detail_pinjam`.status ='dipinjam' ORDER BY `detail_pinjam`.tgl_pinjam ASC Limit 10");
                                $jml    = mysql_num_rows($sql);
                                if($jml >=1){
                                while($data=mysql_fetch_array($sql)){
                                    $cat = $data['jabatan'];
                                    $query_buku = mysql_query("SELECT judul,kd_sirkulasi,denda FROM buku WHERE kd_buku = '$data[kd_buku]'");
                                    $data_buku = mysql_fetch_array($query_buku);
                                    ?>
                                    <tr class = "warning">
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo tgl_sql($data['tgl_pinjam']); ?></td>
                                    <td><a href="?page=members&cat=<?php echo $cat;?>&view-member=<?php echo $data['kd_member']; ?>"><?php echo $data['kd_member']; ?></a></td>
                                    <td><a href="?page=circulation-histori&id=<?php echo $data['kd_pinjam']; ?>"> <?php echo $data_buku['judul']; ?></a></td>
                                    <td><?php echo tgl_sql($data['tgl_hrs_kem']); ?></td>
                                    <td><?php $querys = mysql_query("SELECT * FROM sirkulasi WHERE kd_sirkulasi = '$data_buku[kd_sirkulasi]'");
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
                                                                $denda = $daydiff * $data_buku['denda'];
                                                            }
                                                    }
                                        ?><input type="text" name="denda[<?php echo $i; ?>]" value="<?php echo $denda; ?>" size="3" readonly />
                                        <!--<button name="ok" class="btn-primary" type="submit">
                                        <i class="fa fa-refresh"></i></button>-->
    
                                        <?php }else echo number_format($data['denda']);
                                     ?></td>
                                </tr>                               
                            <?php
                            }
                            if($jml >= 10){
                                echo '<div align="right"><a href="?page=book-late" > Lihat lebih banyak <i class="glyphicon glyphicon-chevron-right"></i></a></div>';
                            }
                        }else echo "<tr class=danger><td colspan=11 align=center>Tidak Ada Record</td></td>";

                               ?>
                            </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
             </div>
                 
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           Info Buku & Skripsi
                        </div>
                        <div class="panel-body chat-widget-main text-left recent-users-sec">
                        <-------------Info Jumlah Buku Fakultas------------><br>
                        <?php 
                            $qt = mysql_query("SELECT * FROM buku WHERE unit = 'Teknik'");
                            $sum_tech = mysql_num_rows($qt);
                                echo "Teknik Informatika : ".$sum_tech."<br />";
                            $qe = mysql_query("SELECT * FROM buku WHERE unit = 'Ekonomi'");
                            $sum_eco = mysql_num_rows($qe);
                                echo "Ekonomi : ".$sum_eco."<br />";
                            $qs = mysql_query("SELECT * FROM buku WHERE unit = 'Sastra'");
                            $sum_lit = mysql_num_rows($qs);
                                echo "Sastra : ".$sum_lit."<br />";
                            $qf = mysql_query("SELECT * FROM buku WHERE unit = 'Ilmu Komunikasi'");
                            $sum_com = mysql_num_rows($qf);
                                echo "Fikom : ".$sum_com."<br>";
                        ?>
                        <--------------Info Jumlah Skripsi Jurusan----------><br>
                        <?php 
                            $qt = mysql_query("SELECT * FROM skripsi WHERE jurusan = 'Teknik Informatika'");
                            $sum_tech = mysql_num_rows($qt);
                                echo "Teknik Informatika : ".$sum_tech."<br />";
                            $qm = mysql_query("SELECT * FROM skripsi WHERE jurusan = 'Manajemen Informatika'");
                            $sum_mi = mysql_num_rows($qm);
                                echo "Manajemen Informatika : ".$sum_mi."<br />";
                            $qea = mysql_query("SELECT * FROM skripsi WHERE jurusan = 'Akuntansi'");
                            $sum_ecoa = mysql_num_rows($qea);
                                echo "Ekonomi Akuntansi: ".$sum_ecoa."<br />";
                            $qem = mysql_query("SELECT * FROM skripsi WHERE jurusan = 'Manajemen'");
                            $sum_ecom = mysql_num_rows($qem);
                                echo "Ekonomi Manajemen : ".$sum_ecom."<br />";
                            $qs = mysql_query("SELECT * FROM skripsi WHERE jurusan = 'Sastra Inggris'");
                            $sum_lit = mysql_num_rows($qs);
                                echo "Sastra Inggris: ".$sum_lit."<br />";
                            $qf = mysql_query("SELECT * FROM skripsi WHERE jurusan = 'Ilmu Komunikasi'");
                            $sum_com = mysql_num_rows($qf);
                                echo "Fikom : ".$sum_com."<br>";
                        ?>                            
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                           Request Buku Tertunda
                        </div>
                        <div class="panel-body chat-widget-main text-left recent-users-sec">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                   <thead>
                                <tr>                                
                                    <th>#</th>
                                    <th>Kode Pengaju</th>
                                    <th>Judul Buku</th>
                                    <th>Pengarang</th>
                                    <th>Tanggal Request</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no     = 1;
                                $sql    = mysql_query("SELECT * FROM request WHERE realisasi = '0' ORDER BY tgl_req DESC Limit 5");
                                $jml    = mysql_num_rows($sql);
                                if($jml >=1){
                                while($data=mysql_fetch_array($sql)){                                
                                    echo"
                                    <tr class=warning>
                                    <td>".$no++."</td>
                                    <td>".$data['kd_pengaju']."</td>
                                    <td><a href=\"?page=request&view-req=".$data['kd_req']."\" > ".$data['judul']."</a></td>
                                    <td>".$data['pengarang']."</td>
                                    <td>".tgl_sql($data['tgl_req'])."</td>
                                </tr>";                                
                            }
                            if($jml > 5){
                                echo '<div align="right"><a href="?page=request" > Lihat lebih banyak <i class="glyphicon glyphicon-chevron-right"></i></a></div>';
                            }
                        }else echo "<tr class=danger><td colspan=11 align=center>Tidak Ada Record</td></td>";

                               ?>
                            </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
             </div>
        </div>
<?php 
 }
 else { echo"<script>window.location=\"?page=catalogue\"</script>";}
?>