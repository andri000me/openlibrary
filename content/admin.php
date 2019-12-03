<div class="col-md-12">
<?php
if(isset($_GET['form-admin'])){
    form_admin();
    if(isset($_POST['reg'])){
    input_admin();
    }
}
elseif(isset($_GET['update-admin'])){
    form_update_admin();
    if(isset($_POST['update'])){
    update_admin();
    }
}
elseif(isset($_GET['view-admin'])){
	form_view_admin();
}
elseif (isset($_GET['change-pass'])) {
    form_change_pass_adm();
}
elseif (isset($_GET['change-pic'])) {
    form_change_pic_adm();
}

else{
    admin_list();
}

?>
</div>
