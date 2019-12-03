<?php

    if (isset($_GET['act']) && isset($_GET['ref'])) {
        $act = $_GET['act'];
        $ref = $_GET['ref'];
        $a   = 0;
        $mem = $_SESSION['members'];
		      
        if ($act == "add") {
            if(isset($_SESSION['cart'])){
                $count = count($_SESSION['cart']);
            }else{
                $count = 0;
            }
            
            foreach ($_SESSION['members'] as $key => $value) {
                $sql = mysql_query("SELECT `peminjaman`.`kd_member` as memberid, `peminjaman`.kd_pinjam as kd1, 
                            `detail_pinjam`.kd_pinjam as kd2, COUNT(*) as counter,`peminjaman`.kd_petugas as kd_petugas
                            FROM `peminjaman` CROSS JOIN `detail_pinjam` on
                            `peminjaman`.kd_member = '$key' AND
                            `peminjaman`.`kd_pinjam`=`detail_pinjam`.`kd_pinjam` AND 
                            `detail_pinjam`.status='dipinjam'");
                $exist  = mysql_num_rows($sql); 
                if($exist > 0){
                    $result = mysql_fetch_array($sql);
                    $all    = $result['counter'];
                }else{
                    $all    = 0;
                }   
            

            $q       = mysql_query("SELECT jabatan FROM anggota WHERE kd_mem = '$key'");
            $j       = mysql_fetch_array($q);
            if($j['jabatan']=='Mahasiswa'){
                $sql_opt = mysql_query("SELECT option_value FROM options WHERE kd_option = '3'");
            }else{
                $sql_opt = mysql_query("SELECT option_value FROM options WHERE kd_option = '4'");
            }
            $val     = mysql_fetch_array($sql_opt);
            $limit   = $val['option_value'];
            echo $result['memberid'];

			if (isset($_GET['kdb'])) {
               $id_product = $_GET['kdb'];
			    if(isset($_SESSION['cart'][$id_product])){
                    //same book id			
					$_SESSION['cart'][$id_product] += 1;

				}else{
                    if(($all + $count) >= $limit){
                        echo"<script>window.location=\"?page=sirkulasi&limit\"</script>";
                    }else{    
                    	$_SESSION['cart'][$id_product] = 0; //different book id
                    }
                }
			}
        }
				
				
      } /*elseif ($act == "plus") {
            if (isset($_GET['kdb'])) {
                $id_product = $_GET['kdb'];
                if (isset($_SESSION['cart'][$id_product])) {
                    $_SESSION['cart'][$id_product] += 1;
                }
            }
        } elseif ($act == "min") {
            if (isset($_GET['kdb'])) {
                $id_product = $_GET['kdb'];
                if (isset($_SESSION['cart'][$id_product])) {
                    $_SESSION['cart'][$id_product] -= 1;
                    if (($_SESSION['cart'][$id_product]) == -1){
                        unset($_SESSION['cart'][$id_product]);
                    }
                }
            }
        }*/ elseif ($act == "del") {
            if (isset($_GET['kdb'])) {
                $id_product = $_GET['kdb'];
                if (isset($_SESSION['cart'][$id_product])) {
                    unset($_SESSION['cart'][$id_product]);
                	}
				}
				elseif(isset($_GET['kdm'])){
				$kdm = $_GET['kdm'];
				if(isset($_SESSION['members'][$kdm])){
					unset($_SESSION['members']);
					unset($_SESSION['cart']);
					}
				}
        }
        echo"<script>window.location=\"?page=".$ref."\"</script>";
    }   
/*} else {?>
	<div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Tidak ada sesi member terdaftar <a href="?page=dashboard-admin">Kembali</a>
                
<?php } ?>*/