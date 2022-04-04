<?php load_templates('layouts/top') ?>
    <div class="content">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Produk</h2>
                        <h5 class="text-white op-7 mb-2">Memanajemen data Produk</h5>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                        <?php if(is_allowed('products/create', auth()->user->id)): ?>
                        <a href="index.php?r=products/create" class="btn btn-secondary btn-round">Buat Produk</a>
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
                                            <?php 
                                            foreach(config('fields')[$table] as $field): 
                                                $label = $field;
                                                if(is_array($field))
                                                {
                                                    $label = $field['label'];
                                                }
                                                $label = _ucwords($label);
                                            ?>
                                            <th><?=$label?></th>
                                            <?php endforeach ?>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Foto</th>
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
                                            <?php 
                                            foreach(config('fields')[$table] as $key => $field): 
                                                $label = $field;
                                                if(is_array($field))
                                                {
                                                    $label = $field['label'];
                                                    $data_value = Form::getData($field['type'],$data->{$key});
                                                    $field = $key;
                                                }
                                                else
                                                {
                                                    $data_value = $data->{$field};
                                                }
                                                $label = _ucwords($label);
                                            ?>
                                            <td><?=$data_value?></td>
                                            <?php endforeach ?>
                                            <td><?=number_format($data->user_product->price??0)?></td>
                                            <td><?=number_format($data->stock)?></td>
                                            <td><img src="<?=$data->pic_url?>" alt="" width="100px" height="100px" style="object-fit:cover;"></td>
                                            <td>
                                                <?php if(is_allowed('products/update-stock', auth()->user->id)): ?>
                                                <a href="index.php?r=products/update-stock&id=<?=$data->id?>" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Tambah Stok</a>
                                                <?php endif ?>
                                                <a href="index.php?r=products/update-price&id=<?=$data->id?>" class="btn btn-sm btn-secondary"><i class="fas fa-pencil-alt"></i> Update Harga</a>
                                                <?php if(is_allowed('products/edit', auth()->user->id)): ?>
                                                    <a href="index.php?r=products/edit&id=<?=$data->id?>" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                <?php endif ?>
                                                <?php if(is_allowed('products/delete', auth()->user->id)): ?>
                                                <a href="index.php?r=products/delete&id=<?=$data->id?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</a>
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