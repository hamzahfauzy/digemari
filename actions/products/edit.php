<?php

$table = 'products';
$conn = conn();
$db   = new Database($conn);

$data = $db->single($table,[
    'id' => $_GET['id']
]);

$data->user_product = $db->single('user_products',[
    'user_id' => auth()->user->id,
    'product_id' => $data->id,
]);

if(request() == 'POST')
{
    $_POST[$table]['pic_url'] = $data->pic_url;
    if(isset($_FILES['file']) && !empty($_FILES['file']['name']))
    {
        $ext  = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $name = strtotime('now').'.'.$ext;
        $file = 'uploads/employees/'.$name;
        copy($_FILES['file']['tmp_name'],$file);
        $_POST[$table]['pic_url'] = $file;
    }

    $db->update($table,$_POST[$table],[
        'id' => $_GET['id']
    ]);
    
    set_flash_msg(['success'=>'Produk berhasil diupdate']);
    header('location:index.php?r=products/index');
}

return [
    'data' => $data,
    'table' => $table
];