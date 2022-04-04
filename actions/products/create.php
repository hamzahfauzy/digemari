<?php

$table = 'products';

if(request() == 'POST')
{
    $conn = conn();
    $db   = new Database($conn);

    $_POST[$table]['pic_url'] = 'assets/img/default-product-image.png';
    if(isset($_FILES['file']) && !empty($_FILES['file']['name']))
    {
        $ext  = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $name = strtotime('now').'.'.$ext;
        $file = 'uploads/products/'.$name;
        copy($_FILES['file']['tmp_name'],$file);
        $_POST[$table]['pic_url'] = $file;
    }

    $product = $db->insert($table,$_POST[$table]);

    $data_user_products = [
        'user_id' => auth()->user->id,
        'product_id' => $product->id,
    ];

    $db->insert('user_products',array_merge($data_user_products,[
        'price' => 0
    ]));
    $db->insert('user_stocks',array_merge($data_user_products,[
        'amount' => 0
    ]));

    set_flash_msg(['success'=>'Product berhasil ditambahkan']);
    header('location:index.php?r=products/index');
}

return compact('table');