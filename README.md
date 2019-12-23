# Multi-Tenancy Architecture in Laravel

## Perquisite

### Version Info
```
PHP 7.3.3
Laravel Framework 6.9.0
```

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


## Automatically Environment Detection
When you connect and run your application with that domain | subdomain it will automatically detect & set the environment as per that. You don't need to define middleware in that case.

Example

```
# Connect site
http://localhost:8000/vcap.me/connect

# Create Posts for that domain
http://vcap.me:8000/posts/create

# Get Posts
http://vcap.me:8000/posts
```

Note: Available virtualhosts pointed to 127.0.0.1 `vcap.me|localtest.me|beweb.com|yoogle.com|ortkut.com|feacebook.com`
more...
http://www.fidian.com/programming/public-dns-pointing-to-localhost


## Links

[Package Documentation](https://tenancy.dev/docs/hyn/5.3/requirements)
[Package Source](https://github.com/tenancy/multi-tenant)