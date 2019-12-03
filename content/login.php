<div class="col-md-6 col-sm-6 col-xs-12">
<?php 
    if(isset($_GET['member'])){
        login_member();
        if(isset($_POST['log_mem'])){
        cek_login_mem();
        }
    } 
    elseif(isset($_GET['dosen'])){
        login_dosen();
        if(isset($_POST['log_dos'])){
        cek_login_dosen();
        }
    }
    elseif(isset($_GET['librarian'])){
        login_librarian();
        if(isset($_POST['log_lib'])){
        cek_login_librarian();
        }
    }
?>
</div>

<?php 
function login_member(){
?>
<div class="panel panel-primary">
    <div class="panel-heading" align="center">
        LOGIN ANGGOTA
    </div>
<div class="panel-body">
    <form role="form" method="post" action="">
        <div class="form-group">
            <label>Masukan NIM/NIK</label>
                <input class="form-control" type="text" name="user" />
        </div>
        <div class="form-group">
            <label>Masukan Password</label>
                <input class="form-control" type="password" name="password" />
        </div>
                                 
        <button type="submit" class="btn btn-primary" name="log_mem">Login </button>
    </form>
</div>
</div>
<?php
}

function login_dosen(){
?>
<div class="panel panel-primary">
    <div class="panel-heading" align="center">
        LOGIN DOSEN
    </div>
<div class="panel-body">
    <form role="form" method="post" action="">
        <div class="form-group">
            <label>Masukan NIK</label>
                <input class="form-control" type="text" name="user" />
        </div>
        <div class="form-group">
            <label>Masukan Password</label>
                <input class="form-control" type="password" name="password" />
        </div>
                                 
        <button type="submit" class="btn btn-primary" name="log_dos">Login </button>
    </form>
</div>
</div>
<?php
}

function login_librarian(){
?>
<div class="panel panel-primary">
    <div class="panel-heading" align="center">
        LOGIN PETUGAS
    </div>
<div class="panel-body">
    <form role="form" method="post" action="">
        <div class="form-group">
            <label>Masukan Kode Petugas</label>
                <input class="form-control" type="text" name="user" />
        </div>
        <div class="form-group">
            <label>Masukan Password</label>
                <input class="form-control" type="password" name="password" />
        </div>
                                 
        <button type="submit" class="btn btn-primary" name="log_lib">Login </button>
    </form>
</div>
</div>
<?php
}

/*function login_admin(){
?>
<div class="panel panel-primary">
    <div class="panel-heading" align="center">
        LOGIN ADMIN
    </div>
<div class="panel-body">
    <form role="form" method="post" action="">
        <div class="form-group">
            <label>Masukan Kode Admin</label>
                <input class="form-control" type="text" name="user" />
        </div>
        <div class="form-group">
            <label>Masukan Password</label>
                <input class="form-control" type="password" name="password" />
        </div>
                                 
        <button type="submit" class="btn btn-primary" name="log_ad">Login </button>
    </form>
</div>
</div>
<?php 
}
*/
function cek_login_mem(){
if(empty($_POST['user']) AND empty($_POST['password'])){    
     ?>
     <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        Isiskan Semua Field
    </div>
     <?php
}else{
    //cek kebereadaaan user
    $query = mysql_query("SELECT * FROM anggota WHERE nim='$_POST[user]'");
    $sql = mysql_num_rows($query);
    if($sql == 0){
    ?>
   <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        Login Gagal. User belum terdaftar.
    </div>
    <?php
    }else{
        //cek password  
        $pass = $_POST['password'];
        $q = mysql_fetch_array($query); 
        if($pass != $q['password']){
        ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                Login Gagal. Password yang Anda masukan salah.
            </div>
          <?php
        }else{
            $datetime = date("Y-m-d G:i:s");
            $qw = mysql_fetch_array($query);
          //login berhasil,
          $_SESSION['user'] = $_POST['user'];
          $_SESSION['level'] = 'member';

            $log = mysql_query("UPDATE anggota SET last_log='$datetime' WHERE nim = '$_SESSION[user]'");
          echo"<script>window.location=\"?page=catalogue\"</script>"; 
          }
        }
        }
}

function cek_login_dosen(){
if(empty($_POST['user']) AND empty($_POST['password'])){    
     ?>
     <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        Isiskan Semua Field
    </div>
     <?php
}else{
    //cek kebereadaaan user
    $query = mysql_query("SELECT * FROM anggota_dosen WHERE nik='$_POST[user]'");
    $sql = mysql_num_rows($query);
    if($sql == 0){
    ?>
   <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        Login Gagal. User belum terdaftar.
    </div>
    <?php
    }else{
        //cek password  
        $pass = $_POST['password'];
        $q = mysql_fetch_array($query); 
        if($pass != $q['password']){
        ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                Login Gagal. Password yang Anda masukan salah.
            </div>
          <?php
        }else{
            $datetime = date("Y-m-d G:i:s");
            $qw = mysql_fetch_array($query);
          //login berhasil,
          $_SESSION['user'] = $_POST['user'];
          $_SESSION['level'] = 'member';

            $log = mysql_query("UPDATE anggota_dosen SET last_log='$datetime' WHERE nim = '$_SESSION[user]'");
          echo"<script>window.location=\"?page=catalogue\"</script>"; 
          }
        }
        }
}

function cek_login_librarian(){
if(empty($_POST['user']) AND empty($_POST['password'])){    
     ?>
     <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        Isiskan Semua Field
    </div>
     <?php
}else{
    //cek kebereadaaan user
    $query = mysql_query("SELECT * FROM petugas WHERE kd_petugas='$_POST[user]'");
    $sql = mysql_num_rows($query);
    if($sql == 0){
    ?>
   <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        Login Gagal. User belum terdaftar.
    </div>
    <?php
    }else{
        //cek password  
        $pass = $_POST['password'];
        $q = mysql_fetch_array($query); 
        if($pass != $q['password']){
        ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                Login Gagal. Password yang Anda masukan salah.
            </div>
          <?php
        }else{
            $user=$_POST['user'];
            $q = mysql_query("SELECT * FROM petugas WHERE kd_petugas='$_POST[user]'");
            $qw = mysql_fetch_array($q);            
            if($qw['level']=='petugas') {
                $level='petugas';
            }
            elseif($qw['level']=='admin'){
                $level='admin';
            }
          //login berhasil,
            $datetime = date("Y-m-d G:i:s");
            
          $_SESSION['user'] = $user;
          $_SESSION['level'] = $level;
          $log = mysql_query("UPDATE petugas SET last_log='$datetime' WHERE kd_petugas='$_SESSION[user]'");
          
          echo"<script>window.location=\"?page=admin-dashboard\"</script>"; 
          }
        }
        }
}

/*function cek_login_admin(){
if(empty($_POST['user']) AND empty($_POST['password'])){    
     ?>
     <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        Isiskan Semua Field
    </div>
     <?php
}else{
    //cek kebereadaaan user
    $query = mysql_query("SELECT * FROM admin WHERE kd_admin='$_POST[user]'");
    $sql = mysql_num_rows($query);
    if($sql == 0){
    ?>
   <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        Login Gagal. User belum terdaftar.
    </div>
    <?php
    }else{
        //cek password  
        $pass = $_POST['password'];
        $q = mysql_fetch_array($query); 
        if($pass != $q['password']){
        ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                Login Gagal. Password yang Anda masukan salah.
            </div>
          <?php
        }else{
            $qw = mysql_fetch_array($query); 
          //login berhasil,
          $_SESSION['user'] = $_POST['user'];
          $_SESSION['level'] = 'admin';
          echo"<script>window.location=\"?page=admin-dashboard\"</script>"; 
          }
        }
        }
}
*/
?>