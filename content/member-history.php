<?php
function history_list_member(){
?>
<div class="row pad-botm">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="90%"><h4 class="header-line">Sirkulasi</h4></td>
                <td><button class="btn btn-warning" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Pinjam Buku</button></td>
            </tr>
        </table>           
    </div>
</div>
<?php
      $per_page = 10;
      $page_query = mysql_query("SELECT COUNT(*) FROM `peminjaman`");
      $page = (isset($_GET['pages'])) ? (int)$_GET['pages'] : 1;
      $start = ($page-1) * $per_page; 
      $pages = ceil(mysql_result($page_query, 0) / $per_page);
      ?>

<div class="row">
<div class="col-md-12">            
<!--    Context Classes  -->
<div class="panel panel-default">
<div class="panel-heading">
    <table width="100%">
        <tbody>
            <tr>
                <td width="30%">
                    <div class="form-group">
                    <?php
                    if(isset($_GET['pages'])){
                        $noPage = $_GET['pages'];}
                    else $noPage = 1;              
                        if($pages >= 2 && $page <= $pages){
                            if ($noPage > 1 OR $noPage == $pages) 
                                echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
                                for($x=1; $x<=$pages; $x++){
                                    $showPage = $x;
                                    if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){                
                                        if (($showPage != ($pages - 1)) && ($x == $pages))
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                                        if ($x == $noPage)
                                            echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                                        else
                                            echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
                                }
                                if ($noPage < $pages)
                                    echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
                            }
                    ?>        
                    </div>
                </td>
                <td width="20%"></td>
                <td width="20%">
                    <form role="form" method="post" action="?page=sirkulasi">             
                        <div class="input-group">
                             <input type="text" name="search" class="form-control">
                                 <span class="form-group input-group-btn">
                                     <button class="btn btn-default" type="submit">Cari</button>
                                     <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Filter <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                            <li><a href="#">Kode Sirkulasi</a></li>
                                            <li><a href="#">Kode Mahasiswa</a></li>
                                            </ul>
                                    </div>                                     
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
            <th>Kode Pinjam</th>
            <th>Kode Petugas</th>
            <th>Kode Anggota</th>
            <th>Jumlah Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Aksi</th>
            </tr>
        </thead>
     <tbody>
    <?php
    $no     = $start+1;
    $sql    = mysql_query("SELECT * FROM peminjaman ORDER BY kd_pinjam ASC LIMIT $start,$per_page");
    $jml    = mysql_num_rows($sql);
    if($jml >=1){
        while($data=mysql_fetch_array($sql)){
            $kdp = $data['kd_pinjam'];
    ?>
        <tr class=warning>                                  
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['kd_pinjam']; ?></td>
            <td><a href="?page=librarians&view-librarian=<?php echo $data['kd_petugas']?>"><?php echo $data['kd_petugas']; ?></a></td>
            <td><a href="?page=members&view-member=<?php echo $data['kd_member'];?>"><?php echo $data['kd_member']; ?></a></td>
            <td><?php echo $data['jml_buku']; ?></td>
            <td><?php echo $data['tgl_pinjam']; ?></td>                                    
            <td><a href="?page=circulation-histori&id=<?php echo $kdp;?>" class="btn btn-primary" type="button">
                <i class="fa fa-pencil"></i> Lihat</a></td>
        </tr>
    <?php }                                
    }else echo "<tr class=danger><td colspan=8 align=center>Tidak Ada Record</td></td>";

    ?>
    </tbody>
</table>
<div align="left">
<?php  
$jml = mysql_query("SELECT * FROM `peminjaman`");
$total = mysql_num_rows($jml);
?>
    <strong>Jumlah Record : <?php echo $total; ?></strong>
</div>

<div class="form-group" align="right">          
<?php
if(isset($_GET['pages'])){
    $noPage = $_GET['pages'];}
else $noPage = 1;
              
              
    if($pages >= 2 && $page <= $pages){
        if ($noPage > 1 OR $noPage == $pages) 
        echo  "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&pages=".($noPage-1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">&lt;&lt; Previous</a>";
            for($x=1; $x<=$pages; $x++){
            $showPage = $x;
                if ((($x >= $noPage - 1) && ($x <= $noPage + 1)) || ($x == 1) || ($x == $pages)){
                //if (($showPage == 2) && ($x != 1))  echo "...";
                if (($showPage != ($pages - 1)) && ($x == $pages))
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\">...</a> ";
                if ($x == $noPage)
                    echo " <a href=\"#\" class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"><b> ".$x."</b></a>";
                else
                    echo " <a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&pages=".$x."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> ".$x."</a> "; }
              }
            if ($noPage < $pages)
                echo "<a href='".$_SERVER['PHP_SELF']."?page=sirkulasi&pages=".($noPage+1)."' class=\"btn btn-default\" style=\"color:#3366CC; border-bottom-style:groove\"> Next &gt;&gt;</a>";
              }
              ?>

        
        </div>
    </div>
</div>
</div>