<?php load_templates('layouts/top') ?>
    <div class="content">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Transaksi</h2>
                        <h5 class="text-white op-7 mb-2">Memanajemen data transaksi</h5>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                        <?php if(!is_role('administrator',auth()->user->id)): ?>
                        <a href="index.php?r=transactions/create" class="btn btn-secondary btn-round">Order</a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            <div class="row row-card-no-pd">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <?php if($success_msg): ?>
                            <div class="alert alert-success"><?=$success_msg?></div>
                            <?php endif ?>
                            <div class="table-responsive table-hover table-sales">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th width="20px">#</th>
                                            <th>Subjek</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th class="text-right">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($datas as $index => $data): ?>
                                        <tr>
                                            <td>
                                                <?=$index+1?>
                                            </td>
                                            <td>
                                                <?php if($data->user_from_id == NULL): ?>
                                                    Umum (Kode Transaksi : #<?=$data->id?>)
                                                <?php else: ?>
                                                    <?=$data->subject->name?> (<?=$data->tipe?>)
                                                <?php endif ?>
                                            </td>
                                            <td><?=number_format($data->total)?></td>
                                            <td><?=config('trx_status')[$data->status]?></td>
                                            <td>
                                                <a href="index.php?r=transactions/view&id=<?=$data->id?>" class="btn btn-sm btn-primary">Detail</a>
                                                <?php if($data->tipe == 'Jual' && $data->status == 0): ?>
                                                <a href="index.php?r=transactions/confirm&id=<?=$data->id?>" class="btn btn-sm btn-success">Konfirmasi</a>
                                                <a href="index.php?r=transactions/cancel&id=<?=$data->id?>" class="btn btn-sm btn-danger">Batalkan</a>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php load_templates('layouts/bottom') ?>