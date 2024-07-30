<?php

namespace App;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clients extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = "clients";
    protected $fillable = [
        'active',
        'cpf',
        'email',
        'name',
        'slug',
        'whatsapp',
        'password',
        'image'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}