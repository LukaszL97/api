<?php

namespace App\Models;
use DB;
use http\Env\Request;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends Model implements Authenticatable
{
    use HasFactory, HasApiTokens, AuthenticableTrait;


    protected $primaryKey = 'id_user';
    protected $fillable = ['password'];

}
