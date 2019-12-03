<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Daftar Ebook</h4></td>
                <td width="10%"><div align="right">
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
            </div></td>
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
                                <td width="30%"></td>
                                <td width="30%"></td>
                                <td width="20%"></td>
                                <td width="20%" align="">
                                    <form role="form">             
                                        <div class="input-group">
                                            <input type="text" class="form-control">
                                                <span class="form-group input-group-btn">
                                                    <button class="btn btn-default" type="button">Cari</button>
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
                                    <th>Judul</th>
                                    <th>Pengarang</th>
                                    <th>Penerbit</th>
                                    <th>Kategori</th>
                                    <th>File Size</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                $sql = mysql_query("SELECT * FROM upload_ebook ORDER BY kd_ebook DESC");
                if(mysql_num_rows($sql) > 0){
                    $no = 1;
                    while($data = mysql_fetch_assoc($sql)){
                        echo '
                        <tr class="info">
                            <td>'.$no.'</td>
                            <td>'.$data['kd_ebook'].'</td>
                            <td><a href="'.$data['lokasi'].'">'.$data['judul'].'</a></td>
                            <td>'.$data['pengarang'].'</td>
                            <td>'.$data['penerbit'].'</td>
                            <td>'.$data['klarifikasi'].'</td>
                            <td>'.formatBytes($data['size']).'</td>
                        </tr>
                        ';
                        $no++;
                    }
                }else{
                    echo '
                    <tr class="danger">
                        <td colspan="7" align="center">Tidak ada data!</td>
                    </tr>
                    ';
                }
                ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</div>