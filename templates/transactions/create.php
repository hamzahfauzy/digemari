<?php load_templates('layouts/top') ?>
    <div class="content">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Buat Transaksi</h2>
                        <h5 class="text-white op-7 mb-2">Memanajemen data transaksi</h5>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                        <a href="index.php?r=transactions/index" class="btn btn-warning btn-round">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            <form action="" method="post">
                <div class="row row-card-no-pd" style="height:100vh;overflow-x:auto;">
                    <?php if(is_role('kios',auth()->user->id)): ?>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Distributor</label>
                                    <select name="transactions[user_to_id]" class="form-control" id="" required onchange="location=location+'&user_to_id='+this.value">
                                        <option value="">- Pilih -</option>
                                        <?php foreach($roles as $role): ?>
                                        <option value="<?=$role->user->id?>" <?=isset($_GET['user_to_id']) && $_GET['user_to_id'] == $role->user_id?'selected':''?>><?=$role->user->name?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
                    <?php foreach($products as $product): ?>
                    <div class="col-12 col-md-4">
                        <div class="card card-profile">
                            <div class="card-header" style="background-image: url('<?=$product->pic_url?>');background-size:contain;background-repeat:no-repeat;background-position:center;">
                            </div>
                            <div class="card-body pt-1">
                                <div class="user-profile text-center">
                                    <div class="name"><?=$product->name?></div>
                                    <div class="view-profile">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button type="button" onclick="if(document.querySelector('#quantity_<?=$product->id?>').value > 0){document.querySelector('#quantity_<?=$product->id?>').value--}" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
                                                <span class="fas fa-minus"></span>
                                                </button>
                                            </span>
                                            <input type="text" id="quantity_<?=$product->id?>" name="transaction_items[<?=$product->id?>]" class="form-control input-number" value="0" min="0" max="<?=$product->stock->total?>">
                                            <span class="input-group-btn">
                                                <button type="button" onclick="if(document.querySelector('#quantity_<?=$product->id?>').value < <?=$product->stock->total?>){document.querySelector('#quantity_<?=$product->id?>').value++}" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                                    <span class="fas fa-plus"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row user-stats text-center">
                                    <div class="col">
                                        <div class="number"><?=number_format($product->stock->total)?></div>
                                        <div class="title">Stok</div>
                                    </div>
                                    <div class="col">
                                        <div class="number"><?=number_format($product->price->price)?></div>
                                        <div class="title">Harga</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block">Buat Pesanan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php load_templates('layouts/bottom') ?>