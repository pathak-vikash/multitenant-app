<?php

namespace App;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use UsesTenantConnection;


    public function posts(){
        return $this->hasMany("App\Post");
    }
}
