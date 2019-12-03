<div class="row pad-botm">
    <div class="col-md-12">
        <h4 class="header-line">UPLOAD EBOOK</h4>
    </div>
</div>
<div class="alert alert-warning">
    Upload file Anda dengan melengkapi form di bawah ini. File yang bisa di Upload hanya file dengan ekstensi <b>.doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .rar, .zip</b> dan besar file (file size) maksimal hanya 1 MB.
 </div>
            <?php
            if(isset($_POST['upload'])){
                $allowed_ext    = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'rar', 'zip');
                $file_name      = $_FILES['file']['name'];
                $file_ext       = strtolower(end(explode('.', $file_name)));
                $file_size      = $_FILES['file']['size'];
                $file_tmp       = $_FILES['file']['tmp_name'];
 
                $kd             = $_POST['kd'];
                $judul          = $_POST['judul'];
                $pengarang      = $_POST['pengarang'];
                $penerbit       = $_POST['penerbit'];
                $th             = $_POST['th_terbit'];
                $edisi          = $_POST['edisi'];
                $isbn           = $_POST['isbn'];
                $seri           = $_POST['seri'];
                $abstrak        = $_POST['abstrak'];
                $klarifikasi    = $_POST['klarifikasi'];
                $pustakawan     = '';

                $tgl            = date("Y-m-d");
 
                if(in_array($file_ext, $allowed_ext) === true){
                    if($file_size < 1044070){
                        $lokasi = 'upload_file/'.$judul.'.'.$file_ext;
                        move_uploaded_file($file_tmp, $lokasi);
                        $in = mysql_query("INSERT INTO upload_ebook 
                            VALUES('$kd','$pustakawan','$judul','$pengarang','$penerbit','$th','$edisi','$isbn','$seri','$abstrak','$klarifikasi','$file_size','$file_ext','$tgl','','$lokasi')");
                        if($in){
                            echo '<div class="ok">SUCCESS: File berhasil di Upload!</div>';
                        }else{
                            echo '<div class="error">ERROR: Gagal upload file!</div>';
                        }
                    }else{
                        echo '<div class="error">ERROR: Besar ukuran file (file size) maksimal 1 Mb!</div>';
                    }
                }else{
                    echo '<div class="error">ERROR: Ekstensi file tidak di izinkan!</div>';
                }
            }
            ?>

    <div class="panel panel-info">
        <div class="panel-heading">
            FORM INPUT EBOOK BARU
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
                <table width="100%">
                    <tr>
                        <td width="20%"><div class="form-group"><label>Kode EBook</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="kd" autofocus/></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Judul EBook</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="judul" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Nama Pengarang</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="pengarang" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Nama Penerbit</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="penerbit" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Tahun Terbit</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="th_terbit" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Edisi</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="edisi" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>ISSN ISBN</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="isbn" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Seri</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="seri" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Klarifikasi Fakultas</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="klarifikasi" /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Abstrak</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><textarea class="form-control" rows="5" name="abstrak"></textarea></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Pilih File</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input type="file" name="file" required /></td>
                    </tr>
                     <tr>
                        <td width="20%"></td>
                        <td width="5%"></td>
                        <td width="70%"><br/><button type="submit" class="btn btn-info" name="upload">Upload </button></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
