
<div class="col-md-12">
<?php if(isset($_SESSION['user']) and (($_SESSION['level'])=='petugas' OR ($_SESSION['level'])=='admin')) {?>
<?php lap_sewa(); ?>
<?php }else{echo ' <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    Anda tidak memiliki hak untuk melihat halaman ini.
                </div>';} ?>
</div>

<?php function lap_sewa(){ ?>
<div class="panel panel-info">
    <div class="panel-heading">
    LAPORAN
    </div>

    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#sirkulasi" data-toggle="tab">Peminjaman</a></li>
            <li class=""><a href="#denda" data-toggle="tab">Denda</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade active in" id="sirkulasi">       
                <p>
                <div class="alert alert-warning">
                    Silahkan pilih rentang waktu laporan yang ingin Anda lihat.
                </div>
                <div class="panel-body" align="center">
                    <form name="" action="report/report-view.php" method="POST" target="_blank">
                        <table>
                            <tr>
                                <td>Tanggal Awal</td>
                                <td>:</td>
                                <td><input type="text" name="tanggal" id="tanggal" size="15" /></td>
                                <td>&nbsp;</td>
                                <td>Tanggal Akhir</td>
                                <td>:</td>
                                <td><input type="text" name="tanggal1" id="tanggal1" size="15" /></td>
                                <td>&nbsp;</td>
                                <td><div><button type="submit" class="btn btn-info" name="tampil_sewa">Tampil Laporan Pinjam</button>
                                    <button type="submit" class="btn btn-success" name="tampil_sewa_ex"><span class="fa fa-file-excel-o"></span> Export</button>
                                    </div>
                                </td>
                            </tr>
                        </table>    
                    </form>
                </div>
            </div>

            <div class="tab-pane fade active" id="denda">
                <p>
                <div class="alert alert-warning">
                    Silahkan pilih rentang waktu laporan yang ingin Anda lihat.
                </div>
                <div class="panel-body" align="center">
                    <form name="" action="report/report-view.php" method="POST" target="_blank">
                        <table>
                            <tr>
                                <td>Tanggal Awal</td>
                                <td>:</td>
                                <td><input type="text" name="tanggal2" id="tanggal2" size="15" /></td>
                                <td>&nbsp;</td>
                                <td>Tanggal Akhir</td>
                                <td>:</td>
                                <td><input type="text" name="tanggal3" id="tanggal3" size="15" /></td>
                                <td>&nbsp;</td>
                                <td><div><button type="submit" class="btn btn-info" name="tampil_denda">Tampil Laporan Denda</button>
                                    <button type="submit" class="btn btn-success" name="tampil_denda_ex"><span class="fa fa-file-excel-o"></span> Export</button>
                                    </div></td>
                            </tr>
                        </table>    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php	}?>