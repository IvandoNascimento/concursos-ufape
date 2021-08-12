<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConcursoController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ArquivoController;
use App\Http\Controllers\NotasController;
use App\Http\Controllers\Controller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('index');

Route::get('/sobre', function () {
    return view('about');
})->name('about');

Route::get('/dashboard', function () {
    return redirect(route('index'));
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/user-password-edit', [ProfileController::class, 'showPassword'])->name('user.password.edit');
});

Route::middleware(['auth:sanctum', 'verified', 'CheckUserAdmin'])->group(function () {
    Route::resource('user', AdminController::class);
});

Route::middleware(['auth:sanctum', 'verified', 'CheckUserCandidato'])->group(function () {

    Route::resource('candidato', CandidatoController::class);

    Route::get('/user-profile-edit', [ProfileController::class, 'showProfileInfo'])->name('user.profile.edit');

    Route::post('/user-profile-update', [ProfileController::class, 'updateProfileInfo'])->name('user.profile.update');

    Route::get('/inscricao/concurso/{concurso_id}', [CandidatoController::class, 'inscreverseConcurso'])
        ->name('inscricao.concurso');

    Route::post('/save-inscricao', [CandidatoController::class, 'saveInscricao'])
        ->name('save.inscricao');

});

Route::get('/envio-documentos/inscricao/{inscricao_id}', [CandidatoController::class, 'showEnvioDocumentos'])
        ->name('envio.documentos.inscricao')->middleware('auth');
Route::post('/save-documentos', [ArquivoController::class, 'store'])
        ->name('documentos.store')->middleware('auth');

Route::middleware(['auth:sanctum', 'verified', 'CheckUserChefeConcurso'])->group(function () {
    Route::get('/candidato/inscricao/{inscricao_id}', [ConcursoController::class, 'inscricaoCandidato'])
        ->name('candidato.inscricao');

    Route::post('/aprovar-reprovar-candidato/inscricao/{inscricao_id}', [ConcursoController::class, 'aprovarReprovarCandidato'])
        ->name('aprovar-reprovar-candidato.inscricao');
});

Route::middleware(['auth:sanctum', 'verified', 'CheckUserPresidenteBanca'])->group(function () {

    Route::get('/candidatos/concurso/{concurso_id}', [ConcursoController::class, 'showCandidatosPresidenteBanca'])
        ->name('candidatos.concurso');

    Route::get('/avalia-documentos/inscricao/{inscricao_id}', [ConcursoController::class, 'avaliarDocumentosCandidato'])
        ->name('avalia.documentos.inscricao');

    Route::post('/avalia-documentos/inscricao/{inscricao_id}', [ConcursoController::class, 'savePontuacaoDocumentosCandidato'])
        ->name('avalia.documentos.inscricao');

    Route::get('/concurso/resultado/{concurso_id}', [ConcursoController::class, 'showResultadoFinal'])
        ->name('concurso.resultado');
});

Route::middleware(['auth:sanctum', 'verified', 'CheckUserIsNotCandadidato'])->group(function () {
    Route::get('/show-candidatos/concurso/{concurso_id}', [ConcursoController::class, 'showCandidatos'])
        ->name('show.candidatos.concurso');

    Route::get("/anexo/{name}", [ArquivoController::class, 'downloadFichaAvaliacao'])->name('baixar.anexo');

    Route::get('/baixar-documentos/inscricao/{inscricao_id}', [ArquivoController::class, 'downloadDocumentosCandidato'])
        ->name('baixar.documentos.candidato');

    Route::get('/baixar-documentos-todos-candidatos/concurso/{concurso_id}', [ArquivoController::class, 'downloadDocumentosTodosCandidatos'])
        ->name('baixar.documentos.todos.candidatos');
});

Route::get('/adicionar-usuario/banca/{user}/{concurso}', [ConcursoController::class, 'AdicionarUserBanca'])->name('concurso.adicionar.banca')->middleware('auth');
Route::get('/remover-usuario/banca/{user}/{concurso}', [ConcursoController::class, 'RemoverUserBanca'])->name('concurso.remover.banca')->middleware('auth');
Route::resource('concurso', ConcursoController::class);

Route::get('/visualizar-arquivo/{arquivo}/{cod}', [ArquivoController::class, 'show'])->name('visualizar.arquivo')->middleware('auth');
Route::get('/visualizar-ficha-avaliacao/{arquivo}', [ArquivoController::class, 'showFichaAvaliacao'])
    ->name('visualizar.ficha-avaliacao')->middleware('auth');
Route::get('/{concurso}/usuarios-banca-examinadora', [AdminController::class, 'usuarioDeBanca'])->name('users.listar.banca')->middleware('auth');
Route::post('/cadastrar-usuario-banca/{concurso}', [AdminController::class, 'createUserBanca'])->name('user.create.banca')->middleware('auth');
Route::post('/definir-presidente-da-banca', [AdminController::class, 'definirPresidente'])->name('user.presidente.banca')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/inscrever-candidato/{concurso}', [ConcursoController::class, 'indexInscraoChefeConcurso'])->name('inscricao.chefe.concurso');
    Route::get('/inscrever-candidato/{concurso}/{user}', [ConcursoController::class, 'inscreverCandidato'])->name('inscrever.candidato');
    Route::post('/inscrever-candidato/save', [CandidatoController::class, 'storeInscricaoChefe'])->name('save.inscricao.chefe');

    Route::get('/notas/{concurso}', [NotasController::class, 'index'])->name('notas.index');
    Route::get('/notas/{concurso}/criar', [NotasController::class, 'create'])->name('notas.create');
    Route::post('/notas/{concurso}/salvar', [NotasController::class, 'store'])->name('notas.store');
    Route::get('/notas/{nota}/editar/{concurso}', [NotasController::class, 'edit'])->name('notas.edit');
    Route::put('/notas/{nota}/atualizar', [NotasController::class, 'update'])->name('notas.update');
    Route::delete('/notas/{nota}/deletar', [NotasController::class, 'destroy'])->name('notas.destroy');
});
Route::get('/notas/{nota}/anexo', [NotasController::class, 'anexo'])->name('notas.anexo');
Route::get('/notas-do-concurso', [NotasController::class, 'get'])->name('notas.get');
Route::get('/error/403', [Controller::class, 'unauthorized']);
