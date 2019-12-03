
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="80%"><h4 class="header-line">Sirkulasi</h4></td>
                <?php if(!isset($_SESSION['members'])){?>
                <td><div><button class="btn btn-warning" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Pinjam Buku</button>
                    <?php if(isset($_SESSION['user']) and ($_SESSION['level'])=='admin'){ ?>
                    <button class="btn btn-default" data-toggle="modal" data-target="#myModal2"><i class="fa fa-cogs"></i> Option</button></div></td>
                <?php }
                } ?>
            </tr>
        </table>           
    </div>
</div>
<div class="row">
<?php
if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')){
if(isset($_SESSION['members'])){
    foreach($_SESSION['members'] as $key => $val){
            $sql    = mysql_query("SELECT * FROM anggota WHERE kd_mem='$key'");
            $result = mysql_fetch_array($sql);            
            }
            form_pinjam();            
}
elseif(!isset($_SESSION['members'])){
    if(isset($_POST['pinjam'])){
                if(isset($_POST['kdm'])){
                    $kdm = $_POST['kdm'];
                    if (isset($_SESSION['members'][$kdm])) {
                        $_SESSION['members'][$kdm] += 1;                
                    } else {
                        $_SESSION['members'][$kdm] = 0; 
                    }
                }
                echo"<script>window.location=\"?page=sirkulasi\"</script>";
            }
    elseif(isset($_GET['member'])){
        if(isset($_POST['search']) or isset($_GET['search'])) {
            sirkulasi_orderby_member_search();
        }
        else{
            sirkulasi_orderby_member();
        }
    }else{
    if(isset($_GET['list'])=='show'){
        if(isset($_POST['search']) or isset($_GET['search'])){
            history_list_search();
        }else{
            history_list();
            
        }
    }
    else{

        show_graf_sir();
        book_late();
        book_borrowed();
    } 
}}}
else{echo ' <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Anda tidak memiliki hak untuk melihat halaman ini.
                </div>';} ?>
</div>
<?php modal();?>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h3>Options</h3>
                </div>
                <div class="modal-body">
                <?php 
                    
                    $result1 = mysql_query("SELECT * FROM options WHERE kd_option='3'");
                    $data1   = mysql_fetch_array($result1);
                    $result2 = mysql_query("SELECT * FROM options WHERE kd_option='4'");
                    $data2   = mysql_fetch_array($result2)?>
                    <div class="form-group">
                    <label>Limit Buku Mahasiswa : </label>
                    <input class="form-control" type="text" name="limit_mhs" id value="<?php echo $data1['option_value'];?>" required autofocus/></div>
                    <div class="form-group">
                    <label>Limit Buku Dosen : </label>
                    <input class="form-control" type="text" name="limit_dosen" id value="<?php echo $data2['option_value'];?>" required/></div>
                    
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-primary" name="save_opt">Save Changes</button>
                </div>
            </div>  
        </form> 
    </div>
</div>
<?php 
if(isset($_POST['save_opt'])){
    $limit_mhs = $_POST['limit_mhs'];
    $limit_dsn = $_POST['limit_dosen'];

    $query_opt1 = mysql_query("UPDATE options set option_value = '$limit_mhs' WHERE kd_option = '3'");
    $query_opt2 = mysql_query("UPDATE options set option_value = '$limit_dsn' WHERE kd_option = '4'");

    if($query_opt1 && $query_opt2){
    ?>
    <script type="text/javascript">
    alert("Option Updated!");
    window.location.href="?page=sirkulasi";
    </script>
<?php
    }
}
?>