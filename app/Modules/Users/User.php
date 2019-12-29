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

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'address',
        'zip_code',
        'user_image',
    ];

}
