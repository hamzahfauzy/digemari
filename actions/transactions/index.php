<?php

$table = 'transactions';
$conn = conn();
$db   = new Database($conn);
$success_msg = get_flash_msg('success');
$user_id = auth()->user->id;

$db->query = "SELECT * FROM transactions WHERE user_from_id = $user_id OR user_to_id = $user_id ORDER BY id DESC";
$data = $db->exec('all');

$data = array_map(function($d) use ($db,$user_id){
    $subject_id = $d->user_from_id;
    $d->tipe = 'Jual';
    if($user_id == $d->user_from_id)
    {
        $subject_id = $d->user_to_id;
        $d->tipe = 'Beli';
    }
    
    $d->subject = $db->single('users',[
        'id' => $subject_id,
    ]);

    return $d;
},$data);

return [
    'datas' => $data,
    'table' => $table,
    'success_msg' => $success_msg
];