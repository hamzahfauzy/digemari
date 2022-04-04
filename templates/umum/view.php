<?php load_templates('layouts/top-without-sidebar') ?>
    <div class="content">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Pesanan Berhasil</h2>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                        <a href="index.php?r=umum/index" class="btn btn-warning btn-round">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            <div class="row row-card-no-pd" style="height:100vh;overflow-x:auto;">
                <div class="col-12">
                    <div class="card card-profile">
                        <div class="card-body pt-1">
                            <center>
                                <h2>Pesanan berhasil di buat</h2>
                                <h3>Kode pesanan anda adalah #<?=$_GET['id']?></h3>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php load_templates('layouts/bottom') ?>