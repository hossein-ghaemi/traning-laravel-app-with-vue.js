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
        'relational_table',
        'relation_id',
        'data'
    ];
}
