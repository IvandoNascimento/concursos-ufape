<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arquivo;
use App\Models\Avaliacao;
use App\Models\Concurso;
use App\Models\Inscricao;
use App\Models\User;
use App\Notifications\EnvioDocumentosNotification;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use ZipArchive;

class ArquivoController extends Controller
{
    public function store(Request $request)
    {
        $arquivos = Arquivo::where('inscricoes_id', $request->inscricao)->first();
        $inscricao = Inscricao::find($request->inscricao);
        //$this->authorize('enviarDocumentos', $inscricao);

        if($inscricao->concurso->tipo == Concurso::TIPO_ENUM['efetivo']){
            Validator::make($request->all(), [
                'avaliacao_perfil' => 'file|mimes:pdf|max:2048',
            ], Arquivo::$efetivo_mensagem)->validate();

            if(!$arquivos){
                $arquivo = new Arquivo();
                $arquivo->avaliacao_perfil = $this->saveDocument($inscricao->concurso->id, $request->inscricao, $request->avaliacao_perfil, 'avaliacao_perfil.pdf');
                $arquivo->inscricoes_id = $request->inscricao;
                $arquivo->save();
            }else{
                if ($request->avaliacao_perfil) {
                    Storage::delete('public/' . $arquivos->avaliacao_perfil);
                    $arquivos->avaliacao_perfil = $this->saveDocument($inscricao->concurso->id, $request->inscricao, $request->avaliacao_perfil, 'avaliacao_perfil.pdf');
                }
                $arquivos->update();
            }
            if (auth()->user()->role == "candidato") {
                Notification::send(auth()->user(), new EnvioDocumentosNotification(auth()->user(), true));
            }
            
            if (auth()->user()->role == "chefeSetorConcursos" || auth()->user()->role == "admin") {
                return redirect(route('avalia.documentos.inscricao', $inscricao->id))->with(['success' => 'Documento enviado com sucesso.']);
            }else{
                return redirect(route('candidato.index'))->with('success', 'Seu documento foi enviado com sucesso.');
            }
        }

        if (!$arquivos) {
            Validator::make($request->all(), Arquivo::$rules, Arquivo::$messages)->validate();
        } else {
            Validator::make($request->all(), [
                'dados_pessoais'           => 'nullable|file|mimes:pdf|max:2048',
                'curriculum_vitae_lattes'  => 'nullable|file|mimes:pdf|max:2048',
                'formacao_academica'       => 'nullable|file|mimes:pdf|max:2048',
                'experiencia_didatica'     => 'nullable|file|mimes:pdf|max:2048',
                'producao_cientifica'      => 'nullable|file|mimes:pdf|max:2048',
                'experiencia_profissional' => 'nullable|file|mimes:pdf|max:2048',
            ], Arquivo::$messages)->validate();
        }

        $concurso = $inscricao->concurso;

        $path = 'concursos/' . $concurso->id . '/inscricoes/' . $request->inscricao . '/';
        $experiencia_didatica_arquivo = true;
        $producao_cientifica_arquivo = true;
        $experiencia_profissiona_arquivo = true;

        if (!$arquivos) {
            $this->saveDocument($concurso->id, $request->inscricao, $request->dados_pessoais, 'dados_pessoais.pdf');
            $this->saveDocument($concurso->id, $request->inscricao, $request->curriculum_vitae_lattes, 'curriculum_vitae_lattes.pdf');
            $this->saveDocument($concurso->id, $request->inscricao, $request->formacao_academica, 'formacao_academica.pdf');

            if ($request->experiencia_didatica) {
                $this->saveDocument($concurso->id, $request->inscricao, $request->experiencia_didatica, 'experiencia_didatica.pdf');
            } else {
                $experiencia_didatica_arquivo = false;
            }

            if ($request->producao_cientifica) {
                $this->saveDocument($concurso->id, $request->inscricao, $request->producao_cientifica, 'producao_cientifica.pdf');
            } else {
                $producao_cientifica_arquivo = false;
            }

            if ($request->experiencia_profissional) {
                $this->saveDocument($concurso->id, $request->inscricao, $request->experiencia_profissional, 'experiencia_profissional.pdf');
            } else {
                $experiencia_profissiona_arquivo = false;
            }

            $arquivo = new Arquivo();
            $arquivo->dados_pessoais = $path . 'dados_pessoais.pdf';
            $arquivo->curriculum_vitae_lattes =  $path . 'curriculum_vitae_lattes.pdf';
            $arquivo->formacao_academica = $path . 'formacao_academica.pdf';
            $arquivo->experiencia_didatica = $experiencia_didatica_arquivo ? $path . 'experiencia_didatica.pdf' : null;
            $arquivo->producao_cientifica = $producao_cientifica_arquivo ? $path . 'producao_cientifica.pdf' : null;
            $arquivo->experiencia_profissional = $experiencia_profissiona_arquivo ? $path . 'experiencia_profissional.pdf' : null;
            $arquivo->inscricoes_id = $request->inscricao;
            $arquivo->save();

            if (auth()->user()->role == "candidato") {
                Notification::send(auth()->user(), new EnvioDocumentosNotification(auth()->user(), false));
            }
        } else {
            if ($request->dados_pessoais) {
                Storage::delete('public/' . $arquivos->dados_pessoais);
                $arquivos->dados_pessoais = $this->saveDocument($concurso->id, $request->inscricao, $request->dados_pessoais, 'dados_pessoais.pdf');
            }

            if ($request->curriculum_vitae_lattes) {
                Storage::delete('public/' . $arquivos->curriculum_vitae_lattes);
                $arquivos->curriculum_vitae_lattes = $this->saveDocument($concurso->id, $request->inscricao, $request->curriculum_vitae_lattes, 'curriculum_vitae_lattes.pdf');
            }

            if ($request->formacao_academica) {
                Storage::delete('public/' . $arquivos->formacao_academica);
                $arquivos->formacao_academica = $this->saveDocument($concurso->id, $request->inscricao, $request->formacao_academica, 'formacao_academica.pdf');
            }

            if ($request->experiencia_didatica && $arquivos->experiencia_didatica) {
                Storage::delete('public/' . $arquivos->experiencia_didatica);
                $arquivos->experiencia_didatica = $this->saveDocument($concurso->id, $request->inscricao, $request->experiencia_didatica, 'experiencia_didatica.pdf');
            } else if ($request->experiencia_didatica) {
                $arquivos->experiencia_didatica = $this->saveDocument($concurso->id, $request->inscricao, $request->experiencia_didatica, 'experiencia_didatica.pdf');
            }

            if ($request->producao_cientifica && $arquivos->producao_cientifica) {
                Storage::delete('public/' . $arquivos->producao_cientifica);
                $arquivos->producao_cientifica = $this->saveDocument($concurso->id, $request->inscricao, $request->producao_cientifica, 'producao_cientifica.pdf');
            } else if ($request->producao_cientifica) {
                $arquivos->producao_cientifica = $this->saveDocument($concurso->id, $request->inscricao, $request->producao_cientifica, 'producao_cientifica.pdf');
            }

            if ($request->experiencia_profissional && $arquivos->experiencia_profissional) {
                Storage::delete('public/' . $arquivos->experiencia_profissional);
                $arquivos->experiencia_profissional = $this->saveDocument($concurso->id, $request->inscricao, $request->experiencia_profissional, 'experiencia_profissional.pdf');
            } else if ($request->experiencia_profissional) {
                $arquivos->experiencia_profissional = $this->saveDocument($concurso->id, $request->inscricao, $request->experiencia_profissional, 'experiencia_profissional.pdf');
            }

            $arquivos->update();

            if (auth()->user()->role == "candidato") {
                Notification::send(auth()->user(), new EnvioDocumentosNotification(auth()->user(), true));
            }
        }

        if (auth()->user()->role == "chefeSetorConcursos" || auth()->user()->role == "admin") {
            return redirect(route('avalia.documentos.inscricao', $inscricao->id))->with(['success' => 'Documentos enviados com sucesso.']);
        }

        return redirect(route('candidato.index'))->with('success', 'Seus documentos foram enviados
                e serão examinados pela banca avaliadora.');
    }

    public function show($arquivo, $cod)
    {
        $arquivos = Arquivo::find($arquivo);
        $this->authorize('view', $arquivos);

        switch ($cod) {
            case "Dados-pessoais":
                return Storage::disk()->exists('public/' . $arquivos->dados_pessoais) ? response()->file('storage/' . $arquivos->dados_pessoais) : abort(404);
                break;
            case "Lattes":
                return Storage::disk()->exists('public/' . $arquivos->curriculum_vitae_lattes) ? response()->file('storage/' . $arquivos->curriculum_vitae_lattes) : abort(404);
                break;
            case "Formacao-academica":
                return Storage::disk()->exists('public/' . $arquivos->formacao_academica) ? response()->file('storage/' . $arquivos->formacao_academica) : abort(404);
                break;
            case "Experiencia-didatica":
                return Storage::disk()->exists('public/' . $arquivos->experiencia_didatica) && $arquivos->experiencia_didatica != null ? response()->file('storage/' . $arquivos->experiencia_didatica) : abort(404);
                break;
            case "Producao-cientifica":
                return Storage::disk()->exists('public/' . $arquivos->producao_cientifica) && $arquivos->producao_cientifica != null ? response()->file('storage/' . $arquivos->producao_cientifica) : abort(404);
                break;
            case "Experiencia-profissional":
                return Storage::disk()->exists('public/' . $arquivos->experiencia_profissional) && $arquivos->experiencia_profissional != null ? response()->file('storage/' . $arquivos->experiencia_profissional) : abort(404);
                break;
            case "Avaliacao-perfil":
                return Storage::disk()->exists('public/' . $arquivos->avaliacao_perfil) && $arquivos->avaliacao_perfil != null ? response()->file('storage/' . $arquivos->avaliacao_perfil) : abort(404);
                break;
            default:
                return abort(404);
                break;
        }
        return abort(404);
    }

    public function downloadDocumentosCandidato($id)
    {
        $arquivos = Arquivo::where('inscricoes_id', $id)->first();
        $this->authorize('view', $arquivos);

        $nomeCandidato = $arquivos->inscricao->user->nome . ' ' . $arquivos->inscricao->user->sobrenome;

        $filename = $nomeCandidato.'.zip';
        $zip = new ZipArchive();
        $zip->open(storage_path('app'. DIRECTORY_SEPARATOR . $filename), ZipArchive::CREATE);
        $path = 'app'. DIRECTORY_SEPARATOR .'public' . DIRECTORY_SEPARATOR . 'concursos' . DIRECTORY_SEPARATOR . $arquivos->inscricao->concursos_id . DIRECTORY_SEPARATOR . 'inscricoes' . DIRECTORY_SEPARATOR . $id;


        $files = File::files(storage_path($path));
        foreach($files as $file){
            if (!$file->isDir()) {
                $relativeName = basename($file);
                $zip->addFile($file, $relativeName);
            }
        }
        $zip->close();
        //return response()->download(storage_path('app'. DIRECTORY_SEPARATOR . $filename));
        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="'.basename(storage_path('app'. DIRECTORY_SEPARATOR . $filename)).'"');
        header("Content-length: " . filesize(storage_path('app'. DIRECTORY_SEPARATOR . $filename)));
        header("Pragma: no-cache");
        header("Expires: 0");

        ob_clean();
        flush();

        readfile(storage_path('app'. DIRECTORY_SEPARATOR . $filename));

        ignore_user_abort(true);
        unlink(storage_path('app'. DIRECTORY_SEPARATOR . $filename));
        exit();
    }

    public function downloadDocumentosTodosCandidatos(Request $request)
    {
        $concurso = Concurso::find($request->concurso_id);
        $this->authorize('viewCandidatos', $concurso);
        $inscricoes = Inscricao::where('concursos_id', $request->concurso_id)->get();
        if(auth()->user()->role == User::ROLE_ENUM['presidenteBancaExaminadora']){
            $membroBanca = auth()->user()->membroBancaExaminadora->whereIn('vaga_id', $concurso->vagas->pluck('id')->toArray());
            $inscricoes = $inscricoes->whereIn('vagas_id', $membroBanca->pluck('vaga_id')->toArray());
        }
        $filename = 'Documentos dos Candidatos.zip';
        $zip = new ZipArchive();
        $zip->open(storage_path('app'. DIRECTORY_SEPARATOR . $filename), ZipArchive::CREATE);

        $temArquivo = false;

        foreach($inscricoes as $inscricao){
            $arquivos = Arquivo::where('inscricoes_id', $inscricao->id)->first();

            if(isset($arquivos)){
                $temArquivo = true;
                $nomeCandidato = $arquivos->inscricao->user->nome . ' ' . $arquivos->inscricao->user->sobrenome . ' - ' . $arquivos->inscricoes_id;
                $path = 'app'. DIRECTORY_SEPARATOR .'public' . DIRECTORY_SEPARATOR . 'concursos' . DIRECTORY_SEPARATOR . $arquivos->inscricao->concursos_id . DIRECTORY_SEPARATOR . 'inscricoes' . DIRECTORY_SEPARATOR . $inscricao->id;

                $zip->addEmptyDir($nomeCandidato);
                $files = File::files(storage_path($path));
                foreach($files as $file){
                    if (!$file->isDir()) {
                        $relativeName = basename($file);
                        $zip->addFile($file, $nomeCandidato.'/'.$relativeName);
                    }
                }
            }
        }

        $zip->close();
        if(!$temArquivo){
            return redirect()->back()->withErrors(['error' => 'Não há documentos submetidos ainda.']);
        }
        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="'.basename(storage_path('app'. DIRECTORY_SEPARATOR . $filename)).'"');
        header("Content-length: " . filesize(storage_path('app'. DIRECTORY_SEPARATOR . $filename)));
        header("Pragma: no-cache");
        header("Expires: 0");

        ob_clean();
        flush();

        readfile(storage_path('app'. DIRECTORY_SEPARATOR . $filename));

        ignore_user_abort(true);
        unlink(storage_path('app'. DIRECTORY_SEPARATOR . $filename));
        exit();
    }

    public function showFichaAvaliacao($avaliacao)
    {
        $avaliacao = Avaliacao::find($avaliacao);
        return response()->file('storage/' . $avaliacao->ficha_avaliacao);
    }

    public function downloadFichaAvaliacao($name)
    {
        $file = public_path() . "/anexo/" . $name;
        $headers = array('Content-Type: application/docx',);
        return Response::download($file, 'modelo_ficha_avaliacao.docx', $headers);
    }

    private function saveDocument($IDConcurso, $IDinscricao, $arquivo, $nome)
    {
        $path = 'concursos/' . $IDConcurso . '/inscricoes/' . $IDinscricao . '/';
        Storage::putFileAs('public/' . $path, $arquivo, $nome);
        return $path . $nome;
    }
}
