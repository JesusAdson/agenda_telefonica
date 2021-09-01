<?php

namespace App\Http\Controllers;

use App\Models\Numero;
use App\Models\Contato;
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
    public function index(Request $request)
    {
        //dd(auth()->user()->id);
       
        if($request->has('nome')){
            return response()->json($this->contato
            ->with('numeros')
            ->where('nome', 'LIKE', '%'.$request->nome.'%')
            ->get(), 200
    );
        }
        if($request->has('id')){
            return response()->json($this->contato
            ->with('numeros')
            ->where('id', $request->id)
            ->get(), 200
    );
    if($request->has('nome') && $request->has('id')){
        return response()->json($this->contato
        ->with('numeros')
        ->where('user_id', auth()->user()->id)
        ->where('nome', 'LIKE', '%'.$request->nome.'%')
        ->where('id', $request->id)
        ->get(), 200
);
    }
        }
        return response()->json($this->contato
        ->with('numeros')
        ->where('user_id', auth()->user()->id)
        ->orderBy('nome', 'ASC')
        ->paginate(2), 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->contato->rules(), $this->contato->feedback());
        //criando contato
        $contato = $this->contato->fill($request->all());
        $contato->user_id = auth()->user()->id;
        $contato->save();
        
        //salvando numeros referente a cada contato
        $this->numero->create([
            'contato_id' => $contato->id,
            'numero_telefone' => $request->numero_telefone
        ]);
        return response()->json($contato, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contato = $this->contato->with('numeros')->find($id);

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
        //dd($request->all() , $id);
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
            return response()->json(['erro' => 'Contato não encontrado!', 404]);
        }
        $this->numero->where('contato_id', $id)->delete();
        $contato->delete();

        return response()->json(['sucesso' => 'Contato removido com sucesso']);
    }
}
