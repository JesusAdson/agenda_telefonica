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
    protected $fillable = ['nome', 'email', 'endereco', 'grupo_id'];

    public function rules(){
        return [
            'nome' => 'required',
            'numero_telefone' => 'required',
        ];
    }

    public function feedback(){
        return [
            'nome.required' => 'Preencha o campo nome',
            'numero_telefone.required' => 'Insira ao menos um número de telefone'
        ];
    }

    public function numeros(){
        return $this->hasMany(Numero::class);
    }

    public function grupo(){
        return $this->belongsTo(Grupo::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


}
