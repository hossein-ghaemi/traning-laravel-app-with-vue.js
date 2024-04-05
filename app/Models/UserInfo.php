<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    protected $fillable =['user_id','profile','info'];


    private function info()
    {
        return $this->hasOne(Role::class, 'user_id');
    }
}
