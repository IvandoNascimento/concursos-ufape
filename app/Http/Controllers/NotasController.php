<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concurso;
use App\Models\NotaDeTexto;
use App\Http\Requests\NotaDeTestoStoreRequest;
use Illuminate\Support\Facades\Storage;

class NotasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $concurso = Concurso::find($id);
        $this->authorize('operacoesNotasDeTexto', $concurso);
        $notas = $concurso->notas()->orderBy('created_at')->get();

        return view('notas.index', compact('concurso', 'notas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $concurso = Concurso::find($id);
        $this->authorize('operacoesNotasDeTexto', $concurso);

        return view('notas.create', compact('concurso'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotaDeTestoStoreRequest $request, $id)
    {
        $concurso = Concurso::find($id);
        $this->authorize('operacoesNotasDeTexto', $concurso);

        $request->validated();
        $nota = new NotaDeTexto();
        $nota->setAtributes($request, $concurso);
        $nota->save();
        $nota->salvarAnexo($request);

        return redirect(route('notas.index', ['concurso' => $id]))->with(['mensage' => "Nota de texto criada com sucesso!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nota_id, $concurso_id)
    {
        $nota = NotaDeTexto::find($nota_id);
        $this->authorize('update', $nota);
        $concurso = Concurso::find($concurso_id);
        $this->authorize('operacoesNotasDeTexto', $concurso);

        return view('notas.edit', compact('nota', 'concurso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NotaDeTestoStoreRequest $request, $id)
    {
        $nota = NotaDeTexto::find($id);
        $this->authorize('update', $nota);

        $request->validated();
        $concurso = $nota->concurso;
        $nota->setAtributes($request, $concurso);
        $nota->update();
        $nota->salvarAnexo($request);

        return redirect(route('notas.index', ['concurso' => $concurso->id]))->with(['mensage' => "Nota de texto salva com sucesso!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nota = NotaDeTexto::find($id);
        $this->authorize('delete', $nota);

        $concurso = $nota->concurso;
        $nota->deletar();

        return redirect(route('notas.index', ['concurso' => $concurso->id]))->with(['mensage' => "Nota de texto deletada com sucesso!"]);
    }

    public function anexo($id)
    {
        $nota = NotaDeTexto::find($id);

        if ($nota->anexo != null && Storage::disk()->exists($nota->anexo)) {
            return response()->file(storage_path('app/'.$nota->anexo));
        }

        return abort(404);
    }

    public function get(Request $request) {
        $concurso = Concurso::find($request->concurso_id);

        if ($concurso != null) {
            $notas = $concurso->notas;

            if ($notas->count() > 0) {
                return response()->json($notas);
            }

            return abort(404);
        }

        return abort(404);
    }
}
