<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_done'
    ];

    // カラムの型を指定 キャストする
    protected $casts = [
        'is_done' => 'bool'
    ];
}
