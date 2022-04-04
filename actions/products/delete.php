<?php

$table = 'products';
$conn = conn();
$db   = new Database($conn);

$db->delete($table,[
    'id' => $_GET['id']
]);

set_flash_msg(['success'=>'Produk berhasil dihapus']);
header('location:index.php?r=products/index');
die();