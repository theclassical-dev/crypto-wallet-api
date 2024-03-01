<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = ['phone', 'password'];

    public function wallet(){
        return $this->hasMany(Wallet::class);
    }

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }

}
