<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends User
{
    use HasFactory;

    protected $table = "users";

    public function setRoleAttribute()
    {
        $this->attributes["role"] = "customer";
    }
}
