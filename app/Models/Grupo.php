<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contato;
use Illuminate\Support\Facades\DB;


class Grupo extends Model
{
    use HasFactory;
    protected $fillable = ['descricao'];

    public function rules(){
        return [
            'descricao' => 'required',
        ];
    }

    public function feedback(){
        return [
            'descricao.required' => 'O campo descrição é obrigatório'
        ];
    }

    public function contatos(){
        return $this->hasMany(Contato::class);
    }

    
}
