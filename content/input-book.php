<?php
if(isset($_GET['form-buku'])){
    form_buku();
    if(isset($_POST['simpan'])){
    input_request();
    }
}
elseif(isset($_GET['update-buku'])){
    form_update_buku();
    if(isset($_POST['update_buku'])){
    update_buku();
    }
}

else{
    list_buku();
}

?>
