

# Installation
1. Install latest version of laravel
```sh
    larevl new app-name
    laravel starter kits
    cd app-name
    composer run dev
    php artisan install:api
```

# configuration
2. configure laravel application [routes/api/auth.php]
```sh
    php artisan make:controller Api/AuthController
```

# Other library dependencies
3. Install laravel permission, cloudinary and scrable api docs
```sh
    # Roles
    composer require spatie/laravel-permission
    php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
    # Storage
    composer require cloudinary-labs/cloudinary-laravel
    # Docs
    composer require dedoc/scramble
    # Logs
    composer require opcodesio/log-viewer 
    # pdf
    

```


## Simple terminal commands
````sh

    php artisan make:model Department -mcrR --api
    php artisan make:resource DepartmentResource

```