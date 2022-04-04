<?php

$conn = conn();
$db   = new Database($conn);

$products = [];
$roles = [];

if(is_role('distributor',auth()->user->id))
{
    if(request() == 'POST')
    {
        $transaction = $db->insert('transactions',[
            'user_from_id' => auth()->user->id,
            'user_to_id' => 1,
            'status'     => 0,
            'total'      => 0,
        ]);

        $total = 0;
        foreach($_POST['transaction_items'] as $product_id => $qty)
        {
            if($qty == 0) continue;
            $user_product = $db->single('user_products',[
                'product_id' => $product_id,
                'user_id'    => 1 // factory user
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
                'user_id'    => 1 // factory user
            ]);


            $total += $subtotal;
        }

        $db->update('transactions',[
            'total' => $total
        ],[
            'id' => $transaction->id
        ]);

        set_flash_msg(['success'=>'Order berhasil buat']);
        header('location:index.php?r=transactions/view&id='.$transaction->id);
        die();
    }

    $products = $db->all('products');
    $products = array_map(function($product) use ($db) {
        $product->price = $db->single('user_products',[
            'product_id' => $product->id,
            'user_id'    => 1 // factory user
        ]);

        $db->query = "SELECT SUM(amount) as total FROM user_stocks WHERE product_id=$product->id AND user_id = 1";
        $product->stock = $db->exec('single');

        return $product;
    }, $products);
}
else if(is_role('kios',auth()->user->id))
{
    if(request() == 'POST')
    {
        $transaction = $db->insert('transactions',[
            'user_from_id' => auth()->user->id,
            'user_to_id' => $_POST['transactions']['user_to_id'],
            'status'     => 0,
            'total'      => 0,
        ]);

        $total = 0;
        foreach($_POST['transaction_items'] as $product_id => $qty)
        {
            if($qty == 0) continue;
            $user_product = $db->single('user_products',[
                'product_id' => $product_id,
                'user_id'    => $_POST['transactions']['user_to_id'] // factory user
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
                'user_id'    => $_POST['transactions']['user_to_id'] // factory user
            ]);


            $total += $subtotal;
        }

        $db->update('transactions',[
            'total' => $total
        ],[
            'id' => $transaction->id
        ]);

        set_flash_msg(['success'=>'Order berhasil buat']);
        header('location:index.php?r=transactions/view&id='.$transaction->id);
        die();
    }

    if(isset($_GET['user_to_id']) && $_GET['user_to_id'])
    {
        $products = $db->all('products');
        $products = array_map(function($product) use ($db) {
            $product->price = $db->single('user_products',[
                'product_id' => $product->id,
                'user_id'    => $_GET['user_to_id']
            ]);
    
            $db->query = "SELECT SUM(amount) as total FROM user_stocks WHERE product_id=$product->id AND user_id = $_GET[user_to_id]";
            $product->stock = $db->exec('single');
    
            return $product;
        }, $products);
    }

    $roles = $db->all('user_roles',[
        'role_id' => 2 // distributor
    ]);

    $roles = array_map(function($role) use ($db){
        $role->user = $db->single('users',[
            'id' => $role->user_id
        ]);
        return $role;
    }, $roles);
}

return compact('products','roles');