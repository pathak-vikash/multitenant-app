# Multi-Tenancy Architecture in Laravel
--------------------------------------------

## Perquisite

### Install Package
```
composer require hyn/multi-tenant
```
### Publish configuration
```
php artisan vendor:publish –-tag=tenancy
```
## Migration

### System Database
```
php artisan migrate --database=system
```

**NOTE**: In case you are getting issue with uuid length, add this line inside your .env file.
```
LIMIT_UUID_LENGTH_32=true
```

### Tenant Database

#### Create Migration
```
php artisan make:migration create_posts_table --path=database/migrations/tenant
```
#### Run Migration
```
php artisan tenancy:migrate
```

#### Other Options
```
php artisan tenancy -h
```

## Demo

### Connect site
[http://localhost:8000/domain1.demo.app/connect](http://localhost:8000/domain1.demo.app/connect)


### List Post
[http://localhost:8000/domain1.demo.app/posts](http://localhost:8000/domain1.demo.app/posts)

### Create Post
[http://localhost:8000/domain1.demo.app/posts/create](http://localhost:8000/domain1.demo.app/posts/create)