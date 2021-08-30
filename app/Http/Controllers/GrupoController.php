<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Contato;
use App\Models\Numero;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function __construct(Grupo $grupo, Contato $contato, Numero $numero)
    {
        $this->middleware('jwt.auth');
        $this->grupo = $grupo;
        $this->contato = $contato;
        $this->numero = $numero;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->grupo->with('contatos')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->grupo->rules(), $this->grupo->feedback());
        $this->grupo->create([
            'descricao' => $request->descricao
        ]);

        return response()->json(['sucesso' => 'Grupo cadastrado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->grupo->rules(), $this->grupo->feedback());
        $this->grupo->update([
            'descricao' => $request->descricao
        ]);

        return response()->json(['sucesso' => 'Grupo atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grupo = $this->grupo->find($id);
        if($grupo === null){
            return response()->json(['erro' => 'Grupo não existe!']);
        }

        //traz todos os contatos referente ao grupo
        $contato = $this->contato->where('grupo_id', $id)->get();

        //exclui os numeros referente ao contato
        foreach($contato as $ctt){
            $this->numero->where('contato_id', $ctt->id)->delete();
        }
        
        //exclui os contatos referentes ao grupo
        $this->contato->where('grupo_id', $id)->delete();

        

        //por fim exclui o grupo
        $grupo->delete();

        return response()->json(['excluido' => 'Grupo excluido com sucesso!']);
    }
}
