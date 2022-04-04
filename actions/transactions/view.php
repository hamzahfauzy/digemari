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

$subject_id = $transaction->user_from_id;
$transaction->tipe = 'Jual';
if($user_id == $transaction->user_from_id)
{
    $subject_id = $transaction->user_to_id;
    $transaction->tipe = 'Beli';
}

$transaction->subject = $db->single('users',[
    'id' => $subject_id,
]);

$items = $db->all('transaction_items',[
    'transaction_id' => $transaction->id
]);

$items = array_map(function($item) use ($db){
    $item->product = $db->single('products',[
        'id' => $item->product_id
    ]);
    return $item;
},$items);

$transaction->items = $items;

return compact('transaction','success_msg');