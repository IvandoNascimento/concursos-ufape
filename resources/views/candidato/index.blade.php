@extends('templates.template-principal')
@section('content')
<div class="container" style="margin-top: 5rem; margin-bottom: 10rem;">
    <div class="form-row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow bg-white style_card_container">
                <div class="card-header d-flex justify-content-between bg-white" id="style_card_container_header">
                    <h6 class="style_card_container_header_titulo">Minhas Inscrições</h6>
                </div>
                @if(session('success'))
                    <div class="row">
                        <div class="col-md-12" style="margin-top: 5px;">
                            <div class="alert alert-success" role="alert">
                                <p>{{session('success')}}</p>
                            </div>
                        </div>
                    </div>
                @endif
                @if($inscricoes->count() > 0)
                    <div class="card-body">
                        <table class="table table-bordered table-hover tabela_container">
                            <thead>
                                <tr>
                                    <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 50%;">Concurso</th>
                                    <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 30%;">Vaga</th>
                                    <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">Pagamento</th>
                                    <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">Inscrição</th>
                                    <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">Prova de títulos</th>
                                    <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inscricoes as $inscricao)
                                    <tr>
                                        <td id="tabela_container_linha">{{ mb_strimwidth($inscricao->concurso->titulo, 0, 38, "...") }}</td>
                                        <td id="tabela_container_linha">{{ mb_strimwidth($inscricao->vaga->nome, 0, 20, "...") }}</td>
                                        <td id="tabela_container_linha">
                                            @if ($inscricao->status == "aprovado")
                                                Aprovado
                                            @else 
                                                <a target="_black" href="http://consulta.tesouro.fazenda.gov.br/gru_novosite/gru_simples.asp">
                                                    Gerar Boleto
                                                </a>
                                            @endif
                                        </td>
                                        <td id="tabela_container_linha">
                                            @if ($inscricao->status == "aprovado")
                                                Deferida
                                            @elseif($inscricao->status == "reprovado") 
                                                Indeferida
                                            @endif
                                        </td>
                                        <td id="tabela_container_linha">
                                            @if ($inscricao->arquivos != null)
                                                Em análise
                                            @else 
                                                Não enviado
                                            @endif
                                        </td>
                                        <td id="tabela_container_linha" style="text-align: center;">
                                            <div class="btn-group">
                                                <a class="btn btn-primary" style="margin-left: 5px; border-radius: 4px;" href="{{ route('candidato.show', $inscricao->id) }}">
                                                    <img src="{{ asset('img/icon_visualizar.svg') }}" alt="Visualizar concurso" width="26px" >
                                                </a>
                                                @if ($inscricao->concurso->data_inicio_envio_doc <= now() && $inscricao->status == "aprovado")
                                                    <a class="btn btn-primary" style="margin-left: 5px; border-radius: 4px;" href="{{ route('envio.documentos.inscricao', $inscricao->id) }}">
                                                        <img src="{{ asset('img/icon_enviar.svg') }}" alt="Enviar documentos" width="26px" >
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($inscricoesEfetivo->count() > 0)
                    <div class="card-body">
                        <table class="table table-bordered table-hover tabela_container">
                            <thead>
                                <tr>
                                    <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 50%;">Concurso</th>
                                    <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 30%;">Vaga</th>
                                    <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">Pagamento</th>
                                    <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">Inscrição</th>
                                    <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">Avaliação de Perfil</th>
                                    <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inscricoesEfetivo as $inscricao)
                                    <tr>
                                        <td id="tabela_container_linha">{{ mb_strimwidth($inscricao->concurso->titulo, 0, 38, "...") }}</td>
                                        <td id="tabela_container_linha">{{ mb_strimwidth($inscricao->vaga->nome, 0, 20, "...") }}</td>
                                        <td id="tabela_container_linha">
                                            @if ($inscricao->status == "aprovado")
                                                Aprovado
                                            @else 
                                                <a target="_black" href="http://consulta.tesouro.fazenda.gov.br/gru_novosite/gru_simples.asp">
                                                    Gerar Boleto
                                                </a>
                                            @endif
                                        </td>
                                        <td id="tabela_container_linha">
                                            @if ($inscricao->status == "aprovado")
                                                Deferida
                                            @elseif($inscricao->status == "reprovado") 
                                                Indeferida
                                            @endif
                                        </td>
                                        <td id="tabela_container_linha">
                                            @if ($inscricao->arquivos != null)
                                                @if($inscricao->avaliacaoEfetivo != null)
                                                    {{$inscricao->avaliacaoEfetivo->getStatusAvaliacao()}}
                                                @else
                                                    Em análise
                                                @endif
                                            @else
                                                
                                                Não enviado
                                            @endif
                                        </td>
                                        <td id="tabela_container_linha" style="text-align: center;">
                                            <div class="btn-group">
                                                <a class="btn btn-primary" style="margin-left: 5px; border-radius: 4px;" href="{{ route('candidato.show', $inscricao->id) }}">
                                                    <img src="{{ asset('img/icon_visualizar.svg') }}" alt="Visualizar concurso" width="26px" >
                                                </a>
                                                @if ($inscricao->concurso->data_inicio_envio_doc <= now() && $inscricao->status == "aprovado")
                                                    <a class="btn btn-primary" style="margin-left: 5px; border-radius: 4px;" href="{{ route('envio.documentos.inscricao', $inscricao->id) }}">
                                                        <img src="{{ asset('img/icon_enviar.svg') }}" alt="Enviar documentos" width="26px" >
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($inscricoes->count() != 0 || $inscricoesEfetivo->count() != 0)
                    <div class="card-footer" style="background-color: #fff; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                        <div><h6 style="color: #909090; margin-bottom:1px">Legenda:</h6></div>
                        <div class="form-row">
                            <div class="btn-group" style="margin:5px">
                                <label style="margin-right: 10px; padding-left:13px; padding-right:13px; border-radius:6px; background-color:#007bff">
                                    <img class="card-img-left example-card-img-responsive" src="{{ asset('img/icon_visualizar.svg') }}" width="25px" style="margin-top: 10px "/>
                                </label>
                                <h6>Minha <br>inscrição</h6>
                            </div>
                            @if ($inscricao->concurso->data_inicio_envio_doc <= now() && $inscricao->status == "aprovado")
                                <div class="btn-group" style="margin:5px">
                                    <label style="margin-right: 10px; padding-left:13px; padding-right:13px; border-radius:6px; background-color:#007bff">
                                        <img class="card-img-left example-card-img-responsive" src="{{ asset('img/icon_enviar.svg') }}" width="25px" style="margin-top: 7px "/>
                                    </label>
                                    <h6>Prova de Títulos /</h6><br>
                                    <h6> Avaliação de Perfil</h6>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                @if($inscricoes->count() == 0 && $inscricoesEfetivo->count() == 0)
                    <div class="card-body">
                        <div class="form-row" style="text-align: center;">
                            <div class="col-md-12" style="margin-top: 5rem; margin-bottom: 10rem;">
                                <img src="{{asset('img/img_default_meus_concursos.svg')}}" alt="Imagem default" width="190px">
                                <h6 class="style_campo_titulo" style="margin-top: 20px;">Você não se candidatou para nenhum concurso</h6>
                            </div>
                        </div>
                    </div>
                @endif    
            </div>
        </div>
    </div>
</div>
@endsection