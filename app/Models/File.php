<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_format',
        'file_path',
        'owner',
        'table_relation',
        'relation_id',
        'width',
        'height',
    ];

    public function info(){
        return $this->hasMany(FileInfo::class,'id','id');
    }
}
