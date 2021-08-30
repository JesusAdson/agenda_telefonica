<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Numero extends Model
{
    use HasFactory;
    protected $fillable = ['contato_id', 'numero_telefone'];
    protected $casts = ['numero_telefone' => 'array'];
}
