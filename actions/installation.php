<?php

if(request() == 'POST')
{
    $conn  = conn();
    $db    = new Database($conn);

    // save application installation
    $db->insert('application',$_POST['app']);

    // create user login
    $_POST['users']['name'] = "Admin ".$_POST['app']['name'];
    $_POST['users']['password'] = md5($_POST['users']['password']);
    $user = $db->insert('users',$_POST['users']);

    // create roles
    $role = $db->insert('roles',[
        'name' => 'administrator'
    ]);

    // assign role to user
    $db->insert('user_roles',[
        'user_id' => $user->id,
        'role_id' => $role->id
    ]);

    // create roles route
    $db->insert('role_routes',[
        'role_id' => $role->id,
        'route_path' => '*'
    ]);

    $additional_roles = [
        'distributor','kios'
    ];

    $additional_routes = [
        'default/*','products/index',
        'products/update-price','transactions/*'
    ];

    foreach($additional_roles as $name)
    {
        $role = $db->insert('roles',[
            'name' => $name
        ]);

        foreach($additional_routes as $route)
        {
            $db->insert('role_routes',[
                'role_id' => $role->id,
                'route_path' => $route
            ]);
        }
    }

    $role = $db->insert('roles',[
        'name' => 'agronomis'
    ]);
    $db->insert('role_routes',[
        'role_id' => $role->id,
        'route_path' => 'default/index'
    ]);

    set_flash_msg(['success'=>'Instalasi Berhasil']);
    header('location:index.php?r=auth/login');
    die();

}