<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Numero;
use App\Models\Grupo;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class Contato extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'email', 'endereco'];

    public function rules(){
        return [
            'nome' => 'required',
            'numero_telefone' => 'required',
            'email' => 'email'
        ];
    }

    public function feedback(){
        return [
            'nome.required' => 'Preencha o campo nome',
            'numero_telefone.required' => 'Insira um número de telefone',
            'email.email' => 'Insira um email válido'
        ];
    }

    public function numeros(){
        return $this->hasOne(Numero::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


}
