<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

// Add this line to import the Str class

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'f_name',
        'l_name',
        'role_id',
        'email',
        'phone_number',
        'password',
    ];

    protected $appends = ['info', 'profile', 'alerts'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function createToken($name, array $abilities = ['*'])
    {
        return $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(80)),
            'abilities' => $abilities,
        ]);
    }


    public function getInfoAttribute()
    {
        return $this->hasOne(UserInfo::class, 'id')->select( 'info')->first();
    }



    public function files(){
        return $this->hasMany(File::class,'owner','id');
    }

    public function getProfileAttribute(){
        return $this->hasOne(File::class,'relation_id','id')->where('table_relation','users')->orderByDesc('id')->get();
    }

    public function getAlertsAttribute(){
        return $this->hasMany(Alert::class,'user_id','id');
    }
}
