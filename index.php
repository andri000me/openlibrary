<?php
date_default_timezone_set('Asia/Jakarta');
session_start();
include("content/function.php")
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Digital Library</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <!-- DATE PICKER -->
    <link rel="stylesheet" href="lib/css/default.css" />

</head>
<body>
    <div class="navbar navbar-inverse set-radius-zero" >
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">
                    <img src="assets/img/logo.png" width="20%" />
                </a>

            </div>

            <div class="right-div">
            
            <?php 
            if(isset($_SESSION['user'])){
                $kds = $_SESSION['user'];
            ?>
              <div style="margin:5px;" class="btn-toolbar">
                    <div class="btn-group">
                      <button class="btn btn-default"><i class=" fa fa-user"></i> <?php 
                            if($_SESSION['level']=='petugas' or $_SESSION['level']=='admin'){
                                $qp = mysql_query("SELECT * FROM petugas WHERE kd_petugas ='$kds' ");
                                $dp = mysql_fetch_array($qp);
                                echo $dp['nama'];
                                ?>
                                </button>
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                <li><a href="?page=librarians&view-librarian=<?php echo $dp['kd_petugas'];?>">Profil</a></li>
                                <li><a href="?page=librarians&change-pass=<?php echo $dp['kd_petugas'];?>">Ubah Password</a></li>
                                <li><a href="?page=librarians&change-pic=<?php echo $dp['kd_petugas'];?>">Ubah Gambar</a></li>
                                <li><a href="?page=logout"><i class=" fa fa-sign-out "></i>Logout</a></li>
                                </ul>
                                <?php }
                                elseif($_SESSION['level']=='dosen'){
                                $qm = mysql_query("SELECT * FROM anggota_dosen WHERE nik ='$kds' ");
                                $dm = mysql_fetch_array($qm);
                                echo $dm['nama'];
                                ?></button>
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                <li><a href="?page=members-dosen&view-member=<?php echo $dm['kd_dos'];?>">Profil</a></li>
                                <li><a href="?page=members-dosen&change-pass=<?php echo $dm['kd_dos'];?>">Ubah Password</a></li>
                                <li><a href="?page=members-dosen&change-pic=<?php echo $dm['kd_dos'];?>">Ubah Gambar</a></li>
                                <li><a href="?page=logout"><i class=" fa fa-sign-out "></i>Logout</a></li>
                                </ul>                   
                                <?php }
                                elseif($_SESSION['level']=='member'){
                                $qm = mysql_query("SELECT * FROM anggota WHERE nim ='$kds' ");
                                $dm = mysql_fetch_array($qm);
                                echo $dm['nama'];
                                ?></button>
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                <li><a href="?page=members&view-member=<?php echo $dm['kd_mem'];?>">Profil</a></li>
                                <li><a href="?page=members&change-pass=<?php echo $dm['kd_mem'];?>">Ubah Password</a></li>
                                <li><a href="?page=members&change-pic=<?php echo $dm['kd_mem'];?>">Ubah Gambar</a></li>
                                <li><a href="?page=logout"><i class=" fa fa-sign-out "></i>Logout</a></li>
                                </ul>                   
                                <?php }?>
                </div>
            </div>
<?php
            } else {
                echo'
                <div style="margin:5px;" class="btn-toolbar">
                    <div class="btn-group">
                      <button class="btn btn-default">Login sebagai</button>
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><span class="caret"></span></button>
                      <ul class="dropdown-menu">
                      <li><a href="?page=login&member">Anggota</a></li>
                      <li><a href="?page=login&librarian">Petugas</a></li>
                      </ul>
                    </div>
                
                    
                </div>';
                }
                ?>
            </div>
        </div>
    </div>
    <!-- LOGO HEADER END-->
    <section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="index.php">DASHBOARD</a></li>                           
                            <li><a href="?page=profile">Profil</a></li>
                            <?php if(isset($_SESSION['user'])) {?>
                            <li><a href="?page=request">Request</a></li>
                            <?php } ?>
                            <?php if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <li><a href="?page=catalogue">Katalog</a></li>
                            <?php } ?>
                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown">Repositori <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">                                
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="?page=intern">KP</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="?page=e-journal">Jurnal</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="?page=skripsi">Skripsi</a></li>
                                </ul>
                            </li>
                            <?php if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown">Anggota <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="?page=members&cat=Mahasiswa">Mahasiswa</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="?page=members&cat=Dosen">Dosen</a></li>
                                    <?php if(isset($_SESSION['user']) AND ($_SESSION['level'])=='admin') {?>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="?page=librarians">Petugas</a></li>
                                    <?php } ?>
                                </ul>
                            </li>                            
                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown">Sirkulasi <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="?page=sirkulasi">Sirkulasi</a></li>
                                    <?php if(isset($_SESSION['user']) AND ($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin') {?>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="?page=calendar">Hari Libur</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="?page=report">Laporan</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                                
                            <?php } ?>
                            <li><a href="?page=about-me">Tentang Saya</a></li>                                                     
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

     <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <?php
        //if(!isset($_SESSION['user'])){
        //echo"<script>window.location=\"login.php\"</script>";
        //}
        //else
         if(isset($_GET['page'])){
                include("content/".$_GET['page'].".php");
                }
        else {
            echo"<script>window.location=\"?page=admin-dashboard\"</script>";   
            }
        ?>

    </div>
    </div>

     <!-- CONTENT-WRAPPER SECTION END-->
    <section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                   &copy; 2016 s3digital-library.com |<a href="?page=about-me" target="_blank"  > Created by : Sarah</a> 
                </div>

            </div>
        </div>
    </section>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
    <!-- DATE PICKER -->
    <script src="lib/jquery.min.js"></script>
    <script src="lib/zebra_datepicker.js"></script>
    <script src="assets/js/highcharts.js"></script>
    <script src="assets/js/exporting.js"></script>
    <!--<script type="text/javascript" src="data.js" ></script>-->

    <script>
    $(document).ready(function(){
        $('#tanggal').Zebra_DatePicker({
            format: 'd-m-Y',
            months : ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
            days : ['Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu'],
            days_abbr : ['Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu']
        });
    });

        $(document).ready(function(){
        $('#tanggal1').Zebra_DatePicker({
            format: 'd-m-Y',
            months : ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
            days : ['Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu'],
            days_abbr : ['Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu']
        });
    });

        $(document).ready(function(){
        $('#tanggal2').Zebra_DatePicker({
            format: 'd-m-Y',
            months : ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
            days : ['Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu'],
            days_abbr : ['Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu']
        });
    });

        $(document).ready(function(){
        $('#tanggal3').Zebra_DatePicker({
            format: 'd-m-Y',
            months : ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
            days : ['Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu'],
            days_abbr : ['Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu']
        });
    });
</script>

<script type="text/javascript">
    $(document).on("click", ".open-AddBookDialog", function () {
    var myBookId = $(this).data('kdbk');
    var borrowID = $(this).data('kode');
    var judul    = $(this).data('judul');
    var ket      = $(this).data('ket');
    $(".modal-body #bookId").val( myBookId );
    $(".modal-body #borrowId").val( borrowID );
    $(".modal-body #judul").val( judul );
    $(".modal-body #ket").val( ket );
    $(".modal-title").text("Keterangan (Judul : "+judul+")");
    });
    </script>

<script async type='text/javascript'>
function formValidatorMember(){
   // Make quick references to our fields
   var kd_mem = document.getElementById('kd_mem');
   var nama = document.getElementById('nama');
   var nim = document.getElementById('nim');
   var jk = document.getElementById('jk');
   var fakultas = document.getElementById('fakultas');
   var jurusan = document.getElementById('jurusan');
   var semester = document.getElementById('semester');
   var kelas = document.getElementById('kelas');
   var tlp = document.getElementById('tlp');
   var email = document.getElementById('email');
   var password = document.getElementById('password');
   var img = document.getElementById('img');
   // Check each input in the order that it appears in the form!
   if(isAlphanumeric(kd_mem,"Isikan Kode Anggota dengan angka dan huruf")){
    if(notEmpty(nama, "Isikan Nama Anggota hanya huruf")){
     if(isNumeric(nim, "Isikan Nim yang Valid")){
      if(madeSelection(jk, "Pilih Jenis Kelamin")){
       if(madeSelection(fakultas, "Pilih Fakultas")){
        if(madeSelection(jurusan, "Pilih Jurusan")){
         if(madeSelection(semester, "Pilih Semester")){
          if(madeSelection(kelas, "Pilih Kelas")){
           if(isNumeric(tlp, "Isikan No Telepon yang valid")){               
             if(emailValidator(email, "Isikan alamat email yang valid")){
              if(lengthRestriction(password, 6, 15)){
                if(notEmpty(nama, "Isikan Gambar")){
               return true;
                }
               }
              }
             }
            }
           }
          }
         }
        }
       }
      }
     }  
   return false;
}

function formValidatorLib(){
   // Make quick references to our fields
   var kd_petugas = document.getElementById('kd_petugas');
   var nama = document.getElementById('nama');
   var nik = document.getElementById('nik');
   var jk = document.getElementById('jk');
   var jabatan = document.getElementById('jabatan');
   var tlp = document.getElementById('tlp');
   var email = document.getElementById('email');
   var password = document.getElementById('password');
   var level = document.getElementById('level');
   var img = document.getElementById('img');
   // Check each input in the order that it appears in the form!
   if(isAlphanumeric(kd_petugas,"Isikan Kode Anggota dengan angka dan huruf")){
    if(notEmpty(nama, "Isikan Nama Anggota hanya huruf")){
     if(isNumeric(nik, "Isikan Nik yang Valid")){
      if(madeSelection(jk, "Pilih Jenis Kelamin")){       
         if(madeSelection(jabatan, "Pilih jabatan")){
          if(isNumeric(tlp, "Isikan No Telepon yang valid")){           
            if(emailValidator(email, "Isikan alamat email yang valid")){
             if(lengthRestriction(password, 6, 15)){
              if(madeSelection(level, "Pilih Level")){
               
               return true;
               }
              }
             }
            }
           }
          }
         }
        }
       }
      
     
    
   return false;
}

function formValidatorPassMem(){
   // Make quick references to our fields   
   var password = document.getElementById('password');
   // Check each input in the order that it appears in the form!
              if(lengthRestriction(password, 6, 15)){
               return true;
                }  
   return false;
}

function formValidatorPassLib(){
   // Make quick references to our fields   
   var password = document.getElementById('password');
   // Check each input in the order that it appears in the form!
              if(lengthRestriction(password, 6, 15)){
               return true;
                }  
   return false;
}

function notEmpty(elem, helperMsg){
   if(elem.value.length == 0){
      alert(helperMsg);
      elem.focus(); // set the focus to this input
      return false;
   }
   return true;
}
function isNumeric(elem, helperMsg){
   var numericExpression = /^[0-9]+$/;
   if(elem.value.match(numericExpression)){
      return true;
   }else{
      alert(helperMsg);
      elem.focus();
      return false;
   }
}
function isAlphabet(elem, helperMsg){
   var alphaExp = /^[a-zA-Z]+$/;
   if(elem.value.match(alphaExp)){
      return true;
   }else{
      alert(helperMsg);
      elem.focus();
      return false;
   }
}
function isAlphanumeric(elem, helperMsg){
   var alphaExp = /^[0-9a-zA-Z]+$/;
   if(elem.value.match(alphaExp)){
      return true;
   }else{
      alert(helperMsg);
      elem.focus();
      return false;
   }
}
function lengthRestriction(elem, min, max){
   var uInput = elem.value;
   if(uInput.length < min || uInput.length > max){
      alert("Isikan antara " +min+ " and " +max+ " karakter");
      elem.focus();
      return false;
   }else{
      return true;
   }
}
function madeSelection(elem, helperMsg){
   if(elem.value == "Please Choose"){
      alert(helperMsg);
      elem.focus();
      return false;
   }else{
      return true;
   }
}
function emailValidator(elem, helperMsg){
   var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
   if(elem.value.match(emailExp)){
      return true;
   }else{
      alert(helperMsg);
      elem.focus();
      return false;
   }
}
</script>
<?php 
  $start = date("m")-5;
 $k1 = mysql_query("SELECT count(*) FROM detail_pinjam WHERE status = 'dipinjam' Group By date_format(tgl_pinjam,'%m') ASC Limit $start,5");
 $k2 = mysql_query("SELECT count(*) FROM detail_pinjam WHERE status = 'dikembalikan' Group By date_format(tgl_kem,'%m') ASC Limit $start,5");
 $k3 = mysql_query("SELECT count(*) FROM detail_pinjam WHERE denda > 0 Group By date_format(tgl_kem,'%m') ASC Limit $start,5");
 $q = mysql_query("SELECT date_format(tgl_pinjam,'%b') as bulan from peminjaman Group By date_format(tgl_pinjam,'%m') ASC Limit $start,5");
 ?>

<script async type="text/javascript">
    //2)script untuk membuat grafik, perhatikan setiap komentar agar paham
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container', //letakan grafik di div id container
        //Type grafik, anda bisa ganti menjadi area,bar,column dan bar
                type: 'column',  
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: 'Laporan Sirkulasi',
                x: -20 //center
            },
            subtitle: {
                text: 'DIGITAL LIBRARY',
                x: -20
            },
            xAxis: { //X axis menampilkan data bulan 
                categories: [<?php while($r=mysql_fetch_array($q)){ echo "'".$r["bulan"]."',";}?>]
            },
            yAxis: {
                title: {  //label yAxis
                    text: 'Jumlah Buku'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080' //warna dari grafik line
                }]
            },
            tooltip: { 
      //fungsi tooltip, ini opsional, kegunaan dari fungsi ini 
      //akan menampikan data di titik tertentu di grafik saat mouseover
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y ;
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
      //series adalah data yang akan dibuatkan grafiknya,
    
            series: [{  
                name: 'Dipinjam',  
        
                data: [<?php while($t=mysql_fetch_array($k1)){ echo $t["count(*)"].",";}?>]
            },
            {  
                name: 'Dikembalikan',  
        
                data: [<?php while($t=mysql_fetch_array($k2)){ echo $t["count(*)"].",";}?>]
            },
            {  
                name: 'Terlambat',  
        
                data: [<?php while($t=mysql_fetch_array($k3)){ echo $t["count(*)"].",";}?>]
            }
            
            ]
        });
    });
    
});
</script>
<!-------- Pie Chart ---------------------------------------------------------------------------------------------------------------------------------------- -->

<?php
$qm = mysql_query("SELECT count(*) as jml FROM anggota Group By status_mem");
?>
<script type="text/javascript">

</script>