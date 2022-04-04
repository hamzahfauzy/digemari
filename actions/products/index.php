<?php

$table = 'products';
$conn = conn();
$db   = new Database($conn);
$success_msg = get_flash_msg('success');

$data = $db->all($table);

$data = array_map(function($d) use ($db){
    $user_id = auth()->user->id;
    $d->user_product = $db->single('user_products',[
        'user_id' => $user_id,
        'product_id' => $d->id,
    ]);

    $db->query = "SELECT SUM(amount) as total FROM user_stocks WHERE user_id = $user_id AND product_id = $d->id";
    $stock = $db->exec('single');
    $d->stock = $stock->total;
    return $d;
},$data);

return [
    'datas' => $data,
    'table' => $table,
    'success_msg' => $success_msg
];