<?php

$conn = conn();
$db   = new Database($conn);

$roles = $db->all('user_roles',[
    'role_id' => 3 // kios
]);

$roles = array_map(function($role) use ($db){
    $role->user = $db->single('users',[
        'id' => $role->user_id
    ]);
    return $role;
}, $roles);

return compact('roles');