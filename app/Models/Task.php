<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Task extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'nome',
        'descricao',
        'finalizado',
        'data_limite',
    ];
    protected $casts = [
        'finalizado' => 'boolean',
        'data_limite' => 'datetime',
    ];
}
