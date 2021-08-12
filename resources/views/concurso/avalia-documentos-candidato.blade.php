@extends('templates.template-principal')
@section('content')
<div class="container" style="margin-top: 5rem; margin-bottom: 8rem;">
    <div class="form-row justify-content-center">
        <div class="@if($inscricao->concurso->users_id == auth()->user()->id) col-md-10 @elseif($inscricao->concurso->chefeDaBanca()->where('chefe', true)->first() != null && $inscricao->concurso->chefeDaBanca()->where('chefe', true)->first()->id == auth()->user()->id) col-md-6 @endif" style="margin-bottom: 2rem;">
            <div class="card shadow bg-white style_card_container">
                <div class="card-header d-flex justify-content-between bg-white" id="style_card_container_header">
                    <h6 class="style_card_container_header_titulo">Etapa - Prova de Títulos</h6>
                    <div class="form-group">
                        @if($inscricao->concurso->users_id == auth()->user()->id)
                            <a class="btn btn-primary" href="{{route('envio.documentos.inscricao', $inscricao->id)}}" style="margin-top: 10px;">Enviar documentos</a>
                        @endif
                        @if (!$arquivos)
                            <button class="btn btn-danger" style="margin-top: 10px;" disabled>
                                <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px"> Nenhum documento enviado
                            </button>
                        @else
                            <a class="btn btn-primary" href="{{route('baixar.documentos.candidato', $inscricao->id)}}" style="margin-top: 10px;">
                                <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px"> Baixar documentos
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="row">
                            <div class="col-md-12" style="margin-top: 5px;">
                                <div class="alert alert-success" role="alert">
                                    <p>{{session('success')}}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6 class="style_titulo_documento">
                                    Documentos Pessoais
                                </h6>
                                @if (!$arquivos || !$arquivos->dados_pessoais)
                                    <div class="d-flex justify-content-left">
                                        <div>
                                            <a class="btn btn-primary">
                                                <div class="btn-group">
                                                    <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px">
                                                    <h6 style="margin-left: 10px; margin-top:5px; color:#fff">Baixar</h6>
                                                </div>
                                            </a>
                                        </div>
                                        <div style="margin-left:10px">
                                            <h6 style="color: red">Documento ainda <br>não foi enviado.</h6>
                                        </div>
                                    </div>
                                @else
                                    <a class="btn btn-primary" href="{{route('visualizar.arquivo', ['arquivo' => $arquivos->id, 'cod' => "Dados-pessoais"])}}" target="_new">
                                        <div class="btn-group">
                                            <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px">
                                            <h6 style="margin-left: 10px; margin-top:5px; color:#fff">Baixar</h6>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <h6 class="style_titulo_documento">
                                    Curriculum vitae modelo Lattes
                                </h6>
                                @if (!$arquivos || !$arquivos->curriculum_vitae_lattes)
                                    <div class="d-flex justify-content-left">
                                        <div>
                                            <a class="btn btn-primary">
                                                <div class="btn-group">
                                                    <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px">
                                                    <h6 style="margin-left: 10px; margin-top:5px; color:#fff">Baixar</h6>
                                                </div>
                                            </a>
                                        </div>
                                        <div style="margin-left:10px">
                                            <h6 style="color: red">Documento ainda <br>não foi enviado.</h6>
                                        </div>
                                    </div>
                                @else
                                    <a class="btn btn-primary" href="{{route('visualizar.arquivo', ['arquivo' => $arquivos->id, 'cod' => "Lattes"])}}" target="_new">
                                        <div class="btn-group">
                                            <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px">
                                            <h6 style="margin-left: 10px; margin-top:5px; color:#fff">Baixar</h6>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <h6 class="style_titulo_documento" style="color: black; margin-top: 5px;">
                                Documentos a serem pontuados na tabela de avaliação de títulos
                            </h6>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6 class="style_titulo_documento">
                                    Grupo I - Formação Acadêmica
                                </h6>
                                @if (!$arquivos || !$arquivos->formacao_academica)
                                    <div class="d-flex justify-content-left">
                                        <div>
                                            <a class="btn btn-primary">
                                                <div class="btn-group">
                                                    <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px">
                                                    <h6 style="margin-left: 10px; margin-top:5px; color:#fff">Baixar</h6>
                                                </div>
                                            </a>
                                        </div>
                                        <div style="margin-left:10px">
                                            <h6 style="color: red">Documento ainda <br>não foi enviado.</h6>
                                        </div>
                                    </div>
                                @else
                                    <a class="btn btn-primary" href="{{route('visualizar.arquivo', ['arquivo' => $arquivos->id, 'cod' => "Formacao-academica"])}}" target="_new">
                                        <div class="btn-group">
                                            <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px">
                                            <h6 style="margin-left: 10px; margin-top:5px; color:#fff">Baixar</h6>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12" style="margin-top: 5px">
                            <div class="form-group">
                                <h6 class="style_titulo_documento">
                                    Grupo II - Experiência Didática
                                </h6>
                                @if (!$arquivos || !$arquivos->experiencia_didatica)
                                    <div class="d-flex justify-content-left">
                                        <div>
                                            <a class="btn btn-primary">
                                                <div class="btn-group">
                                                    <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px">
                                                    <h6 style="margin-left: 10px; margin-top:5px; color:#fff">Baixar</h6>
                                                </div>
                                            </a>
                                        </div>
                                        <div style="margin-left:10px">
                                            <h6 style="color: red">Documento ainda <br>não foi enviado.</h6>
                                        </div>
                                    </div>
                                @else
                                    <a class="btn btn-primary" href="{{route('visualizar.arquivo', ['arquivo' => $arquivos->id, 'cod' => "Experiencia-didatica"])}}" target="_new">
                                        <div class="btn-group">
                                            <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px">
                                            <h6 style="margin-left: 10px; margin-top:5px; color:#fff">Baixar</h6>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12" style="margin-top: 5px">
                            <div class="form-group">
                                <h6 class="style_titulo_documento">
                                    Grupo III - Produção Científica
                                </h6>
                                @if (!$arquivos || !$arquivos->producao_cientifica)
                                    <div class="d-flex justify-content-left">
                                        <div>
                                            <a class="btn btn-primary">
                                                <div class="btn-group">
                                                    <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px">
                                                    <h6 style="margin-left: 10px; margin-top:5px; color:#fff">Baixar</h6>
                                                </div>
                                            </a>
                                        </div>
                                        <div style="margin-left:10px">
                                            <h6 style="color: red">Documento ainda <br>não foi enviado.</h6>
                                        </div>
                                    </div>
                                @else
                                    <a class="btn btn-primary" href="{{route('visualizar.arquivo', ['arquivo' => $arquivos->id, 'cod' => "Producao-cientifica"])}}" target="_new">
                                        <div class="btn-group">
                                            <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px">
                                            <h6 style="margin-left: 10px; margin-top:5px; color:#fff">Baixar</h6>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12" style="margin-top: 5px">
                            <div class="form-group">
                                <h6 class="style_titulo_documento">
                                    Grupo IV - Experiência Profissional
                                </h6>
                                @if (!$arquivos || !$arquivos->experiencia_profissional)
                                    <div class="d-flex justify-content-left">
                                        <div>
                                            <a class="btn btn-primary">
                                                <div class="btn-group">
                                                    <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px">
                                                    <h6 style="margin-left: 10px; margin-top:5px; color:#fff">Baixar</h6>
                                                </div>
                                            </a>
                                        </div>
                                        <div style="margin-left:10px">
                                            <h6 style="color: red">Documento ainda <br>não foi enviado.</h6>
                                        </div>
                                    </div>
                                @else
                                    <a class="btn btn-primary" href="{{route('visualizar.arquivo', ['arquivo' => $arquivos->id, 'cod' => "Experiencia-profissional"])}}" target="_new">
                                        <div class="btn-group">
                                            <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px">
                                            <h6 style="margin-left: 10px; margin-top:5px; color:#fff">Baixar</h6>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow bg-white style_card_container">
                <div class="card-header-without-line d-flex justify-content-between bg-white" id="style_card_container_header">
                    <h6 class="style_card_container_header_titulo">Pontuação</h6>
                </div>
                <div class="card-body">
                    <div>
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <a href="{{route('baixar.anexo', ['name'=> 'Ficha_de_avaliacao.docx'])}}"  class="btn btn-success"
                                    target="_blank" style="color:white;">Baixar Ficha de avaliação</a>
                            </div>
                        </div>
                        @if (!$arquivos)
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong> Só é possível enviar a pontuação quando os arquivos estiverem disponíveis.</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @else
                            @if (date('Y-m-d', strtotime(now())) >= $inscricao->concurso->data_fim_envio_doc && 
                                    date('Y-m-d', strtotime(now())) <= $inscricao->concurso->data_resultado_selecao)
                                <form method="POST" action="{{ route('avalia.documentos.inscricao', $arquivos->inscricoes_id) }}" enctype="multipart/form-data">
                            @else
                                <form>
                            @endif
                                @csrf
                                <div class="form-row">
                                    <div class="col-md-12">
                                        @if($inscricao->avaliacao && $inscricao->avaliacao->ficha_avaliacao)
                                            <a class="btn btn-primary" href="{{route('visualizar.ficha-avaliacao', $inscricao->avaliacao->id)}}" target="_new">
                                                <div class="btn-group">
                                                    <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px">
                                                    <h6 style="margin-left: 10px; margin-top:5px; color:#fff">Arquivo de pontuação</h6>
                                                </div>
                                            </a>
                                        @endif
                                    </div>
                                    @if($inscricao->concurso->chefeDaBanca()->where('chefe', true)->first() != null && $inscricao->concurso->chefeDaBanca()->where('chefe', true)->first()->id == auth()->user()->id)
                                        @if (date('Y-m-d', strtotime(now())) >= $inscricao->concurso->data_fim_envio_doc && 
                                                    date('Y-m-d', strtotime(now())) <= $inscricao->concurso->data_resultado_selecao)
                                            <div class="col-md-12" style="margin-top: 10px;">
                                                <label for="ficha_avaliacao" class="form-label style_campo_titulo">Inserir pontuação da ficha de avaliação (Ex: 10 ou 10.5, etc)</label>
                                                <input type="file" accept=".pdf" class="form-control form-control-sm @error('ficha_avaliacao') is-invalid @enderror"
                                                    id="ficha_avaliacao" style="margin-left:-10px;margin-bottom:1rem; border:0px solid #fff"
                                                    name="ficha_avaliacao" @if ($inscricao->avaliacao && !$inscricao->avaliacao->ficha_avaliacao) required @endif/>
                                                @error('ficha_avaliacao')
                                                    <span style="color: red">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @endif
                                    @endif
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="col-md-12 form-group">
                                                <label for="nota" class="style_campo_titulo">Pontuação total</label>
                                                <input type="number" step=any id="nota" name="nota" min="0" max="100"
                                                        class="form-control style_campo" placeholder="Digite a pontuação do candidato"
                                                    @if ($inscricao->avaliacao && !$inscricao->avaliacao->nota)
                                                        required
                                                    @endif
                                                    @if($inscricao->concurso->users_id == auth()->user()->id || $inscricao->concurso->chefeDaBanca()->where([['users_id', auth()->user()->id], ['chefe', false]])->get()->count() > 0)
                                                        disabled
                                                    @endif
                                                    @if ($inscricao->avaliacao)
                                                        value="{{ $inscricao->avaliacao->nota }}"/>
                                                    @else
                                                        value="{{ old('nota') }}"/>
                                                    @endif
                                            </div>
                                        </div>
                                        @if($inscricao->concurso->chefeDaBanca()->where('chefe', true)->first() != null && $inscricao->concurso->chefeDaBanca()->where('chefe', true)->first()->id == auth()->user()->id)
                                            @if (date('Y-m-d', strtotime(now())) >= $inscricao->concurso->data_fim_envio_doc && 
                                                    date('Y-m-d', strtotime(now())) <= $inscricao->concurso->data_resultado_selecao)
                                                <div class="form-row justify-content-center">
                                                    <div class="col-md-12"><hr></div>
                                                    <div class="col-md-6 form-group" style="margin-bottom: 2.5px;">
                                                        <button type="submit" class="btn btn-success shadow-sm" style="width: 100%;" id="submeterFormBotao">Enviar</button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("input").change(function(){
        if(this.files[0].size > 2097152){
            alert("O arquivo deve ter no máximo 2MB!");
            this.value = "";
        };
    });
</script>
@endsection
