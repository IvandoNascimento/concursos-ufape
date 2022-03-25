<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DocumentoExtra extends Model
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

    public function salvarAnexo($file, $nomeArquivo) {
        if($this->arquivo != null) {
            if (Storage::disk()->exists($this->arquivo) && $file != null) {
                Storage::delete('public/'.$this->arquivo);
            }
        }

        if($file != null){
            $path = 'concursos/' .$this->concurso->id. '/docsextras/';
            $nome = $file->getClientOriginalName();
            $nome = $nomeArquivo . $file->getClientOriginalExtension();
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
