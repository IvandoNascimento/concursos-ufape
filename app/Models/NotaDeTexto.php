<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\NotaDeTestoStoreRequest;
use App\Models\Concurso;
use Illuminate\Support\Facades\Storage;

class NotaDeTexto extends Model
{
    use HasFactory;

    public const ENUM_TIPO = [
        "aviso" => 1,
        "notificacao" => 2,
        "resultado" => 3,
    ];

    protected $fillable = [
        'titulo',
        'texto',
        'tipo',
        'cor',
        'anexo',
    ];

    public function concurso() {
        return $this->belongsTo(Concurso::class, 'concursos_id');
    }

    public function setAtributes(NotaDeTestoStoreRequest $request, Concurso $concurso) {
        $this->titulo = $request->input('título');
        $this->texto = $request->texto_da_nota;
        $this->tipo = $request->tipo;
        $this->cor = $request->cor_do_fundo_da_nota;
        $this->concursos_id = $concurso->id;
    }

    public function salvarAnexo(NotaDeTestoStoreRequest $request) {
        if ($request->anexo != null) {
            $path = 'concursos/' . $this->concurso->id . '/notas/' . $this->id . "/";
            $nome = 'anexo.' . $request->file('anexo')->getClientOriginalExtension();
            Storage::putFileAs($path, $request->anexo, $nome);
            $this->anexo = $path . $nome;
        }

        $this->update();
    }

    public function deletar() {
        if ($this->anexo != null && Storage::disk()->exists($this->anexo)) {
            Storage::delete($this->anexo);
        }

        $this->delete();
    }
}
