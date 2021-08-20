<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $table = 'tasks';
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'status',


    ];

    public static function updateOrCreate(array $array, array $array1)
    {
    }

    public static function find($id)
    {
    }

}
