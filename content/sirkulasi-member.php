<div class="col-md-12">
<?php 
if(isset($_POST['search']) or isset($_GET['search'])) {
    sirkulasi_orderby_member_search();
    }
else{
    sirkulasi_orderby_member();}
?>
</div>