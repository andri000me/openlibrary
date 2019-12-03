<div class="col-md-12">
<?php
if(isset($_GET['form-buku'])){
    form_buku();
    if(isset($_POST['simpan'])){
    input_buku();
    }
}
elseif(isset($_GET['update-buku'])){
    if($_GET['update-buku']=='info'){
        form_update_buku_info();
    }
    elseif($_GET['update-buku']=='abstrak'){
        form_update_buku_abstrak();
    }
    elseif($_GET['update-buku']=='pengarang'){
        form_update_buku_pengarang();
    }
    elseif($_GET['update-buku']=='penerbit'){
        form_update_buku_penerbit();
    }
    elseif($_GET['update-buku']=='sirkulasi'){
        form_update_buku_sirkulasi();
    }
}

elseif(isset($_POST['search']) or isset($_GET['search'])) {
    book_list_search();
}else{
	book_list();
}

?>
</div>
