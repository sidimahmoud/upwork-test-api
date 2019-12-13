<?php

namespace App\Modules\Users;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    //use PaginationTrait;
    use HasApiTokens, Notifiable;
    protected $table = 'users';
    const TYPE = [
        'ADMIN' => 1,
        'AGENT' => 2,
    ];
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'username',
        'gender',
        'mobile',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
