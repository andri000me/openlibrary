<?php if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')){?>
<div class="row pad-botm">
    <div class="col-md-12">
        <h4 class="header-line">TAMBAH EBOOK</h4>
    </div>
</div>
<div class="alert alert-warning">
    Upload file Anda dengan melengkapi form di bawah ini. File yang bisa di Upload hanya file dengan ekstensi <b>.doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .rar, .zip</b> dan besar file (file size) maksimal hanya 1 MB.
 </div>
            <?php

            $kd_bk = $_GET['id'];

             
            //No Urut Ebook
            $kd_ebook   = "eb";
            $qk         = mysql_query("SELECT max(kd_ebook) AS last FROM ebook WHERE kd_ebook LIKE '$kd_ebook%'");
            $dk         = mysql_fetch_array($qk);
            $lastkd1    = $dk['last'];
            $lastNo1    = substr($lastkd1, 2, 5); 
            $nextNo1    = $lastNo1 + 1; 
            $ebook      = $kd_ebook.sprintf('%05s', $nextNo1);
                    

            if(isset($_POST['upload'])){
                $allowed_ext    = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'rar', 'zip');
                $file_name      = $_FILES['file']['name'];
                $file_ext       = strtolower(end(explode('.', $file_name)));
                $file_size      = $_FILES['file']['size'];
                $file_tmp       = $_FILES['file']['tmp_name']; 
                
                $pustakawan     = $_SESSION['user'];
                $judul          = $_POST['judul'];
                $kd             = $_POST['kd'];
                $tgl            = date("Y-m-d");
 
                if(in_array($file_ext, $allowed_ext) === true){
                    if($file_size < 1044070){
                        $lokasi = 'upload_file/'.$ebook.'.'.$file_ext;
                        move_uploaded_file($file_tmp, $lokasi);
                        $in = mysql_query("INSERT INTO ebook 
                            VALUES('$kd','$kd_bk','$pustakawan','$judul','$file_size','$file_ext','$tgl','','$lokasi')") or die(mysql_error());
                        if($in){?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                SUCCESS: File berhasil di Upload!<a href="?page=detail-catalogue&id=<?php echo $_GET['id']; ?>" class="alert-link"> Kembali</a></div>
                        <?php }else{
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
            ?>

    <div class="panel panel-info">
        <div class="panel-heading">
            FORM INPUT BUKU BARU
        </div>
        <div class="panel-body">
            <form role="form" action="" method="post" enctype="multipart/form-data">
                <table width="100%">
                    <tr>                   
                        <td width="20%"><div class="form-group"><label>Kode EBook</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="kd" value="<?php echo $ebook; ?>" readonly /></td>
                    </tr>
                    <tr>
                        <td width="20%"><div class="form-group"><label>Judul EBook</label></div></td>
                        <td width="5%">:</td>
                        <td width="70%"><input class="form-control" type="text" name="judul" required/></td>
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
    <?php }else{echo ' <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Anda tidak memiliki hak untuk melihat halaman ini.
                </div>';} ?>
