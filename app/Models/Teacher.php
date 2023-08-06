<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends User
{
    use HasFactory, HasApiTokens, Notifiable;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        static::addGlobalScope(function (Builder $builder) {
            $builder->where("role", "teacher");
        });
        static::creating(function ($query) {
            $query->role = "teacher";
            $query->password = $query->password ?? Hash::make($query->email);
        });
    }

    protected $table = "users";
    protected $fillable = [
        "code",
        "name",
        "gender",
        "phone",
        "email",
        "password",
        "extra_information",
        "avatar",
        "address",
        "role",
        "birthday"
    ];
    protected $hidden = [
        "password",
        "remember_token",
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        "extra_information" => 'array',
    ];
}
