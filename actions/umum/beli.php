<?php

$conn = conn();
$db   = new Database($conn);

if(request() == 'POST')
{
    $transaction = $db->insert('transactions',[
        'user_to_id' => $_GET['id'],
        'status'     => 0,
        'total'      => 0,
    ]);

    $total = 0;
    foreach($_POST['transaction_items'] as $product_id => $qty)
    {
        if($qty == 0) continue;
        $user_product = $db->single('user_products',[
            'product_id' => $product_id,
            'user_id'    => $_GET['id'] // factory user
        ]);

        $subtotal = $qty*$user_product->price;
        $db->insert('transaction_items',[
            'transaction_id' => $transaction->id,
            'product_id' => $product_id,
            'qty' => $qty,
            'subtotal' => $subtotal,
        ]);

        $db->insert('user_stocks',[
            'amount' => $qty*-1,
            'product_id' => $product_id,
            'user_id'    => $_GET['id'] // factory user
        ]);


        $total += $subtotal;
    }

    $db->update('transactions',[
        'total' => $total
    ],[
        'id' => $transaction->id
    ]);

    set_flash_msg(['success'=>'Pesanan berhasil buat']);
    header('location:index.php?r=umum/view&id='.$transaction->id);
    die();
}

$products = $db->all('products');
$products = array_map(function($product) use ($db) {
    $product->price = $db->single('user_products',[
        'product_id' => $product->id,
        'user_id'    => $_GET['id']
    ]);

    $db->query = "SELECT SUM(amount) as total FROM user_stocks WHERE product_id=$product->id AND user_id = $_GET[id]";
    $product->stock = $db->exec('single');

    return $product;
}, $products);

return compact('products');