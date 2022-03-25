<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResultadoRequest;
use App\Http\Requests\UpdateResultadoRequest;
use App\Models\Concurso;
use App\Models\Resultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResultadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $concurso = Concurso::find($id);
        $this->authorize('isDonoDoConcurso', $concurso);
        $resultados = $concurso->resultados()->orderBy('created_at')->get();
        
        return view('resultado.index', compact('concurso', 'resultados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $concurso = Concurso::find($id);
        $this->authorize('isDonoDoConcurso', $concurso);

        return view('resultado.create', compact('concurso'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResultadoRequest $request, Concurso $concurso)
    {
        $this->authorize('isDonoDoConcurso', $concurso);

        $request->validated();
        $resultado = new Resultado();
        $resultado->setAtributes($request, $concurso);
        $resultado->save();
        $resultado->salvarAnexo($request->arquivo);
        
        return redirect(route('resultados.index', ['concurso' => $concurso]))->with(['success' => "Resultado publicado com sucesso!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resultado  $resultado
     * @return \Illuminate\Http\Response
     */
    public function show(Resultado $resultado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resultado  $resultado
     * @return \Illuminate\Http\Response
     */
    public function edit(Resultado $resultado)
    {
        $concurso = Concurso::find($resultado->concurso->id);
        $this->authorize('isDonoDoConcurso', $concurso);
       
        return view('resultado.edit', compact('resultado', 'concurso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resultado  $resultado
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResultadoRequest $request, Resultado $resultado)
    {
        $concurso = Concurso::find($resultado->concurso->id);
        $this->authorize('isDonoDoConcurso', $concurso);

        $request->validated();
        $concurso = $resultado->concurso;
        $resultado->nome = $request->input('nome');
        $resultado->update();
        $resultado->salvarAnexo($request->arquivo);

        return redirect(route('resultados.index', ['concurso' => $concurso]))->with(['success' => "Resultado atualizado com sucesso!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resultado  $resultado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resultado $resultado)
    {
        $concurso = $resultado->concurso;
        $this->authorize('isDonoDoConcurso', $concurso);

        $resultado->deletar();

        return redirect(route('resultados.index', ['concurso' => $concurso]))->with(['success' => "Resultado deletado com sucesso!"]);
    }

    /**
     * Get the specified file from storage.
     *
     * @param  \App\Models\Resultado  $resultado
     * @return \Illuminate\Http\Response
     */
    public function anexo(Resultado $resultado) 
    {
        if ($resultado->arquivo != null && Storage::disk()->exists('public/'.$resultado->arquivo)) {
            return response()->file("storage/".$resultado->arquivo);
        }

        return abort(404);
    }
}
