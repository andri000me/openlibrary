<div class="col-md-12">
<?php

if(isset($_GET['form-member'])){
    form_member();
    if(isset($_POST['reg'])){
    input_member();
    }
}
elseif(isset($_GET['update-member'])){
    form_update_member();
    if(isset($_POST['update'])){
    update_member();
    }
}
elseif(isset($_GET['view-member'])){
	form_view_member();
}
elseif (isset($_GET['change-pass'])) {
    form_change_pass_mem();
}
elseif (isset($_GET['change-pic'])) {
    form_change_pic_mem();
}
elseif (isset($_POST['search']) or isset($_GET['search'])) {
        members_list_search();
    }
    else{
        members_list();
    }
//}else{ echo "Maaf Halaman yang Anda Cari Tidak Ditemukan.";}
?>
</div>
