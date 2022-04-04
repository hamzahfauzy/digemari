<?php

$table = 'transactions';
$conn = conn();
$db   = new Database($conn);
$success_msg = get_flash_msg('success');
$user_id = auth()->user->id;
$id   = $_GET['id'];

$transaction = $db->single('transactions',[
    'id' => $id
]);

if($user_id != $transaction->user_to_id)
{
    header('location:index.php?r=transactions/index');
    die();
}

$db->update('transactions',[
    'status' => 1
],[
    'id' => $id
]);

$items = $db->all('transaction_items',[
    'transaction_id' => $id
]);

if($transaction->user_from_id)
{
    foreach($items as $item)
    {
        $db->insert('user_stocks',[
            'user_id' => $transaction->user_from_id,
            'product_id' => $item->product_id,
            'amount' => $item->qty,
        ]);
    }
}

set_flash_msg(['success'=>'Transaksi berhasil di konfirmasi']);
header('location:index.php?r=transactions/index');
die();