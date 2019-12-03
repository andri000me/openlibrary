<div class="col-md-12">
<?php
if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')){
if(isset($_GET['form-librarian'])){
    form_librarian();
    if(isset($_POST['reg'])){
    input_librarian();
    }
}
elseif(isset($_GET['update-librarian'])){
    form_update_librarian();
    if(isset($_POST['update'])){
    update_librarian();
    }
}
elseif(isset($_GET['view-librarian'])){
	form_view_librarian();
}
elseif (isset($_GET['change-pass'])) {
    form_change_pass_lib();
}
elseif (isset($_GET['change-pic'])) {
    form_change_pic_lib();
}
elseif (isset($_POST['search']) or isset($_GET['search'])) {
    librarians_list_search();
}

else{
    librarians_list();
}

}else{echo ' <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Anda tidak memiliki hak untuk melihat halaman ini.
                </div>';} ?>
</div>
