<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContatoRequest;
use App\Models\Contato;
use App\Models\Numero;
use Illuminate\Http\Request;

class ContatoController extends Controller
{
    public function __construct(Contato $contato, Numero $numero)
    {
        $this->middleware('jwt.auth', ['except' => ['login']]);
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
        return response()->json($this->contato->with(['numeros', 'grupo', 'user'])->get(), 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContatoRequest $request)
    {
        //dd($request->all());
        //return $request;

        //validando
        
        //$request->validate($this->contato->rules(), $this->contato->feedback()); 

        return $request;
        /*
        //criando contato
        $contato = $this->contato->fill($request->data);
        $contato->user_id = auth()->user()->id;
        $contato->save();
        
        //salvando numeros referente a cada contato
        foreach($request->data['numero_telefone'] as $numero){
            $this->numero->create([
                'contato_id' => $contato->id,
                'numero_telefone' => $numero
            ]);
        }
        return response()->json(['cadastrado' => 'Contato adicionado com sucesso!'], 201);
        */
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contato = $this->contato->with(['numeros', 'grupo'])->find($id);

        if($contato === null){
            return response()->json(['erro' => 'Contato não encontrado!'], 404);
        }

        return response()->json(['contato' => $contato], 200);
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
        $contato = $this->contato->find($id);
        if($contato === null){
            return response()->json(['erro' => 'Contato não encontrado!'], 404);
        }

        if($request->method() === 'PATCH'){
            $regrasDinamicas = array();
            foreach ($contato->rules() as $input => $regra) {
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas);
        }else{
            $request->validate($contato->rules());
        }

        if($request->numero_telefone){
            $this->numero->where('contato_id', $id)
            ->where('id', $request->numero_telefone_id)
            ->update(['numero_telefone' => $request->numero_telefone]);
        }

        $contato->fill($request->all());
        $contato->save();

        return response()->json(['atualizado' => 'Contato atualizado com sucesso'], 200);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contato = $this->contato->find($id);

        if($contato === null){
            return response()->json(['erro' => 'Contato não encontrado!']);
        }
        $this->numero->where('contato_id', $id)->delete();
        $contato->delete();
    }
}
