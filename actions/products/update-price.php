<?php

$table = 'products';
$conn = conn();
$db   = new Database($conn);

$data = $db->single($table,[
    'id' => $_GET['id']
]);

$data_user_products = [
    'user_id' => auth()->user->id,
    'product_id' => $data->id,
];

$data->user_product = $db->single('user_products',$data_user_products);

if(request() == 'POST')
{
    if($data->user_product)
        $db->update('user_products',$_POST['user_products'],$data_user_products);
    else
        $db->insert('user_products',array_merge($_POST['user_products'],$data_user_products));

    set_flash_msg(['success'=>'Harga berhasil diupdate']);
    header('location:index.php?r=products/index');
}

return [
    'data' => $data,
    'table' => $table
];