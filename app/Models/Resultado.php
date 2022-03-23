<?php

namespace App\Models;

use App\Http\Requests\StoreResultadoRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Resultado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'arquivo',
        'concurso_id',
    ];

    public function concurso()
    {
        return $this->belongsTo(Concurso::class, 'concurso_id');
    }

    public function setAtributes(StoreResultadoRequest $request, Concurso $concurso) {
        $this->nome = $request->input('nome');
        $this->concurso_id = $concurso->id;
    }

    public function salvarAnexo($file) {
        if($this->arquivo != null) {
            if (Storage::disk()->exists($this->arquivo) && $file != null) {
                Storage::delete('public/'.$this->arquivo);
            }
        }

        if($file != null){
            $path = 'concursos/' .$this->concurso->id. '/resultados/' . $this->id . "/";
            $nome = $file->getClientOriginalName();
            Storage::putFileAs('public/'. $path, $file, $nome);
            $this->arquivo = $path . $nome;
        }
        $this->update();
    }

    public function deletar() {
        if ($this->arquivo != null && Storage::disk()->exists('public/'.$this->arquivo)) {
            Storage::delete('public/'.$this->arquivo);
        }

        $this->delete();
    }
}
