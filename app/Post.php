<?php

namespace App;
use Hyn\Tenancy\Traits\UsesTenantConnection;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use UsesTenantConnection;

    public function author(){
        return $this->belongsTo("App\Author");
    }
}
