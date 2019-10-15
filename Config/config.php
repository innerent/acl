<?php

return [
    'name' => 'Acl',


    /* ---------------------------------------------------------------------------------------
     | Super admin user setup
     | ---------------------------------------------------------------------------------------
     | Identify a super admin to be used on permissions migration.
     | This user will be updated every time a the migration command is executed, to get all permissions
     |
     */
    'admin' => [
        'class' => \Innerent\People\Models\User::class,

        'username_field' => 'email',

        'username' => 'admin@email.com',
    ],

    /* ---------------------------------------------------------------------------------------
     | Default actions
     | ---------------------------------------------------------------------------------------
     | This list of actions will be attached to all permissions listed below if that isn't
     | defined as "strict"
     |
     */
    'default_actions' => ['create', 'read', 'update', 'destroy'],

    /* ---------------------------------------------------------------------------------------
     | List of permissions
     | ---------------------------------------------------------------------------------------
     | List all system permissions you want to create.
     |
     | Permissions can be only a string, then it will be created only with the default actions.
     | Like the "role" permission below, will be created actually four permissions for it:
     | "role_create", "role_read", "role_update" and "role_destroy"
     |
     | You can create more actions to a specific permission by adding this like a index on
     | the permissions array, then another array inside named "actions".
     | The "post" permission in the example below will create four permissions just like
     | the "role" plus another two: "post_deactivate" and "post_publish"
     |
     | If by any reason you dont want a permission to be created with the default actions,
     | just add a second parameter on the intern array. Check the "user" permission below.
     | Only "user_deactivate" and "user_edit" will be created.
     |
     | Obs.: The permissions below are just examples and can be replaced freely
     */
    'permissions' => [
        'role',
        'post' => [
            'actions' => ['deactivate', 'publish']
        ],
        'user' => [
            'actions' => ['deactivate', 'edit'],
            'strict' => true
        ],
        'plan',
        'owner',
        'contract',
        'renter',
        'property',
    ],
];
