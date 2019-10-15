# Innerent Acl Module

This package is a superset of [spatie/laravel-permission](https://github.com/spatie/laravel-permission). It adds some cool features to that already amazing package.

You can use just like the  [original package documentation](https://docs.spatie.be/laravel-permission/v3/introduction/)

## Main New Feature

### Permissions Migrate

In the configuration file, is possible to list all system available permissions with groups and it's actions. Plus set an administrator to get access to all permissions without restriction.


### Role Label and Type

Roles can receive a descriptive label and a "type" to make it friendly and flexible.

## Installation

Install from composer
```
composer require innerent/acl
```

Run migrations
```
php artisan migration
```

Publish the configuration files
```
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"

php artisan vendor:publish --provider="Innerent\Acl\Providers\AclServiceProvider" --tag="config"
```


## Configuration

#### Super admin user setup

Identify a super admin to be used on permissions migration.
This user will be updated every time a the migration command is executed, to get all permissions

```
// acl.php

'admin' => [
    'class' => \Innerent\People\Models\User::class,
    
    'username_field' => 'email',
    
    'username' => 'admin@email.com',
],
```

#### Default actions

This list of actions will be attached to all permissions listed below if that isn't defined as "strict"

```
// acl.php

'default_actions' => ['create', 'read', 'update', 'destroy'],
```

#### List of permissions

List all system permissions you want to create.

Permissions can be only a string, then it will be created only with the default actions.
Like the "role" permission below, will be created actually four permissions for it:
"role_create", "role_read", "role_update" and "role_destroy"

You can create more actions to a specific permission by adding this like a index on
the permissions array, then another array inside named "actions".
The "post" permission in the example below will create four permissions just like
the "role" plus another two: "post_deactivate" and "post_publish"

If by any reason you dont want a permission to be created with the default actions,
just add a second parameter on the intern array. Check the "user" permission below.
Only "user_deactivate" and "user_edit" will be created.

```
// acl.php

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
```
