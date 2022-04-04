<?php

$table = 'products';
$conn = conn();
$db   = new Database($conn);

$data = $db->single($table,[
    'id' => $_GET['id']
]);

if(request() == 'POST')
{
    $data_user_products = [
        'user_id' => auth()->user->id,
        'product_id' => $data->id,
    ];
    $data_user_products = array_merge($data_user_products,$_POST['user_stocks']);
    $db->insert('user_stocks',$data_user_products);

    set_flash_msg(['success'=>'Stok berhasil ditambah']);
    header('location:index.php?r=products/index');
}

return [
    'data' => $data,
    'table' => $table
];