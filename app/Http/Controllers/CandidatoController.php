<?php

namespace App\Http\Controllers;

use App\Models\Arquivo;
use App\Models\Candidato;
use App\Models\Inscricao;
use App\Models\Concurso;
use App\Models\OpcoesVagas;
use App\Models\User;
use App\Http\Requests\StoreInscricaoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ConfirmarInscricaoNotification;

class CandidatoController extends Controller
{
    public function showEnvioDocumentos($id)
    {
        $arquivos = Arquivo::where('inscricoes_id', $id)->first();
        $inscricao = Inscricao::find($id);
        $this->authorize('showDocumentos', $inscricao);

        return view('candidato.envio-documentos')->with([
            'inscricao' => $inscricao,
            'arquivos' => $arquivos
        ]);
    }

    public function index()
    {
        $inscricoes = Inscricao::select('inscricoes.*')
        ->join('users','inscricoes.users_id','=','users.id')
        ->join('concursos', 'inscricoes.concursos_id', '=', 'concursos.id')
        ->where('inscricoes.users_id', auth()->user()->id)
        ->whereIn('concursos.tipo', [Concurso::TIPO_ENUM['substituto']])
        ->get();

        $inscricoesEfetivo = Inscricao::select('inscricoes.*')
        ->join('users','inscricoes.users_id','=','users.id')
        ->join('concursos', 'inscricoes.concursos_id', '=', 'concursos.id')
        ->where('inscricoes.users_id', auth()->user()->id)
        ->whereIn('concursos.tipo', [Concurso::TIPO_ENUM['efetivo']])
        ->get();

        return view('candidato.index', compact('inscricoes', 'inscricoesEfetivo'));
    }

    public function show($id)
    {
        $inscricao = Inscricao::find($id);
        $this->authorize('view', $inscricao);

        return view('candidato.show')->with([
            'inscricao' => $inscricao,
        ]);
    }

    public function inscreverseConcurso($id)
    {
        $concurso = Concurso::find($id);
        $this->authorize('create', Inscricao::class);
        $vagas = $concurso->vagas;

        $candidato = Candidato::where('users_id', Auth::user()->id)->first();

        return view('candidato.inscricao', compact('vagas', 'candidato'));
    }

    public function saveInscricao(StoreInscricaoRequest $request)
    {
        $request->validated();
        $this->authorize('create', Inscricao::class);
        $vagas = OpcoesVagas::find($request->vaga);

        if (!$vagas) {
            return redirect()->back()->with('vagas', 'Selecione uma vaga valida')->withInput();
        }

        $inscricao = new Inscricao();
        $inscricao->status = "Aguardando pagamento";
        $inscricao->cotista = $request->cotista;
        $inscricao->pcd = $request->pcd;
        $inscricao->solicitou_isencao = $request->desejo_isencao == "on";
        $inscricao->users_id = Auth::user()->id;
        $inscricao->concursos_id = $vagas->concursos_id;
        $inscricao->vagas_id = $vagas->id;
        $inscricao->save();

        Notification::send(auth()->user(), new ConfirmarInscricaoNotification($inscricao));

        return redirect()->route('candidato.index')->with('success', 'Sua inscrição foi realizada com sucesso');
    }

    public function storeInscricaoChefe(StoreInscricaoRequest $request)
    {
        $request->validated();

        $vaga = OpcoesVagas::find($request->vaga);
        $this->authorize('createInscricaoChefeConcurso', $vaga->concurso);
        if (!$vaga) {
            return redirect()->back()->with('vagas', 'Selecione uma vaga valida')->withInput();
        }

        $user = User::find($request->user_id);
        $inscricao = $user->inscricoes()->where('concursos_id', $request->concurso_id)->first();
        if ($inscricao != null) {
            return redirect()->back()->withErrors(['user' => 'Já existe uma inscrição para esse candidato.']);
        }

        $inscricao = new Inscricao();
        $inscricao->status = "Aguardando pagamento";
        $inscricao->cotista = $request->cotista;
        $inscricao->pcd = $request->pcd;
        $inscricao->solicitou_isencao = $request->desejo_isencao == "on";
        $inscricao->users_id = $user->id;
        $inscricao->concursos_id = $vaga->concursos_id;
        $inscricao->vagas_id = $vaga->id;
        $inscricao->save();

        Notification::send($user, new ConfirmarInscricaoNotification($inscricao));

        return redirect(route('inscricao.chefe.concurso', $request->concurso_id))->with(['success' => 'Inscrição realizada com sucesso.']);
    }
}
